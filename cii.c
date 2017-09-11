/*
  +----------------------------------------------------------------------+
  | PHP Version 5                                                        |
  +----------------------------------------------------------------------+
  | Copyright (c) 1997-2016 The PHP Group                                |
  +----------------------------------------------------------------------+
  | This source file is subject to version 3.01 of the PHP license,      |
  | that is bundled with this package in the file LICENSE, and is        |
  | available through the world-wide-web at the following url:           |
  | http://www.php.net/license/3_01.txt                                  |
  | If you did not receive a copy of the PHP license and are unable to   |
  | obtain it through the world-wide-web, please send a note to          |
  | license@php.net so we can mail you a copy immediately.               |
  +----------------------------------------------------------------------+
  | Author:                                                              |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_cii.h"

#include "../standard/php_string.h"

#include "cii_config.c"
#include "cii_uri.c"
#include "cii_router.c"
#include "cii_database.c"
#include "cii_benchmark.c"
#include "cii_output.c"
#include "cii_loader.c"
#include "cii_input.c"
#include "cii_session.c"
#include "cii_lang.c"
#include "cii_pagination.c"
#include "cii_log.c"


ZEND_DECLARE_MODULE_GLOBALS(cii)

/* True global resources - no need for thread safety here */
static int le_cii;

/* {{{ PHP_INI
 */
/* Remove comments and fill if you need to have entries in php.ini
PHP_INI_BEGIN()
    STD_PHP_INI_ENTRY("cii.global_value",      "42", PHP_INI_ALL, OnUpdateLong, global_value, zend_cii_globals, cii_globals)
    STD_PHP_INI_ENTRY("cii.global_string", "foobar", PHP_INI_ALL, OnUpdateString, global_string, zend_cii_globals, cii_globals)
PHP_INI_END()
*/
/* }}} */

/* Remove the following function when you have successfully modified config.m4
   so that your module can be compiled into PHP, it exists only for testing
   purposes. */

/* Every user-visible function in PHP should document itself in the source */
/* {{{ proto string confirm_cii_compiled(string arg)
   Return a string to confirm that the module is compiled in */
static char* cii_get_apppath(TSRMLS_D)
{
	char path[MAXPATHLEN];
	char *retstr = NULL;
	char *ret = NULL;

#if HAVE_GETCWD
	ret = VCWD_GETCWD(path, MAXPATHLEN);
#elif HAVE_GETWD
	ret = VCWD_GETWD(path);
#endif

	if (ret) {
		retstr = estrdup(path);
		return retstr;
	} else {
		return NULL;
	}
}

