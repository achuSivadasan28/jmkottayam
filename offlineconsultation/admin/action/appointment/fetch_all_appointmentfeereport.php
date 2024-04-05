<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_branch/query_branch.php';
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
	
$response_arr = array();
	
	
	
 $search_val=$_GET['search'];
$limit=$_GET['limit_range'];



$where_name_filter = '';
if($search_val != ''){
$where_name_filter = " and (tbl_appointment_modeinvoice.invoice_campain like '%$search_val%') ";
}
	
	
		$startDate_current       =   date("d-m-Y", strtotime($days));
	
	
	$startDate_url        =   $_GET['startdate'];

$startDate_new_format =   date("d-m-Y", strtotime($startDate_url));
$startDate            =   strtotime($startDate_new_format);
$EndDate_url          =   $_GET['enddate'];
$EndDate_new_format   =   date("d-m-Y", strtotime($EndDate_url));
$EndDate              =   strtotime($EndDate_new_format);
$date_diff            = 0;
$date_where_clause    = "";

// date filter
if ($startDate_url != 0) {
	if ($EndDate_url != 0) {
		if ($startDate_url == $EndDate_url) {
			$date_where_clause = " and tbl_appointment_modeinvoice.addedDate='$startDate_new_format'";
		} else {
			$date_diff = ($EndDate - $startDate) / 60 / 60 / 24;
			if ($date_diff != 0) {
				$date_where_clause = " and (";
				for ($x1 = 0; $x1 <= $date_diff; $x1++) {
					$new_date = date('d-m-Y', strtotime($startDate_new_format . ' +' . $x1 . ' day'));
					if ($x1 == $date_diff) {
						$date_where_clause .= "tbl_appointment_modeinvoice.addedDate='$new_date')";
					} else {
						$date_where_clause .= "tbl_appointment_modeinvoice.addedDate='$new_date' or ";
					}
				}
			} else {
				$date_where_clause = " and tbl_appointment_modeinvoice.addedDate =$startDate_new_format";
			}
		}
	} else {
		$date_where_clause = " and tbl_appointment_modeinvoice.addedDate='$startDate_new_format'";
	}

	}else{
$date_where_clause = " and tbl_appointment_modeinvoice.addedDate='$startDate_current'";
}
	
	
	
	
	
	
	
	
 /*$select_all_appoinmentfeereports = $obj->selectData("tbl_appointment_modeinvoice.id,tbl_appointment_modeinvoice.appointment_id,tbl_appointment_modeinvoice.patient_id,tbl_appointment_modeinvoice.invoice_campain,tbl_appointment_modeinvoice.addedDate","tbl_appointment_modeinvoice inner join tbl_appointment on tbl_appointment_modeinvoice.appointment_id=tbl_appointment.id","where tbl_appointment_modeinvoice.status!=0 and tbl_appointment.status!=0 $date_where_clause $where_name_filter  order by tbl_appointment_modeinvoice.id desc limit $limit");*/
	
	
	$select_all_appoinmentfeereports = $obj->selectData("tbl_appointment_modeinvoice.id,tbl_appointment_modeinvoice.appointment_id,tbl_appointment_modeinvoice.patient_id,tbl_appointment_modeinvoice.invoice_campain,tbl_appointment_modeinvoice.addedDate,tbl_appoinment_payment.payment_id,tbl_appoinment_payment.payment_amnt,tbl_appointment.branch_id","tbl_appointment_modeinvoice inner join tbl_appointment on tbl_appointment_modeinvoice.appointment_id=tbl_appointment.id inner join tbl_appoinment_payment on tbl_appointment_modeinvoice.id=tbl_appoinment_payment.tbl_apmnt_mode_payid","where tbl_appointment_modeinvoice.status!=0 and 
tbl_appointment.status!=0 $date_where_clause $where_name_filter  order by tbl_appointment_modeinvoice.id desc");
//echo $select_all_appoinmentfeereports;exit();
if(mysqli_num_rows($select_all_appoinmentfeereports)>0){
	$x = 0;
	$response_arr[0]['status'] = 1;
	$response_arr[0]['data_exist'] = 1;
	while($select_all_appoinment_row = mysqli_fetch_array($select_all_appoinmentfeereports)){
		$branch_id = $select_all_appoinment_row['branch_id'];
		$patient_id=$select_all_appoinment_row['patient_id'];
		$branch = $branch_id;
		$obj_branch = new query_branch();
		$selectData1=$obj_branch->selectData("id,name","tbl_patient","where id=$patient_id");
		if(mysqli_num_rows($selectData1)>0){
		$temp_name= mysqli_fetch_assoc($selectData1);
		if($select_all_appoinment_row['payment_amnt'] == '500'){
			if($select_all_appoinment_row['payment_id'] != 0){
			$invoice_id = $select_all_appoinment_row['id'];
		
		
	/* $selectData1=$obj->selectData("old_patient","tbl_appointment","where patient_id=$patient_id");
        $temp_name= mysqli_fetch_assoc($selectData1);
        $patient_status=$temp_name['old_patient'];
		if($patient_status == 0){
		$response_arr[$x]['patient_status'] = 'New';
		}else{
		$response_arr[$x]['patient_status'] = 'Old';
		}*/
		
		$appointment_id=$select_all_appoinment_row['appointment_id'];
		$selectappointment=$obj->selectData("id,appointment_fee","tbl_appointment","where id=$appointment_id");
$temperory_name= mysqli_fetch_assoc($selectappointment);
$appoinment_fee=$temperory_name['appointment_fee'];
		
		
				$payment_mode_data = '';
		$patient_type='';
		if($appoinment_fee == 500){
			$patient_type='New Patient';
		
		}else if($appoinment_fee == 0){
			$patient_type='';
		}else {
		$patient_type='Renewal';
			
		}

		
	
		$select_payment_mode = $obj->selectData("payment_id,payment_amnt","tbl_appoinment_payment","where tbl_apmnt_mode_payid=$invoice_id and status!=0");
		if(mysqli_num_rows($select_payment_mode)){
			$pay_mode = '';
			while($select_payment_mode_row = mysqli_fetch_array($select_payment_mode)){
				if($select_payment_mode_row['payment_id'] == 1){
						$pay_mode = 'gpay';
					}else if($select_payment_mode_row['payment_id'] == 2){
						$pay_mode = 'cash';
					}else if($select_payment_mode_row['payment_id'] == 3){
						$pay_mode = 'card';
					}
				if($payment_mode_data != ''){
						$payment_mode_data .= " ,".$pay_mode."(".$select_payment_mode_row['payment_amnt'].")";
					}else{
						$payment_mode_data = "$pay_mode (".$select_payment_mode_row['payment_amnt'].")";
					}
				
				
				
				
			}
		}
		$response_arr[$x]['payment_mode_data'] = $payment_mode_data;
		
$patient_name=$temp_name['name'];

		
		
		
		$response_arr[$x]['id'] = $select_all_appoinment_row['id'];
		$response_arr[$x]['appointment_id'] = $select_all_appoinment_row['appointment_id'];
		$response_arr[$x]['patient_id'] = $select_all_appoinment_row['patient_id'];
		$response_arr[$x]['patient_name'] =$patient_name;
		$response_arr[$x]['invoice_campain'] = $select_all_appoinment_row['invoice_campain'];
		$response_arr[$x]['addedDate'] = $select_all_appoinment_row['addedDate'];
		$response_arr[$x]['appointment_fee'] = $appoinment_fee;
		$response_arr[$x]['patient_type'] = $patient_type;
		$x++;
			}
		}else{
		$invoice_id = $select_all_appoinment_row['id'];
		$patient_id=$select_all_appoinment_row['patient_id'];
		
	/* $selectData1=$obj->selectData("old_patient","tbl_appointment","where patient_id=$patient_id");
        $temp_name= mysqli_fetch_assoc($selectData1);
        $patient_status=$temp_name['old_patient'];
		if($patient_status == 0){
		$response_arr[$x]['patient_status'] = 'New';
		}else{
		$response_arr[$x]['patient_status'] = 'Old';
		}*/
		
		$appointment_id=$select_all_appoinment_row['appointment_id'];
		$selectappointment=$obj->selectData("id,appointment_fee","tbl_appointment","where id=$appointment_id");
$temperory_name= mysqli_fetch_assoc($selectappointment);
$appoinment_fee=$temperory_name['appointment_fee'];
		
		
				$payment_mode_data = '';
		$patient_type='';
		if($appoinment_fee == 500){
			$patient_type='New Patient';
		
		}else if($appoinment_fee == 0){
			$patient_type='';
		}else {
		$patient_type='Renewal';
			
		}

		
	
		$select_payment_mode = $obj->selectData("payment_id,payment_amnt","tbl_appoinment_payment","where tbl_apmnt_mode_payid=$invoice_id and status!=0");
		if(mysqli_num_rows($select_payment_mode)){
			$pay_mode = '';
			while($select_payment_mode_row = mysqli_fetch_array($select_payment_mode)){
				if($select_payment_mode_row['payment_id'] == 1){
						$pay_mode = 'gpay';
					}else if($select_payment_mode_row['payment_id'] == 2){
						$pay_mode = 'cash';
					}else if($select_payment_mode_row['payment_id'] == 3){
						$pay_mode = 'card';
					}
				if($payment_mode_data != ''){
						$payment_mode_data .= " ,".$pay_mode."(".$select_payment_mode_row['payment_amnt'].")";
					}else{
						$payment_mode_data = "$pay_mode (".$select_payment_mode_row['payment_amnt'].")";
					}
				
				
				
				
			}
		}
		$response_arr[$x]['payment_mode_data'] = $payment_mode_data;
		
$patient_name=$temp_name['name'];

		
		
		
		$response_arr[$x]['id'] = $select_all_appoinment_row['id'];
		$response_arr[$x]['appointment_id'] = $select_all_appoinment_row['appointment_id'];
		$response_arr[$x]['patient_id'] = $select_all_appoinment_row['patient_id'];
		$response_arr[$x]['patient_name'] = $patient_name;
		$response_arr[$x]['invoice_campain'] = $select_all_appoinment_row['invoice_campain'];
		$response_arr[$x]['addedDate'] = $select_all_appoinment_row['addedDate'];
		$response_arr[$x]['appointment_fee'] = $appoinment_fee;
		$response_arr[$x]['patient_type'] = $patient_type;
		$x++;
		}
		}
		
	}
}else{
	//$response_arr[0]['data_exist'] = 0;
}
}else{
	$response_arr[0]['status'] = 0;
}
}
}
echo json_encode($response_arr);
?>
