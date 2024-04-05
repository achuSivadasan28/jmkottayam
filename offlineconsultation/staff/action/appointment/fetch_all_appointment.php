<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$days_re=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['staff_login_id'])){
$login_id = $_SESSION['staff_login_id'];
$staff_role = $_SESSION['staff_role'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$obj_common = new query_common();
if($staff_role == 'staff'){
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$start_date = $_POST['start_date'];
	$end_date = $_POST['end_date'];
	$search_val = $_POST['search_val'];
	$appointment_fee = $_POST['appointment_fee'];
	$payment_type = $_POST['payment_type'];
	
	
	$where_date_clause = '';
	$where_date_serach = '';
	$flag = false;
	if(strlen($search_val) > 0){
	  for($i = 0;$i < strlen($search_val); $i++){
		  if($search_val[$i] == '/'){
		    $flag = true;
			 break;
		  }
	  
	  }
	}
	$response_arr[0]['current_date'] = '';
	if($search_val != ''){
		if($flag){
		     $where_date_serach = " and tbl_patient.unique_id = '$search_val'";
		}else{
		     $where_date_serach = " and (tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' or tbl_patient.place like '%$search_val%')";
		}
		
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
		$where_date_clause = " and tbl_appointment.appointment_date='$days_re'";
		$response_arr[0]['current_date'] = $days_re;
	}
	$where_appointment_fee= "";
	if(count($appointment_fee)){
		$where_appointment_fee = "and(";
		foreach($appointment_fee as $x => $fee){
			if($x == 0){
				$where_appointment_fee .= "appointment_fee = $fee";
			}else{
				$where_appointment_fee .= " or appointment_fee = $fee";
			}
			
		}
		$where_appointment_fee .= ")";
	}
	$where_payment_type = "";
	if(count($payment_type)){
		$where_payment_type = "and(";
		foreach($payment_type as $x => $pay){
			if($x == 0){
				$where_payment_type .= "payment_id = $pay";
			}else{
				$where_payment_type .= " or payment_id = $pay";
			}
			
		}
		$where_payment_type .= ")";
	}
	//echo $where_payment_type;exit();
	
if($where_date_serach ==""){
	$select_all_data = $obj->selectData("tbl_appointment.id,tbl_appointment.patient_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_appointment.appointment_number,tbl_appointment.branch_id,tbl_doctor.doctor_name,tbl_appointment.status as appointmentstatus,tbl_appointment.appointment_status,tbl_appointment.appointment_fee as appointment_fee","tbl_appointment inner join tbl_doctor on tbl_appointment.doctor_id=tbl_doctor.login_id","where tbl_appointment.status!=2 and tbl_appointment.cross_branch_status!=1 $where_date_clause  $where_appointment_fee ORDER BY tbl_appointment.id desc");
	//echo $select_all_data;exit();
	//tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place
	if(mysqli_num_rows($select_all_data)>0){
		$response_arr[0]['data_status'] = 1;
		$x = 0;
		while($select_all_data_row = mysqli_fetch_array($select_all_data)){
			$appointment_id = $select_all_data_row['id'];
			$response_arr[$x]['filter_status'] = 1;
			$response_arr[$x]['id'] = $select_all_data_row['id'];
			$branch_id = $select_all_data_row['branch_id'];
			$patient_id = $select_all_data_row['patient_id'];
			$response_arr[$x]['appointment_date'] = date('d-m-Y',strtotime($select_all_data_row['appointment_date']));
			$response_arr[$x]['appointment_number'] = $select_all_data_row['appointment_number'];
			
			$response_arr[$x]['doctor_name'] = $select_all_data_row['doctor_name'];
			$response_arr[$x]['appointmentstatus'] = $select_all_data_row['appointmentstatus'];
			$response_arr[$x]['appointment_status'] = $select_all_data_row['appointment_status'];
			$response_arr[$x]['c_date'] = $days;
			$response_arr[$x]['appointment_fee'] = $select_all_data_row['appointment_fee'];
			$select_payment_mode_type = $obj->selectData("id","tbl_appointment_modeinvoice","where appointment_id = $appointment_id and status != 0");
			if(mysqli_num_rows($select_payment_mode_type)>0){
				while($select_payment_type_rows = mysqli_fetch_assoc($select_payment_mode_type)){
				$mod_id = $select_payment_type_rows['id'];
				
				$select_payment = $obj->selectData("payment_id","tbl_appoinment_payment","where tbl_apmnt_mode_payid = $mod_id and status != 0 $where_payment_type");            //echo $select_payment;exit();
				if(mysqli_num_rows($select_payment)>0){
					while($select_payment_row = mysqli_fetch_assoc($select_payment)){
						
						$response_arr[$x]['payment_id'] = $select_payment_row['payment_id'];
				
				 }
				
				}else{
					if($where_payment_type != ""){
						$response_arr[$x]['filter_status'] = 0;
					
					}
				
				}
				
				
			
			}
			
			}else{
				if($where_payment_type != ""){
					$response_arr[$x]['filter_status'] = 0;
					
				}
			
			}
			
			$branch = $branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_patient_data = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place","tbl_patient","where id=$patient_id ");
			if(mysqli_num_rows($select_patient_data)>0){
			$select_patient_data_row = mysqli_fetch_array($select_patient_data);
			$response_arr[$x]['unique_id'] = $select_patient_data_row['unique_id'];
			$response_arr[$x]['name'] = $select_patient_data_row['name'];
			$response_arr[$x]['phone'] = $select_patient_data_row['phone'];
			$response_arr[$x]['place'] = $select_patient_data_row['place'];
			$check_appointments_count = $obj_branch->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and status!=0");
			$check_appointment_count_data = 0;
			$check_appointments_count_row = mysqli_fetch_array($check_appointments_count);
			if($check_appointments_count_row['id'] != null){
				$check_appointment_count_data = $check_appointments_count_row['id'];
			}
			
			$response_arr[$x]['check_appointment_count_data'] = $check_appointment_count_data;
			}
			
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
}else{
	
	//echo $select_patient_data;exit();
			 
			 $select_all_data = $obj->selectData("tbl_appointment.id,tbl_appointment.patient_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_appointment.appointment_number,tbl_appointment.branch_id,tbl_doctor.doctor_name,tbl_appointment.status as appointmentstatus,tbl_appointment.appointment_status,tbl_appointment.appointment_fee as appointment_fee","tbl_appointment inner join tbl_doctor on tbl_appointment.doctor_id=tbl_doctor.login_id","where tbl_appointment.status!=2 and tbl_appointment.cross_branch_status!=1  $where_date_clause  $where_appointment_fee ORDER BY tbl_appointment.id desc");
	//echo $select_all_data;exit();
	//tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place
	if(mysqli_num_rows($select_all_data)>0){
		$response_arr[0]['data_status'] = 1;
		$x = 0;	
		while($select_all_data_row = mysqli_fetch_array($select_all_data)){
			$appointment_id = $select_all_data_row['id'];
			$filter_status = 1;
			$id = $select_all_data_row['id'];
			$branch_id = $select_all_data_row['branch_id'];
			$patient_id = $select_all_data_row['patient_id'];
			$appointment_date = date('d-m-Y',strtotime($select_all_data_row['appointment_date']));
			$appointment_number = $select_all_data_row['appointment_number'];
			
			$doctor_name = $select_all_data_row['doctor_name'];
			$appointmentstatus = $select_all_data_row['appointmentstatus'];
			$appointment_status = $select_all_data_row['appointment_status'];
			$c_date = $days;
			$appointment_fee = $select_all_data_row['appointment_fee'];
			$select_payment_mode_type = $obj->selectData("id","tbl_appointment_modeinvoice","where appointment_id = $appointment_id and status != 0");
			if(mysqli_num_rows($select_payment_mode_type)>0){
				while($select_payment_type_rows = mysqli_fetch_assoc($select_payment_mode_type)){
				$mod_id = $select_payment_type_rows['id'];
				
				$select_payment = $obj->selectData("payment_id","tbl_appoinment_payment","where tbl_apmnt_mode_payid = $mod_id and status != 0 $where_payment_type");            //echo $select_payment;exit();
				if(mysqli_num_rows($select_payment)>0){
					while($select_payment_row = mysqli_fetch_assoc($select_payment)){
						
						$payment_id = $select_payment_row['payment_id'];
				
				 }
				
				}else{
					if($where_payment_type != ""){
						$filter_status = 0;
					
					}
				
				}
				
				
			
			}
			
			}else{
				if($where_payment_type != ""){
					$filter_status = 0;
					
				}
			
			}
			
			$branch = $branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$select_patient_data1 = $obj_branch->selectData("tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.place","tbl_patient","where status != 0 and id = $patient_id $where_date_serach");
			//echo $select_patient_data1;exit();
			if(mysqli_num_rows($select_patient_data1)>0){
				$select_patient_data_row1 = mysqli_fetch_array($select_patient_data1);
				$response_arr[$x]['unique_id'] = $select_patient_data_row1['unique_id'];
				$response_arr[$x]['name'] = $select_patient_data_row1['name'];
				$response_arr[$x]['phone'] = $select_patient_data_row1['phone'];
				$response_arr[$x]['place'] = $select_patient_data_row1['place'];
				$response_arr[$x]['filter_status'] = $filter_status;
				$response_arr[$x]['id'] = $id;
				$response_arr[$x]['appointment_date'] = $appointment_date;
				$response_arr[$x]['appointment_number'] = $appointment_number;
				$response_arr[$x]['doctor_name'] = $doctor_name;
				$response_arr[$x]['appointmentstatus'] = $appointmentstatus;
				$response_arr[$x]['appointment_status'] = $appointment_status;
				$response_arr[$x]['appointment_fee'] = $appointment_fee;
				$response_arr[$x]['payment_id'] = $payment_id;
				$response_arr[$x]['c_date'] = $c_date;
				$check_appointments_count = $obj_branch->selectData("count(id) as id","tbl_appointment","where id = $patient_id and status!=0");
				$check_appointment_count_data = 0;
				$check_appointments_count_row = mysqli_fetch_array($check_appointments_count);
				if($check_appointments_count_row['id'] != null){
					$check_appointment_count_data = $check_appointments_count_row['id'];
				}

				$response_arr[$x]['check_appointment_count_data'] = $check_appointment_count_data;
				$x++;
			}
			
			
		}
		
		
	}else{
		//$response_arr[0]['data_status'] = 0;
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
			 
		
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