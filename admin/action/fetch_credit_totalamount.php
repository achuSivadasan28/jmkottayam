<?php

session_start();
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();


$x = 0;


$startDate_url        =   $_GET['start_date'];
$startDate_new_format =   date("d-m-Y", strtotime($startDate_url));
$startDate            =   strtotime($startDate_new_format);
$EndDate_url          =   $_GET['end_date'];
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


$customer = $obj1->selectData("sum(tbl_credit_note_products.returned_amount) as total_amount ","tbl_credit_note"," INNER JOIN tbl_credit_note_products on tbl_credit_note.id = tbl_credit_note_products.tbl_credit_note_id  where tbl_credit_note.status =1 $date_where_clause");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
     	$total = $customer_row['total_amount'];
		if($total != null){
		$response_arr[$x]['total_amount'] = $customer_row['total_amount'];
			}else{
			$response_arr[$x]['total_amount'] = 0;
		
		}
		$x++;
    }
}

echo json_encode($response_arr);
?>
