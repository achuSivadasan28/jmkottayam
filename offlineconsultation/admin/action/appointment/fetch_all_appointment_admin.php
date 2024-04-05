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
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$search_val = $_POST['search_val'];
	$limit_range = $_POST['limit_range'];
	$where_date_clause = '';
	$where_date_serach = '';
	$response_arr[0]['current_date'] = '';
	if($search_val != ''){
		$search_val = trim($search_val," ");
		$where_date_serach = " and (tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' or tbl_patient.unique_id like '%$search_val%')";
	}
	if($start_date != '' and $end_date == ''){
		$where_date_clause = " and tbl_appointment.appointment_date='$start_date'";
	}else if($end_date !='' and $start_date == ''){
		$where_date_clause = " and tbl_appointment.appointment_date='$end_date'";
	}else if($start_date !='' and $end_date !=''){
		$new_start_Date = date("Y-m-d", strtotime($start_date));
		$new_end_Date = date("Y-m-d", strtotime($end_date));
		$End_new_Date = strtotime($new_end_Date);
		$start_new_Date = strtotime($new_start_Date);
		$date_diff = ($End_new_Date-$start_new_Date)/60/60/24;
		
		if($date_diff!=0){
			$where_date_clause = " and (";
			for($x1=0;$x1<=$date_diff;$x1++){
				$new_date = date('Y-m-d',strtotime($new_start_Date . ' +'.$x1.' day'));
				if($x1 == $date_diff){
					$where_date_clause .= "tbl_appointment.appointment_date='$new_date')";
				}else{
					$where_date_clause .= "tbl_appointment.appointment_date='$new_date' or ";
				}
			}
		}
	}else{
		//$where_date_clause = " and tbl_appointment.appointment_date='$days_re'";
		//$response_arr[0]['current_date'] = $days_re;
	}
	if($where_date_serach == ''){
	$select_todays_appointment = $obj->selectData("tbl_appointment.id as app_id,tbl_appointment.appointment_number,tbl_appointment.present_Illness,tbl_appointment.patient_id,tbl_appointment.appointment_date,tbl_appointment.branch_id,tbl_appointment.appointment_status,tbl_doctor.doctor_name,tbl_appointment.consulted_by,tbl_appointment.status as appointmentstatus","tbl_appointment inner join tbl_doctor on tbl_appointment.doctor_id=tbl_doctor.login_id","where tbl_appointment.status!=2 and tbl_appointment.cross_branch_status=0 $where_date_clause ORDER BY tbl_appointment.id desc limit $limit_range");
		if(mysqli_num_rows($select_todays_appointment)>0){
		$response_arr[0]['data_status'] = 1;
		$x1 = 0;
		while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
			
			$patient_id = $select_todays_appointment_row['patient_id'];
			$branch_id = $select_todays_appointment_row['branch_id'];
			$branch = $branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			//tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone
			$select_patient_data = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place","tbl_patient","where id=$patient_id $where_date_serach");
			if(mysqli_num_rows($select_patient_data)>0){
				$select_patient_data_row = mysqli_fetch_array($select_patient_data);
				$consulted_by = $select_todays_appointment_row['consulted_by'];
				//echo "consulted_by ".$consulted_by;exit();
				if($consulted_by != '' and $consulted_by != 0){
					$select_doctor_name = $obj->selectData("doctor_name","tbl_doctor","where login_id=$consulted_by");
					if(mysqli_num_rows($select_doctor_name)>0){
						$select_doctor_name_row = mysqli_fetch_array($select_doctor_name);
						$response_arr[$x1]['doctor_name'] = $select_doctor_name_row['doctor_name'];
					}
				}else{
					$response_arr[$x1]['doctor_name'] = $select_todays_appointment_row['doctor_name'];
				}
				$response_arr[$x1]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
				
				$response_arr[$x1]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
				$appointment_date_new = date('d/m/Y',strtotime($select_todays_appointment_row['appointment_date']));
				$response_arr[$x1]['id'] = $select_todays_appointment_row['app_id'];
				$response_arr[$x1]['appointment_date'] = $appointment_date_new;
				$response_arr[$x1]['unique_id'] = $select_patient_data_row['unique_id'];
				$response_arr[$x1]['name'] = $select_patient_data_row['name'];
				$response_arr[$x1]['phone'] = $select_patient_data_row['phone'];
				$response_arr[$x1]['place'] = $select_patient_data_row['place'];
				$response_arr[$x1]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
				$response_arr[$x1]['appointmentstatus'] = $select_todays_appointment_row['appointmentstatus'];
				$x1++;
		}
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	}else{
		$response_arr[0]['data_status'] = 0;
		$select_todays_appointment_patient = $obj_common->selectData("id,logind_id,branch_id,unique_id,patient_pk","tbl_patient","where status!=0 $where_date_serach");
		if(mysqli_num_rows($select_todays_appointment_patient)>0){
			$x1 = 0;
			while($select_todays_appointment_patient_row = mysqli_fetch_array($select_todays_appointment_patient)){
				$patient_unique_id = $select_todays_appointment_patient_row['unique_id'];
				$patient_id_arr = explode("/",$patient_unique_id);
				//$patient_id = $patient_id_arr[3];
				$patient_id = $select_todays_appointment_patient_row['patient_pk'];
				$branch_id = $select_todays_appointment_patient_row['branch_id'];
				$select_todays_appointment = $obj->selectData("tbl_appointment.id as 	app_id,tbl_appointment.appointment_number,tbl_appointment.present_Illness,tbl_appointment.patient_id,tbl_appointment.appointment_date,tbl_appointment.branch_id,tbl_appointment.appointment_status,tbl_doctor.doctor_name,tbl_appointment.consulted_by,tbl_appointment.status as appointmentstatus","tbl_appointment inner join tbl_doctor on tbl_appointment.doctor_id=tbl_doctor.login_id","where tbl_appointment.status!=2 and tbl_appointment.cross_branch_status=0 and tbl_appointment.patient_id=$patient_id and tbl_appointment.branch_id=$branch_id $where_date_clause ORDER BY tbl_appointment.id desc");
				if(mysqli_num_rows($select_todays_appointment)>0){
		$response_arr[0]['data_status'] = 1;
		
		while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
			
			$patient_id = $select_todays_appointment_row['patient_id'];
			$branch_id = $select_todays_appointment_row['branch_id'];
			$branch = $branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			//tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone
			$select_patient_data = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place","tbl_patient","where id=$patient_id $where_date_serach");
			if(mysqli_num_rows($select_patient_data)>0){
				$select_patient_data_row = mysqli_fetch_array($select_patient_data);
				$consulted_by = $select_todays_appointment_row['consulted_by'];
				//echo "consulted_by ".$consulted_by;exit();
				if($consulted_by != '' and $consulted_by != 0){
					$select_doctor_name = $obj->selectData("doctor_name","tbl_doctor","where login_id=$consulted_by");
					if(mysqli_num_rows($select_doctor_name)>0){
						$select_doctor_name_row = mysqli_fetch_array($select_doctor_name);
						$response_arr[$x1]['doctor_name'] = $select_doctor_name_row['doctor_name'];
					}
				}else{
					$response_arr[$x1]['doctor_name'] = $select_todays_appointment_row['doctor_name'];
				}
				$response_arr[$x1]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
				
				$response_arr[$x1]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
				$appointment_date_new = date('d/m/Y',strtotime($select_todays_appointment_row['appointment_date']));
				$response_arr[$x1]['id'] = $select_todays_appointment_row['app_id'];
				$response_arr[$x1]['appointment_date'] = $appointment_date_new;
				$response_arr[$x1]['unique_id'] = $select_patient_data_row['unique_id'];
				$response_arr[$x1]['name'] = $select_patient_data_row['name'];
				$response_arr[$x1]['phone'] = $select_patient_data_row['phone'];
				$response_arr[$x1]['place'] = $select_patient_data_row['place'];
				$response_arr[$x1]['appointmentstatus'] = $select_todays_appointment_row['appointmentstatus'];
				$response_arr[$x1]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
				$x1++;
		}
		}
	}else{
		if($response_arr[0]['data_status'] != 1){
			$response_arr[0]['data_status'] = 0;
		}
		//$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
			}
		}
	}

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
?>