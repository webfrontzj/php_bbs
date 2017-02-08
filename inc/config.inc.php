<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2016/12/16
 * Time: 11:31
 */
date_default_timezone_set('Asia/Shanghai');   //设置时区
session_start();
header('Content-type:text/html;charset=utf-8');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASSWORD','root');
define('DB_DATABAASE','sfkbbs');
define('DB_PORT','3306');
//我们项目在服务器的绝对路径
define ('SA_PATH',dirname(dirname(__FILE__)));
//我们的项目在web根目录下面的位置
define ('SUB_URL',str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('\\','/',SA_PATH)).'/');
?>