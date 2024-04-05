<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_common/query_common.php';

$response_arr = array();
$obj = new query();
$obj_common = new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days1 = date('Y-m-d');
$times=date('h:i:s A');
$currect_month = date('m');
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
	$number = $_POST['phone_num'];
	$user_name = $_POST['user_name'];
	$branch_id = $_POST['branch_id'];
	if($branch_id == 0){
		$response_arr[0]['branch_id'] = 0;
	$visit_limit = 0;
	$date_limit = 0;
	$select_add_fee_date_limit = $obj->selectData("visit_limit,date_limit","tbl_appointment_fee","where status=1");
	if(mysqli_num_rows($select_add_fee_date_limit)>0){
		while($select_add_fee_date_limit_row = mysqli_fetch_array($select_add_fee_date_limit)){
			$visit_limit = $select_add_fee_date_limit_row['visit_limit'];
			$date_limit = $select_add_fee_date_limit_row['date_limit'];
		}
	}
	$appointment_date = '';
	$appointment_id = 0;
	$check_last_appointmnet_with_fee = $obj->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
		$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
		$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
		$appointment_id = $check_last_appointmnet_with_fee_row['id'];
	}
	
	$check_phn = $obj->selectData("id,unique_id,name,phone,address,place,age,gender,whatsApp,patient_type","tbl_patient","where phone='$number' and name='$user_name' and  status!=0");
	if(mysqli_num_rows($check_phn)>0){
		$response_arr[0]['data_exist'] = 1;
		while($check_phn_row = mysqli_fetch_array($check_phn)){
			$response_arr[0]['id'] = $check_phn_row['id'];
			$patient_id = $check_phn_row['id'];
			$doctor_name = '';
			$check_last_appointmnet_with_fee = $obj->selectData("consulted_by,height,weight","tbl_appointment","where status!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
			
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
		    $response_arr[0]['height'] = $check_last_appointmnet_with_fee_row['height'];
		    $response_arr[0]['weight'] = $check_last_appointmnet_with_fee_row['weight'];
			$doctor_id = $check_last_appointmnet_with_fee_row['consulted_by'];
			$select_doctor_name = $obj->selectData("doctor_name","tbl_doctor","where login_id=$doctor_id");
			if(mysqli_num_rows($select_doctor_name)>0){
				$select_doctor_name_row = mysqli_fetch_array($select_doctor_name);
				$doctor_name = $select_doctor_name_row['doctor_name'];
				}
			}
			$response_arr[0]['doctor_name'] = $doctor_name;
			$response_arr[0]['unique_id'] = $check_phn_row['unique_id'];
			$unique_id = $check_phn_row['unique_id'];
			$response_arr[0]['phone'] = $check_phn_row['phone'];
			$response_arr[0]['address'] = $check_phn_row['address'];
			$response_arr[0]['place'] = $check_phn_row['place'];
			$response_arr[0]['age'] = $check_phn_row['age'];
			$response_arr[0]['gender'] = $check_phn_row['gender'];
			$response_arr[0]['whatsApp'] = $check_phn_row['whatsApp'];
			if($check_phn_row['patient_type'] == 'N' || $check_phn_row['patient_type'] == ''){
			$select_First_visit = $obj->selectData("first_visit","tbl_appointment","where patient_id='$patient_id' and status!=0");
				//echo $select_First_visit;exit();
				if(mysqli_num_rows($select_First_visit)>0){
					while($select_First_visit_row = mysqli_fetch_array($select_First_visit)){
						$response_arr[0]['first_visit'] = $select_First_visit_row['first_visit'];
						if($select_First_visit_row['first_visit'] != ''){
							break;
						}
					}
				}
				//echo "visit_limit ".$visit_limit." and ".$date_limit;exit();
			if($visit_limit !=0 and $date_limit!=0){
			$appointment_date = '';
			$appointment_id = 0;
			$check_last_appointmnet_with_fee = $obj->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
				//echo $check_last_appointmnet_with_fee;exit();
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
			$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
			$appointment_id = $check_last_appointmnet_with_fee_row['id'];
			}
	
		
	//select total visit after payment
			$total_visit_count = 0;
	$select_visit_count = $obj->selectData("count(id) as id","tbl_appointment","where  id>=$appointment_id and patient_id=$patient_id and status!=0");
	$select_visit_count_row = mysqli_fetch_array($select_visit_count);
	if($select_visit_count_row['id'] != null){
		
		 $selectnumofvist=$obj->selectData("id,num_of_visit","tbl_appointment","where patient_id=$patient_id and id>=$appointment_id and status!=0");
        $totalvist= mysqli_fetch_assoc($selectnumofvist);
        $total_visit_of_patient = $totalvist['num_of_visit'];

		$total_id_in_apnmnt =$select_visit_count_row['id'];
		//(int)$total_visit_count =$select_visit_count_row['id'];
		(int)$total_visit_count = $total_visit_of_patient + $total_id_in_apnmnt;
	}
		//$obj_common
		$select_cross_branch_data = $obj_common->selectData("count(id) as id","tbl_appointment_gone_details","where patient_unique_id='$unique_id' and status!=0");
				$select_cross_branch_data_row = mysqli_fetch_array($select_cross_branch_data);
				if($select_cross_branch_data_row['id'] != null){
					$total_visit_count += (int)$select_cross_branch_data_row['id'];
				}
	$month_limit = "+".$date_limit." months";
	$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
	$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
	$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));

	if($total_visit_count<$visit_limit)	{
		if($days1<$new_format_appointment_date){
			$response_arr[0]['appointment_fee'] = 0;
			$remaining_visit = $visit_limit-$total_visit_count;
			$response_arr[0]['appointment_fee_msg'] = "Remaining Visit ".$remaining_visit." or up to ".$new_format_appointment_date1;
		}else{
			$nr = 0;
				$fetch_nr_fee = $obj->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
		}
	}else{
		$response_arr[0]['appointment_fee'] = 1;
		$nr = 0;
				$fetch_nr_fee = $obj->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
	}
		}else{
				$nr = 0;
				$fetch_nr_fee = $obj->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
			}
		}else{
				$select_nr_limit = $obj->selectData("nr_date_limit,nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($select_nr_limit)>0){
					$select_nr_limit_row = mysqli_fetch_array($select_nr_limit);
					$nr_date_limit = $select_nr_limit_row['nr_date_limit'];
					$nr_fee = $select_nr_limit_row['nr'];
					$month_limit_nr = "+".$nr_date_limit." months";
					$check_last_paid_fee = $obj->selectData("appointment_date","tbl_appointment","where appointment_fee!=0 and status!=0 ORDER BY id DESC limit 1");
					if(mysqli_num_rows($check_last_paid_fee)>0){
						$check_last_paid_fee_row = mysqli_fetch_array($check_last_paid_fee);
						$appointment_taken_date = $check_last_paid_fee_row['appointment_date'];
						$new_format_appointment_date = date("d-m-Y", strtotime($appointment_taken_date));
						$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit_nr", strtotime($new_format_appointment_date)));
						$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
						if($days1 < $new_format_appointment_date){
							$response_arr[0]['appointment_fee'] = 0;
							$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
						}else{
							$response_arr[0]['appointment_fee'] = 1;
							$response_arr[0]['appointment_fee_nr'] = $nr_fee;
						}
					}
				}
			}
		
	
		}
	}else{
		$check_phn = $obj_common->selectData("branch_id","tbl_patient","where phone='$number' and name='$user_name' and  status!=0");
		if(mysqli_num_rows($check_phn)>0){
			while($check_phn_row = mysqli_fetch_array($check_phn)){
				$branch_id = $check_phn_row['branch_id'];
				
	$branch = $branch_id;
		$response_arr[0]['branch_id'] = $branch;
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$visit_limit = 0;
	$date_limit = 0;
	$select_add_fee_date_limit = $obj_branch->selectData("visit_limit,date_limit","tbl_appointment_fee","where status=1");
	if(mysqli_num_rows($select_add_fee_date_limit)>0){
		while($select_add_fee_date_limit_row = mysqli_fetch_array($select_add_fee_date_limit)){
			$visit_limit = $select_add_fee_date_limit_row['visit_limit'];
			$date_limit = $select_add_fee_date_limit_row['date_limit'];
		}
	}
	$appointment_date = '';
	$appointment_id = 0;
	$check_last_appointmnet_with_fee = $obj_branch->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
		$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
		$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
		$appointment_id = $check_last_appointmnet_with_fee_row['id'];
	}
	
	$check_phn = $obj_branch->selectData("id,unique_id,name,phone,address,place,age,gender,whatsApp,patient_type","tbl_patient","where phone='$number' and name='$user_name' and  status!=0");
		//echo $check_phn;exit();
	if(mysqli_num_rows($check_phn)>0){
		$response_arr[0]['data_exist'] = 1;
		while($check_phn_row = mysqli_fetch_array($check_phn)){
			$response_arr[0]['id'] = $check_phn_row['id'];
			$patient_id = $check_phn_row['id'];
			$doctor_name = '';
			$check_last_appointmnet_with_fee = $obj_branch->selectData("consulted_by,height,weight","tbl_appointment","where status!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
			$doctor_id = $check_last_appointmnet_with_fee_row['consulted_by'];
			$response_arr[0]['height'] = $check_last_appointmnet_with_fee_row['height'];
		    $response_arr[0]['weight'] = $check_last_appointmnet_with_fee_row['weight'];
			$select_doctor_name = $obj_branch->selectData("doctor_name","tbl_doctor","where login_id=$doctor_id");
			if(mysqli_num_rows($select_doctor_name)>0){
				$select_doctor_name_row = mysqli_fetch_array($select_doctor_name);
				$doctor_name = $select_doctor_name_row['doctor_name'];
				}
			}
			$response_arr[0]['doctor_name'] = $doctor_name;
			$response_arr[0]['unique_id'] = $check_phn_row['unique_id'];
			$response_arr[0]['phone'] = $check_phn_row['phone'];
			$response_arr[0]['address'] = $check_phn_row['address'];
			$response_arr[0]['place'] = $check_phn_row['place'];
			$response_arr[0]['age'] = $check_phn_row['age'];
			$response_arr[0]['gender'] = $check_phn_row['gender'];
			$response_arr[0]['whatsApp'] = $check_phn_row['whatsApp'];
			if($check_phn_row['patient_type'] == 'N' || $check_phn_row['patient_type'] == ''){
			$select_First_visit = $obj_branch->selectData("first_visit","tbl_appointment","where patient_id='$patient_id' and status!=0");
				//echo $select_First_visit;exit();
				if(mysqli_num_rows($select_First_visit)>0){
					while($select_First_visit_row = mysqli_fetch_array($select_First_visit)){
						$response_arr[0]['first_visit'] = $select_First_visit_row['first_visit'];
						if($select_First_visit_row['first_visit'] != ''){
							break;
						}
					}
				}
			if($visit_limit !=0 and $date_limit!=0){
			$appointment_date = '';
			$appointment_id = 0;
			$check_last_appointmnet_with_fee = $obj_branch->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
			$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
			$appointment_id = $check_last_appointmnet_with_fee_row['id'];
			}
	
		
	//select total visit after payment
			$total_visit_count = 0;
	$select_visit_count = $obj_branch->selectData("count(id) as id","tbl_appointment","where  id>=$appointment_id and patient_id=$patient_id and status!=0");
	$select_visit_count_row = mysqli_fetch_array($select_visit_count);
	if($select_visit_count_row['id'] != null){
		
		 $selectnumofvist=$obj_branch->selectData("id,num_of_visit","tbl_appointment","where patient_id=$patient_id and id>=$appointment_id and status!=0");
        $totalvist= mysqli_fetch_assoc($selectnumofvist);
        $total_visit_of_patient = $totalvist['num_of_visit'];

		$total_id_in_apnmnt =$select_visit_count_row['id'];
		//(int)$total_visit_count =$select_visit_count_row['id'];
		(int)$total_visit_count = $total_visit_of_patient + $total_id_in_apnmnt;
	}
	$month_limit = "+".$date_limit." months";
	$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
	$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
	$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
	//echo "total_visit_count :".$total_visit_count;
	//echo " visit_limit :".$visit_limit;exit();
	if($total_visit_count<$visit_limit)	{
		if($days1<$new_format_appointment_date){
			$response_arr[0]['appointment_fee'] = 0;
			$remaining_visit = $visit_limit-$total_visit_count;
			$response_arr[0]['appointment_fee_msg'] = "Remaining Visit ".$remaining_visit." or up to ".$new_format_appointment_date1;
		}else{
			$nr = 0;
				$fetch_nr_fee = $obj_branch->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
			$response_arr[0]['appointment_fee'] = 1;
		}
	}else{
		$nr = 0;
		$date_data = DateTime::createFromFormat('Y-m-d', $appointment_date);
		$appointment_month = $date_data->format('m');
		
		if($appointment_month == $currect_month){
		$month_limit = "+1 months";
		$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
		$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
		$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
		$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
			$response_arr[0]['appointment_fee_nr'] = 0;
			$response_arr[0]['appointment_fee'] = 0;
		}else{
		//$currect_month
				$fetch_nr_fee = $obj_branch->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
		}
	}
		}else{
		$date_data = DateTime::createFromFormat('Y-m-d', $appointment_date);
		$appointment_month = $date_data->format('m');
		if($appointment_month == $currect_month){
		$month_limit = "+1 months";
		$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
		$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
		$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
		$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
			$response_arr[0]['appointment_fee_nr'] = 0;
			$response_arr[0]['appointment_fee'] = 0;
		}else{
				$nr = 0;
				$fetch_nr_fee = $obj_branch->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
		}
			}
		}else{
				$select_nr_limit = $obj_branch->selectData("nr_date_limit,nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($select_nr_limit)>0){
					$select_nr_limit_row = mysqli_fetch_array($select_nr_limit);
					$nr_date_limit = $select_nr_limit_row['nr_date_limit'];
					$nr_fee = $select_nr_limit_row['nr'];
					$month_limit_nr = "+".$nr_date_limit." months";
					$check_last_paid_fee = $obj_branch->selectData("appointment_date","tbl_appointment","where appointment_fee!=0 and status!=0 ORDER BY id DESC limit 1");
					if(mysqli_num_rows($check_last_paid_fee)>0){
						$check_last_paid_fee_row = mysqli_fetch_array($check_last_paid_fee);
						$appointment_taken_date = $check_last_paid_fee_row['appointment_date'];
						$new_format_appointment_date = date("d-m-Y", strtotime($appointment_taken_date));
						$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit_nr", strtotime($new_format_appointment_date)));
						$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
						if($days1 < $new_format_appointment_date){
							$response_arr[0]['appointment_fee'] = 0;
							$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
						}else{
							$response_arr[0]['appointment_fee'] = 1;
							$response_arr[0]['appointment_fee_nr'] = $nr_fee;
						}
					}
				}
			}
		
	
		}
	}else{
		$response_arr[0]['data_exist'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
			}
		}else{
		$response_arr[0]['data_exist'] = 0;
		}
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
}else{
	$branch = $branch_id;
		$response_arr[0]['branch_id'] = $branch;
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$visit_limit = 0;
	$date_limit = 0;
	$select_add_fee_date_limit = $obj_branch->selectData("visit_limit,date_limit","tbl_appointment_fee","where status=1");
	if(mysqli_num_rows($select_add_fee_date_limit)>0){
		while($select_add_fee_date_limit_row = mysqli_fetch_array($select_add_fee_date_limit)){
			$visit_limit = $select_add_fee_date_limit_row['visit_limit'];
			$date_limit = $select_add_fee_date_limit_row['date_limit'];
		}
	}
	$appointment_date = '';
	$appointment_id = 0;
	$check_last_appointmnet_with_fee = $obj_branch->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
		$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
		$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
		$appointment_id = $check_last_appointmnet_with_fee_row['id'];
	}
	
	$check_phn = $obj_branch->selectData("id,unique_id,name,phone,address,place,age,gender,whatsApp,patient_type","tbl_patient","where phone='$number' and name='$user_name' and  status!=0");
		//echo $check_phn;exit();
	if(mysqli_num_rows($check_phn)>0){
		$response_arr[0]['data_exist'] = 1;
		while($check_phn_row = mysqli_fetch_array($check_phn)){
			$response_arr[0]['id'] = $check_phn_row['id'];
			$patient_id = $check_phn_row['id'];
			$doctor_name = '';
			$check_last_appointmnet_with_fee = $obj_branch->selectData("consulted_by,height,weight","tbl_appointment","where status!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
			$doctor_id = $check_last_appointmnet_with_fee_row['consulted_by'];
			$response_arr[0]['height'] = $check_last_appointmnet_with_fee_row['height'];
		    $response_arr[0]['weight'] = $check_last_appointmnet_with_fee_row['weight'];
			$select_doctor_name = $obj_branch->selectData("doctor_name","tbl_doctor","where login_id=$doctor_id");
			if(mysqli_num_rows($select_doctor_name)>0){
				$select_doctor_name_row = mysqli_fetch_array($select_doctor_name);
				$doctor_name = $select_doctor_name_row['doctor_name'];
				}
			}
			$response_arr[0]['doctor_name'] = $doctor_name;
			$response_arr[0]['unique_id'] = $check_phn_row['unique_id'];
			$response_arr[0]['phone'] = $check_phn_row['phone'];
			$response_arr[0]['address'] = $check_phn_row['address'];
			$response_arr[0]['place'] = $check_phn_row['place'];
			$response_arr[0]['age'] = $check_phn_row['age'];
			$response_arr[0]['gender'] = $check_phn_row['gender'];
			$response_arr[0]['whatsApp'] = $check_phn_row['whatsApp'];
			if($check_phn_row['patient_type'] == 'N' || $check_phn_row['patient_type'] == ''){
			$select_First_visit = $obj_branch->selectData("first_visit","tbl_appointment","where patient_id='$patient_id' and status!=0");
				//echo $select_First_visit;exit();
				if(mysqli_num_rows($select_First_visit)>0){
					while($select_First_visit_row = mysqli_fetch_array($select_First_visit)){
						$response_arr[0]['first_visit'] = $select_First_visit_row['first_visit'];
						if($select_First_visit_row['first_visit'] != ''){
							break;
						}
					}
				}
			if($visit_limit !=0 and $date_limit!=0){
			$appointment_date = '';
			$appointment_id = 0;
			$check_last_appointmnet_with_fee = $obj_branch->selectData("id,appointment_date","tbl_appointment","where status!=0 and appointment_fee!=0 and patient_id = $patient_id ORDER BY id DESC limit 1");
	if(mysqli_num_rows($check_last_appointmnet_with_fee)>0){
			$check_last_appointmnet_with_fee_row = mysqli_fetch_array($check_last_appointmnet_with_fee);
			$appointment_date = $check_last_appointmnet_with_fee_row['appointment_date'];
			$appointment_id = $check_last_appointmnet_with_fee_row['id'];
			}
	
		
	//select total visit after payment
			$total_visit_count = 0;
	$select_visit_count = $obj_branch->selectData("count(id) as id","tbl_appointment","where  id>=$appointment_id and patient_id=$patient_id and status!=0");
	$select_visit_count_row = mysqli_fetch_array($select_visit_count);
	if($select_visit_count_row['id'] != null){
		
		 $selectnumofvist=$obj_branch->selectData("id,num_of_visit","tbl_appointment","where patient_id=$patient_id and id>=$appointment_id and status!=0");
        $totalvist= mysqli_fetch_assoc($selectnumofvist);
        $total_visit_of_patient = $totalvist['num_of_visit'];

		$total_id_in_apnmnt =$select_visit_count_row['id'];
		//(int)$total_visit_count =$select_visit_count_row['id'];
		(int)$total_visit_count = $total_visit_of_patient + $total_id_in_apnmnt;
	}
	$month_limit = "+".$date_limit." months";
	$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
	$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
	$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
	//echo "total_visit_count :".$total_visit_count;
	//echo " visit_limit :".$visit_limit;exit();
	if($total_visit_count<$visit_limit)	{
		if($days1<$new_format_appointment_date){
			$response_arr[0]['appointment_fee'] = 0;
			$remaining_visit = $visit_limit-$total_visit_count;
			$response_arr[0]['appointment_fee_msg'] = "Remaining Visit ".$remaining_visit." or up to ".$new_format_appointment_date1;
		}else{
			$nr = 0;
				$fetch_nr_fee = $obj_branch->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
			$response_arr[0]['appointment_fee'] = 1;
		}
	}else{
		$nr = 0;
		$date_data = DateTime::createFromFormat('Y-m-d', $appointment_date);
		$appointment_month = $date_data->format('m');
		
		if($appointment_month == $currect_month){
		$month_limit = "+1 months";
		$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
		$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
		$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
		$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
			$response_arr[0]['appointment_fee_nr'] = 0;
			$response_arr[0]['appointment_fee'] = 0;
		}else{
		//$currect_month
				$fetch_nr_fee = $obj_branch->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
		}
	}
		}else{
		$date_data = DateTime::createFromFormat('Y-m-d', $appointment_date);
		$appointment_month = $date_data->format('m');
		if($appointment_month == $currect_month){
		$month_limit = "+1 months";
		$new_format_appointment_date = date("d-m-Y", strtotime($appointment_date));
		$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit", strtotime($new_format_appointment_date)));
		$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
		$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
			$response_arr[0]['appointment_fee_nr'] = 0;
			$response_arr[0]['appointment_fee'] = 0;
		}else{
				$nr = 0;
				$fetch_nr_fee = $obj_branch->selectData("nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($fetch_nr_fee)>0){
					$fetch_nr_fee_row = mysqli_fetch_array($fetch_nr_fee);
					$nr = $fetch_nr_fee_row['nr'];
				}
				$response_arr[0]['appointment_fee_nr'] = $nr;
				$response_arr[0]['appointment_fee'] = 1;
		}
			}
		}else{
				$select_nr_limit = $obj_branch->selectData("nr_date_limit,nr","tbl_appointment_fee","where status=1");
				if(mysqli_num_rows($select_nr_limit)>0){
					$select_nr_limit_row = mysqli_fetch_array($select_nr_limit);
					$nr_date_limit = $select_nr_limit_row['nr_date_limit'];
					$nr_fee = $select_nr_limit_row['nr'];
					$month_limit_nr = "+".$nr_date_limit." months";
					$check_last_paid_fee = $obj_branch->selectData("appointment_date","tbl_appointment","where appointment_fee!=0 and status!=0 ORDER BY id DESC limit 1");
					if(mysqli_num_rows($check_last_paid_fee)>0){
						$check_last_paid_fee_row = mysqli_fetch_array($check_last_paid_fee);
						$appointment_taken_date = $check_last_paid_fee_row['appointment_date'];
						$new_format_appointment_date = date("d-m-Y", strtotime($appointment_taken_date));
						$new_format_appointment_date = date('Y-m-d', strtotime("$month_limit_nr", strtotime($new_format_appointment_date)));
						$new_format_appointment_date1 = date("d-m-Y", strtotime($new_format_appointment_date));
						if($days1 < $new_format_appointment_date){
							$response_arr[0]['appointment_fee'] = 0;
							$response_arr[0]['appointment_fee_msg'] = "Remaining Visit up to ".$new_format_appointment_date1;
						}else{
							$response_arr[0]['appointment_fee'] = 1;
							$response_arr[0]['appointment_fee_nr'] = $nr_fee;
						}
					}
				}
			}
		
	
		}
	}else{
		$response_arr[0]['data_exist'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
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