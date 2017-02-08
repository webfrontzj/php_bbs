<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/5
 * Time: 16:26
 */
include_once "inc/config.inc.php";
include_once "inc/mysql.inc.php";
include_once "inc/tool.inc.php";
include_once "inc/upload.inc.php";
$link=connect();
if(!$member_id=is_login($link)){
    skip('login.php','error','请登录后再对自己的头像做设置！');
}
$query="select * from sfk_member where id={$member_id}";
$result_member=execute($link,$query);
$data_member=mysqli_fetch_assoc($result_member);
if (isset($_POST['submit'])){
    $save_path='uploads'.date('/Y/m/d');
    $upload=upload($save_path,'2M','photo');
    if ($upload['return']){
        $query="update sfk_member set photo='{$upload['save_path']}' where id={$member_id}";
        execute($link,$query);
        if (mysqli_affected_rows($link)==1){
            skip("member.php?id={$member_id}",'ok','头像设置成功！');
        }else{
            skip('member_photo_update.php','error','头像设置失败，请重试！');
        }
    }else{
        skip('member_photo_update.php','error',$upload['error']);
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
    <style type="text/css">
        body {
            font-size:12px;
            font-family:微软雅黑;
        }
        h2 {
            padding:0 0 10px 0;
            border-bottom: 1px solid #e3e3e3;
            color:#444;
        }
        .submit {
            background-color: #3b7dc3;
            color:#fff;
            padding:5px 22px;
            border-radius:2px;
            border:0px;
            cursor:pointer;
            font-size:14px;
        }
        #main {
            width:80%;
            margin:0 auto;
        }
    </style>
</head>
<body>
<div id="main">
    <h2>更改头像</h2>
    <div>
        <h3>原头像：</h3>
        <img src="<?php if ($data_member['photo']!=''){echo SUB_URL.$data_member['photo'];}else{echo 'style/photo.jpg';}?>" />
    </div>
    <div style="margin:15px 0 0 0;">
        <form method="post" enctype="multipart/form-data">
            <input style="cursor:pointer;" width="100" name="photo" type="file" /><br /><br />
            <input class="submit" type="submit" name="submit" value="保存" />
        </form>
    </div>
</div>
</body>
</html>
