<?php
session_start();
$staff_id=$_SESSION['staff']; 
require_once '../../_class/query.php';
$obj=new query();
$search_val = $_POST['search_val'];
$status_id = $_POST['status_id'];
$start_date = $_POST['start_date'];
$start_date_new_order = date("d-m-Y",strtotime($start_date));
$end_date = $_POST['end_date'];
$end_date_new_order = date("d-m-Y",strtotime($end_date));
$search_where = "";
if($search_val != ''){
	$search_where = " and (tax_compained_val like '%$search_val%' or customer_name like '%$search_val%' or phone like '%$search_val%' or invoice_no like '%$search_val%')";
}
$where_staff_clause = '';
if($status_id != 0){
	$where_staff_clause = " and staff_id = $status_id";
}

$where_search_date = '';
if($start_date != '' and $end_date !=''){

	$start_date1 = date_create($start_date);
	$end_date1 = date_create($end_date);
	$start_date2 = $start_date1;
	$diff=date_diff($start_date1,$end_date1);
	$diff1 =  $diff->format("%a");
	//$loop_date = date_create($start_date);
	$y1 = 0;
	$loop_date = date_format($start_date1,'d-m-Y');
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " and (created_date like '%$loop_date%'"; 
		}else{
			$where_search_date .= " or created_date like '%$loop_date%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"d-m-Y");
		$start_date2 = date_create($loop_date);
	}
	
	$where_search_date .= ")";
}else if($start_date !='' or $end_date!= ''){
	if($where_search ==''){
		$where_search_date = " ";
	}
	if($start_date != ''){
		$start_date1 = date_create($start_date);
		$date1 = date_format($start_date1,"d-m-Y");
		$where_search_date .= " and created_date like '%$date1%'";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and created_date like '%$date2%'";
	}
}
$bill_count = 0;
$customer_sum = $obj->selectData("count(id) as id","tbl_customer"," where status!=0 $search_where $where_search_date $where_staff_clause ORDER BY id DESC");
$customer_sum_row = mysqli_fetch_array($customer_sum);
if($customer_sum_row['id'] != null){
	$bill_count = $customer_sum_row['id'];
}
echo $bill_count;
?>