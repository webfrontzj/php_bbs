<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/10
 * Time: 16:19
 */
if (!is_manage_login($link)){
    header('Location:login.php');
    exit();
}
if (basename($_SERVER['SCRIPT_NAME'])=='manage_delete.php' || basename($_SERVER['SCRIPT_NAME'])=='manage_add.php'){
    if ($_SESSION['manage']['level']!='0'){
        if (!isset($_SERVER['HTTP_REFERER'])){
            $_SERVER['HTTP_REFERER']='index.php';
        }
        skip($_SERVER['HTTP_REFERER'],'error','您没有权限');
    }
}
?>