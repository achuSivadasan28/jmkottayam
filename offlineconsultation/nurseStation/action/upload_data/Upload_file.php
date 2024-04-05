<?php
session_start();
date_default_timezone_set( 'Asia/Kolkata' );
$date = date( 'd-m-Y' );
$time = date( 'h:i:s A' );
include_once '../../../_class/query.php';
$obj = new query();
$file_name = $_POST['file_name'];
$file_data_name = $_POST['file_data_name'];
$file_remark = $_POST['file_remark'];
$url_details = $_POST['url_details'];
$info_data = array(
	"file" => $file_name,
	"file_name" => $file_data_name,
	"file_remark" => $file_remark,
	"patient_id" => $url_details,
	"date" => $date,
	"time" => $time,
	"status" => 1
);
$obj->insertData("tbl_lab_report",$info_data);
//tbl_lab_report
$count = count($_FILES['files']['name']);
$upload_dir = "../../assets/fileupload/";
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
    move_uploaded_file($x,'../../assets/fileupload/'.$y);
}
?>