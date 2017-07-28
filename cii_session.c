#include "cii_session.h"

zend_class_entry *cii_session_ce;

ZEND_BEGIN_ARG_INFO_EX(cii_session___get_arginfo, 0, 0, 1)
	ZEND_ARG_INFO(0, key)
ZEND_END_ARG_INFO()

ZEND_BEGIN_ARG_INFO_EX(cii_session___set_arginfo, 0, 0, 1)
	ZEND_ARG_INFO(0, key)
	ZEND_ARG_INFO(0, key)
ZEND_END_ARG_INFO()

/**
*	Class constructor
*
*	@return	void
*
*	public function __construct()
*/
PHP_METHOD(cii_session, __construct)
{
	char free_session = 0;
	/*
	*	call session_start() to init session
	*/
	if (zend_hash_exists(EG(function_table), "session_start", 14)) {
		zval *cii_session_retval;
		CII_CALL_USER_FUNCTION_EX(EG(function_table), NULL, "session_start", &cii_session_retval, 0, NULL);
		zval_ptr_dtor(&cii_session_retval);
	}
	/*
	*	fetch session
	*/
	zval **session;
	zval *init_session;
	if( zend_hash_find(&EG(symbol_table), "_SESSION", 9, (void**)&session) == FAILURE ){
		MAKE_STD_ZVAL(init_session);
		array_init(init_session);
		free_session = 1;
	}else{
		init_session = *session;
	}
	/*
	*	update session property
	*/
	Z_UNSET_ISREF_P(init_session);
	zend_update_property(cii_session_ce, getThis(), ZEND_STRL("session"), init_session TSRMLS_CC);
	Z_SET_ISREF_P(init_session);

	if(free_session){
		zval_ptr_dtor(&init_session);
	}
}

/*  
*	cii_session::__get()
*/
PHP_METHOD(cii_session, __get)
{
	char *key;
	uint key_len;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s" ,&key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	zval **value;
	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(session), key, key_len+1, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}
	// php_error(E_NOTICE, "Undefined index: %s", key);
}

/*  
*	cii_session::__set()
*/
PHP_METHOD(cii_session, __set)
{
	char *key;
	uint key_len;
	zval *value;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sz" ,&key, &key_len, &value) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	Z_ADDREF_P(value);
	zend_hash_update(Z_ARRVAL_P(session), key, key_len+1, &value, sizeof(zval *), NULL);
}

/*  
*	cii_session::tempdata() - 还未实现这个方法
*/
PHP_METHOD(cii_session, set_tempdata)
{
	char *key;
	uint key_len;
	zval *value;
	zval *t; // not used
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sz|z" ,&key, &key_len, &value, &t) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	Z_ADDREF_P(value);
	zend_hash_update(Z_ARRVAL_P(session), key, key_len+1, &value, sizeof(zval *), NULL);
}

/*  
*	cii_session::tempdata() - 还未实现这个方法
*/
PHP_METHOD(cii_session, tempdata)
{
	char *key;
	uint key_len;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s" ,&key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	zval **value;
	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(session), key, key_len+1, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}
	// php_error(E_NOTICE, "Undefined index: %s", key);
}

/**
*	Class constructor
*
*	@return	void
*
*	public function set_userdata()
*/
PHP_METHOD(cii_session, set_userdata)
{
	char *key;
	uint key_len;
	zval *value;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "sz" ,&key, &key_len, &value) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	Z_ADDREF_P(value);
	zend_hash_update(Z_ARRVAL_P(session), key, key_len+1, &value, sizeof(zval *), NULL);
}

/*  
*	cii_session::userdata()
*/
PHP_METHOD(cii_session, userdata)
{
	char *key;
	uint key_len;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s" ,&key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	zval **value;
	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(session), key, key_len+1, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}
	// php_error(E_NOTICE, "Undefined index: %s", key);
}

/**
*	Class constructor
*
*	@return	void
*
*	public function unset_userdata()
*/
PHP_METHOD(cii_session, unset_userdata)
{
	char *key;
	uint key_len;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s" ,&key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	/*
	*	fetch session
	*/
	zval *session = zend_read_property(cii_session_ce, getThis(), ZEND_STRL("session"), 1 TSRMLS_CC);
	//
	RETURN_BOOL(!zend_hash_del(Z_ARRVAL_P(session), key, key_len+1));
}

zend_function_entry cii_session_methods[] = {
	PHP_ME(cii_session, __construct, NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_session, __get, cii_session___get_arginfo, ZEND_ACC_PUBLIC)
	PHP_ME(cii_session, __set, cii_session___set_arginfo, ZEND_ACC_PUBLIC)
	PHP_ME(cii_session, set_tempdata, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_session, tempdata, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_session, set_userdata, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_session, userdata, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_session, unset_userdata, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_session)
{
	/**
	 * session Class
	 *
	 * Parses sessions and determines routing
	 */
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "CII_Session", cii_session_methods);
	cii_session_ce = zend_register_internal_class(&ce TSRMLS_CC);
	/**
	 * Current session string
	 *
	 * @var	string
	 */
	//zend_declare_property_stringl(cii_session_ce, ZEND_STRL("session"), "", 0, ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * Session Array
	 *
	 * Default is a empty array
	 *
	 * @var	array
	 */
	zend_declare_property_null(cii_session_ce, ZEND_STRL("session"), ZEND_ACC_PUBLIC TSRMLS_CC);

	return SUCCESS;
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
