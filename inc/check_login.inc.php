<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/19
 * Time: 18:26
 */
if (empty($_POST['name'])){
    skip('login.php','error','用户名不能为空！');
}
if (mb_strlen($_POST['name'])>32){
    skip('login.php','error','用户名长度不能超过32位');
}
if (empty($_POST['pw'])){
    skip('login.php','error','密码不能为空！');
}
if (strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('login.php','error','验证码填写错误！');
}
if (empty($_POST['time']) || !is_numeric($_POST['time']) || $_POST['time']>2592000){
    $_POST['time']=2592000;
}
?>