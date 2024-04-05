<?php
session_start();
$staff_id=$_SESSION['staff']; 
require_once '../../_class/query.php';
$obj=new query();
$search_val = $_POST['search_val'];
$status_id = $_POST['status_id'];
$start_date = $_POST['start_date'];
$start_date_new_order = date("Y-m-d",strtotime($start_date));
$start_date_new_order_new = date("d-m-Y",strtotime($start_date));
$end_date = $_POST['end_date'];
$end_date_new_order = date("Y-m-d",strtotime($end_date));
$end_date_new_order_new = date("d-m-Y",strtotime($end_date));
$search_where = "";
if($search_val != ''){
	$search_where = " and (tbl_customer.tax_compained_val like '%$search_val%' or tbl_customer.customer_name like '%$search_val%' or tbl_customer.phone like '%$search_val%' or tbl_customer.invoice_no like '%$search_val%' or tbl_productdetails.product_name like '%$search_val%')";
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
	$loop_date = date_format($start_date1,'Y-m-d');
	$loop_date_new = date_format($start_date1,'d-m-Y');
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " and (tbl_customer.created_date like '%$loop_date%' or tbl_customer.created_date like '%$loop_date_new%'"; 
		}else{
			$where_search_date .= " or tbl_customer.created_date like '%$loop_date%'  or tbl_customer.created_date like '%$loop_date_new%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"Y-m-d");
		$loop_date_new = date_format($start_date2,"d-m-Y");
		$start_date2 = date_create($loop_date);
	}
	
	$where_search_date .= ")";
}else if($start_date !='' or $end_date!= ''){
	if($where_search ==''){
		$where_search_date = " ";
	}
	if($start_date != ''){
		$start_date1 = date_create($start_date);
		$date1 = date_format($start_date1,"Y-m-d");
		$date1_new = date_format($start_date1,"d-m-Y");
		$where_search_date .= " and (tbl_customer.created_date like '%$date1%' or tbl_customer.created_date like '%$date1_new%')";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$date2_new = date_format($end_date1,"d-m-Y");
		$where_search_date .= " and (tbl_customer.created_date like '%$date2%' or tbl_customer.created_date like '%$date2_new%')";
	}
}
$bill_count = 0;
$customer_sum = $obj->selectData("count(tbl_productdetails.id) as id","tbl_customer inner join tbl_productdetails on tbl_customer.id=tbl_productdetails.customer_id"," where tbl_customer.status!=0 $search_where $where_search_date $where_staff_clause ORDER BY tbl_productdetails.id DESC");
//echo $customer_sum;exit();
$customer_sum_row = mysqli_fetch_array($customer_sum);
if($customer_sum_row['id'] != null){
	$bill_count = $customer_sum_row['id'];
}
echo $bill_count;
?>