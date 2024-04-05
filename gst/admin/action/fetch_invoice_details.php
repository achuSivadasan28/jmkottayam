<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$invoice_id = $_POST['url_val'];
$response_arr = array();
$select_customer_details = $obj->selectData("id,customer_name,phone,place,total_price,total_discount,total_amonut","tbl_customer","where id=$invoice_id");
if(mysqli_num_rows($select_customer_details)>0){
	while($select_customer_details_row = mysqli_fetch_array($select_customer_details)){
		$id = $select_customer_details_row['id'];
		$customer_name = $select_customer_details_row['customer_name'];
		$phone = $select_customer_details_row['phone'];
		$place = $select_customer_details_row['place'];
		$total_price = $select_customer_details_row['total_price'];
		$total_discount = $select_customer_details_row['total_discount'];
		$total_amonut = $select_customer_details_row['total_amonut'];
		$response_arr[0]['customer_name'] = $customer_name;
		$response_arr[0]['phone'] = $phone;
		$response_arr[0]['place'] = $place;
		$response_arr[0]['total_price'] = $total_price;
		$response_arr[0]['total_discount'] = $total_discount;
		$response_arr[0]['total_amonut'] = $total_amonut;
		$select_all_products = $obj->selectData("id,product_name,discount,no_quantity,price,total_price,product_id","tbl_productdetails","where customer_id=$invoice_id and status !=0");
		if(mysqli_num_rows($select_all_products)>0){
			$x = 0;
			while($select_all_products_row = mysqli_fetch_array($select_all_products)){
				$response_arr[0]['product_details'][$x]['p_d_id'] = $select_all_products_row['id'];
				$response_arr[0]['product_details'][$x]['product_name'] = $select_all_products_row['product_name'];
				$response_arr[0]['product_details'][$x]['discount'] = $select_all_products_row['discount'];
				$response_arr[0]['product_details'][$x]['no_quantity'] = $select_all_products_row['no_quantity'];
				$response_arr[0]['product_details'][$x]['price'] = $select_all_products_row['price'];
				$response_arr[0]['product_details'][$x]['total_price'] = $select_all_products_row['total_price'];
				$response_arr[0]['product_details'][$x]['product_id'] = $select_all_products_row['product_id'];
				$x++;
			}
		}
	}
}
echo json_encode($response_arr);
?>