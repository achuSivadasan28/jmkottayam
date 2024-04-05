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
$times=date('h:i:s A');
$c_year = date('Y');
if(isset($_SESSION['staff_login_id'])){
	$login_id = $_SESSION['staff_login_id'];
	$staff_role = $_SESSION['staff_role'];
	$staff_unique_code = $_SESSION['staff_unique_code'];
	if($staff_role == 'staff'){
		$api_key_value = $_SESSION['api_key_value_staff'];
		$staff_unique_code = $_SESSION['staff_unique_code'];
		$Api_key = fetch_Api_Key($obj);
		$admin_live_unique_code = fetch_unique_code($obj,$login_id);
		$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
		$url_val = $_POST['url_val'];
		//echo $check_security;exit();
		if($check_security == 1){
			$name = $_POST['name'];
			$number = $_POST['number'];
			$address = $_POST['address'];
			$place = $_POST['place'];
			$age = $_POST['age'];
			$gender_data = $_POST['gender_data'];
			$doctor_data = $_POST['doctor_data'];
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
			$fVisit = $_POST['fVisit'];
			$WhatsApp = $_POST['whatsApp'];
			$branch = $_POST['branch'];
			$image_url = $_POST['image'];
			$old_patient = $_POST['old_patient'];
			$numofvisit = $_POST['numofvisit'];
			$appointment_fee = $_POST['appointment_fee'];
			$apmnt_id = $url_val;
			$filename = '';
			$image_uploadurl = "";
			if($image_url != ''){
				list($type,$data) = explode(';',$image_url);
				list(,$data) = explode(',',$data);
				$random_number = mt_rand(100000, 999999);
				$filename = $name.$days.$random_number.".jpg";
				$data = base64_decode($data);
				$real_path = realpath('../../');
				$file_path = $real_path."/assets/patientimages/$filename";
				file_put_contents($file_path,$data);
				$image_uploadurl = ($_SERVER['HTTP_PROTOCOL']??'http').'://'.($_SERVER['HTTP_HOST']);

			}
			require_once '../../../_class_branch/query_branch.php';
			$obj_branch = new query_branch();
			$total_num_slot = check_doctor_time_limit($time_slot,$obj);
			$check_doctor_already_added = check_doctor_allready_added($time_slot,$doctor_data,$url_val,$obj,$date);
			if($check_doctor_already_added == 1){
				$appointment_num = 'same';
			}else{
				$appointment_num = check_total_appointments($date,$doctor_data,$time_slot,$obj);
			}
			$appointment_data = 0;
			if($appointment_num != 'same'){
				if($total_num_slot > $appointment_num){
					$appointment_data = 1;
				}
			}else{
				$appointment_data = 1;
			}
			if($appointment_data == 1){
				$patient_id = '';
				$select_patient_id = $obj->selectData("patient_id","tbl_appointment","where id=$url_val");
				if(mysqli_num_rows($select_patient_id)>0){
					while($select_patient_id_row = mysqli_fetch_array($select_patient_id)){
						$patient_id = $select_patient_id_row['patient_id'];
					}
					if($image_url!=""){
						$info_insert_data = array(
							"name" => $name,
							"phone" => $number,
							"address" => $address,
							"place" => $place,
							"age" => $age,
							"gender" => $gender_data,
							"whatsApp" => $WhatsApp,
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
							"whatsApp" => $WhatsApp,

						);

					}
					$obj_branch->updateData("tbl_patient",$info_insert_data,"where id=$patient_id");
					require_once'../../../_class_common/query_common.php';
					$obj_common = new query_common();
					if($image_url!=""){
						$update_data = [
							"name" => $name,
							"phone" => $number,
							"address"=>$address,
							"place" => $place,
							"age" => $age,
							"gender" => $gender_data,
							"image"=>$filename,
							"image_uploadurl"=>$image_uploadurl,
						];
						$obj_common->updateData("tbl_patient",$update_data,"where unique_id = '$unique_id'");

					}else{
						$update_data = [
							"name" => $name,
							"phone" => $number,
							"address"=>$address,
							"place" => $place,
							"age" => $age,
							"gender" => $gender_data,
						];
						$obj_common->updateData("tbl_patient",$update_data,"where unique_id = '$unique_id'");
					}




					$info_add_appointment = array(
						"appointment_date" => $date,
						"appointment_year" => $c_year,
						"height" => $height,
						"weight" => $weight,
						"blood_pressure" => $blood_pressure,
						"allergies_if_any" => $allergies_if_any,
						"current_medication" => $current_medication,
						"present_Illness" => $present_illness,
						"any_surgeries" => $any_surgeries,
						"any_metal_Implantation" => $any_metal_lmplantation,
						"appointment_time_slot_id" => $time_slot,
						"updated_date_time" => $days,
						"updated_by" => $login_id,
						"appointment_fee_status" => 1,
						"first_visit" => $_POST['fVisit'],
						"appointment_fee" => $appointment_fee,
						"appointment_taken_type" => 'Offline',
						"old_patient" => $old_patient,
						"num_of_visit" => $numofvisit
					);

					$obj->updateData("tbl_appointment",$info_add_appointment,"where id=$url_val");
					$select_orginal_branch_id = $obj_common->selectData("branch_id","tbl_patient","where unique_id = '$unique_id'");
					if(mysqli_num_rows($select_orginal_branch_id)){

						$select_orginal_branch_id_row = mysqli_fetch_assoc($select_orginal_branch_id);
						$orginal_branch_id = $select_orginal_branch_id_row['branch_id'];

						$branch = $orginal_branch_id;
						require_once '../../../_class_branch/query_branch.php';
						$obj_branch = new query_branch();

						$obj_branch->updateData("tbl_appointment",$info_add_appointment,"where cross_appointment_id = $url_val and cross_branch_status = 1");

					}
					$tbl_id = "";

					$select_modepay = $obj->selectData("id as modepay_id","tbl_appointment_modeinvoice","where status !=0 and appointment_id=$apmnt_id");
					if(mysqli_num_rows($select_modepay)>0){
						$select_last_modepayid = $obj->selectData("max(id) as modepay_id","tbl_appointment_modeinvoice","where status !=0 and appointment_id=$apmnt_id");	
						while($select_last_id_row = mysqli_fetch_array($select_last_modepayid)){
							$tbl_id = $select_last_id_row['modepay_id'];
						}
					}else{
						$invoice_count = 1;
						$select_last_invoice = $obj->selectData("max(invoice_id) as invoice_id","tbl_appointment_modeinvoice","where status !=0 ");
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


						$select_last_modepayid1 = $obj->selectData("max(id) as modepay_id","tbl_appointment_modeinvoice","where status !=0 and appointment_id=$apmnt_id order by id desc limit 1");	
						if(mysqli_num_rows($select_last_modepayid1)>0){
							while($select_last_id_rows = mysqli_fetch_array($select_last_modepayid1)){
								$tbl_id = $select_last_id_rows['modepay_id'];
							}
						}
					}
					$arr = $_POST['arr'];


					for($x = 0;$x<sizeof($arr);$x++){
						$id = $arr[$x]['id'];
						$select_count = $obj->selectData(" apmnt_id","tbl_appoinment_payment","where id = $id");
						if(mysqli_num_rows($select_count)>0){
							$info_insert_apmnt_fee = array(
								"payment_id" => $arr[$x]['payment_type'],
								"payment_amnt" => $arr[$x]['payment_amnt'],
							);

							$obj->updateData("tbl_appoinment_payment",$info_insert_apmnt_fee,"where id = '$id'");	

						}else{
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

					}
					$response_arr[0]['status'] = 1;
					$response_arr[0]['msg'] = 'Success';
				}else{
					$response_arr[0]['status'] = 0;
					$response_arr[0]['msg'] = 'Something Went Wrong! Try Again';
				}
			}else{
				$response_arr[0]['status'] = 2;
				$response_arr[0]['msg'] = 'TimeSlot Not Available';
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

function check_doctor_allready_added($time_slot,$doctor_data,$url_val,$obj,$date){
	$result_data = 0;
	$check_doctor = $obj->selectData("id","tbl_appointment","where doctor_id=$doctor_data and appointment_time_slot_id=$time_slot and id=$url_val and appointment_date='$date'");
	if(mysqli_num_rows($check_doctor)>0){
		$result_data = 1;
	}
	return $result_data;
}
?>