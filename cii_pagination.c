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

#include "cii_pagination.h"

zend_class_entry *cii_pagination_ce;

PHP_METHOD(cii_pagination, __construct)
{
	zval *_per_page;
	zval *_total_rows;
	zval *_first_link;
	zval *_prev_link;
	zval *_next_link;
	zval *_last_link;
	/*
	* 	Init CII_Pagination::per_page
	*/
	MAKE_STD_ZVAL(_per_page);
	ZVAL_LONG(_per_page, 10);
	zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("per_page"), _per_page TSRMLS_CC);
	zval_ptr_dtor(&_per_page);
	/*
	* 	Init CII_Pagination::total_rows
	*/
	MAKE_STD_ZVAL(_total_rows);
	ZVAL_LONG(_total_rows, 0);
	zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("total_rows"), _total_rows TSRMLS_CC);
	zval_ptr_dtor(&_total_rows);
	/*
	* 	Init CII_Pagination::first_link
	*/
	MAKE_STD_ZVAL(_first_link);
	ZVAL_STRINGL(_first_link, "<<", 2, 1);
	zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("first_link"), _first_link TSRMLS_CC);
	zval_ptr_dtor(&_first_link);
	/*
	* 	Init CII_Pagination::prev_link
	*/
	MAKE_STD_ZVAL(_prev_link);
	ZVAL_STRINGL(_prev_link, "<", 1, 1);
	zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("prev_link"), _prev_link TSRMLS_CC);
	zval_ptr_dtor(&_prev_link);
	/*
	* 	Init CII_Pagination::next_link
	*/
	MAKE_STD_ZVAL(_next_link);
	ZVAL_STRINGL(_next_link, ">", 1, 1);
	zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("next_link"), _next_link TSRMLS_CC);
	zval_ptr_dtor(&_next_link);
	/*
	* 	Init CII_Pagination::last_link
	*/
	MAKE_STD_ZVAL(_last_link);
	ZVAL_STRINGL(_last_link, ">>", 2, 1);
	zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("last_link"), _last_link TSRMLS_CC);
	zval_ptr_dtor(&_last_link);
	/*
	*	output log
	*/
	cii_write_log(3, "Pagination Class Initialized");
}

PHP_METHOD(cii_pagination, initialize)
{
	zval *_params;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "a", &_params) == FAILURE) {
		return;
	}

	if( Z_TYPE_P(_params) == IS_ARRAY ){
		HashPosition pos;
		char *key;
		uint key_len;
		ulong num_index;
		zval **value;
		for(zend_hash_internal_pointer_reset_ex(Z_ARRVAL_P(_params), &pos);
		    zend_hash_has_more_elements_ex(Z_ARRVAL_P(_params), &pos) == SUCCESS;
		    zend_hash_move_forward_ex(Z_ARRVAL_P(_params), &pos)){

			if(zend_hash_get_current_key_ex(Z_ARRVAL_P(_params), &key, &key_len, &num_index, 0, &pos) == FAILURE){
				continue;
			}

			if(zend_hash_get_current_data_ex(Z_ARRVAL_P(_params), (void**)&value, &pos) == FAILURE){
				continue;
			}

			if( !strcmp( key, "base_url" ) ){
				if( Z_TYPE_P(*value) != IS_STRING ){
	 				convert_to_string(*value);
		 		}
				/*
				* update CII_Pagination::base_url
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("base_url"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}else if( !strcmp( key, "total_rows" ) ){
				if( Z_TYPE_P(*value) != IS_LONG ){
	 				convert_to_long(*value);
		 		}
				/*
				* update CII_Pagination::total_rows
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("total_rows"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}else if( !strcmp( key, "per_page" ) ){
				if( Z_TYPE_P(*value) != IS_LONG ){
	 				convert_to_long(*value);
		 		}
				/*
				* update CII_Pagination::per_page
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("per_page"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}else if( !strcmp( key, "first_link" ) ){
				if( Z_TYPE_P(*value) != IS_STRING ){
	 				convert_to_string(*value);
		 		}
				/*
				* update CII_Pagination::first_link
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("first_link"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}else if( !strcmp( key, "prev_link" ) ){
				if( Z_TYPE_P(*value) != IS_STRING ){
	 				convert_to_string(*value);
		 		}
				/*
				* update CII_Pagination::prev_link
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("prev_link"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}else if( !strcmp( key, "next_link" ) ){
				if( Z_TYPE_P(*value) != IS_STRING ){
	 				convert_to_string(*value);
		 		}
				/*
				* update CII_Pagination::next_link
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("next_link"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}else if( !strcmp( key, "last_link" ) ){
				if( Z_TYPE_P(*value) != IS_STRING ){
	 				convert_to_string(*value);
		 		}
				/*
				* update CII_Pagination::last_link
				*/
				Z_ADDREF_P(*value);
				zend_update_property(cii_pagination_ce, getThis(), ZEND_STRL("last_link"), *value TSRMLS_CC);
				zval_ptr_dtor(value);
			}
		}
	}
	RETURN_TRUE;
}

