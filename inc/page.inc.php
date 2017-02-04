<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/1/23
 * Time: 17:35
 */

/**
参数说明：
$count:总记录数
$page_size:煤业显示的记录数
$num_btn：要展示的页码按钮数目
$page：分页的get参数名称
 */
function page($count,$page_size,$num_btn=10,$page_name='page'){
    if (!isset($_GET[$page_name]) || !is_numeric($_GET[$page_name]) || $_GET[$page_name]<1){
        $_GET[$page_name]=1;
    }
    if ($count==0){
        $data=array(
            'limit'=>'',
            'html'=>''
        );
        return $data;
    }
//    总页数
    $page_count_all=ceil($count/$page_size);
    if($_GET[$page_name]>$page_count_all){
        $_GET[$page_name]=$page_count_all;
    }
    $start=($_GET[$page_name]-1)*$page_size;
    $limit="limit {$start},{$page_size}";
    $current_url=$_SERVER['REQUEST_URI'];
    $arr_current=parse_url($current_url);
    $current_path=$arr_current['path'];
    $url='';
    if (isset($arr_current['query'])){
        parse_str($arr_current['query'],$arr_query);
        unset($arr_query[$page_name]);
        if (empty($arr_query)){
            $url="{$current_path}?{$page_name}=";
            var_dump($arr_query);exit();
        }else{
            $other=http_build_query($arr_query);
            $url="{$current_path}?{$other}&{$page_name}=";
        }
    }else{
        $url="{$current_path}?{$page_name}=";
    }
    $html=array();
    if ($num_btn>=$page_count_all){
        for($i=1;$i<=$page_count_all;$i++){
            if ($_GET[$page_name]==$i){
                $html[$i]="<span>{$i}</span>";
            }else{
                $html[$i]="<a href='{$url}{$i}'>{$i}</a>";
            }
        }
    }else{
        $num_left=floor(($num_btn-1)/2);
        $start=$_GET[$page_name]-$num_left;
        $end=$start+($num_btn-1);
        if($start<1){
            $start=1;
        }
        if($end>$page_count_all){
            $start=$page_count_all-($num_btn-1);
        }
        for($i=0;$i<$num_btn;$i++){
            if ($_GET[$page_name]==$start){
                $html[$start]="<span>{$start}</span>";
            }else{
                $html[$start]="<a href='{$url}{$start}'>{$start}</a>";
            }
            $start++;
        }
        if(count($html)>=3){
            reset($html);
            $key_first=key($html);
            end($html);
            $key_end=key($html);
            if ($key_first!=1){
                array_shift($html);
                array_unshift($html,"<a href='{$url}1'>1...</a>");
            }
            if ($key_end!=$page_count_all){
                array_pop($html);
                array_push($html,"<a href='{$url}{$page_count_all}'>...{$page_count_all}</a>");
            }
        }
    }
    if ($_GET[$page_name]!=1){
        $prev=$_GET[$page_name]-1;
        array_unshift($html,"<a href='{$url}{$prev}'><< 上一页</a>");
    }
    if ($_GET[$page_name]!=$page_count_all){
        $next=$_GET[$page_name]+1;
        array_push($html,"<a href='{$url}{$next}'>下一页 >></a>");
    }
    $html=implode(' ',$html);
    $data=array(
        'limit'=>$limit,
        'html'=>$html
    );
    return $data;
}
?>