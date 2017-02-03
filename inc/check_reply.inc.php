<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/3
 * Time: 18:02
 */
if (mb_strlen($_POST['content'])<3){
    skip($_SERVER['REQUEST_URI'],'error','对不起，回复内容不得少于3个字！');
}
?>