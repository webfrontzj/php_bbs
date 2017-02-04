<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/4
 * Time: 11:11
 */
include 'inc/config.inc.php';
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
$template['title']="引用回复页";
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
$data_content=mysqli_fetch_assoc($result_content);
$data_content['title']=htmlspecialchars($data_content['title']);

if (!isset($_GET['reply_id']) || !is_numeric($_GET['reply_id'])){
    skip('index.php','error','你要引用的回复id不合法！');
}
$query="select sfk_reply.content,sfk_member.name from sfk_reply,sfk_member where sfk_reply.id={$_GET['reply_id']} and sfk_reply.content_id={$_GET['id']} and sfk_reply.member_id=sfk_member.id";
$result_reply=execute($link,$query);
$data_reply=mysqli_fetch_assoc($result_reply);
$data_reply['content']=nl2br(htmlspecialchars($data_reply['content']));
if (mysqli_num_rows($result_reply)!=1){
    skip('index.php','error','您要引用的回复不存在！');
}
if (isset($_POST['submit'])){
    include_once "inc/check_reply.inc.php";
    $_POST=escape($link,$_POST);
    $query="insert into sfk_reply(content_id,quote_id,content,time,member_id) values({$_GET['id']},{$_GET['reply_id']},'{$_POST['content']}',now(),$member_id)";
    execute($link,$query);
    if (mysqli_affected_rows($link)==1){
        skip("show.php?id={$_GET['id']}",'ok','回复成功！');
    }else{
        skip($_SERVER['REQUEST_URI'],'error','回复失败，请重试！');
    }
}
//算出是引用的几楼的回复
$query="select count(*) from sfk_reply where content_id={$_GET['id']} and id<={$_GET['reply_id']}";
$floor=num($link,$query);
?>

<?php include_once "inc/header.inc.php"?>

<!--<div id="position" class="auto">-->
<!--    <a>首页</a> &gt; <a>NBA</a> &gt; <a>私房库</a> &gt; 的青蛙地区稳定期望-->
<!--</div>-->
<div id="publish">
    <div><?php echo $data_content['name']?>: <?php echo $data_content['title']?></div>
    <div class="quote">
        <p class="title">引用<?php echo $floor;?>楼 <?php echo $data_reply['name']?> 发表的: </p>
        <?php echo $data_reply['content']?>
    </div>
    <form method="post">
        <textarea name="content" class="content"></textarea>
        <input class="reply" type="submit" name="submit" value="" />
        <div style="clear:both;"></div>
    </form>
</div>
<?php include_once "inc/footer.inc.php"?>
