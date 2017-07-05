#include "cii_database.h"

zend_class_entry *cii_database_ce;
zend_class_entry *cii_db_result_ce;

#define CII_CALL_USER_METHOD_EX(object_ptr, function_name, retval_ptr, param_count, params) \
    do{ \
        zval *func_name; \
        MAKE_STD_ZVAL(func_name); \
        ZVAL_STRING(func_name, function_name, 1); \
        if( call_user_function_ex(NULL, object_ptr, func_name, retval_ptr, param_count, params, 0, NULL TSRMLS_CC) == FAILURE ){ \
            php_error(E_ERROR, "Call method failed: %s", function_name); \
        } \
        zval_ptr_dtor(&func_name); \
    }while(0)

/* }}} */
/* The previous line is meant for vim and emacs, so it can correctly fold and 
   unfold functions in source code. See the corresponding marks just before 
   function definition, where the functions purpose is also documented. Please 
   follow this convention for the convenience of others editing your code.
*/

PHP_METHOD(CII_Database, __construct)
{
	zval *hostname;
	zval *username;
	zval *password;
	zval *database;
	zval **params[4];
	zval **params_charset[1];
	zval *charset;
	zend_class_entry **mysqli_ce;
	zval *db_obj;
	zval *func_name;
	zval *retval;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "zzzz", &hostname, &username, &password, &database) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if( Z_TYPE_P(hostname) != IS_STRING || Z_TYPE_P(username) != IS_STRING || Z_TYPE_P(password) != IS_STRING || Z_TYPE_P(database) != IS_STRING ){
		php_error(E_ERROR, "Your config item 'hostname' does not appear to be formatted correctly.");
	}

	zend_update_property(cii_database_ce, getThis(), "hostname", 8, hostname TSRMLS_CC);
	zend_update_property(cii_database_ce, getThis(), "username", 8, username TSRMLS_CC);
	zend_update_property(cii_database_ce, getThis(), "password", 8, password TSRMLS_CC);
	zend_update_property(cii_database_ce, getThis(), "database", 8, database TSRMLS_CC);

	params[0] = &hostname;
	params[1] = &username;
	params[2] = &password;
	params[3] = &database;

	if( zend_hash_find(EG(class_table), "mysqli", 7, (void**)&mysqli_ce) == FAILURE ){
		zend_error(E_ERROR, "mysqli class has not initialized yet");
	}

	MAKE_STD_ZVAL(db_obj);
	object_init_ex(db_obj, *mysqli_ce);
	
	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "connect", 1);
	if( call_user_function_ex(NULL, &db_obj, func_name, &retval, 4, params, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::connect function failed");
	}
	zval_ptr_dtor(&func_name);
	zval_ptr_dtor(&retval);

	MAKE_STD_ZVAL(charset);
	ZVAL_STRING(charset, "utf8", 1);

	params_charset[0] = &charset;

	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "set_charset", 1);
	if( call_user_function_ex(NULL, &db_obj, func_name, &retval, 1, params_charset, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::set_charset function failed");
	}
	zval_ptr_dtor(&func_name);
	zval_ptr_dtor(&retval);
	zval_ptr_dtor(&charset);
	
	zend_update_property(cii_database_ce, getThis(), "conn_id", 7, db_obj TSRMLS_CC);
	zval_ptr_dtor(&db_obj);
}


PHP_METHOD(CII_Database, query)
{
	zval *sql;
	zval *hostname;
	zval *username;
	zval *password;
	zval *database;
	zval **params[4];
	zval *db_obj;
	zval *func_name;
	zval *retval;
	zval **query[1];
	zval *result_obj;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &sql) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	db_obj = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("conn_id"), 1 TSRMLS_CC);

	query[0] = &sql;

	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "query", 1);
	if( call_user_function_ex(NULL, &db_obj, func_name, &retval, 1, query, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::query function failed");
	}
	zval_ptr_dtor(&func_name);
	/* update affected_rows */
	zend_class_entry **mysqli_result_ce;
	zval *result_affected_rows;
	if( zend_hash_find(EG(class_table), "mysqli_result", 14, (void**)&mysqli_result_ce) == FAILURE ){
		zend_error(E_ERROR, "mysqli class has not initialized yet");
	}
	result_affected_rows = zend_read_property(*mysqli_result_ce, db_obj, ZEND_STRL("affected_rows"), 1 TSRMLS_CC);
	zend_update_property(cii_database_ce, getThis(), "affected_rows", 13, result_affected_rows TSRMLS_CC);
	/* add object to CII_Database */
	zend_update_property(cii_database_ce, getThis(), "result_id", 9, retval TSRMLS_CC);
	/* call CII_DB_result __construct */
	MAKE_STD_ZVAL(result_obj);
	object_init_ex(result_obj, cii_db_result_ce);

	if ( zend_hash_exists(&cii_db_result_ce->function_table, "__construct", 12) ){
		zval *cii_db_result_retval;
		CII_CALL_USER_METHOD_EX(&result_obj, "__construct", &cii_db_result_retval, 0, NULL);
		zval_ptr_dtor(&cii_db_result_retval);
	}

	zend_update_property(cii_db_result_ce, result_obj, "conn_id", 7, db_obj TSRMLS_CC);
	zend_update_property(cii_db_result_ce, result_obj, "result_id", 9, retval TSRMLS_CC);
	zval_ptr_dtor(&retval);

	RETURN_ZVAL(result_obj, 1, 1);
}

