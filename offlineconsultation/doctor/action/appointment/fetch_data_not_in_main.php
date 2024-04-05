<?php
session_start();
require_once '../../../_class/query.php';
require_once '../../../_class_common/query_common.php';
$obj_common=new query_common();
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$patient_id = $_POST['patient_id'];
$branch = 5;
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$select_branch_data = $obj_branch->selectData("id,unique_id,logind_id,code,year,no,name,phone,address,place,whatsApp,age,gender,added_date,added_time,added_by,status,online_account_status,patient_type,branch_data,password,branch_id","tbl_patient","where status!=0 and online_account_status=0");
if(mysqli_num_rows($select_branch_data)){
	while($select_branch_data_row = mysqli_fetch_array($select_branch_data)){
		$id = $select_branch_data_row['id'];
		$unique_id = $select_branch_data_row['unique_id'];
		if (strpos($unique_id,'Pala') == false) {
			$logind_id = $select_branch_data_row['logind_id'];
			$code = $select_branch_data_row['code'];
			$year = $select_branch_data_row['year'];
			$no = $select_branch_data_row['no'];
			$name = $select_branch_data_row['name'];
			$phone = $select_branch_data_row['phone'];
			$address = $select_branch_data_row['address'];
			$place = $select_branch_data_row['place'];
			$whatsApp = $select_branch_data_row['whatsApp'];
			$age = $select_branch_data_row['age'];
			$gender = $select_branch_data_row['gender'];
			$added_date = $select_branch_data_row['added_date'];
			$added_time = $select_branch_data_row['added_time'];
			$added_by = $select_branch_data_row['added_by'];
			$status = $select_branch_data_row['status'];
			$online_account_status = $select_branch_data_row['online_account_status'];
			$patient_type = $select_branch_data_row['patient_type'];
			$branch_data = $select_branch_data_row['branch_data'];
			$password = $select_branch_data_row['password'];
			$branch_id = $select_branch_data_row['branch_id'];
			$split_unique_id = explode("/",$unique_id);
			$new_unique_id = $split_unique_id['0'].'/'.$split_unique_id['1'].'/Pala/'.$split_unique_id['2'];
			//echo $new_unique_id ;exit();
			   $info_add_data = array(
				   "logind_id" => $logind_id,
				   "code" => $code,
				   "no" => $no,
				   "unique_id" => $new_unique_id,
				   "name" => $name,
				   "phone" => $phone,
				   "address" => $address,
				   "place" => $place,
				   "whatsApp" => $whatsApp,
				   "age" => $age,
				   "gender" => $gender,
				   "added_date" => $added_date,
				   "added_time" => $added_time,
				   "added_by" => $added_by,
				   "status" => $status,
				   "online_account_status" => $online_account_status,
				   "patient_type" => $patient_type,
				   "branch_data" => $branch_data,
				   "password" => $password,
				   "branch_id" => $branch_id
			   );
			
		 	$obj_common->insertData("tbl_patient",$info_add_data);
			$info_update = array(
				"unique_id" => $new_unique_id
			);
			$obj_branch->updateData("tbl_patient",$info_update,"where id=$id");
		}else{
			//echo $unique_id;exit();
		}
	}
}
?>