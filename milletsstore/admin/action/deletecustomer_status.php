<?php
include '../../_class/query.php';
$obj = new query();
$id=$_GET['id'];
$info=[
    'customer_status'=>0
];
$update_Data=$obj->updateData("tbl_customer",$info,"where id=$id");
echo 'deleted';

?>