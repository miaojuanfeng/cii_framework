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

#include "cii_output.h"

zend_class_entry *cii_output_ce;

/**
* Class constructor
*
* Determines whether zLib output compression will be used.
*
* @return	void
*
* public function __construct()
*/
PHP_METHOD(cii_output, __construct)
{
	/*
	*	output log
	*/
	cii_write_log(3, "Output Class Initialized");
}
/*
*	append_output
*/
void cii_append_output(zend_class_entry *cii_output_ce, zval *cii_output_obj, char *output_str TSRMLS_DC)
{
	zval *final_output;
	char *output_new;
	zval *new_final_output;

	final_output = zend_read_property(cii_output_ce, cii_output_obj, "final_output", 12, 1 TSRMLS_CC);
	
	spprintf(&output_new, 0, "%s%s", Z_STRVAL_P(final_output), output_str);

	MAKE_STD_ZVAL(new_final_output);
	ZVAL_STRING(new_final_output, output_new, 0);

	zend_update_property(cii_output_ce, cii_output_obj, "final_output", 12, new_final_output TSRMLS_CC);

	zval_ptr_dtor(&new_final_output);
}
/**
* Append Output
*
* Appends data onto the output string.
*
* @param	string	$output	Data to append
* @return	CI_Output
*
* public function append_output($output)
*/
PHP_METHOD(cii_output, append_output)
{
	char *output = NULL;
	uint output_len;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "s" ,&output, &output_len) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	if( output && output_len ){
		cii_append_output(cii_output_ce, getThis(), output TSRMLS_CC);
	}
	if( return_value_used){
		RETURN_ZVAL(getThis(), 1, 0);
	}
}
/*
*	display
*/
int cii_display(char *output, uint output_len, char **output_new, uint *output_new_len TSRMLS_DC){
	// char *p = NULL;
	// char *free_output_new = NULL;
	// char retval = 0;
	// char *elapsed_time;
	// char elapsed_time_state;
	
	// elapsed_time_state = elapsed_time_ex(cii_benchmark_ce, CII_G(benchmark_obj), "total_execution_time_start", 26, "total_execution_time_end", 24, 4, &elapsed_time TSRMLS_CC);
	// /*
	// *	replace {elapsed_time}
	// */
	// *output_new = output;
	// *output_new_len = output_len;
	// //debug
	// //double start = cii_microtime();
	// //debug
	// while(CII_G(output_replace_elapsed_time)--){
	// 	p = strstr(*output_new, "{elapsed_time}");
	// 	if( p ){
	// 		p[13] = '\0';
	// 		p[0]  = '\0';
	// 		if( retval ){
	// 			free_output_new = *output_new;
	// 		}
	// 		*output_new_len = spprintf(output_new, 0, "%s%s%s", *output_new, elapsed_time, &p[14]);
	// 		if( free_output_new ){
	// 			efree(free_output_new);
	// 			free_output_new = NULL;
	// 		}
	// 		retval = 1;
	// 	}
	// }
	// /*
	// *	replace {memory_usage}
	// */
	// while(CII_G(output_replace_memory_usage)--){
	// 	char *memory;

	// 	p = strstr(*output_new, "{memory_usage}");
	// 	if( p ){
	// 		p[13] = '\0';
	// 		p[0]  = '\0';
	// 		if( retval ){
	// 			free_output_new = *output_new;
	// 		}
	// 		memory = _php_math_number_format((double)zend_memory_usage(0 TSRMLS_CC)/1024/1024, 2, '.', ',');
	// 		*output_new_len = spprintf(output_new, 0, "%s%s%s%s", *output_new, memory, "MB", &p[14]);
	// 		efree(memory);
	// 		if( free_output_new ){
	// 			efree(free_output_new);
	// 			free_output_new = NULL;
	// 		}
	// 		retval = 1;
	// 	}
	// }
	// /*
	// *	replace {memory_peak}
	// */
	// while(CII_G(output_replace_memory_peak)--){
	// 	char *memory;

	// 	p = strstr(*output_new, "{memory_peak}");
	// 	if( p ){
	// 		p[12] = '\0';
	// 		p[0]  = '\0';
	// 		if( retval ){
	// 			free_output_new = *output_new;
	// 		}
	// 		memory = _php_math_number_format((double)zend_memory_peak_usage(0 TSRMLS_CC)/1024/1024, 2, '.', ',');
	// 		*output_new_len = spprintf(output_new, 0, "%s%s%s%s", *output_new, memory, "MB", &p[13]);
	// 		efree(memory);
	// 		if( free_output_new ){
	// 			efree(free_output_new);
	// 			free_output_new = NULL;
	// 		}
	// 		retval = 1;
	// 	}
	// }
	// /*
	// *	return state. 1 means replaced or 0 means not replaced
	// */
	// //debug
	// //double end = cii_microtime();
	// //php_printf("time: %f\n", end-start);
	// //debug
	// if( elapsed_time_state ){
	// 	efree(elapsed_time);
	// }
	// return retval;
}
/**
* Display Output
*
* Processes and sends finalized output data to the browser along
* with any server headers and profile data. It also stops benchmark
* timers so the page rendering speed and memory usage can be shown.
*
* Note: All "view" data is automatically put into $this->final_output
*	 by controller class.
*
* @uses	CI_Output::$final_output
* @param	string	$output	Output data override
* @return	void
*
* public function display($output = '')
*/
PHP_METHOD(cii_output, display)
{
	zval *output = NULL;
	char *output_new;
	uint output_new_len;
	char retval;

	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "|z!" ,&output) == FAILURE) {
		WRONG_PARAM_COUNT;
	}

	if( output && Z_TYPE_P(output) != IS_STRING ){
		convert_to_string(output);
	}

	if( output && Z_TYPE_P(output) == IS_STRING ){
		retval = cii_display(Z_STRVAL_P(output), Z_STRLEN_P(output), &output_new, &output_new_len TSRMLS_CC);
	}else{
		zval *output = zend_read_property(cii_output_ce, getThis(), "final_output", 12, 1 TSRMLS_CC);
		retval = cii_display(Z_STRVAL_P(output), Z_STRLEN_P(output), &output_new, &output_new_len TSRMLS_CC);
	}
	PHPWRITE(output_new, output_new_len);
	if( retval ){
		efree(output_new);
	}
}
/**
* Get Output
*
* Returns the current output string.
*
* @return	string
*
* public function get_output()
*/
PHP_METHOD(cii_output, get_output)
{
	zval *final_output = zend_read_property(cii_output_ce, getThis(), "final_output", 12, 1 TSRMLS_CC);
	RETURN_STRING(Z_STRVAL_P(final_output), 1);
}
/**
* Set Output
*
* Sets the output string.
*
* @param	string	$output	Output data
* @return	CI_Output
*
* public function set_output($output)
*/
PHP_METHOD(cii_output, set_output)
{
	zval *output;
	if (zend_parse_parameters(ZEND_NUM_ARGS() TSRMLS_CC, "z" ,&output) == FAILURE) {
		WRONG_PARAM_COUNT;
	}
	zend_update_property(cii_output_ce, getThis(), "final_output", 12, output TSRMLS_CC);
	RETURN_ZVAL(getThis(), 1, 0);
}	

zend_function_entry cii_output_methods[] = {
	PHP_ME(cii_output, __construct, NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_output, append_output, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_output, display, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_output, get_output, NULL, ZEND_ACC_PUBLIC)
	PHP_ME(cii_output, set_output, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_output)
{
	/**
	 * Output Class
	 *
	 * Responsible for sending final output to the browser.
	 */
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "CII_Output", cii_output_methods);
	cii_output_ce = zend_register_internal_class(&ce TSRMLS_CC);
	/**
	 * Final output string
	 *
	 * @var	string
	 */
	zend_declare_property_string(cii_output_ce, ZEND_STRL("final_output"), "", ZEND_ACC_PUBLIC TSRMLS_CC);

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
 