<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('father_module.php','error','id参数传递失败！，');
}
$link=connect();
include "inc/is_manage_login.inc.php";
$query="select * from sfk_son_module where father_module_id={$_GET['id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)){
    skip('father_module.php','error','该父版块下存在子版块，请先将对应子版块删除！');
}
$query="delete from sfk_father_module where id={$_GET['id']}";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
    skip('father_module.php','ok','恭喜你删除成功，');
}else{
    skip('father_module.php','error','对不起，删除失败，请重试，');
}
?>