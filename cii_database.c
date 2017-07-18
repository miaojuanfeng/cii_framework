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

PHP_METHOD(cii_database, __construct)
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

	zval *select;

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

	MAKE_STD_ZVAL(select);
	ZVAL_STRING(select, "SELECT *", 1);
	zend_update_property(cii_database_ce, getThis(), "select", 6, select TSRMLS_CC);
	zval_ptr_dtor(&select);
}


PHP_METHOD(cii_database, query)
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
	//
	zend_update_property(cii_database_ce, getThis(), "last_query", 10, sql TSRMLS_CC);
	/* update affected_rows */
	zend_class_entry **mysqli_result_ce;
	zval *result_affected_rows;
	zval *result_insert_id;
	if( zend_hash_find(EG(class_table), "mysqli_result", 14, (void**)&mysqli_result_ce) == FAILURE ){
		zend_error(E_ERROR, "mysqli class has not initialized yet");
	}
	result_affected_rows = zend_read_property(*mysqli_result_ce, db_obj, ZEND_STRL("affected_rows"), 1 TSRMLS_CC);
	result_insert_id = zend_read_property(*mysqli_result_ce, db_obj, ZEND_STRL("insert_id"), 1 TSRMLS_CC);
	zend_update_property(cii_database_ce, getThis(), "affected_rows", 13, result_affected_rows TSRMLS_CC);
	zend_update_property(cii_database_ce, getThis(), "insert_id", 9, result_insert_id TSRMLS_CC);
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

PHP_METHOD(cii_database, affected_rows)
{
	zval *affected_rows;

	affected_rows = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("affected_rows"), 1 TSRMLS_CC);

	RETURN_ZVAL(affected_rows, 1, 0);
}

PHP_METHOD(cii_database, insert_id)
{
	zval *insert_id;

	insert_id = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("insert_id"), 1 TSRMLS_CC);

	RETURN_ZVAL(insert_id, 1, 0);
}

PHP_METHOD(cii_database, select)
{
	// zval *where;
	// char *key;
	// uint key_len;
	// char *value;
	// uint value_len;

	// if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss", &key, &key_len, &value, &value_len) == FAILURE) {
	// 	WRONG_PARAM_COUNT;
	// }

	// where = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("where"), 1 TSRMLS_CC);

	// if( Z_TYPE_P(where) == IS_STRING ){
	// 	char *query;
	// 	spprintf(&query, 0, " %s AND %s = '%s'", Z_STRVAL_P(where), key, value);
	// 	zval_dtor(where);
	// 	ZVAL_STRING(where, query, 0);
	// }else{
	// 	RETURN_FALSE;
	// }
	// RETURN_TRUE;
}

PHP_METHOD(cii_database, from)
{
	zval *from;
	char *table;
	uint table_len;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &table, &table_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	from = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("from"), 1 TSRMLS_CC);

	if( Z_TYPE_P(from) == IS_NULL ){
		char *query;
		spprintf(&query, 0, " FROM %s", table);
		MAKE_STD_ZVAL(from);
		ZVAL_STRING(from, query, 0);
		zend_update_property(cii_database_ce, getThis(), "from", 4, from TSRMLS_CC);
	}else if( Z_TYPE_P(from) == IS_STRING ){
		char *query;
		spprintf(&query, 0, " FROM %s", table);
		zval_dtor(from);
		ZVAL_STRING(from, query, 0);
	}else{
		RETURN_FALSE;
	}
	RETURN_TRUE;
}

PHP_METHOD(cii_database, where)
{
	zval *where;
	char *key;
	uint key_len;
	char *value;
	uint value_len;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "ss", &key, &key_len, &value, &value_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	where = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("where"), 1 TSRMLS_CC);

	if( Z_TYPE_P(where) == IS_NULL ){
		char *query;
		spprintf(&query, 0, " WHERE %s = '%s'", key, value);
		MAKE_STD_ZVAL(where);
		ZVAL_STRING(where, query, 0);
		zend_update_property(cii_database_ce, getThis(), "where", 5, where TSRMLS_CC);
	}else if( Z_TYPE_P(where) == IS_STRING ){
		char *query;
		spprintf(&query, 0, " %s AND %s = '%s'", Z_STRVAL_P(where), key, value);
		zval_dtor(where);
		ZVAL_STRING(where, query, 0);
	}else{
		RETURN_FALSE;
	}
	RETURN_TRUE;
}

