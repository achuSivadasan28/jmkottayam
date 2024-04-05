<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_branch/query_branch.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();

date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$next_date = $_POST['next_date'];
$url_val = $_POST['url_val'];
$next_time = $_POST['next_time'];
$online_confirm_date = '';
$fetch_current_date = $obj->selectData("online_confirm_date,branch_id,real_branch_id","tbl_appointment","where id=$url_val");
if(mysqli_num_rows($fetch_current_date)>0){
	$fetch_current_date_row = mysqli_fetch_array($fetch_current_date);
	$online_confirm_date = $fetch_current_date_row['online_confirm_date'];
	$real_branch_id = $fetch_current_date_row['real_branch_id'];
	$branch_id = $fetch_current_date_row['branch_id'];
	if($real_branch_id == $branch_id){
		$update_current_sitting = array(
			"appointment_id" => $url_val,
			"consulted_date" => $online_confirm_date,
			"added_date" => $days,
			"status" => 1
		);
		
		$obj->insertData("tbl_online_appointment_sitting_history",$update_current_sitting);
		$update_appointment_date = array(
			"online_confirm_date" => $next_date,
			"appointment_date" => $next_date,
			"online_confirm_time" => $next_time,
		);
		$obj->updateData("tbl_appointment",$update_appointment_date,"where id=$url_val");
		echo 1;
		
	}else{
		$branch = $branch_id;
		$obj_branch = new query_branch();
		$select_appointment = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id = $url_val");
		if(mysqli_num_rows($select_appointment)>0){
			$select_appointment_id = mysqli_fetch_assoc($select_appointment);
			$appointment_id = $select_appointment_id['id'];

			$update_current_sitting = array(
				"appointment_id" => $appointment_id,
				"consulted_date" => $online_confirm_date,
				"added_date" => $days,
				"status" => 1
			);
			$obj_branch->insertData("tbl_online_appointment_sitting_history",$update_current_sitting);

			$update_appointment_date = array(
				"online_confirm_date" => $next_date,
				"appointment_date" => $next_date,
				"online_confirm_time" => $next_time,
			);
			$obj->updateData("tbl_appointment",$update_appointment_date,"where id=$url_val");
			$obj_branch->updateData("tbl_appointment",$update_appointment_date,"where cross_appointment_id = $url_val");
			echo 1;
		}
			
	}
	
}
?>