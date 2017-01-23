<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/23
 * Time: 18:29
 */

include "inc/config.inc.php";
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
$link=connect();
$member_id=is_login($link);
if(!$member_id){
    skip('index.php','error','你没有登陆，不需要退出！');
}
setcookie('sfk[name]','',time()-1);
setcookie('sfk[pw]','',time()-1);
skip('index.php','ok','退出成功!');
?>