PHP_METHOD(CII_Database, affected_rows)
{
	zval *affected_rows;

	affected_rows = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("affected_rows"), 1 TSRMLS_CC);

	RETURN_ZVAL(affected_rows, 1, 0);
}

/****************************************************************/
PHP_METHOD(CII_DB_result, __construct)
{
	zval *result_array;
	zval *row_array;

	MAKE_STD_ZVAL(result_array);
	array_init(result_array);
	zend_update_property(cii_db_result_ce, getThis(), "result_array", 12, result_array TSRMLS_CC);
	zval_ptr_dtor(&result_array);

	MAKE_STD_ZVAL(row_array);
	array_init(row_array);
	zend_update_property(cii_db_result_ce, getThis(), "row_array", 9, row_array TSRMLS_CC);
	zval_ptr_dtor(&row_array);
}

PHP_METHOD(CII_DB_result, result_array)
{
	zval *result_array;
	zval *func_name;
	zval *retval;
	zval **result_type[1];
	zval *mysql_assoc;

	result_array = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("result_array"), 1 TSRMLS_CC);

	if( !Z_ARRVAL_P(result_array)->nNumOfElements ){
		zval *result_id;
		zend_class_entry **mysqli_result_ce;
		zval *result_num_rows;
		result_id = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("result_id"), 1 TSRMLS_CC);
		
		if( Z_TYPE_P(result_id) != IS_BOOL ){
			MAKE_STD_ZVAL(mysql_assoc);
			ZVAL_LONG(mysql_assoc, 1);

			result_type[0] = &mysql_assoc;

			MAKE_STD_ZVAL(func_name);
			ZVAL_STRING(func_name, "fetch_all", 1);
			if( call_user_function_ex(NULL, &result_id, func_name, &retval, 1, result_type, 0, NULL TSRMLS_CC) == FAILURE ){
				php_error(E_ERROR, "Call Mysqli::result_array function failed");
			}
			zval_ptr_dtor(&func_name);
			zval_ptr_dtor(&mysql_assoc);

			zend_update_property(cii_db_result_ce, getThis(), "result_array", 12, retval TSRMLS_CC);
			RETURN_ZVAL(retval, 1, 1);
		}else{
			RETURN_ZVAL(result_array, 1, 0);
		}
	}
	RETURN_ZVAL(result_array, 1, 0);
}

PHP_METHOD(CII_DB_result, row_array)
{
	zval *row_array;
	zval **first_row;
	zval *func_name;
	zval *retval;
	zval **result_type[1];
	zval *mysql_assoc;

	row_array = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("row_array"), 1 TSRMLS_CC);

	if( !Z_ARRVAL_P(row_array)->nNumOfElements ){
		zval *result_id;
		zend_class_entry **mysqli_result_ce;
		zval *result_num_rows;
		result_id = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("result_id"), 1 TSRMLS_CC);
	
		if( Z_TYPE_P(result_id) != IS_BOOL ){
			MAKE_STD_ZVAL(mysql_assoc);
			ZVAL_LONG(mysql_assoc, 1);

			result_type[0] = &mysql_assoc;

			MAKE_STD_ZVAL(func_name);
			ZVAL_STRING(func_name, "fetch_all", 1);
			if( call_user_function_ex(NULL, &result_id, func_name, &retval, 1, result_type, 0, NULL TSRMLS_CC) == FAILURE ){
				php_error(E_ERROR, "Call Mysqli::result_array function failed");
			}
			zval_ptr_dtor(&func_name);
			zval_ptr_dtor(&mysql_assoc);

			zend_hash_index_find(Z_ARRVAL_P(retval), 0, (void**)&first_row);
			zend_update_property(cii_db_result_ce, getThis(), "row_array", 9, *first_row TSRMLS_CC);
			zval_ptr_dtor(&retval);
			row_array = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("row_array"), 1 TSRMLS_CC);
			RETURN_ZVAL(row_array, 1, 0);
		}else{
			RETURN_ZVAL(row_array, 1, 0);
		}
	}
	RETURN_ZVAL(row_array, 1, 0);
}

