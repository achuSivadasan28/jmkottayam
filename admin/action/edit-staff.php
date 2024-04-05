
<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$sname = $_POST['sname'];
$phone=$_POST['phone'];
$branch=$_POST['branch'];
$role_data=$_POST['role_data'];
$email=$_POST['email'];
$check_email = $obj->selectData("id","tbl_staff","where email='$email' and status!=0 and id!=$id");
if(mysqli_num_rows($check_email)>0){
echo 0;
}else{
$info=[
    "staff_name" => $sname,
    "phone"=>$phone,
	"branch"=>$branch,
    "status"=>1,
	"email" => $email,
	"role" => $role_data
        ];
$updateData =$obj->updateData("tbl_staff",$info,"where id =$id");  
$select_login_id = $obj->selectData("staff_login","tbl_staff","where id=$id and status!=0");
if(mysqli_num_rows($select_login_id)>0){
	$select_login_id_row = mysqli_fetch_array($select_login_id);
	$staff_log_id = $select_login_id_row['staff_login'];
	$info_login = array(
		"username" => $email
	);
$obj->updateData("tbl_login",$info_login,"where id=$staff_log_id");

	//tbl_login
echo 1;
}
}
?>

