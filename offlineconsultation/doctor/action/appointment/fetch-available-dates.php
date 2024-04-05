<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$c_year = date('Y');
$curr_year = date('y');
$real_branch_id = 5;
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$doctor_role = $_SESSION['doctor_role'];
$doctor_unique_code = $_SESSION['doctor_unique_code'];
if($doctor_role == 'doctor'){
$api_key_value = $_SESSION['api_key_value_doctor'];
$doctor_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$doctor_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$current_month = $_POST['month'] + 1;
	$current_year = $_POST['year'];
	$select_dateby_year = $obj->selectData("distinct reffered_year","tbl_reffered_dates","where doctor_id = $login_id and status = 1 and reffered_year >= $current_year order by reffered_year desc");
	//echo $select_dateby_year;exit();
	if(mysqli_num_rows($select_dateby_year)>0){
		$x = 0;
		while($select_dateby_year_rows = mysqli_fetch_assoc($select_dateby_year)){
			$reffered_year = $select_dateby_year_rows['reffered_year'];
			$response_arr[$x]['year'] = $select_dateby_year_rows['reffered_year'];
			$select_dateby_month = $obj->selectData("distinct reffered_month","tbl_reffered_dates","where doctor_id = $login_id and status = 1 and reffered_year = $reffered_year and reffered_month >= $current_month order by reffered_month desc ");
			if(mysqli_num_rows($select_dateby_month)>0){
				$y = 0;
				while($select_dateby_month_rows = mysqli_fetch_assoc($select_dateby_month)){
					$response_arr[$x]['years'][$y]['month'] = $select_dateby_month_rows['reffered_month'];
					$reffered_month = $select_dateby_month_rows['reffered_month'];
					$select_reffered_date = $obj->selectData("reffered_date,id","tbl_reffered_dates","where doctor_id = $login_id and status = 1 and reffered_year = $reffered_year and reffered_month = $reffered_month order by reffered_date asc ");
					
					
					if(mysqli_num_rows($select_reffered_date)>0){
						$z = 0;
						while($select_reffered_date_rows = mysqli_fetch_assoc($select_reffered_date)){
							$response_arr[$x]['years'][$y]['months'][$z]['date'] = $select_reffered_date_rows['reffered_date'];
							$response_arr[$x]['years'][$y]['months'][$z]['id'] = $select_reffered_date_rows['id'];
							$reffered_date = $select_reffered_date_rows['reffered_date'];
							$select_reffered_app = $obj->selectData('id','tbl_appointment',"where reffer_status = $login_id and reffered_date = '$reffered_date' and status = 1");
							//echo $select_reffered_app;exit();
							$response_arr[$x]['years'][$y]['months'][$z]['noofapp'] = mysqli_num_rows($select_reffered_app);
							
							
						  $z++;
						}
					
					}
				$y++;
				}
			}
			$x++;
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