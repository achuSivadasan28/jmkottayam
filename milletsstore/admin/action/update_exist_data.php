<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$ProductName = $_POST['ProductName'];
$product_id = $_POST['product_id'];
$product_id_details = $_POST['product_id_details'];
$Price = $_POST['Price'];
$Quantity = $_POST['Quantity'];
$Rate = $_POST['Rate'];
$tax_in_per = $_POST['tax_in_per'];
$tax_data = $_POST['tax_data'];
$no_quantity = 0;
$pills_id = 0;
$check_quantity = $obj->selectData("no_quantity,pills_id","tbl_productdetails","where id=$product_id_details");
if(mysqli_num_rows($check_quantity)>0){
	$check_quantity_row = mysqli_fetch_array($check_quantity);
	$no_quantity = $check_quantity_row['no_quantity'];
	$pills_id = $check_quantity_row['pills_id'];
}
$check_quantity = $no_quantity-$Quantity;
if($check_quantity < 0){
	$actual_quantity = $check_quantity*-1;
	$fetch_current_stock = $obj->selectData("quantity","tbl_medicine_details","where id=$pills_id");
	if(mysqli_num_rows($fetch_current_stock)>0){
		$fetch_current_stock_row = mysqli_fetch_array($fetch_current_stock);
		$old_quantity = $fetch_current_stock_row['quantity'];
		$total_old_quantity = $old_quantity-$actual_quantity;
		$info_update_q = array(
			"quantity" => $total_old_quantity
		);
		$obj->updateData("tbl_medicine_details",$info_update_q,"where id=$pills_id");
	}
}else if($check_quantity >0 ){
	$actual_quantity = $check_quantity;
	$fetch_current_stock = $obj->selectData("quantity","tbl_medicine_details","where id=$pills_id");
	if(mysqli_num_rows($fetch_current_stock)>0){
		$fetch_current_stock_row = mysqli_fetch_array($fetch_current_stock);
		$old_quantity = $fetch_current_stock_row['quantity'];
		$total_old_quantity = $old_quantity+$actual_quantity;
		$info_update_q = array(
			"quantity" => $total_old_quantity
		);
		$obj->updateData("tbl_medicine_details",$info_update_q,"where id=$pills_id");
	}
}
$update_arr = array(
	"product_name" => $ProductName,
	"no_quantity" => $Quantity,
	"price" => $Price,
	"total_price" => $Rate,
	"product_id" => $product_id,
	"tax_in_per" => $tax_in_per,
	"tax_data" => $tax_data,
);
$obj->updateData("tbl_productdetails",$update_arr,"where id=$product_id_details");

?>