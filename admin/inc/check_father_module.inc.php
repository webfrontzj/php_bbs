<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/7
 * Time: 19:58
 */
if(empty($_POST['module_name'])){
    skip('father_module_add.php','error','板块名称不能为空!');
}
if(mb_strlen($_POST['module_name']>66)){
    skip('father_module_add.php','error','板块名称不能多于66个字符!');
}
if(!is_numeric($_POST['sort'])){
    skip('father_module_add.php','error','排序只能是数字！');
}
$link=connect();
$_POST=escape($link,$_POST);
switch ($check_flag){
    case 'add':
        $query="select * from sfk_father_module where module_name='{$_POST['module_name']}'";
        break;
    case 'update':
        $query="select * from sfk_father_module where module_name='{$_POST['module_name']}' and id !={$_GET['id']}";
        break;
    default:
        skip('father_module.php','error','$check_flag参数错误！');
}
$result=execute($link,$query);
if(mysqli_num_rows($result)){
    skip('father_module_add.php','error','板块已经存在，不能重复添加！!');
}
?>