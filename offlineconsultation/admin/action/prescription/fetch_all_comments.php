<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
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
$date_arr = [];
	//echo $check_security;exit();
if($check_security == 1){
	$patient_id = $_POST['patient_id'];
	$branch = $_POST['branch_id'];
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$select_all_comments = $obj_branch->selectData("DISTINCT added_date","tbl_comments","where patient_id='$patient_id' and status!=0 ORDER BY id DESC");
	if(mysqli_num_rows($select_all_comments)>0){
		$response_arr[0]['data_status'] = 1;
		while($select_all_comments_row = mysqli_fetch_array($select_all_comments)){
			array_push($date_arr,$select_all_comments_row['added_date']);
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	 $date_arr_size = sizeof($date_arr);
	$x1 = 0;
	for($x = 0;$x<$date_arr_size;$x++){
		$added_date = $date_arr[$x];
		$response_arr[$x1]['added_date'] = $added_date;
		$select_all_data = $obj_branch->selectData("id,comment","tbl_comments","where patient_id='$patient_id' and added_date = '$added_date' and status!=0 ORDER BY id DESC");
		if(mysqli_num_rows($select_all_data)>0){
			$y = 0;
			while($select_all_data_row = mysqli_fetch_array($select_all_data)){
				$response_arr[$x1]['comment_data'][$y]['comment'] = $select_all_data_row['comment'];
				$response_arr[$x1]['comment_data'][$y]['id'] = $select_all_data_row['id'];
				$y++;
			}
		}
		$x1++;
	}
	//tbl_prescription_medicine_data
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'success';
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