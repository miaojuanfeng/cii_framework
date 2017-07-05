#include "cii_loader.h"
#include "cii_database.c"

zend_class_entry *cii_loader_ce;

ZEND_BEGIN_ARG_INFO_EX(cii_loader___get_arginfo, 0, 0, 1)
	ZEND_ARG_INFO(0, key)
ZEND_END_ARG_INFO()

/*
*	function cii___get()
*/
ZEND_API void cii___get(INTERNAL_FUNCTION_PARAMETERS)
{
	char *key;
	uint key_len;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s" ,&key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *value = zend_read_property(cii_loader_ce, CII_G(loader_obj), key, key_len, 1 TSRMLS_CC);
	RETURN_ZVAL(value, 1, 0);
}
/*
*	function __get(string key)
*/
PHP_FUNCTION(cii_model___get)
{
	cii___get(INTERNAL_FUNCTION_PARAM_PASSTHRU);
}
/*  
*	cii_loader::__get()
*/
//PHP_ME_MAPPING( cii_loader, __get, NULL)
PHP_METHOD(cii_loader, __get)
{
	cii___get(INTERNAL_FUNCTION_PARAM_PASSTHRU);
}
/**
* Class constructor
*
* Runs the route mapping function.
*
* @return	void
*
* public function __construct()
*/
PHP_METHOD(cii_loader, __construct)
{

    // if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(post), "PATH_INFO", sizeof("PATH_INFO"), (void**)&query) && Z_TYPE_PP(query) == IS_STRING ){

    // }
}

/**
* View Loader
*
* Loads "view" files.
*
* @param	string	$view	View name
* @param	array	$vars	An associative array of data
*				to be extracted for use in the view
* @param	bool	$return	Whether to return the view output
*				or leave it to the Output class
* @return	object|string
*
* public function view($view, $vars = array(), $return = FALSE)
*/
PHP_METHOD(cii_loader, view){
	char *view;
	uint view_len;
	HashTable *data = NULL;
	char is_return = 0;
	zval **value;
	char *file;
	uint file_len;

	HashTable *old_active_symbol_table;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s|H!b" ,&view, &view_len, &data, &is_return) == FAILURE) {
		RETURN_ZVAL(getThis(), 1, 0);
	}

	if (!view_len) {
		RETURN_ZVAL(getThis(), 1, 0);
	}

	// if( !CII_G(apppath) ){
	// 	cii_get_apppath();
	// }
	zval **views_path;
	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "views_path", 11, (void**)&views_path) == FAILURE ||
		Z_TYPE_PP(views_path) != IS_STRING || Z_STRLEN_PP(views_path) == 0 ){
		php_error(E_ERROR, "Your config 'views_path' does not appear to be formatted correctly.");
	}
	file_len = spprintf(&file, 0, "%s%s%s%s%s%s", CII_G(app_path), "/", Z_STRVAL_PP(views_path), "/", view, ".php");

	if(zend_hash_exists(&EG(included_files), file, file_len + 1)){
		efree(file);
		RETURN_ZVAL(getThis(), 1, 0);
	}

	/*if (EG(active_symbol_table)) {
		zend_rebuild_symbol_table(TSRMLS_C);
	}*/
    old_active_symbol_table = EG(active_symbol_table);
    ALLOC_HASHTABLE(EG(active_symbol_table));
    zend_hash_init(EG(active_symbol_table), 0, NULL, ZVAL_PTR_DTOR, 0);

	if(data){
		char *key;
		uint key_len;
		ulong idx;
		/*
		* using HashPosition pos to make sure not modify data's hashtable internal pointer
		*/
		HashPosition pos;
		for(zend_hash_internal_pointer_reset_ex(data, &pos);
		    zend_hash_has_more_elements_ex(data, &pos) == SUCCESS;
		    zend_hash_move_forward_ex(data, &pos)){
			if(zend_hash_get_current_key_ex(data, &key, &key_len, &idx, 0, &pos) != HASH_KEY_IS_STRING){
				continue;
			}
			if(zend_hash_get_current_data_ex(data, (void**)&value, &pos) == FAILURE){
				continue;
			}
			CII_IF_ISREF_THEN_SEPARATE_ELSE_ADDREF(value);
			zend_hash_update(EG(active_symbol_table), key, key_len, value, sizeof(zval *), NULL);
		}
	}

	if(php_output_start_user(NULL, 0, PHP_OUTPUT_HANDLER_STDFLAGS TSRMLS_CC) == SUCCESS){
		if(is_return){	
			cii_loader_import(file, file_len, 0 TSRMLS_CC);
			php_output_get_contents(return_value TSRMLS_CC);
			php_output_discard(TSRMLS_C);
		}else{
			zval *output;
			cii_loader_import(file, file_len, 0 TSRMLS_CC);
			//
			MAKE_STD_ZVAL(output);
			php_output_get_contents(output TSRMLS_CC);
			// cii_append_output(cii_output_ce, output_obj, Z_STRVAL_P(output));
			zval_ptr_dtor(&output);
			// php_output_discard(TSRMLS_C);
		}
	}else{
		php_error(E_WARNING, "failed to create buffer");
	}

	efree(file);

	zend_hash_destroy(EG(active_symbol_table));
    FREE_HASHTABLE(EG(active_symbol_table));
    EG(active_symbol_table) = old_active_symbol_table;

	if(!is_return){
		RETURN_ZVAL(getThis(), 1, 0);
	}
}


