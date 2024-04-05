<?php

require_once '../../../_class/query.php';

$obj = new Query();

date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');

 
$length=0;
$search_val=$_POST['Searchval'];


$where_name_filter = '';
if($search_val != ''){
$where_name_filter = " and (tbl_appointment_modeinvoice.invoice_campain like '%$search_val%') ";
}
	
	
	$startDate_current       =   date("d-m-Y", strtotime($days));
	
	
	$startDate_url        =   $_POST['startdate'];

$startDate_new_format =   date("d-m-Y", strtotime($startDate_url));
$startDate            =   strtotime($startDate_new_format);
$EndDate_url          =   $_POST['enddate'];
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
}
else{
$date_where_clause = " and tbl_appointment_modeinvoice.addedDate='$startDate_current'";
}

  $fetchReports = $obj->selectData("count(tbl_appointment_modeinvoice.id) as id,tbl_appointment_modeinvoice.appointment_id,tbl_appointment_modeinvoice.patient_id,tbl_appointment_modeinvoice.invoice_campain,tbl_appointment_modeinvoice.addedDate,tbl_appoinment_payment.payment_id","tbl_appointment_modeinvoice inner join tbl_appointment on tbl_appointment_modeinvoice.appointment_id=tbl_appointment.id inner join tbl_appoinment_payment on tbl_appointment_modeinvoice.id=tbl_appoinment_payment.tbl_apmnt_mode_payid","where tbl_appointment_modeinvoice.status!=0 and 
tbl_appointment.status!=0 $date_where_clause $where_name_filter");
$fetchReports_row = mysqli_fetch_array($fetchReports);
if($fetchReports_row['id'] != null){
	$length = $fetchReports_row['id'];
}
echo $length;
?>