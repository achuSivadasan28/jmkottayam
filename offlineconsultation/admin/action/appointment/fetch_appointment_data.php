<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
require_once '../../../_class_common/query_common.php';
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days_re=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['admin_login_id'])){
$login_id = $_SESSION['admin_login_id'];
$admin_role = $_SESSION['admin_role'];
$admin_unique_code = $_SESSION['admin_unique_code'];
if($admin_role == 'admin'){
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
		$url_val = $_POST['url_val'];
		$select_appointment_details = $obj->selectData("tbl_appointment.id,tbl_appointment.patient_id,tbl_appointment.branch_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_appointment.height,tbl_appointment.weight,tbl_appointment.blood_pressure,tbl_appointment.allergies_if_any,tbl_appointment.current_medication,tbl_appointment.first_visit,tbl_appointment.present_Illness,tbl_appointment.any_surgeries,tbl_appointment.any_metal_Implantation,tbl_appointment.appointment_number,tbl_appointment.appointment_time_slot_id,old_patient,num_of_visit,appointment_fee","tbl_appointment","where tbl_appointment.id=$url_val");

	//,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.whatsApp
	if(mysqli_num_rows($select_appointment_details)>0){
		$x = 0;
		while($select_appointment_details_row = mysqli_fetch_array($select_appointment_details)){
			$response_arr[$x]['id'] = $select_appointment_details_row['id'];
			$patient_id = $select_appointment_details_row['patient_id'];
			
			$response_arr[$x]['patient_id'] = $select_appointment_details_row['patient_id'];
			$response_arr[$x]['doctor_id'] = $select_appointment_details_row['doctor_id'];
			$response_arr[$x]['first_visit'] = $select_appointment_details_row['first_visit'];
			$response_arr[$x]['appointment_date'] = $select_appointment_details_row['appointment_date'];
			$response_arr[$x]['height'] = $select_appointment_details_row['height'];
			$response_arr[$x]['weight'] = $select_appointment_details_row['weight'];
			$response_arr[$x]['blood_pressure'] = $select_appointment_details_row['blood_pressure'];
			$response_arr[$x]['allergies_if_any'] = $select_appointment_details_row['allergies_if_any'];
			$response_arr[$x]['current_medication'] = $select_appointment_details_row['current_medication'];
			$response_arr[$x]['present_Illness'] = $select_appointment_details_row['present_Illness'];
			$response_arr[$x]['any_surgeries'] = $select_appointment_details_row['any_surgeries'];
			$response_arr[$x]['any_metal_Implantation'] = $select_appointment_details_row['any_metal_Implantation'];
			$response_arr[$x]['appointment_number'] = $select_appointment_details_row['appointment_number'];
			$response_arr[$x]['appointment_time_slot_id'] = $select_appointment_details_row['appointment_time_slot_id'];
			$response_arr[$x]['appointment_fee'] = $select_appointment_details_row['appointment_fee'];
			$response_arr[$x]['old_patient'] = $select_appointment_details_row['old_patient'];
			$response_arr[$x]['num_of_visit'] = $select_appointment_details_row['num_of_visit'];
			$response_arr[$x]['c_date'] = $days1;
			$response_arr[$x]['branch_id'] = $select_appointment_details_row['branch_id'];
			$branch_id = $select_appointment_details_row['branch_id'];
			$branch = $branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_patient_data = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.whatsApp","tbl_patient","where id=$patient_id");
			if(mysqli_num_rows($select_patient_data)>0){
			$select_patient_data_row = mysqli_fetch_array($select_patient_data);
			$unique_id = $select_patient_data_row['unique_id'];
			$response_arr[$x]['unique_id'] = $select_patient_data_row['unique_id'];
			$response_arr[$x]['name'] = $select_patient_data_row['name'];
			$response_arr[$x]['phone'] = $select_patient_data_row['phone'];
			$response_arr[$x]['address'] = $select_patient_data_row['address'];
			$response_arr[$x]['place'] = $select_patient_data_row['place'];
			$response_arr[$x]['age'] = $select_patient_data_row['age'];
			$response_arr[$x]['gender'] = $select_patient_data_row['gender'];
			$response_arr[$x]['whatsApp'] = $select_patient_data_row['whatsApp'];
			
			require_once'../../../_class_common/query_common.php';
			$obj_common = new query_common();
			$select_patient_image = $obj_common->selectData("image,image_uploadurl","tbl_patient","where unique_id = '$unique_id'and id =(select max(id) from tbl_patient where unique_id ='$unique_id') limit 1 ");
			
			if($select_patient_image_row = mysqli_fetch_assoc($select_patient_image)){
				$response_arr[$x]['image'] = $select_patient_image_row ['image'];
				$response_arr[$x]['image_url'] = $select_patient_image_row['image_uploadurl'];
			 }
			}
			$branch = $branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_num_of_visits = $obj_branch->selectData('count(*) as visits,num_of_visit',"tbl_appointment","where patient_id = $patient_id and id<=$url_val and status != 0");
			
			if(mysqli_num_rows($select_num_of_visits)>0){
			   $select_num_of_visits_rows = mysqli_fetch_assoc($select_num_of_visits);
			   $response_arr[$x]['visits'] = $select_num_of_visits_rows['visits'] +  $select_num_of_visits_rows['num_of_visits'];
			}
			
			$x++;      
		}
	}
		$response_arr[0]['status'] = 1;
		$response_arr[0]['msg'] = 'Success';
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);



function check_doctor_time_limit($time_slot,$obj){
	$total_num_slot = 0;
	$select_time_slot_id = $obj->selectData("time_slot_id","tbl_doctor_appointment_slot","where id=$time_slot and status!=0");
	if(mysqli_num_rows($select_time_slot_id)>0){
		$select_time_slot_id_row = mysqli_fetch_array($select_time_slot_id);
		$time_solot_id = $select_time_slot_id_row['time_slot_id'];
		$select_max_appointments = $obj->selectData("total_num_slot","tbl_appointment_slot","where id=$time_solot_id and status!=0");
		if(mysqli_num_rows($select_max_appointments)){
			$select_max_appointments_row = mysqli_fetch_array($select_max_appointments);
			$total_num_slot = $select_max_appointments_row['total_num_slot'];
			
		}
	}
	return $total_num_slot;
}

function check_total_appointments($date,$doctor_data,$time_slot,$obj){
	$total_num_appointment = 0;
	$check_total_appointments_data = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$doctor_data and appointment_date='$date' and appointment_time_slot_id=$time_slot and status!=0");
	if(mysqli_num_rows($check_total_appointments_data)>0){
		$check_total_appointments_row = mysqli_fetch_array($check_total_appointments_data);
		if($check_total_appointments_row['id'] != null){
			$total_num_appointment  = $check_total_appointments_row['id'];
		}
	}
	return $total_num_appointment;
}
?>