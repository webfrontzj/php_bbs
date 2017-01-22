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
$template['title']='会员注册页';
$template['css']=array('style/public.css','style/register.css');
$link=connect();
if($member_id=is_login($link)){
    skip('index.php','error','你已经登录，请不要重复注册！');
}
if (isset($_POST['submit'])){
    include 'inc/check_register.inc.php';
    $query="insert into sfk_member(name,pw,register_time) values('{$_POST['name']}',md5('{$_POST['pw']}'),now())";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        setcookie('sfk[name]',$_POST['name']);
        setcookie('sfk[pw]',sha1(md5($_POST['pw'])));
        skip('index.php','ok','注册成功！');
    }else{
        skip('register.php','error','注册失败！');
    }
}
?>
<?php include 'inc/header.inc.php'?>
<div id="register" class="auto">
    <h2>欢迎注册成为 私房库会员</h2>
    <form method="post">
        <label>用户名：<input type="text" name="name" /><span>*用户名不能为空并且不能超过32个字符</span></label>
        <label>密码：<input type="password" name="pw" /><span>*密码不得少于6位</span></label>
        <label>确认密码：<input type="password" name="confirm_pw" /><span>*请再次输入密码</span></label>
        <label>验证码：<input name="vcode" type="text"  /><span>*请输入下方验证码</span></label>
        <img class="vcode" src="show_code.php" />
        <div style="clear:both;"></div>
        <input class="btn" type="submit" name="submit" value="确定注册" />
    </form>
</div>
<?php include 'inc/footer.inc.php'?>
</body>
</html>
