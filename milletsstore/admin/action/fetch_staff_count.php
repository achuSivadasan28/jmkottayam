<?php
session_start();
$staff_id=$_SESSION['staff']; 
require_once '../../_class/query.php';
$obj=new query();
$search_val = $_POST['search_val'];

$search_where = "";
if($search_val != ''){
	$search_where = " and (staff_name like '%$search_val%' or email like '%$search_val%' or phone like '%$search_val%')";
}

$staff_count = 0;
$customer_sum = $obj->selectData("count(id) as id","tbl_staff"," where status=1 $search_where ORDER BY id DESC");
$customer_sum_row = mysqli_fetch_array($customer_sum);
if($customer_sum_row['id'] != null){
	$staff_count = $customer_sum_row['id'];
}
echo $staff_count;
?>