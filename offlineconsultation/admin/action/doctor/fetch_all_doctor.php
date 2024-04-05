<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
if(isset($_SESSION['admin_login_id'])){
$login_id = $_SESSION['admin_login_id'];
$admin_role = $_SESSION['admin_role'];
$admin_unique_code = $_SESSION['admin_unique_code'];
if($admin_role == 'admin'){
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$where_search = '';
	$search_val = $_POST['search_val'];
	$limit_range = $_POST['limit_range'];
	$dep_id = $_POST['dep_id'];
	$branch_id_f = $_POST['branch_id_f'];
	if($search_val != ''){
		$where_search = " and (tbl_doctor.doctor_name like '%$search_val%' or tbl_doctor.phone_no like '%$search_val%' or tbl_doctor.email like '%$search_val%')";
	}
if($dep_id !=0){
	$where_dep = " and department_id=$dep_id";
}
if($branch_id_f !=0){
	$where_branch = " and branch_id=$branch_id_f";
}
	$select_all_doctor = $obj->selectData("tbl_doctor.id,doctor_name,phone_no,email,department_id,branch_id,tbl_login.role","tbl_doctor join tbl_login on tbl_doctor.login_id = tbl_login.id ","where tbl_doctor.status=1  $where_search $where_dep $where_branch ORDER BY id DESC limit $limit_range");
	if(mysqli_num_rows($select_all_doctor)>0){
		$x = 0;
		$response_arr[0]['data_status'] = 1;
		while($select_all_doctor_row = mysqli_fetch_array($select_all_doctor)){
			$response_arr[$x]['id'] = $select_all_doctor_row['id'];
			$response_arr[$x]['doctor_name'] = $select_all_doctor_row['doctor_name'];
			$response_arr[$x]['phone_no'] = $select_all_doctor_row['phone_no'];
			$response_arr[$x]['email'] = $select_all_doctor_row['email'];
			$response_arr[$x]['role'] = $select_all_doctor_row['role'];
			$department_id = $select_all_doctor_row['department_id'];
			$branch_id = $select_all_doctor_row['branch_id'];
			$department_name = '';
			$branch_name = '';
			$select_dep_name = $obj->selectData("department_name","tbl_department","where id=$department_id and status!=0");
			if(mysqli_num_rows($select_dep_name)>0){
				$select_dep_name_row = mysqli_fetch_array($select_dep_name);
				$department_name = $select_dep_name_row['department_name'];
			}
		   $select_branch_name = $obj->selectData("branch_name","tbl_branch","where id=$branch_id and status!=0");
			if(mysqli_num_rows($select_branch_name)>0){
				$select_branch_name_row = mysqli_fetch_array($select_branch_name);
				$branch_name = $select_branch_name_row['branch_name'];
			}
			$response_arr[$x]['department_name'] = $department_name;
			$response_arr[$x]['branch_name'] = $branch_name;
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
	}
	
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
	//tbl_branch
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);
?>