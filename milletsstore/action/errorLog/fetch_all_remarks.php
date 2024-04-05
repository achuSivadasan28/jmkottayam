<?php
require_once '../../../../class_error_log/query.php';
$obj=new query();
$response_arr=[];
date_default_timezone_set('Asia/Kolkata');
$id=$_GET['id'];
$select=$obj->selectData("id,remark_val,error_id_val,added_date,added_time,action_perfomed,remark_done_by_admin","tbl_remark","where error_id_val=$id ORDER BY id DESC");
if(mysqli_num_rows($select)>0){
	$x=0;
	while($select_row=mysqli_fetch_array($select)){
	$response_arr[$x]['id']=$select_row['id'];
	$response_arr[$x]['remark_val']=$select_row['remark_val'];
	$response_arr[$x]['action_perfomed']=$select_row['action_perfomed'];	
	$response_arr[$x]['added_date']=$select_row['added_date'];
	$response_arr[$x]['added_time']=$select_row['added_time'];
	$response_arr[$x]['remark_done_by_admin']=$select_row['remark_done_by_admin'];	
		$x++;
	}
}
echo json_encode($response_arr);
?>