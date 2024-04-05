<?php
require_once '../../../../class_error_log/query.php';
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$added_date=date('d-m-Y');
$added_time=date('h:i:s A');
$remark_val=$_POST['remark_val'];
$error_id_val=$_GET['id'];
$branch_name=$_POST['branch_name'];
$admin_type=$_POST['admin_type'];
$info=[
"action_perfomed"=>'Remark updated on',	
"remark_val"=>$remark_val,
"error_id_val"=>$error_id_val,
"branch_name"=>$branch_name,
"admin_type"=>$admin_type,	
"added_date"=>$added_date,
"added_time"=>$added_time,
"r_status"=>1,	
"status"=>1	
];
$insert=$obj->insertData("tbl_remark",$info);

$select=$obj->selectData("id","tbl_remark","where error_id_val =$error_id_val and status=1 ORDER BY id desc LIMIT 1 OFFSET 1");
if(mysqli_num_rows($select)>0){
	while($select_row=mysqli_fetch_array($select)){
	$follow_up_id=$select_row['id'];
	}
}
$info_update=[
"r_status"=>0
];
$update_followup=$obj->updateData("tbl_remark",$info_update,"where id=$follow_up_id");

$info_update_enq=[
"error_status"=>3
];
$update_error=$obj->updateData("tbl_error_log",$info_update_enq,"where id=$error_id_val");
echo 1;
?>