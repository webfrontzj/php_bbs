<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/5
 * Time: 9:23
 */
include_once "inc/config.inc.php";
include_once "inc/mysql.inc.php";
include_once "inc/tool.inc.php";
$link=connect();
if (!$member_id=is_login($link)){
    skip('index.php','error','没有登录！');
}
if (!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('index.php','error','帖子id参数不合法！');
}
$query="select member_id from sfk_content where id={$_GET['id']}";
$result_content=execute($link,$query);
if (mysqli_num_rows($result_content)==1){
    $data_content=mysqli_fetch_assoc($result_content);
    if(check_user($member_id,$data_content['member_id'])){
        $query="delete from sfk_content where id={$_GET['id']}";
        execute($link,$query);
        if (mysqli_affected_rows($link)==1){
            skip("member.php?id={$member_id}",'ok','恭喜你删除成功！');
        }else{
            skip("member.php?id={$member_id}",'error','对不起删除失败！');
        }
    }else{
        skip('index.php','error','这个帖子不属于你，你没有权限');
    }
}else{
    skip('index.php','error','帖子不存在！');
}

?>