int cii_loader_import(char *path, int path_len, int include_once TSRMLS_DC) {
	/*zend_file_handle file_handle;
	zend_op_array 	*op_array;
	char realpath[MAXPATHLEN];

	if (!VCWD_REALPATH(path, realpath)) {
		php_error(E_ERROR, "Unable to load the requested file: %s", path);
	}

	file_handle.filename = path;
	file_handle.free_filename = 0;
	file_handle.type = ZEND_HANDLE_FILENAME;
	file_handle.opened_path = NULL;
	file_handle.handle.fp = NULL;

	op_array = zend_compile_file(&file_handle, ZEND_INCLUDE TSRMLS_CC);

	if (op_array && file_handle.handle.stream.handle) {
		int dummy = 1;

		if (!file_handle.opened_path) {
			file_handle.opened_path = path;
		}

		zend_hash_add(&EG(included_files), file_handle.opened_path, strlen(file_handle.opened_path)+1, (void *)&dummy, sizeof(int), NULL);
	}
	zend_destroy_file_handle(&file_handle TSRMLS_CC);

	if (op_array) {
		zval *result = NULL;

		CII_STORE_EG_ENVIRON();

		EG(return_value_ptr_ptr) = &result;
		EG(active_op_array) 	 = op_array;
		
#if ((PHP_MAJOR_VERSION == 5) && (PHP_MINOR_VERSION > 2)) || (PHP_MAJOR_VERSION > 5)
		if (!EG(active_symbol_table)) {
			zend_rebuild_symbol_table(TSRMLS_C);
		}
#endif
		zend_execute(op_array TSRMLS_CC);

		destroy_op_array(op_array TSRMLS_CC);
		efree(op_array);
		if (!EG(exception)) {
			if (EG(return_value_ptr_ptr) && *EG(return_value_ptr_ptr)) {
				zval_ptr_dtor(EG(return_value_ptr_ptr));
			}
		}
		CII_RESTORE_EG_ENVIRON();

	    return 1;
	}
	return 0;*/

	/* require_once/include_once */
	{
		zend_file_handle file_handle;
		char *resolved_path;
		zend_op_array *new_op_array=NULL;
		zend_bool failure_retval = 0;
		resolved_path = zend_resolve_path(path, path_len TSRMLS_CC);
		if (resolved_path) {
			failure_retval = zend_hash_exists(&EG(included_files), resolved_path, strlen(resolved_path)+1);
		} else {
			resolved_path = path;
		}
		if (failure_retval) {
			// do nothing, file already included
		} else if (SUCCESS == zend_stream_open(resolved_path, &file_handle TSRMLS_CC)) {
			if (!file_handle.opened_path) {
				file_handle.opened_path = estrdup(resolved_path);
			}
			/*
			*	include once
			*/
			if( !include_once ){
				if (zend_hash_add_empty_element(&EG(included_files), file_handle.opened_path, strlen(file_handle.opened_path)+1)==SUCCESS) {
					new_op_array = zend_compile_file(&file_handle, ZEND_INCLUDE TSRMLS_CC);
					zend_destroy_file_handle(&file_handle TSRMLS_CC);
				} else {
					zend_file_handle_dtor(&file_handle TSRMLS_CC);
					failure_retval=1;
				}
			/*
			*	include more
			*/
			}else{
				new_op_array = zend_compile_file(&file_handle, ZEND_INCLUDE TSRMLS_CC);
				zend_destroy_file_handle(&file_handle TSRMLS_CC);
			}
		} else {
			zend_message_dispatcher(ZMSG_FAILED_INCLUDE_FOPEN, path TSRMLS_CC);
		}
		if (resolved_path != path) {
			efree(resolved_path);
		}

		if (EXPECTED(new_op_array != NULL)) {
			zend_op_array *origin_op_array = EG(active_op_array);
			EG(active_op_array) = new_op_array;

			if (!EG(active_symbol_table)) {
				zend_rebuild_symbol_table(TSRMLS_C);
			}

			zend_execute(new_op_array TSRMLS_CC);

			EG(active_op_array) = origin_op_array;
			destroy_op_array(new_op_array TSRMLS_CC);
			efree(new_op_array);

			if( EG(return_value_ptr_ptr) && *EG(return_value_ptr_ptr) ){
				zval_ptr_dtor(EG(return_value_ptr_ptr));
			}
		}
	}
	/* */
	return 1;
}

static void cii_init_configs(TSRMLS_D){
	zval *controllers_dir;
	zval *models_dir;
	zval *views_dir;
	/*
	*	init controllers_path
	*/
	
	MAKE_STD_ZVAL(controllers_dir);
	ZVAL_STRINGL(controllers_dir, "controllers", 11, 1);
	zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), "controllers_path", 17, &controllers_dir, sizeof(zval *), NULL);
	/*
	*	init models_path
	*/
	
	MAKE_STD_ZVAL(models_dir);
	ZVAL_STRINGL(models_dir, "models", 6, 1);
	zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), "models_path", 12, &models_dir, sizeof(zval *), NULL);
	/*
	*	init views_path
	*/
	
	MAKE_STD_ZVAL(views_dir);
	ZVAL_STRINGL(views_dir, "views", 5, 1);
	zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), "views_path", 11, &views_dir, sizeof(zval *), NULL);
	//
	ALLOC_HASHTABLE(CII_G(view_symbol_table));
    zend_hash_init(CII_G(view_symbol_table), 0, NULL, ZVAL_PTR_DTOR, 0);
    //
    CII_G(view_symbol_level) = 0;
}

