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

#include "cii_uri.c"
#include "cii_router.c"
#include "cii_loader.c"
#include "cii_output.c"
// #include "cii_database.c" // not load cii_database here, load it in cii_loader
#include "cii_input.c"

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
static char* cii_get_apppath()
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

CII_API int cii_loader_import(char *path, int len, int use_path TSRMLS_DC) {
	zend_file_handle file_handle;
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
	return 0;
}

static void cii_init_configs(){
	/*
	*	init controllers_path
	*/
	zval *controllers_dir;
	MAKE_STD_ZVAL(controllers_dir);
	ZVAL_STRINGL(controllers_dir, "controllers", 11, 1);
	zend_hash_update(Z_ARRVAL_P(CII_G(configs)), "controllers_path", 17, &controllers_dir, sizeof(zval *), NULL);
	/*
	*	init models_path
	*/
	zval *models_dir;
	MAKE_STD_ZVAL(models_dir);
	ZVAL_STRINGL(models_dir, "models", 6, 1);
	zend_hash_update(Z_ARRVAL_P(CII_G(configs)), "models_path", 12, &models_dir, sizeof(zval *), NULL);
	/*
	*	init views_path
	*/
	zval *views_dir;
	MAKE_STD_ZVAL(views_dir);
	ZVAL_STRINGL(views_dir, "views", 5, 1);
	zend_hash_update(Z_ARRVAL_P(CII_G(configs)), "views_path", 11, &views_dir, sizeof(zval *), NULL);
}

