<?php
function fetch_user_name($admin_login_id,$obj){
	$staff_name = '';
$select_staff_name = $obj->selectData("user_name","tbl_admin_reg","where login_id=$admin_login_id");
if(mysqli_num_rows($select_staff_name)>0){
	while($select_staff_name_row = mysqli_fetch_array($select_staff_name)){
		$staff_name = $select_staff_name_row['user_name'];
	}
}
	return $staff_name;
}
?>