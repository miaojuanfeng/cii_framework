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
  | Author: miaojuanfeng@qq.com                                          |
  +----------------------------------------------------------------------+
*/

/* $Id$ */

#include "cii_input.h"

zend_class_entry *cii_input_ce;

zval* cii_get_http_globals(char *name TSRMLS_DC){
	// 这里要初始化一下，不然得不到$_POST
	if (PG(auto_globals_jit)) {
		zend_is_auto_global(name, sizeof(name)-1 TSRMLS_CC);
	}
	if( !strcmp(name, "_POST") ){
		return PG(http_globals)[TRACK_VARS_POST];
	}else if( !strcmp(name, "_GET") ){
		return PG(http_globals)[TRACK_VARS_GET];
	}else if( !strcmp(name, "_SERVER") ){
		return PG(http_globals)[TRACK_VARS_SERVER];
	}
	return NULL;
}

PHP_METHOD(cii_input, __construct)
{

    /*
	*	output log
	*/
	cii_write_log(3, "Input Class Initialized");
}

PHP_METHOD(cii_input, is_post)
{
	zval *post;

	post = cii_get_http_globals("_POST" TSRMLS_CC);

	RETURN_BOOL(Z_ARRVAL_P(post)->nNumOfElements);
}

PHP_METHOD(cii_input, is_get)
{
	zval *get;

	get = cii_get_http_globals("_GET" TSRMLS_CC);

	RETURN_BOOL(Z_ARRVAL_P(get)->nNumOfElements);
}

PHP_METHOD(cii_input, num_post)
{
	zval *post;

	post = cii_get_http_globals("_POST" TSRMLS_CC);

	RETURN_LONG(Z_ARRVAL_P(post)->nNumOfElements);
}

PHP_METHOD(cii_input, num_get)
{
	zval *get;

	get = cii_get_http_globals("_GET" TSRMLS_CC);

	RETURN_LONG(Z_ARRVAL_P(get)->nNumOfElements);
}

PHP_METHOD(cii_input, post)
{
	zval *post;
	char *key = NULL;
	uint key_len = 0;
	
	post = cii_get_http_globals("_POST" TSRMLS_CC);

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|s", &key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if( key && key_len ){
		zval **value;
		if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(post), key, key_len+1, (void**)&value) ){
			RETURN_ZVAL(*value, 1, 0);
		}else{
			RETURN_NULL();
		}
	}else{
		RETURN_ZVAL(post, 1, 0);
	}
}

PHP_METHOD(cii_input, get)
{
	zval *get;
	char *key = NULL;
	uint key_len = 0;
	char xss = 0;

	get = cii_get_http_globals("_GET" TSRMLS_CC);

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|sb", &key, &key_len, &xss) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if( key && key_len ){
		zval **value;
		if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(get), key, key_len+1, (void**)&value) ){
			RETURN_ZVAL(*value, 1, 0);
		}else{
			RETURN_NULL();
		}
	}else{
		RETURN_ZVAL(get, 1, 0);
	}
}

PHP_METHOD(cii_input, post_get)
{
	zval *post, *get;
	char *key = NULL;
	uint key_len = 0;
	zval **value;

	post = cii_get_http_globals("_POST" TSRMLS_CC);

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(post), key, key_len+1, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}else{
		get = cii_get_http_globals("_GET" TSRMLS_CC);

		if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(get), key, key_len+1, (void**)&value) ){
			RETURN_ZVAL(*value, 1, 0);
		}else{
			RETURN_NULL();
		}
	}
}

PHP_METHOD(cii_input, get_post)
{
	zval *post, *get;
	char *key = NULL;
	uint key_len = 0;
	zval **value;

	get = cii_get_http_globals("_GET" TSRMLS_CC);

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s", &key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(get), key, key_len+1, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}else{
		post = cii_get_http_globals("_POST" TSRMLS_CC);

		if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(post), key, key_len+1, (void**)&value) ){
			RETURN_ZVAL(*value, 1, 0);
		}else{
			RETURN_NULL();
		}
	}
}

PHP_METHOD(cii_input, server)
{
	zval *server;
	char *key = NULL;
	uint key_len = 0;

	server = cii_get_http_globals("_SERVER" TSRMLS_CC);

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|s", &key, &key_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if( key && key_len ){
		zval **value;
		if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), key, key_len+1, (void**)&value) ){
			RETURN_ZVAL(*value, 1, 0);
		}else{
			RETURN_NULL();
		}
	}else{
		RETURN_ZVAL(server, 1, 0);
	}
}

PHP_METHOD(cii_input, method)
{
	char *lower = NULL;
	zval *server;
	zval **value;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|b", &lower) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	server = cii_get_http_globals("_SERVER" TSRMLS_CC);

	if ( SUCCESS != zend_hash_find(Z_ARRVAL_P(server), "REQUEST_METHOD", 15, (void**)&value) ){
		RETURN_NULL();
	}

	if( lower ){
		char *p = Z_STRVAL_PP(value);
		while( *p != '\0' ){
			*p = tolower(*p);
			p++;
		}
		RETURN_ZVAL(*value, 1, 0);
	}
	RETURN_ZVAL(*value, 1, 0);
}

PHP_METHOD(cii_input, user_agent)
{
	zval *server;
	zval **value;

	server = cii_get_http_globals("_SERVER" TSRMLS_CC);

	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), "HTTP_USER_AGENT", 16, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}else{
		RETURN_NULL();
	}
}

PHP_METHOD(cii_input, ip_address)
{
	zval *server;
	zval **value;

	server = cii_get_http_globals("_SERVER" TSRMLS_CC);

	if ( SUCCESS == zend_hash_find(Z_ARRVAL_P(server), "REMOTE_ADDR", 12, (void**)&value) ){
		RETURN_ZVAL(*value, 1, 0);
	}else{
		RETURN_NULL();
	}
}

zend_function_entry cii_input_methods[] = {
	PHP_ME(cii_input, __construct,  NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_input, post,   NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, get, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, post_get,   NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, get_post,   NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, num_post, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, num_get, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, server, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, is_post, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, is_get, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, user_agent, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, method, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_input, ip_address, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_input)
{
	zend_class_entry ce;
	
	INIT_CLASS_ENTRY(ce, "CII_Input", cii_input_methods);
	cii_input_ce = zend_register_internal_class(&ce TSRMLS_CC);

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
 