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
	
	
		 <div class="printDesign">
           <!-- <div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2>JOHNMARIAN WELLNESS HOSPITAL</h2>
					<p>P.P Road Kottayam , Meenachil P.O pala ,Kottayam 686577</p>
                    <p>Ph : 7736077731 || 8714161636 | E-mail : johnmarianwellness@gmail.com | Web : drmanojjohnson.com</p>
                    <p><b>GST Number : 32BNFPG3513BIZV</b></p>
					<h2>Tax invoice</h2>
                </div>
            </div>
            <div class="printDesignProfile">
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Invoice No <b>:</b></span>
                            <p id="unique_id_text"></p>
                        </li>
                        <li>
                            <span>Customer Name <b>:</b></span>
                            <p id="customer_name_text"></p>
                        </li>
                        <li>
                            <span>Mobile No <b>:</b></span>
                            <p id="mob_num_text"></p>
                        </li>
                    </ul>
                </div>
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Bill Date & Time<b>:</b></span>
                            <p id="order_date_text"></p>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="printDesignTable">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Treatement</th>
                            <th>Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody class="tableInvoice">
                           <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>1</td>
                            <td>t1</td>
                            <td>₹ 200</td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>2</td>
                            <td>t1</td>
                            <td>₹ 200</td>
                        </tr>

                    </tbody>
					
					<tbody class="taxDiv" style="border-top: 1px solid black;">
						<!--<tr style="page-break-inside: avoid; page-break-after: auto; border-bottom: 1px dashed black;">
                            <td colspan="5" class="tax_val_dis1"><b></b></td>
                            <td colspan="1"><b id="quantity_class1"></b></td>
							<td colspan="1"><b id="tax_in_per_data">@18%</b></td>
							<td colspan="1"><b id="tax_in_per_data"></b></td>
							 <td colspan="1"><b id="total_cgst_in_per">₹ 12</b></td>
							 <td colspan="1"><b id="total_sgst_in_per">₹ 12</b></td>-->
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                           <!-- <td colspan="0" style="text-align: left;"><b id="total_amt_11"></b></td>-->
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                       <!-- </tr>-->
					<!--</tbody>
                    <tfoot>
						<tr style="page-break-inside: avoid; page-break-after: auto; display:none;" class="delivery_charge_section">
							<td colspan="9"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="5" class="tax_val_dis"><b>Total</b></td>
                            <td colspan="3"><b id="quantity_class"></b></td>
							 <td colspan="1"><b id="cgst"></b></td>
							 <td colspan="1"><b id="sgst"></b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <!--<td colspan="0" style="text-align: left;"><b id="total_amt_1"></b></td>
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                       <!-- </tr>
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>-->
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="12"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
				<!--<h2>Bank Details</h2>
				<p>Account Name : JOHNMARIAN WELLNESS CLINIC</p>
				<p>Account Number : 306530123456789</p>
				<p>Branch: KALAMASSERY</p>
				<p>Account Type : Current Account</p>
				<p>IFSC Code : TMBL0000306</p>
				<p>MICR Code : 682060003</p>-->
                <!--<h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>-->
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

        <!--fee collection popup-->
		<div class="feeCollectionPopup">
			<div class="feeCollectionPopupHead">
				<h1>Treatment Fee Collection</h1>
				<div class="closeFeeCollectionPopupBtn"><i class="uil uil-multiply"></i></div>
			</div>
			<form>
				
			
				<div class="feeCollectionPopupAddTreatmentSection">
					<div class="feeCollectionPopupAddTreatmentSectionTemp">
						<div class="formGroup">
							<label>Choose Treatment</label>
							<div class="dropDownSection">
								<div class="dropDownInput">
									<input type="text" class="dropDownInputText" disabled="" style="box-shadow: rgba(0, 0, 0, 0.06) 0px 0px 20px;position:relative;z-index:-1">
								</div>

								<div class="dropDownPopup">
									<div class="dropDownSearch">
										<input type="search" class="searchDropDown-field" placeholder="Search...">
									</div>

									<div class="dropDownPopuplist singleSelect treatment_data">
										<ul>
											
										</ul>
										<div class="elseDesign" style="display: none;">
											<div class="elseDesignthumbnail">
												<img src="assets/images/empty.png" alt="">
											</div>
											<p>No Data Available</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="formGroup">
							<label>Amount</label>
							<input type="number" class="treatment_amt" value="0">
							<span class="error_num"></span>
						</div>
						<div class="feeCollectionPopupAddTreatmentSectionTempBtnArea">
							<div class="feeCollectionPopupAddTreatmentSectionTempAddBtn">Add</div>
						</div>
					</div>
					<div class="feeCollectionPopupAddTreatmentSectionTempCopy"></div>
				</div>
				<div class="feeCollectionPopupBody">
					<!--<div class="feeCollectionPopupBox">
						<p>Treatement Name</p>
						<input type="number">
					</div>
					<div class="feeCollectionPopupBox">
						<p>Treatement Name</p>
						<input type="number">
					</div>
					<div class="feeCollectionPopupBox">
						<p>Treatement Name</p>
						<input type="number">
					</div>
					<div class="paymentMood">
						<h2>Payment Mood</h2>
						<div class="paymentMoodBox">
							<select>
								<option>Cash</option>
								<option>Google Pay</option>
								<option>Card</option>
							</select>
							<input type="number">
							<div class="addPaymentMoodBtn">Add</div>
						</div>
						<div class="paymentMoodBoxTemplate"></div>
					</div>-->
				</div>
					<span id="amt_error" style="color:red"></span>
				<input type="hidden" id="amt_error_val">
				<div class="feeCollectionPopupFooter">
					<div class="totalAmnt"><p>Total :</p> <b class="total_amt_details">₹ 0</b></div>
					<button id="treatment_btn" disabled=true>Save</button>
				</div>
			</form>
		</div>
		<!--fee collection popup close -->
        
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
								<!--<a  href="#" style="display:none" class="currentConsultingheadPrintBtn"><i class="uil uil-print"></i>Print</a>-->
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
								<div class="buttonAreaList">
									<!--<button class="currentConsultingKeepWaitBtn">Keep Wait</button>-->
									<button class="consultedBtn" style="display:none">
										<span id="text" class="consult_btn active_btn">completed</span>
										<span id="loading" class="consult_btn"></span>
										<span id="done" class="consult_btn">Done</span>
									</button>
									<div class="collectFeeBtn" style="display:flex">Collect Fee</div>
									<a href="" class="print_enable printFeeBtn" style="display:none">Print</a>
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

        <!-- comments popup -->
        <div class="commentsPopup">
			<!--<div class="commentsPopupHead">
				<h1>Prescription</h1>
				<div class="closeCommentsPopupBtn">Close</div>
			</div>-->
            <div class="commentsPopupMain" style="border-top: none; margin-top: 0; padding-top: 0;">
				<div class="commentsPopupTabBtnArea">
					<button class="tablink active" style="margin-top: 0;" onclick="openCity2(event,'tab6')">Treatment</button>
					<button class="tablink" style="margin-top: 0;" onclick="openCity2(event,'tab7')">Bills</button>
					<!--<button class="tablink active" style="margin-top: 0;" onclick="openCity2(event,'tab1')">History</button>
					<button class="tablink" onclick="openCity2(event,'tab10')" style="margin-top: 0;">Lab</button>-->
					<!--<button class="tablink" style="margin-top: 0;" onclick="openCity2(event,'tab3')">Prescription History</button>
					<button style="margin-left: auto; margin-top: 0;" class="tablink" onclick="openCity2(event,'tab4')">Medical History</button>
					<button style=" margin-top: 0;" class="tablink" onclick="openCity2(event,'tab5')">Surgical History</button>-->
				</div>
				
				
				
					
				<div id="tab6" class="commentsPopupTabBox" style="display: flex;">
					<div class="historyList">
						<div class="commentsPopupPrevious" style="flex: 100%">
							<div class="commentsPopupPreviousFileUploadSection">
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
							</div>
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
					
				<div id="tab7" class="commentsPopupTabBox" style="display: none;">
					<div class="historyList">
						<div class="commentsPopupPrevious" style="flex: 100%">
							<h2>Reports</h2>
							<div class="labTestHistorySection">
								<div class="labTestHistorySectionBox">
									<!--<div class="labTestHistoryDate">01-01-2023</div>-->
									<div class="labTestHistoryReport Invoice_report">
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
										
									</div>
								</div>
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
		
		//add terament
		$('body').delegate('.feeCollectionPopupAddTreatmentSectionTempAddBtn', 'click', function(){
			let template = `<div class="feeCollectionPopupAddTreatmentSectionTemp">
						<div class="formGroup">
							<label>Treatment</label>
							<div class="dropDownSection">
								<div class="dropDownInput">
									<input type="text" class="dropDownInputText" disabled="" style="box-shadow: rgba(0, 0, 0, 0.06) 0px 0px 20px;position:relative;z-index:-1">
								</div>

								<div class="dropDownPopup">
									<div class="dropDownSearch">
										<input type="search" class="searchDropDown-field" placeholder="Search...">
									</div>

									<div class="dropDownPopuplist singleSelect lab_report">
										<ul>`;
			$.ajax({
				url:"action/appointment/fetch_all_treatment.php",
				success:function(result_data){
				let result_data_json = jQuery.parseJSON(result_data)
				console.log("treatment")
				console.log(result_data_json)
					let lab_len = result_data_json.length
					let loop_c = 1;
				if(result_data_json.length !=0){
				for(let x=0;x<result_data_json.length;x++){
				template += `<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['treatment']}</li>`
				loop_c++
				if(lab_len == loop_c){
				template += `</ul>
										<div class="elseDesign" style="display: none;">
											<div class="elseDesignthumbnail">
												<img src="assets/images/empty.png" alt="">
											</div>
											<p>No Data Available</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="formGroup">
							<label>Amount</label>
							<input type="number" class="treatment_amt" value="0">
							<span class="error_num"></span>
						</div>
						<div class="feeCollectionPopupAddTreatmentSectionTempBtnArea">
							<div class="feeCollectionPopupAddTreatmentSectionTempDeleteBtn">Remove</div>
						</div>
					</div>`;
			$('.feeCollectionPopupAddTreatmentSectionTempCopy').append(template)
				}
			}
			}
		}
	})
			
		})
		$('body').delegate('.feeCollectionPopupAddTreatmentSectionTempDeleteBtn', 'click', function(){
			$(this).parent().parent().remove();
		})
		

		
