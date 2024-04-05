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
$c_year = date('Y');
if(isset($_SESSION['staff_login_id'])){
	$login_id = $_SESSION['staff_login_id'];
	$staff_role = $_SESSION['staff_role'];
	$staff_unique_code = $_SESSION['staff_unique_code'];
	if($staff_role == 'staff'){
		$api_key_value = $_SESSION['api_key_value_staff'];
		$staff_unique_code = $_SESSION['staff_unique_code'];
		$Api_key = fetch_Api_Key($obj);
		$admin_live_unique_code = fetch_unique_code($obj,$login_id);
		$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
		//echo $check_security;exit();
		if($check_security == 1){

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
			if(isset($_SESSION['staff_login_id'])){
				$login_id = $_SESSION['staff_login_id'];
				$staff_role = $_SESSION['staff_role'];
				$staff_unique_code = $_SESSION['staff_unique_code'];
				if($staff_role == 'staff'){
					$api_key_value = $_SESSION['api_key_value_staff'];
					$staff_unique_code = $_SESSION['staff_unique_code'];
					$Api_key = fetch_Api_Key($obj);
					$admin_live_unique_code = fetch_unique_code($obj,$login_id);
					$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
					//echo $check_security;exit();
					if($check_security == 1){
						$apmnt_id = $_POST['id'];
						$select_last_modepayid = $obj->selectData("max(id) as modepay_id","tbl_appointment_modeinvoice","where status !=0 and 	appointment_id=$apmnt_id order by id desc limit 1");
						#echo $select_last_modepayid;
						#exit();
						if(mysqli_num_rows($select_last_modepayid)>0){
							while($select_last_id_row = mysqli_fetch_array($select_last_modepayid)){
								$tbl_id = $select_last_id_row['modepay_id'];
								$select_payment_details = $obj->selectData("id,payment_id,payment_amnt","tbl_appoinment_payment","where tbl_apmnt_mode_payid = $tbl_id and status != 0");
								#echo $select_payment_details;
								#exit();
								if(mysqli_num_rows($select_payment_details)>0){
									$x = 0;
									while($select_payment_details_rows  = mysqli_fetch_assoc($select_payment_details)){
										$response_arr[$x]['payment_id'] = $select_payment_details_rows['payment_id'];
										$response_arr[$x]['payment_amnt'] = $select_payment_details_rows['payment_amnt'];
										$response_arr[$x]['id'] = $select_payment_details_rows['id'];
										$x++;

									}

								}

							}
							//$response_arr[0] = ['data_status'=>1,'message' => "success"];
						}else{
							$response_arr = ['data_status'=>0,'message' => "failed"];
						}
					}else{
						$response_arr = ['data_status'=>0,'login_status' => 0];

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

	}
}



?>