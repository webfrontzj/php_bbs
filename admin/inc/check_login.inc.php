<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/10
 * Time: 15:33
 */
if (empty($_POST['name'])){
    skip('login.php','error','管理员名称不得为空');
}
if (mb_strlen($_POST['name'])>32){
    skip('login.php','error','管理员名称不可能多余32字符');
}
if (mb_strlen($_POST['pw'])<6){
    skip('login.php','error','密码不少于6个字符');
}
if (strtolower($_POST['vcode'])!=strtolower($_SESSION['vcode'])){
    skip('login.php','error','验证码填写错误！');
}
?>