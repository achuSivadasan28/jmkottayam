<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['doctor_login_id']) and $_SESSION['doctor_role'] == 'doctor'){
$login_id = $_SESSION['doctor_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_doctor'];
$staff_unique_code = $_SESSION['doctor_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
$head = '';
$address = '';
$phn_details = '';
$gmail = '';
$website = '';
$select_address_data = $obj->selectData("head,address,phn_details,gmail,website","tbl_address","");
if(mysqli_num_rows($select_address_data)>0){
	while($select_address_data_row = mysqli_fetch_array($select_address_data)){
		$head = $select_address_data_row['head'];
		$address = $select_address_data_row['address'];
		$phn_details = $select_address_data_row['phn_details'];
		$gmail = $select_address_data_row['gmail'];
		$website = $select_address_data_row['website'];
	}
}
	$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

	
<style>
    #suggestionBoxId {
      border: 1px solid grey;
      border-radius: 10px;
      width: 100%;
      display: flex;
      flex-direction: column;
      cursor: pointer;
      max-height: 200px;
      overflow-y: auto;
    }
    #one{
        display: flex;
        justify-content: center;
    }
	pre { 
		white-space: pre;
	}

  </style>	
	
<body>
    <div class="printPage">
			<div class="printPageHead">
				<h1>JOHNMARIAN'S</h1>
				<p>A Speciality Health Care</p>
			</div>
			<div class="printPageProfile">
				<div class="printPageProfileRow">
					<div class="name" id="name_data"></div>
					<div class="gender">Gender : <b id="gender_data"></b></div>
					<div class="age">Age : <b id="age_data"></b></div>
					<div class="id">ID : <b id="unique_id">JMW/2022/3</b></div>
					<div class="totalVisit">Total Visit : <b id="total_visit">3</b></div>
					<div class="FirstVisit">First Visit : <b id="first_visit"></b></div>
					<div class="LastVisit">Last Visit : <b id="last_visit"></b></div>
					<div class="LastVisit2 p_height">Height : <b id="height_data"></b></div>
					<div class="LastVisit2 p_weight">Weight : <b id="weight_data"></b></div>
					<div class="LastVisit2 p_bmi">BMI : <b id="bmi_data">s</b></div>
					<div class="LastVisit2 p_category">Category : <b id="weight_cat"></b></div>
					
					
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
				</div>
			</div>
			<div class="printPageBody">
				<div class="printPageBodyRow1">
					<div class="printPageBox">
						<h2>Our Doctors</h2>
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<div class="doctorDetailBox dynamic_doctor">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<!--<div class="doctorDetailBox dynamic_doctor">
							<ul>
								<li><b>Dr Reshma Biju</b></li>
								<li>BNYS, DNHE</li>
								<li>TCMC 380</li>
								<li>Naturopathy Yoga Physician</li>
							</ul>
						</div>-->
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
					<div class="printPageBox prescription_data_print">
						<h2>Prescription</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.	</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
					<div class="printPageBox complaints_data_print">
						<h2>Complaints</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
				</div>
				<div class="printPageBodyRow1">
					<div class="printPageBox medical_history_print">
						<h2>Medical History</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
					<div class="printPageBox Investigations_data">
						<h2>Investigations</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
				</div>
				<div class="printPageBodyRow1">
					<div class="printPageBox">
						<h2>Diet to be followed / പാലിക്കേണ്ട ഭക്ഷണക്രമം.</h2>
						<ul class="food_to_follow">
						<!--	<li>Weight Management Diet</li>
							<li>Low Protein Diet</li>
							<li>Low Carb Diet</li>-->
							
							<!--<li><b>No. of Days : 10 Days</b></li>-->
						</ul>
					</div>
					<div class="printPageBox">
						<h2>Foods to be avoided / ഒഴിവാക്കേണ്ടവ.</h2>
						<ul class="food_to_avoid">
							<!--<li>Milk, Milk with tea, Ice Cream</li>
							<li>Wheat, Maida, Oats, Rava, Atta</li>
							<li>Soy Products</li>
							<li>Coffee</li>-->
						</ul>
					</div>
				</div>
				<div class="printPageBodyRow2">
					<div class="printPageBox">
						<h2>Remark</h2>
						<p id="all_remark"></p>
					</div>
				</div>
			</div>
			<div class="printPageFooter">
				<h1><?php echo $head;?></h1>
				<p><i class="uil uil-location-point"></i><?php echo $address;?><br><i class="uil uil-phone-alt"></i> <?php echo $phn_details;?> <i class="uil uil-envelope"></i> <?php echo $gmail;?> <i class="uil uil-globe"></i> <?php echo $website;?></p>
			</div>
		</div>
    <main>
		<!-- toaster-->
<div class="toaster">
	<div class="toasterIcon successTost" style="display:none"><i class="uil uil-check"></i></div>
<!--<div class="toasterIcon"><i class="uil uil-check"></i></div>-->
	<div class="toasterIcon errorTost" style="display:none"><i class="uil uil-times"></i></div>
	<div class="toasterMessage"></div>
