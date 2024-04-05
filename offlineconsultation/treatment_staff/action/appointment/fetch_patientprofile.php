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
	
$url_val = $_POST['patient_id'];

 $fetch_patient = $obj->selectData("id,name,phone,age,place","tbl_patient","where id= '$url_val'");
	$patient_details= mysqli_fetch_assoc($fetch_patient);
$response_arr[0]['patient_name']=$patient_details['name'];
$response_arr[0]['patient_phn']=$patient_details['phone'];
$response_arr[0]['patient_age']=$patient_details['age'];
$response_arr[0]['patient_place']=$patient_details['place'];

$select_bmi_details = $obj->selectData("weight,height,diet_no_of_days,dite_remark","tbl_appointment","where patient_id=$url_val order by id desc limit 1");
				//and appointment_status=1 and status!=0
				if(mysqli_num_rows($select_bmi_details)>0){
					while($select_appointment_details_row = mysqli_fetch_array($select_bmi_details)){
					$height = $select_appointment_details_row['height'];
					$weight = $select_appointment_details_row['weight'];
						$response_arr[0]['height'] = $height;
						$response_arr[0]['weight'] = $weight;
					$response_arr[0]['diet_no_of_days'] = $select_appointment_details_row['diet_no_of_days'];
					$response_arr[0]['dite_remark'] = $select_appointment_details_row['dite_remark'];
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
					}
				}


	
	 $select_todays_appointment = $obj->selectData("tbl_appointment.id,tbl_appointment.appointment_status,tbl_appointment.doctor_id,tbl_appointment.appointment_date,tbl_appointment.patient_id,tbl_appointment.appointment_number,tbl_appointment.height,tbl_appointment.weight,tbl_appointment.blood_pressure,tbl_appointment.allergies_if_any,tbl_appointment.current_medication,tbl_appointment.present_Illness,tbl_appointment.any_surgeries,tbl_appointment.any_metal_Implantation,tbl_patient.unique_id,tbl_patient.name,tbl_patient.phone,tbl_patient.address,tbl_patient.place,tbl_patient.age,tbl_patient.gender,tbl_patient.id as patient_id","tbl_appointment inner join tbl_patient on tbl_appointment.patient_id=tbl_patient.id","where tbl_appointment.appointment_status=2 and tbl_appointment.patient_id=$url_val");
	if(mysqli_num_rows($select_todays_appointment)>0){
		$response_arr[0]['data_status'] = 1;
		
		$x = 0;
		while($select_todays_appointment_row = mysqli_fetch_array($select_todays_appointment)){
			
		$doctor_id=$select_todays_appointment_row['doctor_id'];
			$appointment_id=$select_todays_appointment_row['id'];
			
				$fetch_doctor = $obj->selectData("doctor_name","tbl_doctor","where login_id= '$doctor_id'");
	$doc= mysqli_fetch_assoc($fetch_doctor);
$doctor_name=$doc['doctor_name'];
			
				$fetch_count = $obj->selectData("count(id) as id","tbl_appointment","where patient_id ='$url_val' and appointment_status ='2'");
	$total_count= mysqli_fetch_assoc($fetch_count);
$total_number_visit=$total_count['id'];
			
			$response_arr[$x]['id'] = $select_todays_appointment_row['id'];
			$response_arr[$x]['patient_id'] = $select_todays_appointment_row['patient_id'];
			$response_arr[$x]['appointment_number'] = $select_todays_appointment_row['appointment_number'];
			$response_arr[$x]['appointment_date'] = $select_todays_appointment_row['appointment_date'];
			$patient_id = $select_todays_appointment_row['patient_id'];
			$response_arr[$x]['doctor_name'] =  $doctor_name;
			$response_arr[$x]['total_number_visit'] =  $total_number_visit;
			$response_arr[$x]['unique_id'] = $select_todays_appointment_row['unique_id'];
			$response_arr[$x]['name'] = $select_todays_appointment_row['name'];
			$response_arr[$x]['phone'] = $select_todays_appointment_row['phone'];
			$response_arr[$x]['address'] = $select_todays_appointment_row['address'];
			$response_arr[$x]['place'] = $select_todays_appointment_row['place'];
			$response_arr[$x]['age'] = $select_todays_appointment_row['age'];
			$response_arr[$x]['gender'] = $select_todays_appointment_row['gender'];
			$response_arr[$x]['weight'] = $select_todays_appointment_row['weight'];
			$response_arr[$x]['blood_pressure'] = $select_todays_appointment_row['blood_pressure'];
			$response_arr[$x]['allergies_if_any'] = $select_todays_appointment_row['allergies_if_any'];
			$response_arr[$x]['current_medication'] = $select_todays_appointment_row['current_medication'];
			$response_arr[$x]['present_Illness'] = $select_todays_appointment_row['present_Illness'];
			$response_arr[$x]['any_surgeries'] = $select_todays_appointment_row['any_surgeries'];
			$response_arr[$x]['any_metal_Implantation'] = $select_todays_appointment_row['any_metal_Implantation'];
			$response_arr[$x]['email'] = '';
			$response_arr[$x]['appointment_status'] = $select_todays_appointment_row['appointment_status'];
			
			$select_appointment_details = $obj->selectData("weight,height,diet_no_of_days,dite_remark","tbl_appointment","where id=$appointment_id");
				//and appointment_status=1 and status!=0
				if(mysqli_num_rows($select_appointment_details)>0){
					while($select_appointment_details_row = mysqli_fetch_array($select_appointment_details)){
					$height = $select_appointment_details_row['height'];
					$weight = $select_appointment_details_row['weight'];
						$response_arr[$x]['height'] = $height;
						$response_arr[$x]['weight'] = $weight;
					$response_arr[$x]['diet_no_of_days'] = $select_appointment_details_row['diet_no_of_days'];
					$response_arr[$x]['dite_remark'] = $select_appointment_details_row['dite_remark'];
					$response_arr[$x]['BMI'] = '';
					$response_arr[$x]['weight_cat'] = '';
					if($height != '' && $weight != ''){
					$height_in_m = $height/100;
					$height_in_m *= $height_in_m;
					$BMI = round($weight/$height_in_m,2);
					$response_arr[$x]['BMI'] = $BMI;
						if($BMI < 18.5){
								$response_arr[$x]['weight_cat'] = 'UnderWeight';
								}else if($BMI >=18.5 && $BMI <= 24.9){
								$response_arr[$x]['weight_cat'] = 'Healthy Weight';
							}else if($BMI >= 25 && $BMI <=29.9){
								$response_arr[$x]['weight_cat'] = 'OverWeight';
							}else if($BMI >=30 && $BMI <= 34.9){
								$response_arr[$x]['weight_cat'] = 'Obese (Class1)';
							}else if($BMI >= 35 && $BMI <= 39.9){
								$response_arr[$x]['weight_cat'] = 'Severely Obese (Class11)';
							}else if($BMI >= 40 && $BMI <= 49.9){
								$response_arr[$x]['weight_cat'] = 'Morbidly Obese (Class111)';
							}else if($BMI >=50){
								$response_arr[$x]['weight_cat'] = 'Super Obese (Class111)';
							}
					}
					}
				}
			/*$select_bmi_history = $obj->selectData("height,weight,appointment_date","tbl_appointment","where patient_id='$url_val'");
			if(mysqli_num_rows($select_bmi_history)>0){
				
			}*/
			/*$select_bmi_history = $obj->selectData("height,weight,appointment_date","tbl_appointment","where patient_id=$patient_id");
			if(mysqli_num_rows($select_bmi_history)>0){
				$x1 = 0;
				while($select_bmi_history_row = mysqli_fetch_array($select_bmi_history)){
					if($select_bmi_history_row['height'] !=''){
					$response_arr[$x]['BMI'][$x1]['height'] = $select_bmi_history_row['height'];
					$height = $select_bmi_history_row['height'];
					$weight = $select_bmi_history_row['weight'];
					$height_in_m = $height/100;
					$BMI = round($weight/$height_in_m,2);
					$response_arr[$x]['BMI'][$x1]['weight'] = $select_bmi_history_row['weight'];
					$response_arr[$x]['BMI'][$x1]['BMIVal'] = $BMI;
					$appointment_date = $select_bmi_history_row['appointment_date'];
					$appointment_date_new = date('d-m-Y',strtotime($appointment_date));
					$response_arr[$x]['BMI'][$x1]['appointment_date_new'] = $appointment_date_new;
					$x1++;
					}
				}
			}
			$pending_count = 1;
			if($select_todays_appointment_row['appointment_status'] ==1){
				$waiting_count++;
			}*/
			$x++;
		}
	}else{
		$response_arr[0]['data_status'] = 0;
		$response_arr[0]['total_number_visit'] = 0;
	}
	
