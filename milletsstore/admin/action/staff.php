<?php
include '../../_class/query.php';
$obj=new query();
$id=$_GET['id'];
$select=$obj->selectData("id,staff_name,phone,branch,role,email","tbl_staff","where id=$id");
if(mysqli_num_rows($select)>0){
    $x=0;
    while($data=mysqli_fetch_array($select)){
        $id=$data['id'];
        $status_name=$data['staff_name'];
        $phone=$data['phone'];
		$branch = $data['branch'];
		$role = $data['role'];

        $dataArray[$x]['id']=$id;
        $dataArray[$x]['sname']=$status_name; 
        $dataArray[$x]['phone']=$phone; 
		$dataArray[$x]['branch']=$branch; 
		$dataArray[$x]['role']=$role; 
		$dataArray[$x]['email']=$data['email']; 
        $x++;
    }
    echo json_encode($dataArray);
}
?>