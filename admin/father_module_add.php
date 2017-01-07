<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
include_once '../inc/tool.inc.php';
$templates['title']='添加父版块';
$templates['css']=array('style/public.css');
if (isset($_POST['submit'])){
    $check_flag='add';
    include "inc/check_father_module.inc.php";
    $query="insert into sfk_father_module(module_name,sort) values('{$_POST['module_name']}',{$_POST['sort']})";
    execute($link,$query);
    if(mysqli_affected_rows($link)){
        skip('father_module.php','ok','恭喜你，添加成功！');
    }else{
        skip('father_module_add.php','error','对不起，添加失败，请重试！');
    }
}
?>
<?php include 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom: 20px;">添加父版块</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name"></td>
                <td>板块名称不能为空，最大不能超过66个字</td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input type="text" name="sort"></td>
                <td>填写一个数字即可</td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" type="submit" name="submit" value="添加" class="btn">
    </form>
</div>
<?php include 'inc/footer.inc.php'?>
