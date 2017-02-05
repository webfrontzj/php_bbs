<?php
function upload($custom_upload_max_filesize){
    $return_data=array();
    $phpini=ini_get('upload_max_filesize');
    $phpini_unit=strtoupper(substr($phpini,-1));
    $phpini_number=substr($phpini,0,-1);
    $phpini_multiple=get_multiple($phpini_unit);
    $phpini_bytes=$phpini_number*$phpini_multiple;
    $custom_unit=strtoupper(substr($custom_upload_max_filesize,-1));
    $custom_number=substr($custom_upload_max_filesize,0,-1);
    $custom_multiple=get_multiple($custom_unit);
    $custom_bytes=$custom_number*$custom_multiple;

    if ($custom_bytes>$phpini_bytes){
        $return_data['error']='传入的$custom_upload_max_filesize大于php配置文件里的'.$phpini;
        $return_data['return']=false;
        return $return_data;
    }

    $arr_errors=array(
        1=>'上传的文件超过了php.ini的设置',
        2=>'上传文件的大小超过了html表单中max_file_size的指定值',
        3=>'文件只有部分被上传',
        4=>'没有文件被上传',
        6=>'找不到临时文件夹',
        7=>'文件写入失败'
    );
    if (!isset($_FILES['error'])){
        $return_data['error']='由于未知原因导致$_file["error"]不存在，上传失败，请重试！';
        $return_data['return']=false;
        return $return_data;
    }
    if ($_FILES['error']!=0){
        $return_data['error']=$arr_errors[$_FILES['error']];
        $return_data['return']=false;
        return $return_data;
    }
    var_dump($_FILES);
    $return_data['return']=true;
    return $return_data;
}
upload('2M');
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
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="myfile">
    <input type="submit" name="submit">
</form>
