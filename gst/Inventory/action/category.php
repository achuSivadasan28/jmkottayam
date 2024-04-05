<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$select=$obj->selectData("id,category_name","tbl_category","where id=$id");
if(mysqli_num_rows($select)>0){
    $x=0;
    while($data=mysqli_fetch_array($select)){
        $id=$data['id'];
        $category_name=$data['category_name'];

        $dataArray[$x]['id']=$id;
        $dataArray[$x]['category']=$category_name; 
        $x++;
    }
    echo json_encode($dataArray);
}
?>