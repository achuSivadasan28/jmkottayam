<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['staff_login_id']) and $_SESSION['staff_role'] == 'treatment_staff'){
$login_id = $_SESSION['staff_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
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
		
	
	<!-- page loader-->
	<div class="pageLoader">
		<div class="spinner">
			<div class="circle"></div>
		</div>
	</div>
	<!-- page loader close-->
		

        <!-- shimmer -->
        <div class="shimmer"></div>
        <!-- shimmer close -->
		        <!-- comments popup -->
        <div class="commentsPopup2">
			<div class="commentsPopupHead">
				<h1>Prescription</h1>
				<div class="closeCommentsPopupBtn">Close</div>
			</div>
            <div class="commentsPopupMain">
				<div class="commentsPopupTabBtnArea">
					<button style="display:none" class=" tablink" onclick="openCity2(event,'tab1')">Prescription</button>
					<button class="tablink active" onclick="openCity2(event,'tab2')">Comments</button>
					<button class="tablink" onclick="openCity2(event,'tab3')">Prescription History</button>
				</div>
				<div id="tab1" class="commentsPopupTabBox" style="display: none;">
					<div class="commentsPopupPrevious" Style="flex: 100%">
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
										<div class="formGroup formGroup2">
											<label>Quantity</label>
											<input type="text" class="quantity_data">
											<span id="quantity_error" style="color:red"></span>
										</div>
										<div class="formGroup3">
											<div class="checkBoxArea">
												<label>Morning</label>
												<input type="checkbox" class="morning_data">
											</div>
											<div class="checkBoxArea">
												<label>Noon</label>
												<input type="checkbox" class="noon_data">
											</div>
											<div class="checkBoxArea">
												<label>Evening</label>
												<input type="checkbox" class="evening_data">
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<div class="formGroup formGroup2">
											<label>No.Of Days</label>
											<input type="text" class="no_days">
											<span id="noof_error" style="color:red"></span>
										</div>
										<div class="formGrouptextarea">
											<label>Remark</label>
											<textarea class="remark_data"></textarea>
										</div>
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
				</div>
				<div id="tab2" class="commentsPopupTabBox">
					<div class="commentsPopupPrevious">
						<h2>Previous Comments</h2>
						<div class="commentsPopupPreviousList">
							<dl>
								<!--<dt class="PreviousListDate">
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
							<div class="elseDesign elseDesign_comments">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Previous Comments</p>
							</div>
						</div>
					</div>
					<!--<div class="commentsPopupForm">
						<h2>Add Comments</h2>
						<form action="">
							<div class="formGroup">
								<div id="commentsTextarea"></div>
							</div>
							<div class="formBtnArea">
								<button class="saveCommentsPopupBtn">Save</button>
							</div>
						</form>
					</div>-->
				</div>
				<div id="tab3" class="commentsPopupTabBox" style="display: none;">
					<div class="commentsPopupPrevious" Style="flex: 100%">
						<h2>Prescription History</h2>
						<div class="prescriptionHistory">
							<table>
								<thead>
									<tr>
										<th>Medicine</th>
										<th>Quantity</th>
										<th>Time</th>
										<th>No.Of Days</th>
										<th>Date</th>
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
					</div>
				</div>
            </div>
        </div>
        <!-- comments popup close -->
        
        <!-- profile Details Popup  -->
        <div class="profileDetailsPopup">
            <div class="profileDetailsPopupMain">
                <div class="profileDetailsPopupBox1">
                    <div class="profileDetailsHead">
                        <div class="UniqueId">
                            <span id="unique_code"></span>
                        </div>
                        <h1 id="patient_name"></h1>
                    </div>
                    <div class="totalVisit">
                        <span>Total Visit : <b id="visit"></b></span>
                    </div>
                    <div class="profileDetailsBody">
                        <ul>
                            <li>
                                <span>Age <b>:</b></span>
                                <p id="age"></p>
                            </li>
                            <li>
                                <span>Gender <b>:</b></span>
                                <p id="gender"></p>
                            </li>
                            <li>
                                <span>Phone <b>:</b></span>
                                <p id="phnnumber"></p>
                            </li>
                            <li>
                                <span>Address <b>:</b></span>
                                <p id="addressData"></p>
                            </li>
                            <li>
                                <span>Place <b>:</b></span>
                                <p id="place"></p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profileDetailsPopupBox2">
					<div class="profileDetailsPopupBox2Head">
						<h2>Comments <i class="uil uil-angle-down"></i></h2>
						<!--<div class="printBtn"><i class="uil uil-print"></i> Print</div>-->
					</div>
                    <div class="commentsPopupPreviousList">
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
                            <dd class="commentsPopupPreviousBox">
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas quisquam suscipit amet accusamus in nam, rem quasi laborum odit exercitationem similique dignissimos omnis, et culpa obcaecati enim necessitatibus! Animi, reiciendis.</p>
                            </dd>
                        </dl>
                        <div class="elseDesign elseDesign_comments">
                            <div class="elseDesignthumbnail">
                                <img src="assets/images/empty.png" alt="">
                            </div>
                            <p>No Previous Comments</p>
                        </div>
                    </div>
                    <div class="profileDetailsPopupBtnArea">
                        <div class="closeProfileDetailsPopup">Close</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile Details Popup close -->
        
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
                        <h1>Old Offline Appointments</h1>
                        <div class="breadCrumbs">
                            <a href="old-appointments.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="old-appointments.php">Old Appointments</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>
                                    <div class="dateRange">
                                        <input type="date" id="start_date">
                                        <span></span>
                                        <input type="date" id="end_date">
                                        <button id="date_filter_btn"><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
										<div class="sckelly">
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
											<div class="sckellyLoader"></div>
										</div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                    <th>Place</th>
                                                    <th>Date</th>
													<th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <!--  <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
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
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
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
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
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
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
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
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
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
                                                    <td data-label="Place">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="viewDetailsBtn">View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>-->
                                            </tbody>
                                        </table>
                                    </div>
																																	<div class="pagination">
            							<ul>
              <!--pages or li are comes from javascript --> 
            							</ul>
          							</div>
                                    <div class="elseDesign">
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
	<script src="assets/appointment/old-appointments-data.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->

    <script>
		

        // view Details popup
        $('.viewDetailsBtn').click(function(){
            $('.shimmer').fadeIn();
            $('.profileDetailsPopup').fadeIn();
        });
        $('.closeProfileDetailsPopup').click(function(){
            $('.shimmer').fadeOut();
            $('.profileDetailsPopup').fadeOut();
        });
		
		//print btn 
		$('.printBtn').click(function(){
			window.print();
		})

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