PHP_METHOD(cii_database, order_by)
{
	zval *order_by;
	char *order;
	uint order_len;
	char *ascend = "ASC";
	uint ascend_len = 3;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s|s", &order, &order_len, &ascend, &ascend_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	order_by = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("order_by"), 1 TSRMLS_CC);

	if( Z_TYPE_P(order_by) == IS_NULL ){
		char *query;
		spprintf(&query, 0, " ORDER BY %s %s", order, ascend);
		MAKE_STD_ZVAL(order_by);
		ZVAL_STRING(order_by, query, 0);
		zend_update_property(cii_database_ce, getThis(), "order_by", 8, order_by TSRMLS_CC);
	}else if( Z_TYPE_P(order_by) == IS_STRING ){
		char *query;
		spprintf(&query, 0, " ORDER BY %s %s", order, ascend);
		zval_dtor(order_by);
		ZVAL_STRING(order_by, query, 0);
	}else{
		RETURN_FALSE;
	}
	RETURN_TRUE;
}

PHP_METHOD(cii_database, limit)
{
	zval *limit;
	char *lmt;
	uint lmt_len;
	char *offset = NULL;
	uint offset_len = 0;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s|s", &lmt, &lmt_len, &offset, &offset_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	limit = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("limit"), 1 TSRMLS_CC);

	if( Z_TYPE_P(limit) == IS_NULL ){
		char *query;
		if( offset && offset_len ){
			spprintf(&query, 0, " LIMIT %s , %s", lmt, offset);
		}else{
			spprintf(&query, 0, " LIMIT %s", lmt);
		}
		MAKE_STD_ZVAL(limit);
		ZVAL_STRING(limit, query, 0);
		zend_update_property(cii_database_ce, getThis(), "limit", 5, limit TSRMLS_CC);
	}else if( Z_TYPE_P(limit) == IS_STRING ){
		char *query;
		if( offset && offset_len ){
			spprintf(&query, 0, " LIMIT %s , %s", lmt, offset);
		}else{
			spprintf(&query, 0, " LIMIT %s", lmt);
		}
		zval_dtor(limit);
		ZVAL_STRING(limit, query, 0);
	}else{
		RETURN_FALSE;
	}
	RETURN_TRUE;
}

PHP_METHOD(cii_database, get)
{
	zval *select;
	zval *from;
	zval *where;
	zval *order_by;
	zval *limit;
	char *query;
	uint query_len;
	zval *last_query;
	
	select = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("select"), 1 TSRMLS_CC);
	from = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("from"), 1 TSRMLS_CC);
	where = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("where"), 1 TSRMLS_CC);
	order_by = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("order_by"), 1 TSRMLS_CC);
	limit = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("limit"), 1 TSRMLS_CC);

	if( Z_TYPE_P(select) == IS_STRING ){
		query_len = spprintf(&query, 0, "%s", Z_STRVAL_P(select));
	}
	if( Z_TYPE_P(from) == IS_STRING ){
		efree(query);
		query_len = spprintf(&query, 0, "%s%s", Z_STRVAL_P(select), Z_STRVAL_P(from));
	}
	if( Z_TYPE_P(where) == IS_STRING ){
		char *p = query;
		query_len = spprintf(&query, 0, "%s%s", query, Z_STRVAL_P(where));
		if(p){
			efree(p);
		}
	}
	if( Z_TYPE_P(order_by) == IS_STRING ){
		char *p = query;
		query_len = spprintf(&query, 0, "%s%s", query, Z_STRVAL_P(order_by));
		if(p){
			efree(p);
		}
	}
	if( Z_TYPE_P(limit) == IS_STRING ){
		char *p = query;
		query_len = spprintf(&query, 0, "%s%s", query, Z_STRVAL_P(limit));
		if(p){
			efree(p);
		}
	}
	//
	MAKE_STD_ZVAL(last_query);
	ZVAL_STRING(last_query, query, 1);
	zend_update_property(cii_database_ce, getThis(), "last_query", 10, last_query TSRMLS_CC);
	zval_ptr_dtor(&last_query);
	//
	zval *func_name;
	zval *retval;
	zval *query_query;
	zval **query_param[1];

	MAKE_STD_ZVAL(query_query);
	ZVAL_STRING(query_query, query, 1);

	query_param[0] = &query_query;

	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "query", 1);
	if( call_user_function_ex(NULL, &getThis(), func_name, &retval, 1, query_param, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::query function failed");
	}
	zval_ptr_dtor(&func_name);
	//
	RETURN_ZVAL(retval, 1, 1);
}

