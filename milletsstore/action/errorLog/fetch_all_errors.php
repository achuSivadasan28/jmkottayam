<?php
require_once '../../../../class_error_log/query.php';
$response_arr = array();
$obj=new query();
$limit_range=$_POST['limit_range'];
$branch_name=$_POST['branch_name'];
$admin_type=$_POST['admin_type'];
$status_val_fil=$_POST['status_val_fil'];
$where_filter='';
if($status_val_fil!=''){
$where_filter="and error_status='$status_val_fil'";
}
	$select_all_error = $obj->selectData("id,issue_info,added_date,error_status,approve_status","tbl_error_log","where status=1 and branch_name='$branch_name' and admin_type='$admin_type' $where_filter ORDER BY id DESC limit $limit_range");
	if(mysqli_num_rows($select_all_error)>0){
		$x = 0;
		while($select_all_error_row = mysqli_fetch_array($select_all_error)){
			$response_arr[$x]['id'] = $select_all_error_row['id'];
			$response_arr[$x]['issue_info'] = $select_all_error_row['issue_info'];
			$response_arr[$x]['added_date'] = $select_all_error_row['added_date'];
			$response_arr[$x]['error_status'] = $select_all_error_row['error_status'];
			$response_arr[$x]['approve_status'] = $select_all_error_row['approve_status'];
			$error_status= $select_all_error_row['error_status'];
			$status_val=$obj->selectData("id,status_val","tbl_status","where status!=0 and id=$error_status");
				if(mysqli_num_rows($status_val)>0){
					while($status_val_row=mysqli_fetch_array($status_val)){
					$response_arr[$x]['status_val'] = $status_val_row['status_val'];
					}
				}
			$x++;
		}
	}
echo json_encode($response_arr);
?>