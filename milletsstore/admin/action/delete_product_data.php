<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$btn_id = $_POST['btn_id'];
$url_val = $_POST['url_val'];
$total_amt = $_POST['total_amt'];
$g_total_amt = $_POST['g_total_amt'];
$total_dis = $_POST['total_dis'];
$p_actual_price = $_POST['p_actual_price'];
$p_total_price = $_POST['p_total_price'];
$info_update_data = array(
	"status" => 0,
	"remark" => "Admin Removed on ".$days." ".$times,
);
$obj->updateData("tbl_productdetails",$info_update_data,"where id=$btn_id");
//check stock
$fetch_stock_data = $obj->selectData("no_quantity,pills_id","tbl_productdetails","where id=$btn_id");
if(mysqli_num_rows($fetch_stock_data)>0){
	while($fetch_stock_data_row = mysqli_fetch_array($fetch_stock_data)){
		$no_quantity = $fetch_stock_data_row['no_quantity'];
		$pills_id = $fetch_stock_data_row['pills_id'];
		$check_product_stock = $obj->selectData("quantity","tbl_medicine_details","where id=$pills_id");
		if(mysqli_num_rows($check_product_stock)>0){
			$check_product_stock_row = mysqli_fetch_array($check_product_stock);
			$quantity = $check_product_stock_row['quantity'];
			$total_new_quantity = $quantity+$no_quantity;
			$info_new_quantity = array(
				"quantity" => $total_new_quantity
			);
		 $obj->updateData("tbl_medicine_details",$info_new_quantity,"where id=$pills_id");
		}
	}
}
$check_products = $obj->selectData("id","tbl_productdetails","where customer_id=$url_val and status!=0");
if(mysqli_num_rows($check_products)>0){
$total_amt_g_total = $g_total_amt-$p_total_price;
$info_update_total = array(
	"total_price" => $total_amt_g_total,
	"total_discount" => $total_dis,
	"total_amonut" => $total_amt_g_total,
	"edit_status" => 1
);
$obj->updateData("tbl_customer",$info_update_total,"where id=$url_val");
	echo 1;
}else{
	$info_delete_customer = array(
	"status" => 0
);
$obj->updateData("tbl_customer",$info_delete_customer,"where id=$url_val");
	echo 0;
}

//tbl_customer
?>