PHP_METHOD(cii_database, insert)
{
	zval *from;
	HashTable *values;
	char *query = NULL;
	uint query_len;
	zval *last_query;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "zH", &from, &values) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	char *key;
	uint key_len;
	ulong idx;
	zval **value;
	/*
	* using HashPosition pos to make sure not modify data's hashtable internal pointer
	*/
	HashPosition pos;
	char *query_keys = NULL;
	char *query_values = NULL;
	for(zend_hash_internal_pointer_reset_ex(values, &pos);
	    zend_hash_has_more_elements_ex(values, &pos) == SUCCESS;
	    zend_hash_move_forward_ex(values, &pos)){
		if(zend_hash_get_current_key_ex(values, &key, &key_len, &idx, 0, &pos) != HASH_KEY_IS_STRING){
			php_error(E_NOTICE, "Array key type should be String");
			continue;
		}
		if(zend_hash_get_current_data_ex(values, (void**)&value, &pos) == FAILURE){
			continue;
		}

		if( Z_TYPE_PP(value) != IS_STRING ){
			convert_to_string(*value);
		}

		if( query_keys ){
			char *p = query_keys;
			spprintf(&query_keys, 0, "%s, %s", query_keys, key);
			if(p){
				efree(p);
			}
		}else{
			spprintf(&query_keys, 0, "%s", key);
		}
		if( query_values ){
			char *p = query_values;
			spprintf(&query_values, 0, "%s, '%s'", query_values, Z_STRVAL_PP(value));
			if(p){
				efree(p);
			}
		}else{
			spprintf(&query_values, 0, "'%s'", Z_STRVAL_PP(value));
		}
	}
	char *p = query;
	query_len = spprintf(&query, 0, "INSERT INTO %s(%s) VALUES(%s)", Z_STRVAL_P(from), query_keys, query_values);
	if(p){
		efree(p);
	}
	//
	MAKE_STD_ZVAL(last_query);
	ZVAL_STRING(last_query, query, 1);
	zend_update_property(cii_database_ce, getThis(), "last_query", 10, last_query TSRMLS_CC);
	zval_ptr_dtor(&last_query);
	//
	zval *func_name;
	zval *retval;
	zval *query_query;
	zval **query_param[1];

	MAKE_STD_ZVAL(query_query);
	ZVAL_STRING(query_query, query, 1);

	query_param[0] = &query_query;

	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "query", 1);
	if( call_user_function_ex(NULL, &getThis(), func_name, &retval, 1, query_param, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::query function failed");
	}
	zval_ptr_dtor(&func_name);
	//
	RETURN_ZVAL(retval, 1, 1);
}

