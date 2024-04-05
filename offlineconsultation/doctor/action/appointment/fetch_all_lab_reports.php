<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
$obj=new query();
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$obj_common=new query_common();
$response_arr = array();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$c_year = date('Y');
$patient_id = $_POST['patient_id'];
$branch = $_POST['branch_id'];
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$test_name = '';
$id = '';
$lab_report_file = '';
$select_all_reports_date = $obj_branch->selectData("DISTINCT added_date","tbl_add_lab_data","where patient_id=$patient_id and status!=0 ORDER BY id DESC");
if(mysqli_num_rows($select_all_reports_date)>0){
	$x = 0;
	while($select_all_reports_date_row = mysqli_fetch_array($select_all_reports_date)){
		$added_date = $select_all_reports_date_row['added_date'];
		$response_arr[$x]['added_date'] = $added_date;
		$select_all_reports = $obj_branch->selectData("test_name,id","tbl_add_lab_data","where added_date='$added_date' and patient_id=$patient_id and status!=0");
if(mysqli_num_rows($select_all_reports)>0){
	$lab_status = 0;
	$y = 0;
	while($select_all_reports_row = mysqli_fetch_array($select_all_reports)){
		$test_name = $select_all_reports_row['test_name'];
		$id = $select_all_reports_row['id'];
		$response_arr[$x]['lab'][$y]['test_name'] = $test_name;
		$select_lab_file = $obj_branch->selectData("file,uploaded_branch,upload_from","tbl_lab_reports","where status = 1 and lab_data_id = $id ");
		
		if(mysqli_num_rows($select_lab_file)){
			$lab_status = 1;
			$z = 0;
		 	while($select_lab_file_rows = mysqli_fetch_assoc($select_lab_file)){
				
				$lab_report_file = $select_lab_file_rows['file'];
				$upload_branch = $select_lab_file_rows['uploaded_branch'];
				$upload_from = $select_lab_file_rows['upload_from'];
				if($upload_branch == 0){
					$upload_branch = 16;
				}
				
		if($upload_from == 0){
		
		$select_branch_url = $obj->selectData("branch_id,url","tbl_branch_url","where status!=0 and branch_id=$upload_branch");
			
		if(mysqli_num_rows($select_branch_url)>0){
			$select_branch_url_row = mysqli_fetch_array($select_branch_url);
			$response_arr[$x]['lab'][$y]['test'][$z]['url'] = $select_branch_url_row['url'].'offlineconsultation/lab/assets/fileupload/';
			$branch_url_data = $response_arr[$x]['lab'][$y]['test'][$z]['url'];
			if($lab_report_file != ''){
				$file_path_data = $branch_url_data.$lab_report_file;
				$headers = @get_headers($file_path_data);
				$response_arr[$x]['lab'][$y]['test'][$z]['file_status_file'] = $file_path_data;
				
				if ($headers && strpos($headers[0], "200 OK") !== false) {
						$response_arr[$x]['lab'][$y]['test'][$z]['file_status'] = 1;
    					//echo "The file exists.";
					} else {
						$response_arr[$x]['lab'][$y]['test'][$z]['file_status'] = 0;
    					//echo "The file does not exist.";
					}
			
			}
		}
		}else{
				$response_arr[$x]['lab'][$y]['test'][$z]['url'] = "https://johnmariansconsultation.com/fileupload/";
				if($lab_report_file != ''){
					$file_path_data = "https://johnmariansconsultation.com/fileupload/".$lab_report_file;
					$headers = @get_headers($file_path_data);
					$response_arr[$x]['lab'][$y]['test'][$z]['file_status_file'] = $file_path_data;
					if ($headers && strpos($headers[0], "200 OK") !== false) {
						$response_arr[$x]['lab'][$y]['test'][$z]['file_status'] = 1;
    					//echo "The file exists.";
					} else {
						$response_arr[$x]['lab'][$y]['test'][$z]['file_status'] = 0;
    					//echo "The file does not exist.";
					}
				}
			
		}
				$z++;
			}
		}
		
	
		
		$response_arr[$x]['lab'][$y]['report_status'] = $lab_status;
		$response_arr[$x]['lab'][$y]['id'] = $id;
		
		$y++;
	}
}
		$x++;
	}
}
echo json_encode($response_arr);

?>