/**
* Model Loader
*
* Loads and instantiates models.
*
* @param	string	$model		Model name
* @param	string	$name		An optional object name to assign to
* @return	object
*
* public function model($model, $name = '')
*/
PHP_METHOD(cii_loader, model){
	char *model;
	uint model_len;
	char *name;
	uint name_len;
	char *file;
	uint file_len;

	HashTable *old_active_symbol_table;

	zend_class_entry **ce;
	zval *new_object;
	char *name_lower;

	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss", &name, &name_len, &model, &model_len) == FAILURE){
		RETURN_NULL();
	}
	/*
	*	no model specify, just return this
	*/
	if( !model_len || !name_len ){
		RETURN_NULL();
	}
	/*
	*	model filepath
	*/
	file_len = spprintf(&file, 0, "%s", model);
	/*
	*	is already included
	*/
	if (zend_hash_exists(&EG(included_files), file, file_len + 1)){
		efree(file);
	}
	/*
	*	include file
	*/
    old_active_symbol_table = EG(active_symbol_table);
    ALLOC_HASHTABLE(EG(active_symbol_table));
    zend_hash_init(EG(active_symbol_table), 0, NULL, ZVAL_PTR_DTOR, 0);

	cii_loader_import(file, file_len, 0 TSRMLS_CC);
	
	zend_hash_destroy(EG(active_symbol_table));
    FREE_HASHTABLE(EG(active_symbol_table));
    EG(active_symbol_table) = old_active_symbol_table;

	efree(file);
	/*
	* add new object property to cii_controller class
	*/
	name_lower = zend_str_tolower_dup(name, name_len);
	if( zend_hash_find(CG(class_table), name_lower, name_len+1, (void**)&ce) == SUCCESS ){
		/*
		*	new ce object
		*/
		MAKE_STD_ZVAL(new_object);
		object_init_ex(new_object, *ce);
		/*
		*
		*/
		zend_update_property(*ce, new_object, "load", 4, CII_G(loader_obj) TSRMLS_CC);
		//
		/*
		*	add __get method
		*/
		if( !zend_hash_exists(&(*ce)->function_table, "__get", 6) ){
			zend_function *func_pDest;
			zend_function func;
			func.internal_function.type = ZEND_INTERNAL_FUNCTION;
			func.internal_function.function_name = "__get";
			func.internal_function.scope = *ce;
			func.internal_function.fn_flags = ZEND_ACC_PUBLIC;
			func.internal_function.num_args = 0;
			func.internal_function.required_num_args = 0;
			func.internal_function.arg_info = (zend_arg_info*)cii_loader___get_arginfo+1;
			func.internal_function.handler = ZEND_FN(cii_model___get);
			if( zend_hash_add(&(*ce)->function_table, "__get", 6, &func, sizeof(zend_function), (void**)&func_pDest) == FAILURE ){
				php_error(E_WARNING, "add __get method failed");
			}else{
				(*ce)->__get = func_pDest;
				(*ce)->__get->common.fn_flags &= ~ZEND_ACC_ALLOW_STATIC;
			}
		}
		/*
		*	call new object construct function
		*/
		if (zend_hash_exists(&(*ce)->function_table, "__construct", 12)) {
			zval *retval;
			CII_CALL_USER_METHOD_EX(&new_object, "__construct", &retval, 0, NULL);
			zval_ptr_dtor(&retval);
		}
		efree(name_lower);
		RETURN_ZVAL(new_object, 1, 1);
	}else{
		efree(name_lower);
		/*
		*	return this
		*/
		RETURN_NULL();
	}
}