</div>
<!-- toaster close -->

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->

        <!-- delete alert  -->
        <div class="deleteAlert">
            <div class="deleteAlertMian">
                <div class="deleteAlertThumbnail">
                    <img src="assets/images/icon/delete-alert.gif" alt="">
                </div>
                <div class="deleteAlertContent">
                    <p>Do you want to Delete ?</p>
                    <div class="deleteAlertBtnArea">
                        <div class="closedeleteAlert">No</div>
                        <div class="confirmdeleteAlert">Delete</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete alert close -->

        
        
        <!-- dashboard  -->
        <section id="dashboard">

            <!-- nav -->
            <?php
                include "assets/includes/nav/nav.php";
            ?>
            <!-- nav close -->

            <!-- sidemenu  -->
            <?php
                include "assets/includes/sidemenu/sidemenu.php";
            ?>
            <!-- sidemenu close -->

            <!-- canvas  -->
            <div class="canvas">
            
              
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
					<div class="consultingWindowNextSextion">
						<div style="display:none" class="consultingWindowNextSextionBox secound_consultingNextBtn1">
							<p id="secound_staff_name"></p>
							<button style="border: none; outline: none;" class="consultingNextBtn secound_consultingNextBtn button_disabled_status" disabled>Next</button>
						</div>
					</div>
					<div class="consultingWindowHead">
						<div class="currentConsulting currentConsulting_patient" style="display:none">
							<div class="currentConsultinghead">
								<h1 id="current_patient_name"></h1>
								<p id="age_details"></p>
								<div class="UniqueId">
									<span id="current_patient_uniqueid"></span>
								</div>
								<!--style="display:none"-->
								<a  href="#" class="currentConsultingheadPrintBtn" style="display:none"><i class="uil uil-print"></i> Print</a>
								
								<span id="first_v" style="border:.5px solid grey; padding:5px;border-radius:5px;color:grey;font-size:14px;">First visit :<span id='dofv'></span></span>
								<!--onclick="window.print()" -->
							</div>
							<div class="currentConsultingBody">
								<div class="currentConsultingBox">
									<div class="formGroup" style="display: none;">
										<span>Phone Number</span>
										<p id="current_patient_phn"></p>
									</div>
									<div class="formGroup">
										<span>Present Illness</span>
										<p id="present_Illness"></p>
									</div>
									<div class="formGroup" style="display: none;">
										<span>Age</span>
										<p id="current_patient_age"></p>
									</div>
									<div class="formGroup">
										<span>Address</span>
										<p id="current_patient_address"></p>
									</div>
									<div class="formGroup">
										<span>Allergies if any</span>
										<p id="allergies_if_any"></p>
									</div>
									
									<div class="formGroup">
										<span>Any Metal Implantation</span>
										<p id="any_metal_Implantation"></p>
									</div>
									<!--<div class="formGroup">
										<span>Place</span>
										<p id="current_patient_place"></p>
									</div>-->
								</div>
								<div class="buttonAreaList">
									<!--<button class="currentConsultingKeepWaitBtn">Keep Wait</button>-->
									<button class="consultedBtn">
										<span id="text" class="consult_btn active_btn">Consulted</span>
										<span id="loading" class="consult_btn"></span>
										<span id="done" class="consult_btn">Done</span>
									</button>
								</div>
								<!--<div class="currentConsultingBox">
									<div class="formGroup" style="display: none;">
										<span>Gender</span>
										<p id="current_patient_gender"></p>
									</div>
								</div>
								<div class="currentConsultingBoxBtnArea">
									<div class="addCommentsBtn">Add Prescription</div>
									<div class="currentConsultingKeepWaitBtn">Keep Wait</div>
									<button class="consultedBtn">
										<span id="text">Consulted</span>
										<span id="loading"></span>
										<span id="done">Done</span>
									</button>
								</div>-->
							</div>
						</div>
						<div class="consultingWindowTable" style="display:none">
							<h1>BMI History</h1>
							<div class="consultingWindowTableBox">
								<table>
									<thead>
										<tr>
											<th>Visit</th>
											<th>Date</th>
											<th>Height</th>
											<th>Weight</th>
											<th>BMI</th>
											<th>Blood Pressure</th>
											<th>Category</th>
										</tr>
									</thead>
									<tbody class="bmiTable">
										<!--<tr>
											<td data-label="1st Visit">
												<p>1</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>2</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>3</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>4</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>5</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>6</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>7</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>8</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>9</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>
										<tr>
											<td data-label="1st Visit">
												<p>10</p>
											</td>
											<td data-label="Date">
												<p>12-09-2022</p>
											</td>
											<td data-label="Weight">
												<p>80 KG</p>
											</td>
											<td data-label="BMI">
												<p>1</p>
											</td>
										</tr>-->
									</tbody>
								</table>
							</div>
						</div>
					</div>

        <!-- comments popup -->
        <div class="commentsPopup" style="display:none">
			<!--<div class="commentsPopupHead">
				<h1>Prescription</h1>
				<div class="closeCommentsPopupBtn">Close</div>
			</div>-->
            <div class="commentsPopupMain" style="border-top: none; margin-top: 0; padding-top: 0;">
				<div class="commentsPopupTabBtnArea">
					<button class=" tablink active" onclick="openCity2(event,'tab1')" style="margin-top: 0;">Prescription</button>
					<!--<button class="tablink" onclick="openCity2(event,'tab2')">Comments</button>-->
					<button class="tablink" onclick="openCity2(event,'tab4')" style="margin-top: 0;">Lab</button>
					<button class="tablink" onclick="openCity2(event,'tab5')" style="margin-top: 0;">Treatment</button>
					<button class="tablink" onclick="openCity2(event,'tab3')" style="margin-top: 0;">History</button>
					<!--<button style="margin-left: auto; margin-top: 0;" class="tablink" onclick="openCity2(event,'tab4')">Medical History</button>
					<button style=" margin-top: 0;" class="tablink" onclick="openCity2(event,'tab5')">Surgical History</button>-->
				</div>
				<div id="tab1" class="commentsPopupTabBox">
					<div class="commentsPopupTabBoxMain" style="width: 100%; display: flex; justify-content: space-between;">
					<div class="commentsPopupPrevious">
						
						<div class="prescriptionHistoryList">
							<div class="prescriptionHistoryListMain prescriptionHistoryListMain_new">
								<!--<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>-->
							</div>
						</div>
						
						<h2 style="margin-top:50px;">Prescription</h2>
						<div class="commentsPopupPrescriptionForm">
							<form id="prescription_data_form">
								<div class="commentsPopupPrescriptionFormMain">
									<div class="tempPanel prescription_data main_prescription_div">
										<div class="formGroup">
											<label>Medicine</label>
											<div class="formSelect">
												<select name="" class="medicine_details">
												</select>
												<span id="stock_error_msg" style="color:red"></span>
												<input type="hidden" class="position" value=1>
											</div>
											<span id="medicine_error" style="color:red"></span>
										</div>
										<div class="formGroup3">
											<div class="checkBoxArea2">
												<label><i class="uil uil-sun"></i></label>
												<div class="inputCountDropDown">
													<input type="text" class="morning_data iputCountDropBtn" value="1">
													<div class="inputCountDropDownPopup">
														<ul>
															<li>0</li>
															<li>1</li>
															<li>2</li>
															<li>3</li>
															<li>4</li>
															<li>5</li>
															<li>6</li>
															<li>7</li>
															<li>8</li>
															<li>9</li>
															<li>10</li>
															<li>11</li>
															<li>12</li>
															<li>13</li>
															<li>14</li>
															<li>15</li>
														</ul>
													</div>
												</div>
											</div>
											<div class="checkBoxArea2">
												<label><i class="uil uil-sunset"></i></label>
												<div class="inputCountDropDown">
													<input type="text" class="noon_data iputCountDropBtn" value="0">
													<div class="inputCountDropDownPopup">
														<ul>
															<li>0</li>
															<li>1</li>
															<li>2</li>
															<li>3</li>
															<li>4</li>
															<li>5</li>
															<li>6</li>
															<li>7</li>
															<li>8</li>
															<li>9</li>
															<li>10</li>
															<li>11</li>
															<li>12</li>
															<li>13</li>
															<li>14</li>
															<li>15</li>
														</ul>
													</div>
												</div>
											</div>
											<div class="checkBoxArea2">
												<label><i class="uil uil-moon"></i></label>
												<div class="inputCountDropDown">
													<input type="text" class="evening_data iputCountDropBtn" value="1">
													<div class="inputCountDropDownPopup">
														<ul>
															<li>0</li>
															<li>1</li>
															<li>2</li>
															<li>3</li>
															<li>4</li>
															<li>5</li>
															<li>6</li>
															<li>7</li>
															<li>8</li>
															<li>9</li>
															<li>10</li>
															<li>11</li>
															<li>12</li>
															<li>13</li>
															<li>14</li>
															<li>15</li>
														</ul>
													</div>
												</div>
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No Of Days</label>
											<div class="inputCountDropDown">
												<input type="text" class="no_days iputCountDropBtn" value="15">
												<div class="inputCountDropDownPopup">
													<ul>
														<li>1</li>
														<li>2</li>
														<li>3</li>
														<li>4</li>
														<li>5</li>
														<li>6</li>
														<li>7</li>
														<li>8</li>
														<li>9</li>
														<li>10</li>
														<li>11</li>
														<li>12</li>
														<li>13</li>
														<li>14</li>
														<li>15</li>
														<li>16</li>
														<li>17</li>
														<li>18</li>
														<li>19</li>
														<li>20</li>
														<li>21</li>
														<li>22</li>
														<li>23</li>
														<li>24</li>
														<li>25</li>
														<li>26</li>
														<li>27</li>
														<li>28</li>
														<li>29</li>
														<li>30</li>
													</ul>
												</div>
											</div>
											<span id="quantity_error" style="color:red"></span>
										</div>
										<!--<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No.Of Days</label>
											<input type="text" class="no_days">
											<span id="noof_error" style="color:red"></span>
										</div>-->
										<div class="formGroup4">
											<div class="checkBoxArea">
												<input type="radio" class="morning_data afterFood" id="afterFood" name="foodMed">
												<label for="afterFood">After Food</label>
											</div>
											<div class="checkBoxArea">
												<input type="radio" class="noon_data beforeFood" id="beforeFood" name="foodMed">
												<label for="beforeFood">Before Food</label>
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<!--<div class="formGrouptextarea">
											<label>Chief History</label>
											<textarea class="remark_data"></textarea>
										</div>-->
									</div>
									<div class="tempPanelDiv"></div>
									<div class="tempPanelBtnArea">
										<div class="addMoreBtn">Add</div>
									</div>
								</div>
								<div class="formBtnArea">
									<button id="prescription_data">Save</button>
								</div>
							</form>
						</div>
					</div>
						<div class="commentsPopupPreviousMain" style="flex: 0 0 53%;">
					<div class="commentsPopupPrevious">
					
						<h2 style="margin-top: 0;">Complaints History</h2>
						
						<div class="commentsPopupPreviousList commentsPopupPreviousList_complaints">
							<dl>
							<!--	<dt class="PreviousListDate">
									<span>06-07-2022</span>
								</dt>
								<dd class="commentsPopupPreviousBox">
									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
								</dd>
								<dd class="commentsPopupPreviousBox">
									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
								</dd>
								<dt class="PreviousListDate">
									<span>05-07-2022</span>
								</dt>
								<dd class="commentsPopupPreviousBox">
									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
								</dd>
								<dd class="commentsPopupPreviousBox">
									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
								</dd>
								<dd class="commentsPopupPreviousBox">
									<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
								</dd>-->
							</dl>
							<div class="elseDesign">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
					<div class="commentsPopupForm">
						<h2>Add Complaints</h2>
						
						<form action="">
							<div class="formGroup" id="one" style="margin-top:5px;">
							
							<div class="text-area-container">
							  <textarea id="textAreaId" style="height:150px;"></textarea>
							</div>
								<div id="test" class="spnEL"></div>
								<pre style ="display:none"><code></code></pre>
						</div>
							<div class="formBtnArea">
								<button class="saveCommentsPopupBtn commentsTextarea_btn">Save</button>
							</div>
						</form>
						<!---<form action="">
							<div class="formGroup commentsTextarea_data">
								<div id="commentsTextarea"></div>
							</div>
							<div class="formBtnArea">
								<button class="saveCommentsPopupBtn commentsTextarea_btn">Save</button>
							</div>
						</form> --->
					</div>
						</div>
					</div>
					
					<div class="dietSection">
						<div class="dietSectionColumn1">
							<div class="dietBox">
								<h2>Diet to be followed</h2>
								<ul id="dite_details_to_follow">
									<!--<li>
										<input type="checkbox" id="diet1" value="grain free diet" class="dite_details">
										<label for="diet1">grain free diet</label>
									</li>
									<li>
										<input type="checkbox" id="diet2" value="low protein diet" class="dite_details">
										<label for="diet2">low protein diet</label>
									</li>
									<li>
										<input type="checkbox" id="diet3" value="low carb diet" class="dite_details">
										<label for="diet3">low carb diet</label>
									</li>
									<li>
										<input type="checkbox" id="diet4" value="wellness diet" class="dite_details">
										<label for="diet4">wellness diet</label>
									</li>-->
								</ul>
								<div class="dietBoxForm">
									<div class="dietBoxFormGroup">
										<input type="text" class="dietBoxFormGroupInput_dite">
										
										<div class="dietBoxFormGroupAddBtn dite_to_follow_btn">Add</div>
										
									</div>
									<span id="dite_pan_exist" style="color:red"></span>
								</div>
							</div>
							<div class="dietBox">
								<h2>Foods to be avoided</h2>
								<ul id="food_to_be_avoid_data">
									<!--<li>
										<input type="checkbox" id="diet5" class="food_avoided" value="Milk, Milk with tea, Ice Cream">
										<label for="diet5">Milk, Milk with tea, Ice Cream</label>
									</li>
									<li>
										<input type="checkbox" id="diet6" class="food_avoided" value="Wheat, Maida, Oats, Rava, Atta">
										<label for="diet6">Wheat, Maida, Oats, Rava, Atta</label>
									</li>
									<li>
										<input type="checkbox" id="diet7" class="food_avoided" value="Soy Products">
										<label for="diet7">Soy Products</label>
									</li>
									<li>
										<input type="checkbox" id="diet8" class="food_avoided" value="Coffee">
										<label for="diet8">Coffee</label>
									</li>
									<li>
										<input type="checkbox" id="diet9" class="food_avoided" value="Tea">
										<label for="diet9">Tea</label>
									</li>
									<li>
										<input type="checkbox" id="diet10" class="food_avoided" value="Sugar">
										<label for="diet10">Sugar</label>
									</li>
									<li>
										<input type="checkbox" id="diet11" class="food_avoided" value="Salt">
										<label for="diet11">Salt</label>
									</li>
									<li>
										<input type="checkbox" id="diet12" class="food_avoided" value="Egg">
										<label for="diet12">Egg</label>
									</li>
									<li>
										<input type="checkbox" id="diet13" class="food_avoided" value="Meat">
										<label for="diet13">Meat</label>
									</li>
									<li>
										<input type="checkbox" id="diet14" class="food_avoided" value="Fish">
										<label for="diet14">Fish</label>
									</li>
									<li>
										<input type="checkbox" id="diet15" class="food_avoided" value="Brinjal">
										<label for="diet15">Brinjal</label>
									</li>
									<li>
										<input type="checkbox" id="diet16" class="food_avoided" value="Ladies Finger">
										<label for="diet16">Ladies Finger</label>
									</li>
									<li>
										<input type="checkbox" id="diet17" class="food_avoided" value="Tomato">
										<label for="diet17">Tomato</label>
									</li>-->
								</ul>
								<div class="dietBoxForm">
									<div class="dietBoxFormGroup">
										<input type="text" class="dietBoxFormGroupInput new_food_to_avoid">
										<div class="dietBoxFormGroupAddBtn food_to_avoid_btn">Add</div>
									</div>
									<span id="food_data_exist" style="color:red"></span>
								</div>
							</div>
						</div>
						<div class="dietSectionColumn2">
							<form>
								<div class="formGroup">
									<label>No.of days</label>
									<input type="text" id="noofDays">
								</div>
								<div class="formGroupTextArea">
									<label>Remark (Doctor)</label>
									<textarea id="food_remark"></textarea>
								</div>
							</form>
						</div>
					</div>
				<div class="commentsTextarea">
					<label>Remark (Print)</label>
					<textarea class="remark_data"></textarea>
				</div>
				</div>
				<div id="tab3" class="commentsPopupTabBox" style="display: flex;">
					<div class="historyList">
						<div class="commentsPopupPrevious" Style="flex: 0 0 32%">
							<h2>Prescription History</h2>
						<!--<div class="prescriptionHistory">
							<table>
								<thead>
									<tr>
										<th>Medicine</th>
										<th>Morning</th>
										<th>Noon</th>
										<th>Evening</th>
										<th>No.Of Days</th>
										<th>Time</th>
										<th>Added Date</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>-->
							
							
							
							<div class="prescriptionHistoryList">
							<div class="prescriptionHistoryListMain prescriptionHistoryListMain_history">
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
								
								<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">01-01-2022</div>
										<div class="prescriptionHistoryBtnArea">
											<button class="prescriptionHistoryEditBtn">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn">
												<i class="uil uil-trash"></i>
											</button>
										</div>
									</div>
									<div class="prescriptionHistoryListBoxBody">
										<div class="prescriptionHistoryRow">
											<div class="prescriptionHistoryRowBox1">
												<p>Super Nova</p>
											</div>
											<div class="prescriptionHistoryRowBox2">
												<div class="count">1</div>
												<div class="count">1</div>
												<div class="count">0</div>
											</div>
											<div class="prescriptionHistoryRowBox3">
												<p>3 Days</p>
											</div>
											<div class="prescriptionHistoryRowBox4">
												<p>AF</p>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
							
							
							
						
						<div class="commentsPopupPreviousMain" style="flex: 0 0 32%;">
							<div class="commentsPopupPrevious">
							<h2>Medical History</h2>
								<div class="commentsPopupPreviousList commentsPopupPreviousList_medical">
									<dl>
									<!--	<dt class="PreviousListDate">
											<span>06-07-2022</span>
										</dt>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dt class="PreviousListDate">
											<span>05-07-2022</span>
										</dt>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>-->
									</dl>
									<div class="elseDesign">
										<div class="elseDesignthumbnail">
											<img src="assets/images/empty.png" alt="">
										</div>
										<p>No Previous Comments</p>
									</div>
								</div>
							</div>
							<div class="commentsPopupForm">
								<h2>Add Medical</h2>
								<form action="">
									<div class="formGroup medicalTextarea_area">
										<div id="medicalTextarea"></div>
									</div>
									<div class="formBtnArea">
										<button class="saveCommentsPopupBtn medicalTextarea_btn">Save</button>
									</div>
								</form>
							</div>
						</div>
							
							
							
						
						
						<div class="commentsPopupPreviousMain" style="flex: 0 0 32%;">
							<div class="commentsPopupPrevious">
								<h2>Investigations</h2>
								<div class="commentsPopupPreviousList commentsPopupPreviousList_surgical">
									<dl>
									<!--	<dt class="PreviousListDate">
											<span>06-07-2022</span>
										</dt>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dt class="PreviousListDate">
											<span>05-07-2022</span>
										</dt>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>
										<dd class="commentsPopupPreviousBox">
											<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
										</dd>-->
									</dl>
									<div class="elseDesign">
										<div class="elseDesignthumbnail">
											<img src="assets/images/empty.png" alt="">
										</div>
										<p>No Previous Comments</p>
									</div>
								</div>
							</div>
							<div class="commentsPopupForm">
								<h2>Add Investigations</h2>
								<form action="">
									<div class="formGroup surgicalTextarea_data">
										<div id="surgicalTextarea"></div>
									</div>
									<div class="formBtnArea">
										<button class="saveCommentsPopupBtn surgicalTextarea_btn">Save</button>
									</div>
								</form>
							</div>
						</div>
							
							
					</div>
				</div>
				<div id="tab4" class="commentsPopupTabBox" style="display: none;">
					<div class="historyList">
						<div class="commentsPopupPrevious" style="flex: 100%">
							<div class="commentsPopupPreviousFileUploadSection">
								<h2>Upload Report</h2>
								<div class="commentsPopupPreviousFileUploadSectionBox">
									<div class="formGroup">
										<label>File Name</label>
										<input type="text" class="report_name">
										<span style="color:red" class="file_name_error"></span>
									</div>
									<div class="formGroupFile">
										<div class="formGroupFileMain">
											<div class="formGroupFileBox1">
												<label>Upload File</label>
												<label class="uploadBtn">
  													<input type="file" class="fileInput report_file">
                                                    <p>Upload images</p>
                                                </label>
												<span style="color:red" class="file_error"></span>
											</div>
											
											<div class="formGroupFileBox2">
												
											</div>
										</div>
									</div>
								</div>
								<div class="commentsPopupPreviousFileUploadSectionTemplate"></div>
										<div class="formGroupFileSaveBtn">Save</div>
								<div class="commentsPopupPreviousFileUploadSectionBoxBtnarea">
									<div class="FileUploadAddBtn">Add More</div>
								</div>
							</div>
							<h2>Mark Lab Test</h2>
							<!--<ul class="labTestSection">
								<li>
									<input type="checkbox" id="labTest1" value="Lab Test">
									<label for="labTest1">Lab Test - ₹ 100</label>
								</li>
								<li>
									<input type="checkbox" id="labTest2" value="Lab Test 2">
									<label for="labTest2">Lab Test 2 - ₹ 100</label>
								</li>
								<li>
									<input type="checkbox" id="labTest3" value="Lab Test 3">
									<label for="labTest3">Lab Test 3 - ₹ 100</label>
								</li>
								<li>
									<input type="checkbox" id="labTest4" value="Lab Test 5">
									<label for="labTest4">Lab Test 5 - ₹ 100</label>
								</li>
								<div class="formBtnArea">
									<button>Save</button>
								</div>
							</ul>-->

							<div class="formWraperBox">
								<div class="labTestListSection">
									<div class="labTestListSectionBox">
										<div class="labTestListSectionBoxHead">Haematology</div>
										<ul>
											<li>
												<input type="checkbox" id="CBC" value="CBC">
												<label for="CBC">CBC</label>
											</li>
											<li>
												<input type="checkbox" id="TC" value="TC">
												<label for="TC">TC</label>
											</li>
											<li>
												<input type="checkbox" id="DC" value="DC">
												<label for="DC">DC</label>
											</li>
											<li>
												<input type="checkbox" id="ESR" value="ESR">
												<label for="ESR">ESR</label>
											</li>
											<li>
												<input type="checkbox" id="Hb" value="Hb">
												<label for="Hb">Hb</label>
											</li>
											<li>
												<input type="checkbox" id="PlateletCount" value="Platelet Count">
												<label for="PlateletCount">Platelet Count</label>
											</li>
											<li>
												<input type="checkbox" id="AEC" value="AEC">
												<label for="AEC">AEC</label>
											</li>
											<li>
												<input type="checkbox" id="PBF" value="PBF">
												<label for="PBF">PBF</label>
											</li>
										</ul>
										<h3>URIN</h3>
										<ul>
											<li>
												<input type="checkbox" id="UrineRE" value="Urine RE">
												<label for="UrineRE">Urine RE</label>
											</li>
										</ul>
									</div>
									
									<div class="labTestListSectionBox">
										<div class="labTestListSectionBoxHead">Bio Chemistry</div>
										<ul>
											<li>
												<input type="checkbox" id="FBS" value="FBS">
												<label for="FBS">FBS</label>
											</li>
											<li>
												<input type="checkbox" id="PPBS" value="PPBS">
												<label for="PPBS">PPBS</label>
											</li>
											<li>
												<input type="checkbox" id="RBS" value="RBS">
												<label for="RBS">RBS</label>
											</li>
											<li>
												<input type="checkbox" id="GTT" value="GTT">
												<label for="GTT">GTT</label>
											</li>
											<li>
												<input type="checkbox" id="GCT" value="GCT">
												<label for="GCT">GCT</label>
											</li>
											<li>
												<input type="checkbox" id="HbA1c" value="HbA1c">
												<label for="HbA1c">HbA1c</label>
											</li>
											<li>
												<input type="checkbox" id="Calcium" value="Calcium">
												<label for="Calcium">Calcium</label>
											</li>
											<li>
												<input type="checkbox" id="Phosphorus" value="Phosphorus">
												<label for="Phosphorus">Phosphorus</label>
											</li>
										</ul>
									</div>
									
									<div class="labTestListSectionBox">
										<div class="labTestListSectionBoxHead">Hormones</div>
										<ul>
											<li>
												<input type="checkbox" id="T3" value="T3">
												<label for="T3">T3</label>
											</li>
											<li>
												<input type="checkbox" id="T4" value="T4">
												<label for="T4">T4</label>
											</li>
											<li>
												<input type="checkbox" id="TSH" value="TSH">
												<label for="TSH">TSH</label>
											</li>
											<li>
												<input type="checkbox" id="TFT" value="TFT">
												<label for="TFT">TFT</label>
											</li>
											<li>
												<input type="checkbox" id="FT3" value="FT3">
												<label for="FT3">FT3</label>
											</li>
											<li>
												<input type="checkbox" id="FT4" value="FT4">
												<label for="FT4">FT4</label>
											</li>
											<li>
												<input type="checkbox" id="FSH" value="FSH">
												<label for="FSH">FSH</label>
											</li>
											<li>
												<input type="checkbox" id="LH" value="LH">
												<label for="LH">LH</label>
											</li>
										</ul>
									</div>
		
									<div class="dummyDiv"></div>
									<div class="dummyDiv"></div>
									
								</div>

                                
							</div>
							<h2>Reports</h2>
							<div class="labTestHistorySection lab_report_section">
								<!--<div class="labTestHistorySectionBox">
									<div class="labTestHistoryDate">01-01-2023</div>
									<div class="labTestHistoryReport">
										<!--<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>-->
										
										<!-- dont remove the div-->
										<!--<div class="dummyDiv"></div>-->
										<!-- dont remove the div-->
										
									<!--</div>
								</div>-->
							</div>
						</div>
					</div>
				</div>
				
				<div id="tab5" class="commentsPopupTabBox" style="display: none;">
					<div class="historyList">
						<div class="commentsPopupPrevious" style="flex: 100%">
							<!--<div class="commentsPopupPreviousFileUploadSection">
								<h2>Treatment Report</h2>
								<div class="commentsPopupPreviousFileUploadSectionBox">
									<div class="formGroup">
										<label>File Name</label>
										<input type="text" class="report_name">
										<span style="color:red" class="file_name_error"></span>
									</div>
									<div class="formGroupFile">
										<div class="formGroupFileMain">
											<div class="formGroupFileBox1">
												<label>Upload File</label>
												<label class="uploadBtn">
  													<input type="file" class="fileInput report_file">
                                                    <p>Upload images</p>
                                                </label>
												<span style="color:red" class="file_error"></span>
											</div>
											
											<div class="formGroupFileBox2">
												
											</div>
										</div>
									</div>
								</div>
								<div class="commentsPopupPreviousFileUploadSectionTemplate"></div>
										<div class="formGroupFileSaveBtn">Save</div>
								<div class="commentsPopupPreviousFileUploadSectionBoxBtnarea">
									<div class="FileUploadAddBtn">Add More</div>
								</div>
							</div>-->
							<h2>Mark Treatment</h2>
							<!--<ul class="labTestSection">
								<li>
									<input type="checkbox" id="labTest1" value="Lab Test">
									<label for="labTest1">Lab Test - ₹ 100</label>
								</li>
								<li>
									<input type="checkbox" id="labTest2" value="Lab Test 2">
									<label for="labTest2">Lab Test 2 - ₹ 100</label>
								</li>
								<li>
									<input type="checkbox" id="labTest3" value="Lab Test 3">
									<label for="labTest3">Lab Test 3 - ₹ 100</label>
								</li>
								<li>
									<input type="checkbox" id="labTest4" value="Lab Test 5">
									<label for="labTest4">Lab Test 5 - ₹ 100</label>
								</li>
								<div class="formBtnArea">
									<button>Save</button>
								</div>
							</ul>-->

							<div class="formWraperBox">
							<div class="formTagArea selected_treatment_report">
                                    
                            </div>
								<div class="formGroup">
									<label for="" style="font-size:12px;margin-bottom:5px;">Select Treatment</label>
									<div class="dropDownSection">
										<div class="dropDownInput">
											<input type="text" class="dropDownInputText" >
										</div>
										
										<div class="dropDownPopup">
											<div class="dropDownSearch">
												<input type="search" class="searchDropDown-field" placeholder="Search...">
											</div>
											
											<div class="dropDownPopuplist multipleSelect treatment_data">
												<ul>
													<!--<li data-id=1>a</li>
													<li data-id=2>b</li>
													<li data-id=3>c</li>-->
												</ul>
												<div class="elseDesign">
													<div class="elseDesignthumbnail">
														<img src="assets/images/empty.png" alt="">
													</div>
													<p>No Data Available</p>
												</div>
											</div>
										</div>
									</div>
								</div>

                                
							</div>
							<h2>Treatment Reports</h2>
							<div class="labTestHistorySection treatment_repor">
								<!--<div class="labTestHistorySectionBox">
									<div class="labTestHistoryDate">01-01-2023</div>
									<div class="labTestHistoryReport">
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>
										<div class="labTestHistoryReportBox">
											<p>Lab Test 1</p>
											<a href="" class="labTestHistoryReportFileBtn spotlight">
												<i class="uil uil-eye"></i>
											</a>
										</div>-->
										
										<!-- dont remove the div-->
										<!--<div class="dummyDiv"></div>-->
										<!-- dont remove the div-->
										
									<!--</div>
								</div>-->
							</div>
						</div>
					</div>
				</div>
				<!--<div id="tab4" class="commentsPopupTabBox" style="display: none;">
						<div class="commentsPopupPreviousMain" style="flex:100%;">
					<div class="commentsPopupPrevious">
						<h2>Medical History</h2>
						<div class="commentsPopupPreviousList commentsPopupPreviousList_medical">
							<dl>
							</dl>
							<div class="elseDesign">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
					<div class="commentsPopupForm">
						<h2>Add Medical</h2>
						<form action="">
							<div class="formGroup medicalTextarea_area">
								<div id="medicalTextarea"></div>
							</div>
							<div class="formBtnArea">
								<button class="saveCommentsPopupBtn medicalTextarea_btn">Save</button>
							</div>
						</form>
					</div>
						</div>
				</div>
				<div id="tab5" class="commentsPopupTabBox" style="display: none;">
						<div class="commentsPopupPreviousMain" style="flex:100%;">
					<div class="commentsPopupPrevious">
						<h2>Surgical History</h2>
						<div class="commentsPopupPreviousList commentsPopupPreviousList_surgical">
							<dl>
							</dl>
							<div class="elseDesign">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
					<div class="commentsPopupForm">
						<h2>Add Surgical</h2>
						<form action="">
							<div class="formGroup surgicalTextarea_data">
								<div id="surgicalTextarea"></div>
							</div>
							<div class="formBtnArea">
								<button class="saveCommentsPopupBtn surgicalTextarea_btn">Save</button>
							</div>
						</form>
					</div>
						</div>
				</div>-->
            </div>
        </div>
					
        <!-- comments popup close -->
                    <div class="consultAppointmentList">
                        <div class="consultAppointmentListTab">
                            <!--<button class="tablinks active" onclick="openCity(event, 'appointmentTab1')" id="defaultOpen">Appointments</button>-->
                            <button class="tablinks" style="display: none;" onclick="openCity(event, 'appointmentTab2')"><div class="WaitingCount">0</div>  Waiting List</button>
                        </div>
                        <div id="appointmentTab1" class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_details">
                                        <button id="search_btn_data"><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
													<th>Doctor</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="allprev_appointments">
                                               <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>Kottiyottuthodi (H)</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="keepWaitBtn">Keep Wait</div>
                                                            <div class="nextBtn disableNextBtn">Next</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>Kottiyottuthodi (H)</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="keepWaitBtn">Keep Wait</div>
                                                            <div class="nextBtn disableNextBtn">Next</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>Kottiyottuthodi (H)</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="keepWaitBtn">Keep Wait</div>
                                                            <div class="nextBtn disableNextBtn">Next</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>5</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>Kottiyottuthodi (H)</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="keepWaitBtn">Keep Wait</div>
                                                            <div class="nextBtn disableNextBtn">Next</div>
                                                        </div>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="elseDesign all_pending_appointments_else">
                                        <div class="elseDesignthumbnail">
                                            <img src="assets/images/empty.png" alt="">
                                        </div>
                                        <p>No Appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="appointmentTab2" class="tabcontent">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <div class="searchBox">
                                        <input type="search" placeholder="Search...">
                                        <button><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Address</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody class="allprev_appointments_waiting">
                                               <!-- <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>Kottiyottuthodi (H)</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="nextBtn">Next</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>AKR120622</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>Kottiyottuthodi (H)</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="nextBtn">Next</div>
                                                        </div>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="elseDesign all_waiting_appointments_else">
                                        <div class="elseDesignthumbnail">
                                            <img src="assets/images/empty.png" alt="">
                                        </div>
                                        <p>No Appointments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- consultingWindow close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
    <!-- script close -->

    <script>
		
		//split line
		  function divide() {
            var txt;
            txt = document.getElementById('textAreaId').value;
            var text = txt.split(".");
            var str = text.join('.</br>');
			 
            console.log(str);
			  
			  return str;
        }
		
		
		//Comments popup tab
		function openCity2(evt, cityName2) {
		  var i, x, tablinks;
		  x = document.getElementsByClassName("commentsPopupTabBox");
		  for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablink");
		  for (i = 0; i < x.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  document.getElementById(cityName2).style.display = "flex";
		  evt.currentTarget.className += " active";
		}
		
		$('body').delegate('.removeMoreBtn', 'click', function(){
			$(this).parent().parent().remove();
		})
		
		function create_custom_dropdowns() {
			$('.formSelect select').each(function (i, select) {
				if (!$(this).next().hasClass('dropdown-select')) {
					$(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div><ul></ul></div></div>');
					var dropdown = $(this).next();
					var options = $(select).find('option');
					var selected = $(this).find('option:selected');
					dropdown.find('.current').html(selected.data('display-text') || selected.text());
					options.each(function (j, o) {
						var display = $(o).data('display-text') || '';
						dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
					});
				}
			});

			/*$('.dropdown-select ul').before('<div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>')*/;
		}

		// Event listeners

		// Open/close
		
		$('body').delegate('.dropdown-select', 'click', function (event) {
			if($(event.target).hasClass('dd-searchbox')){
				return;
			}
			$('.dropdown-select').not($(this)).removeClass('open');
			$(this).toggleClass('open');
			if ($(this).hasClass('open')) {
				$(this).find('.option').attr('tabindex', 0);
				$(this).find('.selected').focus();
			} else {
				$(this).find('.option').removeAttr('tabindex');
				$(this).focus();
			}
			
		});
		
		
		
		//dropdown search
			function filter(){
			var valThis = $('#txtSearchValue').val();
			$('.dropdown-select ul > li').each(function(){
			 var text = $(this).text();
				(text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show() : 		      $(this).hide();         
		   });
		};
		
		$('body').delegate('#txtSearchValue','keyup',function(){
			let theInpVal = $(this).val();
			let valLower = theInpVal.toLowerCase();
			let theUlElement = $(this).parent().parent().find('ul');
			//console.log(theUlElement.children())
			let theSearchTarget = theUlElement.children();
			//console.log(theSearchTarget.length)
			for(let i=1; i<theSearchTarget.length; i++){
				let theLoopedLi = theSearchTarget[i].innerText.toLowerCase();
				if(theLoopedLi.includes(valLower)){
					theSearchTarget[i].style.display = "flex";
				}else{
					theSearchTarget[i].style.display = "none";	
				}
			}
		})
		
		
	
			
			
			/*$(document).on('click', '.dropdown-select', function (event) {
			if($(event.target).hasClass('dd-searchbox')){
				return;
			}
			$('.dropdown-select').not($(this)).removeClass('open');
			$(this).toggleClass('open');
			if ($(this).hasClass('open')) {
				$(this).find('.option').attr('tabindex', 0);
				$(this).find('.selected').focus();
			} else {
				$(this).find('.option').removeAttr('tabindex');
				$(this).focus();
			}
			
		});*/

		// Close when clicking outside
		$(document).on('click', function (event) {
			if ($(event.target).closest('.dropdown-select').length === 0) {
				$('.dropdown-select').removeClass('open');
				$('.dropdown-select .option').removeAttr('tabindex');
			}
			event.stopPropagation();
		});

	
		// Search

		// Option click
		$(document).on('click', '.dropdown-select .option', function (event) {
			$(this).closest('.list').find('.selected').removeClass('selected');
			$(this).addClass('selected');
			var text = $(this).data('display-text') || $(this).text();
			$(this).closest('.dropdown-select').find('.current').text(text);
			$(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
		});

		// Keyboard events
		$(document).on('keydown', '.dropdown-select', function (event) {
			var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
			// Space or Enter
			//if (event.keyCode == 32 || event.keyCode == 13) {
			if (event.keyCode == 13) {
				if ($(this).hasClass('open')) {
					focused_option.trigger('click');
				} else {
					$(this).trigger('click');
				}
				return false;
				// Down
			} else if (event.keyCode == 40) {
				if (!$(this).hasClass('open')) {
					$(this).trigger('click');
				} else {
					focused_option.next().focus();
				}
				return false;
				// Up
			} else if (event.keyCode == 38) {
				if (!$(this).hasClass('open')) {
					$(this).trigger('click');
				} else {
					var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
					focused_option.prev().focus();
				}
				return false;
				// Esc
			} else if (event.keyCode == 27) {
				if ($(this).hasClass('open')) {
					$(this).trigger('click');
				}
				return false;
			}
		});



        // consulted Btn click 
        /**$('.consultedBtn').click(function(e){
            e.preventDefault();
                $('#text').fadeOut();
            setTimeout(function(){
                $('#loading').fadeIn();
            },500);
            setTimeout(function(){
                $('#loading').fadeOut();
            },1500);
            setTimeout(function(){
                $('#done').fadeIn();
            },2000);
            setTimeout(function(){
                $('.currentConsulting').fadeOut();
            $('.nextBtn').removeClass('disableNextBtn');
            $('.nextBtn').addClass('enableNextBtn');
            },2500);
            setTimeout(function(){
                $('#done').fadeOut();
                $('#text').fadeIn();
            },3000);
        });**/



        // Comments popup 
        $('.addCommentsBtn').click(function(){
            $('.commentsPopup').fadeIn();
            $('.shimmer').fadeIn();
        });
        $('.closeCommentsPopupBtn').click(function(){
            $('.commentsPopup').fadeOut();
            $('.shimmer').fade.innerText
        });
        $('.saveCommentsPopupBtn').click(function(e){
            e.preventDefault();
			divide()
			$("pre code").text($("textarea").val());
			console.log($('pre code').innerHTML)
			
        });

        // appointments tab  
        function openCity(evt, cityName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        //document.getElementById("defaultOpen").click();
        
        // keep wait click 
        $('.keepWaitBtn').click(function(){
            $(this).parent().parent().parent().fadeOut();
        });

        
        

        // commentsTextarea
        $('#commentsTextarea').summernote({
            placeholder: 'Type here...',
            tabsize: 2,
            height: 200,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'help']]
            ]
      });
		// commentsTextarea
        $('#medicalTextarea').summernote({
            placeholder: 'Type here...',
            tabsize: 2,
            height: 200,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'help']]
            ]
      });
		// commentsTextarea
        $('#surgicalTextarea').summernote({
            placeholder: 'Type here...',
            tabsize: 2,
            height: 200,
            toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear', 'italic']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'help']]
            ]
      });
		

		//delete alert 



    </script>
	<script>
    var suggestions = [
     "the", "be", "to", "of", "and", "a", "in", "that", "have", "I", "it", "for", "not", "on", "with", "he", "as", "you", "do", "at", "this", "but", "his", "by", "from", "they", "we", "say", "her", "she", "or", "an", "will", "my", "one", "all", "would", "there", "their", "what", "so", "up", "out", "if", "about", "who", "get", "which", "go", "me", "when", "make", "can", "like", "time", "no", "just", "him", "know", "take", "person", "into", "year", "your", "good", "some", "could", "them", "see", "other", "than", "then", "that", "now", "look", "only", "come", "its", "over", "think", "also", "back", "after", "use", "two", "how", "our", "work", "first", "well", "way", "even", "new", "want", "because", "any", "these", "give", "day", "most", "us", "Patient", "Diagnosis", "Symptoms", "Treatment", "Medication", "Surgery", "Follow-up", "Prescription", "Referral", "Examination", "Procedure", "Chart", "Medical history", "Vital signs", "Laboratory", "Infection", "Pain", "Recovery", "Disease", "Condition", "Dose", "Side effects", "Allergies", "Appointment", "Consultation", "Discharge", "Emergency", "Hospital", "Illness", "Injury", "Medical", "Nurse", "Physician", "Prescribe", "Referral", "Test results", "X-ray", "Holistic", "Natural", "Herbal", "Nutrition", "Homeopathy", "Supplements", "Acupuncture", "Ayurveda", "Detox", "Wellness", "Lifestyle", "Mind-body", "Preventative", "Alternative", "Healing", "Organic", "Bio-individuality", "Energy", "Balance", "Environment", "Emotions", "Mindfulness", "Detoxification", "Naturopathic", "Anatomy",    "Physiology",    "Pathology",    "Microbiology",    "Immunology",    "Pharmacology",    "Neurology",    "Cardiology",    "Oncology",    "Dermatology",    "Orthopedics",    "Pediatrics",    "Obstetrics and Gynecology",    "Radiology",    "Surgery",    "Neurological Disorders",    "Infectious Diseases",    "Cancer",    "Mental Health",    "Allergy and Asthma",    "Respiratory Diseases",    "Gastrointestinal Disorders",    "Endocrine Disorders",    "Rheumatologic Disorders",    "Hematologic Disorders",    "Ophthalmology",    "Otolaryngology","Obesity",    "Diabetes",    "Hypertension",    "Heart Disease",    "Stroke",    "Cancer",    "Dyslipidemia",    "Metabolic Syndrome",    "Dysfunctional Glucose Regulation",    "Non-alcoholic Fatty Liver Disease",    "Osteoarthritis",    "Depression",    "Anxiety",    "Sleep Apnea",    "Gout",    "Chronic Kidney Disease",    "Alzheimer's Disease",    "Dementia",    "Parkinson's Disease",    "Lung Diseases",    "COPD",    "Asthma","Skeleton",    "Muscles",    "Joints",    "Ligaments",    "Tendons",    "Bones",    "Cartilage",    "Skin",    "Nails",    "Hair",    "Eyes",    "Ears",    "Nose",    "Mouth",    "Throat",    "Lungs",    "Heart",    "Blood Vessels",    "Digestive System",    "Liver",    "Gallbladder",    "Pancreas",    "Spleen",    "Stomach",    "Intestines",    "Kidneys",    "Bladder",    "Ureters",    "Urethra",    "Reproductive System",    "Nervous System",    "Brain",    "Spinal Cord",    "Endocrine System",    "Adrenal Glands",    "Thyroid",    "Pituitary Gland",    "Ovaries",    "Testes",    "Lymphatic System",    "Immune System",    "Circulatory System","Influenza",    "Common Cold",    "Tuberculosis",    "Malaria",    "HIV/AIDS",    "Diabetes",    "Cancer",    "Heart Disease",    "Stroke",    "Arthritis",    "Asthma",    "Chronic Obstructive Pulmonary Disease (COPD)",    "Depression",    "Anxiety",    "Alzheimer's Disease",    "Dementia",    "Parkinson's Disease",    "Liver Disease",    "Kidney Disease",    "Gastroesophageal Reflux Disease (GERD)",    "Peptic Ulcer Disease",    "Irritable Bowel Syndrome (IBS)",    "Crohn's Disease",    "Ulcerative Colitis",    "Migraines",    "Epilepsy",    "Multiple Sclerosis",    "Amyotrophic Lateral Sclerosis (ALS)",    "Shingles",    "Chickenpox",    "Measles",    "Mumps",    "Rubella",    "Pneumonia",    "Urinary Tract Infections (UTIs)",    "Skin Infections",    "Sinusitis",    "Back Pain",    "Osteoporosis",
    ];

    var textArea = document.getElementById("textAreaId");

    var suggestionBox = document.createElement("div");
    suggestionBox.setAttribute("id", "suggestionBoxId");

    document.getElementById("test").appendChild(suggestionBox);

    var currentSelection = 0;
    var selectedSuggestion = "";

    textArea.addEventListener("keyup", function (event) {
	
		if(event.keyCode === 13){
			let txtArea = document.getElementById('textAreaId')
			var str = txtArea.value.concat('.');
			txtArea.value = str
		}
      if (event.target.value === "") {
        suggestionBox.innerHTML = "";
      } else {
        var currentValue = textArea.value;
        var currentWord = currentValue.split(" ").pop();

        var filteredSuggestions = suggestions.filter(function (suggestion) {
          return suggestion.toLowerCase().startsWith(currentWord.toLowerCase());
        });

        suggestionBox.innerHTML = "";

        filteredSuggestions.forEach(function (suggestion, index) {
          var suggestionItem = document.createElement("span");
          suggestionItem.innerHTML = suggestion;
          suggestionItem.style.padding = '5px';
          suggestionItem.style.borderRadius = '5px';

          suggestionBox.appendChild(suggestionItem);

          suggestionItem.addEventListener("mouseover", function () {
            currentSelection = index;
            this.style.background = "#f2f2f2";
          });
          suggestionItem.addEventListener("mouseout", function () {
            currentSelection = index;
            this.style.background = "none";
          });

          suggestionItem.addEventListener("click", function () {
            textArea.value =
              currentValue.substr(0, currentValue.lastIndexOf(" ") + 1) +
              suggestion.toLowerCase();
            textArea.focus();
            suggestionBox.innerHTML = "";
          });
        });
      }
    });

    textArea.parentNode.appendChild(suggestionBox);
		









