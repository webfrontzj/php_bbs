<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/7
 * Time: 14:26
 */
function skip($url,$pic,$message){
    $html=<<<A
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>正在跳转中</title>
<meta http-equiv="refresh" content="3;url={$url}" />
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic {$pic}"></span> {$message}3秒钟后自动跳转... <a href="{$url}">直接跳转</a></div>
</body>
</html>
A;
echo $html;
}
?>