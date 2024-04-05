<?php

include '../../_class/query.php';
$obj = new Query();


$dataArray=[];
$id=$_GET['id'];

$selectData=$obj->selectData("id,customer_name,phone,place,status","tbl_customer","where status !=0 and id='$id'");

if(mysqli_num_rows($selectData)>0)
$x=0;
while($data=mysqli_fetch_array($selectData))
{
    $id=$data['id'];
 $customer_name =$data['customer_name'];
	 $phone =$data['phone'];
	 $place =$data['place'];

    $dataArray[$x]['id']=$id;
    $dataArray[$x]['customer_name']=$customer_name;
	  $dataArray[$x]['phone']=$phone;
	$dataArray[$x]['place']=$place;
    $x++;
}
echo json_encode($dataArray);





?>