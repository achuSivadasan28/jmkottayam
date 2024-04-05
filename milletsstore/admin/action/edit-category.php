
<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$category = $_POST['category'];
$address = $_POST['address'];
$gstNum = $_POST['gstNum'];
$phnNum = $_POST['phnNum'];
    $info=[
    "category_name" => $category,
	"address" => $address,
	"gstNum" => $gstNum,
	"phnNum" => $phnNum,
    "status"=>1
        ];
$updateData =$obj->updateData("tbl_category",$info,"where id =$id");    
echo 1;
?>

