
<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$sname = $_POST['sname'];
$phone=$_POST['phone'];
$branch=$_POST['branch'];
$role_data=$_POST['role_data'];
    $info=[
    "staff_name" => $sname,
    "phone"=>$phone,
	"branch"=>$branch,
    "status"=>1,
	"role" => $role_data
        ];
$updateData =$obj->updateData("tbl_staff",$info,"where id =$id");    
echo 1;
?>

