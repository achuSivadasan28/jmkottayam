<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['admin_login_id']) and $_SESSION['admin_role'] == 'admin'){
$obj=new query();
$login_id = $_SESSION['admin_login_id'];
$api_key_value = $_SESSION['api_key_value'];
$admin_unique_code = $_SESSION['admin_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$admin_unique_code);
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
	
	  <!-- print design  -->
        <div class="printDesign">
            <!--<div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2>JOHNMARIAN WELLNESS HOSPITAL</h2>
					<p>P.P Road Kottayam , Meenachil P.O pala ,Kottayam 686577</p>
                    <p>Ph : 9562732575 | E-mail : johnmarianwellness@gmail.com | Web : drmanojjohnson.com</p>
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
                        <li id="invoice_data_details" style="display:none">
                            <span>Invoice Id <b>:</b></span>
                            <p id="tax_id_text"></p>
                        </li>
                        <li>
                            <span>Order Date & Time<b>:</b></span>
                            <p id="order_date_text"></p>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="printDesignTable">
				<div class="printDesignTable2">

				
				</div>
                <table>
                    <!--<thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>HSN <br>Code</th>
                            <th>Batch No</th>
                            <th>Expire Date</th>
                            <th>QTY</th>
                            <th>Taxable Value</th>
							<th>Tax %</th>
							<th>CGST</th>
							<th>SGST</th>
							<th>MRP</th>
                        </tr>
                    </thead>
                    <tbody class="tableInvoice---">
                           <!--<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>1</td>
                            <td>Paracetamol, Medicin Category</td>
                            <td>2</td>
                            <td>₹ 200</td>
                            <td>₹ 200</td>
                            <td>₹ 20</td>
                            <td>₹ 10</td>
                            <td>₹ 190</td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>2</td>
                            <td>Paracetamol, Medicin Category</td>
                            <td>2</td>
                            <td>₹ 200</td>
                            <td>₹ 200</td>
                            <td>₹ 20</td>
                            <td>₹ 10</td>
                            <td>₹ 190</td>
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
                       <!-- </tr>
					</tbody>
                    <tfoot>
						<tr style="page-break-inside: avoid; page-break-after: auto; display:none;" class="delivery_charge_section">
							<td colspan="1"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="border-top: 1px solid black; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total QTY</b></td>
                            <td ><b id="quantity_class"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total CGST</b></td>
							 <td><b id="cgst"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total SGST</b></td>
							 <td><b id="sgst"></b></td>
                        </tr>
                        <tr style="border-top: none; page-break-inside: avoid; page-break-after: auto;">
							<td colspan="1"></td>
                            <td class="tax_val_dis"><b>Total Amount</b></td>
                            <td style="text-align: left;"><b id="total_amt_1"></b></td>
                        </tr>
						
						
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="3"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
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
				<p>MICR Code : 682060003</p>
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>-->
        </div>
        <!-- print design close -->
    
    <main>

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
                    <p>Do you want to Cancel ?</p>
                    <div class="deleteAlertBtnArea">
                        <div class="closedeleteAlert">No</div>
                        <div class="confirmdeleteAlert">Delete</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete alert close -->
        
        <!-- profile Details Popup  -->
        <div class="profileDetailsPopup">
            <div class="profileDetailsPopupMain">
                <div class="profileDetailsPopupBox1">
                    <div class="profileDetailsHead">
                        <div class="UniqueId">
                            <span>AKR120622</span>
                        </div>
                        <h1>Muhammed Afsal K T</h1>
                    </div>
                    <div class="totalVisit">
                        <span>Total Visit : <b>5</b></span>
                    </div>
                    <div class="profileDetailsBody">
                        <ul>
                            <li>
                                <span>Age <b>:</b></span>
                                <p>24</p>
                            </li>
                            <li>
                                <span>Gender <b>:</b></span>
                                <p>Male</p>
                            </li>
                            <li>
                                <span>Phone <b>:</b></span>
                                <p>7356339750</p>
                            </li>
                            <li>
                                <span>Address <b>:</b></span>
                                <p>Kottiyottuthodi (H)</p>
                            </li>
                            <li>
                                <span>Place <b>:</b></span>
                                <p>Palakkadu</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="profileDetailsPopupBox2">
                    <h2>Comments <i class="uil uil-angle-down"></i></h2>
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
                        <div class="elseDesign">
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
                        <h1>Appointments</h1>
                    </div>
                </div>
                <!-- canvas head close -->
				
				<div class="reportBoxListSection">
					<div class="reportBoxList" style="background: cornflowerblue; color: white;display:flex;flex-direction:row;justify-content:space-between;">
					    <div>
							<h1 id="gpay_amt_data">0</h1>
							<p>Gpay</p>
						</div>
					</div>
					<div class="reportBoxList" style="background: coral; color: white;display:flex;flex-direction:row;justify-content:space-between;">
						<div>
							<h1 id="cash_tax_data">0</h1>
							<p>Cash</p>
						</div>
					</div>
					<div class="reportBoxList" style="background: forestgreen; color: white;display:flex;flex-direction:row;justify-content:space-between;">
						<div>
							<h1 id="card_amt_data">0</h1>
							<p>Card</p>
						</div>
					</div>
					<div class="reportBoxList" style="background: forestgreen; color: white;isplay:flex;flex-direction:row;justify-content:space-between;">
						<div>
							<h1 id="tmt_amt_data">0</h1>
							<p>Total Amount</p>
						</div>
						<div>
							<h1 id="treatment">0</h1>
							<p>Total Treatments</p>
						</div>
					</div>
				</div>
				
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                    <div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button id="serach_btn"><i class="uil uil-search"></i></button>
                                    </div>
                                    <div class="dateRange">
                                        <input type="date" id="startdate">
                                        <span></span>
                                        <input type="date" id="enddate">
                                        <button id="date_filter"><i class="uil uil-search"></i></button>
                                    </div>
									<a href="" class="addBtn export_reports">Export Excel</a>
                                </div>
                                <div class="consultAppointmentListTableBody appointment_tbl">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
													<th>Invoice Number</th>
                                                    <th>Name</th>
                                                    <th>Date</th>
													<th>Treatment Fee</th>
													<th>Payment Mode</th>
													<th>Type</th>
												    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="fee_reports">
                                                <!--<tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                      <td data-label="Name">
                                                        <p>JM001</p>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>300</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>06-07-2022</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" onclick="print()" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                    <!--  <tr>
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
                                        <p>No Data</p>
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
<script src="assets/appointment/fetch_treatmentfeereports.js?v=<?php echo $version_variable;?>"></script>
  

</body>
</html>
<?php
}else{
	header('Location:../login.php');
}
}else{
	header('Location:../login.php');
}	
?>