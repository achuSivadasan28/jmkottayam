<?php
header('Access-Control-Allow-Origin: *');
require_once '../_class/query.php';
$obj = new query();
header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"),true);
$api_val = $data['api'];
$product_id = $data['product_id'];
$Productnopill_id = $data['Productnopill_id'];
//$api_val = $_GET['api'];
$apival = md5('esight_offilne_appointment');
if($api_val == $apival){
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = "success";
	$check_stock = $obj->selectData("sum(quantity) as quantity","tbl_medicine_details","where product_id=$product_id");
	if(mysqli_num_rows($check_stock)>0){
		$check_stock_row = mysqli_fetch_array($check_stock);
		if($check_stock_row['quantity'] != null){
			if($check_stock_row['quantity'] <=0){
				$response_arr[0]['stock'] = 0;
			}else{
				$response_arr[0]['stock'] = 1;
			}
		}
	}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = "Autantication Error";
}
echo json_encode($response_arr);
?>