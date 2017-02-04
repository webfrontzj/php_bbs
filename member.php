<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/4
 * Time: 17:41
 */
include "inc/config.inc.php";
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
include "inc/page.inc.php";
$link=connect();
$template['title']='会员中心';
$template['css']=array('style/public.css','style/list.css','style/member.css');
$member_id=is_login($link);
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php','error','会员id不合法！');
}
$query="select * from sfk_member where id={$_GET['id']}";
$result_member=execute($link,$query);
if (mysqli_num_rows($result_member)!=1){
    skip('index.php','error','你所访问的会员不存在！');
}
$data_member=mysqli_fetch_assoc($result_member);
//帖子總數
$query="select count(*) from sfk_content where member_id={$_GET['id']}";
$count_all=num($link,$query);
?>
<?php include_once "inc/header.inc.php"?>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; <?php echo $data_member['name']?>
</div>
<div id="main" class="auto">
    <div id="left">
        <ul class="postsList">
            <?php
            $page=page($count_all,20);
            $query="select sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo from sfk_content,sfk_member where sfk_content.member_id={$_GET['id']} AND sfk_content.member_id=sfk_member.id {$page['limit']}";
            $result_content=execute($link,$query);
            while($data_content=mysqli_fetch_assoc($result_content)){
                $query="select time from sfk_reply where content_id={$data_content['id']} order by id desc limit 0,1";
                $data_content['title']=htmlspecialchars($data_content['title']);
                $result_last_reply=execute($link,$query);
                if (mysqli_num_rows($result_last_reply)==0){
                    $last_time='暂无';
                }else{
                    $data_last_reply=mysqli_fetch_assoc($result_last_reply);
                    $last_time=$data_last_reply['time'];
                }
            ?>
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45" src="<?php if ($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><h2><a href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
                    <p>
                        发帖日期：<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time;?>
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br />
                        <span>
                            <?php
                            $query="select count(*) from sfk_reply where content_id={$data_content['id']}";
                            echo num($link,$query);
                            ?>
                        </span>
                    </p>
                    <p>
                        浏览<br /><span><?php echo $data_content['times']?></span>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </li>
            <?php }?>
        </ul>
        <div class="pages">
            <?php echo $page['html'];?>
        </div>
    </div>
    <div id="right">
        <div class="member_big">
            <dl>
                <dt>
                    <img width="180" height="180" src="<?php if ($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
                </dt>
                <dd class="name"><?php echo $data_member['name'];?></dd>
                <dd>帖子总计：<?php echo $count_all;?></dd>
                <!--<dd>操作：<a target="_blank" href="">修改头像</a> | <a target="_blank" href="">修改密码</a></dd>-->
            </dl>
            <div style="clear:both;"></div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<?php include_once "inc/footer.inc.php"?>
