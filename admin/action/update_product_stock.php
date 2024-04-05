<?php
session_start();
require_once '../../_class/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$product_id = $_POST['product_id'];
$product_name = $_POST['ProductName'];
$returned_qty = $_POST['remaining_qty'];
$pills_id = $_POST['Productnopill_id'];
$credit_invoice_id = $_POST['credit_invoice_id'];

$amount_paid = $_POST['amount_paid'];
$remaining_qty = $_POST['remaining_qty'];
$returned_amount = $_POST['returned_amount'];
$product_price= $_POST['Price'];

 $fetch_current_stock = $obj->selectData("quantity","tbl_medicine_details","where id=$pills_id");
	if(mysqli_num_rows($fetch_current_stock)>0){
		$fetch_current_stock_row = mysqli_fetch_array($fetch_current_stock);
		$old_quantity = $fetch_current_stock_row['quantity'];
		$new_qty = $old_quantity+$returned_qty;
		
$info_update_q = array(
			"quantity" => $new_qty
		);
		$obj->updateData("tbl_medicine_details",$info_update_q,"where id=$pills_id");
		
	}


//insert credit products

$info_credit_products = array(
	"tbl_credit_note_id" => $credit_invoice_id,
	"meds_tbl_id" => $pills_id,
	"product_id" =>$product_id,
	"product_name" => $product_name,
	"product_price" => $product_price,
	"amount_paid" => $amount_paid,
	"returned_qty" =>$remaining_qty,
	"returned_amount" =>$returned_amount,
    "status"=>1,
	
);
$insert=$obj->insertData("tbl_credit_note_products",$info_credit_products);




 $creditnote_activity_log = array(
        "action_done" =>'admin updated quantity of product '."".$product_name."".' having old quantity '."".$old_quantity."".' to new quantity '."".$new_qty."".' where id is '."".$pills_id,
        "addedDate" =>$days,
        "addedTime" => $times,
        "status" => 1
    );
    $obj->insertData("tbl_credit_noteactivity",$creditnote_activity_log);





?>