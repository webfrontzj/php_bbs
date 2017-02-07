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

?>