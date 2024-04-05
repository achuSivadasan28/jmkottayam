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
                        <h1>Edit Old Offline Appointments</h1>
                        <div class="breadCrumbs">
                            <a href="today-appointments.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="today-appointments.php">Today Appointments</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
					<div class="consultingWindowHead">
						<div class="currentConsulting currentConsulting_patient" style="display:none">
							<div class="currentConsultinghead">
								<h1 id="current_patient_name"></h1>
								<p id="age_details"></p>
								<div class="UniqueId">
									<span id="current_patient_uniqueid"></span>
								</div>
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
									<div class="currentConsultingKeepWaitBtn">Keep Wait</div>
									<button class="consultedBtn">
										<span id="text">Consulted</span>
										<span id="loading"></span>
										<span id="done">Done</span>
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
							<table>
								<thead>
									<tr>
										<th>Visit</th>
										<th>Date</th>
										<th>Weight</th>
										<th>BMI</th>
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
					<button class="tablink" onclick="openCity2(event,'tab3')" style="margin-top: 0;">Prescription History</button>
					<button style="margin-left: auto; margin-top: 0;" class="tablink" onclick="openCity2(event,'tab4')">Medical History</button>
					<button style=" margin-top: 0;" class="tablink" onclick="openCity2(event,'tab5')">Surgical History</button>
				</div>
				<div id="tab1" class="commentsPopupTabBox">
					<div class="commentsPopupTabBoxMain" style="display: flex; justify-content: space-between;">
					<div class="commentsPopupPrevious">
						<h2>Prescription</h2>
						<div class="commentsPopupPrescriptionForm">
							<form id="prescription_data_form">
								<div class="commentsPopupPrescriptionFormMain">
									<div class="tempPanel prescription_data main_prescription_div">
										<div class="formGroup">
											<label>Medicine</label>
											<div class="formSelect">
												<select name="" class="medicine_details">
												</select>
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
										<div class="formGroup4">
											<div class="checkBoxArea">
												<label for="afterFood">After Food</label>
												<input type="radio" class="morning_data" id="afterFood" name="foodMed">
											</div>
											<div class="checkBoxArea">
												<label for="beforeFood">Before Food</label>
												<input type="radio" class="noon_data" id="beforeFood" name="foodMed">
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
					
					<div class="dietSection">
						<div class="dietBox">
							<h2>Diet to be followed</h2>
							<ul>
								<li>
									<input type="checkbox" id="diet1" value="Weight Management Diet" class="dite_details">
      								<label for="diet1">Weight Management Diet</label>
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
								</li>
							</ul>
						</div>
						<div class="dietBox">
							<h2>Foods to be avoided</h2>
							<ul>
								<li>
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
								</li>
							</ul>
						</div>
					</div>
				<div class="commentsTextarea">
					<label>Remark</label>
					<textarea class="remark_data"></textarea>
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
									<!--<tr>
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
									</tr>-->
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div id="tab4" class="commentsPopupTabBox" style="display: none;">
						<div class="commentsPopupPreviousMain" style="flex:100%;">
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
				</div>
				<div id="tab5" class="commentsPopupTabBox" style="display: none;">
						<div class="commentsPopupPreviousMain" style="flex:100%;">
					<div class="commentsPopupPrevious">
						<h2>Surgical History</h2>
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
				</div>
            </div>
        </div>
        <!-- comments popup close -->
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
		
		//medicine add more 
		$('.addMoreBtn').click(function(){
			let api = 'de317f60c5d5182d99a2cf0fdc8f6175';
			let theParenrtEl = $('.tempPanelDiv');
			let theTemplate = `<div class="tempPanel prescription_data">
										<div class="formGroup">
											<label>Medicine</label>
											<div class="formSelect">
												<select name="" class="medicine_details">
												<option value=""></option>`;
																																		fetch("https://jmwell.in/api/fetchAll_medicine.php?api="+api)
												.then(response => response.json())
												.then(data => {
																																			console.log(data)
														data.map((x) =>{
															const {product_name,product_id} = x
									theTemplate +=`<option value="${product_id}">${product_name}												</option>`;
														})
													})
			.then(() => {
												theTemplate +=`</select>
											</div>
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
										</div>
										<!--<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No.Of Days</label>
											<input type="text" class="no_days">
										</div>-->
										<div class="formGroup4">
											<div class="checkBoxArea">
												<label for="afterFood">After Food</label>
												<input type="radio" class="morning_data" id="afterFood" name="foodMed2">
											</div>
											<div class="checkBoxArea">
												<label for="beforeFood">Before Food</label>
												<input type="radio" class="noon_data" id="beforeFood" name="foodMed2">
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<!--<div class="formGrouptextarea">
											<label>Chief History</label>
											<textarea class="remark_data"></textarea>
										</div>-->
										<div class="tempPanelBtnArea">
											<div class="removeMoreBtn">Remove</div>
										</div>
									</div>`;
			theParenrtEl.append(theTemplate)
			create_custom_dropdowns()
																																			})
			/**$('.dropdown-select ul').before('<div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>')**/
			
		})
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

    </script>
	<script src="assets/appointment/fetch_all_todays_appointment.js?v=<?php echo $version_variable;?>"></script>

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