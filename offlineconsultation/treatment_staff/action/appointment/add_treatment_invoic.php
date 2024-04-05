<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$appointment_id = $_POST['appointment_id'];
$main_appointment_id = $appointment_id;
$real_branch_id = 0;
$branch_id = 0;
$check_branch = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($check_branch)>0){
	$check_branch_row = mysqli_fetch_array($check_branch);
	$real_branch_id = $check_branch_row['real_branch_id'];
	$branch_id = $check_branch_row['branch_id'];
}
$patient_id = '';
$select_patient_details = $obj->selectData("patient_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($select_patient_details)>0){
	$select_patient_details_row = mysqli_fetch_array($select_patient_details);
	$patient_id = $select_patient_details_row['patient_id'];
}
$invoice_num = 0;
$select_invoice_num = $obj->selectData("max(invoice_num) as invoice_num","tbl_treatment_invoice","");
$select_invoice_num_row = mysqli_fetch_array($select_invoice_num);
if($select_invoice_num_row['invoice_num'] != null){
	$invoice_num = $select_invoice_num_row['invoice_num']+1;
}else{
	$invoice_num = '1';
}
	$branch = $branch_id;
	$branch_code = '';
	$select_branch_code = $obj->selectData("short","tbl_branch_url","where branch_id= $real_branch_id and status!=0");
	if(mysqli_num_rows($select_branch_code)>0){
		$select_branch_code_row = mysqli_fetch_array($select_branch_code);
		$branch_code = $select_branch_code_row['short'];
	}
/**if($branch == 4){
	$branch_code = 'EDY';
}else if($branch == 5){
	$branch_code = 'Pala';
}else if($branch == 7){
	$branch_code = 'Kannur';
}else if($branch == 8){
	$branch_code = 'TRVL';
}else if($branch == 9){
	$branch_code = 'TVM';
}else if($branch == 10){
	$branch_code = 'BLR';
}else if($branch == 11){
	$branch_code = 'Kottakkal';
}else if($branch == 12){
	$branch_code = 'KKZ';
}else if($branch == 13){
	$branch_code = 'TDPA';
}else if($branch == 14){
	$branch_code = 'CLT';
}**/
$invoice_com = $c_year.'/'.$branch_code.'/'.$invoice_num;
$info_data = array(
	"invoice_num" => $invoice_num,
	"invoice_num_com" => $invoice_com,
	"appointment_id" => $appointment_id,
	"patient_id" => $patient_id,
	"added_date" => $days,
	"time" => $times,
	"status" => 1
);
$obj->insertData("tbl_treatment_invoice",$info_data);
$select_invoice_id = $obj->selectData("id","tbl_treatment_invoice","where invoice_num_com='$invoice_com' and status=1");
if(mysqli_num_rows($select_invoice_id)>0){
	$select_invoice_id_row = mysqli_fetch_array($select_invoice_id);
	$id = $select_invoice_id_row['id'];
}
$info_update_status = array(
	"treatment_fee_status" => 1
);
$obj->updateData("tbl_appointment",$info_update_status,"where id=$appointment_id");
$response_arr[0]['id'] = $id;
$response_arr[0]['branch_id'] = $branch_id;
echo json_encode($response_arr);
?>