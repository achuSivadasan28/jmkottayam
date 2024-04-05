<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$status_name= $_POST['category'];
$info_user = array(
    "category_name" => $status_name,
    "added_date"=>$days,
    "time"=>$times,
    "status"=>1
);
if($obj->insertData("tbl_category",$info_user)){
    echo 1;
}else{
    echo 0;
}

?>