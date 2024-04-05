<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$ebs_response_arr = array();
$ebs_price = $_POST['price'];
$ebs_quantity = $_POST['Quantity'];
$Productnopill_id = $_POST['Productnopill_id'];
if($ebs_quantity == ''){
	$ebs_quantity = 1;
}

$EBS_select_medicine_details = $obj->selectData("tax_data","tbl_medicine_details","where id=$Productnopill_id and status!=0");
if(mysqli_num_rows($EBS_select_medicine_details)>0){
	$EBS_select_medicine_details_row = mysqli_fetch_array($EBS_select_medicine_details);
	$ebs_tax_per = $EBS_select_medicine_details_row['tax_data'];
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

echo json_encode($ebs_response_arr);

function including_tax_desi($tax_ratio,$amount){
    $tax_in_hund = $tax_ratio+100;
    $y = ((int)$amount/$tax_in_hund)*100;
    return round($y,2);
}
?>