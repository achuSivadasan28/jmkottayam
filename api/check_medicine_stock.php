<?php
header('Access-Control-Allow-Origin: *');
require_once '../_class/query.php';
$obj = new query();
header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"),true);
$api_val = $data['api'];
$product_id = $data['product_id'];
$Productnopill_id = $data['Productnopill_id'];
$quantiy = $data['quantity'];
//echo $product_id;
//echo $quantiy;
//$api_val = $_GET['api'];
$apival = md5('esight_offilne_appointment');
if($api_val == $apival){
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = "success";
	$check_stock = $obj->selectData("no_of_pills,quantity","tbl_medicine_details","where product_id=$product_id and status !=0 order  by quantity desc , no_of_pills desc ");
	//echo $check_stock;exit();
	if(mysqli_num_rows($check_stock)>0){
		$check_stock_row = mysqli_fetch_array($check_stock);
		$quantity = (int)$check_stock_row['quantity'] * (int)$check_stock_row['no_of_pills'];
		//echo"q".$quantity;exit();
		//echo $check_stock_row['quantity']."  ".$check_stock_row['no_of_pills'];exit();
		//if($quantity){
			//echo"q". $quantity;exit();
			if($quantity < $quantiy or (int)$quantity == 0){
				$response_arr[0]['stock'] = 0;
				$response_arr[0]['quantity'] = $check_stock_row['quantity'];
			}else{
				$response_arr[0]['stock'] = 1;
				$response_arr[0]['quantity'] = $quantity;
			}
		//}else{
			//echo"q". $quantity;exit();
		//}
	}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = "Autantication Error";
}
echo json_encode($response_arr);
?>