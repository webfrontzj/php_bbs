<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/20
 * Time: 17:32
 */
if (empty($_POST['module_id']) || !is_numeric($_POST['module_id'])){
    skip('publish.php','error','所属板块id不合法！');
}
$query="select * from sfk_son_module where id={$_POST['module_id']}";
$result=execute($link,$query);
if(mysqli_num_rows($result)!=1){
    skip('publish.php','error','所属板块不存在！');
}
if(empty($_POST['title'])){
    skip('publish.php','error','标题不能为空！');
}
if(mb_strlen($_POST['title'])>255){
    skip('publish.php','error','标题不能超过255个字符！');
}
?>