
<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
include '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$id=$_GET['id'];
$p_name = $_POST['p_name'];
$category = $_POST['category'];
$discount = $_POST['discount'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
    $info=[
        "product_name" => $p_name,
        "category_id" => $category,
        "price" => $price,
        "discount" => $discount,
        "quantity" => $quantity,
        "added_date"=>$days,
        "time"=>$times,
        "status"=>1
        ];
$updateData =$obj->updateData("tbl_product",$info,"where id =$id"); 

$select_cat_name = $obj->selectData("category_name","tbl_category","where id=$category");
if(mysqli_num_rows($select_cat_name)>0){
	$select_cat_name_row = mysqli_fetch_array($select_cat_name);
	$category_name = $select_cat_name_row['category_name'];
}
		$remark = "New Product $p_name added by admin on $days at $times. product price is $price and stock is $quantity and its category is $category_name";
		$info_add_data = array(
			"product_id" => $id,
			"product_activity" => "Edited Product $p_name",
			"performed_by" => $adminLogId,
			"performed_date" => $days,
			"performed_time" => $times,
			"remark" => $remark,
			"status" => 1
		);
		$obj->insertData("tbl_stock_activity",$info_add_data);
	
echo 1;
?>

