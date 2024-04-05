<?php
session_start();
$staffId = $_SESSION['staffId'];
include '../../_class/query.php';
$obj = new query();
$days=date('d-m-Y');
$times=date('h:i:s A');
$id=$_GET['id'];
$info=[
    'status'=>0
];
$update_Data=$obj->updateData("tbl_product",$info,"where id=$id");
$staff_name = '';
		$select_staff_name = $obj->selectData("staff_name","tbl_staff","where id=$staffId");
		if(mysqli_num_rows($select_staff_name)>0){
			$select_staff_name_row = mysqli_fetch_array($select_staff_name);
			$staff_name = $select_staff_name_row['staff_name'];
		}
$product_name = '';
$select_product_name = $obj->selectData("product_name","tbl_product","where id=$id");
if(mysqli_num_rows($select_product_name)>0){
	while($select_product_name_row = mysqli_fetch_array($select_product_name)){
		$product_name = $select_product_name_row['product_name'];
	}
}

		$remark = "$product_name is deleted by $staff_name on $days at $times";
		$info_add_data = array(
			"product_id" => $pid,
			"product_activity" => "$product_name Deleted",
			"performed_by" => $staffId,
			"performed_date" => $days,
			"performed_time" => $times,
			"remark" => $remark,
			"status" => 1
		);
		$obj->insertData("tbl_stock_activity",$info_add_data);
echo "1";

?>