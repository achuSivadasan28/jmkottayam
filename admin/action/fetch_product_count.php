<?php
session_start();
$staff_id=$_SESSION['staff']; 
require_once '../../_class/query.php';
$obj=new query();
$search_val = $_POST['search_val'];
$search_where = "";
if($search_val != ''){
	$search_where = " and (product_name like '%$search_val%')";
}
$cat_count = 0;
$cat_sum = $obj->selectData("count(id) as id","tbl_product"," where status!=0 $search_where  ORDER BY id DESC");
$cat_sum_row = mysqli_fetch_array($cat_sum);
if($cat_sum_row['id'] != null){
	$cat_count = $cat_sum_row['id'];
}
echo $cat_count;
?>