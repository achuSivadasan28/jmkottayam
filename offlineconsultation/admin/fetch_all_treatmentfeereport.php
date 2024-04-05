<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_branch/query_branch.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$response_arr[0]['gpay'] = 0;
$response_arr[0]['cash'] = 0;
$response_arr[0]['card'] = 0;
$obj=new query();
$obj_common = new query_common();
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
$online_date_clause = "";
$treatment_date_clause = "";
// date filter
if ($startDate_url != 0) {
	if ($EndDate_url != 0) {
		if ($startDate_url == $EndDate_url) {
			$date_where_clause = " and tbl_appointment_modeinvoice.addedDate='$startDate_new_format'";
			$start_date1 = date('Y-m-d',strtotime($startDate_new_format));
			$online_date_clause = "and date = '$start_date1'";
			$treatment_date_clause = "and added_date  = '$startDate_new_format'";
			$where_date_clause = "and appointment_date = '$start_date1'";
		} else {
			$date_diff = ($EndDate - $startDate) / 60 / 60 / 24;
			if ($date_diff != 0) {
				$date_where_clause = " and (";
				$online_date_clause =  " and (";
				$treatment_date_clause = "and (";
				$where_date_clause = "and (";
				for ($x1 = 0; $x1 <= $date_diff; $x1++) {
					$new_date = date('d-m-Y', strtotime($startDate_new_format . ' +' . $x1 . ' day'));
					$new_date1 = date('Y-m-d', strtotime($startDate_new_format . ' +' . $x1 . ' day'));
					
					if ($x1 == $date_diff) {
						$online_date_clause .=  " date = '$new_date1')";
						$treatment_date_clause .= "added_date = '$new_date' ";
						$date_where_clause .= "tbl_appointment_modeinvoice.addedDate='$new_date')";
						$where_date_clause .= "appointment_date = '$new_date1' )";
					} else {
						$online_date_clause .= " date = '$new_date1' or";
						$treatment_date_clause .= "added_date = '$new_date' or ";
						$date_where_clause .= "tbl_appointment_modeinvoice.addedDate='$new_date' or ";
						$where_date_clause .= "appointment_date = '$new_date1' or ";
					}
				}
					$treatment_date_clause .= ")"; 
			} else {
				$start_date1 = date('Y-m-d',strtotime($startDate_new_format));
				$online_date_clause .= "and date = '$start_date1'";
				$treatment_date_clause .= "and added_date  = '$startDate_new_format'";
				$date_where_clause .= " and tbl_appointment_modeinvoice.addedDate =$startDate_new_format";
				$where_date_clause .= "and appointment_date = '$start_date1'";
			}
		}
	} else {
		$start_date1 = date('Y-m-d',strtotime($startDate_new_format));
		$online_date_clause .= "and date = '$start_date1'";
		$treatment_date_clause .= "and added_date  = '$startDate_new_format'";
		$date_where_clause .= " and tbl_appointment_modeinvoice.addedDate='$startDate_new_format'";
		$where_date_clause .= "and appointment_date = '$start_date1' ";
	}

	}else{
	$start_date1 = date('Y-m-d',strtotime($startDate_current));
	$online_date_clause .= "and date = '$start_date1' ";
	$treatment_date_clause .= "and added_date  = '$startDate_current'";
$date_where_clause = " and tbl_appointment_modeinvoice.addedDate='$startDate_current'";
	$where_date_clause = "and appointment_date = '$start_date1' ";
}
	$payment_mode = ['Gpay','Cash','Card'];
	$select_treatment_data = $obj->selectData("tbl_treatment_invoice.invoice_num_com,tbl_treatment_invoice.id,tbl_treatment_invoice.patient_id,tbl_treatment_invoice.added_date,tbl_treatment_invoice.total_amt","tbl_treatment_invoice","where status != 0  and total_amt != 0 $treatment_date_clause limit $limit");
	//echo $select_treatment_data;exit();
	if(mysqli_num_rows($select_treatment_data)){
		$x = 0;
		while($select_treatment_data_rows = mysqli_fetch_assoc($select_treatment_data)){
			$patient_id = $select_treatment_data_rows['patient_id'];
			$invoice_num  = $select_treatment_data_rows['id'];
			$response_arr[$x]['invoice_num_com'] = $select_treatment_data_rows['invoice_num_com'];
			$response_arr[$x]['added_date'] = $select_treatment_data_rows['added_date'];
			$response_arr[$x]['tot_amt'] = $select_treatment_data_rows['total_amt'];
			$select_patient_details = $obj_common -> selectData("name,phone","tbl_patient","where status != 0 and patient_pk = $patient_id");
			if(mysqli_num_rows($select_patient_details)){
				$select_patient_details_rows = mysqli_fetch_assoc($select_patient_details);
				$response_arr[$x]['patient_name'] = $select_patient_details_rows['name'];
			}
			$select_payment_mode = $obj-> selectData("amount,payment_type","tbl_treatment_payment_mode","where invoice_id = $invoice_num and status !=0 ");
			if(mysqli_num_rows($select_payment_mode)){
				$y = 0;
				$payment_type = "";
				while($select_payment_mode_data = mysqli_fetch_assoc($select_payment_mode)){
					$response_arr[$x]['payment'][$y]['payment_type'] = $select_payment_mode_data['payment_type'];
					$response_arr[$x]['payment'][$y]['amount'] = $select_payment_mode_data['amount'];
					if($select_payment_mode_data['payment_type'] == 1){
						$response_arr[0]['gpay'] += $select_payment_mode_data['amount'];
					}else if($select_payment_mode_data['payment_type'] == 2){
						$response_arr[0]['cash'] += $select_payment_mode_data['amount'];
					}else if($select_payment_mode_data['payment_type'] == 3){
						$response_arr[0]['card'] += $select_payment_mode_data['amount'];
					}
					$payment_type .=  $payment_mode[$select_payment_mode_data['payment_type'] - 1]. "(".$select_payment_mode_data['amount'].")";
					$y++;
				}
				$response_arr[$x]['payment_mode'] = $payment_type;
			}
		 $x++;
		}
	}
	$select_new_appointment_fee = $obj->selectData("count(*) as total","tbl_treatment_invoice","where status != 0 and total_amt != 0 $treatment_date_clause");
	//echo $select_new_appointment_fee;exit();
	if(mysqli_num_rows($select_new_appointment_fee)){
		$select_new_appointment_fee_rows = mysqli_fetch_assoc($select_new_appointment_fee);	
		$response_arr[0]['treat_count'] = $select_new_appointment_fee_rows['total'];
		
	}
	
$i = 0;

	
	
	

}else{
	//$response_arr[0]['data_exist'] = 0;
}
}else{
	$response_arr[0]['status'] = 0;
}
}

echo json_encode($response_arr);
?>
