<?php
session_start();
include '../../_class/query.php';
$staff_id=$_SESSION['staffId'];

$obj=new query();
$select=$obj->selectData("id,staff_name,phone,email","tbl_staff","where staff_login = $staff_id");
//print_r($select);exit();
if(mysqli_num_rows($select)>0){
    $x=0;
    while($data=mysqli_fetch_array($select)){

        $dataArray[$x]['id']=$data['id'];
        $dataArray[$x]['admin_name']=$data['staff_name'];
        $dataArray[$x]['phone']=$data['phone'];
        $dataArray[$x]['email']=$data['email'];
        $x++;
    }
    echo json_encode($dataArray);
}
?>