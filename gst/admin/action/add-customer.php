<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$response_data = array();
$invoice_no=$obj->selectData("invoice_no","tbl_customer","");
if(mysqli_num_rows($invoice_no)>0){
    while($invoice_row = mysqli_fetch_array($invoice_no)){
  $last_id=$invoice_row ['invoice_no'];
    }
}
if(empty(  $last_id)){
    $number="E-0000001";
}
else{
    $idd=str_replace("E-","",$last_id);
    $id=str_pad($idd+1,7,0,STR_PAD_LEFT);
    $number='E-'.$id;
}
$c_year=date('Y');
$tax_cal = $_POST['tax_cal'];
$tax_invoice_compaied = '';
$tax_invoice = 0;
$tax_apply = 0;
if($tax_cal == 1){
	$tax_apply = 1;
	$select_last_invoice = $obj->selectData("max(tax_invoice) as tax_invoice","tbl_customer","where tax_invoice_year='$c_year'");
	$select_last_invoice_row = mysqli_fetch_array($select_last_invoice);
	if($select_last_invoice_row['tax_invoice'] != null){
		$tax_invoice = $select_last_invoice_row['tax_invoice'];
		$tax_invoice += 1;
	}
	$tax_invoice_compaied = 'E/'.$c_year.'/'.$tax_invoice;
}
$staff_id=$_SESSION['staff']; 
$customer_name= $_POST['customer_name'];
$phone= $_POST['phone_num'];
$Tprice=$_POST['Tprice'];
$discount=$_POST['discount'];
$tamount=$_POST['tamount'];
$total_tax=$_POST['total_tax'];
$total_tax_cgst=$_POST['total_tax_cgst'];
$total_tax_sgst=$_POST['total_tax_sgst'];
$Actual_amt = $_POST['Actual_amt'];
$place = $_POST['place'];
$bill_date = $_POST['bill_date'];
$payment_option = $_POST['payment_option'];
if($bill_date !=''){
	$newDate = date("d-m-Y", strtotime($bill_date));
}else{
	$newDate = $days;
}
// $invoice_id=$_POST['invoice_no'];
$info_user = array(
	"tax_invoice_year" => $c_year,
	"tax_invoice" => $tax_invoice,
	"tax_compained_val" => $tax_invoice_compaied,
    "invoice_no"=>$number,
    "staff_id"=>$staff_id,
    "customer_name" => $customer_name,
    "phone" => $phone,
	"place" => $place,
    "created_date"=>$newDate,
	"added_date" => $days,
    "time"=>$times,
    "total_price"=>$Tprice,
    "total_discount"=>$discount,
    "total_amonut"=>$tamount,
	"total_tax_amt" => $total_tax,
	"total_cgst" => $total_tax_cgst,
	"total_sgst" => $total_tax_sgst,
	"actual_amt" => $Actual_amt,
    "status"=>1,
	"tax_apply" => $tax_apply,
	"payment_option" => $payment_option,
);
$insert=$obj->insertData("tbl_customer",$info_user);
$select=$obj->selectData("id","tbl_customer","where invoice_no='$number'");
if(mysqli_num_rows($select)>0){
    while($data=mysqli_fetch_array($select)){
        $id=$data['id'];
    }
}
$api_val = '';
$select_api_val = $obj->selectData("api_key","api_key","where status=1");
if(mysqli_num_rows($select_api_val)>0){
	while($select_api_val_row = mysqli_fetch_array($select_api_val)){
		$api_val = $select_api_val_row['api_key'];
	}
}
$msg = "Hi ".$customer_name." 
Thanks for your visit 
johnmarian wellness clinic";
$link = "https://promo.esightsolutions.com/wapp/api/send?apikey=".$api_val;

$response_data[0]['link'] = $link;
$response_data[0]['phn'] = $phone;
$response_data[0]['sms'] = $msg;
$response_data[0]['cid'] = $id;
echo json_encode($response_data);
?>