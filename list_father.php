<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/21
 * Time: 16:52
 */
include "inc/config.inc.php";
include "inc/mysql.inc.php";
include "inc/tool.inc.php";
include "inc/page.inc.php";
$template['title']='父版块列表页';
$template['css']=array('style/public.css','style/list.css');
$link=connect();
$member_id=is_login($link);
if (!isset($_GET['id']) || !is_numeric($_GET['id'])){
    skip('index.php','error','父版块ID不合法！');
}
$query="select * from sfk_father_module where id={$_GET['id']}";
$result_father=execute($link,$query);
if(mysqli_num_rows($result_father)==0){
    skip('index.php','error','父版块不存在！');
}
$data_father=mysqli_fetch_assoc($result_father);

$query="select * from sfk_son_module where father_module_id={$_GET['id']}";
$result_son=execute($link,$query);
$id_son="";
$list_son="";
while($data_son=mysqli_fetch_assoc($result_son)){
    $id_son.=$data_son['id'].',';
    $list_son.="<a href='list_son.php?id={$data_son['id']}'>{$data_son['module_name']}</a> ";
}
$id_son=trim($id_son,',');
if($id_son==''){
    $id_son=0;
}
$query="select count(*) from sfk_content where module_id in({$id_son})";
$count_all=num($link,$query);
$query="select count(*) from sfk_content where module_id in({$id_son}) and time > CURDATE()";
$count_today=num($link,$query);
?>
<?php include 'inc/header.inc.php'?>
<div id="position" class="auto">
    <a href="index.php">首页</a> &gt; <?php echo $data_father['module_name']?>
</div>
<div id="main" class="auto">
    <div id="left">
        <div class="box_wrap">
            <h3><?php echo $data_father['module_name'];?></h3>
            <div class="num">
                今日：<span><?php echo $count_today?></span>&nbsp;&nbsp;&nbsp;
                总帖：<span><?php echo $count_all?></span>
                <div class="moderator"> 子版块： <?php echo $list_son?></div>
            </div>
            <div class="pages_wrap">
                <a class="btn publish" href=""></a>
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
                $query="select sfk_content.title,sfk_content.id,sfk_content.time,sfk_content.times,sfk_member.name,sfk_member.photo,sfk_son_module.module_name from sfk_content,sfk_member,sfk_son_module where sfk_content.module_id in({$id_son}) AND sfk_content.member_id=sfk_member.id AND sfk_content.module_id=sfk_son_module.id {$result_page['limit']}";
                $result_content=execute($link,$query);
                while($data_content=mysqli_fetch_assoc($result_content)){
            ?>
                <li>
                    <div class="smallPic">
                        <a href="#">
                            <img width="45" height="45"src="<?php if ($data_content['photo']!=''){echo $data_content['photo'];}else{echo "style/photo.jpg";}?>">
                        </a>
                    </div>
                    <div class="subject">
                        <div class="titleWrap"><a href="#">[<?php echo $data_content['module_name']?>]</a>&nbsp;&nbsp;<h2><a href="#"><?php echo $data_content['title']?></a></h2></div>
                        <p>
                            楼主：<?php echo $data_content['name']?>&nbsp;<?php echo $data_content['time']?>&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
                        </p>
                    </div>
                    <div class="count">
                        <p>
                            回复<br /><span>41</span>
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
            <a class="btn publish" href=""></a>
            <div class="pages">
                <?php echo $result_page['html']?>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <?php include "inc/list_right.inc.php"?>
    <div style="clear:both;"></div>
</div>
<?php include 'inc/footer.inc.php'?>
