<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['nurse_login_id']) and $_SESSION['nurse_role'] == 'nurse'){
$login_id = $_SESSION['nurse_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_nurse'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
if($check_security == 1){
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

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
								<li><b>Dr. Febin Rony </b></li>
								<li>BNYS,CRM(iiph)</li>
								<li>TCMC 261, Central Reg. 902</li>
								<li>Chief Consultant</li>
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
								<li><b>Dr. Lakshmi Mohan P</b></li>
								<li>BAMS</li>
								<li>TCMC 22475</li>
								<li>Ayurveda Physician</li>
							</ul>
						</div>
						<div class="doctorDetailBox">
							<ul>
								<li><b>Dr. Abin Sunny</b></li>
								<li>BNYS TCMC 410</li>
								<li>Visiting Consultant</li>
								<li>Naturopathy Yoga Physician</li>
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
				<h1>JOHNMARIAN WELLNESS CLINIC</h1>
				<p><i class="uil uil-location-point"></i> Behind Museum of Kerala History, Metro Pillar Number 349, Koonamthai, Pathadipalam, Cochin- 682024 <br><i class="uil uil-phone-alt"></i> Ph: (Reg) +91 87141 61636, 77 360 777 31 <i class="uil uil-envelope"></i> johnmarianwellness@gmail.com <i class="uil uil-globe"></i> www.drmanojjohnson.com</p>
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
            
                <!-- canvas head  -->
                <div class="canvasHead">
                    <div class="canvasHeadBox1">
                        <h1>Edit Appointments</h1>
                        <div class="breadCrumbs">
                            <a href="today-appointments.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="old-offline-appointments.php">Old Offline Appointments</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
					<div class="consultingWindowNextSextion">
						<!--<div  class="consultingWindowNextSextionBox secound_consultingNextBtn1">
							<!--<p id="secound_staff_name"></p>
							<button style="border: none; outline: none;" class="consultingNextBtn secound_consultingNextBtn button_disabled_status" disabled>Next</button>-->
						<!--</div>-->
					</div>
					<div class="consultingWindowHead">
						<div class="currentConsulting currentConsulting_patient">
							<div class="currentConsultinghead">
								<h1 id="current_patient_name"></h1>
								<p id="age_details"></p>
								<div class="UniqueId">
									<span id="current_patient_uniqueid"></span>
								</div>
								<!--style="display:none"-->
								<a style="display:none"  href="#" class="currentConsultingheadPrintBtn"><i class="uil uil-print" ></i> Print</a>
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
									<!--<div class="formGroup">
										<span>Place</span>
										<p id="current_patient_place"></p>
									</div>-->
								</div>
								<div class="buttonAreaList">
									<!--<button class="currentConsultingKeepWaitBtn">Keep Wait</button>-->
									<!--<button class="consultedBtn updateData">
										<span id="text">Update</span>
										<span id="loading"></span>
										<span id="done">Done</span>
									</button>-->
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
						<!--<div class="consultingWindowTable">
							<h1>BMI History</h1>
							<table>
								<thead>
									<tr>
										<th>Visit</th>
										<th>Date</th>
										<th>Height</th>
										<th>Weight</th>
										<th>BMI</th>
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
									</tr>
								</tbody>
							</table>
						</div>-->
					</div>

        <!-- comments popup -->
        <div class="commentsPopup">
			<!--<div class="commentsPopupHead">
				<h1>Prescription</h1>
				<div class="closeCommentsPopupBtn">Close</div>
			</div>-->
            <div class="commentsPopupMain" style="border-top: none; margin-top: 0; padding-top: 0;">
				<div class="commentsPopupTabBtnArea">
					<button class=" tablink active" onclick="openCity2(event,'tab1')" style="margin-top: 0;">Prescription</button>
					<!--<button class="tablink" onclick="openCity2(event,'tab2')">Comments</button>-->
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
						
						<!--<h2>Prescription</h2>-->
						<!--<div class="commentsPopupPrescriptionForm">
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
												<input type="text" class="morning_data">
											</div>
											<div class="checkBoxArea2">
												<label><i class="uil uil-sunset"></i></label>
												<input type="text" class="noon_data">
											</div>
											<div class="checkBoxArea2">
												<label><i class="uil uil-moon"></i></label>
												<input type="text" class="evening_data">
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No Of Days</label>
											<input type="text" class="no_days">
											<span id="quantity_error" style="color:red"></span>
										</div>
										<!--<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No.Of Days</label>
											<input type="text" class="no_days">
											<span id="noof_error" style="color:red"></span>
										</div>-->
										<!--<div class="formGroup4">
											<div class="checkBoxArea">
												<label for="afterFood">After Food</label>
												<input type="radio" class="morning_data" id="afterFood" name="foodMed">
											</div>
											<div class="checkBoxArea">
												<label for="beforeFood">Before Food</label>
												<input type="radio" class="noon_data" id="beforeFood" name="foodMed">
											</div>
											<span id="type_error" style="color:red"></span>
										</div>-->
										<!--<div class="formGrouptextarea">
											<label>Chief History</label>
											<textarea class="remark_data"></textarea>
										</div>-->
									<!--</div>
									<div class="tempPanelDiv"></div>
									<div class="tempPanelBtnArea">
										<div class="addMoreBtn">Add</div>
									</div>
								</div>
								<div class="formBtnArea">
									<button id="prescription_data">Save</button>
								</div>
							</form>
						</div>-->
					</div>
						<div class="commentsPopupPreviousMain" style="flex: 0 0 57%;">
					<div class="commentsPopupPrevious">
						<h2>Complaints History</h2>
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
							<div class="formGroup commentsTextarea_data">
								<div id="commentsTextarea"></div>
							</div>
							<div class="formBtnArea">
								<button class="saveCommentsPopupBtn commentsTextarea_btn">Save</button>
							</div>
						</form>
					</div>
						</div>
					</div>
					
					<!--<div class="dietSection">
						<div class="dietBox dite_details">
							<h2>Diet to be followed</h2>
							<ul>
								<!--<li>
									<input type="checkbox" id="diet1" value="Weight Management Diet" class="dite_details">
      								<label for="diet1">Grain-Free Diet/Weight Management Diet</label>
								</li>
								<li>
									<input type="checkbox" id="diet2" value="Low Protein Diet" class="dite_details">
      								<label for="diet2">Low Protein Diet</label>
								</li>
								<li>
									<input type="checkbox" id="diet3" value="Low Carb Diet" class="dite_details">
      								<label for="diet3">Low Carb Diet</label>
								</li>
								<li>
									<input type="checkbox" id="diet4" value="Wellness Diet" class="dite_details">
      								<label for="diet4">Wellness Diet</label>
								</li>-->
							<!--</ul>
						</div>
						<div class="dietBox food_details">
							<h2>Foods to be avoided</h2>
							<ul>
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
							<!--</ul>
						</div>
						<form>
							<div class="formGroup">
								<label>No.of days</label>
								<input type="text" id="noofDays">
							</div>
							<div class="formGroupTextArea">
								<label>Remark</label>
								<textarea id="food_remark"></textarea>
							</div>
						</form>
					</div>-->
				<!--<div class="commentsTextarea">
					<label>Remark</label>
					<textarea class="remark_data"></textarea>
				</div>-->
				</div>
				<div id="tab3" class="commentsPopupTabBox" style="display: none;">
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
				if(theLoopedLi.includes(theInpVal)){
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

		$(document).ready(function () {
			//create_custom_dropdowns();
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
            $('.shimmer').fadeOut();
        });
        $('.saveCommentsPopupBtn').click(function(e){
            e.preventDefault();
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
	<script src="assets/appointment/edit_appointment.js"></script>
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