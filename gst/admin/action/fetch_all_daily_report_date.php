<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$product_date_arr = array();
$response_arr = array();
$patient_date_arr = array();
$total_income = 0;
$total_price_1 = 0;
$total_quantity_1 = 0;
$select_todays_report = $obj->selectData("tbl_productdetails.id,tbl_productdetails.added_date,tbl_productdetails.price,tbl_productdetails.discount,tbl_productdetails.no_quantity,tbl_productdetails.total_price","tbl_productdetails inner join tbl_customer on tbl_productdetails.customer_id=tbl_customer.id","where tbl_productdetails.status!=0 and tbl_customer.status!=0 ORDER BY tbl_productdetails.id DESC");
if(mysqli_num_rows($select_todays_report)>0){
	$response_arr[0]['data_exist'] = 1;
	$x = 0;
	while($select_todays_report_row = mysqli_fetch_array($select_todays_report)){
		$id = $select_todays_report_row['id'];
		$added_date = $select_todays_report_row['added_date'];
		$added_date1 = date("Y-m-d", strtotime($added_date));
		$added_date2 = date("d-m-Y", strtotime($added_date));
		$price = $select_todays_report_row['price'];
		$discount = $select_todays_report_row['discount'];
		$no_quantity = $select_todays_report_row['no_quantity'];
		$total_price_all = $select_todays_report_row['total_price'];
		if(in_array($added_date,$product_date_arr)){
			$loop_index = 0;
			$arr_len = sizeof($response_arr);
			for($x1 = 0;$x1<$arr_len;$x1++){
				$loop_date = $response_arr[$x1]['date'];
				if($loop_date == $added_date){
					$loop_index = $x1;
					break;
				}
			}
			
			$loop_quantity = $response_arr[$loop_index]['total_quantity'];
			$loop_price = $response_arr[$loop_index]['total_price'];
			$total_quantity_1 = $loop_quantity+$no_quantity;
			$total_price_1 = $loop_price+$total_price_all;
			$response_arr[$loop_index]['total_price'] = $total_price_1;
			$response_arr[$loop_index]['total_quantity'] = $total_quantity_1;
			$total_income += $total_price_all;
			//print_r($response_arr);
		}else{
			$response_arr[$x]['date'] = $added_date;
			$total_price = $price+$no_quantity;
			$response_arr[$x]['total_price'] = $total_price_all;
			$response_arr[$x]['total_quantity'] = $no_quantity;
			$total_income += $total_price_all;
			$select_todays_patients = $obj->selectData("count(id) as id","tbl_customer","where status!=0 and (created_date = '$added_date1' or  created_date = '$added_date2')");
			$select_todays_patients_row = mysqli_fetch_array($select_todays_patients);
			if($select_todays_patients_row['id'] != null){
				$response_arr[$x]['total_patient'] = $select_todays_patients_row['id'];
			}else{
				$response_arr[$x]['total_patient'] = 0;
			}
			array_push($product_date_arr,$added_date);
			$x++;
			//print_r($response_arr);
		}
		
	}
}else{
	$response_arr[0]['data_exist'] = 0;
}
$response_arr[0]['total_income'] = $total_income;




//total invoice
$select_all_total_invoice = $obj->selectData("count(id) as id","tbl_customer","where status!=0");
$select_all_total_invoice_row = mysqli_fetch_array($select_all_total_invoice);
if($select_all_total_invoice_row['id'] != null || $select_all_total_invoice_row['id'] !=0){
	$response_arr[0]['total_invoice'] = $select_all_total_invoice_row['id'];
}else{
	$response_arr[0]['total_invoice'] = 0;
}
echo json_encode($response_arr);
?>