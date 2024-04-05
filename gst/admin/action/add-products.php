<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$p_name= $_POST['p_name'];
$price= $_POST['price'];
$discount= $_POST['discount'];
$quantity= $_POST['quantity'];
$categoryid= $_POST['select'];
$info_user = array(
    "product_name" => $p_name,
    "category_id" => $categoryid,
    "price" => $price,
    "discount" => $discount,
    "quantity" => $quantity,
    "added_date"=>$days,
    "time"=>$times,
    "status"=>1,
);
$obj->insertData("tbl_product",$info_user);
	$select_added_product = $obj->selectData("id","tbl_product","where product_name='$p_name' and category_id=$categoryid and added_date='$days' and status=1");
	if(mysqli_num_rows($select_added_product)>0){
		$select_added_product_row = mysqli_fetch_array($select_added_product);
		$pid = $select_added_product_row['id'];
$select_cat_name = $obj->selectData("category_name","tbl_category","where id=$category");
if(mysqli_num_rows($select_cat_name)>0){
	$select_cat_name_row = mysqli_fetch_array($select_cat_name);
	$category_name = $select_cat_name_row['category_name'];
}
		$remark = "New Product $p_name added by admin on $days at $times. product price is $price and stock is $quantity and its category is $category_name";
		$info_add_data = array(
			"product_id" => $pid,
			"product_activity" => "Product $p_name Added",
			"performed_by" => $adminLogId,
			"performed_date" => $days,
			"performed_time" => $times,
			"remark" => $remark,
			"status" => 1
		);
		$obj->insertData("tbl_stock_activity",$info_add_data);
	}

    echo 0;


?>