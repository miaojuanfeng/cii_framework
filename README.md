# cii_framework
Codeigniter Internal Framework. Working as PHP extension, Faster than Codeigniter Framework.

### 简介
CII 是一个小巧但功能强大的 PHP 扩展框架，作为一个简单优雅的工具包，它可以为 PHP 程序员建立功能完善并且快速的 Web 应用程序。

如果你已经厌倦了那些傻大笨粗的框架，为 CodeIgniter 的运行效率而烦恼，并且你的站点运行在独立主机中，那么 CII 扩展框架就是你所需要的。

### 特性
* CII 高性能扩展框架，全称为 CodeIgniter Internal Framework 。
* 这是根据目前非常流行的开源框架 CodeIgniter 的架构，以 PHP 扩展方式实现的框架。
* 完全采用 C 语言编写而成，编译为动态链接库，在 PHP 启动时装载运行。
* 采用 CII 框架开发网站的速度和便利不输于 CodeIgniter 。
* 支持 Codeigniter 框架结构及语法。
* 对比 Codeignter 拥有超过 5 倍的性能提升。
* 对比 Codeignter 减少了 75% 的内存使用。
* 经过线下单元测试与线上长期运行，CII 框架运行时不会产生段错误与内存泄露 。
* 未来的代码优化，会带来更好的性能表现。

### 运行环境
CII 扩展在以下环境中开发测试及运行：

OS：
* Mac OS X EI Capitan 10.11.6
* Ubuntu Kylin 14.04 64bit
* Windows 7 64bit

PHP：
* PHP-5.6.25

Server:
* Httpd 2.4.27

Mysql：
* 任何 Mysqli 扩展支持的版本

### PHP编译方式
CII 框架支持PHP的单线程模式与多线程模式。如果 PHP 被编译成单线程，采用 CGI 方式与服务器协作。参考编译配置：

```php
--prefix=/web/php --disable-maintainer-zts --enable-debug --with-mysql=mysqlnd --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd
```

如果 PHP 被编译成 Apache 模块，采用多线程方式与服务器协作，编译 PHP 时需要开启多线程模式。线上安装请关闭 PHP 的 Debug 模式，去除 `--enable-debug`。
