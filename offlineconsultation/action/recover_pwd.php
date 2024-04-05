<?php
session_start();
require '../admin/action/smtp/PHPMailerAutoload.php';
$mail = new PHPMailer(true);
require_once '../admin/action/send_mail/mail.php';
require_once '../_class/query.php';
include_once '../admin/action/security/unique_code.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$username = $_POST['email'];
$check_pwd_exist = $obj->selectData("id,role,user_name,status","tbl_login","where user_name='$username'");
if(mysqli_num_rows($check_pwd_exist)>0){
	$response_arr[0]['status'] = 1;
	while($check_pwd_exist_row = mysqli_fetch_array($check_pwd_exist)){
		$user_name = $check_pwd_exist_row['user_name'];
		$role = $check_pwd_exist_row['role'];
		$login_id = $check_pwd_exist_row['id'];
		$status = $check_pwd_exist_row['status'];
		if($status !=0){
		$staff_name = '';
		if($role == 'staff'){
			$select_name = $obj->selectData("staff_name","tbl_staff","where login_id=$login_id");
			if(mysqli_num_rows($select_name)>0){
				while($select_name_row = mysqli_fetch_array($select_name)){
					$staff_name = $select_name_row['staff_name'];
				}
			}
		}else if($role == 'doctor'){
			$select_name = $obj->selectData("doctor_name","tbl_doctor","where login_id=$login_id");
			if(mysqli_num_rows($select_name)>0){
				while($select_name_row = mysqli_fetch_array($select_name)){
					$staff_name = $select_name_row['doctor_name'];
				}
			}
		}else if($role == 'admin'){
			$select_name = $obj->selectData("user_name","tbl_admin_reg","where login_id=$login_id");
			if(mysqli_num_rows($select_name)>0){
				while($select_name_row = mysqli_fetch_array($select_name)){
					$staff_name = $select_name_row['user_name'];
				}
			}
		}
		$pwd = randomPassword();
		$pwd_to_lower = strtolower($pwd);
		$pwd_to_lower_eny = md5($pwd_to_lower);
		$return_val = fwd_details_mailer($mail,$user_name,$pwd,$staff_name,'Recover Password');
		if($return_val == 1){
			$info_update_pwd = array(
				"password" => $pwd_to_lower_eny
			);
			$obj->updateData("tbl_login",$info_update_pwd,"where id=$login_id");
			$response_arr[0]['status'] = 1;
			$response_arr[0]['msg'] = "Success. Check Your Mail";
		}else{
			$response_arr[0]['status'] = 0;
			$response_arr[0]['error_log'] = "Something Went Wrong! Try Again";
		}
		}else{
			$response_arr[0]['status'] = 0;
			$response_arr[0]['error_log'] = "Account Is Removed By Admin!";
		}

	}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['error_log'] = "Email Not Found In Our System!";
}


echo json_encode($response_arr);

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
?>