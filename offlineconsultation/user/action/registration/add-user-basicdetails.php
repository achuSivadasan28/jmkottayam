<?php
session_start();
require '../../../admin/action/smtp/PHPMailerAutoload.php';
$mail = new PHPMailer(true);
if(isset($_SESSION['phn_number'])){
$phn_number = $_SESSION['phn_number'];
require_once '../../../_class/query.php';
require_once '../../../admin/action/send_mail/mail.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$current_Y=date('Y');
$times=date('h:i:s A');
$Name = $_POST['Name'];
$number_data = $_POST['number_data'];
$email = $_POST['email'];
if($number_data == $phn_number){
	$select_last_id = $obj->selectData("no,code","tbl_patient","where status!='' ORDER BY id DESC limit 1");
	if(mysqli_num_rows($select_last_id)>0){
		$select_last_id_row = mysqli_fetch_array($select_last_id);
		$no = $select_last_id_row['no'];
		$code = $select_last_id_row['code'];
		$new_no = $no+1;
		$new_unique_id = $code.'/'.$current_Y.'/'.$new_no;
		$user_pwd = randomPassword();
		$pwd_details_converted = strtolower($user_pwd);
		$pwd_details_converted_encrypt = md5($pwd_details_converted);
		$check_number_data = validate_phn($number_data,$obj);
		$email_validate = validate_email($email,$obj);
		if($check_number_data !=1 and $email_validate!=1){
		$info_login_data = array(
			"user_name" => $email,
			"password" => $pwd_details_converted_encrypt,
			"phone_number" => $number_data,
			"role" => 'patient',
			"status" => 1
		);
		$obj->insertData("tbl_login",$info_login_data);
		$select_login_data = $obj->selectData("id","tbl_login","where user_name='$email' and password='$pwd_details_converted_encrypt' and phone_number='$number_data' and role='patient' and status=1");
		if(mysqli_num_rows($select_login_data)>0){
			$select_login_data_row = mysqli_fetch_array($select_login_data);
			$log_id = $select_login_data_row['id'];
			$_SESSION['patient_login_id'] = $log_id;
			$info_insert_arr = array(
				"code" => $code,
				"no" => $new_no,
				"unique_id" => $new_unique_id,
				"name" => $Name,
				"phone" => $number_data,
				"logind_id" => $log_id,
				"online_account_status" => 1
			);
			$obj->insertData("tbl_patient",$info_insert_arr);
		login_details_mailer($mail,$email,$Name,$email,$number_data,$user_pwd,'Login Credentials Jhonmarians User Panel');
			$response_arr[0]['status'] = 1;
			$response_arr[0]['msg'] = 'Account Created Successfully';
		}else{
			$response_arr[0]['status'] = 0;
			$response_arr[0]['error_log'] = 'Something Went Wrong! Try Again';
		}
		}else{
				$response_arr[0]['status'] = 2;
				$response_arr[0]['phn_error'] = '';
				$response_arr[0]['email_error'] = '';
				if($check_number_data == 1){
					$response_arr[0]['phn_error'] = 'Phone Number Already Exist!';
				}
				if($email_validate == 1){
					$response_arr[0]['email_error'] = 'Email Already Exist!';
				}
				$response_arr[0]['msg'] = 'Duplication Occurs';
			}
		//tbl_login

		
	}else{
			$response_arr[0]['status'] = 0;
			$response_arr[0]['error_log'] = 'Something Went Wrong! Try Again';
	}

	//tbl_patient
}else{
	$response_arr[0]['status'] = 3;
	$response_arr[0]['error_log'] = 'Invalid Phone Number';
}
}else{
		$response_arr[0]['status'] = 3;
		$response_arr[0]['error_log'] = 'Invalid Phone Number';
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