PHP_METHOD(cii_database, update)
{
	zval *from;
	zval *where;
	HashTable *set;
	char *query = NULL;
	uint query_len;
	zval *last_query;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "zH", &from, &set) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	where = zend_read_property(cii_database_ce, getThis(), ZEND_STRL("where"), 1 TSRMLS_CC);

	char *key;
	uint key_len;
	ulong idx;
	zval **value;
	/*
	* using HashPosition pos to make sure not modify data's hashtable internal pointer
	*/
	HashPosition pos;
	for(zend_hash_internal_pointer_reset_ex(set, &pos);
	    zend_hash_has_more_elements_ex(set, &pos) == SUCCESS;
	    zend_hash_move_forward_ex(set, &pos)){
		if(zend_hash_get_current_key_ex(set, &key, &key_len, &idx, 0, &pos) != HASH_KEY_IS_STRING){
			php_error(E_NOTICE, "Array key type should be String");
			continue;
		}
		if(zend_hash_get_current_data_ex(set, (void**)&value, &pos) == FAILURE){
			continue;
		}

		if( Z_TYPE_PP(value) != IS_STRING ){
			convert_to_string(*value);
		}
		
		if( query ){
			char *p = query;
			query_len = spprintf(&query, 0, "%s, %s = '%s'", query, key, Z_STRVAL_PP(value));
			if(p){
				efree(p);
			}
		}else{
			query_len = spprintf(&query, 0, "UPDATE %s SET %s = '%s'", Z_STRVAL_P(from), key, Z_STRVAL_PP(value));
		}
	}
	if( Z_TYPE_P(where) == IS_STRING ){
		char *p = query;
		query_len = spprintf(&query, 0, "%s%s", query, Z_STRVAL_P(where));
		if(p){
			efree(p);
		}
	}
	//
	MAKE_STD_ZVAL(last_query);
	ZVAL_STRING(last_query, query, 1);
	zend_update_property(cii_database_ce, getThis(), "last_query", 10, last_query TSRMLS_CC);
	zval_ptr_dtor(&last_query);
	//
	zval *func_name;
	zval *retval;
	zval *query_query;
	zval **query_param[1];

	MAKE_STD_ZVAL(query_query);
	ZVAL_STRING(query_query, query, 1);

	query_param[0] = &query_query;

	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "query", 1);
	if( call_user_function_ex(NULL, &getThis(), func_name, &retval, 1, query_param, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::query function failed");
	}
	zval_ptr_dtor(&func_name);
	//
	RETURN_ZVAL(retval, 1, 1);
}

PHP_METHOD(cii_database, delete)
{
	zval *from;
	HashTable *where;
	char *query = NULL;
	uint query_len;
	zval *last_query;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "zH", &from, &where) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	char *key;
	uint key_len;
	ulong idx;
	zval **value;
	/*
	* using HashPosition pos to make sure not modify data's hashtable internal pointer
	*/
	HashPosition pos;
	for(zend_hash_internal_pointer_reset_ex(where, &pos);
	    zend_hash_has_more_elements_ex(where, &pos) == SUCCESS;
	    zend_hash_move_forward_ex(where, &pos)){
		if(zend_hash_get_current_key_ex(where, &key, &key_len, &idx, 0, &pos) != HASH_KEY_IS_STRING){
			php_error(E_NOTICE, "Array key type should be String");
			continue;
		}
		if(zend_hash_get_current_data_ex(where, (void**)&value, &pos) == FAILURE){
			continue;
		}

		if( Z_TYPE_PP(value) != IS_STRING ){
			convert_to_string(*value);
		}
		
		if( query ){
			char *p = query;
			query_len = spprintf(&query, 0, "%s AND %s = '%s'", query, key, Z_STRVAL_PP(value));
			if(p){
				efree(p);
			}
		}else{
			query_len = spprintf(&query, 0, "WHERE %s = '%s'", key, Z_STRVAL_PP(value));
		}
	}
	char *p = query;
	if( query ){
		query_len = spprintf(&query, 0, "DELETE FROM %s %s", Z_STRVAL_P(from), query);
	}else{
		query_len = spprintf(&query, 0, "DELETE FROM %s", Z_STRVAL_P(from));
	}
	if(p){
		efree(p);
	}
	//
	MAKE_STD_ZVAL(last_query);
	ZVAL_STRING(last_query, query, 1);
	zend_update_property(cii_database_ce, getThis(), "last_query", 10, last_query TSRMLS_CC);
	zval_ptr_dtor(&last_query);
	//
	zval *func_name;
	zval *retval;
	zval *query_query;
	zval **query_param[1];

	MAKE_STD_ZVAL(query_query);
	ZVAL_STRING(query_query, query, 1);

	query_param[0] = &query_query;

	MAKE_STD_ZVAL(func_name);
	ZVAL_STRING(func_name, "query", 1);
	if( call_user_function_ex(NULL, &getThis(), func_name, &retval, 1, query_param, 0, NULL TSRMLS_CC) == FAILURE ){
		php_error(E_ERROR, "Call CII_Database::query function failed");
	}
	zval_ptr_dtor(&func_name);
	//
	RETURN_ZVAL(retval, 1, 1);
}

