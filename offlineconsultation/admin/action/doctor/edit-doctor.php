<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
if(isset($_SESSION['admin_login_id'])){
$login_id = $_SESSION['admin_login_id'];
$admin_role = $_SESSION['admin_role'];
$admin_unique_code = $_SESSION['admin_unique_code'];
if($admin_role == 'admin'){
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$time_slot_check_id_data = $_POST['time_slot_check_id_data'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$doctor_name = $_POST['doctor_name'];
	$phnNo = $_POST['phnNo'];
	$email = $_POST['email'];
	$department_data = $_POST['department_data'];
	$branch_data = $_POST['branch_data'];
	$role =$_POST['role'];
	$val = $_POST['val'];
	$time_slot_arr = $_POST['time_slot'];
	$login_id_data1 = 0;
		$select_log_id = $obj->selectData("login_id","tbl_doctor","where id=$val");
	if(mysqli_num_rows($select_log_id)>0){
		while($select_log_id_row = mysqli_fetch_array($select_log_id)){
			$login_id_data1 = $select_log_id_row['login_id'];
		}
	}
	$phn_validate = validate_phn($phnNo,$login_id_data1,$obj);
	$email_validate = validate_email($email,$login_id_data1,$obj);
	if($phn_validate !=1 and $email_validate!=1){
	$info_branch = array(
		"doctor_name" => $doctor_name,
		"phone_no" => $phnNo,
		"email" => $email,
		"department_id" => $department_data,
		"branch_id" => $branch_data,
	);
	$obj->updateData("tbl_doctor",$info_branch,"where id=$val");
	$select_log_id = $obj->selectData("login_id","tbl_doctor","where id=$val");
	if(mysqli_num_rows($select_log_id)>0){
		while($select_log_id_row = mysqli_fetch_array($select_log_id)){
			$login_id_data = $select_log_id_row['login_id'];
			$update_log_data = array(
				"user_name" => $email,
				"phone_number" => $phnNo,
				"role" => $role,
			);
			$obj->updateData("tbl_login",$update_log_data,"where id=$login_id_data");
			//$login_id_data
		}
	}
		$already_add_time_slot = array();
		if($time_slot_check_id_data !=0){
		if(sizeof($time_slot_arr) !=0){
			$select_prev_check = $obj->selectData("time_slot_id","tbl_doctor_appointment_slot","where doctor_id=$login_id_data and status=1");
			if(mysqli_num_rows($select_prev_check)>0){
				while($select_prev_check_row = mysqli_fetch_array($select_prev_check)){
					array_push($already_add_time_slot,$select_prev_check_row['time_slot_id']);
				}
			}
			
			for($v1=0;$v1<sizeof($already_add_time_slot);$v1++){
				$time_slot_id = $already_add_time_slot[$v1];
				if(!in_array($time_slot_id,$time_slot_arr)){
					$info_doctor_slot = array(
						"status" => 0
					);
					$obj->updateData("tbl_doctor_appointment_slot",$info_doctor_slot,"where doctor_id=$login_id_data and time_slot_id=$time_slot_id");
				}
			}
			
			for($v2=0;$v2<sizeof($time_slot_arr);$v2++){
				$time_slot_id_new = $time_slot_arr[$v2];
				if(!in_array($time_slot_id_new,$already_add_time_slot)){
					$info_add_time_slot = array(
						"time_slot_id" => $time_slot_id_new,
						"doctor_id" => $login_id_data,
						"added_date" => $days,
						"added_time" => $times,
						"added_by" => $login_id,
						"status" => 1
					);
					$obj->insertData("tbl_doctor_appointment_slot",$info_add_time_slot);
					//tbl_doctor_appointment_slot
				}
			}
			
		}else{
			$info_doctor_slot = array(
				"status" => 0
			);
			$obj->updateData("tbl_doctor_appointment_slot",$info_doctor_slot,"where doctor_id=$login_id_data");
			//tbl_doctor_appointment_slot
		}
		}else{
			$info_doctor_slot = array(
				"status" => 0
			);
			$obj->updateData("tbl_doctor_appointment_slot",$info_doctor_slot,"where doctor_id=$login_id_data");
		}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	}else{
	$response_arr[0]['status'] = 2;
	$response_arr[0]['phn_error'] = '';
	$response_arr[0]['email_error'] = '';
	if($phn_validate == 1){
		$response_arr[0]['phn_error'] = 'Phone Number Already Exist!';
	}
	if($email_validate == 1){
		$response_arr[0]['email_error'] = 'Email Already Exist!';
	}
	$response_arr[0]['msg'] = 'Duplication Occurs';
	}
	//tbl_branch
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

	function validate_phn($phone_no,$log_id,$obj){
		$phn_res = 1;
		$check_phn = $obj->selectData("id","tbl_login","where phone_number='$phone_no' and status!=0 and id!=$log_id");
		if(mysqli_num_rows($check_phn)>0){
			$phn_res = 1;
		}else{
			$phn_res = 0;
		}
		return $phn_res;
	}
	function validate_email($email,$log_id,$obj){
		$email_res = 1;
		$check_email = $obj->selectData("id","tbl_login","where user_name='$email' and status!=0 and id!=$log_id");
		if(mysqli_num_rows($check_email)>0){
			$email_res = 1;
		}else{
			$email_res = 0;
		}
		return $email_res;
	}
?>