<?php
session_start();
require_once '../_class/query.php';
include_once '../admin/action/security/unique_code.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$username = $_POST['username'];
$pwd = $_POST['pwd'];
$pwd_to_lower = strtolower($pwd);
$pwd_to_lower_eny = md5($pwd_to_lower);
$select_data = $obj->selectData("id,role","tbl_login","where user_name='$username' and password='$pwd_to_lower_eny' and status!=0");
if(mysqli_num_rows($select_data)>0){
	while($select_data_row = mysqli_fetch_array($select_data)){
		$response_arr[0]['status'] = 0;
		$login_id =  $select_data_row['id'];
		$response_arr[0]['role'] = $select_data_row['role'];
		if($select_data_row['role'] == 'admin'){
		$_SESSION['admin_login_id'] = $select_data_row['id'];
		$_SESSION['admin_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['admin_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$_SESSION['admin_domain'] = '';
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		}else if($select_data_row['role']  == 'doctor'){
		$_SESSION['doctor_login_id'] = $select_data_row['id'];
		$_SESSION['doctor_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['doctor_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_doctor'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['doctor_domain'] = '';
		}else if($select_data_row['role']  == 'staff'){
		$_SESSION['staff_login_id'] = $login_id;
		$_SESSION['staff_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['staff_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_staff'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['staff_domain'] = '';
		}else if($select_data_row['role']  == 'treatment_staff'){
		$_SESSION['staff_login_id'] = $login_id;
		$_SESSION['staff_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['staff_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_staff'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['staff_domain'] = '';
		}else if($select_data_row['role']  == 'nurse'){
		$_SESSION['nurse_login_id'] = $login_id;
		$_SESSION['nurse_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['nurse_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_nurse'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['staff_domain'] = '';
		}else if($select_data_row['role']  == 'lab'){
		$_SESSION['lab_login_id'] = $login_id;
		$_SESSION['lab_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['lab_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_lab'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['staff_domain'] = '';
		}
		
	}
}else{
	$select_data_phn = $obj->selectData("id,role","tbl_login","where phone_number='$username' and password='$pwd_to_lower_eny' and status!=0");
	if(mysqli_num_rows($select_data_phn)>0){
	while($select_data_row = mysqli_fetch_array($select_data_phn)){
		$response_arr[0]['status'] = 0;
		$login_id =  $select_data_row['id'];
		$response_arr[0]['role'] = $select_data_row['role'];
		if($select_data_row['role'] == 'admin'){
		$_SESSION['admin_login_id'] = $select_data_row['id'];
		$_SESSION['admin_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['admin_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$_SESSION['admin_domain'] = '';
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		}else if($select_data_row['role']  == 'staff'){
		$_SESSION['staff_login_id'] = $select_data_row['id'];
		$_SESSION['staff_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['staff_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_staff'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['staff_domain'] = '';
		}else if($select_data_row['role']  == 'doctor'){
		$_SESSION['doctor_login_id'] = $select_data_row['id'];
		$_SESSION['doctor_role'] = $select_data_row['role'];
		$unique_id = randomPassword();
		$_SESSION['doctor_unique_code'] = $unique_id;
		$Api_key = fetch_Api_Key($obj);
		$Api_key_compain = $Api_key.''.$unique_id;
		$_SESSION['api_key_value_doctor'] = $Api_key_compain;
		$info_update_unique = array(
			"unique_code" => $unique_id,
			"last_login" => $days.' '.$times,
		);
		$obj->updateData("tbl_login",$info_update_unique,"where id=$login_id");
		$_SESSION['doctor_domain'] = '';
		}
		
	}
}else{
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = '*UserName Or Password Is Incorrect!';
	}
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