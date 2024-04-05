<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
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



$sino = 1;
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 

// Excel file name for download 
$fileName = "AppoinmentFee_Reports" . date('d-m-Y') . ".xls"; 

$fields = array('No','Invoice number','Name','Date','Treatment Fee','Payment Type');

$excelData = implode("\t", array_values($fields)) . "\n"; 

	
	
	
	$search_val=$_GET['search'];
$where_name_filter = '';
if($search_val != ''){
$where_name_filter = " and (tbl_appointment_modeinvoice.invoice_campain like '%$search_val%') ";
}
	
	
	
	
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
			$date_where_clause = " and tbl_treatment_invoice.added_date='$startDate_new_format'";
		} else {
			$date_diff = ($EndDate - $startDate) / 60 / 60 / 24;
			if ($date_diff != 0) {
				$date_where_clause = " and (";
				for ($x1 = 0; $x1 <= $date_diff; $x1++) {
					$new_date = date('d-m-Y', strtotime($startDate_new_format . ' +' . $x1 . ' day'));
					if ($x1 == $date_diff) {
						$date_where_clause .= "tbl_treatment_invoice.added_date='$new_date')";
					} else {
						$date_where_clause .= "tbl_treatment_invoice.added_date='$new_date' or ";
					}
				}
			} else {
				$date_where_clause = " and tbl_treatment_invoice.added_date =$startDate_new_format";
			}
		}
	} else {
		$date_where_clause = " and tbl_treatment_invoice.added_date='$startDate_new_format'";
	}
}
	


$select_all_appoinmentfeereports = $obj->selectData("appointment_id, patient_id,invoice_num_com,added_date,id ","tbl_treatment_invoice","where status!=0 $date_where_clause   order by id desc ");

if(mysqli_num_rows($select_all_appoinmentfeereports)>0){
	$x = 0;
	while($select_all_appoinment_row = mysqli_fetch_array($select_all_appoinmentfeereports)){
		$invoice_id = $select_all_appoinment_row['id'];
		$payment_mode_data = '';
		$select_payment_mode = $obj->selectData("payment_type,amount","tbl_treatment_payment_mode","where invoice_id =$invoice_id and status!=0");
		if(mysqli_num_rows($select_payment_mode)){
			$pay_mode = '';
			while($select_payment_mode_row = mysqli_fetch_array($select_payment_mode)){
				if($select_payment_mode_row['payment_type'] == 1){
						$pay_mode = 'gpay';
					}else if($select_payment_mode_row['payment_type'] == 2){
						$pay_mode = 'cash';
					}else if($select_payment_mode_row['payment_type'] == 3){
						$pay_mode = 'card';
					}
				$amount = $select_payment_mode_row['amount'];
				if($payment_mode_data != ''){
						$payment_mode_data .= " ,".$pay_mode."(".$select_payment_mode_row['amount'].")";
					}else{
						$payment_mode_data = "$pay_mode (".$select_payment_mode_row['amount'].")";
					}
			}
		}
			$patient_id=$select_all_appoinment_row['patient_id'];
		$selectData1=$obj->selectData("id,name","tbl_patient","where id = $patient_id");
$temp_name= mysqli_fetch_assoc($selectData1);
$patient_name=$temp_name['name'];

		
	
 
	$lineData = array($sino, $select_all_appoinment_row['invoice_num_com'],$patient_name,$select_all_appoinment_row['added_date'],$amount,$payment_mode_data); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n";
	$sino++;
	 
 //}
}
 }
else{ 
    $excelData .= 'No records found...'. "\n"; 
} 



// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
}
}
}



?>