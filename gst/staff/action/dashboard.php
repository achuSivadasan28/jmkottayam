<?php
session_start();
$login_id =$_SESSION['staff']; 
include '../../_class/query.php';
$obj = new Query();

$dataArray=[];

$selectData=$obj->selectData("id,staff_name,status","tbl_staff","where  staff_login=$login_id");

if(mysqli_num_rows($selectData)>0){
$x=0;
while($data=mysqli_fetch_array($selectData))
{
    $id=$data['id'];
   $staff_name=$data['staff_name'];
   $dataArray[$x]['id']=$id;
    $dataArray[$x]['sname']=$staff_name;
    $selectData1=$obj->selectData("id,staff_log_id,role","tbl_login","where  id=$login_id");

if(mysqli_num_rows($selectData1)>0)
$x=0;
while($data=mysqli_fetch_array($selectData1))
{
    //$id=$data['id'];
   $staffrole=$data['role'];
  // $dataArray[$x]['id']=$id;
    $dataArray[$x]['srole']=$staffrole;
    
}
$x++;
    
}
}
echo json_encode($dataArray);
?>



