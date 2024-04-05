<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
$product_id = $_POST['product_id'];
$response_arr = array();
$select_product_data = $obj->selectData("id,no_of_pills,expiry_date","tbl_medicine_details","where product_id=$product_id and status!=0 and quantity!=0");
if(mysqli_num_rows($select_product_data)>0){
	$x = 0;
	$response_arr[0]['status'] = 1;
	while($select_product_data_row = mysqli_fetch_array($select_product_data)){
		$response_arr[$x]['id'] = $select_product_data_row['id'];
		$response_arr[$x]['no_of_pills'] = $select_product_data_row['no_of_pills'];
		$exp_date = date_create($select_product_data_row['expiry_date']);
		$response_arr[$x]['expiry_date'] = date_format($exp_date,"d-m-Y");
		$x++;
	}
}else{
	$response_arr[0]['status'] = 0;
}
echo json_encode($response_arr);
?>