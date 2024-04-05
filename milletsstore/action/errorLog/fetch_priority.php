<?php
require_once '../../../../class_error_log/query.php';
$obj=new query();
$response_arr=[];
$select=$obj->selectData("id,priority_data","tbl_priority","where status!=0 ORDER BY id DESC");
if(mysqli_num_rows($select)>0){
	    $x=0;
	while($select_row=mysqli_fetch_array($select)){
		$response_arr[$x]['priority_data']=$select_row['priority_data'];
		$x++;
	}
}
echo json_encode($response_arr);
?>