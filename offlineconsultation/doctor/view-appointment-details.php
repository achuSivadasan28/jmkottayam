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
                        <h1>Appointments Details</h1>
                        <div class="breadCrumbs">
                            <a href="appointments.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="old-offline-appointments.php">Appointments</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
					<div class="consultingWindowHead">
						<div class="currentConsulting currentConsulting_patient">
							<div class="currentConsultinghead">
								<h1 id="current_patient_name"></h1>
								<p id="age_details"></p>
								<div class="UniqueId">
									<span id="current_patient_uniqueid"></span>
								</div>
								<a  href="#" style="display:none" class="currentConsultingheadPrintBtn"><i class="uil uil-print"></i>Print</a>
							</div>
							
							<div class="currentConsultingBody">
								<div class="currentConsultingBox">
									<div class="formGroup" style="display: none;">
										<span>Phone Number</span>
										<p id="current_patient_phn"></p>
									</div>
									<div class="formGroup">
										<span>Illness</span>
										<p id="present_Illness"></p>
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
						<div class="consultingWindowTable">
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
									<tbody>
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
        <div class="commentsPopup">
			<!--<div class="commentsPopupHead">
				<h1>Prescription</h1>
				<div class="closeCommentsPopupBtn">Close</div>
			</div>-->
            <div class="commentsPopupMain" style="border-top: none; margin-top: 0; padding-top: 0;">
				<div class="commentsPopupTabBtnArea">
					<button class="tablink active" style="margin-top: 0;" onclick="openCity2(event,'tab1')">History</button>
					<button class="tablink" onclick="openCity2(event,'tab10')" style="margin-top: 0;">Lab</button>
					<button class="tablink" onclick="openCity2(event,'tab11')" style="margin-top: 0;">Treatment</button>
					<!--<button class="tablink" style="margin-top: 0;" onclick="openCity2(event,'tab3')">Prescription History</button>
					<button style="margin-left: auto; margin-top: 0;" class="tablink" onclick="openCity2(event,'tab4')">Medical History</button>
					<button style=" margin-top: 0;" class="tablink" onclick="openCity2(event,'tab5')">Surgical History</button>-->
				</div>
				
				
				
				
				<div id="tab1" class="commentsPopupTabBox">
					<div class="commentsPopupTabBoxMain" style="width: 100%; display: flex; justify-content: space-between; flex-wrap: wrap;">
						
						
						<div class="commentsPopupPrevious" style="flex: 0 0 48%;">
							<h2>Complaints History</h2>
							<div class="commentsPopupPreviousList commentsPopupPreviousList_complaints">
								<dl><dt class="PreviousListDate">
									<span>06-10-2022</span>
									</dt><dd class="commentsPopupPreviousBox">
									<p>Cold with a slight fever</p><p>Intermittent headache</p><p>Vomiting&nbsp;</p>
									</dd></dl>
								<div class="elseDesign">
									<div class="elseDesignthumbnail">
										<img src="assets/images/empty.png" alt="">
									</div>
									<p>No Previous Comments</p>
								</div>
							</div>
						</div>
						
						
						<div class="commentsPopupPrevious" style="flex: 0 0 48%;">
							<h2>Prescription History</h2>
							<div class="prescriptionHistoryList">
								<div class="prescriptionHistoryListMain prescriptionHistoryListMain_history">
									
									
									
								
								<div class="prescriptionHistoryListTable">
									<table>
										<thead>
											<tr>
												<th colspan="7" style="background: #7868e6; color: white;">01-01-2022</th>
											</tr>
											<tr>
												<th>Medicine</th>
												<th>No Of Days</th>
												<th><i class="uil uil-sun"></i></th>
												<th><i class="uil uil-sunset"></i></th>
												<th><i class="uil uil-moon"></i></th>
												<th>Medication Guidlines</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Grey Forte</td>
												<td>10</td>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>After Food</td>
												<td>
													<div class="prescriptionHistoryBtnArea">
														<button class="prescriptionHistoryEditBtn" branch_id="4" data-id="47172">
															<i class="uil uil-edit"></i>
														</button>
														<button class="prescriptionHistoryDeleteBtn" branch_id="4" data-id="47172">
															<i class="uil uil-trash"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>Grey Forte</td>
												<td>10</td>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>After Food</td>
												<td>
													<div class="prescriptionHistoryBtnArea">
														<button class="prescriptionHistoryEditBtn" branch_id="4" data-id="47172">
															<i class="uil uil-edit"></i>
														</button>
														<button class="prescriptionHistoryDeleteBtn" branch_id="4" data-id="47172">
															<i class="uil uil-trash"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>Grey Forte</td>
												<td>10</td>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>After Food</td>
												<td>
													<div class="prescriptionHistoryBtnArea">
														<button class="prescriptionHistoryEditBtn" branch_id="4" data-id="47172">
															<i class="uil uil-edit"></i>
														</button>
														<button class="prescriptionHistoryDeleteBtn" branch_id="4" data-id="47172">
															<i class="uil uil-trash"></i>
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
									<table>
										<thead>
											<tr>
												<th colspan="7" style="background: #7868e6; color: white;">01-01-2022</th>
											</tr>
											<tr>
												<th>Medicine</th>
												<th>No Of Days</th>
												<th><i class="uil uil-sun"></i></th>
												<th><i class="uil uil-sunset"></i></th>
												<th><i class="uil uil-moon"></i></th>
												<th>Medication Guidlines</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>Grey Forte</td>
												<td>10</td>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>After Food</td>
												<td>
													<div class="prescriptionHistoryBtnArea">
														<button class="prescriptionHistoryEditBtn" branch_id="4" data-id="47172">
															<i class="uil uil-edit"></i>
														</button>
														<button class="prescriptionHistoryDeleteBtn" branch_id="4" data-id="47172">
															<i class="uil uil-trash"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>Grey Forte</td>
												<td>10</td>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>After Food</td>
												<td>
													<div class="prescriptionHistoryBtnArea">
														<button class="prescriptionHistoryEditBtn" branch_id="4" data-id="47172">
															<i class="uil uil-edit"></i>
														</button>
														<button class="prescriptionHistoryDeleteBtn" branch_id="4" data-id="47172">
															<i class="uil uil-trash"></i>
														</button>
													</div>
												</td>
											</tr>
											<tr>
												<td>Grey Forte</td>
												<td>10</td>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>After Food</td>
												<td>
													<div class="prescriptionHistoryBtnArea">
														<button class="prescriptionHistoryEditBtn" branch_id="4" data-id="47172">
															<i class="uil uil-edit"></i>
														</button>
														<button class="prescriptionHistoryDeleteBtn" branch_id="4" data-id="47172">
															<i class="uil uil-trash"></i>
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
									
									
									
									
									<!--<div class="prescriptionHistoryListBox">
										<div class="prescriptionHistoryListBoxHead">
											<div class="prescriptionHistoryDate">06-10-2022</div>
											<div class="prescriptionHistoryBtnArea">


											</div>
										</div>
										<div class="prescriptionHistoryListBoxBody">
											<div class="prescriptionHistoryRow">
												<div class="prescriptionHistoryRowBox1">
													<p>Mag. Citrate</p>
												</div>
												<div class="prescriptionHistoryRowBox2">
													<div class="count">0</div>
													<div class="count">0</div>
													<div class="count">1</div>
												</div>
												<div class="prescriptionHistoryRowBox3">
													<p>15 Days</p>
												</div>
												<div class="prescriptionHistoryRowBox4">
													<p>After Food </p>
												</div>
											</div>
										</div>
									</div>
									<div class="prescriptionHistoryListBox">
										<div class="prescriptionHistoryListBoxHead">
											<div class="prescriptionHistoryDate">06-10-2022</div>
											<div class="prescriptionHistoryBtnArea">


											</div>
										</div>
										<div class="prescriptionHistoryListBoxBody">
											<div class="prescriptionHistoryRow">
												<div class="prescriptionHistoryRowBox1">
													<p>Cure alone</p>
												</div>
												<div class="prescriptionHistoryRowBox2">
													<div class="count">1</div>
													<div class="count">1</div>
													<div class="count">1</div>
												</div>
												<div class="prescriptionHistoryRowBox3">
													<p>7 Days</p>
												</div>
												<div class="prescriptionHistoryRowBox4">
													<p>After Food </p>
												</div>
											</div>
										</div>
									</div>-->
								</div>
							</div>
							<div class="prescriptionRemark" style="width: 100%; display: flex; border: 1px solid #ccc;  flex-direction: column;margin-top: 10px; padding: 10px;border-radius: 10px;">
								<h2 style="margin-top: 0;">Remark</h2>
								<p style="font-size: 14px; line-height: 1.5; margin-top: 5px;" id="remark_data"></p>
							</div>							
						</div>
						
						
						<div class="commentsPopupPrevious" style="flex: 0 0 48%;">
							<h2>Medical History</h2>
								<div class="commentsPopupPreviousList commentsPopupPreviousList_medical">
									<dl><dt class="PreviousListDate">
									<span>06-10-2022</span>
								</dt><dd class="commentsPopupPreviousBox">
							NIL
								</dd>
									</dl>
									<div class="elseDesign">
										<div class="elseDesignthumbnail">
											<img src="assets/images/empty.png" alt="">
										</div>
										<p>No Previous Comments</p>
									</div>
							</div>
						</div>
						
						
						<div class="commentsPopupPrevious" style="flex: 0 0 48%;">
								<h2>Investigations</h2>
								<div class="commentsPopupPreviousList commentsPopupPreviousList_surgical">
									<dl><dt class="PreviousListDate">
									<span>06-10-2022</span>
								</dt><dd class="commentsPopupPreviousBox">
							NIL
								</dd></dl>
									<div class="elseDesign">
										<div class="elseDesignthumbnail">
											<img src="assets/images/empty.png" alt="">
										</div>
										<p>No Previous Comments</p>
									</div>
								</div>
							</div>
						<div class="dietSection">
						<div class="dietBox">
							<h2>Diet to be followed</h2>
							<ul id="diteBox_data"><li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>low protein diet</p>
								</li></ul>
						</div>
						<div class="dietBox">
							<h2>Foods to be avoided</h2>
							<ul id="food_tobe_avoid"><li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>broccoli</p>
								</li><li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>DETOX DIET</p>
								</li><li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Tamarind</p>
								</li><li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>red meat</p>
								</li><li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>citric foods</p>
								</li></ul>
						</div>
					</div>
						
					</div>
				</div>
					
					
					
				<div id="tab10" class="commentsPopupTabBox" style="display: none;">
					<div class="historyList">
						<div class="commentsPopupPrevious" style="flex: 100%">
							<h2>Reports</h2>
							<div class="labTestHistorySection lab_report">
								<div class="labTestHistorySectionBox">
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
										</div>
										
										<!-- dont remove the div-->
										<!--<div class="dummyDiv"></div>-->
										<!-- dont remove the div-->
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div id="tab11" class="commentsPopupTabBox"  style="display:none">
					<div class="historyList">
						<div class="commentsPopupPrevious" style="flex: 100%">
							
							<!--<h2>Mark Treatment</h2>-->
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

							<!--<div class="formWraperBox">
							<div class="formTagArea selected_treatment_report">
                                    
                            </div>
								<div class="formGroup">
									<label for="" style="font-size:12px;margin-bottom:5px;">Select Treatment</label>
									<div class="dropDownSection">
										<div class="dropDownInput">
											<input type="text" class="dropDownInputText" disabled>
										</div>
										
										<div class="dropDownPopup">
											<div class="dropDownSearch">
												<input type="search" class="searchDropDown-field" placeholder="Search...">
											</div>
											
											<div class="dropDownPopuplist multipleSelect treatment_data">
												<ul>-->
													<!--<li data-id=1>a</li>
													<li data-id=2>b</li>
													<li data-id=3>c</li>-->
												<!--</ul>
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

                                
							</div>-->
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
				
				
				
				
				
				<!--<div id="tab2" class="commentsPopupTabBox" style="display: none;">
					<div class="commentsPopupTabBoxMain" style="width: 100%; display: flex; justify-content: space-between;">
						<div class="commentsPopupPreviousMain" style="flex: 100%;">
					<div class="commentsPopupPrevious">
						<h2>Complaints History</h2>
						<div class="commentsPopupPreviousList commentsPopupPreviousList_complaints">-->
							<!-- ---------<dl>
							<dt class="PreviousListDate">
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
								</dd>
							</dl>----- -->
							<!--<div class="elseDesign">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>
				<div id="tab3" class="commentsPopupTabBox" style="display: none;">
					<div class="commentsPopupPrevious" Style="flex: 100%">
						<h2>Prescription History</h2>
						<div class="prescriptionHistory">
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
									<tr>
										<td>Medicine 1</td>
										<td>10</td>
										<td>Morning</td>
										<td>1</td>
										<td>01-09-2022</td>
									</tr>
									<tr>
										<td>Medicine 2</td>
										<td>5</td>
										<td>Noon</td>
										<td>.5</td>
										<td>01-09-2022</td>
									</tr>
									<tr>
										<td>Medicine 3</td>
										<td>10</td>
										<td>Night</td>
										<td>1</td>
										<td>01-09-2022</td>
									</tr>
								</tbody>
							</table>
						</div>
					
					<div class="dietSection">
						<div class="dietBox">
							<h2>Diet to be followed</h2>
							<ul id="diteBox_data">
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Weight Management Diet</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Low Protein Diet</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Low Carb Diet</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Wellness Diet</p>
								</li>
							</ul>
						</div>
						<div class="dietBox">
							<h2>Foods to be avoided</h2>
							<ul id="food_tobe_avoid">
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Milk, Milk with tea, Ice Cream</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Wheat, Maida, Oats, Rava, Atta</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Soy Products</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Coffee</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Tea</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Sugar</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Salt</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Egg</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Meat</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Fish</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Brinjal</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Ladies Finger</p>
								</li>
								<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>Tomato</p>
								</li>
							</ul>
						</div>
					</div>
					</div>
				</div>
				<div id="tab4" class="commentsPopupTabBox" style="display: none;">
						<div class="commentsPopupPreviousMain" style="flex:100%;">
					<div class="commentsPopupPrevious">
						<h2>Medical History</h2>
						<div class="commentsPopupPreviousList commentsPopupPreviousList_medical">
							<dl>
								<!-- --------<dt class="PreviousListDate">
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
								</dd>-------- -->
							<!--</dl>
							<div class="elseDesign">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
						</div>
				</div>
				<div id="tab5" class="commentsPopupTabBox" style="display: none;">
						<div class="commentsPopupPreviousMain" style="flex:100%;">
					<div class="commentsPopupPrevious">
						<h2>Surgical History</h2>
						<div class="commentsPopupPreviousList commentsPopupPreviousList_surgical">
							<dl>
								<dt class="PreviousListDate">
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
								</dd>
							</dl>
							<div class="elseDesign">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
						</div>
				</div>
					
            </div>-->
        </div>
        <!-- comments popup close -->
                </div>
                <!-- consultingWindow close -->

            </div>
            <!-- canvas close -->
			</div>
        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
	<script src="assets/appointment/fetch_all_previous_history.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->
	<!--<script src="assets/appointment/fetch_all_todays_appointment.js"></script>-->
	
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
	</script>

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