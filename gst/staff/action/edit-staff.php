
<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$sname = $_POST['sname'];
$phone=$_POST['phone'];
    $info=[
    "staff_name" => $sname,
    "phone"=>$phone,
    "status"=>1
        ];
$updateData =$obj->updateData("tbl_staff",$info,"where id =$id");    
echo 1;
?>

