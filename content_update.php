<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/5
 * Time: 9:23
 */
include_once "inc/config.inc.php";
include_once "inc/mysql.inc.php";
include_once "inc/tool.inc.php";
$link=connect();
$template['title']='帖子修改页';
$template['css']=array('style/public.css','style/publish.css');
if (!$member_id=is_login($link)){
    skip('index.php','error','没有登录！');
}
if (!isset($_GET['id'])||!is_numeric($_GET['id'])){
    skip('index.php','error','帖子id参数不合法！');
}
$query="select * from sfk_content where id={$_GET['id']}";
$result_content=execute($link,$query);
if (mysqli_num_rows($result_content)==1){
    $data_content=mysqli_fetch_assoc($result_content);
    if(check_user($member_id,$data_content['member_id'])){
        if (isset($_POST['submit'])){
            include "inc/check_publish.inc.php";
            $_POST=escape($link,$_POST);
            $query="update sfk_content set module_id={$_POST['module_id']},title='{$_POST['title']}',content='{$_POST['content']}' where id={$_GET['id']}";
            execute($link,$query);
            if (mysqli_affected_rows($link)==1){
                skip("member.php?id={$member_id}",'ok','发布成功！');
            }else{
                skip("member.php?id={$member_id}",'error','发布失败，请重试！');
            }
        }
    }else{
        skip('index.php','error','这个帖子不属于你，你没有权限');
    }
}else{
    skip('index.php','error','帖子不存在！');
}

?>
<?php include "inc/header.inc.php"?>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; 编辑帖子
</div>
<div id="publish">
    <form method="post">
        <select name="module_id">
            <?php
            $query="select * from sfk_father_module order by sort desc";
            $result_father=execute($link,$query);
            while($data_father=mysqli_fetch_assoc($result_father)){
                echo "<optgroup label='{$data_father['module_name']}'>";
                $query="select * from sfk_son_module where father_module_id={$data_father['id']} order by sort desc";
                $result_son=execute($link,$query);
                while ($data_son=mysqli_fetch_assoc($result_son)){
                    if (isset($data_content['module_id']) && $data_content['module_id']==$data_son['id']){
                        echo "<option selected value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                    }else{
                        echo "<option value='{$data_son['id']}'>{$data_son['module_name']}</option>";
                    }
                }
                echo "</optgroup>";
            }
            ?>
        </select>
        <input class="title" placeholder="请输入标题" name="title" type="text" value="<?php echo $data_content['title'];?>" />
        <textarea name="content" class="content">
            <?php echo $data_content['content'];?>
        </textarea>
        <input class="publish" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>
<?php include "inc/footer.inc.php"?>