PHP_FUNCTION(cii_run)
{
	zval *config = NULL;
	/*
	*	get config array or path
	*/
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &config) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	/*
	*	init CII_G(CII_G(configs))
	*/
	MAKE_STD_ZVAL(CII_G(configs));
	array_init(CII_G(configs));
	cii_init_configs();
	CII_G(app_path) = cii_get_apppath();
	/*
	*	Do not use CONST_PERSISTENT, because after load cii, ci can not register constant BASEPATH.
	*/
	REGISTER_MAIN_STRING_CONSTANT("BASEPATH", cii_get_apppath(), CONST_CS);
	/*
	*	get the config item
	*/
	HashPosition pos;
	char *key;
	uint key_len;
	ulong idx;
	zval **value;
	uint key_type;
	/*
	*	parameter config is a array
	*/
	if( Z_TYPE_P(config) == IS_ARRAY ){
		/*
		*	foreach config array that defined in parameter
		*/
		for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(config), &pos);
		    zend_hash_has_more_elements_ex(Z_ARRVAL_P(config), &pos) == SUCCESS;
		    zend_hash_move_forward_ex(Z_ARRVAL_P(config), &pos)){
			if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(config), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
				continue;
			}
			if(zend_hash_get_current_data_ex(Z_ARRVAL_P(config), (void**)&value, &pos) == FAILURE){
				continue;
			}
			/*
			*	update CII_G(CII_G(configs))
			*/
			Z_ADDREF_P(*value);
			zend_hash_update(Z_ARRVAL_P(CII_G(configs)), key, key_len, value, sizeof(zval *), NULL);
		}
	/*
	*	parameter config is a file path
	*/
	}else if( Z_TYPE_P(config) == IS_STRING ){
		zval **cfg;
		char *file;
		uint file_len;
		file_len = spprintf(&file, 0, "%s/%s", CII_G(app_path), Z_STRVAL_P(config));

		CII_ALLOC_ACTIVE_SYMBOL_TABLE();

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
			*	update CII_G(configs)
			*/
			Z_ADDREF_P(*value);
			zend_hash_update(Z_ARRVAL_P(CII_G(configs)), key, key_len, value, sizeof(zval *), NULL);
		}

		// database
		zval **db;

		if( zend_hash_find(EG(active_symbol_table), "db", 3, (void**)&db) == FAILURE || Z_TYPE_PP(db) != IS_ARRAY ){
			// php_error(E_ERROR, "Your config file does not appear to be formatted correctly.");	
		}
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
			*	update CII_G(configs)
			*/
			Z_ADDREF_P(*value);
			zend_hash_update(Z_ARRVAL_P(CII_G(configs)), key, key_len, value, sizeof(zval *), NULL);
		}

		CII_DESTROY_ACTIVE_SYMBOL_TABLE();

		efree(file);
	}else{
		php_error(E_ERROR, "Your config parameter does not appear to be formatted correctly.");
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
	* load CII_Router object - 一调用__construct就会挂 - Bug
	*/
	MAKE_STD_ZVAL(CII_G(router_obj));
	object_init_ex(CII_G(router_obj), cii_router_ce);
	if (zend_hash_exists(&cii_router_ce->function_table, "__construct", 12)) {
		// zval *cii_router_retval;
		// CII_CALL_USER_METHOD_EX(&CII_G(router_obj), "__construct", &cii_router_retval, 0, NULL);
		// zval_ptr_dtor(&cii_router_retval);
	}
	/*
	* load CII_Loader object -- this object should be first one, or will get segment fault
	*/
	MAKE_STD_ZVAL(CII_G(loader_obj));
	object_init_ex(CII_G(loader_obj), cii_loader_ce);
	if (zend_hash_exists(&cii_loader_ce->function_table, "__construct", 12)) {
		zval *cii_loader_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(loader_obj), "__construct", &cii_loader_retval, 0, NULL);
		zval_ptr_dtor(&cii_loader_retval);
	}
	/*
	* load CII_Output object -- this object should be first one, or will get segment fault
	*/
	MAKE_STD_ZVAL(CII_G(output_obj));
	object_init_ex(CII_G(output_obj), cii_output_ce);
	if (zend_hash_exists(&cii_output_ce->function_table, "__construct", 12)) {
		zval *cii_output_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(output_obj), "__construct", &cii_output_retval, 0, NULL);
		zval_ptr_dtor(&cii_output_retval);
	}
	/*
	* load CII_Input object -- this object should be first one, or will get segment fault
	*/
	MAKE_STD_ZVAL(CII_G(input_obj));
	object_init_ex(CII_G(input_obj), cii_input_ce);
	if (zend_hash_exists(&cii_input_ce->function_table, "__construct", 12)) {
		zval *cii_input_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(input_obj), "__construct", &cii_input_retval, 0, NULL);
		zval_ptr_dtor(&cii_input_retval);
	}

	zval *rsegments = zend_read_property(cii_uri_ce, CII_G(uri_obj), ZEND_STRL("rsegments"), 1 TSRMLS_CC);

	zval **run_controller;
	if( !zend_hash_index_exists(Z_ARRVAL_P(rsegments), 1) || zend_hash_index_find(Z_ARRVAL_P(rsegments), 1, (void**)&run_controller) == FAILURE ){
		php_error(E_ERROR, "Controller is empty");
	}
	zval **run_method;
	if( !zend_hash_index_exists(Z_ARRVAL_P(rsegments), 2) || zend_hash_index_find(Z_ARRVAL_P(rsegments), 2, (void**)&run_method) == FAILURE ){
		php_error(E_ERROR, "Method is empty");
	}
	zval *dir_path = zend_read_property(cii_uri_ce, CII_G(uri_obj), ZEND_STRL("dir_path"), 1 TSRMLS_CC);

	zval **controllers_path;
	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "controllers_path", 17, (void**)&controllers_path) == FAILURE ||
		Z_TYPE_PP(controllers_path) != IS_STRING || Z_STRLEN_PP(controllers_path) == 0 ){
		php_error(E_ERROR, "Your config 'controllers_path' does not appear to be formatted correctly.");
	}
