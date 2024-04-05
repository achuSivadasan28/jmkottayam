<?php

include '../../_class/query.php';

$obj = new Query();



 

$search_val=$_POST['search_val'];
$length=0;


$where_name_filter = '';
if($search_val != ''){
$where_name_filter = " and (tbl_credit_note.credit_note_invoice_number like '%$search_val%') ";
}



$startDate_url        =   $_POST['start_date'];
$startDate_new_format =   date("d-m-Y", strtotime($startDate_url));
$startDate            =   strtotime($startDate_new_format);
$EndDate_url          =   $_POST['end_date'];
$EndDate_new_format   =   date("d-m-Y", strtotime($EndDate_url));
$EndDate              =   strtotime($EndDate_new_format);
$date_diff            = 0;
$date_where_clause    = "";

if ($startDate_url != 0) {
	if ($EndDate_url != 0) {
		if ($startDate_url == $EndDate_url) {
			$date_where_clause = " and tbl_credit_note.addedDate='$startDate_new_format'";
		} else {
			$date_diff = ($EndDate - $startDate) / 60 / 60 / 24;
			if ($date_diff != 0) {
				$date_where_clause = " and (";
				for ($x1 = 0; $x1 <= $date_diff; $x1++) {
					$new_date = date('d-m-Y', strtotime($startDate_new_format . ' +' . $x1 . ' day'));
					if ($x1 == $date_diff) {
						$date_where_clause .= "tbl_credit_note.addedDate='$new_date')";
					} else {
						$date_where_clause .= "tbl_credit_note.addedDate='$new_date' or ";
					}
				}
			} else {
				$date_where_clause = " and tbl_credit_note.addedDate=$startDate_new_format";
			}
		}
	} else {
		$date_where_clause = " and tbl_credit_note.addedDate='$startDate_new_format'";
	}
}



$fetchReports = $obj->selectData("count(id) as id","tbl_credit_note","where status =1  $where_name_filter $date_where_clause");
$fetchReports_row = mysqli_fetch_array($fetchReports);
if($fetchReports_row['id'] != null){
	$length = $fetchReports_row['id'];
}
echo $length;
?>