PHP_FUNCTION(cii_run)
{
	zval *config = NULL;

	HashPosition pos;
	char *key;
	uint key_len;
	ulong idx;
	zval **value;
	uint key_type;

	zval *marker;
	zval *total_execution_time_start;

	zval *rsegments;

	zval **run_controller;
	zval **run_method;

	zval *dir_path;
	zval **controllers_path;

	char *file;
	uint file_len;

	zend_class_entry **run_class_ce;

	zval **autoload;

	zval ***run_method_param = NULL;
	uint run_method_param_count = 0;

	zval *run_method_retval;
	/*
	*	get config array or path
	*/
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &config) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	/*
	*	init CII_G(CII_G(config_arr))
	*/
	MAKE_STD_ZVAL(CII_G(config_arr));
	array_init(CII_G(config_arr));
	cii_init_configs(TSRMLS_C);
	CII_G(app_path) = cii_get_apppath(TSRMLS_C);
	/*
	*	Do not use CONST_PERSISTENT, because after load cii, ci can not register constant BASEPATH.
	*/
	REGISTER_MAIN_STRING_CONSTANT("BASEPATH", cii_get_apppath(TSRMLS_C), CONST_CS);
	/*
	*	get the config item
	*/
	
	/*
	*	parameter config is a array
	*/
	if( Z_TYPE_P(config) == IS_ARRAY ){
		/*
		*	foreach config array that defined in parameter
		*/
		// for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(config), &pos);
		//     zend_hash_has_more_elements_ex(Z_ARRVAL_P(config), &pos) == SUCCESS;
		//     zend_hash_move_forward_ex(Z_ARRVAL_P(config), &pos)){
		// 	if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(config), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
		// 		continue;
		// 	}
		// 	if(zend_hash_get_current_data_ex(Z_ARRVAL_P(config), (void**)&value, &pos) == FAILURE){
		// 		continue;
		// 	}
		// 	/*
		// 	*	update CII_G(CII_G(config_arr))
		// 	*/
		// 	Z_ADDREF_P(*value);
		// 	zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), key, key_len, value, sizeof(zval *), NULL);
		// }
		php_error(E_ERROR, "Config by array have not complete yet.");
	/*
	*	parameter config is a file path
	*/
	}else if( Z_TYPE_P(config) == IS_STRING ){
		zval **cfg;
		char *file;
		uint file_len;

		HashTable *old_active_symbol_table;

		zval **db;

		zval **autoload;

		file_len = spprintf(&file, 0, "%s/%s", CII_G(app_path), Z_STRVAL_P(config));

		// CII_ALLOC_ACTIVE_SYMBOL_TABLE();
	    old_active_symbol_table = EG(active_symbol_table);
	    ALLOC_HASHTABLE(EG(active_symbol_table));
	    zend_hash_init(EG(active_symbol_table), 0, NULL, ZVAL_PTR_DTOR, 0);

		cii_loader_import(file, file_len, 0 TSRMLS_CC);

		if( zend_hash_find(EG(active_symbol_table), "config", 7, (void**)&cfg) == FAILURE || Z_TYPE_PP(cfg) != IS_ARRAY ){
			php_error(E_ERROR, "Your config file does not appear to be formatted correctly.");
		}
		/*
		*	foreach config array that defined in file
		*/
		for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(*cfg), &pos);
		    zend_hash_has_more_elements_ex(Z_ARRVAL_P(*cfg), &pos) == SUCCESS;
		    zend_hash_move_forward_ex(Z_ARRVAL_P(*cfg), &pos)){
			if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(*cfg), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
				continue;
			}
			if(zend_hash_get_current_data_ex(Z_ARRVAL_P(*cfg), (void**)&value, &pos) == FAILURE){
				continue;
			}
			/*
			*	update CII_G(config_arr)
			*/
			Z_ADDREF_P(*value);
			zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), key, key_len, value, sizeof(zval *), NULL);
		}
		/*
		*	database
		*/
		
		if( zend_hash_find(EG(active_symbol_table), "db", 3, (void**)&db) != FAILURE && Z_TYPE_PP(db) == IS_ARRAY ){
			// php_error(E_ERROR, "Your config file does not appear to be formatted correctly.");	
			/*
			*	foreach config array that defined in file
			*/
			for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(*db), &pos);
			    zend_hash_has_more_elements_ex(Z_ARRVAL_P(*db), &pos) == SUCCESS;
			    zend_hash_move_forward_ex(Z_ARRVAL_P(*db), &pos)){
				if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(*db), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
					continue;
				}
				if(zend_hash_get_current_data_ex(Z_ARRVAL_P(*db), (void**)&value, &pos) == FAILURE){
					continue;
				}
				/*
				*	update CII_G(config_arr)
				*/
				Z_ADDREF_P(*value);
				zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), key, key_len, value, sizeof(zval *), NULL);
			}
		}
		/*
		*	autoload
		*/
		
		if( zend_hash_find(EG(active_symbol_table), "autoload", 9, (void**)&autoload) != FAILURE && Z_TYPE_PP(autoload) == IS_ARRAY ){
			// php_error(E_ERROR, "Your config file does not appear to be formatted correctly.");	
			/*
			*	foreach autoload array that defined in file
			*/
			Z_ADDREF_P(*autoload);
			zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), "autoload", 9, autoload, sizeof(zval *), NULL);
		}

		CII_DESTROY_ACTIVE_SYMBOL_TABLE();

		efree(file);
	}else{
		php_error(E_ERROR, "Your config parameter does not appear to be formatted correctly.");
	}
	/*
	* load CII_Config object
	*/
	MAKE_STD_ZVAL(CII_G(config_obj));
	object_init_ex(CII_G(config_obj), cii_config_ce);
	if (zend_hash_exists(&cii_config_ce->function_table, "__construct", 12)) {
		zval *cii_config_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(config_obj), "__construct", &cii_config_retval, 0, NULL);
		zval_ptr_dtor(&cii_config_retval);
	}
	/*
	* load CII_URI object
	*/
	MAKE_STD_ZVAL(CII_G(uri_obj));
	object_init_ex(CII_G(uri_obj), cii_uri_ce);
	if (zend_hash_exists(&cii_uri_ce->function_table, "__construct", 12)) {
		zval *cii_uri_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(uri_obj), "__construct", &cii_uri_retval, 0, NULL);
		zval_ptr_dtor(&cii_uri_retval);
	}
	/*
	* load CII_Router object
	*/
	MAKE_STD_ZVAL(CII_G(router_obj));
	object_init_ex(CII_G(router_obj), cii_router_ce);
	if (zend_hash_exists(&cii_router_ce->function_table, "__construct", 12)) {
		zval *cii_router_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(router_obj), "__construct", &cii_router_retval, 0, NULL);
		zval_ptr_dtor(&cii_router_retval);
	}
	/*
	* load CII_Loader object
	*/
	MAKE_STD_ZVAL(CII_G(loader_obj));
	object_init_ex(CII_G(loader_obj), cii_loader_ce);
	if (zend_hash_exists(&cii_loader_ce->function_table, "__construct", 12)) {
		zval *cii_loader_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "__construct", &cii_loader_retval, 0, NULL);
		zval_ptr_dtor(&cii_loader_retval);
	}
	
	rsegments = zend_read_property(cii_uri_ce, CII_G(uri_obj), ZEND_STRL("rsegments"), 1 TSRMLS_CC);

	if( !zend_hash_index_exists(Z_ARRVAL_P(rsegments), 1) || zend_hash_index_find(Z_ARRVAL_P(rsegments), 1, (void**)&run_controller) == FAILURE ){
		php_error(E_ERROR, "Controller is empty");
	}
	
	if( !zend_hash_index_exists(Z_ARRVAL_P(rsegments), 2) || zend_hash_index_find(Z_ARRVAL_P(rsegments), 2, (void**)&run_method) == FAILURE ){
		php_error(E_ERROR, "Method is empty");
	}
	dir_path = zend_read_property(cii_uri_ce, CII_G(uri_obj), ZEND_STRL("dir_path"), 1 TSRMLS_CC);

	if( zend_hash_find(Z_ARRVAL_P(CII_G(config_arr)), "controllers_path", 17, (void**)&controllers_path) == FAILURE ||
		Z_TYPE_PP(controllers_path) != IS_STRING || Z_STRLEN_PP(controllers_path) == 0 ){
		php_error(E_ERROR, "Your config 'controllers_path' does not appear to be formatted correctly.");
	}

	if( dir_path && Z_TYPE_P(dir_path) == IS_STRING ){
		file_len = spprintf(&file, 0, "%s/%s/%s/%s.php", CII_G(app_path), Z_STRVAL_PP(controllers_path), Z_STRVAL_P(dir_path), Z_STRVAL_PP(run_controller));
	}else{
		file_len = spprintf(&file, 0, "%s/%s/%s.php", CII_G(app_path), Z_STRVAL_PP(controllers_path), Z_STRVAL_PP(run_controller));
	}

	if (!zend_hash_exists(&EG(included_files), file, file_len + 1)){
		CII_ALLOC_ACTIVE_SYMBOL_TABLE();
		cii_loader_import(file, file_len, 0 TSRMLS_CC);
		CII_DESTROY_ACTIVE_SYMBOL_TABLE();
	}
	efree(file);

	if( zend_hash_find(EG(class_table), Z_STRVAL_PP(run_controller), Z_STRLEN_PP(run_controller)+1, (void**)&run_class_ce) == FAILURE ){
		php_error(E_ERROR, "controller does not exist: %s\n", Z_STRVAL_PP(run_controller));
	}
	CII_G(controller_ce) = *run_class_ce;

	if ( !zend_hash_exists(&(*run_class_ce)->function_table, Z_STRVAL_PP(run_method), Z_STRLEN_PP(run_method)+1) ){
		php_error(E_ERROR, "method does not exist: %s\n", Z_STRVAL_PP(run_method));
	}

	MAKE_STD_ZVAL(CII_G(controller_obj));
	object_init_ex(CII_G(controller_obj), *run_class_ce);
	/*
	*	save for $this->db->...
	*/
	CII_G(instance_ce)  = *run_class_ce;
	CII_G(instance_obj) = CII_G(controller_obj);
	/*
	*	注入CII内核类对象实例到活动控制器成员变量中
	*/
	zend_update_property(*run_class_ce, CII_G(controller_obj), "config", 6, CII_G(config_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "uri", 3, CII_G(uri_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "router", 6, CII_G(router_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "load", 4, CII_G(loader_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "input", 5, CII_G(input_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "session", 7, CII_G(session_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "benchmark", 9, CII_G(benchmark_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "lang", 4, CII_G(lang_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "pagination", 10, CII_G(pagination_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "output", 6, CII_G(output_obj) TSRMLS_CC);
	// zend_update_property(*run_class_ce, CII_G(controller_obj), "log", 3, CII_G(log_obj) TSRMLS_CC);
	/*
	*	注入autoload对象
	*/
	if( zend_hash_find(Z_ARRVAL_P(CII_G(config_arr)), "autoload", 9, (void**)&autoload) == SUCCESS ){
		/*
		*	model
		*/
		zval **model;
		zval **helper;
		zval **library;
		if( zend_hash_find(Z_ARRVAL_PP(autoload), "model", 6, (void**)&model) == SUCCESS && Z_TYPE_PP(model) == IS_ARRAY ){
			/*
			*	foreach model array that defined in file
			*/
			for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(*model), &pos);
			    zend_hash_has_more_elements_ex(Z_ARRVAL_P(*model), &pos) == SUCCESS;
			    zend_hash_move_forward_ex(Z_ARRVAL_P(*model), &pos)){
				if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(*model), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
					continue;
				}
				if(zend_hash_get_current_data_ex(Z_ARRVAL_P(*model), (void**)&value, &pos) == FAILURE){
					continue;
				}
				/*
				*	update CII_G(config_arr)
				*/
				if( Z_TYPE_PP(value) == IS_STRING ){
					zval *loader_retval;
					zval **loader_param[1];
					loader_param[0] = value;
					//if ( zend_hash_exists(&cii_loader_ce->function_table, "model", 7) ){
					
					CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "model", &loader_retval, 1, loader_param);
					zval_ptr_dtor(&loader_retval);
					//}
				}else if( Z_TYPE_PP(value) == IS_ARRAY ){
					zval ***loader_param = NULL;
					uint loader_param_count = 0;
					if( Z_ARRVAL_PP(value)->nNumOfElements > 0 ){
						HashPosition loader_pos;
						char *loader_key;
						uint loader_key_len;
						ulong loader_idx;
						zval **loader_value;
						uint loader_key_type;
						uint loader_param_index = 0;

						zval *loader_retval;

						loader_param_count = Z_ARRVAL_PP(value)->nNumOfElements;
						loader_param = emalloc(loader_param_count * sizeof(zval*));
						
						for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_PP(value), &loader_pos);
						    zend_hash_has_more_elements_ex(Z_ARRVAL_PP(value), &loader_pos) == SUCCESS;
						    zend_hash_move_forward_ex(Z_ARRVAL_PP(value), &loader_pos)){
							if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_PP(value), &loader_key, &loader_key_len, &loader_idx, 0, &loader_pos)) == HASH_KEY_NON_EXISTENT){
								continue;
							}
							if(zend_hash_get_current_data_ex(Z_ARRVAL_PP(value), (void**)&loader_value, &loader_pos) == FAILURE){
								continue;
							}
							loader_param[loader_param_index++] = loader_value;
							// php_printf("%s", Z_STRVAL_PP(loader_value));
						}
						
						CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "model", &loader_retval, loader_param_count, loader_param);
						zval_ptr_dtor(&loader_retval);
						efree(loader_param);
					}
				}else{
					php_error(E_WARNING, "Autoload 'model' item should be String or Array\n");
				}
			}
		}
		/*
		*	helper
		*/
		
		if( zend_hash_find(Z_ARRVAL_PP(autoload), "helper", 7, (void**)&helper) == SUCCESS && Z_TYPE_PP(helper) == IS_ARRAY ){
			/*
			*	foreach helper array that defined in file
			*/
			for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(*helper), &pos);
			    zend_hash_has_more_elements_ex(Z_ARRVAL_P(*helper), &pos) == SUCCESS;
			    zend_hash_move_forward_ex(Z_ARRVAL_P(*helper), &pos)){
				if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(*helper), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
					continue;
				}
				if(zend_hash_get_current_data_ex(Z_ARRVAL_P(*helper), (void**)&value, &pos) == FAILURE){
					continue;
				}
				/*
				*	update CII_G(config_arr)
				*/
				if( Z_TYPE_PP(value) == IS_STRING ){
					zval *loader_retval;
					zval **loader_param[1];
					loader_param[0] = value;
					//if ( zend_hash_exists(&cii_loader_ce->function_table, "helper", 7) ){
					
					CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "helper", &loader_retval, 1, loader_param);
					zval_ptr_dtor(&loader_retval);
					//}
				}else{
					php_error(E_WARNING, "Autoload 'helper' item should be String\n");
				}
			}
		}
		/*
		*	library
		*/
		
		if( zend_hash_find(Z_ARRVAL_PP(autoload), "library", 8, (void**)&library) == SUCCESS && Z_TYPE_PP(library) == IS_ARRAY ){
			/*
			*	foreach library array that defined in file
			*/
			for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(*library), &pos);
			    zend_hash_has_more_elements_ex(Z_ARRVAL_P(*library), &pos) == SUCCESS;
			    zend_hash_move_forward_ex(Z_ARRVAL_P(*library), &pos)){
				if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(*library), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
					continue;
				}
				if(zend_hash_get_current_data_ex(Z_ARRVAL_P(*library), (void**)&value, &pos) == FAILURE){
					continue;
				}
				/*
				*	update CII_G(config_arr)
				*/
				if( Z_TYPE_PP(value) == IS_STRING ){
					zval *loader_retval;
					zval **loader_param[1];
					loader_param[0] = value;
					//if ( zend_hash_exists(&cii_loader_ce->function_table, "library", 7) ){
					
					CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "library", &loader_retval, 1, loader_param);
					zval_ptr_dtor(&loader_retval);
					//}
				}else if( Z_TYPE_PP(value) == IS_ARRAY ){
					zval ***loader_param = NULL;
					uint loader_param_count = 0;
					if( Z_ARRVAL_PP(value)->nNumOfElements > 0 ){
						HashPosition loader_pos;
						char *loader_key;
						uint loader_key_len;
						ulong loader_idx;
						zval **loader_value;
						uint loader_key_type;
						uint loader_param_index = 0;

						zval *loader_retval;

						loader_param_count = Z_ARRVAL_PP(value)->nNumOfElements;
						loader_param = emalloc(loader_param_count * sizeof(zval*));
						

						for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_PP(value), &loader_pos);
						    zend_hash_has_more_elements_ex(Z_ARRVAL_PP(value), &loader_pos) == SUCCESS;
						    zend_hash_move_forward_ex(Z_ARRVAL_PP(value), &loader_pos)){
							if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_PP(value), &loader_key, &loader_key_len, &loader_idx, 0, &loader_pos)) == HASH_KEY_NON_EXISTENT){
								continue;
							}
							if(zend_hash_get_current_data_ex(Z_ARRVAL_PP(value), (void**)&loader_value, &loader_pos) == FAILURE){
								continue;
							}
							loader_param[loader_param_index++] = loader_value;
						}
						
						CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "library", &loader_retval, loader_param_count, loader_param);
						zval_ptr_dtor(&loader_retval);
						efree(loader_param);
					}
				}else{
					php_error(E_WARNING, "Autoload 'library' item should be String or Array\n");
				}
			}
		}
	}
	/*
	*	调用活动控制器构造方法
	*	没有参数
	*/
	if ( zend_hash_exists(&(*run_class_ce)->function_table, "__construct", 12) ){
		zval *run_class_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(controller_obj), "__construct", &run_class_retval, 0, NULL);
		zval_ptr_dtor(&run_class_retval);
	}
	/*
	*	如果uri有带有参数，获取参数传入到method中
	*	默认参数为空
	*/
	/*
	*	参数从rsegments下标为3的元素开始
	*/
	if( Z_ARRVAL_P(rsegments)->nNumOfElements > 2 ){
		int i;
		run_method_param_count = Z_ARRVAL_P(rsegments)->nNumOfElements - 2;
		run_method_param = emalloc(run_method_param_count * sizeof(zval*));
		
		for(i=1;i<=run_method_param_count;i++){
			zval **param;
			if( !zend_hash_index_exists(Z_ARRVAL_P(rsegments), i+2) || zend_hash_index_find(Z_ARRVAL_P(rsegments), i+2, (void**)&param) == FAILURE ){
				php_error(E_ERROR, "Get method parameters failed.");
			}
			Z_ADDREF_PP(param);
			run_method_param[i-1] = param;
		}
	}
	/*
	*	调用活动控制器指定方法或默认方法，开始执行控制器
	*	并将参数传入
	*/
	CII_CALL_USER_METHOD_EX(&CII_G(controller_obj), Z_STRVAL_PP(run_method), &run_method_retval, run_method_param_count, run_method_param);
	zval_ptr_dtor(&run_method_retval);
	if( run_method_param ){
		efree(run_method_param);
	}

