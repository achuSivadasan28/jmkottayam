<?php

include '../../_class/query.php';
$obj = new query();

$id=$_POST['id'];
$Quantity=$_POST['Quantity'];
$selectData=$obj->selectData("id,product_name,quantity,status","tbl_product","where status!=0 and id=$id");
// echo $selectData; exit();
if(mysqli_num_rows($selectData)>0){
while($data=mysqli_fetch_array($selectData))
{
   $checkq=$data['quantity'];
   //echo $checkq;exit();
   if($Quantity>$checkq){
echo 1;
   }
else{
    echo 0;
}
}
}

?>