// dropdown 
$('.dropDownInput').click(function(e){
	e.stopPropagation();
	var imagePos = $(this).parent('.dropDownSection').offset().top;
	var topOfWindow = $(window).scrollTop();
	if (imagePos < topOfWindow+700) {
		$('.dropDownPopup').removeClass('dropDownPopupUp');
		$('.dropDownPopup').removeClass('dropDownPopupDown');
		$(this).parent().find('.dropDownPopup').addClass('dropDownPopupDown');
		$('.dropDownInput input').css({
			boxShadow: 'none',
		})
		$(this).find('input').css({
			boxShadow: '0 0 20px rgba(0, 0, 0, 0.059)'
		});
	}
	else{
		$('.dropDownPopup').removeClass('dropDownPopupUp');
		$('.dropDownPopup').removeClass('dropDownPopupDown');
		$(this).parent().find('.dropDownPopup').addClass('dropDownPopupUp');
		$('.dropDownPopup').removeClass('dropDownPopupDown');
		$('.dropDownInput input').css({
			boxShadow: 'none',
		})
		$(this).find('input').css({
			boxShadow: '0 0 20px rgba(0, 0, 0, 0.059)'
		});
	}
	$(this).siblings().children('.dropDownSearch').children().focus();
})
$(".dropDownPopup").click(function(e){
    e.stopPropagation();
});
$(document).click(function(){
	$('.dropDownPopup').removeClass('dropDownPopupUp');
	$('.dropDownPopup').removeClass('dropDownPopupDown');
	$('.dropDownInput input').css({
		boxShadow: 'none',
	});
	$('.searchDropDown-field').val('');
	$('.singleSelect ul li').show();
	//$('.elseDesign').hide();
});

