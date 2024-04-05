
<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$category = $_POST['category'];
    $info=[
    "category_name" => $category,
    "status"=>1
        ];
$updateData =$obj->updateData("tbl_category",$info,"where id =$id");    
echo 1;
?>

