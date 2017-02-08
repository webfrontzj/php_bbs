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
            $query="select sfk_content.member_id,sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo from sfk_content,sfk_member where sfk_content.member_id={$_GET['id']} AND sfk_content.member_id=sfk_member.id {$page['limit']}";
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
                    <img width="45" height="45" src="<?php if ($data_content['photo']!=''){echo $data_content['photo'];}else{echo 'style/photo.jpg';}?>" />
                </div>
                <div class="subject">
                    <div class="titleWrap"><h2><a href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
                    <p>
                        <?php
                            if (check_user($member_id,$data_content['member_id'])){
                                $url=urlencode("content_delete.php?id={$data_content['id']}");
                                $return_url=urlencode($_SERVER["REQUEST_URI"]);
                                $message="你真的要删除帖子{$data_content['title']}吗？";
                                $delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
                                echo "<a href='content_update.php?id={$data_content['id']}'>编辑</a> <a href='{$delete_url}'>删除</a>";
                            }
                        ?>
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
                    <img width="180" height="180" src="<?php if ($data_member['photo']!=''){echo SUB_URL.$data_member['photo'];}else{echo 'style/photo.jpg';}?>" />
                </dt>
                <dd class="name"><?php echo $data_member['name'];?></dd>
                <dd>帖子总计：<?php echo $count_all;?></dd>
                <?php
                    if($member_id==$data_member['id']){
                ?>
                <dd>操作：<a target="_blank" href="member_photo_update.php">修改头像</a> | <a target="_blank" href="">修改密码</a></dd>
                <?php }?>
            </dl>
            <div style="clear:both;"></div>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<?php include_once "inc/footer.inc.php"?>