// search dropdown 
$('.searchDropDown-field').on('keyup', function() {
	var inputWord = this.value.toLowerCase();
	var ulElement = $(this).parent().parent().find('.dropDownPopuplist ul li');
	console.log(this.value)
	var count = 0;
	for(let i=0; i < ulElement.length; i++){
		var liValue = ulElement[i].innerText.toLowerCase();

		if(liValue.includes(inputWord)){
			ulElement[i].style.display = 'flex';
		}else{
			count ++
			ulElement[i].style.display = 'none';	
		}

		if(count === ulElement.length){
			$(this).parent().siblings().children('.elseDesign').css({
				display: 'flex',
			});
		}else{
			$(this).parent().siblings().children('.elseDesign').css({
				display: 'none',
			});
		}
	}
})
document.querySelector('.searchDropDown-field').addEventListener('search',function(){
	if(this.value === ""){ 	
		var ulElement = $(this).parent().siblings().children('ul').children();
		console.log(ulElement)
		for(let i=0; i < ulElement.length; i++){
			ulElement[i].style.display = 'flex';
		}
		$(this).parent().siblings().children('.elseDesign').css({
			display: 'none',
		});
	}
});
/*$('.searchDropDown-field').on("search",function() {
        if(this.value === ""){ 	
		var ulElement = $(this).parent().siblings().children('ul').children();
		console.log(ulElement)
		for(let i=0; i < ulElement.length; i++){
			ulElement[i].style.display = 'flex';
		}
		$(this).parent().siblings().children('.elseDesign').css({
			display: 'none',
		});
	}
    });*/
