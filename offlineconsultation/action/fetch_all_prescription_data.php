<?php
session_start();
require_once '../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$bill_days=date('Y-m-d');
$enc_key = $_POST['enc_key'];
$bill_data = $_POST['bill_data'];
$Api_key = 'jhnmariansBilling';
$enc_Api_key = md5($Api_key);
$x = 0;
$z = 0;

if($enc_Api_key == $enc_key){
	$response_arr[0]['status'] = 1;
	$real_branch_id = 0;
	$branch_id = 0;
	$patient_id = 0;
	$check_brnach = $obj->selectData("real_branch_id,branch_id,patient_id","tbl_appointment","where id=$bill_data");
	if(mysqli_num_rows($check_brnach)>0){
		$check_brnach_row = mysqli_fetch_array($check_brnach);
		$real_branch_id = $check_brnach_row['real_branch_id'];
		$branch_id = $check_brnach_row['branch_id'];
		$patient_id = $check_brnach_row['patient_id'];
	}
	if($real_branch_id == $branch_id){
			$select_prescription_data = $obj->selectData("id,patient_id","tbl_prescriptions","where appointment_id=$bill_data and status!=0");
	if(mysqli_num_rows($select_prescription_data)>0){
		while($select_prescription_data_row = mysqli_fetch_array($select_prescription_data)){
			$prescription_id = $select_prescription_data_row['id'];
			$patient_id = $select_prescription_data_row['patient_id'];
			if($x == 0){
			$select_patient_details = $obj->selectData("name,phone,place","tbl_patient","where id=$patient_id");
			if(mysqli_num_rows($select_patient_details)>0){
				while($select_patient_details_row = mysqli_fetch_array($select_patient_details)){
					$response_arr[0]['name'] = $select_patient_details_row['name'];
					$response_arr[0]['phone'] = $select_patient_details_row['phone'];
					$response_arr[0]['place'] = $select_patient_details_row['place'];
					$response_arr[0]['date'] = $bill_days;
					//$bill_days
				}
			}
			}
			
			$select_product_id = $obj->selectData("id,medicine_id,quantity,morning_section,noon_section,evening_section,no_of_day","tbl_prescription_medicine_data","where prescription_id=$prescription_id and status!=0");
			if(mysqli_num_rows($select_product_id)>0){
				$y = 0;
				while($select_product_id_row = mysqli_fetch_array($select_product_id)){
					$response_arr[$x]['medicine_id'] = $select_product_id_row['medicine_id'];
					$total_section = $select_product_id_row['morning_section']+$select_product_id_row['evening_section']+$select_product_id_row['noon_section'];
					$total_days = $select_product_id_row['no_of_day'];
					$total_quantity = $total_days*$total_section;
					$response_arr[$x]['quantity'] = $total_quantity;
					$x++;
				}
			}
	}
}
	}else{
		$branch = $branch_id;
		require_once '../_class_branch/query_branch.php';
		$obj_branch = new query_branch();
		$fetch_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$bill_data and patient_id=$patient_id");
		if(mysqli_num_rows($fetch_appointment_id)>0){
			$fetch_appointment_id_row = mysqli_fetch_array($fetch_appointment_id);
			$bill_data = $fetch_appointment_id_row['id'];
			$select_prescription_data = $obj_branch->selectData("id,patient_id","tbl_prescriptions","where appointment_id=$bill_data and status!=0");
	if(mysqli_num_rows($select_prescription_data)>0){
		while($select_prescription_data_row = mysqli_fetch_array($select_prescription_data)){
			$prescription_id = $select_prescription_data_row['id'];
			$patient_id = $select_prescription_data_row['patient_id'];
			if($x == 0){
			$select_patient_details = $obj_branch->selectData("name,phone,place","tbl_patient","where id=$patient_id");
			if(mysqli_num_rows($select_patient_details)>0){
				while($select_patient_details_row = mysqli_fetch_array($select_patient_details)){
					$response_arr[0]['name'] = $select_patient_details_row['name'];
					$response_arr[0]['phone'] = $select_patient_details_row['phone'];
					$response_arr[0]['place'] = $select_patient_details_row['place'];
					$response_arr[0]['date'] = $bill_days;
					//$bill_days
				}
			}
			}
			
			$select_product_id = $obj_branch->selectData("id,medicine_id,quantity,morning_section,noon_section,evening_section,no_of_day","tbl_prescription_medicine_data","where prescription_id=$prescription_id and status!=0");
			if(mysqli_num_rows($select_product_id)>0){
				$y = 0;
				while($select_product_id_row = mysqli_fetch_array($select_product_id)){
					$response_arr[$x]['medicine_id'] = $select_product_id_row['medicine_id'];
					$total_section = $select_product_id_row['morning_section']+$select_product_id_row['evening_section']+$select_product_id_row['noon_section'];
					$total_days = $select_product_id_row['no_of_day'];
					$total_quantity = $total_days*$total_section;
					$response_arr[$x]['quantity'] = $total_quantity;
					$x++;
				}
			}
	}
}
		}
	}

}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong';
}
echo json_encode($response_arr);
?>