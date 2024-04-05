<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();

require_once '../../../_class_common/query_common.php';
$obj_common=new query_common();

$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['staff_login_id'])){
$login_id = $_SESSION['staff_login_id'];
$staff_role = $_SESSION['staff_role'];
$staff_unique_code = $_SESSION['staff_unique_code'];
if($staff_role == 'treatment_staff'){
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$search_data = $_POST['search_data'];
	$waiting_count = 0;
	$pending_count = 0;
	$search_data_where = "";
	$appointment_data = $_POST['appointment_data'];
	$appointment_where = '';
	
	if($appointment_data == 0){
		//$appointment_where = " and tbl_appointment.doctor_id='$login_id'";
	}
	$where_c_date_filter = " and tbl_appointment.appointment_date='$c_days'";
	if($search_data != ''){
		$search_data_where = " and (tbl_patient.phone like '%$search_data%' or tbl_patient.name like '%$search_data%' or tbl_patient.unique_id like '%$search_data%')";
		$where_c_date_filter = '';
	}
	if($search_data_where == ''){
	$select_todays_appointment = $obj->selectData("tbl_appointment.id,tbl_appointment.doctor_id,tbl_appointment.branch_id,tbl_appointment.appointment_status,tbl_appointment.patient_id,tbl_appointment.appointment_number,tbl_appointment.height,tbl_appointment.weight,tbl_appointment.blood_pressure,tbl_appointment.allergies_if_any,tbl_appointment.current_medication,tbl_appointment.present_Illness,tbl_appointment.any_surgeries,tbl_appointment.any_metal_Implantation,tbl_doctor.doctor_name,tbl_appointment.first_visit","tbl_appointment inner join tbl_doctor on tbl_appointment.doctor_id = tbl_doctor.login_id","where tbl_appointment.status!=0 and tbl_appointment.appointment_status=2 $appointment_where $where_c_date_filter ORDER BY tbl_appointment.id DESC");
	//echo $select_todays_appointment;exit();
	if(mysqli_num_rows($select_todays_appointment)>0){
		$response_arr[0]['data_status'] = 1;
		//tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.id as patient_id
		$x = 0;
		$active_id = 0;
		if(isset($_SESSION['active_id'])){
				$active_id = $_SESSION['active_id'];	
			}else{
				$active_id = 0;
			}
		
		while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
			$patient_id = $select_todays_appointment_row['patient_id'];
			$branch = $select_todays_appointment_row['branch_id'];
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_patient_data = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.id as patient_id","tbl_patient","where id=$patient_id $search_data_where");
			if(mysqli_num_rows($select_patient_data)>0){
			$select_patient_data_row = mysqli_fetch_array($select_patient_data);
			$response_arr[$x]['id'] = $select_todays_appointment_row['id'];
			$response_arr[$x]['patient_id'] = $select_patient_data_row['patient_id'];
			$response_arr[$x]['branch'] = $branch;
			if($active_id == 0){
				if($x == 0){
					$response_arr[$x]['active'] = 1;
				}else{
					$response_arr[$x]['active'] = 0;
				}
			}else{
				if($select_todays_appointment_row['id'] == $active_id){
					$response_arr[$x]['active'] = 1;
				}else{
					$response_arr[$x]['active'] = 0;
				}
			}
				$select_first_visit = $obj_branch->selectData('first_visit,appointment_date',"tbl_appointment","where status = 1 and patient_id = $patient_id and branch_id = $branch order by id asc limit 1");
				//echo $select_first_visit;exit();
				if(mysqli_num_rows($select_first_visit)){
					$select_first_visit_rows = mysqli_fetch_assoc($select_first_visit);
					if($select_first_visit_rows['first_visit'] == ''){
						$response_arr[$x]['first_visit'] = $select_first_visit_rows['appointment_date'];
					}else{
						$response_arr[$x]['first_visit'] = $select_first_visit_rows['first_visit'];
					}

				}
			$response_arr[$x]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
			$patient_id = $select_patient_data_row['patient_id'];
			$response_arr[$x]['unique_id'] = $select_patient_data_row['unique_id'];
			$response_arr[$x]['patient_id'] = $patient_id;
			$response_arr[$x]['doctor_name'] = $select_todays_appointment_row['doctor_name'];
			if($select_todays_appointment_row['doctor_id'] == $login_id){
				$response_arr[$x]['to'] = 1;
			}else{
				$response_arr[$x]['to'] = 0;
			}
			$response_arr[$x]['name'] = $select_patient_data_row['name'];
			
			$response_arr[$x]['phone'] = $select_patient_data_row['phone'];
			$response_arr[$x]['address'] = $select_patient_data_row['address'];
			$response_arr[$x]['place'] = $select_patient_data_row['place'];
			$response_arr[$x]['age'] = $select_patient_data_row['age'];
			$response_arr[$x]['gender'] = $select_patient_data_row['gender'];
			$response_arr[$x]['weight'] = $select_patient_data_row['weight'];
			$response_arr[$x]['height'] = $select_patient_data_row['height'];
			$response_arr[$x]['blood_pressure'] = $select_todays_appointment_row['blood_pressure'];
			$response_arr[$x]['current_medication'] = '';
			if($select_todays_appointment_row['allergies_if_any'] != ''){
				$response_arr[$x]['allergies_if_any'] = $select_todays_appointment_row['allergies_if_any'];
			}else{
				$response_arr[$x]['allergies_if_any'] = 'No';
			}
			if($select_todays_appointment_row['current_medication'] != ''){
				$response_arr[$x]['current_medication'] = $select_todays_appointment_row['current_medication'];
			}else{
				$response_arr[$x]['current_medication'] = 'No';
			}
			$response_arr[$x]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
			$response_arr[$x]['any_surgeries'] = $select_todays_appointment_row['any_surgeries'];
			if($select_todays_appointment_row['any_metal_Implantation'] != ''){
				$response_arr[$x]['any_metal_Implantation'] = $select_todays_appointment_row['any_metal_Implantation'];
			}else{
				$response_arr[$x]['any_metal_Implantation'] = 'No';
			}
			$response_arr[$x]['email'] = '';
			$response_arr[$x]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
			$select_bmi_history = $obj_branch->selectData("height,weight,appointment_date,blood_pressure","tbl_appointment","where patient_id=$patient_id ORDER BY id DESC");
			if(mysqli_num_rows($select_bmi_history)>0){
				$x1 = 0;
				while($select_bmi_history_row = mysqli_fetch_array($select_bmi_history)){
					if($select_bmi_history_row['height']!= '' and $select_bmi_history_row['weight']!= '' and $select_bmi_history_row['height']!=0 and  $select_bmi_history_row['weight']!=0 and $select_bmi_history_row['height']!=00 and  $select_bmi_history_row['weight']!=00){
					$response_arr[$x]['BMI'][$x1]['height'] = $select_bmi_history_row['height'];
					$height = $select_bmi_history_row['height'];
					$weight = $select_bmi_history_row['weight'];
					$height_in_m = $height/100;
					$height_in_m *= $height_in_m;
					$BMI = round($weight/$height_in_m,2);
					
					$response_arr[$x]['BMI'][$x1]['weight'] = $select_bmi_history_row['weight'];
					$response_arr[$x]['BMI'][$x1]['blood_pressure'] = $select_bmi_history_row['blood_pressure'];
					$response_arr[$x]['BMI'][$x1]['BMIVal'] = $BMI;
					$appointment_date = $select_bmi_history_row['appointment_date'];
					$appointment_date_new = date('d-m-Y',strtotime($appointment_date));
					$response_arr[$x]['BMI'][$x1]['appointment_date_new'] = $appointment_date_new;
					$x1++;
					}else{
						if($select_bmi_history_row['height'] == ''){
						$response_arr[$x]['BMI'][$x1]['height'] = 0;
						}else{
						$response_arr[$x]['BMI'][$x1]['height'] = $select_bmi_history_row['height'];
						}
						
					if($select_bmi_history_row['weight'] == ''){
					$response_arr[$x]['BMI'][$x1]['weight'] = 0;
					}else{
					$response_arr[$x]['BMI'][$x1]['weight'] = $select_bmi_history_row['weight'];
					}
					$response_arr[$x]['BMI'][$x1]['blood_pressure'] = $select_bmi_history_row['blood_pressure'];
					$response_arr[$x]['BMI'][$x1]['BMIVal'] = '';
					$appointment_date = $select_bmi_history_row['appointment_date'];
					$appointment_date_new = date('d-m-Y',strtotime($appointment_date));
					$response_arr[$x]['BMI'][$x1]['appointment_date_new'] = $appointment_date_new;
					$x1++;
					}
					
				}
			}
			//exit();
			if($select_todays_appointment_row['appointment_status'] ==1){
				$waiting_count++;
			}else if($select_todays_appointment_row['appointment_status'] == 0){
				$pending_count++;
			}
			$x++;
		}
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	}else{
	$select_todays_appointment_patient = $obj_common->selectData("id,logind_id,branch_id,unique_id","tbl_patient","where status!=0 $search_data_where");
		if(mysqli_num_rows($select_todays_appointment_patient)>0){
			$x1 = 0;
			while($select_todays_appointment_patient_row = mysqli_fetch_array($select_todays_appointment_patient)){
				$patient_unique_id = $select_todays_appointment_patient_row['unique_id'];
				$patient_id_arr = explode("/",$patient_unique_id);
				$patient_id = $patient_id_arr[3];
				$branch_id = $select_todays_appointment_patient_row['branch_id'];
	$select_todays_appointment = $obj->selectData("tbl_appointment.id,tbl_appointment.doctor_id,tbl_appointment.branch_id,tbl_appointment.appointment_status,tbl_appointment.patient_id,tbl_appointment.appointment_number,tbl_appointment.height,tbl_appointment.weight,tbl_appointment.blood_pressure,tbl_appointment.allergies_if_any,tbl_appointment.current_medication,tbl_appointment.present_Illness,tbl_appointment.any_surgeries,tbl_appointment.any_metal_Implantation,tbl_doctor.doctor_name,tbl_appointment.first_visit","tbl_appointment inner join tbl_doctor on tbl_appointment.doctor_id = tbl_doctor.login_id","where tbl_appointment.status!=0 and tbl_appointment.appointment_status=2 $appointment_where and tbl_appointment.patient_id=$patient_id and  tbl_appointment.branch_id=$branch_id ORDER BY tbl_appointment.id DESC");
	//echo $select_todays_appointment;exit();
	if(mysqli_num_rows($select_todays_appointment)>0){
		$response_arr[0]['data_status'] = 1;
		//tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.id as patient_id
		$x = 0;
		$active_id = 0;
		if(isset($_SESSION['active_id'])){
				$active_id = $_SESSION['active_id'];	
			}else{
				$active_id = 0;
			}
		
		while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
			$patient_id = $select_todays_appointment_row['patient_id'];
			$branch = $select_todays_appointment_row['branch_id'];
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_patient_data = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.id as patient_id","tbl_patient","where id=$patient_id $search_data_where");
			if(mysqli_num_rows($select_patient_data)>0){
			$select_patient_data_row = mysqli_fetch_array($select_patient_data);
			$response_arr[$x]['id'] = $select_todays_appointment_row['id'];
			$response_arr[$x]['patient_id'] = $select_patient_data_row['patient_id'];
			$response_arr[$x]['branch'] = $branch;
			if($active_id == 0){
				if($x == 0){
					$response_arr[$x]['active'] = 1;
				}else{
					$response_arr[$x]['active'] = 0;
				}
			}else{
				if($select_todays_appointment_row['id'] == $active_id){
					$response_arr[$x]['active'] = 1;
				}else{
					$response_arr[$x]['active'] = 0;
				}
			}
				$select_first_visit = $obj_branch->selectData('first_visit,appointment_date',"tbl_appointment","where status = 1 and patient_id = $patient_id and branch_id = $branch order by id asc limit 1");
				//echo $select_first_visit;exit();
				if(mysqli_num_rows($select_first_visit)){
					$select_first_visit_rows = mysqli_fetch_assoc($select_first_visit);
					if($select_first_visit_rows['first_visit'] == ''){
						$response_arr[$x]['first_visit'] = $select_first_visit_rows['appointment_date'];
					}else{
						$response_arr[$x]['first_visit'] = $select_first_visit_rows['first_visit'];
					}
					
				}
			$response_arr[$x]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
			$patient_id = $select_patient_data_row['patient_id'];
			$response_arr[$x]['unique_id'] = $select_patient_data_row['unique_id'];
			$response_arr[$x]['patient_id'] = $patient_id;
			$response_arr[$x]['doctor_name'] = $select_todays_appointment_row['doctor_name'];
			if($select_todays_appointment_row['doctor_id'] == $login_id){
				$response_arr[$x]['to'] = 1;
			}else{
				$response_arr[$x]['to'] = 0;
			}
			$response_arr[$x]['name'] = $select_patient_data_row['name'];
			
			$response_arr[$x]['phone'] = $select_patient_data_row['phone'];
			$response_arr[$x]['address'] = $select_patient_data_row['address'];
			$response_arr[$x]['place'] = $select_patient_data_row['place'];
			$response_arr[$x]['age'] = $select_patient_data_row['age'];
			$response_arr[$x]['gender'] = $select_patient_data_row['gender'];
			$response_arr[$x]['weight'] = $select_patient_data_row['weight'];
			$response_arr[$x]['height'] = $select_patient_data_row['height'];
			$response_arr[$x]['blood_pressure'] = $select_todays_appointment_row['blood_pressure'];
			$response_arr[$x]['current_medication'] = '';
			if($select_todays_appointment_row['allergies_if_any'] != ''){
				$response_arr[$x]['allergies_if_any'] = $select_todays_appointment_row['allergies_if_any'];
			}else{
				$response_arr[$x]['allergies_if_any'] = 'No';
			}
			if($select_todays_appointment_row['current_medication'] != ''){
				$response_arr[$x]['current_medication'] = $select_todays_appointment_row['current_medication'];
			}else{
				$response_arr[$x]['current_medication'] = 'No';
			}
			$response_arr[$x]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
			$response_arr[$x]['any_surgeries'] = $select_todays_appointment_row['any_surgeries'];
			if($select_todays_appointment_row['any_metal_Implantation'] != ''){
				$response_arr[$x]['any_metal_Implantation'] = $select_todays_appointment_row['any_metal_Implantation'];
			}else{
				$response_arr[$x]['any_metal_Implantation'] = 'No';
			}
			$response_arr[$x]['email'] = '';
			$response_arr[$x]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
			$select_bmi_history = $obj_branch->selectData("height,weight,appointment_date,blood_pressure","tbl_appointment","where patient_id=$patient_id ORDER BY id DESC");
			if(mysqli_num_rows($select_bmi_history)>0){
				$x1 = 0;
				while($select_bmi_history_row = mysqli_fetch_array($select_bmi_history)){
					if($select_bmi_history_row['height']!= '' and $select_bmi_history_row['weight']!= '' and $select_bmi_history_row['height']!=0 and  $select_bmi_history_row['weight']!=0 and $select_bmi_history_row['height']!=00 and  $select_bmi_history_row['weight']!=00){
					$response_arr[$x]['BMI'][$x1]['height'] = $select_bmi_history_row['height'];
					$height = $select_bmi_history_row['height'];
					$weight = $select_bmi_history_row['weight'];
					$height_in_m = $height/100;
					$height_in_m *= $height_in_m;
					$BMI = round($weight/$height_in_m,2);
					
					$response_arr[$x]['BMI'][$x1]['weight'] = $select_bmi_history_row['weight'];
					$response_arr[$x]['BMI'][$x1]['blood_pressure'] = $select_bmi_history_row['blood_pressure'];
					$response_arr[$x]['BMI'][$x1]['BMIVal'] = $BMI;
					$appointment_date = $select_bmi_history_row['appointment_date'];
					$appointment_date_new = date('d-m-Y',strtotime($appointment_date));
					$response_arr[$x]['BMI'][$x1]['appointment_date_new'] = $appointment_date_new;
					$x1++;
					}else{
						if($select_bmi_history_row['height'] == ''){
						$response_arr[$x]['BMI'][$x1]['height'] = 0;
						}else{
						$response_arr[$x]['BMI'][$x1]['height'] = $select_bmi_history_row['height'];
						}
						
					if($select_bmi_history_row['weight'] == ''){
					$response_arr[$x]['BMI'][$x1]['weight'] = 0;
					}else{
					$response_arr[$x]['BMI'][$x1]['weight'] = $select_bmi_history_row['weight'];
					}
					$response_arr[$x]['BMI'][$x1]['blood_pressure'] = $select_bmi_history_row['blood_pressure'];
					$response_arr[$x]['BMI'][$x1]['BMIVal'] = '';
					$appointment_date = $select_bmi_history_row['appointment_date'];
					$appointment_date_new = date('d-m-Y',strtotime($appointment_date));
					$response_arr[$x]['BMI'][$x1]['appointment_date_new'] = $appointment_date_new;
					$x1++;
					}
					
				}
			}
			//exit();
			if($select_todays_appointment_row['appointment_status'] ==1){
				$waiting_count++;
			}else if($select_todays_appointment_row['appointment_status'] == 0){
				$pending_count++;
			}
			$x++;
		}
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	}
	}
	}
	$response_arr[0]['waiting_count'] = $waiting_count;
	$response_arr[0]['pending_count'] = $pending_count;
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
//echo "haii";exit();
//print_r($response_arr);
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