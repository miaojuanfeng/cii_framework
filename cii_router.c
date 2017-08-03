#include "cii_router.h"

zend_class_entry *cii_router_ce;

/**
* Class constructor
*
* Runs the route mapping function.
*
* @return	void
*
* public function __construct()
*/
PHP_METHOD(cii_router, __construct)
{
	/*
	*	get cii_uri::rsegments
	*/
	zval *rsegments = zend_read_property(cii_uri_ce, CII_G(uri_obj), ZEND_STRL("rsegments"), 1 TSRMLS_CC);
	/*
	*	update cii_router::class and update cii_router::method
	*/
	zval **class, **method;
    if( zend_hash_index_find(Z_ARRVAL_P(rsegments), 1, (void**)&class) != FAILURE ){
		zend_update_property(cii_router_ce, getThis(), ZEND_STRL("class"), *class TSRMLS_CC);
	}
	if( zend_hash_index_find(Z_ARRVAL_P(rsegments), 2, (void**)&method) != FAILURE ){
		zend_update_property(cii_router_ce, getThis(), ZEND_STRL("method"), *method TSRMLS_CC);
	}
	/*
	*	output log
	*/
	cii_write_log(3, "Router Class Initialized");
}
/**
* Set class name
*
* @param	string	$class	Class name
* @return	void
*
* public function set_class($class)
*/
PHP_METHOD(cii_router, set_class)
{
	zval *class;
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &class) == FAILURE){
		WRONG_PARAM_COUNT;
	}
	zend_update_property(cii_router_ce, getThis(), ZEND_STRL("class"), class TSRMLS_CC);
}
/**
* Fetch the current class
*
* @deprecated	3.0.0	Read the 'class' property instead
* @return	string
*
* public function fetch_class()
*/
PHP_METHOD(cii_router, fetch_class)
{
	RETURN_ZVAL(zend_read_property(cii_router_ce, getThis(), ZEND_STRL("class"), 1 TSRMLS_CC), 1, 0);
}
/**
* Set method name
*
* @param	string	$method	Method name
* @return	void
*
* public function set_method($method)
*/
PHP_METHOD(cii_router, set_method)
{
	zval *method;
	if(zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z", &method) == FAILURE){
		WRONG_PARAM_COUNT;
	}
	zend_update_property(cii_router_ce, getThis(), ZEND_STRL("method"), method TSRMLS_CC);
}
/**
* Fetch the current method
*
* @deprecated	3.0.0	Read the 'method' property instead
* @return	string
*
* public function fetch_method()
*/
PHP_METHOD(cii_router, fetch_method)
{
	RETURN_ZVAL(zend_read_property(cii_router_ce, getThis(), ZEND_STRL("method"), 1 TSRMLS_CC), 1, 0);
}

zend_function_entry cii_router_methods[] = {
	PHP_ME(cii_router, __construct, NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_router, set_class, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_router, fetch_class, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_router, set_method, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_router, fetch_method, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_router)
{
	/**
	 * Router Class
	 *
	 * Parses URIs and determines routing
	 */
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "CII_Router", cii_router_methods);
	cii_router_ce = zend_register_internal_class(&ce TSRMLS_CC);
	/**
	 * Current class name
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_router_ce, ZEND_STRL("class"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * Current method name
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_router_ce, ZEND_STRL("method"), ZEND_ACC_PUBLIC TSRMLS_CC);

	return SUCCESS;
}