<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$status_name= $_POST['category'];
$address= $_POST['address'];
$gstNum= $_POST['gstNum'];
$phnNum= $_POST['phnNum'];
$info_user = array(
    "category_name" => $status_name,
	"address" => $address,
	"gstNum" => $gstNum,
	"phnNum" => $phnNum,
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