//  以下方法会随机产生Segment Fault，先不用
	// /*
	// *	替换时间戳
	// */
	// zval *output;
	// MAKE_STD_ZVAL(output);
	// php_output_get_contents(output TSRMLS_CC);
	// php_output_discard(TSRMLS_C);
	// /*
	// *  Send the final rendered output to the browser
	// */
	// char *output_new;
	// uint output_new_len;
	// char retval;
	// // zval *output = zend_read_property(cii_output_ce, CII_G(output_obj), "final_output", 12, 1 TSRMLS_CC);
	// retval = cii_display(Z_STRVAL_P(output), Z_STRLEN_P(output), &output_new, &output_new_len TSRMLS_CC);
	// PHPWRITE(output_new, output_new_len);
	// if( retval ){
	// 	efree(output_new);
	// }
	// zval_ptr_dtor(&output);
//  以上方法会随机产生Segment Fault，先不用

	/*
	*	释放内存，防止内存泄漏
	*/
	efree(CII_G(app_path));
	zval_ptr_dtor(&CII_G(config_arr));
	//
	zval_ptr_dtor(&CII_G(config_obj));
	zval_ptr_dtor(&CII_G(uri_obj));
	zval_ptr_dtor(&CII_G(router_obj));
	zval_ptr_dtor(&CII_G(loader_obj));
	//
 	zval_ptr_dtor(&CII_G(controller_obj));
	//
	zend_hash_destroy(CII_G(view_symbol_table));
 	FREE_HASHTABLE(CII_G(view_symbol_table));
 	//
	RETURN_TRUE;
}
/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/
PHP_FUNCTION(cii_base_url)
{
	char *request_uri = NULL;
	uint request_uri_len = 0;
	zval **base_url;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|s", &request_uri, &request_uri_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	
	if( zend_hash_find(Z_ARRVAL_P(CII_G(config_arr)), "base_url", 9, (void**)&base_url) == FAILURE ){
		// zval *server;
		// zval **server_name;
		// zval **server_port;
		// // 这里要初始化一下，不然得不到$_SERVER
		// if (PG(auto_globals_jit)) {
		// 	zend_is_auto_global("_SERVER", sizeof("_SERVER")-1);
		// }
		// server = PG(http_globals)[TRACK_VARS_SERVER];

		// if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), "SERVER_NAME", sizeof("SERVER_NAME"), (void**)&server_name) && Z_TYPE_PP(server_name) == IS_STRING ){
		// 	char *server_name_port;
		// 	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), "SERVER_PORT", sizeof("SERVER_PORT"), (void**)&server_port) && Z_TYPE_PP(server_port) == IS_STRING ){
		// 		spprintf(&server_name_port, 0, "http://%s:%s", Z_STRVAL_PP(server_name), Z_STRVAL_PP(server_port));
		// 	}else{
		// 		spprintf(&server_name_port, 0, "http://%s", Z_STRVAL_PP(server_name));
		// 	}
		// 	MAKE_STD_ZVAL(*base_url);
		// 	ZVAL_STRING(*base_url, server_name_port, 0);
		// }else{
		// 	MAKE_STD_ZVAL(*base_url);
		// 	ZVAL_EMPTY_STRING(*base_url);
		// }
		// zend_hash_update(Z_ARRVAL_P(CII_G(config_arr)), "base_url", 9, base_url, sizeof(zval *), NULL);
		php_error(E_ERROR, "get config item 'base_url' failed.");
	}
	if( request_uri && request_uri_len ){
		char *server_require_uri;
		spprintf(&server_require_uri, 0, "%s/%s", Z_STRVAL_PP(base_url), request_uri);
		RETURN_STRING(server_require_uri, 0);
	}else{
		RETURN_ZVAL(*base_url, 1, 0);
	}
}

