<?php
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$id = $_POST['id'];
$reson = $_POST['reson'];
$info_delete = array(
	"status" => 0,
	"edit_data" => $days,
	"edit_time" => $times,
	"remark" => "Admin Cancelled",
	"reson" => $reson,
);
$obj->updateData("tbl_customer",$info_delete,"where id=$id");
$select_invoice_p = $obj->selectData("product_id,no_quantity","tbl_productdetails","where customer_id=$id");
if(mysqli_num_rows($select_invoice_p)>0){
	while($select_invoice_p_row = mysqli_fetch_array($select_invoice_p)){
		$product_id  = $select_invoice_p_row['product_id'];
		$no_quantity  = $select_invoice_p_row['no_quantity'];
		$select_total_quantity = $obj->selectData("quantity","tbl_product","where id=$product_id");
		$select_total_quantity_row = mysqli_fetch_array($select_total_quantity);
		$total_quantity = $select_total_quantity_row['quantity'];
		$total_quantity += $no_quantity;
		$reupdate_data = array(
			"quantity" => $total_quantity
		);
		$obj->updateData("tbl_product",$reupdate_data,"where id=$product_id");
	}
}

?>