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
$templates['title']='站点设置';
$templates['css']=array('style/public.css');
$link=connect();
$query="select * from sfk_info where id=1";
$result_info=execute($link,$query);
$data_info=mysqli_fetch_assoc($result_info);

if(isset($_POST["submit"])){
    $_POST=escape($link,$_POST);
    $query="update sfk_info set title='{$_POST['title']}',keywords='{$_POST['keywords']}',description='{'description'}'";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip('web_set.php','ok','修改成功！');
    }else{
        skip('web_set.php','error','修改失败！请重试');
    }
}
?>
<?php include "inc/header.inc.php";?>
<div id="main">
    <div class="title" style="margin-bottom: 20px;">网站设置</div>
    <form action="" method="post">
        <table class="au">
            <tr>
                <td>网站标题</td>
                <td><input type="text" name="title" value="<?php echo $data_info['title']?>"></td>
                <td>就是前台页面的title里面的标题</td>
            </tr>
            <tr>
                <td>关键字</td>
                <td><input type="text" name="keywords" value="<?php echo $data_info['keywords']?>"></td>
                <td>关键字keyword</td>
            </tr>
            <tr>
                <td>描述</td>
                <td>
                    <textarea name="description" id="" cols="30" rows="10"><?php echo $data_info['description']?></textarea>
                </td>
                <td>描述</td>
            </tr>
        </table>
        <input style="margin-top: 20px;cursor: pointer" type="submit" name="submit" value="设置" class="btn">
    </form>
</div>
<?php include "inc/footer.inc.php";?>