$('div').delegate('.singleSelect ul li','click',function(){
	var liTxt = $(this).text();
	$(this).parent().find('li').removeClass('dropDownPopuplistMenuActive');
	$(this).addClass('dropDownPopuplistMenuActive');
	$(this).parent().parent().parent().parent().find('.dropDownInputText').val(liTxt);
	$('.dropDownPopup').removeClass('dropDownPopupUp');
	$('.dropDownPopup').removeClass('dropDownPopupDown');
	$('.dropDownInput input').css({
		boxShadow: 'none',
	});
	$('.searchDropDown-field').val('');
	$('.singleSelect ul li').show();
})

// let theStaffList = document.createElement('ul');
let namesArr = [];
let namesArr1 = [];
$('div').delegate('.lab_report ul li','click',function(){
	
	var liTxt = $(this).text();
	var data_id = $(this).attr('data-id')
	console.log(data_id)
	$(this).toggleClass('dropDownPopuplistMenuActive');
	$(this).parent().parent().parent().parent().find('.dropDownInputText').val(liTxt);
	$('.searchDropDown-field').val('');
	$('.lab_report ul li').show();
	
	let theParenrtEl = $('.selected_lab_report');
	
	if($(this).hasClass( "dropDownPopuplistMenuActive" )){
		let theNme = $(this).context.innerHTML;
		let theDataId = $(this).attr('data-id');
		let theObj = {
			"name": theNme, 
			"data_id": theDataId
		}
		namesArr.push(theObj)
	// console.log(theStaffList)
	 //console.log(namesArr)
	}else{
		let blackSheep = $(this).context.innerHTML;
		let theDatAId = $(this).attr('data-id');
		//console.log(theDatAId)
		for(let i=0; i<namesArr.length;i++){
			// console.log(namesArr[i])
			if(namesArr[i].data_id === theDatAId){
			//	console.log(namesArr.indexOf(namesArr[i]))
				
				const index = namesArr.indexOf(namesArr[i]);
				//console.log(index)
				if (index > -1) {
					namesArr.splice(index, 1); 
				  }
				// console.log('maaahhhh')
			}
		}
		// console.log($(this).context.innerHTML)
		 //console.log(namesArr)
	}
	// console.log($('.formTagArea')[0].innerHTML);
	$('.selected_lab_report')[0].innerHTML = "";
	for(let j=0;j<namesArr.length;j++){
		let theStaffName = namesArr[j].name;
		let theID = namesArr[j].data_id;

		let theTemplate = `<div class="formTagBox">
	<p class="tagName lab_tagName" data_id = ${theID}>${theStaffName}</p>
	<div class="closeFormTagBox">
		<span><i class="uil uil-multiply"></i></span>
	</div>
</div>`;
theParenrtEl.append(theTemplate);
	}


	
})
$('div').delegate('.treatment_data ul li','click',function(){
	
	var liTxt = $(this).text();
	var data_id = $(this).attr('data-id')
	console.log(data_id)
	$(this).toggleClass('dropDownPopuplistMenuActive');
	$(this).parent().parent().parent().parent().find('.dropDownInputText').val(liTxt);
	$('.searchDropDown-field').val('');
	$('.treatment_data ul li').show();
	
	let theParenrtEl = $('.selected_treatment_report');
	
	if($(this).hasClass( "dropDownPopuplistMenuActive" )){
		let theNme = $(this).context.innerHTML;
		let theDataId = $(this).attr('data-id');
		let theObj = {
			"name": theNme, 
			"data_id": theDataId
		}
		namesArr1.push(theObj)
	// console.log(theStaffList)
	 //console.log(namesArr)
	}else{
		let blackSheep = $(this).context.innerHTML;
		let theDatAId = $(this).attr('data-id');
		//console.log(theDatAId)
		for(let i=0; i<namesArr1.length;i++){
			// console.log(namesArr[i])
			if(namesArr1[i].data_id === theDatAId){
			//	console.log(namesArr.indexOf(namesArr[i]))
				
				const index = namesArr1.indexOf(namesArr1[i]);
				//console.log(index)
				if (index > -1) {
					namesArr1.splice(index, 1); 
				  }
				// console.log('maaahhhh')
			}
		}
		// console.log($(this).context.innerHTML)
		 //console.log(namesArr)
	}
	// console.log($('.formTagArea')[0].innerHTML);
	$('.selected_treatment_report')[0].innerHTML = "";
	for(let j=0;j<namesArr1.length;j++){
		let theStaffName = namesArr1[j].name;
		let theID = namesArr1[j].data_id;

		let theTemplate = `<div class="formTagBox">
	<p class="tagName treatment_tagName" data_id = ${theID}>${theStaffName}</p>
	<div class="closeFormTagBox">
		<span><i class="uil uil-multiply"></i></span>
	</div>
</div>`;
theParenrtEl.append(theTemplate);
	}


	
})
$('body').delegate('.closeFormTagBox', 'click', function(){
	$(this).parent().remove();
	let thePEl = $(this).parent()[0]
    let theBlackSheep = thePEl.querySelector('.tagName').innerHTML;
	let theIdNeeded = thePEl.querySelector('.tagName').getAttribute('data_id');
	
	console.log(theIdNeeded)
	
let theMultiEl = $('.multipleSelect ul');
let theMultiElChildren = theMultiEl.children();

for(let i=0; i<theMultiElChildren.length; i++){
	if(theMultiElChildren[i].innerHTML === theBlackSheep){
		theMultiElChildren[i].classList.remove('dropDownPopuplistMenuActive')
	}
}

for(let j=0; j<namesArr1.length;j++){
	if(namesArr1[j].data_id === theIdNeeded){
		const index = namesArr1.indexOf(namesArr[j]);
				//console.log(index)
				if (index > -1) {
					namesArr1.splice(index, 1); 
				  }
	}
}

});
		


		//iputCountDropBtn
		$('body').delegate('.iputCountDropBtn', 'focus', function(){
			$(this).parent().find('.inputCountDropDownPopup').fadeIn();
		})
		$('body').delegate('.iputCountDropBtn', 'focusout', function(){
			$('.inputCountDropDownPopup').fadeOut();
		})
		$('body').delegate('.inputCountDropDownPopup ul li', 'click', function(){
			var countVal = $(this).text();
			$(this).parent().parent().parent().find('.iputCountDropBtn').val(countVal)
		});

		
		//file upload
		$('body').delegate('.fileInput', 'change', function(e){
			$(this).parent().parent().parent().find('.formGroupFileBox2').append(`<div class="formFileBox">
				<p>${e.target.files[0].name}</p>
				<div class="closeFormFileBox"><i class="uil uil-times"></i></div>
			</div>`);
		})
		$('body').delegate('.closeFormFileBox', 'click', function(){
			$(this).parent().remove();
		})
		
		$('.FileUploadAddBtn').click(function(){
			$('.commentsPopupPreviousFileUploadSectionTemplate').append(`
								<div class="commentsPopupPreviousFileUploadSectionBox" style="width :100%; display :flex; margin-top: 10px; background: #f6f7e7; border-radius: 10px; padding: 10px; flex-wrap: wrap;">
									<div class="formGroup">
										<label>File Name</label>
										<input type="text" class="report_name">
										<span style="color:red" class="file_name_error"></span>
									</div>
									<div class="formGroupFile">
										<div class="formGroupFileMain">
											<div class="formGroupFileBox1">
												<label>Upload File</label>
												<label class="uploadBtn">
  													<input type="file" class="fileInput report_file">
                                                    <p>Upload images</p>
                                                </label>
												<span style="color:red" class="file_error"></span>
											</div>
											<div class="formGroupFileBox2">
												
											</div>
										</div>
									</div>
								<div class="commentsPopupPreviousFileUploadSectionBoxremoveBtnarea">
									<div class="FileUploadRemoveBtn">Remove</div>
								</div>
								</div>`);				 
		});
		$('body').delegate('.FileUploadRemoveBtn', 'click', function(){
			$(this).parent().parent().remove();
		})
		

		

  </script>
	<script src="assets/appointment/fetch_all_todays_appointment_reffered_list.js?v=<?php echo $version_variable;?>"></script>
</body>
</html>
<?php
}else{
	header("Location:../login.php");
}
}else{
	header("Location:../login.php");
}
?>