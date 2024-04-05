<?php

include '../../_class/query.php';
$obj = new query();

$id=$_POST['id'];
$discount=$_POST['discount'];
$selectData=$obj->selectData("id,product_name,quantity,discount,status","tbl_product","where status!=0 and id=$id");
if(mysqli_num_rows($selectData)>0){
while($data=mysqli_fetch_array($selectData))
{
   $checkq=$data['discount'];
   if($discount>$checkq){
echo 1;
   }
else{
    echo 0;
}
}
}

?>