PHP_METHOD(cii_pagination, create_links)
{
	uint _cur_page;
	zval *_base_url;
	zval *_total_rows;
	zval *_per_page;

	zval *_first_link;
	zval *_prev_link;
	zval *_next_link;
	zval *_last_link;

	uint num_page;
	char *output, *p, *q;
	uint output_len;
	int start, end;

	int i;
	/*
	* init CII_Pagination::cur_page
	*/
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|l", &_cur_page) == FAILURE) {
		return;
	}

	if( !_cur_page ){
		_cur_page = 1;
	}

	_base_url   = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("base_url"),   1 TSRMLS_CC);
	if( Z_STRLEN_P(_base_url) == 0 ){
		RETURN_NULL();
	}
	_total_rows = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("total_rows"), 1 TSRMLS_CC);
	if( Z_LVAL_P(_total_rows) == 0 ){
		RETURN_NULL();
	}
	_per_page = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("per_page"), 1 TSRMLS_CC);
	if( Z_LVAL_P(_per_page) == 0 ){
		RETURN_NULL();
	}
	_first_link = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("first_link"), 1 TSRMLS_CC);
	_prev_link  = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("prev_link"), 1 TSRMLS_CC);
	_next_link  = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("next_link"), 1 TSRMLS_CC);
	_last_link  = zend_read_property(cii_pagination_ce, getThis(), ZEND_STRL("last_link"), 1 TSRMLS_CC);

	num_page = Z_LVAL_P(_total_rows)%Z_LVAL_P(_per_page)?(int)Z_LVAL_P(_total_rows)/Z_LVAL_P(_per_page)+1:(int)Z_LVAL_P(_total_rows)/Z_LVAL_P(_per_page);
	if( num_page <= 1 ){
		RETURN_NULL();
	}

	if( !_cur_page || _cur_page < 1 ){
		_cur_page = 1;
	}
	if( _cur_page > num_page ){
		_cur_page = num_page;
	}

	start = _cur_page - 2;
	end = _cur_page + 2;
	if( start < 1 ){
		start = 1;
	}
	if( end > num_page ){
		end = num_page;
	}

	output_len = spprintf(&output, 0, "<div class='pn'><div class='pn-container'>");
	if( start != 1 ){
		p = output;
		output_len = spprintf(&output, 0, "%s<span><a href='%s'>%s</a></span>", p, Z_STRVAL_P(_base_url), Z_STRVAL_P(_first_link));
		efree(p);
	}
	if( _cur_page > start ){
		p = output;
		output_len = spprintf(&output, 0, "%s<span><a href='%s%d'>%s</a></span>", p, Z_STRVAL_P(_base_url), _cur_page-1, Z_STRVAL_P(_prev_link));
		efree(p);
	}
	for(i=start;i<=end;i++){
		p = output;
		if( i == _cur_page ){
			spprintf(&q, 0, "<span class='current'>%d</span>", i);
		}else{
			spprintf(&q, 0, "<span><a href='%s%d'>%d</a></span>", Z_STRVAL_P(_base_url), i, i);
		}
		output_len = spprintf(&output, 0, "%s%s", p, q);
		efree(p);
		efree(q);
	}
	if( _cur_page < end ){
		p = output;
		output_len = spprintf(&output, 0, "%s<span><a href='%s%d'>%s</a></span>", p, Z_STRVAL_P(_base_url), _cur_page+1, Z_STRVAL_P(_next_link));
		efree(p);
	}
	if( end != num_page ){
		p = output;
		output_len = spprintf(&output, 0, "%s<span><a href='%s%d'>%s</a></span>", p, Z_STRVAL_P(_base_url), num_page, Z_STRVAL_P(_last_link));
		efree(p);
	}
	p = output;
	output_len = spprintf(&output, 0, "%s<div class='clearfix'></div></div><div class='clearfix'></div></div>", p);
	efree(p);
	RETURN_STRINGL(output, output_len, 0);
}

zend_function_entry cii_pagination_methods[] = {
	PHP_ME(cii_pagination, __construct,  NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_pagination, initialize,   NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_pagination, create_links, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_pagination)
{
	zend_class_entry ce;
	
	INIT_CLASS_ENTRY(ce, "CII_Pagination", cii_pagination_methods);
	cii_pagination_ce = zend_register_internal_class(&ce TSRMLS_CC);

	/**
	 * CII_Pagination::base_url
	 *
	 * @var	string
	 */
	zend_declare_property_null(cii_pagination_ce, ZEND_STRL("base_url"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Pagination::per_page
	 *
	 * @var	long
	 */
	zend_declare_property_null(cii_pagination_ce, ZEND_STRL("per_page"), ZEND_ACC_PUBLIC TSRMLS_CC);
	/**
	 * CII_Pagination::total_rows
	 *
	 * @var	long
	 */
	zend_declare_property_null(cii_pagination_ce, ZEND_STRL("total_rows"), ZEND_ACC_PUBLIC TSRMLS_CC);

	// zval *cii_pagination;
	// MAKE_STD_ZVAL(cii_pagination);
	// object_init_ex(cii_pagination, cii_input_ce);
	// zend_hash_update(Z_ARRVAL_P(CII_G(classes)), "input", 6, &cii_input_obj, sizeof(zval *), NULL);

	/* If you have INI entries, uncomment these lines 
	REGISTER_INI_ENTRIES();
	*/
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