/**
* Helper Loader
*
* @param	string|string[]	$helpers	Helper name(s)
* @return	object
*/
PHP_METHOD(cii_loader, helper){
	char *helper;
	uint helper_len;
	char *name;
	uint name_len;
	char *file;
	uint file_len;

	HashTable *old_active_symbol_table;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss", &name, &name_len, &helper, &helper_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if( !helper_len || !name_len ){
		RETURN_FALSE;
	}

    old_active_symbol_table = EG(active_symbol_table);
    ALLOC_HASHTABLE(EG(active_symbol_table));
    zend_hash_init(EG(active_symbol_table), 0, NULL, ZVAL_PTR_DTOR, 0);
		/*
		*	set helper file name
		*/
		file_len = spprintf(&file, 0, "%s", helper);
		/*
		*	check is loaded helper file name
		*/
		if( zend_hash_exists(&EG(included_files), file, file_len + 1) ){
			efree(file);
			CII_DESTROY_ACTIVE_SYMBOL_TABLE();
			RETURN_FALSE;
		}
		/*
		*	load helper file
		*/
		cii_loader_import(file, file_len, 0 TSRMLS_CC);
		/*
		*	free used memory
		*/
		efree(file);

	zend_hash_destroy(EG(active_symbol_table));
    FREE_HASHTABLE(EG(active_symbol_table));
    EG(active_symbol_table) = old_active_symbol_table;

	RETURN_TRUE;
}
/**
* Library Loader
*
* Loads and instantiates libraries.
* Designed to be called from application controllers.
*
* @param	string	$library	Library name
* @param	array	$params		Optional parameters to pass to the library class constructor
* @param	string	$object_name	An optional object name to assign to
* @return	object
*
* public function library($library, $params = NULL, $object_name = NULL)
*/
PHP_METHOD(cii_loader, library){
	char *library;
	uint library_len;
	char *name;
	uint name_len;
	char *file;
	uint file_len;

	HashTable *old_active_symbol_table;

	zend_class_entry **ce;
	zval *new_object;
	char *name_lower;

	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss", &name, &name_len, &library, &library_len) == FAILURE){
		RETURN_NULL();
	}
	/*
	*	no model specify, just return this
	*/
	if( !library_len || !name_len ){
		RETURN_NULL();
	}
	/*
	*	model filepath
	*/
	file_len = spprintf(&file, 0, "%s", library);
	/*
	*	is already included
	*/
	if (zend_hash_exists(&EG(included_files), file, file_len + 1)){
		efree(file);
	}
	/*
	*	include file
	*/
	old_active_symbol_table = EG(active_symbol_table);
    ALLOC_HASHTABLE(EG(active_symbol_table));
    zend_hash_init(EG(active_symbol_table), 0, NULL, ZVAL_PTR_DTOR, 0);

	cii_loader_import(file, file_len, 0 TSRMLS_CC);
	
	zend_hash_destroy(EG(active_symbol_table));
    FREE_HASHTABLE(EG(active_symbol_table));
    EG(active_symbol_table) = old_active_symbol_table;

	efree(file);
	/*
	* add new object property to cii_controller class
	*/
	name_lower = zend_str_tolower_dup(name, name_len);
	if( zend_hash_find(CG(class_table), name_lower, name_len+1, (void**)&ce) == SUCCESS ){
		/*
		*	new ce object
		*/
		MAKE_STD_ZVAL(new_object);
		object_init_ex(new_object, *ce);
		/*
		*	call new object construct function
		*/
		if (zend_hash_exists(&(*ce)->function_table, "__construct", 12)) {
			zval *retval;
			CII_CALL_USER_METHOD_EX(&new_object, "__construct", &retval, 0, NULL);
			zval_ptr_dtor(&retval);
		}
		efree(name_lower);
		RETURN_ZVAL(new_object, 1, 1);
	}else{
		efree(name_lower);
		/*
		*	return this
		*/
		RETURN_NULL();
	}
}

