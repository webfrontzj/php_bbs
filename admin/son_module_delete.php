<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('father_module.php','error','id参数传递失败！，');
}
$link=connect();
$query="delete from sfk_son_module where id={$_GET['id']}";
execute($link,$query);
if(mysqli_affected_rows($link)==1){
    skip('son_module.php','ok','恭喜你删除成功，');
}else{
    skip('son_module.php','error','对不起，删除失败，请重试，');
}
?>