RETURN_ZVAL(CII_G(uri_obj), 1, 0);

	char *file;
	uint file_len;
	if( dir_path ){
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

	zend_class_entry **run_class_ce;
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
	*	add loader object to CII_Loader::load
	*/
	zend_update_property(cii_loader_ce, CII_G(loader_obj), "load", 4, CII_G(loader_obj) TSRMLS_CC);
	//
	zend_update_property(*run_class_ce, CII_G(controller_obj), "config", 6, CII_G(configs) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "uri", 3, CII_G(uri_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "router", 6, CII_G(router_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "load", 4, CII_G(loader_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "output", 6, CII_G(output_obj) TSRMLS_CC);
	zend_update_property(*run_class_ce, CII_G(controller_obj), "input", 5, CII_G(input_obj) TSRMLS_CC);
	//
	if ( zend_hash_exists(&(*run_class_ce)->function_table, "__construct", 12) ){
		zval *run_class_retval;
		CII_CALL_USER_METHOD_EX(&CII_G(controller_obj), "__construct", &run_class_retval, 0, NULL);
		zval_ptr_dtor(&run_class_retval);
	}

	zval *run_method_retval;
	CII_CALL_USER_METHOD_EX(&CII_G(controller_obj), Z_STRVAL_PP(run_method), &run_method_retval, 0, NULL);
	zval_ptr_dtor(&run_method_retval);

	efree(CII_G(app_path));
	zval_ptr_dtor(&CII_G(configs));
	zval_ptr_dtor(&CII_G(uri_obj));
	zval_ptr_dtor(&CII_G(router_obj));
	// zval_ptr_dtor(&CII_G(loader_obj));
	zval_ptr_dtor(&CII_G(output_obj));
	zval_ptr_dtor(&CII_G(input_obj));
	RETURN_ZVAL(CII_G(controller_obj), 0, 1);
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

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|s", &request_uri, &request_uri_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	zval **base_url;
	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "base_url", 9, (void**)&base_url) == FAILURE ){
		zval *server;
		zval **server_name;
		zval **server_port;
		// 这里要初始化一下，不然得不到$_SERVER
		if (PG(auto_globals_jit)) {
			zend_is_auto_global("_SERVER", sizeof("_SERVER")-1);
		}
		server = PG(http_globals)[TRACK_VARS_SERVER];

		if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), "SERVER_NAME", sizeof("SERVER_NAME"), (void**)&server_name) && Z_TYPE_PP(server_name) == IS_STRING ){
			char *server_name_port;
			if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), "SERVER_PORT", sizeof("SERVER_PORT"), (void**)&server_port) && Z_TYPE_PP(server_port) == IS_STRING ){
				spprintf(&server_name_port, 0, "http://%s:%s", Z_STRVAL_PP(server_name), Z_STRVAL_PP(server_port));
			}else{
				spprintf(&server_name_port, 0, "http://%s", Z_STRVAL_PP(server_name));
			}
			MAKE_STD_ZVAL(*base_url);
			ZVAL_STRING(*base_url, server_name_port, 0);
		}else{
			MAKE_STD_ZVAL(*base_url);
			ZVAL_EMPTY_STRING(*base_url);
		}
		zend_hash_update(Z_ARRVAL_P(CII_G(configs)), "base_url", 9, base_url, sizeof(zval *), NULL);
	}
	if( request_uri && request_uri_len ){
		char *server_require_uri;
		spprintf(&server_require_uri, 0, "%s/%s", Z_STRVAL_PP(base_url), request_uri);
		RETURN_STRING(server_require_uri, 0);
	}else{
		RETURN_ZVAL(*base_url, 1, 0);
	}
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
	// cii_globals->CII_G(app_path) = cii_get_apppath();
	// /*
	// *	init CII_G(config_obj)
	// */
	// MAKE_STD_ZVAL(cii_globals->configs);
	// array_init(cii_globals->configs);
}

static void php_cii_globals_dtor(zend_cii_globals *cii_globals)
{
	// 现在变成自动释放？
	// if( cii_globals->cii_CII_G(controller_obj) ) zval_ptr_dtor(&cii_globals->cii_CII_G(controller_obj));
	// if( cii_globals->CII_G(app_path) ) efree(cii_globals->CII_G(app_path));
	// if( cii_globals->configs ) zval_ptr_dtor(&cii_globals->configs);

	// efree(CII_G(app_path));
	// zval_ptr_dtor(&configs);
	// zval_ptr_dtor(&uri_obj);
	// zval_ptr_dtor(&CII_G(router_obj));
	// zval_ptr_dtor(&CII_G(loader_obj));
	// zval_ptr_dtor(&CII_G(output_obj));
}
/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(cii)
{
	ZEND_INIT_MODULE_GLOBALS(cii, php_cii_globals_ctor, php_cii_globals_dtor);
	//
	ZEND_MINIT(cii_uri)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_router)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_loader)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_output)(INIT_FUNC_ARGS_PASSTHRU);
	ZEND_MINIT(cii_input)(INIT_FUNC_ARGS_PASSTHRU);
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