PHP_FUNCTION(cii_redirect)
{
	char *request_uri = NULL;
	uint request_uri_len = 0;
	zval **header_param[1];

	char *hstr;
	uint hstr_len;

	zval *header;
	zval *header_retval;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|s", &request_uri, &request_uri_len) == FAILURE){
		WRONG_PARAM_COUNT;
	}

	if( strstr(request_uri, "http://") || strstr(request_uri, "https://") ){
		hstr_len = spprintf(&hstr, 0, "Location: %s", request_uri);
	}else{
		zval **base_url;
		if( zend_hash_find(Z_ARRVAL_P(CII_G(config_arr)), "base_url", 9, (void**)&base_url) == FAILURE ){
			php_error(E_ERROR, "get config item 'base_url' failed.");
		}
		if( request_uri ){
			hstr_len = spprintf(&hstr, 0, "Location: %s/%s", Z_STRVAL_PP(base_url), request_uri);
		}else{
			hstr_len = spprintf(&hstr, 0, "Location: %s", Z_STRVAL_PP(base_url));
		}
	}

	
	MAKE_STD_ZVAL(header);
	ZVAL_STRINGL(header, hstr, hstr_len, 0);

	header_param[0] = &header;

	
	CII_CALL_USER_FUNCTION_EX(EG(function_table), NULL, "header", &header_retval, 1, header_param);
	zval_ptr_dtor(&header_retval);

	zval_ptr_dtor(&header);
}

