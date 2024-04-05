<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$appointment_id_data = $_POST['appointment_id_data'];
$position_count = 1;
$select_appointmenT_pres = $obj->selectData("id","tbl_prescriptions","where appointment_id=$appointment_id_data and status!=0");
//echo $select_appointmenT_pres;exit();
if(mysqli_num_rows($select_appointmenT_pres)>0){
	while($select_appointmenT_pres_row = mysqli_fetch_array($select_appointmenT_pres)){
		$prescription_id = $select_appointmenT_pres_row['id'];
		$select_count = $obj->selectData("count(id) as id","tbl_prescription_medicine_data","where prescription_id=$prescription_id and status!=0");
		$select_count_row = mysqli_fetch_array($select_count);
		if($select_count_row['id'] != null){
			$position_count += $select_count_row['id'];
		}
		//tbl_prescription_medicine_data
	}
}
echo $position_count;
?>