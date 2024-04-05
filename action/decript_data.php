<?php
require_once '../_class/query.php';
$obj=new query();
$response = array();
$customer_id = $_POST['customer_id'];
$dycript_id = base64_decode($customer_id);
$response[0]['dcy'] = $dycript_id;
$check_id = $obj->selectData("id","tbl_customer","where id=$dycript_id and status !=0");
if(mysqli_num_rows($check_id)>0){
	$response[0]['status'] = 1;
}else{
	$response[0]['status'] = 0;
}
echo json_encode($response);
?>