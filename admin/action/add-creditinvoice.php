<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$response_data = array();
$adminid=$_SESSION['adminLogId'];
$invoice_no=$obj->selectData("credit_note_invoice_number","tbl_credit_note","");
if(mysqli_num_rows($invoice_no)>0){
    while($invoice_row = mysqli_fetch_array($invoice_no)){
  $last_id=$invoice_row ['credit_note_invoice_number'];
    }
}
if(empty($last_id)){
    $number="CN-JM23/24-TRVL001";
}
else{
	
$idd=str_replace("CN-JM23/24-TRVL00","",$last_id);
    //$id=str_pad($idd+1,7,0,STR_PAD_LEFT);
	$id=$idd+1;
    $number='CN-JM23/24-TRVL00'.$id;
}



$invoice_num = $_POST['invoice_number'];
$invoice_id = $_POST['invoice_id'];


$info_user = array(
	"invoice_id" => $invoice_id,
	"staff_id" => $adminid,
	"invoice_number" => $invoice_num,
	"credit_note_invoice_number" =>$number,
    "addedDate"=>$days,
    "addedTime"=>$times,
    "status"=>1,
	
);
$insert=$obj->insertData("tbl_credit_note",$info_user);
$select=$obj->selectData("id","tbl_credit_note","where credit_note_invoice_number='$number'");
if(mysqli_num_rows($select)>0){
    while($data=mysqli_fetch_array($select)){
        $id=$data['id'];
    }
}

$response_data[0]['cid'] = $id;
echo json_encode($response_data);
?>