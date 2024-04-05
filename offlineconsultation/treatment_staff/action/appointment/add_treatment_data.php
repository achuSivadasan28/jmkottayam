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
$treatement_id = $_POST['treatement_id'];
$treatement_name = $_POST['treatement_name'];
$treatment_amt = $_POST['treatment_amt'];
$id = $_POST['id'];
$branch = $_POST['invoice_branch'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
if($treatement_id != '' and $treatement_name !='' and $treatment_amt!=0 and $treatment_amt!=''){
$info_update_data = array(
	"invoice_id" => $id,
	"treatement_name" => $treatement_name,
	"treatement_id" => $treatement_id,
	"amount" => $treatment_amt,
	"status" => 1
);
$obj->insertData("tbl_treatment_invoice_details",$info_update_data);
}
//tbl_treatment_invoice_details
$response_arr[0]['id'] = $id;
echo json_encode($response_arr);
?>