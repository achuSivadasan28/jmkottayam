<?php
require_once '../../../_class/query.php';
$obj = new query();
$select_all_lab_data = $obj->selectData("id,lab_report_file,lab_report_status,uploaded_branch,upload_from","tbl_add_lab_data","where 1");
if(mysqli_num_rows($select_all_lab_data)){
	while($select_all_lab_data_rows = mysqli_fetch_assoc($select_all_lab_data)){
		$file_name = $select_all_lab_data_rows['lab_report_file'];
		$file_id = $select_all_lab_data_rows['id'];
		$status = $select_all_lab_data_rows['lab_report_status'];
		$uploaded_branch = $select_all_lab_data_rows['uploaded_branch'];
		$upload_from = $select_all_lab_data_rows['upload_from'];
		$insert_data = [
			"lab_data_id" => $file_id,
			"file" => $file_name,
			"uploaded_branch" => $uploaded_branch,
			"upload_from" => $upload_from,
			"status" => $status,
		];
		$obj->insertData("tbl_lab_reports",$insert_data);
	}
}
echo "done";exit();
?>