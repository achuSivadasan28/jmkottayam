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
$cat_sum = $obj->selectData("count(tbl_product.id) as id","tbl_product inner join  tbl_medicine_details on tbl_product.id = tbl_medicine_details.product_id inner join tbl_category on tbl_category.id = tbl_product.category_id","where tbl_product.status!=0  and tbl_medicine_details.status != 0 and tbl_medicine_details.quantity > 0 and tbl_category.status != 0 $search_where ");
$cat_sum_row = mysqli_fetch_array($cat_sum);
if($cat_sum_row['id'] != null){
	$cat_count = $cat_sum_row['id'];
}
echo $cat_count;
?>