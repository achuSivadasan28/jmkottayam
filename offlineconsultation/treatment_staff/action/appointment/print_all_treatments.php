<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_branch/query_branch.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$days_re=date('Y-m-d');
$c_year = date('Y');
$id = $_POST['appointment_id'];

$dataArray=[];
$obj_branch = new query_branch();

$real_branch_id = 0;
$branch_id = 0;
$check_branch = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$id");
if(mysqli_num_rows($check_branch)>0){
	$check_branch_row = mysqli_fetch_array($check_branch);
	$real_branch_id = $check_branch_row['real_branch_id'];
	$branch_id = $check_branch_row['branch_id'];
}
$fetch_all_address = $obj->selectData("head,address,phn_details,gmail,website","tbl_address","");
if(mysqli_num_rows($fetch_all_address)>0){
	$fetch_all_address_row = mysqli_fetch_array($fetch_all_address);
	$dataArray[0]['head'] = $fetch_all_address_row['head'];
	$dataArray[0]['address'] = $fetch_all_address_row['address'];
	$dataArray[0]['phn_details'] = $fetch_all_address_row['phn_details'];
	$dataArray[0]['gmail'] = $fetch_all_address_row['gmail'];
	$dataArray[0]['website'] = $fetch_all_address_row['website'];
}
$fetch_invoice_details=$obj->selectData("id,invoice_num,invoice_num_com,appointment_id,patient_id,status,added_date","tbl_treatment_invoice","where appointment_id=$id  and status = 1 ORDER BY id DESC limit 1");
//print_r($obj);exit();
if(mysqli_num_rows($fetch_invoice_details)>0){
	$x=0;
	while($data=mysqli_fetch_array($fetch_invoice_details))
	{

		$dataArray[$x]['id']=$data['id'];
		$dataArray[$x]['invoice_num']=$data['invoice_num'];
		$dataArray[$x]['invoice_num_com']=$data['invoice_num_com'];
		$dataArray[$x]['appointment_id']=$data['appointment_id'];
		$dataArray[$x]['patient_id']=$data['patient_id'];
		$dataArray[$x]['added_date']=$data['added_date'];
		$patient_id = $data['patient_id'];
		$branch = $branch_id;
		$obj_branch = new query_branch();
		$select_patient_name = $obj_branch->selectData("name,phone","tbl_patient","where id=$patient_id");
		//print_r($obj);exit();
		if(mysqli_num_rows($select_patient_name)){
			$select_patient_name_row = mysqli_fetch_array($select_patient_name);
			$name = $select_patient_name_row['name'];
			$phone = $select_patient_name_row['phone'];
			$dataArray[$x]['name'] = $name;
			$dataArray[$x]['phone'] = $phone;
		}

       
		$invoice_id =$data['id'];
        //echo $invoice_id;exit();
		$total_amount_exc = 0;
		$total_amounts=$obj->selectData("SUM(amount) AS total_amount,status","tbl_treatment_payment_mode","where invoice_id=$invoice_id and  status = 1");
		if(mysqli_num_rows($total_amounts)>0){
			while($ross=mysqli_fetch_array($total_amounts)){
				$dataArray[$x]['total_sum']=$ross['total_amount'];

			}
		}
       
		$fetch_treatment_details=$obj->selectData("id,invoice_id,treatement_name,treatement_id,amount,status","tbl_treatment_invoice_details","where invoice_id=$invoice_id  and  status = 1");
		//print_r($fetch_treatment_details);exit();
		
		if(mysqli_num_rows($fetch_treatment_details)>0){
			$y=0;
			while($row=mysqli_fetch_array($fetch_treatment_details)){
				$customer_id = $row['customer_id'];
				$dataArray[$x]['treatment_details'][$y]['invoice_id']=$row['invoice_id'];
				$dataArray[$x]['treatment_details'][$y]['treatement_name']=$row['treatement_name'];
				$dataArray[$x]['treatment_details'][$y]['treatment_amount']=$row['amount'];
				$y++;	
			}
		}
		$x++;
	}

}
//print_r($dataArray);exit();
echo json_encode($dataArray);

?>