PHP_FUNCTION(cii_log_message)
{
	char *level;
	uint level_len;
	char *message;
	uint message_len;

	char retval;
	
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss" ,&level, &level_len, &message, &message_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	retval = cii_user_write_log(level, level_len, message, message_len TSRMLS_CC);
	if( return_value_used ){
		RETURN_BOOL(retval);
	}
}

ZEND_BEGIN_ARG_INFO_EX(cii_get_instance_arginfo, 0, 1, 0)
ZEND_END_ARG_INFO()
PHP_FUNCTION(cii_get_instance)
{
	RETURN_ZVAL(CII_G(controller_obj), 1, 0);
}

/* {{{ php_cii_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_cii_init_globals(zend_cii_globals *cii_globals)
{
	cii_globals->global_value = 0;
	cii_globals->global_string = NULL;
}
*/
/* }}} */
static void php_cii_globals_ctor(zend_cii_globals *cii_globals)
{
	// cii_globals->controller_ce = NULL;
	// cii_globals->CII_G(controller_obj) = NULL;
	// /*
	// *	init CII_G(CII_G(app_path))
	// */
	// cii_globals->CII_G(app_path) = cii_get_apppath(TSRMLS_C);
	// /*
	// *	init CII_G(config_obj)
	// */
	// MAKE_STD_ZVAL(cii_globals->config_arr);
	// array_init(cii_globals->config_arr);
	memset(cii_globals, 0, sizeof(zend_cii_globals));
}

