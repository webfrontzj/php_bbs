<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/24
 * Time: 17:06
 */
include "inc/config.inc.php";
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
include "inc/page.inc.php";
$template['title']='子版块列表页';
$template['css']=array('style/public.css','style/list.css');
$link=connect();
$member_id=is_login($link);
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php','error','子版块id不合法！');
}
$query="select * from sfk_son_module where id={$_GET['id']}";
$result_son=execute($link,$query);
if (mysqli_num_rows($result_son)!=1){
    skip('index.php','error','子版块不存在！');
}
$data_son=mysqli_fetch_assoc($result_son);
$query="select count(*) from sfk_content where module_id={$_GET['id']}";
$count_all=num($link,$query);
$query="select count(*) from sfk_content where module_id={$_GET['id']} and time>CURDATE()";
$count_today=num($link,$query);
$query="select * from sfk_member where id={$data_son['member_id']}";
$result_member=execute($link,$query);
?>
<?php include "inc/header.inc.php";?>
<div id="position" class="auto">
    <?php
        $query="select * from sfk_father_module where id={$data_son['father_module_id']}";
        $result_father=execute($link,$query);
        $data_father=mysqli_fetch_assoc($result_father);
    ?>
    <a>首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>"><?php echo $data_father['module_name']?></a> &gt; <?php echo $data_son['module_name']?>
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3><?php echo $data_son['module_name']?></h3>
            <div class="num">
                今日：<span>7</span>&nbsp;&nbsp;&nbsp;
                总帖：<span>158061</span>
            </div>
            <div class="moderator">版主：
                <span>
                    <?php
                        if (mysqli_num_rows($result_member)==0){
                            echo '暂无版主';
                        }else{
                            $data_member=mysqli_fetch_assoc($result_member);
                            echo $data_member['name'];
                        }
                    ?>
                </span>
            </div>
            <div class="notice"><?php echo $data_son['info']?></div>
            <div class="pages_wrap">
                <a class="btn publish" href="publish.php?son_module_id=<?php echo $_GET['id']?>"></a>
                <div class="pages">
                    <?php
                    $result_page=page($count_all,1,3);
                    echo $result_page['html'];
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">
            <?php
            $query="select sfk_content.member_id,sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo from sfk_content,sfk_member where sfk_content.module_id={$_GET['id']} AND sfk_content.member_id=sfk_member.id {$result_page['limit']}";
            $result_content=execute($link,$query);
            while($data_content=mysqli_fetch_assoc($result_content)){
            $data_content['title']=htmlspecialchars($data_content['title']);
            $query="select time from sfk_reply where content_id={$data_content['id']} order by id desc limit 0,1";
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
                        <a href="member.php?id=<?php echo $data_content['member_id'];?>">
                            <img width="45" height="45"src="<?php if ($data_content['photo']!=''){echo SUB_URL.$data_content['photo'];}else{echo "style/photo.jpg";}?>">
                        </a>
                    </div>
                    <div class="subject">
                        <div class="titleWrap"><h2><a href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title']?></a></h2></div>
                        <p>
                            楼主：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time;?>
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
        <div class="pages_wrap">
            <a class="btn publish" href="publish.php?son_module_id=<?php echo $_GET['id']?>"></a>
            <div class="pages">
                <?php echo $result_page['html'];?>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <?php include "inc/list_right.inc.php"?>
    <div style="clear:both;"></div>
</div>
<?php include "inc/footer.inc.php";?>
