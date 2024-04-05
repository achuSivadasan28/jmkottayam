<?php
include '../../_class/query.php';
$obj = new query();
$id=$_GET['id'];
$info=[
    'status'=>0
];
$update_Data=$obj->updateData("tbl_product",$info,"where id=$id");
echo "1";

?>