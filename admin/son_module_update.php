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
$templates['title']='子版块修改页';
$templates['css']=array('style/public.css');
$link=connect();
if (!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('son_module.php','error','id参数错误！');
}
$query="select * from sfk_son_module where id={$_GET['id']}";
$result=execute($link,$query);
if (!mysqli_num_rows($result)){
    skip('son_module.php','error','这条子版块信息不存在！');
}
$data=mysqli_fetch_assoc($result);
if(isset($_POST['submit'])){
    $check_flag='update';
    include "inc/check_son_module.inc.php";
    $query="update sfk_son_module set father_module_id={$_POST['father_module_id']},module_name='{$_POST['module_name']}',info='{$_POST['info']}',member_id={$_POST['member_id']},sort={$_POST['sort']} where id={$_GET['id']}";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('son_module.php','ok','修改成功!');
    }else{
        skip('son_module.php','error','修改失败，请重试！');
    }
}
?>
<?php include "inc/header.inc.php";?>
<div id="main">
    <div class="title" style="margin-bottom: 20px;">修改子版块-<?php echo $data['module_name']?></div>
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
                            while($data_father=mysqli_fetch_assoc($result_father)){
                                if ($data['father_module_id']==$data_father['id']){
                                    echo "<option selected value='{$data_father["id"]}'>{$data_father['module_name']}</option>";
                                }else{
                                    echo "<option value='{$data_father["id"]}'>{$data_father['module_name']}</option>";
                                }
                            }
                        ?>
                    </select>
                </td>
                <td>必须选择一个所属父版块</td>
            </tr>
            <tr>
                <td>版块名称</td>
                <td><input type="text" value="<?php echo $data['module_name']?>" name="module_name"></td>
                <td>板块名称不能为空，最大不能超过66个字</td>
            </tr>
            <tr>
                <td>板块简介</td>
                <td>
                    <textarea name="info" id="" cols="30" rows="10"><?php echo $data['info']?></textarea>
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
                <td><input type="text" value="<?php echo $data['sort']?>" name="sort"></td>
                <td>填写一个数字即可</td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" type="submit" name="submit" value="修改" class="btn">
    </form>
</div>
<?php include "inc/footer.inc.php";?>