PHP_METHOD(CII_DB_result, num_rows)
{
	zval *num_rows;
	zval *func_name;
	zval *retval;

	num_rows = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("num_rows"), 1 TSRMLS_CC);

	if( Z_TYPE_P(num_rows) == IS_NULL ){
		zval *result_id;
		zend_class_entry **mysqli_result_ce;
		zval *result_num_rows;
		result_id = zend_read_property(cii_db_result_ce, getThis(), ZEND_STRL("result_id"), 1 TSRMLS_CC);
		
		if( Z_TYPE_P(result_id) != IS_BOOL ){
			if( zend_hash_find(EG(class_table), "mysqli_result", 14, (void**)&mysqli_result_ce) == FAILURE ){
				zend_error(E_ERROR, "mysqli class has not initialized yet");
			}
			result_num_rows = zend_read_property(*mysqli_result_ce, result_id, ZEND_STRL("num_rows"), 1 TSRMLS_CC);
			zend_update_property(cii_db_result_ce, getThis(), "num_rows", 8, result_num_rows TSRMLS_CC);
			RETURN_ZVAL(result_num_rows, 1, 0);
		}else{
			RETURN_LONG(0);
		}
	}
	RETURN_ZVAL(num_rows, 1, 0);
}
/* {{{ php_cii_database_init_globals
 */
/* Uncomment this function if you have INI entries
static void php_cii_database_init_globals(zend_cii_database_globals *cii_database_globals)
{
	cii_database_globals->global_value = 0;
	cii_database_globals->global_string = NULL;
}
*/
/* }}} */

/* {{{ PHP_MINIT_FUNCTION
 */
PHP_MINIT_FUNCTION(cii_database)
{
	zend_class_entry ce;
	zend_class_entry result_ce;

	zend_function_entry cii_database_methods[] = {
		PHP_ME(CII_Database, __construct,  NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
		PHP_ME(CII_Database, query,   NULL, ZEND_ACC_PUBLIC)
		PHP_ME(CII_Database, affected_rows, NULL, ZEND_ACC_PUBLIC)
		// PHP_ME(CII_Database, row_array, NULL, ZEND_ACC_PUBLIC)
		// PHP_ME(cii_router, fetch_method, NULL, ZEND_ACC_PUBLIC)
		PHP_FE_END
	};

	zend_function_entry cii_db_result_methods[] = {
		PHP_ME(CII_DB_result, __construct,  NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
		// PHP_ME(CII_Database, query,   NULL, ZEND_ACC_PUBLIC)
		// PHP_ME(CII_Database, result_array, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(CII_DB_result, result_array, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(CII_DB_result, row_array, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(CII_DB_result, num_rows, NULL, ZEND_ACC_PUBLIC)
		PHP_FE_END
	};
	
	INIT_CLASS_ENTRY(ce, "CII_Database", cii_database_methods);
	cii_database_ce = zend_register_internal_class(&ce TSRMLS_CC);

	INIT_CLASS_ENTRY(result_ce, "CII_DB_result", cii_db_result_methods);
	cii_db_result_ce = zend_register_internal_class(&result_ce TSRMLS_CC);

	/**
	 * CII_Database::db
	 *
	 * @var	resource
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("conn_id"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::result
	 *
	 * @var	resource
	 */
	zend_declare_property_bool(cii_database_ce, ZEND_STRL("result_id"), 0, ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::hostname
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("hostname"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::username
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("username"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::password
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("password"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::database
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("database"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::affected_rows
	 *
	 * @var	long
	 */
	zend_declare_property_long(cii_database_ce, ZEND_STRL("affected_rows"), 0, ZEND_ACC_PUBLIC TSRMLS_CC);
	///////////////
	///////////////
	///////////////
	///////////////
	///////////////
	///////////////
	/**
	 * CII_DB_result::conn_id
	 *
	 * @var	resource
	 */
	zend_declare_property_null(cii_db_result_ce, ZEND_STRL("conn_id"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_DB_result::result_id
	 *
	 * @var	resource
	 */
	zend_declare_property_bool(cii_db_result_ce, ZEND_STRL("result_id"), 0, ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_DB_result::result_array
	 *
	 * @var	int
	 */
	zend_declare_property_null(cii_db_result_ce, ZEND_STRL("result_array"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_DB_result::row_array
	 *
	 * @var	int
	 */
	zend_declare_property_null(cii_db_result_ce, ZEND_STRL("row_array"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_DB_result::num_rows
	 *
	 * @var	int
	 */
	zend_declare_property_null(cii_db_result_ce, ZEND_STRL("num_rows"), ZEND_ACC_PUBLIC TSRMLS_CC);

	/* If you have INI entries, uncomment these lines 
	REGISTER_INI_ENTRIES();
	*/
	return SUCCESS;
}