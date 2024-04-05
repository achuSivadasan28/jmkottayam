<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$c_days=date('Y-m-d');
$times=date('h:i:s A');
$appointment_id = $_POST['appointment_id'];
$patient_id = 0;
$appointment_added_date = '';
$doctor_id = 0;
$branch = 0;
$fetch_patient_id = $obj->selectData("patient_id,appointment_date,doctor_id,consulted_by,branch_id","tbl_appointment","where id=$appointment_id");
if(mysqli_num_rows($fetch_patient_id)){
$fetch_patient_id_row = mysqli_fetch_array($fetch_patient_id);
$branch = $fetch_patient_id_row['branch_id'];
$c_year = date('Y');
if($fetch_patient_id_row['consulted_by'] != 0){
	$doctor_id =  $fetch_patient_id_row['consulted_by'];
}else{
	$doctor_id =  $fetch_patient_id_row['doctor_id'];
}
$patient_id = $fetch_patient_id_row['patient_id'];
$appointment_added_date = date('d-m-Y',strtotime($fetch_patient_id_row['appointment_date']));
}
require_once '../../../_class_branch/query_branch.php';
$obj_branch = new query_branch();
	if($patient_id !=0){
		
		$select_doctor_data = $obj_branch->selectData("doctor_name,designation_data,qualification_data,experiance_data,reg_num","tbl_doctor","where login_id=$doctor_id");
		if(mysqli_num_rows($select_doctor_data)>0){
			while($select_doctor_data_row = mysqli_fetch_array($select_doctor_data)){
				$response_arr[0]['doctor_name'] = $select_doctor_data_row['doctor_name'];
				$response_arr[0]['designation_data'] = $select_doctor_data_row['designation_data'];
				$response_arr[0]['qualification_data'] = $select_doctor_data_row['qualification_data'];
				$response_arr[0]['experiance_data'] = $select_doctor_data_row['experiance_data'];
				$response_arr[0]['reg_num'] = $select_doctor_data_row['reg_num'];
			}
		}
		
		$select_patient_id = $obj_branch->selectData("unique_id,name,phone,address,place,gender,age","tbl_patient","where id=$patient_id and status!=0");
		if(mysqli_num_rows($select_patient_id)>0){
			while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
				$response_arr[0]['unique_id'] = $select_patient_id_row['unique_id'];
				$response_arr[0]['name'] = $select_patient_id_row['name'];
				$response_arr[0]['phone'] = $select_patient_id_row['phone'];
				$response_arr[0]['address'] = $select_patient_id_row['address'];
				$response_arr[0]['place'] = $select_patient_id_row['place'];
				$response_arr[0]['gender'] = $select_patient_id_row['gender'];
				$response_arr[0]['age'] = $select_patient_id_row['age'];
				$patient_id_unique_id = $select_patient_id_row['unique_id'];
				$select_First_visit = $obj_branch->selectData("appointment_date","tbl_appointment","where patient_id='$patient_id' and appointment_status=2 and status!=0 limit 1");
				
				if(mysqli_num_rows($select_First_visit)>0){
					while($select_First_visit_row = mysqli_fetch_array($select_First_visit)){
						$response_arr[0]['first_visit'] = $select_First_visit_row['appointment_date'];
					}
				}
				
				$select_last_visit = $obj_branch->selectData("appointment_date","tbl_appointment","where patient_id='$patient_id' and appointment_status=2 and status!=0 ORDER BY id DESC limit 1");
				if(mysqli_num_rows($select_last_visit)>0){
					while($select_last_visit_row = mysqli_fetch_array($select_last_visit)){
						$response_arr[0]['Last_visit'] = $select_last_visit_row['appointment_date'];
					}
				}
				$select_total_num_visit = $obj_branch->selectData("count(id) as id","tbl_appointment","where patient_id='$patient_id' and appointment_status=2 and status!=0");
						$select_total_num_visit_row = mysqli_fetch_array($select_total_num_visit);
						if($select_total_num_visit_row['id'] != null){
							$response_arr[0]['total_visit_count'] = $select_total_num_visit_row['id'];
						}
					
				
				
				$select_appointment_details = $obj_branch->selectData("weight,height,diet_no_of_days,dite_remark,main_remark","tbl_appointment","where id=$appointment_id ");
				//and appointment_status=1 and status!=0
				if(mysqli_num_rows($select_appointment_details)>0){
					while($select_appointment_details_row = mysqli_fetch_array($select_appointment_details)){
					$height = $select_appointment_details_row['height'];
					$weight = $select_appointment_details_row['weight'];
						$response_arr[0]['height'] = $height;
						$response_arr[0]['weight'] = $weight;
					$response_arr[0]['diet_no_of_days'] = $select_appointment_details_row['diet_no_of_days'];
					$response_arr[0]['dite_remark'] = $select_appointment_details_row['main_remark'];
					$response_arr[0]['BMI'] = '';
					$response_arr[0]['weight_cat'] = '';
					if($height != '' && $weight != ''){
					$height_in_m = $height/100;
					$height_in_m *= $height_in_m;
					$BMI = round($weight/$height_in_m,2);
					$response_arr[0]['BMI'] = $BMI;
						if($BMI < 18.5){
								$response_arr[0]['weight_cat'] = 'UnderWeight';
								}else if($BMI >=18.5 && $BMI <= 24.9){
								$response_arr[0]['weight_cat'] = 'Healthy Weight';
							}else if($BMI >= 25 && $BMI <=29.9){
								$response_arr[0]['weight_cat'] = 'OverWeight';
							}else if($BMI >=30 && $BMI <= 34.9){
								$response_arr[0]['weight_cat'] = 'Obese (Class1)';
							}else if($BMI >= 35 && $BMI <= 39.9){
								$response_arr[0]['weight_cat'] = 'Severely Obese (Class11)';
							}else if($BMI >= 40 && $BMI <= 49.9){
								$response_arr[0]['weight_cat'] = 'Morbidly Obese (Class111)';
							}else if($BMI >=50){
								$response_arr[0]['weight_cat'] = 'Super Obese (Class111)';
							}
					}
$select_appoint_id = $obj_branch->selectData('id',"tbl_appointment","where cross_appointment_id = $appointment_id ");
//print_r($obj_branch);exit();
if(mysqli_num_rows($select_appoint_id)){
	$select_appoint_id_rows = mysqli_fetch_assoc($select_appoint_id);
	$appointment_id = $select_appoint_id_rows['id'];
}						
$select_appointment_lab_report = $obj_branch->selectData("test_name","tbl_add_lab_data","where appointment_id=$appointment_id and status!=0");
if(mysqli_num_rows($select_appointment_lab_report)>0){
	$x = 0;
	while($select_appointment_lab_report_row = mysqli_fetch_array($select_appointment_lab_report)){
		$response_arr[0]['treatment'][$x]['treatment_name'] = $select_appointment_lab_report_row['test_name'];
		$x++;
	}
}
						
					
					}
				}
				
			}
			
			//$select_doctor_data = $obj->selectData("doctor_name","tbl_doctor","where login_id=$doctor_id");
		}
	}
	$response_arr[0]['status'] = 1;
	$response_arr[0]['msg'] = 'Success';
echo json_encode($response_arr);
?>