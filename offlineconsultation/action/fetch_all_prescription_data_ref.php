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
	$check_branch = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$bill_data");
	$check_branch_row = mysqli_fetch_array($check_branch);
	if($check_branch_row['real_branch_id'] == $check_branch_row['branch_id']){
	$select_prescription_data = $obj->selectData("id,patient_id","tbl_prescriptions","where appointment_id=$bill_data and status!=0");
	if(mysqli_num_rows($select_prescription_data)>0){
		while($select_prescription_data_row = mysqli_fetch_array($select_prescription_data)){
			$prescription_id = $select_prescription_data_row['id'];
			$patient_id = $select_prescription_data_row['patient_id'];
			$select_product_id = $obj->selectData("id,medicine_id,quantity,morning_section,noon_section,evening_section,no_of_day,medicine_name,after_food,befor_food","tbl_prescription_medicine_data","where prescription_id=$prescription_id and status!=0");
			if(mysqli_num_rows($select_product_id)>0){
				$y = 0;
				while($select_product_id_row = mysqli_fetch_array($select_product_id)){
					$response_arr[$x]['medicine_id'] = $select_product_id_row['medicine_id'];
					$response_arr[$x]['medicine_name'] = $select_product_id_row['medicine_name'];
					$response_arr[$x]['morning_section'] = $select_product_id_row['morning_section'];
					$response_arr[$x]['noon_section'] = $select_product_id_row['noon_section'];
					$response_arr[$x]['evening_section'] = $select_product_id_row['evening_section'];
					$response_arr[$x]['no_of_day'] = $select_product_id_row['no_of_day'];
					if($select_product_id_row['after_food'] == 1){
						$response_arr[$x]['food_session'] = 'AF';
					}else if($select_product_id_row['befor_food'] == 1){
						$response_arr[$x]['food_session'] = 'BF';
					}else{
						$response_arr[$x]['food_session'] = '';
					}
					$x++;
				}
			}
	}
}
}else{
		$branch = $check_branch_row['branch_id'];
		require_once '../_class_branch/query_branch.php';
		$obj_branch = new query_branch();
	$appointment_branch_data = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$bill_data");
	if(mysqli_num_rows($appointment_branch_data)>0){
		$appointment_branch_data_row = mysqli_fetch_array($appointment_branch_data);
		$bill_data = $appointment_branch_data_row['id'];
		$select_prescription_data = $obj_branch->selectData("id,patient_id","tbl_prescriptions","where appointment_id=$bill_data and status!=0");
	if(mysqli_num_rows($select_prescription_data)>0){
		while($select_prescription_data_row = mysqli_fetch_array($select_prescription_data)){
			$prescription_id = $select_prescription_data_row['id'];
			$patient_id = $select_prescription_data_row['patient_id'];
			$select_product_id = $obj_branch->selectData("id,medicine_id,quantity,morning_section,noon_section,evening_section,no_of_day,medicine_name,after_food,befor_food","tbl_prescription_medicine_data","where prescription_id=$prescription_id and status!=0");
			if(mysqli_num_rows($select_product_id)>0){
				$y = 0;
				while($select_product_id_row = mysqli_fetch_array($select_product_id)){
					$response_arr[$x]['medicine_id'] = $select_product_id_row['medicine_id'];
					$response_arr[$x]['medicine_name'] = $select_product_id_row['medicine_name'];
					$response_arr[$x]['morning_section'] = $select_product_id_row['morning_section'];
					$response_arr[$x]['noon_section'] = $select_product_id_row['noon_section'];
					$response_arr[$x]['evening_section'] = $select_product_id_row['evening_section'];
					$response_arr[$x]['no_of_day'] = $select_product_id_row['no_of_day'];
					if($select_product_id_row['after_food'] == 1){
						$response_arr[$x]['food_session'] = 'AF';
					}else if($select_product_id_row['befor_food'] == 1){
						$response_arr[$x]['food_session'] = 'BF';
					}else{
						$response_arr[$x]['food_session'] = '';
					}
					$x++;
				}
			}
	}
}
	}
}
}
echo json_encode($response_arr);
?>