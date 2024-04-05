<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$recipt_id = $_POST['recipt_id'];
$response = array();
$select_customer_data = $obj->selectData("customer_name,invoice_no","tbl_customer","where id=$recipt_id");
if(mysqli_num_rows($select_customer_data)>0){
	while($select_customer_data_row = mysqli_fetch_array($select_customer_data)){
		$response[0]['customer_name'] = $select_customer_data_row['customer_name'];
		$response[0]['invoice_no'] = $select_customer_data_row['invoice_no'];
	}
}
echo json_encode($response);
?>