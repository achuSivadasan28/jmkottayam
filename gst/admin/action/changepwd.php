<?php
session_start();
$id=$_SESSION['adminLogId'];
include '../../_class/query.php';
header('Content-type:application/json;charset=utf-8');
$data = json_decode(file_get_contents('php://input'),true);
$obj = new query();
$oldPwd = $data['oldpassword'];
$oldEn = md5($oldPwd);
$conformPwd = $data['cpassword'];
$newPwd = md5($conformPwd);
$checkPwd = $obj->selectData("id,password","tbl_login","where password='$oldEn' and id=$id and status=1");
if(mysqli_num_rows($checkPwd)>0){
    $info = array(
        "password" => $newPwd
        );
    $d = $obj->updateData("tbl_login",$info,"where id=$id");
    echo 1;
}else{
    echo 0;
}
?>