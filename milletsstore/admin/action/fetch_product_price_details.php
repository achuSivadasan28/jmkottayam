<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$ebs_response_arr = array();
$id_details = $_POST['id_details'];
$ebs_quantity = $_POST['quantity'];
if($ebs_quantity == ''){
	$ebs_quantity = 1;
}
$ebs_price = 0;
$ebs_tax_per = 0;
$ebs_stock = 0;
$EBS_select_medicine_details = $obj->selectData("price,tax_data,quantity","tbl_medicine_details","where id=$id_details and status!=0");
if(mysqli_num_rows($EBS_select_medicine_details)>0){
	$EBS_select_medicine_details_row = mysqli_fetch_array($EBS_select_medicine_details);
	$ebs_price = $EBS_select_medicine_details_row['price'];
	$ebs_tax_per = $EBS_select_medicine_details_row['tax_data'];
	$ebs_stock = $EBS_select_medicine_details_row['quantity'];
}
if($ebs_tax_per == ''){
	$ebs_tax_per = 0;
}

$ebs_response_arr[0]['ebs_tax_per'] = $ebs_tax_per;


$ebs_total_price = $ebs_price*$ebs_quantity;
if($ebs_tax_per !=0){
	$actual_amt = including_tax_desi($ebs_tax_per,$ebs_total_price);
	$tax_amt = $ebs_total_price-$actual_amt;
	$ebs_response_arr[0]['ebs_tax'] = round($tax_amt,2);
}
$ebs_response_arr[0]['ebs_total_price'] = $ebs_total_price;
$ebs_response_arr[0]['ebs_price'] = $ebs_price;
$ebs_response_arr[0]['ebs_quantity'] = $ebs_quantity;
if($ebs_stock>=$ebs_quantity){
	$ebs_response_arr[0]['ebs_stock'] = 0;
}else{
	$ebs_response_arr[0]['ebs_stock'] = 1;
}
echo json_encode($ebs_response_arr);

function including_tax_desi($tax_ratio,$amount){
    $tax_in_hund = $tax_ratio+100;
    $y = ((int)$amount/$tax_in_hund)*100;
    return round($y,2);
}
?>