<?php
session_start();
$adminLogId = $_SESSION['adminLogId'];

include '../../_class/query.php';
$obj = new query();

$dataArray=[];

$selectData=$obj->selectData("id,admin_name,status","tbl_admin","where  id=$adminLogId");

if(mysqli_num_rows($selectData)>0){
$x=0;
while($data=mysqli_fetch_array($selectData))
{
    $id=$data['id'];
   $admin_name=$data['admin_name'];
  
   $dataArray[$x]['id']=$id;
    $dataArray[$x]['user']=$admin_name;


    $selectData1=$obj->selectData("id,admin_log_id,role","tbl_login","where  admin_log_id=$adminLogId");

if(mysqli_num_rows($selectData1)>0)
{
while($data=mysqli_fetch_array($selectData1))
{
   $adminrole=$data['role'];
    $dataArray[$x]['srole']=$adminrole;
	$dataArray[$x]['user']="Admin";
    
}
}
$x++;
    
}
}
echo json_encode($dataArray);

?>