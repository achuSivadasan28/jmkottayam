<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days1 = $_POST['date'];
$days = date("Y-m-d", strtotime($days1));
$search_val = $_POST['search_val'];
$product_id_arr = array();
$response_arr = array();
$total_income = 0;
$select_todays_report = $obj->selectData("tbl_productdetails.id,tbl_productdetails.customer_id,tbl_productdetails.product_id,tbl_productdetails.price,tbl_productdetails.discount,tbl_productdetails.no_quantity,tbl_productdetails.total_price","tbl_productdetails inner join tbl_customer on tbl_productdetails.customer_id = tbl_customer.id","where (tbl_customer.added_date='$days1' or tbl_customer.created_date='$days') and tbl_productdetails.status!=0 and tbl_customer.status!=0");
if(mysqli_num_rows($select_todays_report)>0){
	$x = 0;
	while($select_todays_report_row = mysqli_fetch_array($select_todays_report)){
		$product_id = $select_todays_report_row['product_id'];
		$price = $select_todays_report_row['price'];
		$discount = $select_todays_report_row['discount'];
		$quantity = $select_todays_report_row['no_quantity'];
		$total_price_all = $select_todays_report_row['total_price'];
		if(in_array($product_id,$product_id_arr)){
			$main_index = 0;
			$mult_arr_len = sizeof($response_arr);
			for($x1 = 0;$x1<$mult_arr_len;$x1++){
				$p_id = $response_arr[$x1]['product_id'];
				if($p_id == $product_id){
					$main_index = $x1;
					break;
				}
			}
			$total_quantity = $quantity+$response_arr[$main_index]['product_total_q'];
			$total_amt_details = $total_price_all;
			$total_price = $total_amt_details+$response_arr[$main_index]['product_total_price'];
			$total_income += $total_amt_details;
			$response_arr[$main_index]['product_total_q'] =  $total_quantity;
			$response_arr[$main_index]['product_total_price'] =  $total_price;
		}else{
			$select_product_name = $obj->selectData("product_name","tbl_product","where id=$product_id");
			if(mysqli_num_rows($select_product_name)>0){
				$select_product_name_row = mysqli_fetch_array($select_product_name);
				$response_arr[$x]['date'] = $days;
				$response_arr[$x]['product_id'] = $product_id;
				$response_arr[$x]['product_name'] = $select_product_name_row['product_name'];
				$response_arr[$x]['product_total_q'] =  $quantity;
				$total_amt_details = $total_price_all;
				$total_income += $total_amt_details;
				$response_arr[$x]['product_total_price'] =  $total_amt_details;
				}
			$x++;
			array_push($product_id_arr,$product_id);
		}
	}
}
$response_arr[0]['total_price'] = $total_income;

//total invoice
$select_all_total_invoice = $obj->selectData("count(id) as id","tbl_customer","where (tbl_customer.added_date='$days1' or tbl_customer.created_date='$days') and status!=0");
$select_all_total_invoice_row = mysqli_fetch_array($select_all_total_invoice);
if($select_all_total_invoice_row['id'] != null){
	$response_arr[0]['total_invoice'] = $select_all_total_invoice_row['id'];
}else{
	$response_arr[0]['total_invoice'] = 0;
}
echo json_encode($response_arr);
?>