PHP_METHOD(cii_database, last_query)
{
	RETURN_ZVAL(zend_read_property(cii_database_ce, getThis(), ZEND_STRL("last_query"), 1 TSRMLS_CC), 1, 0);
}
/****************************************************************/
PHP_METHOD(cii_db_result, __construct)
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

PHP_METHOD(cii_db_result, result)
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
			//
			zval *retval_copy;
			ALLOC_ZVAL(retval_copy);
			INIT_PZVAL_COPY(retval_copy, retval);
			zval_copy_ctor(retval_copy);
			//
			zend_class_entry **std_class_ce;
			if( Z_TYPE_P(retval_copy) == IS_ARRAY && zend_hash_find(EG(class_table), "stdclass", 9, (void**)&std_class_ce) != FAILURE ){
				HashPosition pos;
				char *key;
				uint key_len;
				ulong idx;
				zval **value;
				uint key_type;
				//
				for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(retval_copy), &pos);
				    zend_hash_has_more_elements_ex(Z_ARRVAL_P(retval_copy), &pos) == SUCCESS;
				    zend_hash_move_forward_ex(Z_ARRVAL_P(retval_copy), &pos)){
					// if( (key_type = zend_hash_get_current_key_ex(Z_ARRVAL_P(retval_copy), &key, &key_len, &idx, 0, &pos)) == HASH_KEY_NON_EXISTENT){
					// 	continue;
					// }
					if(zend_hash_get_current_data_ex(Z_ARRVAL_P(retval_copy), (void**)&value, &pos) == FAILURE){
						continue;
					}
					// 要分离一份，不然result_array()函数返回的也是对象
					convert_to_object(*value);
					/*
					*	update CII_G(CII_G(configs))
					*/
					//RETURN_ZVAL(retval_copy, 1, 1);
				}
			}
			//
			RETURN_ZVAL(retval, 1, 1);
		}else{
			RETURN_ZVAL(result_array, 1, 0);
		}
	}
	RETURN_ZVAL(result_array, 1, 0);
}

PHP_METHOD(cii_db_result, result_array)
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
			ZVAL_LONG(mysql_assoc, 2);

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

PHP_METHOD(cii_db_result, row_array)
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

PHP_METHOD(cii_db_result, num_rows)
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

PHP_MINIT_FUNCTION(cii_database)
{
	zend_class_entry ce;
	zend_class_entry result_ce;

	zend_function_entry cii_database_methods[] = {
		PHP_ME(cii_database, __construct,  NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
		PHP_ME(cii_database, query,   NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, affected_rows, NULL, ZEND_ACC_PUBLIC)
		//
		PHP_ME(cii_database, select, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, from, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, where, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, order_by, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, limit, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, get, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, insert, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, update, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, delete, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, last_query, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_database, insert_id, NULL, ZEND_ACC_PUBLIC)
		PHP_FE_END
	};

	zend_function_entry cii_db_result_methods[] = {
		PHP_ME(cii_db_result, __construct,  NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
		PHP_ME(cii_db_result, result, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_db_result, result_array, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_db_result, row_array, NULL, ZEND_ACC_PUBLIC)
		PHP_ME(cii_db_result, num_rows, NULL, ZEND_ACC_PUBLIC)
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
	/**
	 * CII_Database::insert_id
	 *
	 * @var	long
	 */
	zend_declare_property_long(cii_database_ce, ZEND_STRL("insert_id"), 0, ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Database::select
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("select"), ZEND_ACC_PROTECTED TSRMLS_CC);
	/**
	 * CII_Database::from
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("from"), ZEND_ACC_PROTECTED TSRMLS_CC);
	/**
	 * CII_Database::where
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("where"), ZEND_ACC_PROTECTED TSRMLS_CC);
	/**
	 * CII_Database::order_by
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("order_by"), ZEND_ACC_PROTECTED TSRMLS_CC);
	/**
	 * CII_Database::limit
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("limit"), ZEND_ACC_PROTECTED TSRMLS_CC);
	/**
	 * CII_Database::last_query
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_database_ce, ZEND_STRL("last_query"), ZEND_ACC_PROTECTED TSRMLS_CC);
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
