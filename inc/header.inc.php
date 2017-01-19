<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/19
 * Time: 17:18
 */
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8" />
    <title><?php echo $template['title']?></title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <?php
        foreach ($template['css'] as $val){
            echo "<link rel='stylesheet' type='text/css' href='{$val}'>";
        }
    ?>
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
