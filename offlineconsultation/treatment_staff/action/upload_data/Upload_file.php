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
$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($select_patient_id)){
	$select_patient_id_row = mysqli_fetch_array($select_patient_id);
	$patient_id = $select_patient_id_row['patient_id'];
}
$info_data = array(
	"appointment_id" => $appointment_id,
	"patient_id" => $patient_id,
	"test_name" => $file_name,
	"lab_report_file" => $file,
	"lab_report_status" => 1,
	"added_date" => $date,
	"added_time" => $time,
	"status" => 1
);
$obj->insertData("tbl_add_lab_data",$info_data);
//tbl_lab_report
$count = count($_FILES['files']['name']);
$upload_dir = "../../../lab/assets/fileupload/";
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
    move_uploaded_file($x,'../../assets/fileupload/'.$y);
}
?>