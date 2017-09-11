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

#include "cii_log.h"

zend_class_entry *cii_log_ce;
/**
* Class constructor
*
* @return	void
*
* public function __construct()
*/
PHP_METHOD(cii_log, __construct)
{
	zval **logs_path;
	char *filepath;
	/*
	*	logs filepath
	*/
	
	if( zend_hash_find(Z_ARRVAL_P(CII_G(config_arr)), "logs_path", 10, (void**)&logs_path) == FAILURE ||
		Z_TYPE_PP(logs_path) != IS_STRING || Z_STRLEN_PP(logs_path) == 0 ){
		php_error(E_ERROR, "Your config 'logs_path' does not appear to be formatted correctly.");
	}
	/*
	*	set filepath
	*/
	
	spprintf(&filepath, 0, "%s/%s", CII_G(app_path), Z_STRVAL_PP(logs_path));
	/*
	*	directory not exists, create the directory
	*/
	if( access(filepath, 0) ){
		if( !mkdir(filepath, 0777) ){
			/*
			*	output log
			*/
			cii_write_log(3, "Log Folder Created" TSRMLS_CC);
		}else{
			/*
			*	output log
			*/
			php_error(E_WARNING, "Create Log Folder Failed");
		}
	}
	efree(filepath);
	/*
	*	output log
	*/
	cii_write_log(3, "Log Class Initialized" TSRMLS_CC);
}
/*
* Write Log File
*/
int cii_write_log(int level, char *message TSRMLS_DC)
{
	static int log_threshold = 4;
	char filename[19];
	time_t t;
	zval **logs_path;
	char *filepath;
	char *level_upper;
	char timer[20];
	FILE *f;

	// This function Not working in Thread Safe mode. will fix it later.
	return 1;
	/*
	* 0 = Disables logging, Error logging TURNED OFF
	* 1 = Error Messages (including PHP errors)
	* 2 = Debug Messages
	* 3 = Informational Messages
	* 4 = All Messages
	*/
	
	/*
	*	if disables logging
	*/
	if( !log_threshold ){
		return 0;
	}
	/*
	*	if level overflow
	*/
	if( level > log_threshold ){
		return 0;
	}
	/*
	*	get time
	*/
	t = time(NULL);
	/*
	*	set filename
	*/
	strftime(filename, 19, "log-%Y-%m-%d.php", localtime(&t));
	/*
	*	logs filepath
	*/
	if( zend_hash_find(Z_ARRVAL_P(CII_G(config_arr)), "logs_path", 10, (void**)&logs_path) == FAILURE ||
		Z_TYPE_PP(logs_path) != IS_STRING || Z_STRLEN_PP(logs_path) == 0 ){
		php_error(E_ERROR, "Your config 'logs_path' does not appear to be formatted correctly.");
	}
	/*
	*	set filepath
	*/
	spprintf(&filepath, 0, "%s/%s/%s", CII_G(app_path), Z_STRVAL_PP(logs_path), filename);
	/*
	*	set level title
	*/
	if( level == 1 ){
		level_upper = "ERROR";
	}else if( level == 2 ){
		level_upper = "DEBUG";
	}else if( level == 3 ){
		level_upper = "INFO";
	}else if( level == 4 ){
		level_upper = "ALL";
	}
	/*
	*	get time
	*/
	strftime(timer, 20, "%Y-%m-%d %H:%M:%S", localtime(&t));
	/*
	*	open file to write log
	*/
	/*
	*	open new file
	*/
	if( access(filepath, 0) ){	
		char *access;
		char *log;

		if( (f = fopen(filepath, "a")) == NULL ){
			php_error(E_WARNING, "Cannot open log file: %s", filepath);
			efree(filepath);
			return 0;
		}
		/*
		*	write access
		*/
		spprintf(&access, 0, "<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>\r\n\r\n");
		fputs(access, f);
		efree(access);
		/*
		*	write log
		*/
		spprintf(&log, 0, "%s%s%s%s%s%s", level_upper, " - ", timer, " --> ", message, "\r\n");
		fputs(log, f);
		efree(log);
	/*
	*	open exists file
	*/
	}else{
		char *log;

		if( (f = fopen(filepath, "a")) == NULL ){
			php_error(E_WARNING, "Cannot open log file: %s", filepath);
			efree(filepath);
			return 0;
		}
		/*
		*	write log
		*/
		spprintf(&log, 0, "%s%s%s%s%s%s", level_upper, " - ", timer, " --> ", message, "\r\n");
		fputs(log, f);
		efree(log);
	}
	/*
	*	free used memory
	*/
	fclose(f);
	efree(filepath);
	/*
	* return state
	*/
	return 1;
}
/*
*	cii_user_write_log
*/
int cii_user_write_log(char *level, uint level_len, char *message, uint message_len TSRMLS_DC)
{
	char *log_threshold[4] = {"error", "debug", "info", "all"};
	char *level_lower = zend_str_tolower_dup(level, level_len);
	int p = -1;
	int i;
	for (i = 0; i < 4; i++)
	{
		if( !strcmp(level_lower, log_threshold[i]) ){
			p = i+1;
			break;
		}
	}
	efree(level_lower);
	if( p >= 0 ){
		return cii_write_log(p, message TSRMLS_CC);
	}
	return 0;
}
/**
* Write Log File
*
* Generally this function will be called using the global log_message() function
*
* @param	string	the error level: 'error', 'debug' or 'info'
* @param	string	the error message
* @return	bool
*
* public function write_log($level, $msg)
*/
PHP_METHOD(cii_log, write_log)
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

zend_function_entry cii_log_methods[] = {
	PHP_ME(cii_log, __construct, NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
	PHP_ME(cii_log, write_log, NULL, ZEND_ACC_PUBLIC)
	PHP_FE_END
};

PHP_MINIT_FUNCTION(cii_log)
{
	/**
	 * Logging Class
	 */
	zend_class_entry ce;
	INIT_CLASS_ENTRY(ce, "CII_Log", cii_log_methods);
	cii_log_ce = zend_register_internal_class(&ce TSRMLS_CC);
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: noet sw=4 ts=4 fdm=marker
 * vim<600: noet sw=4 ts=4
 */
