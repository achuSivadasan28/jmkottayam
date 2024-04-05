<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$select=$obj->selectData("id,admin_name,phone","tbl_admin","where id=$id");
if(mysqli_num_rows($select)>0){
    $x=0;
    while($data=mysqli_fetch_array($select)){
        $id=$data['id'];
        $status_name=$data['admin_name'];
        $phone=$data['phone'];

        $dataArray[$x]['id']=$id;
        $dataArray[$x]['sname']=$status_name; 
        $dataArray[$x]['phone']=$phone; 
        $x++;
    }
    echo json_encode($dataArray);
}
?>