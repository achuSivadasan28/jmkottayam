<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
include_once '../../../_class/query.php';
$obj = new query();
$file_name = $_POST['file_name'];
$url_id = $_POST['url_id'];
$appointment_id = $_POST['appointment_id'];
$real_branch_id = 0;

$select_branch_id = $obj->selectData("real_branch_id,branch_id", "tbl_appointment", "where id=$appointment_id");
if (mysqli_num_rows($select_branch_id) > 0) {
    $select_branch_id_row = mysqli_fetch_array($select_branch_id);
    $real_branch_id = $select_branch_id_row['real_branch_id'];
    $branch_id = $select_branch_id_row['branch_id'];
}

$upload_dir = "../../assets/fileupload"; // Define the upload directory

if ($real_branch_id == $branch_id) {
    $files = $_FILES['files']; // Note: $_FILES should be used instead of $_FILES['files']['name']
	$file_report = $_FILES['files']['name'];
    foreach ($file_report as $x => $file) {
        // Get extension
		echo $file;
        $ext = pathinfo($_FILES['files']['name'][$x], PATHINFO_EXTENSION);
        // Valid image extensions
        $valid_ext = array("jpg", "jpeg", "png");
        if (in_array($ext, $valid_ext)) {
            $path = $upload_dir . '/' . $files['name'][$x]; // Include directory
            compressFile($_FILES['files']['tmp_name'][$x], $path, 55);
            echo 1;
        } else {
            insertnormal($_FILES['files']['tmp_name'][$x], $_FILES['files']['name'][$x]);
            echo 1;
        }
        $info_data = array(
            "lab_data_id" => $url_id,
            "file" => $file,
           
            "uploaded_branch" => $real_branch_id,
            "status" => 1,
        );
        $obj->insertData("tbl_lab_reports", $info_data);
		
    }
} else {
    $branch = $branch_id;
    require_once '../../../_class_branch/query_branch.php';
    $obj_branch = new query_branch();
    $files = $_FILES['files']; // Note: $_FILES should be used instead of $_FILES['files']['name']
	$file_report = $_FILES['files']['name'];
    foreach ($file_report as $x => $file) {
        // Get extension
		echo $file;
        $ext = pathinfo($_FILES['files']['name'][$x], PATHINFO_EXTENSION);
        // Valid image extensions
        $valid_ext = array("jpg", "jpeg", "png");
        if (in_array($ext, $valid_ext)) {
            $path = $upload_dir . '/' . $files['name'][$x]; // Include directory
            compressFile($_FILES['files']['tmp_name'][$x], $path, 55);
            echo 1;
        } else {
            insertnormal($_FILES['files']['tmp_name'][$x], $_FILES['files']['name'][$x]);
            echo 1;
        }
        $info_data = array(
            "lab_data_id" => $url_id,
            "file" => $file,
           
            "uploaded_branch" => $real_branch_id,
            "status" => 1,
        );
        $obj_branch->insertData("tbl_lab_reports", $info_data);
    }
}

// tbl_lab_report
$count = count($_FILES['files']['name']);

function compressFile($source, $destination, $quality)
{
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);
    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);
    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);
}

function insertnormal($x, $y)
{
    move_uploaded_file($x, '../../assets/fileupload/' . $y);
}
?>
