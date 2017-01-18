<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/18
 * Time: 17:30
 */
include 'inc/config.inc.php';
include 'inc/mysql.inc.php';
include 'inc/tool.inc.php';
$link=connect();
if (isset($_POST['submit'])){
    include 'inc/check_register.inc.php';
    $query="insert into sfk_member(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('index.php','ok','注册成功！');
    }else{
        skip('register.php','error','注册失败！');
    }
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link rel="stylesheet" type="text/css" href="style/public.css" />
    <link rel="stylesheet" type="text/css" href="style/register.css" />
</head>
<body>
<div class="header_wrap">
    <div id="header" class="auto">
        <div class="logo">sifangku</div>
        <div class="nav">
            <a class="hover">首页</a>
        </div>
        <div class="serarch">
            <form>
                <input class="keyword" type="text" name="keyword" placeholder="搜索其实很简单" />
                <input class="submit" type="submit" name="submit" value="" />
            </form>
        </div>
        <div class="login">
            <a>登录</a>&nbsp;
            <a>注册</a>
        </div>
    </div>
</div>
<div style="margin-top:55px;"></div>
<div id="register" class="auto">
    <h2>欢迎注册成为 私房库会员</h2>
    <form method="post">
        <label>用户名：<input type="text" name="name" /><span>*用户名不能为空并且不能超过32个字符</span></label>
        <label>密码：<input type="password" name="pw" /><span>*密码不得少于6位</span></label>
        <label>确认密码：<input type="password" name="confirm_pw" /><span>*请再次输入密码</span></label>
        <label>验证码：<input name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
        <img class="vcode" src="style/show_code.jpg" />
        <div style="clear:both;"></div>
        <input class="btn" type="submit" name="submit" value="确定注册" />
    </form>
</div>
<div id="footer" class="auto">
    <div class="bottom">
        <a>私房库</a>
    </div>
    <div class="copyright">Powered by sifangku ©2015 sifangku.com</div>
</div>
</body>
</html>
