<?php
/**
 * Created by PhpStorm.
 * User: web
 * Date: 2017/2/7
 * Time: 17:43
 */

function upload($save_path,$custom_upload_max_filesize,$key,$type=array('jpg','jpeg','gif','png')){
    $return_data=array();
//    获取php配置文件中最大文件上传大小的设置
    $phpini=ini_get('upload_max_filesize');
//    获取配置文件中设置的最大大小的单位
    $phpini_unit=strtoupper(substr($phpini,-1));
//    获取配置文件中设置的最大大小的值
    $phpini_number=substr($phpini,0,-1);
//    switch出配置单位相对于字节的倍数
    $phpini_multiple=get_multiple($phpini_unit);
//    计算出以字节为单位的大小值
    $phpini_bytes=$phpini_number*$phpini_multiple;
//    获取程序设置的最大大小的单位
    $custom_unit=strtoupper(substr($custom_upload_max_filesize,-1));
//    获取程序设置的最大大小
    $custom_number=substr($custom_upload_max_filesize,0,-1);
//    switch出配置单位相对于字节的倍数
    $custom_multiple=get_multiple($custom_unit);
//    计算出一字节为单位的大小值
    $custom_bytes=$custom_number*$custom_multiple;
//检查程序设置的最大值是否比php配置文件的最大值大
    if ($custom_bytes>$phpini_bytes){
        $return_data['error']='传入的$custom_upload_max_filesize大于php配置文件里的'.$phpini;
        $return_data['return']=false;
        return $return_data;
    }
//    定义错误信息数组
    $arr_errors=array(
        1=>'上传的文件超过了php.ini的设置',
        2=>'上传文件的大小超过了html表单中max_file_size的指定值',
        3=>'文件只有部分被上传',
        4=>'没有文件被上传',
        6=>'找不到临时文件夹',
        7=>'文件写入失败'
    );
//    没有error字段的定义说明文件上传失败，但不知道是什么原因
    if (!isset($_FILES[$key]['error'])){
        $return_data['error']='由于未知原因导致上传失败，请重试！';
        $return_data['return']=false;
        return $return_data;
    }
//    当error代码不为0说明出错了，根据定义的错误信息数组输出错误信息
    if ($_FILES[$key]['error']!=0){
        $return_data['error']=$arr_errors[$_FILES[$key]['error']];
        $return_data['return']=false;
        return $return_data;
    }
//    判断上传文件是否是通过post方式上传的
    if (!is_uploaded_file($_FILES[$key]['tmp_name'])){
        $return_data['error']='你上传的文件不是通过HTTP POST方式上传的！';
        $return_data['return']=false;
        return $return_data;
    }
//检测上传文件的大小是否符合程序要求
    if ($_FILES[$key]['size']>$custom_bytes){
        $return_data['error']='上传文件的大小超过了程序作者限定的'.$custom_upload_max_filesize;
        $return_data['return']=false;
        return $return_data;
    }
//    获取上传文件的后缀名
    $arr_filename=pathinfo($_FILES[$key]['name']);
    if (!isset($arr_filename['extension'])){
        $arr_filename['extension']='';
    }
//    检测上传文件的扩展名是不是在规定内
    if (!in_array($arr_filename['extension'],$type)){
        $return_data['error']='上传文件的类型必须是'.implode(',',$type).'其中的一种';
        $return_data['return']=false;
        return $return_data;
    }
//    检测输入的存储目录是否存在，如果不存在就创建
    if (!file_exists($save_path)){
        if (!mkdir($save_path,0777,true)){
            $return_data['error']='上传文件保存目录创建失败，请检查权限';
            $return_data['return']=false;
            return $return_data;
        }
    }
//    通过uniqid和mt_rand生成独一无二的文件名
    $new_filename=str_replace('.','',uniqid(mt_rand(1000,9999),true));
//    如果上传的文件有扩展名，就将扩展名拼接至新生成的独一无二的文件名
    if ($arr_filename['extension']!=''){
        $new_filename.=".{$arr_filename['extension']}";
    }
//    确保保存路径末尾有“/”
    $save_path=rtrim($save_path,'/').'/';
//    将上传的文件移动到指定的路径下并重命名
    if (!move_uploaded_file($_FILES[$key]['tmp_name'],$save_path.$new_filename)){
        $return_data['error']='临时文件移动失败，请检查权限';
        $return_data['return']=false;
        return $return_data;
    }
//    程序走到这里代表上传成功，返回应该返回的信息
    $return_data['save_path']=$save_path.$new_filename;
    $return_data['filename']=$new_filename;
    $return_data['return']=true;
    return $return_data;
}
function get_multiple($unit){
    switch ($unit){
        case 'K':
            $multiple=1024;
            return $multiple;
        case 'M':
            $multiple=1024*1024;
            return $multiple;
        case 'G':
            $multiple=1024*1024*1024;
            return $multiple;
    }
}
?>