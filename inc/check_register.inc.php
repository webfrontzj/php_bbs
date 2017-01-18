<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/18
 * Time: 17:40
 */
if(empty($_POST['name'])){
    skip('register.php','error','用户名不得为空！');
}
if(mb_strlen($_POST['name'])>32){
    skip('register.php','error','用户名长度不能大于32个字符！');
}
if (mb_strlen($_POST['pw'])<6){
    skip('register.php','error','密码长度不能小于6个字符！');
}
if ($_POST['pw']!=$_POST['confirm_pw']){
    skip('register.php','error','两次输入密码不一样！');
}
$_POST=escape($link,$_POST);
$query="select * from sfk_member where name='{$_POST['name']}'";
$result=execute($link,$query);
if (mysqli_num_rows($result)){
    skip('register.php','error','这个用户名已经被别人注册了！');
}
?>