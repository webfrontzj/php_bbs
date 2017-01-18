<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 22:23
 */
session_start();
include_once 'inc/vcode.inc.php';
$_SESSION['vcode']=vcode();
?>