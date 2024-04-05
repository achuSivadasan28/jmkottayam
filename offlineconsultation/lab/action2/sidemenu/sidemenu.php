<?php
function fetch_staff_name($staff_login_id,$obj){
	$staff_name = '';
$select_staff_name = $obj->selectData("staff_name","tbl_staff","where login_id=$staff_login_id");
if(mysqli_num_rows($select_staff_name)>0){
	while($select_staff_name_row = mysqli_fetch_array($select_staff_name)){
		$staff_name = $select_staff_name_row['staff_name'];
	}
}
	return $staff_name;
}
?>