echo json_encode($response_arr);


/*
function check_doctor_time_limit($time_slot,$obj){
	$total_num_slot = 0;
	$select_time_slot_id = $obj->selectData("time_slot_id","tbl_doctor_appointment_slot","where id=$time_slot and status!=0");
	if(mysqli_num_rows($select_time_slot_id)>0){
		$select_time_slot_id_row = mysqli_fetch_array($select_time_slot_id);
		$time_solot_id = $select_time_slot_id_row['time_slot_id'];
		$select_max_appointments = $obj->selectData("total_num_slot","tbl_appointment_slot","where id=$time_solot_id and status!=0");
		if(mysqli_num_rows($select_max_appointments)){
			$select_max_appointments_row = mysqli_fetch_array($select_max_appointments);
			$total_num_slot = $select_max_appointments_row['total_num_slot'];
			
		}
	}
	return $total_num_slot;
}

/*function check_total_appointments($url_val,$obj){
	$total_num_appointment = 0;
	$check_total_appointments_data = $obj->selectData("count(id) as id","tbl_appointment","where patient_id ='$url_val' and appointment_status ='2'");
	if(mysqli_num_rows($check_total_appointments_data)>0){
		$check_total_appointments_row = mysqli_fetch_array($check_total_appointments_data);
		if($check_total_appointments_row['id'] != null){
			$total_num_appointment  = $check_total_appointments_row['id'];
		}
	}
	return $total_num_appointment;
}*/
?>