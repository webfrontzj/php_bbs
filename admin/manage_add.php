<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/10
 * Time: 12:02
 */
include_once "../inc/config.inc.php";
include_once "../inc/mysql.inc.php";
include_once "../inc/tool.inc.php";
$link=connect();
include "inc/is_manage_login.inc.php";
$templates['title']='管理员添加页';
$templates['css']=array('style/public.css');
if (isset($_POST['submit'])){
    include 'inc/check_manage.inc.php';
    $query="insert into sfk_manage(name,pw,create_time,level) VALUES ('{$_POST['name']}',md5({$_POST['pw']}),now(),{$_POST['level']})";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('manage.php','ok','恭喜你，添加成功！');
    }else{
        skip('manage_add.php','error','添加失败，请重试');
    }
}
?>

<?php include_once "inc/header.inc.php"?>
<div id="main">
    <div class="title" style="margin-bottom: 20px;">添加父版块</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>管理员名称</td>
                <td><input type="text" name="name"></td>
                <td>名称不能为空，最大不能超过32个字</td>
            </tr>
            <tr>
                <td>密码</td>
                <td><input type="text" name="pw"></td>
                <td>不能少于6位</td>
            </tr>
            <tr>
                <td>等级</td>
                <td>
                    <select name="level">
                        <option value="1">普通管理员</option>
                        <option value="0">超级管理员</option>
                    </select>
                </td>
                <td>请选择一个等级，默认为普通管理员</td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" type="submit" name="submit" value="添加" class="btn">
    </form>
</div>
<?php include_once "inc/footer.inc.php"?>
