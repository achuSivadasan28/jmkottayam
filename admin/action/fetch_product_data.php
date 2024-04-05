<?php
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
include_once '../../_class/query.php';
$obj = new query();
$product_name = $_POST['product_name'];
$response_arr = array();
$select_data = $obj->selectData("id,price,category_id,product_name,discount,quantity","tbl_product","where product_name='$product_name'");
//echo $select_data;exit();
if(mysqli_num_rows($select_data)>0){
	while($select_data_row = mysqli_fetch_array($select_data)){
		if($select_data_row['price'] == ''){
			$product_price = 0;
		}else{
			$product_price = $select_data_row['price'];
		}

		if($select_data_row['quantity'] == ''){
			$product_price = 0;
		}else{
			$quantity = $select_data_row['quantity'];
		}
		$response_arr[0]['id'] = $select_data_row['id'];
		$response_arr[0]['product_name'] = $select_data_row['product_name'];
		$response_arr[0]['price'] = $product_price;
        $response_arr[0]['quantity'] =$quantity;
		$response_arr[0]['discount'] =$quantity;
		$response_arr[0]['discount_data'] = $select_data_row['discount'];
		$id=$select_data_row['category_id'];
		$category = $obj->selectData("id,category_name","tbl_category","where id='$id'");
		if(mysqli_num_rows($category)>0){
			while($category_row = mysqli_fetch_array($category)){
				$response_arr[0]['category_name'] = $category_row['category_name'];
			}
		}

	}
}
echo json_encode($response_arr);
?>