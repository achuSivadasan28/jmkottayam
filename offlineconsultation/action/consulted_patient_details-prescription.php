<?php
session_start();
require_once '../_class/query.php';
$response_arr = array();
$obj=new query();
require_once '../_class_common/query_common.php';
require_once '../_class_branch/query_branch.php';
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$limit =$_POST['limit_range'];

$days=date('d-m-Y');
$search_val = $_POST['search_val'];
$where_details = '';
if($search_val != ''){
	$where_details = " and (tbl_patient.name like '%$search_val%' or tbl_patient.phone like '%$search_val%' or tbl_patient.unique_id like '%$search_val%')";
}
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$enc_key1 = $_POST['enc_key1'];
$where_search_date = '';
if($start_date != '' and $end_date !=''){

	$start_date1 = date_create($start_date);
	$end_date1 = date_create($end_date);
	$start_date2 = $start_date1;
	$diff=date_diff($start_date1,$end_date1);
	$diff1 =  $diff->format("%a");
	//$loop_date = date_create($start_date);
	$y1 = 0;
	$loop_date = date_format($start_date1,'Y-m-d');
	for($x1=0;$x1<=$diff1;$x1++){
		if($where_search_date == ""){
			$where_search_date .= " and (tbl_appointment.appointment_date like '%$loop_date%'"; 
		}else{
			$where_search_date .= " or tbl_appointment.appointment_date like '%$loop_date%'";
		}
		date_add($start_date2,date_interval_create_from_date_string("1 days"));
		$loop_date = date_format($start_date2,"Y-m-d");
		$start_date2 = date_create($loop_date);
	}
	
	$where_search_date .= ")";
}else if($start_date !='' or $end_date!= ''){
	if($where_search ==''){
		$where_search_date = " ";
	}
	if($start_date != ''){
		$start_date1 = date_create($start_date);
		$date1 = date_format($start_date1,"Y-m-d");
		$where_search_date .= " and tbl_appointment.appointment_date like '%$date1%'";
	}else if($end_date != ''){
		$end_date1 = date_create($end_date);
		$date2 = date_format($end_date1,"Y-m-d");
		$where_search_date .= " and tbl_appointment.appointment_date like '%$date2%'";
	}
}

$enc_key = $_POST['enc_key1'];
$Api_key = 'requestingfor@patientdetails';
$Api_value = 'JhonmariansBilling';
$key_compain = $Api_key.''.$Api_value;
$enc_key_val = md5($key_compain);
if($enc_key_val == $enc_key){
	$response_arr[0]['status'] = 1;
	if($where_details == ''){
	$select_patient_count = $obj->selectData("tbl_appointment.id,tbl_appointment.real_branch_id,tbl_appointment.branch_id,tbl_appointment.patient_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_doctor.doctor_name","tbl_appointment inner join tbl_doctor on tbl_appointment.consulted_by = tbl_doctor.login_id","where tbl_appointment.appointment_status=2 and tbl_appointment.status=1 and tbl_appointment.cross_branch_status=0 $where_search_date order by id desc limit $limit");
	if(mysqli_num_rows($select_patient_count)>0){
	$x = 0;
	while($select_patient_count_row = mysqli_fetch_array($select_patient_count)){
		$branch = $select_patient_count_row['branch_id'];
		$patient_id = $select_patient_count_row['patient_id'];
		$obj_branch = new query_branch();
		$select_patient_data = $obj_branch->selectData("name,phone,place","tbl_patient","where id=$patient_id");
		if(mysqli_num_rows($select_patient_data)>0){
		$select_patient_data_row = mysqli_fetch_array($select_patient_data);
		$response_arr[$x]['appointment_id'] = $select_patient_count_row['id'];
		$newDate = date("d-m-Y", strtotime($select_patient_count_row['appointment_date']));  
		//$newDate = date(strtotime($select_patient_count_row['appointment_date']),'d-m-Y')
		$response_arr[$x]['appointment_date'] = $newDate;
		$response_arr[$x]['name'] = $select_patient_data_row['name'];
		$response_arr[$x]['phone'] = $select_patient_data_row['phone'];
		$response_arr[$x]['doctor_name'] = $select_patient_count_row['doctor_name'];
		$response_arr[$x]['place'] = $select_patient_data_row['place'];
		$response_arr[$x]['branch'] = $branch;
		$x++;
		}
	}
	$response_arr[0]['data_exist'] = 1;
}else{
	$response_arr[0]['data_exist'] = 0;
}
	}else{
//$response_arr[0]['data_status'] = 0;
$select_patient_count_patient = $obj_common->selectData("id,logind_id,branch_id,unique_id","tbl_patient","where status!=0 $where_details");
		//echo $select_patient_count_patient;exit();
		//echo $select_todays_appointment_patient;exit();
		if(mysqli_num_rows($select_patient_count_patient)>0){
			$x1 = 0;
			while($select_patient_count_patient_row = mysqli_fetch_array($select_patient_count_patient)){
				$patient_unique_id = $select_patient_count_patient_row['unique_id'];
				$patient_id_arr = explode("/",$patient_unique_id);
				$patient_id = $patient_id_arr[3];
				$branch_id = $select_patient_count_patient_row['branch_id'];
				$branch = $branch_id;
				$obj_branch = new query_branch();
				$select_patient_id = $obj->selectData("id","tbl_patient","where unique_id='$patient_unique_id'");
				if(mysqli_num_rows($select_patient_id)>0){
					$select_patient_id_row = mysqli_fetch_array($select_patient_id);
					$patient_id = $select_patient_id_row['id'];
				$select_patient_count = $obj->selectData("tbl_appointment.id,tbl_appointment.real_branch_id,tbl_appointment.branch_id,tbl_appointment.patient_id,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_doctor.doctor_name","tbl_appointment inner join tbl_doctor on tbl_appointment.consulted_by = tbl_doctor.login_id","where tbl_appointment.appointment_status=2 and tbl_appointment.status=1 and tbl_appointment.cross_branch_status=0 and tbl_appointment.patient_id=$patient_id $where_search_date order by id desc limit $limit");
	if(mysqli_num_rows($select_patient_count)>0){
	$x = 0;
	while($select_patient_count_row = mysqli_fetch_array($select_patient_count)){
		$branch = $select_patient_count_row['branch_id'];
		$patient_id = $select_patient_count_row['patient_id'];
		
		$obj_branch = new query_branch();
		$select_patient_data = $obj_branch->selectData("name,phone,place","tbl_patient","where id=$patient_id");
		if(mysqli_num_rows($select_patient_data)>0){
		$select_patient_data_row = mysqli_fetch_array($select_patient_data);
		$response_arr[$x]['appointment_id'] = $select_patient_count_row['id'];
		$newDate = date("d-m-Y", strtotime($select_patient_count_row['appointment_date']));  
		//$newDate = date(strtotime($select_patient_count_row['appointment_date']),'d-m-Y')
		$response_arr[$x]['appointment_date'] = $newDate;
		$response_arr[$x]['name'] = $select_patient_data_row['name'];
		$response_arr[$x]['phone'] = $select_patient_data_row['phone'];
		$response_arr[$x]['doctor_name'] = $select_patient_count_row['doctor_name'];
		$response_arr[$x]['place'] = $select_patient_data_row['place'];
		$response_arr[$x]['branch'] = $branch;
		$x++;
		}
	}
	$response_arr[0]['data_exist'] = 1;
}else{
	$response_arr[0]['data_exist'] = 0;
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