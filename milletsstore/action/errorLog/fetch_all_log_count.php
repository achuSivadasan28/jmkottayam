<?php
require_once '../../../../class_error_log/query.php';
$response_arr = array();
$obj=new query();
$branch_name=$_POST['branch_name'];
$admin_type=$_POST['admin_type'];
$status_val_fil=$_POST['status_val_fil'];
$where_filter='';
if($status_val_fil!=''){
$where_filter="and error_status='$status_val_fil'";
}
$select_all_count = $obj->selectData("count(id) as id","tbl_error_log","where status=1 and branch_name='$branch_name' and admin_type='$admin_type' $where_filter");
$select_all_count_row = mysqli_fetch_array($select_all_count);
if($select_all_count_row['id'] != null){
	echo $select_all_count_row['id'];
}else{
	echo 0;
}
?>