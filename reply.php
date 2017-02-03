<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/3
 * Time: 17:22
 */
include 'inc/config.inc.php';
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
$template['title']="帖子回复页";
$template['css']=array('style/public.css','style/publish.css');
$link=connect();
if (!$member_id=is_login($link)){
    skip('login.php','error','请先登录,再回复！');
}
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php','error','您要回复的帖子id参数不合法！');
}
$query="select sc.id,sc.title,sm.name from sfk_content sc,sfk_member sm where sc.id={$_GET['id']} and sc.member_id=sm.id";
$result_content=execute($link,$query);
if (mysqli_num_rows($result_content)!=1){
    skip('index.php','error','您要回复的帖子不存在！');
}

if (isset($_POST['submit'])){
    include "inc/check_reply.inc.php";
    $_POST=escape($link,$_POST);
    $query="insert into sfk_reply(content_id,content,time,member_id) VALUES({$_GET['id']},'{$_POST['content']}',now(),$member_id)";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip("show.php?id={$_GET['id']}",'ok','回复成功！');
    }else{
        skip($_SERVER['REQUEST_URI'],'error','回复失败，请重试！');
    }
}
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);

?>
<?php include_once "inc/header.inc.php"?>
<div id="position" class="auto">
    <a>首页</a> &gt; 回复帖子
</div>
<div id="publish">
    <div>回复：由 <?php echo $data_content['name']?> 发布的 <?php echo $data_content['title']?></div>
    <form method="post">
        <textarea name="content" class="content"></textarea>
        <input class="reply" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>
<?php include_once "inc/footer.inc.php"?>
