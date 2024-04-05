<?php
session_start();
require_once '../../_class/query.php';
$obj1=new query();
$response_arr = array();

 $search_val=$_GET['search_val'];
 $limit=$_GET['limit_range'];
$x = 0;


$where_name_filter = '';
if($search_val != ''){
$where_name_filter = " and (tbl_credit_note.credit_note_invoice_number like '%$search_val%') ";
}



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







$customer = $obj1->selectData("id,invoice_id,invoice_number,credit_note_invoice_number,addedDate,addedTime","tbl_credit_note"," where status =1  $where_name_filter $date_where_clause ORDER BY id DESC limit $limit");
if(mysqli_num_rows($customer)>0){
    while($customer_row = mysqli_fetch_array($customer)){
        $response_arr[$x]['id'] = $customer_row['id'];
        $response_arr[$x]['invoice_id'] = $customer_row['invoice_id'];
        $response_arr[$x]['invoice_number'] = $customer_row['invoice_number'];
        $response_arr[$x]['dates'] = $customer_row['addedDate'].' '.$customer_row['addedTime'];
		  $response_arr[$x]['date'] = $customer_row['addedDate'];
        $response_arr[$x]['credit_note_invoice_number'] = $customer_row['credit_note_invoice_number'];
		
$invoice_id = $customer_row['invoice_id'];
$selectData1 = $obj1->selectData("id,customer_name,phone","tbl_customer","where id='$invoice_id'");
$temp_name= mysqli_fetch_assoc($selectData1);
$customer_name = $temp_name['customer_name'];
$phone = $temp_name['phone'];
		
		$tbl_id = $customer_row['id'];
		
		$response_arr[$x]['customer_name'] =$customer_name;
        $response_arr[$x]['phone'] = $phone;
        
		$y = 0;
		$total_price_1 = 0;
		
        $fetch_data = $obj1->selectData("id,tbl_credit_note_id,product_name,amount_paid,product_price,returned_qty,returned_amount","tbl_credit_note_products","where tbl_credit_note_id=$tbl_id and status!=0");
        if(mysqli_num_rows($fetch_data)>0){
            while($fetch_data_row = mysqli_fetch_array($fetch_data)){
				$total_price_1 += $fetch_data_row['returned_amount'];
				 $y++;
			 }
        }
		
		
		$response_arr[$x]['total_price_1'] = $total_price_1;
		$x++;
    }
}

echo json_encode($response_arr);
?>
