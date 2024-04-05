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
$c_year = date('Y');
if(isset($_SESSION['doctor_login_id'])){
$login_id = $_SESSION['doctor_login_id'];
$staff_role = $_SESSION['doctor_role'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
if($staff_role == 'doctor'){
$api_key_value = $_SESSION['api_key_value_doctor'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
	$appointment_id = $_POST['appointment_id'];
	$branch = $_POST['p_brnach_id'];
	require_once '../../../_class_branch/query_branch.php';
	$obj_branch = new query_branch();
	$patient_id = 0;
	$appointment_added_date = '';
	$doctor_id = 0;
	$fetch_patient_id = $obj->selectData("patient_id,appointment_date,doctor_id,consulted_by","tbl_appointment","where id=$appointment_id");
	//and appointment_status=1 and status!=0
	if(mysqli_num_rows($fetch_patient_id)>0){
		while($fetch_patient_id_row = mysqli_fetch_array($fetch_patient_id)){
			if($fetch_patient_id_row['consulted_by'] != 0){
				$doctor_id =  $fetch_patient_id_row['consulted_by'];
			}else{
				$doctor_id =  $fetch_patient_id_row['doctor_id'];
			}
			$patient_id = $fetch_patient_id_row['patient_id'];
			$appointment_added_date = date('d-m-Y',strtotime($fetch_patient_id_row['appointment_date']));
			
		}
	}
	if($patient_id !=0){
		
		$select_doctor_data = $obj->selectData("doctor_name,designation_data,qualification_data,experiance_data,reg_num","tbl_doctor","where login_id=$doctor_id");
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
				$select_First_visit = $obj_branch->selectData("first_visit","tbl_appointment","where patient_id='$patient_id' and status!=0");
				
				if(mysqli_num_rows($select_First_visit)>0){
					while($select_First_visit_row = mysqli_fetch_array($select_First_visit)){
						$response_arr[0]['first_visit'] = $select_First_visit_row['first_visit'];
						if($select_First_visit_row['first_visit'] != ''){
							break;
						}
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
					
				
				
				$select_appointment_details = $obj->selectData("weight,height,diet_no_of_days,dite_remark,main_remark","tbl_appointment","where id=$appointment_id ");
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
			$c_appointment_id = 0;
			$cross_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$appointment_id");
					if(mysqli_num_rows($cross_appointment_id)>0){
						$cross_appointment_id_row = mysqli_fetch_array($cross_appointment_id);
						$c_appointment_id = $cross_appointment_id_row['id'];
					}else{
						$c_appointment_id = $appointment_id;
					}
					//select prescription for this appointment
					$selectData_prescription = $obj_branch->selectData("id","tbl_prescriptions","where appointment_id=$c_appointment_id and status!=0");
						//echo $selectData_prescription;exit();
						if(mysqli_num_rows($selectData_prescription)>0){
							$x1 = 0;
							while($selectData_prescription_row = mysqli_fetch_array($selectData_prescription)){
								$prescription_id_pk = $selectData_prescription_row['id'];
								$selectData_prescription_details = $obj_branch->selectData("medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,after_food,befor_food","tbl_prescription_medicine_data","where status!=0 and prescription_id=$prescription_id_pk ORDER BY position_data ASC");
								if(mysqli_num_rows($selectData_prescription_details)>0){
									while($selectData_prescription_details_rows = mysqli_fetch_array($selectData_prescription_details)){
										$response_arr[0]['prescription'][$x1]['medicine_name'] = $selectData_prescription_details_rows['medicine_name'];
										$response_arr[0]['prescription'][$x1]['quantity'] = $selectData_prescription_details_rows['quantity'];
										$response_arr[0]['prescription'][$x1]['morning_section'] = $selectData_prescription_details_rows['morning_section'];
										$response_arr[0]['prescription'][$x1]['noon_section'] = $selectData_prescription_details_rows['noon_section'];
										$response_arr[0]['prescription'][$x1]['evening_section'] = $selectData_prescription_details_rows['evening_section'];
										$response_arr[0]['prescription'][$x1]['no_of_day'] = $selectData_prescription_details_rows['no_of_day'];
											$response_arr[0]['prescription'][$x1]['after_food'] = $selectData_prescription_details_rows['after_food'];
											$response_arr[0]['prescription'][$x1]['befor_food'] = $selectData_prescription_details_rows['befor_food'];
										$x1++;
									}
								}
							}
					       	}
						
					//select current date complaint history
						$select_complaint_history = $obj_branch->selectData("comment","tbl_comments","where patient_id = '$patient_id_unique_id' and added_date ='$appointment_added_date' and status!=0");
					if(mysqli_num_rows($select_complaint_history)>0){
						$x2 = 0;
						while($select_complaint_history_row = mysqli_fetch_array($select_complaint_history)){
							$response_arr[0]['comment_data'][$x2]['comment'] = $select_complaint_history_row['comment'];
							$x2++;
						}
					}	
						
					//medical history
				$medical_history = $obj_branch->selectData("id,comment","tbl_medical_history","where patient_id='$patient_id_unique_id' and added_date ='$appointment_added_date' and status!=0");
					       if(mysqli_num_rows($medical_history)>0){
							   $x3 = 0;
						   	while($medical_history_row = mysqli_fetch_array($medical_history)){
								$id = $medical_history_row['id'];
								$comment = $medical_history_row['comment'];
								$response_arr[0]['medical_data'][$x3]['comment'] = $medical_history_row['comment'];
								$x3++;
							}
						   }
						
							//surgical history
				$surgical_history = $obj_branch->selectData("id,comment","tbl_surgical_history","where patient_id='$patient_id_unique_id' and added_date ='$appointment_added_date' and status!=0");
					       if(mysqli_num_rows($surgical_history)>0){
							   $x4 = 0;
						   	while($surgical_history_row = mysqli_fetch_array($surgical_history)){
								$id = $surgical_history_row['id'];
								$comment = $surgical_history_row['comment'];
								$response_arr[0]['surgical_data'][$x4]['comment'] = $surgical_history_row['comment'];
								$x4++;
							}
						   }
						
						//dite plan to follow
						$select_dite_plan = $obj_branch->selectData("diet","tbl_diet_followed","where appointment_id=$c_appointment_id and status!=0");
						
						if(mysqli_num_rows($select_dite_plan)>0){
							$x5 = 0;
							while($select_dite_plan_row = mysqli_fetch_array($select_dite_plan)){
								$response_arr[0]['diet_follow'][$x5]['diet'] = $select_dite_plan_row['diet'];
								$x5++;
							}
						}
						  //Foods to be avoided
						$select_food_to_be_avoid = $obj_branch->selectData("foods_to_be_avoided","tbl_foods_avoid","where appointment_id=$c_appointment_id and status!=0");
						if(mysqli_num_rows($select_food_to_be_avoid)>0){
							$x6 = 0;
							while($select_food_to_be_avoid_row = mysqli_fetch_array($select_food_to_be_avoid)){
								$response_arr[0]['food_plan'][$x6]['foods_avoid'] = $select_food_to_be_avoid_row['foods_to_be_avoided'];
								$x6++;
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
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';	
}
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Unauthorised login';
}
echo json_encode($response_arr);
?>