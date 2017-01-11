<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/10
 * Time: 15:42
 */
include_once "../inc/config.inc.php";
include_once "../inc/mysql.inc.php";
include_once "../inc/tool.inc.php";
$templates['title']='子版块添加页';
$templates['css']=array('style/public.css');
$link=connect();
if(isset($_POST["submit"])){
//    验证用户填写的信息
    $check_flag='add';
    include_once 'inc/check_son_module.inc.php';
    $query="insert into sfk_son_module(father_module_id,module_name,info,member_id,sort) values({$_POST['father_module_id']},'{$_POST['module_name']}','{$_POST['info']}',{$_POST['member_id']},{$_POST['sort']})";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('son_module.php','ok','恭喜你，添加成功！');
    }else{
        skip('son_module_add.php','error','对不起，添加失败，请重试！');
    }
}
?>
<?php include "inc/header.inc.php";?>
<div id="main">
    <div class="title" style="margin-bottom: 20px;">添加子版块</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>所属父版块</td>
                <td>
                    <select name="father_module_id">
                        <option value="0">==请选择一个父版块==</option>
                        <?php
                            $query="select * from sfk_father_module";
                            $result_father=execute($link,$query);
                            while($data=mysqli_fetch_assoc($result_father)){
                                echo "<option value='{$data["id"]}'>{$data['module_name']}</option>";
                            }
                        ?>
                    </select>
                </td>
                <td>必须选择一个所属父版块</td>
            </tr>
            <tr>
                <td>版块名称</td>
                <td><input type="text" name="module_name"></td>
                <td>板块名称不能为空，最大不能超过66个字</td>
            </tr>
            <tr>
                <td>板块简介</td>
                <td>
                    <textarea name="info" id="" cols="30" rows="10"></textarea>
                </td>
                <td>简介不得多于255个字符</td>
            </tr>
            <tr>
                <td>版主</td>
                <td>
                    <select name="member_id">
                        <option value="0">==请选择一个会员作为版主==</option>
                    </select>
                </td>
                <td>请选择一个会员作为版主</td>
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
<?php include "inc/footer.inc.php";?>
