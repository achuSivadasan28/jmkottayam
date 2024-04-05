<?php
session_start();
date_default_timezone_set( 'Asia/Kolkata' );
$date = date( 'd-m-Y' );
$time = date( 'h:i:s A' );
include_once '../../../_class/query.php';
$obj = new query();
$file_name = $_POST['file_name'];
$appointment_id = $_POST['appointment_id'];
$file = $_POST['file'];
$patient_id = 0;
$real_branch_id = 0;
$branch_id = 0;
$check_branch = $obj->selectData("real_branch_id,branch_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($check_branch)>0){
	$check_branch_row = mysqli_fetch_array($check_branch);
	$real_branch_id = $check_branch_row['real_branch_id'];
	$branch_id = $check_branch_row['branch_id'];
}
if($real_branch_id == $branch_id){
$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($select_patient_id)){
	$select_patient_id_row = mysqli_fetch_array($select_patient_id);
	$patient_id = $select_patient_id_row['patient_id'];
}
$info_data = array(
	"appointment_id" => $appointment_id,
	"patient_id" => $patient_id,
	"treatment_name" => $file_name,
	"file" => $file,
	"added_date" => $date,
	"added_time" => $time,
	"status" => 1,
	"file_branch" => $real_branch_id,
);
$obj->insertData("tbl_assigned_treatment",$info_data);
}else{
	$branch = $branch_id;
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$select_appointment_data = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$appointment_id");
	if(mysqli_num_rows($select_appointment_data)>0){
		$select_appointment_data_row = mysqli_fetch_array($select_appointment_data);
		$appointment_id = $select_appointment_data_row['id'];
	}
	$select_patient_id = $obj_branch->selectData("patient_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($select_patient_id)){
	$select_patient_id_row = mysqli_fetch_array($select_patient_id);
	$patient_id = $select_patient_id_row['patient_id'];
}
$info_data = array(
	"appointment_id" => $appointment_id,
	"patient_id" => $patient_id,
	"treatment_name" => $file_name,
	"file" => $file,
	"added_date" => $date,
	"added_time" => $time,
	"status" => 1,
	"file_branch" => $real_branch_id,
);
$obj_branch->insertData("tbl_assigned_treatment",$info_data);
}
//tbl_lab_report
$count = count($_FILES['files']['name']);
$upload_dir = "../../assets/treatmentfileupload/";
for($x=0; $x<$count;$x++)
{
    $filename=$_FILES['files']['name'][$x];

    //get extenshion
    $ext = pathinfo($filename,PATHINFO_EXTENSION);

    //vald image extenshion
	
    $valid_ext = array("jpg","jpeg","png");
    if(in_array($ext,$valid_ext))
    {
        // echo "haii";
        $path=$upload_dir.$filename;
        compressFile($_FILES['files']['tmp_name'][$x],$path,55);
        // echo $data;
        echo $patient_id;
    }else{
	insertnormal($_FILES['files']['tmp_name'][$x],$_FILES['files']['name'][$x]);
		echo $patient_id;
	}
}
function compressFile($source,$destination,$quaity)
{
    $info = getimagesize($source);
    if($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    elseif($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image , $destination , $quaity);
    //echo $image;
}
function insertnormal($x,$y)
{
    move_uploaded_file($x,'../../assets/treatmentfileupload/'.$y);
}
?>