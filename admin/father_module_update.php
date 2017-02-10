<?php
    include '../inc/config.inc.php';
    include '../inc/mysql.inc.php';
    include '../inc/tool.inc.php';
    $templates['title']='父版块-修改';
    $templates['css']=array('style/public.css');
    $link=connect();
    include "inc/is_manage_login.inc.php";
    if(!isset($_GET['id']) || !is_numeric($_GET['id'])){
        skip('father_module.php','error','id参数错误!');
    }
    $query="select * from sfk_father_module where id={$_GET['id']}";
    $result=execute($link,$query);
    if(!mysqli_num_rows($result)){
        skip('father_module.php','error','这条板块信息不存在');
    }
    if(isset($_POST['submit'])){
        $check_flag='update';
        include "inc/check_father_module.inc.php";
        $query="update sfk_father_module set module_name='{$_POST['module_name']}',sort={$_POST['sort']} where id={$_GET['id']}";
        execute($link,$query);
        if(mysqli_affected_rows($link)==1){
            skip('father_module.php','ok','修改成功！');
        }else{
            skip('father_module.php','error','修改失败！');
        }
    }
    $data=mysqli_fetch_assoc($result);
?>
<?php include_once 'inc/header.inc.php'?>
<div id="main">
    <div class="title" style="margin-bottom: 20px;">修改父版块-<?php echo $data['module_name']?></div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name" value="<?php echo $data['module_name']?>"></td>
                <td>板块名称不能为空，最大不能超过66个字</td>
            </tr>
            <tr>
                <td>排序</td>
                <td><input type="text" name="sort" value="<?php echo $data['sort']?>"></td>
                <td>填写一个数字即可</td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" type="submit" name="submit" value="修改" class="btn">
    </form>
</div>
<?php include "inc/footer.inc.php";?>
