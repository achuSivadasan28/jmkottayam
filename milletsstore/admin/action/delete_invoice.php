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
$select_invoice_p = $obj->selectData("product_id,no_quantity,pills_id","tbl_productdetails","where customer_id=$id");
if(mysqli_num_rows($select_invoice_p)>0){
	while($select_invoice_p_row = mysqli_fetch_array($select_invoice_p)){
		$product_id  = $select_invoice_p_row['product_id'];
		$no_quantity  = $select_invoice_p_row['no_quantity'];
		$pills_id  = $select_invoice_p_row['pills_id'];
		$select_total_quantity = $obj->selectData("quantity","tbl_medicine_details","where id=$pills_id");
		if(mysqli_num_rows($select_total_quantity)>0){
			$select_total_quantity_row = mysqli_fetch_array($select_total_quantity);
			$quantity = $select_total_quantity_row['quantity'];
			$total_quantity = $quantity+$no_quantity;
			$info_update_total_q = array(
				"quantity" => $total_quantity
			);
			$obj->updateData("tbl_medicine_details",$info_update_total_q,"where id=$pills_id");
		}
	}
}

?>