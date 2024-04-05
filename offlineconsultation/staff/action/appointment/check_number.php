<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
if(isset($_SESSION['staff_login_id'])){
$login_id = $_SESSION['staff_login_id'];
$staff_role = $_SESSION['staff_role'];
$staff_unique_code = $_SESSION['staff_unique_code'];
if($staff_role == 'staff'){
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
	//echo $check_security;exit();
if($check_security == 1){
	$number = $_POST['phn_number'];
	$check_phn = $obj->selectData("id,unique_id,name,phone,address,place,age,gender","tbl_patient","where phone='$number' and status!=0");
	if(mysqli_num_rows($check_phn)>0){
		$response_arr[0]['data_exist'] = 1;
		$x = 0;
		while($check_phn_row = mysqli_fetch_array($check_phn)){
			$response_arr[$x]['id'] = $check_phn_row['id'];
			$response_arr[$x]['unique_id'] = $check_phn_row['unique_id'];
			$response_arr[$x]['name'] = $check_phn_row['name'];
			/**$response_arr[0]['phone'] = $check_phn_row['phone'];
			$response_arr[0]['address'] = $check_phn_row['address'];
			$response_arr[0]['place'] = $check_phn_row['place'];
			$response_arr[0]['age'] = $check_phn_row['age'];
			$response_arr[0]['gender'] = $check_phn_row['gender'];**/
			$response_arr[$x]['branch_id'] = 0;
			$response_arr[$x]['branch_name'] = "Peruthalmana";
			$unique_code = $check_phn_row['unique_id'];
			$pname = $check_phn_row['name'];
			$where_cross .= " and unique_id!='$unique_code'";
			$x++;
		}
		$check_phn_common = $obj_common->selectData("id,unique_id,name,phone,address,place,age,gender,branch_id","tbl_patient","where phone='$number' and status!=0 $where_cross");
		if(mysqli_num_rows($check_phn_common)>0){
		$response_arr[0]['data_exist'] = 1;
		while($check_phn_common_row = mysqli_fetch_array($check_phn_common)){
			$response_arr[$x]['id'] = $check_phn_common_row['id'];
			$response_arr[$x]['unique_id'] = $check_phn_common_row['unique_id'];
			$branch_name = 'Thrissur';
			if($check_phn_common_row['branch_id'] == 5){
				$branch_name = "Pala";
			}else if($check_phn_common_row['branch_id'] == 4){
				$branch_name = "Edappally";
			}else if($check_phn_common_row['branch_id'] == 7){
				$branch_name = "Kannur";
			}else if($check_phn_common_row['branch_id'] == 8){
				$branch_name = "Thiruvalla";
			}else if($check_phn_common_row['branch_id'] == 9){
				$branch_name = "trivandrum";
			}else if($check_phn_common_row['branch_id'] == 10){
				$branch_name = "Bangalore";
			}else if($check_phn_common_row['branch_id'] == 11){
				$branch_name = "kottakkal";
			}else if($check_phn_common_row['branch_id'] == 12){
				$branch_name = "kottarakkara";
			}else if($check_phn_common_row['branch_id'] == 13){
				$branch_name = "Thodupuzha";
			}else if($check_phn_common_row['branch_id'] == 14){
				$branch_name = "Calicut";
			}else if($check_phn_common_row['branch_id'] == 15){
				$branch_name = "Perumbavoor";
			}else if($check_phn_common_row['branch_id'] == 16){
				$branch_name = "Peruthalmana";
			}else if($check_phn_common_row['branch_id'] == 17){
				$branch_name = "Kasargod";
			}else if($check_phn_common_row['branch_id'] == 18){
				$branch_name = "Kattanam";
			}else if($check_phn_common_row['branch_id'] == 19){
				$branch_name = "Pune";
			}else if($check_phn_common_row['branch_id'] == 20){
				$branch_name = "Wayanad";
			}else if($check_phn_common_row['branch_id'] == 21){
				$branch_name = "Thrissur";
			}else if($check_phn_common_row['branch_id'] == 23){
				$branch_name = "KOTTAYOM";
			}
			$response_arr[$x]['name'] = $check_phn_common_row['name'];
			$response_arr[$x]['branch_id'] = $check_phn_common_row['branch_id'];
			$response_arr[$x]['branch_name'] = $branch_name;
			$x++;
		}
	}
	}else{
		$check_phn_common = $obj_common->selectData("id,unique_id,name,phone,address,place,age,gender,branch_id","tbl_patient","where phone='$number' and status!=0");
		if(mysqli_num_rows($check_phn_common)>0){
		$response_arr[0]['data_exist'] = 1;
		$x = 0;
		while($check_phn_common_row = mysqli_fetch_array($check_phn_common)){
			$response_arr[$x]['id'] = $check_phn_common_row['id'];
			$response_arr[$x]['unique_id'] = $check_phn_common_row['unique_id'];
			$branch_name = 'Thrissur';
			if($check_phn_common_row['branch_id'] == 5){
				$branch_name = "Pala";
			}else if($check_phn_common_row['branch_id'] == 4){
				$branch_name = "Edappally";
			}else if($check_phn_common_row['branch_id'] == 7){
				$branch_name = "Kannur";
			}else if($check_phn_common_row['branch_id'] == 8){
				$branch_name = "Thiruvalla";
			}else if($check_phn_common_row['branch_id'] == 9){
				$branch_name = "trivandrum";
			}else if($check_phn_common_row['branch_id'] == 10){
				$branch_name = "Bangalore";
			}else if($check_phn_common_row['branch_id'] == 11){
				$branch_name = "kottakkal";
			}else if($check_phn_common_row['branch_id'] == 12){
				$branch_name = "kottarakkara";
			}else if($check_phn_common_row['branch_id'] == 13){
				$branch_name = "Thodupuzha";
			}else if($check_phn_common_row['branch_id'] == 14){
				$branch_name = "Calicut";
			}else if($check_phn_common_row['branch_id'] == 15){
				$branch_name = "Perumbavoor";
			}else if($check_phn_common_row['branch_id'] == 16){
				$branch_name = "Peruthalmana";
			}else if($check_phn_common_row['branch_id'] == 17){
				$branch_name = "Kasargod";
			}else if($check_phn_common_row['branch_id'] == 18){
				$branch_name = "Kattanam";
			}else if($check_phn_common_row['branch_id'] == 19){
				$branch_name = "Pune";
			}else if($check_phn_common_row['branch_id'] == 20){
				$branch_name = "Wayanad";
			}else if($check_phn_common_row['branch_id'] == 21){
				$branch_name = "Thrissur";
			}else if($check_phn_common_row['branch_id'] == 23){
				$branch_name = "KOTTAYOM";
			}
			$response_arr[$x]['name'] = $check_phn_common_row['name'];
			$response_arr[$x]['branch_id'] = $check_phn_common_row['branch_id'];
			$response_arr[$x]['branch_name'] = $branch_name;
			$x++;
		}
	}else{
		$response_arr[0]['data_exist'] = 0;
	}
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