<?php

include '../../_class/query.php';
$obj = new query();

$id=$_POST['id'];
$Quantity=$_POST['Quantity'];
$selectData=$obj->selectData("quantity","tbl_medicine_details","where status!=0 and id=$id");
//echo $selectData; exit();
if(mysqli_num_rows($selectData)>0){
while($data=mysqli_fetch_array($selectData))
{
   $checkq=$data['quantity'];
   //echo $checkq;exit();
   if($Quantity>$checkq){
echo 0;
   }
else{
    echo 1;
}
}
}

?>