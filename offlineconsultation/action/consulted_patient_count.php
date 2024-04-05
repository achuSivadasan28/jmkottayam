<?php
session_start();
require_once '../_class/query.php';
$response_arr = array();
$obj=new query();
require_once '../_class_common/query_common.php';
require_once '../_class_branch/query_branch.php';
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$search_val = $_POST['search_val'];
$where_details = '';
if($search_val != ''){
	$where_details = " and (tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' or tbl_patient.unique_id like '%$search_val%')";
}
$enc_key = $_POST['enc_key'];
$Api_key = 'requestingfor@patientCount';
$Api_value = 'JhonmariansBilling';
$key_compain = $Api_key.''.$Api_value;
$enc_key_val = md5($key_compain);
if($enc_key_val == $enc_key){
	if($where_details == ''){
		$select_patient_count = $obj->selectData("count(tbl_appointment.id) as appointment","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.appointment_status=2 and tbl_appointment.status=1 and tbl_appointment.bill_gen_status=0 and tbl_appointment.cross_branch_status=0");
		//echo $select_patient_count;exit();
	$select_patient_count_row = mysqli_fetch_array($select_patient_count);
	$response_arr[0]['status'] = 1;
	if($select_patient_count_row['appointment'] != null){
		$response_arr[0]['count'] = $select_patient_count_row['appointment'];
	}else{
		$response_arr[0]['count'] = 0;
	}
	}else{
		$response_arr[0]['data_status'] = 0;
		$response_arr[0]['count'] = 0;
		$select_patient_count_patient = $obj_common->selectData("id,logind_id,branch_id,unique_id,no","tbl_patient","where status!=0 $where_details");
		if(mysqli_num_rows($select_patient_count_patient)>0){
			$x1 = 0;
			while($select_todays_appointment_patient_row = mysqli_fetch_array($select_patient_count_patient)){
				$patient_unique_id = $select_todays_appointment_patient_row['unique_id'];
				$patient_id_arr = explode("/",$patient_unique_id);
				$patient_id = $select_todays_appointment_patient_row['no'];
				$branch_id = $select_todays_appointment_patient_row['branch_id'];
				$branch = $branch_id;
				$obj_branch = new query_branch();
				$select_patient_id = $obj_branch->selectData("id","tbl_patient","where unique_id='$patient_unique_id'");
				if(mysqli_num_rows($select_patient_id)>0){
				$select_patient_id_row = mysqli_fetch_array($select_patient_id);
				$patient_id = $select_patient_id_row['id'];
				$select_patient_count = $obj->selectData("count(tbl_appointment.id) as appointment","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.appointment_status=2 and tbl_appointment.status=1 and tbl_appointment.bill_gen_status=0 and tbl_appointment.cross_branch_status=0 and tbl_appointment.patient_id=$patient_id and tbl_appointment.branch_id=$branch_id");
				$select_patient_count_row = mysqli_fetch_array($select_patient_count);
				$response_arr[0]['status'] = 1;
					if($select_patient_count_row['appointment'] != null){
						//echo "count ".$select_patient_count_row['appointment'];
						$response_arr[0]['count'] += $select_patient_count_row['appointment'];
					}else{
						//$response_arr[0]['count'] = 0;
					}
				}
			}
		}
	}

}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong';
}
echo json_encode($response_arr);
?>