/**
* Library Loader
*
* public function database()
*/
PHP_METHOD(cii_loader, database)
{
	zval *database_obj;
	zval **hostname;
	zval **username;
	zval **password;
	zval **database;
	zval **params[4];

	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "hostname", 9, (void**)&hostname) == FAILURE ||
		Z_TYPE_PP(hostname) != IS_STRING || Z_STRLEN_PP(hostname) == 0 ){
		php_error(E_ERROR, "Your database config 'hostname' does not appear to be formatted correctly.");
	}
	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "username", 9, (void**)&username) == FAILURE ||
		Z_TYPE_PP(username) != IS_STRING || Z_STRLEN_PP(username) == 0 ){
		php_error(E_ERROR, "Your database config 'username' does not appear to be formatted correctly.");
	}
	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "password", 9, (void**)&password) == FAILURE ){
		php_error(E_ERROR, "Your database config 'password' does not appear to be formatted correctly.");
	}
	if( zend_hash_find(Z_ARRVAL_P(CII_G(configs)), "database", 9, (void**)&database) == FAILURE ||
		Z_TYPE_PP(database) != IS_STRING || Z_STRLEN_PP(database) == 0 ){
		php_error(E_ERROR, "Your database config 'database' does not appear to be formatted correctly.");
	}

	params[0] = hostname;
	params[1] = username;
	params[2] = password;
	params[3] = database;

	MAKE_STD_ZVAL(database_obj);
	object_init_ex(database_obj, cii_database_ce);
	if (zend_hash_exists(&cii_database_ce->function_table, "__construct", 12)) {
		zval *cii_output_retval;
		CII_CALL_USER_METHOD_EX(&database_obj, "__construct", &cii_output_retval, 4, params);
		zval_ptr_dtor(&cii_output_retval);
	}

	zend_update_property(cii_loader_ce, getThis(), "db", 2, database_obj TSRMLS_CC);
	
	RETURN_TRUE;
}

zend_function_entry cii_loader_methods[] = {
	PHP_ME(cii_loader, __construct, NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_loader, __get, cii_loader___get_arginfo, ZEND_ACC_PUBLIC)
	PHP_ME(cii_loader, view, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_loader, model, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_loader, helper, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_loader, library, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_loader, database, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_loader)
{
	ZEND_MINIT(cii_database)(INIT_FUNC_ARGS_PASSTHRU);
	/**
	 * Router Class
	 *
	 * Parses URIs and determines routing
	 */
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "CII_Loader", cii_loader_methods);
	cii_loader_ce = zend_register_internal_class(&ce TSRMLS_CC);
	/**
	 * Current class name
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_loader_ce, ZEND_STRL("class"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * Current method name
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_loader_ce, ZEND_STRL("method"), ZEND_ACC_PUBLIC TSRMLS_CC);

	return SUCCESS;
}