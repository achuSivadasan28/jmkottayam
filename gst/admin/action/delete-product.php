<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];
include '../../_class/query.php';
$obj = new query();
$id=$_GET['id'];
$info=[
    'status'=>0
];
$days=date('d-m-Y');
$times=date('h:i:s A');
$product_name = '';
$update_Data=$obj->updateData("tbl_product",$info,"where id=$id");
$select_product_name = $obj->selectData("product_name","tbl_product","where id=$id");
if(mysqli_num_rows($select_product_name)>0){
	while($select_product_name_row = mysqli_fetch_array($select_product_name)){
		$product_name = $select_product_name_row['product_name'];
	}
}
$remark = "$product_name is deleted by admin on $days at $times";
		$info_add_data = array(
			"product_id" => $id,
			"product_activity" => "$product_name Deleted",
			"performed_by" => $adminLogId,
			"performed_date" => $days,
			"performed_time" => $times,
			"remark" => $remark,
			"status" => 1
		);
		$obj->insertData("tbl_stock_activity",$info_add_data);
echo "1";

?>