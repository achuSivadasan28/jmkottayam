<?php
session_start();
require_once '../_class/query.php';
$response_arr = array();
$obj=new query();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$appointment_id = $_POST['appointment_id'];
$api_key_val = $_POST['api_key_val'];
$branch = $_POST['branch'];
require_once '../_class_branch/query_branch.php';
$obj_branch = new query_branch();
$enc_api_key_val = md5($api_key_val);
$Api_key = 'requestingfor@patientCount';
$Api_value = 'JhonmariansBilling';
$key_compain = $Api_key.''.$Api_value;
$enc_key_val = md5($key_compain);
$appointment_added_date = '';
$main_remark = '';
if($enc_api_key_val == 'cee5c2a44868706bec43e115c2633e27'){
	$patient_id = 0;
	$doctor_id = 0;
	$real_branch_id = 0;
	$branch_id = 0;
	$selectData_prescription_p = $obj->selectData("patient_id,appointment_date,main_remark,consulted_by,doctor_id,real_branch_id,branch_id","tbl_appointment","where id=$appointment_id");
	//echo $selectData_prescription_p;exit();
	if(mysqli_num_rows($selectData_prescription_p)>0){
		while($selectData_prescription_p_row = mysqli_fetch_array($selectData_prescription_p)){
			$real_branch_id = $selectData_prescription_p_row['real_branch_id'];
			$branch_id = $selectData_prescription_p_row['branch_id'];
			
			
			$appointment_added_date1 = $selectData_prescription_p_row['appointment_date'];
			$appointment_added_date = date('d-m-Y',strtotime($appointment_added_date1));
			$patient_id = $selectData_prescription_p_row['patient_id'];
			$main_remark = $selectData_prescription_p_row['main_remark'];
			$dite_remark = $selectData_prescription_p_row['dite_remark'];
			if($selectData_prescription_p_row['consulted_by'] != 0){
				$doctor_id =  $selectData_prescription_p_row['consulted_by'];
			}else{
				$doctor_id =  $selectData_prescription_p_row['doctor_id'];
			}
		}
	}
	if($real_branch_id != $branch_id){
		$real_branch_id = $branch_id;
		$branch = $real_branch_id;
		$obj_branch = new query_branch();
		$selectData_prescription_app = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$appointment_id and cross_branch_status=1 and patient_id=$patient_id");
		//echo $selectData_prescription_app;exit();
		if(mysqli_num_rows($selectData_prescription_app)>0){
			$selectData_prescription_app_row = mysqli_fetch_array($selectData_prescription_app);
			$appointment_id = $selectData_prescription_app_row['id'];
		}
	}
		$branch = $real_branch_id;
		$obj_branch = new query_branch();
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
	
	$branch = $branch_id;
	$obj_branch = new query_branch();
	
	$select_appointment_details = $obj_branch->selectData("weight,height,diet_no_of_days,dite_remark","tbl_appointment","where id=$appointment_id");
				//and appointment_status=1 and status!=0
				if(mysqli_num_rows($select_appointment_details)>0){
					while($select_appointment_details_row = mysqli_fetch_array($select_appointment_details)){
					$height = $select_appointment_details_row['height'];
					$weight = $select_appointment_details_row['weight'];
						$response_arr[0]['height'] = $height;
						$response_arr[0]['weight'] = $weight;
					$response_arr[0]['diet_no_of_days'] = $select_appointment_details_row['diet_no_of_days'];
					$response_arr[0]['dite_remark'] = $select_appointment_details_row['dite_remark'];
					$response_arr[0]['BMI'] = '';
					$response_arr[0]['weight_cat'] = '';
					if($height != '' && $weight != '' && $height != 0 && $weight != 0){
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
				$response_arr[0]['main_remark'] = $main_remark;
				//$response_arr[0]['diet_remark'] = $dite_remark;
				$patient_id_unique_id = $select_patient_id_row['unique_id'];
				$select_First_visit = $obj_branch->selectData("appointment_date","tbl_appointment","where patient_id='$patient_id' and appointment_status=2 and status!=0 and branch_id = $branch_id limit 1");
				
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
			}
		}
	$selectData_prescription = $obj_branch->selectData("id","tbl_prescriptions","where appointment_id=$appointment_id and status!=0");
						//echo $selectData_prescription;exit();
						if(mysqli_num_rows($selectData_prescription)>0){
							$response_arr[0]['status']  = 1;
							$response_arr[0]['data-exist'] = 1;
							$x1 = 0;
							while($selectData_prescription_row = mysqli_fetch_array($selectData_prescription)){
								$prescription_id_pk = $selectData_prescription_row['id'];
								$selectData_prescription_details = $obj_branch->selectData("medicine_name,quantity,morning_section,noon_section,evening_section,no_of_day,after_food,befor_food,medicine_id","tbl_prescription_medicine_data","where status!=0 and prescription_id=$prescription_id_pk");
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
										$response_arr[0]['prescription'][$x1]['medicine_id'] = $selectData_prescription_details_rows['medicine_id'];
										$x1++;
									}
								}
							}
					       	}else{
							$response_arr[0]['data-exist'] = 0;
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
						$select_dite_plan = $obj_branch->selectData("diet","tbl_diet_followed","where appointment_id=$appointment_id and status!=0");
						
						if(mysqli_num_rows($select_dite_plan)>0){
							$x5 = 0;
							while($select_dite_plan_row = mysqli_fetch_array($select_dite_plan)){
								$response_arr[0]['diet_follow'][$x5]['diet'] = $select_dite_plan_row['diet'];
								$x5++;
							}
					     	}
	
	  //Foods to be avoided
						$select_food_to_be_avoid = $obj_branch->selectData("foods_to_be_avoided","tbl_foods_avoid","where appointment_id=$appointment_id and status!=0");
						if(mysqli_num_rows($select_food_to_be_avoid)>0){
							$x6 = 0;
							while($select_food_to_be_avoid_row = mysqli_fetch_array($select_food_to_be_avoid)){
								$response_arr[0]['food_plan'][$x6]['foods_avoid'] = $select_food_to_be_avoid_row['foods_to_be_avoided'];
								$x6++;
							}
						 }
	
	
	
}else{
	$response_arr[0]['status'] = 0;
	$response_arr[0]['msg'] = 'Something Went Wrong';
}
echo json_encode($response_arr);
?>