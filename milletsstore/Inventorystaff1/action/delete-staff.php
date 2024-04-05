<?php
include '../../_class/query.php';
$obj = new query();
$id=$_GET['id'];
$info=[
    'status'=>0
];
$update_Data=$obj->updateData("tbl_staff",$info,"where id=$id");
$info1=[
    'status'=>0
];
$update=$obj->updateData("tbl_login",$info1,"where staff_log_id=$id");
echo "1";

?>