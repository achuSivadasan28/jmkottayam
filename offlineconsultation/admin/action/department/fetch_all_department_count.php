<?php
require_once '../../../_class/query.php';
$response_arr = array();
$obj=new query();
$select_all_count = $obj->selectData("count(id) as id","tbl_department","where status!=0");
$select_all_count_row = mysqli_fetch_array($select_all_count);
if($select_all_count_row['id'] != null){
	echo $select_all_count_row['id'];
}else{
	echo 0;
}
?>