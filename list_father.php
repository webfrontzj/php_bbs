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
    $list_son.="<a href='#'>{$data_son['module_name']}</a> ";
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
    <a href="index.php">首页</a> &gt; <a href="list_father.php?id=<?php echo $data_father['id']?>">NBA</a>
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
                    <a>« 上一页</a>
                    <a>1</a>
                    <span>2</span>
                    <a>3</a>
                    <a>4</a>
                    <a>...13</a>
                    <a>下一页 »</a>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
        <div style="clear:both;"></div>
        <ul class="postsList">
            <?php
                $query="select * from sfk_content where module_id in({$id_son})";
                $result_content=execute($link,$query);
                while($data_content=mysqli_fetch_assoc($result_content)){

                }
            ?>
            <li>
                <div class="smallPic">
                    <a href="#">
                        <img width="45" height="45"src="style/2374101_small.jpg">
                    </a>
                </div>
                <div class="subject">
                    <div class="titleWrap"><a href="#">[分类]</a>&nbsp;&nbsp;<h2><a href="#">我这篇帖子不错哦</a></h2></div>
                    <p>
                        楼主：孙胜利&nbsp;2014-12-08&nbsp;&nbsp;&nbsp;&nbsp;最后回复：2014-12-08
                    </p>
                </div>
                <div class="count">
                    <p>
                        回复<br /><span>41</span>
                    </p>
                    <p>
                        浏览<br /><span>896</span>
                    </p>
                </div>
                <div style="clear:both;"></div>
            </li>
        </ul>
        <div class="pages_wrap">
            <a class="btn publish" href=""></a>
            <div class="pages">
                <a>« 上一页</a>
                <a>1</a>
                <span>2</span>
                <a>3</a>
                <a>4</a>
                <a>...13</a>
                <a>下一页 »</a>
            </div>
            <div style="clear:both;"></div>
        </div>
    </div>
    <div id="right">
        <div class="classList">
            <div class="title">版块列表</div>
            <ul class="listWrap">
                <li>
                    <h2><a href="#">NBA</a></h2>
                    <ul>
                        <li><h3><a href="#">私房库</a></h3></li>
                        <li><h3><a href="#">私</a></h3></li>
                        <li><h3><a href="#">房</a></h3></li>
                    </ul>
                </li>
                <li>
                    <h2><a href="#">CBA</a></h2>
                </li>
            </ul>
        </div>
    </div>
    <div style="clear:both;"></div>
</div>
<?php include 'inc/footer.inc.php'?>
