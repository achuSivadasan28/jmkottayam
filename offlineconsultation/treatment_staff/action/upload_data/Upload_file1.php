<?php
session_start();
date_default_timezone_set( 'Asia/Kolkata' );
$date = date( 'd-m-Y' );
$time = date( 'h:i:s A' );
include_once '../../../_class/query.php';
$obj = new query();
$file_name = $_POST['file_name'];
$url_id = $_POST['url_id'];
$branch = $_POST['branch'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$select_real_b = $obj_branch->selectData("appointment_id","tbl_assigned_treatment","where id=$url_id");
$select_real_b_row = mysqli_fetch_array($select_real_b);
$appointment_id = $select_real_b_row['appointment_id'];
$select_appointment_data = $obj_branch->selectData("branch_id","tbl_appointment","where id=$appointment_id");
$select_appointment_data_row = mysqli_fetch_array($select_appointment_data);
$real_branch = $select_appointment_data_row['branch_id'];
$branch = $_POST['branch'];
$info_data = array(
	"file" => $file_name,
	"file_branch" => $real_branch
);
$obj_branch->updateData("tbl_assigned_treatment",$info_data,"where id=$url_id");
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
        echo 1;
    }else{
	insertnormal($_FILES['files']['tmp_name'][$x],$_FILES['files']['name'][$x]);
		echo 1;
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