// static void php_cii_globals_dtor(zend_cii_globals *cii_globals)
// {
// 	// 现在变成自动释放？
// 	// if( cii_globals->cii_CII_G(controller_obj) ) zval_ptr_dtor(&cii_globals->cii_CII_G(controller_obj));
// 	// if( cii_globals->CII_G(app_path) ) efree(cii_globals->CII_G(app_path));
// 	// if( cii_globals->config_arr ) zval_ptr_dtor(&cii_globals->config_arr);

// 	// efree(CII_G(app_path));
// 	// zval_ptr_dtor(&config_arr);
// 	// zval_ptr_dtor(&uri_obj);
// 	// zval_ptr_dtor(&CII_G(router_obj));
// 	// zval_ptr_dtor(&CII_G(loader_obj));
// 	// zval_ptr_dtor(&CII_G(output_obj));
// }
/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(cii)
{
	ZEND_INIT_MODULE_GLOBALS(cii, php_cii_globals_ctor, NULL);
	//
	ZEND_MINIT(cii_config)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_uri)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_router)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_database)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_loader)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_input)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_session)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_benchmark)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_lang)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_pagination)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_output)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_log)(INIT_FUNC_ARGS_PASSTHRU);
	//
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MSHUTDOWN_FUNCTION
 */
PHP_MSHUTDOWN_FUNCTION(cii)
{
	/* uncomment this line if you have INI entries
	UNREGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request start */
/* {{{ PHP_RINIT_FUNCTION
 */
PHP_RINIT_FUNCTION(cii)
{
	return SUCCESS;
}
/* }}} */

/* Remove if there's nothing to do at request end */
/* {{{ PHP_RSHUTDOWN_FUNCTION
 */
PHP_RSHUTDOWN_FUNCTION(cii)
{
	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION
 */
PHP_MINFO_FUNCTION(cii)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "cii support", "enabled");
	php_info_print_table_end();

	/* Remove comments if you have entries in php.ini
	DISPLAY_INI_ENTRIES();
	*/
}
/* }}} */

/* {{{ cii_functions[]
 *
 * Every user visible function must have an entry in cii_functions[].
 */
const zend_function_entry cii_functions[] = {
	PHP_FE(cii_run,	NULL)		/* For testing, remove later. */
	PHP_FE(cii_base_url,	NULL)
	PHP_FE(cii_redirect,	NULL)
	PHP_FE(cii_log_message,	NULL)
	PHP_FE(cii_get_instance,	cii_get_instance_arginfo)
	PHP_FE_END	/* Must be the last line in cii_functions[] */
};
/* }}} */

/* {{{ cii_module_entry
 */
zend_module_entry cii_module_entry = {
	STANDARD_MODULE_HEADER,
	"cii",
	cii_functions,
	PHP_MINIT(cii),
	PHP_MSHUTDOWN(cii),
	PHP_RINIT(cii),		/* Replace with NULL if there's nothing to do at request start */
	PHP_RSHUTDOWN(cii),	/* Replace with NULL if there's nothing to do at request end */
	PHP_MINFO(cii),
	PHP_CII_VERSION,
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_CII
ZEND_GET_MODULE(cii)
#endif

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
