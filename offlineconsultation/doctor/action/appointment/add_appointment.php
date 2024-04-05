<?php
session_start();
include_once '../security/unique_code.php';
include_once '../security/security.php';
require_once '../../../_class/query.php';
include_once '../SMS/sendsms.php';
require_once '../../../_class_common/query_common.php';
$response_arr = array();
$obj=new query();
$obj_common=new query_common();
date_default_timezone_set('Asia/Kolkata');
$days=date('d-m-Y');
$times=date('h:i:s A');
$c_year = date('Y');
$curr_year = date('y');
$real_branch_id = 23;
if(isset($_SESSION['doctor_login_id'])){
	$login_id = $_SESSION['doctor_login_id'];
	$doctor_role = $_SESSION['doctor_role'];
	$doctor_unique_code = $_SESSION['doctor_unique_code'];
	if($doctor_role == 'doctor'){
		$api_key_value = $_SESSION['api_key_value_doctor'];
		$doctor_unique_code = $_SESSION['doctor_unique_code'];
		$Api_key = fetch_Api_Key($obj);
		$admin_live_unique_code = fetch_unique_code($obj,$login_id);
		$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$doctor_unique_code);

		//echo $check_security;exit();
		if($check_security == 1){
			$name = $_POST['name'];
			$number = $_POST['number'];
			$address = $_POST['address'];
			$place = $_POST['place'];
			$age = $_POST['age'];
			$gender_data = $_POST['gender_data'];
			$doctor_data = $login_id;
			$date = $_POST['date'];
			$unique_id = $_POST['unique_id'];
			$time_slot = $_POST['time_slot'];
			$height = $_POST['height'];
			$weight = $_POST['weight'];
			$blood_pressure = $_POST['blood_pressure'];
			$allergies_if_any = $_POST['allergies_if_any'];
			$current_medication = $_POST['current_medication'];
			$present_illness = $_POST['present_illness'];
			$any_surgeries = $_POST['any_surgeries'];
			$any_metal_lmplantation = $_POST['any_metal_lmplantation'];
			$Fvisit = $_POST['Fvisit'];
			$whatsApp = $_POST['whatsApp'];
			$appointment_fee = $_POST['appointment_fee'];
			$old_patient = $_POST['old_patient'];
			$num_of_visit = $_POST['num_of_visit'];
			$branch_id = $_POST['branch_id'];
			$image_url = $_POST['image'];
			$filename = '';
			$image_uploadurl = '';
			if($image_url != ''){
				list($type,$data) = explode(';',$image_url);
				list(,$data) = explode(',',$data);
				$random_number = mt_rand(100000, 999999);
				$filename = $name.$days.$random_number.".jpg";
				$data = base64_decode($data);
				$real_path = realpath('../../../');
				$file_path = $real_path."/staff/assets/patientimages/$filename";
				#echo $file_path;
				#exit();
				file_put_contents($file_path,$data);
				$image_uploadurl = ($_SERVER['HTTP_PROTOCOL']??'http').'://'.($_SERVER['HTTP_HOST']);
			}
			$total_num_slot = check_doctor_time_limit($time_slot,$obj);
			$appointment_num = check_total_appointments($date,$doctor_data,$time_slot,$obj);
			if($total_num_slot!=0){
				if($total_num_slot > $appointment_num){
					if($unique_id == '0'){

						$unique_No = '';
						$select_max_code = $obj->selectData("no","tbl_patient","ORDER BY id DESC limit 1");
						if(mysqli_num_rows($select_max_code)>0){
							while($select_max_code_row = mysqli_fetch_array($select_max_code)){
								$unique_No = $select_max_code_row['no'];
							}
							$unique_No += 1;
						}else{
							$unique_No = 1;
						}
						$unique_No_id = "JMW/".$c_year."/KTM/".$unique_No;
						$unique_id = $unique_No_id;
						$info_insert_data = array(
							"code" => "JMW",
							"year" => $c_years,
							"no" => $unique_No,
							"unique_id" => $unique_No_id,
							"name" => $name,
							"phone" => $number,
							"address" => $address,
							"place" => $place,
							"age" => $age,
							"gender" => $gender_data,
							"whatsApp" => $whatsApp,
							"added_date" => $days,
							"added_time" => $times,
							"added_by" => $login_id,
							"status" => 1,
							"online_account_status" => 0,
							"patient_type" => "N",
							"branch_id" => 23,
							"image"=>$filename
						);
						$obj->insertData("tbl_patient",$info_insert_data);

						$info_insert_data_common = array(
							"code" => "JMW",
							"year" => $c_years,
							"no" => $unique_No,
							"unique_id" => $unique_No_id,
							"name" => $name,
							"phone" => $number,
							"address" => $address,
							"place" => $place,
							"age" => $age,
							"gender" => $gender_data,
							"whatsApp" => $whatsApp,
							"added_date" => $days,
							"added_time" => $times,
							"added_by" => $login_id,
							"status" => 1,
							"online_account_status" => 0,
							"patient_type" => "N",
							"branch_id" => 23,
							"image" => $filename,
							"image_uploadurl"=>$image_uploadurl,
						);
						$obj_common->insertData("tbl_patient",$info_insert_data_common);
					}else{
						if($branch_id == 0){
							$check_user_exist = $obj->selectData("id,unique_id","tbl_patient","where name='$name' and phone='$number' and status=1");
							$info_insert_data = '';
							if(mysqli_num_rows($check_user_exist)>0){
								$check_user_exist_row = mysqli_fetch_array($check_user_exist);
								$p_id = $check_user_exist_row['id'];
								$unique_id = $check_user_exist_row['unique_id'];
								if($gender_data != ''){

									if($image_url != ''){
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"gender" => $gender_data,
											"whatsApp" => $whatsApp,
											"image"=>$filename,
										);
									}else{
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"gender" => $gender_data,
											"whatsApp" => $whatsApp,
										);
									}

								}else{
									if($image_url != ""){
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"whatsApp" => $whatsApp,
											"image"=>$filename,
										);
									}else{
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"whatsApp" => $whatsApp,
										);
									}
								}
								$imagedata = [];
								if($image_url !=""){
									$imagedata = [
										"image"=>$filename,
										"image_uploadurl"=>$image_uploadurl,
									];
								}
								$obj_common->updateData("tbl_patient",$imagedata,"where unique_id='$unique_id'");	
								$obj->updateData("tbl_patient",$info_insert_data,"where id='$p_id'");
							}
						}else{
							$branch = $branch_id;
							require_once '../../../_class_branch/query_branch.php';
							$obj_branch = new query_branch();
							$check_user_exist = $obj_branch->selectData("id,unique_id","tbl_patient","where name='$name' and phone='$number' and status=1");
							$info_insert_data = '';
							if(mysqli_num_rows($check_user_exist)>0){
								$check_user_exist_row = mysqli_fetch_array($check_user_exist);
								$p_id = $check_user_exist_row['id'];
								$unique_id = $check_user_exist_row['unique_id'];
								if($gender_data != ''){
									if($image_url != ''){
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"gender" => $gender_data,
											"whatsApp" => $whatsApp,
											"image"=>$filename,
										);
									}else{
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"gender" => $gender_data,
											"whatsApp" => $whatsApp,
										);
									}
								}else{
									if($image_url != ""){
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"whatsApp" => $whatsApp,
											"image"=>$filename,
										);
									}else{
										$info_insert_data = array(
											"name" => $name,
											"phone" => $number,
											"address" => $address,
											"place" => $place,
											"age" => $age,
											"whatsApp" => $whatsApp,
										);
									}
								}
								$imagedata = [];
								if($image_url !=""){
									$imagedata = [
										"image"=>$filename,
										"image_uploadurl"=>$image_uploadurl,
									];
								}
								$obj_common->updateData("tbl_patient",$imagedata,"where unique_id='$unique_id'");
								$obj_branch->updateData("tbl_patient",$info_insert_data,"where id='$p_id'");
							}
							/**else{		
			if($gender_data != ''){
	$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
		"gender" => $gender_data,
		"whatsApp" => $whatsApp,
	);
		}else{
	$info_insert_data = array(
		"name" => $name,
		"phone" => $number,
		"address" => $address,
		"place" => $place,
		"age" => $age,
		"whatsApp" => $whatsApp,
	);
		}
		$obj_branch->updateData("tbl_patient",$info_insert_data,"where unique_id='$unique_id'");
		}**/

						}


					}

					//add appointment
					if($branch_id == 0){
						$patient_id = 0;
						$select_patient_id = $obj->selectData("id","tbl_patient","where unique_id='$unique_id'");
						if(mysqli_num_rows($select_patient_id)>0){
							while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
								$patient_id = $select_patient_id_row['id'];
							}
						}
					}else{
						$branch = $branch_id;
						$obj_branch = new query_branch();
						$patient_id = 0;
						$select_patient_id = $obj_branch->selectData("id","tbl_patient","where unique_id='$unique_id'");
						if(mysqli_num_rows($select_patient_id)>0){
							while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
								$patient_id = $select_patient_id_row['id'];
							}
						}
					}
					//$select_admission_fee = $obj->selectData("appointment_fee","tbl_appointment_fee","where status=1");
					//$select_admission_fee_row = mysqli_fetch_array($select_admission_fee);
					//$admission_fee = $select_admission_fee_row['appointment_fee'];
					$token_num = 0;
					$select_last_num_this_date = $obj->selectData("max(appointment_number) as appointment_number","tbl_appointment","where appointment_date='$date' and status!=0 and doctor_id=$doctor_data");
					$select_last_num_this_date_row = mysqli_fetch_array($select_last_num_this_date);
					if($select_last_num_this_date_row['appointment_number'] != null){
						$token_num = $select_last_num_this_date_row['appointment_number'];
					}
					$token_num +=1;
					$cross_status = 0;
					if($branch_id == 0){
						$cross_status = 1;
						$branch_id = 23;
					}

					$new_patient_id = 0;
					$check_patient_data = $obj->selectData("patient_id","tbl_appointment","where appointment_date='$date' and status!=0 ORDER BY id DESC limit 1");
					if(mysqli_num_rows($check_patient_data)>0){
						$check_patient_data_row = mysqli_fetch_array($check_patient_data);
						$new_patient_id = $check_patient_data_row['patient_id'];
					}
					if($new_patient_id != $patient_id){
						$info_add_appointment = array(
							"patient_id" => $patient_id,
							"doctor_id" =>$doctor_data,
							"branch_id" => $branch_id,
							"real_branch_id" => $real_branch_id,
							"appointment_date" => $date,
							"appointment_taken_type" => "Offline",
							"appointment_year" => $c_year,
							"height" => $height,
							"weight" => $weight,
							"blood_pressure" => $blood_pressure,
							"allergies_if_any" => $allergies_if_any,
							"current_medication" => $current_medication,
							"present_Illness" => $present_illness,
							"any_surgeries" => $any_surgeries,
							"first_visit" => $Fvisit,
							"any_metal_Implantation" => $any_metal_lmplantation,
							"appointment_number" => $token_num,
							"appointment_taken_date" => $days,
							"appointment_taken_time" => $times,
							"appointment_taken_by" => 'doctor',
							"appointment_taken_id" => $login_id,
							"old_patient" =>$old_patient,
							"num_of_visit" =>$num_of_visit,
							"appointment_fee" => $appointment_fee,
							"appointment_fee_type" => 'Offline',
							"appointment_fee_status" => 1,
							"appointment_time_slot_id" => $time_slot,
							"status" => 1,
						);
						$obj->insertData("tbl_appointment",$info_add_appointment);
					}
					//tbl_appointment_gone_details

					if($appointment_fee != 0){
						//$apmnt_id=0;
						$select_apnmnt_id = $obj->selectData("MAX(id) as appointment_id","tbl_appointment","where patient_id='$patient_id' and status !=0 order by id desc limit 1");
						if(mysqli_num_rows($select_apnmnt_id)>0){
							while($select_appoinment_id_row = mysqli_fetch_array($select_apnmnt_id)){
								$apmnt_id = $select_appoinment_id_row['appointment_id'];
							}
						}

						//add appointment in org barnch and hide it
						if($cross_status == 0){
							$info_add_appointment = array(
								"patient_id" => $patient_id,
								"doctor_id" =>$doctor_data,
								"branch_id" => $branch_id,
								"real_branch_id" => $branch_id,
								"appointment_date" => $date,
								"appointment_taken_type" => "Offline",
								"appointment_year" => $c_year,
								"height" => $height,
								"weight" => $weight,
								"blood_pressure" => $blood_pressure,
								"allergies_if_any" => $allergies_if_any,
								"current_medication" => $current_medication,
								"present_Illness" => $present_illness,
								"any_surgeries" => $any_surgeries,
								"first_visit" => $Fvisit,
								"any_metal_Implantation" => $any_metal_lmplantation,
								"appointment_number" => $token_num,
								"appointment_taken_date" => $days,
								"appointment_taken_time" => $times,
								"appointment_taken_by" => 'doctor',
								"appointment_taken_id" => $login_id,
								"old_patient" =>$old_patient,
								"num_of_visit" =>$num_of_visit,
								"appointment_fee" => $appointment_fee,
								"appointment_fee_type" => 'Offline',
								"appointment_fee_status" => 1,
								"appointment_time_slot_id" => $time_slot,
								"status" => 1,
								"cross_branch_status" => 1,
								"cross_appointment_id" => $apmnt_id,
								"cross_branch_id" => $real_branch_id,
							);
							$obj_branch->insertData("tbl_appointment",$info_add_appointment);
						}

						$invoice_count = 1;
						$select_last_invoice = $obj->selectData("max(invoice_id) as invoice_id","tbl_appointment_modeinvoice","where status !=0 order by id desc limit 1");
						if(mysqli_num_rows($select_last_invoice)>0){
							while($select_lastinvoice_id_row = mysqli_fetch_array($select_last_invoice)){
								$invoice_count += $select_lastinvoice_id_row['invoice_id'];

							}
						}


						$invoice_compaied = 'JM-AT'.$curr_year.'00'.$invoice_count;		

						$info_insert_apmnt_invoicepay = array(
							"appointment_id" =>$apmnt_id,
							"patient_id" => $patient_id,
							"invoice_id" =>$invoice_count,
							"invoice_date" => $c_year,
							"invoice_campain"=>$invoice_compaied,
							"addedDate"=>$days,
							"addedTime"=>$times,
							"status"=>1,
						);

						$obj->insertData("tbl_appointment_modeinvoice",$info_insert_apmnt_invoicepay);	


						$select_last_modepayid = $obj->selectData("max(id) as modepay_id","tbl_appointment_modeinvoice","where status !=0 and appointment_id=$apmnt_id order by id desc limit 1");	
						if(mysqli_num_rows($select_last_modepayid)>0){
							while($select_last_id_row = mysqli_fetch_array($select_last_modepayid)){
								$tbl_id = $select_last_id_row['modepay_id'];
							}
						}



						$arr = $_POST['arr'];


						for($x = 0;$x<sizeof($arr);$x++){

							$info_insert_apmnt_fee = array(
								"payment_id" => $arr[$x]['payment_type'],
								"tbl_apmnt_mode_payid" =>$tbl_id,
								"apmnt_id" => $apmnt_id,
								"patient_id" =>$patient_id,
								"payment_amnt" =>$arr[$x]['payment_amnt'],
								"addedDate"=>$days,
								"addedTime"=>$times,
								"status"=>1,
							);
							$obj->insertData("tbl_appoinment_payment",$info_insert_apmnt_fee);	
						}
						$response_arr[0]['status'] = 1;
						$response_arr[0]['msg'] = 'Success';
					}else{
						$select_apnmnt_id = $obj->selectData("MAX(id) as appointment_id","tbl_appointment","where patient_id='$patient_id' and status !=0 order by id desc limit 1");
						if(mysqli_num_rows($select_apnmnt_id)>0){
							while($select_appoinment_id_row = mysqli_fetch_array($select_apnmnt_id)){
								$apmnt_id = $select_appoinment_id_row['appointment_id'];

							}
						}
						if($cross_status == 0){	
							$info_add_appointment = array(
								"patient_id" => $patient_id,
								"doctor_id" =>$doctor_data,
								"branch_id" => $branch_id,
								"real_branch_id" => $branch_id,
								"appointment_date" => $date,
								"appointment_taken_type" => "Offline",
								"appointment_year" => $c_year,
								"height" => $height,
								"weight" => $weight,
								"blood_pressure" => $blood_pressure,
								"allergies_if_any" => $allergies_if_any,
								"current_medication" => $current_medication,
								"present_Illness" => $present_illness,
								"any_surgeries" => $any_surgeries,
								"first_visit" => $Fvisit,
								"any_metal_Implantation" => $any_metal_lmplantation,
								"appointment_number" => $token_num,
								"appointment_taken_date" => $days,
								"appointment_taken_time" => $times,
								"appointment_taken_by" => 'doctor',
								"appointment_taken_id" => $login_id,
								"old_patient" =>$old_patient,
								"num_of_visit" =>$num_of_visit,
								"appointment_fee" => $appointment_fee,
								"appointment_fee_type" => 'Offline',
								"appointment_fee_status" => 1,
								"appointment_time_slot_id" => $time_slot,
								"status" => 1,
								"cross_branch_status" => 1,
								"cross_appointment_id" => $apmnt_id,
								"cross_branch_id" => $real_branch_id,
							);
							$obj_branch->insertData("tbl_appointment",$info_add_appointment);
						}

						/**$info_appointment_common = array(
		"patient_id" => $patient_id,
		"patient_unique_id" => $unique_id,
		"appointment_id" => $apmnt_id,
		"branch_id" => $branch_id,
		"consulted_branch" => 5,
		"appointment_type" => "offline",
		"added_date" => $days,
		"added_time" => $times,
		"status" => 1
);
$obj_common->insertData("tbl_appointment_gone_details",$info_appointment_common);
}**/



						//sent_sms($number,$name,$days,$unique_id,$appointment_fee);
						//$sms_result = appointment_success_sms($number,$name,$token_num,$date);
						//add surgical history
						$check_patient_appointment_count = $obj->selectData("count(id) as id","tbl_appointment","where patient_id=$patient_id and status!=0");
						$check_patient_appointment_count_row = mysqli_fetch_array($check_patient_appointment_count);
						if($check_patient_appointment_count_row['id'] != null){
							if($check_patient_appointment_count_row['id'] > 1){
								if($appointment_fee != 0){
									$info_insert_data_patient = array(
										"patient_type" => 'NR',
									);
									$obj_branch->updateData("tbl_patient",$info_insert_data_patient,"where unique_id='$unique_id'");
								}


							}
						}
						if($any_surgeries != ''){
							$info_surgical_history = array(
								"patient_id" => $unique_id,
								"comment" => $any_surgeries,
								"added_date" => $days,
								"added_time" => $times,
								"added_by" => $login_id,
								"status" => 1
							);
							$obj_branch->insertData("tbl_surgical_history",$info_surgical_history);
						}

						//medical history
						if($current_medication != ''){
							$info_medication_history = array(
								"patient_id" => $unique_id,
								"comment" => $current_medication,
								"added_date" => $days,
								"added_time" => $times,
								"added_by" => $login_id,
								"status" => 1
							);
							$obj_branch->insertData("tbl_medical_history",$info_medication_history);
						}
						$response_arr[0]['status'] = 1;
						$response_arr[0]['msg'] = 'Success';
					}
				}else{
					$response_arr[0]['status'] = 2;
					$response_arr[0]['msg'] = 'TimeSlot Not Available';
				}
			}else{
				$response_arr[0]['status'] = 2;
				$response_arr[0]['msg'] = 'TimeSlot Error';
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

function check_total_appointments($date,$doctor_data,$time_slot,$obj){
	$total_num_appointment = 0;
	$check_total_appointments_data = $obj->selectData("count(id) as id","tbl_appointment","where doctor_id=$doctor_data and appointment_date='$date' and appointment_time_slot_id=$time_slot and status!=0");
	if(mysqli_num_rows($check_total_appointments_data)>0){
		$check_total_appointments_row = mysqli_fetch_array($check_total_appointments_data);
		if($check_total_appointments_row['id'] != null){
			$total_num_appointment  = $check_total_appointments_row['id'];
		}
	}
	return $total_num_appointment;
}

function sent_sms($mob,$username,$date,$reg_num,$appointment_fee){
	$msg = "Hi $username!

This confirms that your appointment has been successfully scheduled at Johnmarians Wellness Hospital. Please find the details below:

Date: $date
Registration number : $reg_num
Registration Fees: $appointment_fee

We look forward to seeing you soon!

Best regards,
Johnmarians Wellness Hospital";

	$code = '+91';
	$new_mob = '';
	if(strpos($mob, $code) !== false){
		$new_mob = $mob;
	} else{
		$code_sym = "91";
		$code_symb = "+";
		if(strpos($mob, $code_sym) !== false){
			if(strpos($mob, $code_sym) !=0){
				$new_mob = $code.$mob;
			}else{
				$new_mob = $code_symb.$mob;
			}
		}else{
			$new_mob = $code.$mob;
		}

	}
	$sender_id = "JMWELL";
	$ch = curl_init();
	$SINO = 'HXIN1718319102IN';
	$template_id = '1207167964018863670';
	$api_key = 'A9c926ea892613838ec202f9d1d1ab25b';
	curl_setopt($ch, CURLOPT_URL, "https://api.kaleyra.io/v1/$SINO/messages");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "to=$new_mob&type=MKT&sender=$sender_id&body=$msg&template_id=$template_id");

	$headers = array();
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = "Api-Key: $api_key";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	$sms_result = 0;
	if (curl_errno($ch)) {
		//echo 'Error:' . curl_error($ch);
	}else{

	}
	curl_close($ch);
}
?>