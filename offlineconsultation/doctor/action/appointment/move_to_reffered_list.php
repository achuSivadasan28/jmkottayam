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
			$patient_id = $_POST['patient_id'];
			$food_avoided_plan = $_POST['food_avoided_plan'];
			$diet_plan = $_POST['diet_plan'];
			$diet_plan = $_POST['diet_plan'];
			$c_patient_id = 0;
			$consulted_branch_id =  $_POST['consulted_branch_id'];
			$reffered_doc_id = $_POST['reffred_doc_id'];
			$reffered_date = date('Y-m-d',strtotime($_POST['reffered_date']));
			$branch = $consulted_branch_id;
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$check_cross_appointment = $obj->selectData("id,real_branch_id,branch_id","tbl_appointment","where id=$patient_id");
			//echo $check_cross_appointment;exit();
			if(mysqli_num_rows($check_cross_appointment)>0){
				$check_cross_appointment_row = mysqli_fetch_array($check_cross_appointment);
				if($check_cross_appointment_row['real_branch_id'] == $check_cross_appointment_row['branch_id']){
					if($reffered_date === $c_days){
						$c_patient_id = $patient_id;
						$food_status = array(
							"status" => 0
						);

						$obj->updateData("tbl_foods_avoid",$food_status,"where appointment_id=$c_patient_id");
						$diet_status = array(
							"status" => 0
						);
						$obj->updateData("tbl_diet_followed",$diet_status,"where appointment_id=$c_patient_id");
						$info_update_counsulted_b = array(
							"appointment_date" => $c_days,
							"diet_no_of_days" => $_POST['no_of_days'],
							"dite_remark" => $_POST['food_remark'],
							"main_remark" =>  $_POST['main_remark'],
							"consulted_by" => $login_id,
							"appointment_status" => 1,
							"reffer_status" => $reffered_doc_id,
							"reffered_date" => $reffered_date,

						);
						$pending_data = 0;
						$obj->updateData("tbl_appointment",$info_update_counsulted_b,"where id=$patient_id");
						if(sizeof($food_avoided_plan)!=0){
							for($x1=0;$x1<sizeof($food_avoided_plan);$x1++){
								$check_food_data = $obj->selectData("id","tbl_foods_avoid","where appointment_id=$c_patient_id and foods_to_be_avoided='$food_avoided_plan[$x1]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_food_data)>0){
								}else{
									$food_avoided_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"foods_to_be_avoided" => $food_avoided_plan[$x1],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj->insertData("tbl_foods_avoid",$food_avoided_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}

						if(sizeof($diet_plan)!=0){
							for($x2=0;$x2<sizeof($diet_plan);$x2++){
								$check_dite_plan = $obj->selectData("id","tbl_diet_followed","where appointment_id=$c_patient_id and diet='$diet_plan[$x2]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_dite_plan)>0){}else{
									$diet_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"diet" => $diet_plan[$x2],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj->insertData("tbl_diet_followed",$diet_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}

						$select_watting_pending_count = $obj->selectData("count(tbl_appointment.appointment_status) as watting_list","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.appointment_date='$c_days' and tbl_appointment.status!=0 and tbl_appointment.appointment_status=1");
						$select_watting_pending_count_row = mysqli_fetch_array($select_watting_pending_count);
						if($select_watting_pending_count_row['watting_list'] != null){
							$pending_data = $select_watting_pending_count_row['watting_list'];
						}
						$response_arr[0]['status'] = 1;
						$response_arr[0]['msg'] = 'Success';
						$response_arr[0]['pending_count'] = $pending_data;
					}else{
						$c_patient_id = $patient_id;
						$food_status = array(
							"status" => 0
						);

						$obj->updateData("tbl_foods_avoid",$food_status,"where appointment_id=$c_patient_id");
						$diet_status = array(
							"status" => 0
						);
						$obj->updateData("tbl_diet_followed",$diet_status,"where appointment_id=$c_patient_id");
						$info_update_counsulted_b = array(
							"appointment_date" => $c_days,
							"diet_no_of_days" => $_POST['no_of_days'],
							"dite_remark" => $_POST['food_remark'],
							"main_remark" =>  $_POST['main_remark'],
							"consulted_by" => $login_id,
							"appointment_status" => 2,


						);
						$pending_data = 0;
						$obj->updateData("tbl_appointment",$info_update_counsulted_b,"where id=$patient_id");
						if(sizeof($food_avoided_plan)!=0){
							for($x1=0;$x1<sizeof($food_avoided_plan);$x1++){
								$check_food_data = $obj->selectData("id","tbl_foods_avoid","where appointment_id=$c_patient_id and foods_to_be_avoided='$food_avoided_plan[$x1]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_food_data)>0){
								}else{
									$food_avoided_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"foods_to_be_avoided" => $food_avoided_plan[$x1],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj->insertData("tbl_foods_avoid",$food_avoided_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}

						if(sizeof($diet_plan)!=0){
							for($x2=0;$x2<sizeof($diet_plan);$x2++){
								$check_dite_plan = $obj->selectData("id","tbl_diet_followed","where appointment_id=$c_patient_id and diet='$diet_plan[$x2]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_dite_plan)>0){}else{
									$diet_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"diet" => $diet_plan[$x2],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj->insertData("tbl_diet_followed",$diet_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}

						$select_watting_pending_count = $obj->selectData("count(tbl_appointment.appointment_status) as watting_list","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.appointment_date='$c_days' and tbl_appointment.status!=0 and tbl_appointment.appointment_status=1");
						$select_watting_pending_count_row = mysqli_fetch_array($select_watting_pending_count);
						if($select_watting_pending_count_row['watting_list'] != null){
							$pending_data = $select_watting_pending_count_row['watting_list'];
						}
						$select_appointment_details = $obj->selectData("id,real_branch_id,branch_id,patient_id,weight,height,blood_pressure,allergies_if_any,current_medication,present_Illness,any_surgeries,first_visit,any_metal_Implantation", "tbl_appointment", "where id = $patient_id");

						if (mysqli_num_rows($select_appointment_details) > 0) {
							$select_appointment_details_row = mysqli_fetch_array($select_appointment_details);
							$patient_id = $select_appointment_details_row['patient_id'];
							$branch_id = $select_appointment_details_row['branch_id'];
							$real_branch_id = $select_appointment_details_row['real_branch_id'];
							$weight = $select_appointment_details_row['weight'];
							$height = $select_appointment_details_row['height'];
							$blood_pressure = $select_appointment_details_row['blood_pressure'];
							$allergies_if_any = $select_appointment_details_row['allergies_if_any'];
							$current_medication = $select_appointment_details_row['current_medication'];
							$present_Illness = $select_appointment_details_row['present_Illness'];
							$first_visit = $select_appointment_details_row['first_visit'];
							$any_metal_Implantation = $select_appointment_details_row['any_metal_Implantation'];


							$branch = 5;
							$obj_branch = new query_branch();
							$select_appointment_number = $obj_branch->selectData("count(id) as token_no", "tbl_appointment", "where doctor_id = $referred_id and reffered_date = '$referred_date' and status != 0");

							if (mysqli_num_rows($select_appointment_number) > 0) {
								$select_appointment_number_row = mysqli_fetch_assoc($select_appointment_number);
								$token_no = $select_appointment_number_row['token_no'] + 1;
							} else {
								$token_no = 1;
							}

							$info_add_appointment = array(
								"patient_id" => $patient_id,
								"doctor_id" => $login_id,
								"branch_id" => $branch_id,
								"real_branch_id" => 5,
								"appointment_date" => $reffered_date,
								"appointment_taken_type" => "Offline",
								"appointment_year" => date("Y"),
								"height" => $height,
								"weight" => $weight,
								"blood_pressure" => $blood_pressure,
								"allergies_if_any" => $allergies_if_any,
								"current_medication" => $current_medication,
								"present_Illness" => $present_Illness,
								"any_surgeries" => $any_surgeries,
								"first_visit" => $first_visit,
								"any_metal_Implantation" => $any_metal_Implantation,
								"appointment_number" => $token_no,
								"appointment_taken_date" => date("d-m-Y"),
								"appointment_taken_time" => date("H:i:s"),
								"appointment_taken_id" => $login_id, // You need to define $login_id
								"appointment_status" => 1,
								"status" => 1,
								"reffer_status" => $reffered_doc_id , // You need to define $login_id
								"reffered_date" => $reffered_date,
								"appointment_fee_status" => 1,
								"reffered_doctor_branch" => $real_branch_id,
							);
							$obj_branch->insertData("tbl_appointment", $info_add_appointment);
							//print_r($obj_branch);
							if ($branch_id != 5) {
								//cross branch
								$select_last_appointment = $obj_branch->selectData("max(id) as id", "tbl_appointment", "where patient_id = $patient_id and status != 0");
								if (mysqli_num_rows($select_last_appointment) > 0) {
									$select_last_appointment_row = mysqli_fetch_assoc($select_last_appointment);
									$appmnt_id = $select_last_appointment_row['id'];
								}

								$info_add_appointment = array(
									"patient_id" => $patient_id,
									"doctor_id" => $reffered_doc_id,
									"branch_id" => $branch_id,
									"real_branch_id" => $branch_id,
									"appointment_date" => $reffered_date,
									"appointment_taken_type" => "Offline",
									"appointment_year" => date("Y"),
									"height" => $height,
									"weight" => $weight,
									"blood_pressure" => $blood_pressure,
									"allergies_if_any" => $allergies_if_any,
									"current_medication" => $current_medication,
									"present_Illness" => $present_Illness,
									"any_surgeries" => $any_surgeries,
									"first_visit" => $first_visit,
									"any_metal_Implantation" => $any_metal_Implantation,
									"appointment_number" => $token_no,
									"appointment_taken_date" => date("d-m-Y"),
									"appointment_taken_time" => date("H:i:s"),
									"appointment_taken_id" => $login_id, // You need to define $login_id
									"status" => 1,
									"cross_branch_status" => 1,
									"cross_appointment_id" => $appmnt_id,
									"cross_branch_id" => $real_branch_id,
								);
								$branch = $branch_id;
								$obj_branch = new query_branch();
								$obj_branch->insertData("tbl_appointment", $info_add_appointment);
								//print_r($obj_branch);exit();
							}

						}
						$response_arr[0]['status'] = 1;
						$response_arr[0]['msg'] = 'Success';
						$response_arr[0]['pending_count'] = $pending_data;



					}


				}else{
					if($c_days === $reffered_date){
						$select_actual_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$patient_id");
						if(mysqli_num_rows($select_actual_appointment_id)>0){
							$select_actual_appointment_id_row = mysqli_fetch_array($select_actual_appointment_id);
							$c_patient_id = $select_actual_appointment_id_row['id'];
						}
						$food_status = array(
							"status" => 0
						);
						$obj_branch->updateData("tbl_foods_avoid",$food_status,"where appointment_id=$c_patient_id");
						$diet_status = array(
							"status" => 0
						);
						$obj_branch->updateData("tbl_diet_followed",$diet_status,"where appointment_id=$c_patient_id");
						$info_update_counsulted_b = array(
							"appointment_date" => $c_days,
							"diet_no_of_days" => $_POST['no_of_days'],
							"dite_remark" => $_POST['food_remark'],
							"main_remark" =>  $_POST['main_remark'],
							"consulted_by" => $login_id,
							"appointment_status" => 1,
							"reffer_status" => $reffered_doc_id,
							"reffered_date" => $reffered_date,

						);
						$pending_data = 0;
						$obj->updateData("tbl_appointment",$info_update_counsulted_b,"where id=$patient_id");
						$info_update_counsulted = array(
							"appointment_date" => $c_days,
							"diet_no_of_days" => $_POST['no_of_days'],
							"dite_remark" => $_POST['food_remark'],
							"main_remark" =>  $_POST['main_remark'],
							"consulted_by" => $login_id,
							"appointment_status" => 1,
							"reffer_status" => $reffered_doc_id,
							"reffered_date" => $reffered_date,

						);
						$pending_data = 0;
						$obj_branch->updateData("tbl_appointment",$info_update_counsulted,"where cross_appointment_id=$c_patient_id");
						if(sizeof($food_avoided_plan)!=0){
							for($x1=0;$x1<sizeof($food_avoided_plan);$x1++){
								$check_food_data = $obj_branch->selectData("id","tbl_foods_avoid","where appointment_id=$c_patient_id and foods_to_be_avoided='$food_avoided_plan[$x1]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_food_data)>0){
								}else{
									$food_avoided_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"foods_to_be_avoided" => $food_avoided_plan[$x1],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj_branch->insertData("tbl_foods_avoid",$food_avoided_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}

						if(sizeof($diet_plan)!=0){
							for($x2=0;$x2<sizeof($diet_plan);$x2++){
								$check_dite_plan = $obj_branch->selectData("id","tbl_diet_followed","where appointment_id=$c_patient_id and diet='$diet_plan[$x2]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_dite_plan)>0){}else{
									$diet_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"diet" => $diet_plan[$x2],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj_branch->insertData("tbl_diet_followed",$diet_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}
						$select_watting_pending_count = $obj->selectData("count(tbl_appointment.appointment_status) as watting_list","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.appointment_date='$c_days' and tbl_appointment.status!=0 and tbl_appointment.appointment_status=1");
						$select_watting_pending_count_row = mysqli_fetch_array($select_watting_pending_count);
						if($select_watting_pending_count_row['watting_list'] != null){
							$pending_data = $select_watting_pending_count_row['watting_list'];
						}
						$response_arr[0]['status'] = 1;
						$response_arr[0]['msg'] = 'Success';
						$response_arr[0]['pending_count'] = $pending_data;

					}else{
						$select_actual_appointment_id = $obj_branch->selectData("id","tbl_appointment","where cross_appointment_id=$patient_id");
						if(mysqli_num_rows($select_actual_appointment_id)>0){
							$select_actual_appointment_id_row = mysqli_fetch_array($select_actual_appointment_id);
							$c_patient_id = $select_actual_appointment_id_row['id'];
						}
						$food_status = array(
							"status" => 0
						);
						$obj_branch->updateData("tbl_foods_avoid",$food_status,"where appointment_id=$c_patient_id");
						$diet_status = array(
							"status" => 0
						);
						$obj_branch->updateData("tbl_diet_followed",$diet_status,"where appointment_id=$c_patient_id");
						$info_update_counsulted_b = array(
							"appointment_date" => $c_days,
							"diet_no_of_days" => $_POST['no_of_days'],
							"dite_remark" => $_POST['food_remark'],
							"main_remark" =>  $_POST['main_remark'],
							"consulted_by" => $login_id,
							"appointment_status" => 1,
							

						);
						$pending_data = 0;
						$obj->updateData("tbl_appointment",$info_update_counsulted_b,"where id=$patient_id");
						$info_update_counsulted = array(
							"appointment_date" => $c_days,
							"diet_no_of_days" => $_POST['no_of_days'],
							"dite_remark" => $_POST['food_remark'],
							"main_remark" =>  $_POST['main_remark'],
							"consulted_by" => $login_id,
							"appointment_status" => 1,
							

						);
						$pending_data = 0;
						$obj_branch->updateData("tbl_appointment",$info_update_counsulted,"where cross_appointment_id=$c_patient_id");
						if(sizeof($food_avoided_plan)!=0){
							for($x1=0;$x1<sizeof($food_avoided_plan);$x1++){
								$check_food_data = $obj_branch->selectData("id","tbl_foods_avoid","where appointment_id=$c_patient_id and foods_to_be_avoided='$food_avoided_plan[$x1]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_food_data)>0){
								}else{
									$food_avoided_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"foods_to_be_avoided" => $food_avoided_plan[$x1],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj_branch->insertData("tbl_foods_avoid",$food_avoided_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}

						if(sizeof($diet_plan)!=0){
							for($x2=0;$x2<sizeof($diet_plan);$x2++){
								$check_dite_plan = $obj_branch->selectData("id","tbl_diet_followed","where appointment_id=$c_patient_id and diet='$diet_plan[$x2]' and added_date='$days' and status=1");
								if(mysqli_num_rows($check_dite_plan)>0){}else{
									$diet_plan_array_data = array(
										"appointment_id" => $c_patient_id,
										"diet" => $diet_plan[$x2],
										"added_date" => $days,
										"added_time" => $times,
										"status" => 1
									);
									$obj_branch->insertData("tbl_diet_followed",$diet_plan_array_data);
								}
							}
							//tbl_foods_avoid
						}
						$select_watting_pending_count = $obj->selectData("count(tbl_appointment.appointment_status) as watting_list","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.doctor_id='$login_id' and tbl_appointment.appointment_date='$c_days' and tbl_appointment.status!=0 and tbl_appointment.appointment_status=1");
						$select_watting_pending_count_row = mysqli_fetch_array($select_watting_pending_count);
						if($select_watting_pending_count_row['watting_list'] != null){
							$pending_data = $select_watting_pending_count_row['watting_list'];
						}
						$select_appointment_details = $obj->selectData("id,real_branch_id,branch_id,patient_id,weight,height,blood_pressure,allergies_if_any,current_medication,present_Illness,any_surgeries,first_visit,any_metal_Implantation", "tbl_appointment", "where id = $patient_id");

						if (mysqli_num_rows($select_appointment_details) > 0) {
							$select_appointment_details_row = mysqli_fetch_array($select_appointment_details);
							$patient_id = $select_appointment_details_row['patient_id'];
							$branch_id = $select_appointment_details_row['branch_id'];
							$real_branch_id = $select_appointment_details_row['real_branch_id'];
							$weight = $select_appointment_details_row['weight'];
							$height = $select_appointment_details_row['height'];
							$blood_pressure = $select_appointment_details_row['blood_pressure'];
							$allergies_if_any = $select_appointment_details_row['allergies_if_any'];
							$current_medication = $select_appointment_details_row['current_medication'];
							$present_Illness = $select_appointment_details_row['present_Illness'];
							$first_visit = $select_appointment_details_row['first_visit'];
							$any_metal_Implantation = $select_appointment_details_row['any_metal_Implantation'];


							$branch = 5;
							$obj_branch = new query_branch();
							$select_appointment_number = $obj_branch->selectData("count(id) as token_no", "tbl_appointment", "where doctor_id = $referred_id and reffered_date = '$referred_date' and status != 0");

							if (mysqli_num_rows($select_appointment_number) > 0) {
								$select_appointment_number_row = mysqli_fetch_assoc($select_appointment_number);
								$token_no = $select_appointment_number_row['token_no'] + 1;
							} else {
								$token_no = 1;
							}

							$info_add_appointment = array(
								"patient_id" => $patient_id,
								"doctor_id" => $login_id,
								"branch_id" => $branch_id,
								"real_branch_id" => 5,
								"appointment_date" => $reffered_date,
								"appointment_taken_type" => "Offline",
								"appointment_year" => date("Y"),
								"height" => $height,
								"weight" => $weight,
								"blood_pressure" => $blood_pressure,
								"allergies_if_any" => $allergies_if_any,
								"current_medication" => $current_medication,
								"present_Illness" => $present_Illness,
								"any_surgeries" => $any_surgeries,
								"first_visit" => $first_visit,
								"any_metal_Implantation" => $any_metal_Implantation,
								"appointment_number" => $token_no,
								"appointment_taken_date" => date("d-m-Y"),
								"appointment_taken_time" => date("H:i:s"),
								"appointment_taken_id" => $login_id, // You need to define $login_id
								"appointment_status" => 1,
								"status" => 1,
								"reffer_status" => $reffered_doc_id , // You need to define $login_id
								"reffered_date" => $reffered_date,
								"appointment_fee_status" => 1,
								"reffered_doctor_branch" => $real_branch_id,
							);
							$obj_branch->insertData("tbl_appointment", $info_add_appointment);
							//print_r($obj_branch);
							if ($branch_id != 5) {
								//cross branch
								$select_last_appointment = $obj_branch->selectData("max(id) as id", "tbl_appointment", "where patient_id = $patient_id and status != 0");
								if (mysqli_num_rows($select_last_appointment) > 0) {
									$select_last_appointment_row = mysqli_fetch_assoc($select_last_appointment);
									$appmnt_id = $select_last_appointment_row['id'];
								}

								$info_add_appointment = array(
									"patient_id" => $patient_id,
									"doctor_id" => $reffered_doc_id,
									"branch_id" => $branch_id,
									"real_branch_id" => $branch_id,
									"appointment_date" => $reffered_date,
									"appointment_taken_type" => "Offline",
									"appointment_year" => date("Y"),
									"height" => $height,
									"weight" => $weight,
									"blood_pressure" => $blood_pressure,
									"allergies_if_any" => $allergies_if_any,
									"current_medication" => $current_medication,
									"present_Illness" => $present_Illness,
									"any_surgeries" => $any_surgeries,
									"first_visit" => $first_visit,
									"any_metal_Implantation" => $any_metal_Implantation,
									"appointment_number" => $token_no,
									"appointment_taken_date" => date("d-m-Y"),
									"appointment_taken_time" => date("H:i:s"),
									"appointment_taken_id" => $login_id, // You need to define $login_id
									"status" => 1,
									"cross_branch_status" => 1,
									"cross_appointment_id" => $appmnt_id,
									"cross_branch_id" => $real_branch_id,
								);
								$branch = $branch_id;
								$obj_branch = new query_branch();
								$obj_branch->insertData("tbl_appointment", $info_add_appointment);
								//print_r($obj_branch);exit();
							}
						}
						$response_arr[0]['status'] = 1;
						$response_arr[0]['msg'] = 'Success';
						$response_arr[0]['pending_count'] = $pending_data;


					}



				}
			}

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
function taken_refer_appointment($referred_id, $appointment_id, $referred_date,$login_id){
	global $obj; // Assuming you have a database connection object named $obj

}

?>