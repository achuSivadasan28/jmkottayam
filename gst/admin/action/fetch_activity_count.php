<?php
session_start();
$staff_id=$_SESSION['staff']; 
require_once '../../_class/query.php';
$obj=new query();
$search_val = $_POST['search_val'];

$bill_count = 0;
$customer_sum = $obj->selectData("count(id) as id","tbl_stock_activity"," where status!=0 ORDER BY id DESC");
$customer_sum_row = mysqli_fetch_array($customer_sum);
if($customer_sum_row['id'] != null){
	$bill_count = $customer_sum_row['id'];
}
echo $bill_count;
?>