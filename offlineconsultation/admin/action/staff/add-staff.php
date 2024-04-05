<?php
session_start();
require '../smtp/PHPMailerAutoload.php';
$mail = new PHPMailer(true);
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../send_mail/mail.php';
require_once '../../../_class/query.php';
$Username = 'counsultation@jmwell.in';
$Password = '5b2*1nDf';
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
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$staff_name = $_POST['staff_name'];
	$phone_no = $_POST['staff_phn'];
	$branch_name = $_POST['branch_name'];
	$staff_email = $_POST['staff_email'];
	$role = $_POST['role'];
	//login data
	$phn_validate = validate_phn($phone_no,$obj);
	$email_validate = validate_email($staff_email,$obj);
	if($phn_validate !=1 and $email_validate!=1){
	//$pwd_details = randomPassword();
	//$pwd_details_converted = strtolower($pwd_details);
	$pwd_details = '123456';
	$pwd_details_converted = strtolower($pwd_details);
	$pwd_details_converted_encrypt = md5($pwd_details_converted);
	$info_doctor_login = array(
		"user_name" => $staff_email,
		"password" => $pwd_details_converted_encrypt,
		"phone_number" => $phone_no,
		"role" => $role,
		"status" => 1
	);
	$obj->insertData("tbl_login",$info_doctor_login);
	$select_login_id = $obj->selectData("id","tbl_login","where user_name='$staff_email' and password='$pwd_details_converted_encrypt' and phone_number='$phone_no' and role='$role' and status=1");
	if(mysqli_num_rows($select_login_id)){
		while($select_login_id_row = mysqli_fetch_array($select_login_id)){
			$new_login_id = $select_login_id_row['id'];
				$info_staff = array(
					"staff_name" => $staff_name,
					"login_id" => $new_login_id,
					"staff_phone" => $phone_no,
					"staff_email" => $staff_email,
					"branch_id" => $branch_name,
					"added_date" => $days,
					"added_time" => $times,
					"added_id" => $login_id,
					"status" => 1
				);
	$obj->insertData("tbl_staff",$info_staff);
		}
	}
login_details_mailer($mail,$staff_email,$staff_name,$staff_email,$phone_no,$pwd_details,'Login Credentials Jhonmarians Staff Panel');
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

	function validate_phn($phone_no,$obj){
		$phn_res = 1;
		$check_phn = $obj->selectData("id","tbl_login","where phone_number='$phone_no' and status!=0");
		if(mysqli_num_rows($check_phn)>0){
			$phn_res = 1;
		}else{
			$phn_res = 0;
		}
		return $phn_res;
	}
	function validate_email($email,$obj){
		$email_res = 1;
		$check_email = $obj->selectData("id","tbl_login","where user_name='$email' and status!=0");
		if(mysqli_num_rows($check_email)>0){
			$email_res = 1;
		}else{
			$email_res = 0;
		}
		return $email_res;
	}

?>