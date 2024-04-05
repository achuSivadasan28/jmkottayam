<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$date = date('d-m-Y');
$time = date('h:i:s A');
include_once '../../../_class/query.php';
$obj = new query();
$file_name = $_POST['file_name'];

$appointment_id = $_POST['appointment_id'];
$file = $_FILES['files']['name'];

$branch = $_POST['branch_id'];


$patient_id = 0;
$real_branch_id = 0;
$select_patient_id = $obj->selectData("patient_id,real_branch_id,branch_id", "tbl_appointment", "where id=$appointment_id");
if (mysqli_num_rows($select_patient_id)) {
	$select_patient_id_row = mysqli_fetch_array($select_patient_id);
	$patient_id = $select_patient_id_row['patient_id'];
	$real_branch_id = $select_patient_id_row['real_branch_id'];
	$branch_id = $select_patient_id_row['branch_id'];
	$branch = $branch_id;
	require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
	if ($real_branch_id == $branch_id) {
		$info_data = array(
			"appointment_id" => $appointment_id,
			"patient_id" => $patient_id,
			"test_name" => $file_name,
			"added_date" => $date,
			"added_time" => $time,
			"status" => 1
		);
		$obj_branch->insertData("tbl_add_lab_data", $info_data);
		$select_last_added_lab = $obj->selectData("id", "tbl_add_lab_data", "where appointment_id = $appointment_id order by id desc limit 1");
		if (mysqli_num_rows($select_last_added_lab)) {
			$select_last_added_lab_row = mysqli_fetch_assoc($select_last_added_lab);
			$lab_id = $select_last_added_lab_row['id'];
		}
		
		$upload_dir = "../../../lab/assets/fileupload/";
		foreach ($file as $y => $fileName) {
			echo $fileName;
			// Get extension
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
			// Valid image extensions
			$valid_ext = array("jpg", "jpeg", "png");
			$path = $upload_dir . $fileName;
			if (in_array($ext, $valid_ext)) {
				// Compress and save image
				if (compressFile($_FILES['files']['tmp_name'][$y], $path, 55)) {
					$insert_data = array(
						'lab_data_id' => $lab_id,
						'file' => $fileName,
						"uploaded_branch" => $real_branch_id,
						"upload_from" => 0,
						"status"=>1,
					);
					$obj_branch->insertData("tbl_lab_reports", $insert_data);
					
				}
				echo $patient_id;
			} else {
				insertnormal($_FILES['files']['tmp_name'][$y], $fileName, $upload_dir);
				$insert_data = array(
					'lab_data_id' => $lab_id,
					'file' => $fileName,
					"uploaded_branch" => $real_branch_id,
					"upload_from" => 0,
					"status"=>1,
				);
				$obj_branch->insertData("tbl_lab_reports", $insert_data);
				
				echo $patient_id;
			}
		}
		// tbl_lab_report
		$count = count($_FILES['files']['name']);
		$main_folder_path = '';
		if ($branch == 4) {
			$main_folder_path = "https://jmwell.in/offlineconsultation/";
		} elseif ($branch == 5) {
			$main_folder_path = "https://pala.jmwell.in/offlineconsultation/";
		} elseif ($branch == 7) {
			$main_folder_path = "https://kannur.jmwell.in/offlineconsultation/";
		} elseif ($branch == 8) {
			$main_folder_path = "https://trvl.jmwell.in/offlineconsultation/";
		} elseif ($branch == 9) {
			$main_folder_path = "https://tvm.jmwell.in/offlineconsultation/";
		}
	} else {
		$select_patient_id_data = $obj_branch->selectData("id", "tbl_appointment", "where cross_appointment_id=$appointment_id and cross_branch_status=1");
		if (mysqli_num_rows($select_patient_id_data) > 0) {
			$select_patient_id_data_row = mysqli_fetch_array($select_patient_id_data);
			$appointment_id = $select_patient_id_data_row['id'];
		}
		$info_data = array(
			"appointment_id" => $appointment_id,
			"patient_id" => $patient_id,
			"test_name" => $file_name,
			"added_date" => $date,
			"added_time" => $time,
			"status" => 1
		);
		$obj_branch->insertData("tbl_add_lab_data", $info_data);
		//print_r($obj_branch);exit();
		$select_last_added_lab = $obj_branch->selectData("id", "tbl_add_lab_data", "where appointment_id = $appointment_id order by id desc limit 1");
		if (mysqli_num_rows($select_last_added_lab)) {
			$select_last_added_lab_row = mysqli_fetch_assoc($select_last_added_lab);
			$lab_id = $select_last_added_lab_row['id'];
		}
		
		$upload_dir = "../../../lab/assets/fileupload/";
		foreach ($file as $y => $fileName) {
			echo $fileName;
			// Get extension
			$ext = pathinfo($fileName, PATHINFO_EXTENSION);
			// Valid image extensions
			$valid_ext = array("jpg", "jpeg", "png");
			$path = $upload_dir . $fileName;
			if (in_array($ext, $valid_ext)) {
				// Compress and save image
				if (compressFile($_FILES['files']['tmp_name'][$y], $path, 55)) {
					$insert_data = array(
						'lab_data_id' => $lab_id,
						'file' => $fileName,
						"uploaded_branch" => $real_branch_id,
						"upload_from" => 0,
						"status"=>1,
					);
					$obj_branch->insertData("tbl_lab_reports", $insert_data);
					
				}
				echo $patient_id;
			} else {
				insertnormal($_FILES['files']['tmp_name'][$y], $fileName, $upload_dir);
				$insert_data = array(
					'lab_data_id' => $lab_id,
					'file' => $fileName,
					"uploaded_branch" => $real_branch_id,
					"upload_from" => 0,
					"status"=>1,
				);
				$obj_branch->insertData("tbl_lab_reports", $insert_data);
				
				echo $patient_id;
			}
		}
		// tbl_lab_report
		$count = count($_FILES['files']['name']);
		$main_folder_path = '';
		if ($branch == 4) {
			$main_folder_path = "https://jmwell.in/offlineconsultation/";
		} elseif ($branch == 5) {
			$main_folder_path = "https://pala.jmwell.in/offlineconsultation/";
		} elseif ($branch == 7) {
			$main_folder_path = "https://kannur.jmwell.in/offlineconsultation/";
		} elseif ($branch == 8) {
			$main_folder_path = "https://trvl.jmwell.in/offlineconsultation/";
		} elseif ($branch == 9) {
			$main_folder_path = "https://tvm.jmwell.in/offlineconsultation/";
		}
	}
}

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
	return true;
}

function insertnormal($x, $y, $path)
{   
	move_uploaded_file($x, $path.$y);
}

function insertnormal1($x, $y, $path)
{
	move_uploaded_file($x, $path.$y);
}
?>
