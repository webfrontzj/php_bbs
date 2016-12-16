<?php
include_once '../inc/config.inc.php';
include_once '../inc/mysql.inc.php';
$link=connect();

$a=<<<START
dw'qd'wq"dqw"dwq''dwq
START;
$a=mysqli_real_escape_string($link,$a);
$query="insert into sfk_father_module(module_name) values('{$a}')";
var_dump(execute($link,$query));
?>