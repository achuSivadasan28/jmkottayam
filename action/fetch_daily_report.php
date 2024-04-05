<?php
$connect=mysqli_connect("localhost","johnmarians_2","qh0o4Z&0","db_johnmarians_2");
date_default_timezone_set('Asia/Kolkata');
$days = date('d-m-Y');
$search_val = $_POST['search_val'];
$product_id_arr = array();
$response_arr = array();
$total_income = 0;
$select_todays_report = "SELECT id,customer_id,product_id,price,discount,no_quantity,total_price from tbl_productdetails where added_date='$days' and status!=0";
$select_todays_report_exe = mysqli_query($connect,$select_todays_report);
if(mysqli_num_rows($select_todays_report_exe)>0){
	$x = 0;
	while($select_todays_report_exe_row = mysqli_fetch_array($select_todays_report_exe)){
		$product_id = $select_todays_report_exe_row['product_id'];
		$price = $select_todays_report_exe_row['price'];
		$discount = $select_todays_report_exe_row['discount'];
		$quantity = $select_todays_report_exe_row['no_quantity'];
		$total_price_all = $select_todays_report_exe_row['total_price'];
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
			$select_product_name = "Select product_name from tbl_product where id=$product_id";
			$select_product_name_exe = mysqli_query($connect,$select_product_name);
			if(mysqli_num_rows($select_product_name_exe)>0){
				$select_product_name_exe_row = mysqli_fetch_array($select_product_name_exe);
				$response_arr[$x]['date'] = $days;
				$response_arr[$x]['product_id'] = $product_id;
				$response_arr[$x]['product_name'] = $select_product_name_exe_row['product_name'];
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
$select_all_total_invoice = "SELECT count(id) as id from tbl_customer where created_date='$days' and status!=0";
$select_all_total_invoice_exe = mysqli_query($connect,$select_all_total_invoice);
$select_all_total_invoice_exe_row = mysqli_fetch_array($select_all_total_invoice_exe);
if($select_all_total_invoice_exe_row['id'] != null){
	$response_arr[0]['total_invoice'] = $select_all_total_invoice_exe_row['id'];
}else{
	$response_arr[0]['total_invoice'] = 0;
}
echo json_encode($response_arr);
?>