<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/7
 * Time: 13:40
 */
include_once "../inc/config.inc.php";
if(!isset($_GET['message']) || !isset($_GET['url']) || !isset($_GET['return_url'])){
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8" />
<title>确认页</title>
<meta name="keywords" content="确认页" />
<meta name="description" content="确认页" />
<link rel="stylesheet" type="text/css" href="style/remind.css" />
</head>
<body>
<div class="notice"><span class="pic ask"></span> <?php echo $_GET['message']?> <a href="<?php echo $_GET['url']?>">确认</a> <a href="<?php echo $_GET['return_url']?>">取消</a></div>
</body>
</html>