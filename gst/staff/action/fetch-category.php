<?php

include '../../_class/query.php';
$obj = new query();


$dataArray=[];

$selectData=$obj->selectData("id,category_name,status","tbl_category","where status !=0 ORDER BY id DESC");

if(mysqli_num_rows($selectData)>0)
$x=0;
while($data=mysqli_fetch_array($selectData))
{
    $id=$data['id'];
   $status=$data['category_name'];
    

    $dataArray[$x]['id']=$id;
    $dataArray[$x]['category']=$status;
    $x++;
}
echo json_encode($dataArray);
?>