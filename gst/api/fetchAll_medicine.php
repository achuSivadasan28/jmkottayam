<?php
header('Access-Control-Allow-Origin: *');
require_once '../_class/query.php';
$obj = new query();
header("Content-Type: application/json; charset=UTF-8");
$data = json_decode(file_get_contents("php://input"),true);
$api_val = $data['api'];
//$api_val = $_GET['api'];
$apival = md5('esight_offilne_appointment');
if($api_val == $apival){
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = "success";
		$select_medicine_name = $obj->selectData("id,product_name,quantity","tbl_product","where status!=0");
	if(mysqli_num_rows($select_medicine_name)>0){
		$x = 0;
		while($select_medicine_name_row = mysqli_fetch_array($select_medicine_name)){
			$response_arr[$x]['product_name'] = $select_medicine_name_row['product_name'];
			$response_arr[$x]['product_id'] = $select_medicine_name_row['id'];
			if($select_medicine_name_row['quantity'] <= 0){
				$response_arr[$x]['stock'] = 0;
			}else{
				$response_arr[$x]['stock'] = 1;
			}
			$x++;
		}
	}
	
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = "Autantication Error";
}
echo json_encode($response_arr);
?>