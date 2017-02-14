<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/14
 * Time: 15:14
 */
include "inc/config.inc.php";
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
include "inc/page.inc.php";
$link=connect();
$member_id=is_login($link);
$is_manage_login=is_manage_login($link);
if (!isset($_GET['keyword'])){
    $_GET['keyword']='';
}
$_GET['keyword']=trim($_GET['keyword']);
$_GET['keyword']=escape($link,$_GET['keyword']);
$template['title']='搜索页';
$template['css']=array('style/public.css','style/list.css');
$query="select count(*) from sfk_content where title like '%{$_GET['keyword']}%'";
$count_all=num($link,$query);


?>

<?php include "inc/header.inc.php";?>
<div id="position" class="auto">
    <a>首页</a> &gt; 搜索页
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3>共有<?php echo $count_all?>条匹配的帖子</h3>
            <div class="pages_wrap">
                <div class="pages">
                    <?php
                    $result_page=page($count_all,5,3);
                    echo $result_page['html'];
                    ?>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">
            <?php
            $query="select sfk_content.member_id,sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo from sfk_content,sfk_member where sfk_content.title like '%{$_GET['keyword']}%' AND sfk_content.member_id=sfk_member.id {$result_page['limit']}";
            $result_content=execute($link,$query);
            while($data_content=mysqli_fetch_assoc($result_content)){
                $data_content['title']=htmlspecialchars($data_content['title']);
                $data_content['title_color']=str_replace($_GET['keyword'],"<span style='color:red'>{$_GET['keyword']}</span>",$data_content['title']);
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
                        <div class="titleWrap"><h2><a href="show.php?id=<?php echo $data_content['id']?>"><?php echo $data_content['title_color']?></a></h2></div>
                        <p>
                            楼主：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：<?php echo $last_time;?><br/>
                            <?php
                            if (check_user($member_id,$data_content['member_id'],$is_manage_login)){
                                $return_url=urlencode($_SERVER["REQUEST_URI"]);
                                $url=urlencode("content_delete.php?id={$data_content['id']}&return_url={$return_url}");
                                $message="你真的要删除帖子{$data_content['title']}吗？";
                                $delete_url="confirm.php?url={$url}&return_url={$return_url}&message={$message}";
                                echo "<a href='content_update.php?id={$data_content['id']}&return_url={$return_url}'>编辑</a> <a href='{$delete_url}'>删除</a>";
                            }
                            ?>
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

