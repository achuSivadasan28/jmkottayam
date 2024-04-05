<?php
require_once '../../_class/query.php';
$obj=new query();
$response_arr = array();
$select_all_lab = $obj->selectData("test_name,mrp,special_rate","tbl_lab","where status!=0");
if(mysqli_num_rows($select_all_lab)>0){
	$x = 0;
	while($select_all_lab_row = mysqli_fetch_array($select_all_lab)){
		$response_arr[$x]['test_name'] = $select_all_lab_row['test_name'];
		$response_arr[$x]['mrp'] = $select_all_lab_row['mrp'];
		$response_arr[$x]['special_rate'] = $select_all_lab_row['special_rate'];
		$x++;
	}
}
echo json_encode($response_arr);
?>