// dropdown 
$('body').delegate('.dropDownInput', 'click', function(e){
	e.stopPropagation();
	var imagePos = $(this).parent('.dropDownSection').offset().top;
	var topOfWindow = $(window).scrollTop();
	if (imagePos < topOfWindow+700) {
		$('.dropDownPopup').removeClass('dropDownPopupUp');
		$('.dropDownPopup').removeClass('dropDownPopupDown');
		//$(this).parent().find('.dropDownPopup').addClass('dropDownPopupDown');
		
		var $container = $(this).parent();
		var $containerposition = $container.position();

		$(this).parent().find(".dropDownPopup").css({
			bottom: $container.innerHeight() + 50 + "px",
			left: $containerposition.left,
		});				
		$(this).parent().find('.dropDownPopup').addClass('dropDownPopupUp');   
								   
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
		//$(this).parent().find('.dropDownPopup').addClass('dropDownPopupUp');
		
		var $container = $(this).parent();
		var $containerposition = $container.position();

		$(this).parent().find(".dropDownPopup").css({
			bottom: $container.innerHeight() + 50 + "px",
			left: $containerposition.left,
		});				
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
$('body').delegate('.searchDropDown-field', 'keyup', function(e){
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


// let theStaffList = document.createElement('ul');
let namesArr = [];
let namesArr1 = [];
$('div').delegate('.treatment_data ul li','click',function(){
	
	var liTxt = $(this).text();
	var data_id = $(this).attr('data-id')
	console.log(data_id)
	$(this).toggleClass('dropDownPopuplistMenuActive');
	$(this).parent().parent().parent().parent().find('.dropDownInputText').val(liTxt);
	$('.searchDropDown-field').val('');
	$('.treatment_data ul li').show();
	
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
	
let theMultiEl = $('.singleSelect ul');
let theMultiElChildren = theMultiEl.children();

for(let i=0; i<theMultiElChildren.length; i++){
	if(theMultiElChildren[i].innerHTML === theBlackSheep){
		theMultiElChildren[i].classList.remove('dropDownPopuplistMenuActive')
	}
}

for(let j=0; j<namesArr.length;j++){
	if(namesArr[j].data_id === theIdNeeded){
		const index = namesArr.indexOf(namesArr[j]);
				//console.log(index)
				if (index > -1) {
					namesArr.splice(index, 1); 
				  }
	}
}

});
	
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