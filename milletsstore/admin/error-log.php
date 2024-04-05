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
	$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
if($check_security == 1){
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->
	<style>
		.FollowupQuotationPopup{
  position: fixed;
  transform: translate(-50%, -50%);
  top: 50%;
  left: 50%;
  z-index: 110;
  background: white;
  border-radius: 10px;
  padding: 40px;
  width: 400px;
 display: none;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent p {
  margin-top: 20px;
  font-size: 16px;
  font-weight: 500;
  text-align: center;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .formGroup{
	width: 100%;
	display :flex;
	flex-direction: column;
	margin-top: 20px;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .formGroup label{
	font-size: 14px;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .formGroup input{
	width :100%;
	height: 35px;
	border: 1px solid #ddd;
	outline: none;
	padding: 0px 15px;
	font-size: 14px;
	outline: none;
	border-radius: 5px;
	margin-top :5px;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .formGroup input:focus{
	border-color: black;
}

.FollowupQuotationPopup .FollowupQuotationPopupContent .formGroup textarea{
	width :100%;
	height: 65px;
	border: 1px solid #ddd;
	outline: none;
	padding: 0px 15px;
	font-size: 14px;
	outline: none;
	border-radius: 5px;
	margin-top :5px;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .formGroup textarea:focus{
	border-color: black;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .FollowupQuotationPopupBtnArea {
  width: 100%;
  margin-top: 30px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .FollowupQuotationPopupBtnArea .closeFollowupQuotationPopup {
  flex: 0 0 48%;
  padding: 14px;
  text-align: center;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  background: #eee;
  color: black;
  transition: 0.2s;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .FollowupQuotationPopupBtnArea .closeFollowupQuotationPopup:hover {
  transition: 0.2s;
  opacity: 0.7;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .FollowupQuotationPopupBtnArea .confirmFollowupQuotationPopup {
  flex: 0 0 48%;
  padding: 14px;
  text-align: center;
  border-radius: 10px;
  font-size: 16px;
  font-weight: 500;
  cursor: pointer;
  background: var(--fourthColor);
  color: white;
  transition: 0.2s;
}
.FollowupQuotationPopup .FollowupQuotationPopupContent .FollowupQuotationPopupBtnArea .confirmFollowupQuotationPopup:hover {
  transition: 0.2s;
  opacity: 0.7;
}
		
		
.followUpPopup{
  position: fixed;
  transform: translate(-50%, -50%);
  top: 50%;
  left: 50%;
  z-index: 110;
  background: white;
  border-radius: 10px;
  padding: 40px;
  width: 700px;
 display: none;
}
.followUpPopup .followUpPopupMain{
	width: 100%;
	display: flex;
	flex-direction: column;
	gap: 30px;
	max-height: 75vh;
	overflow-y: auto;
}
.followUpPopup .followUpPopupMain .followUpPopupList{
	width: 100%;
	display: flex;
	flex-direction: column;
	gap: 20px;
	border-top: 1px solid #eee;
	padding-top: 30px;
}
.followUpPopup .followUpPopupMain .followUpPopupList:nth-of-type(1){
	border-top: none;
	padding-top: 0px;
}
.followUpPopup .followUpPopupMain .followUpPopupBox{
	width: 100%;
	display: flex;
	flex-direction: column;
}
.followUpPopup .followUpPopupMain .followUpPopupBox span{
	font-size: 12px;
	opacity: .7;
}
.followUpPopup .followUpPopupMain .followUpPopupBox p{
	font-size: 16px;
	margin-top:10px;
}
		.followUpPopup .followUpPopupMain table{
			width:100%;
			border-collapse: collapse;
			border: 1px solid #eee;
		}
		.followUpPopup .followUpPopupMain table thead{
			width:100%;
		}
		.followUpPopup .followUpPopupMain table thead tr{
			width:100%;
		}
		.followUpPopup .followUpPopupMain table thead tr th{
			background-color: #e4eeff;
			color: black;
			padding: 5px 10px;
			font-size: 12px;
		}
		.followUpPopup .followUpPopupMain table tbody{
			width:100%;
		}
		.followUpPopup .followUpPopupMain table tbody tr{
			width:100%;
		}
		.followUpPopup .followUpPopupMain table tbody tr td{
			border-top: 1px solid #eee;
			font-size: 14px;
			padding: 8px 10px;
		}
.followUpPopup .closeFollowUpPopup{
	padding: 8px 20px;
	font-size: 14px;
	background: #eee;
	border-radius: 5px;
	cursor: pointer;
	margin-top: 20px;
	width: fit-content;
	margin-left: auto;
	transition: .3;
}
.followUpPopup .closeFollowUpPopup:hover{
	transition: .3;
	opacity: .7;
}		
	</style>
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
			<!-- FollowupQuotation -->
		<div class="FollowupQuotationPopup">
			<div class="FollowupQuotationPopupContent">
				<p>Remark</p>
				<!--<div class="formGroup">
					<label>Date</label>
					<input type="date" id="follow_up_date" required>
				</div>-->
				<div class="formGroup">
					<label>Remark</label>
					<textarea  id="remark_val"> </textarea>
				</div>
				<div class="FollowupQuotationPopupBtnArea">
					<div class="closeFollowupQuotationPopup">No</div>
					<button class="confirmFollowupQuotationPopup" style="border:none;">Submit</button>
				</div>
			</div>
		</div>
		<!-- FollowupQuotation close --> 
<!--followup popup-->
		<div class="followUpPopup">
			<div class="followUpPopupMain">
				<table>
					<thead>
						<tr>
							<th>Sl No</th>
							<th>Action</th>
							<th>Date</th>
							<th>Time</th>
							<th>Remark</th>
						</tr>
					</thead>
					<tbody>
					</tbody>	
					</table>	
				<!--<div class="followUpPopupList">
					<div class="followUpPopupBox">
						<span>Date</span>
						<p>10-10-2023</p>
					</div>
					<div class="followUpPopupBox">
						<span>Remark</span>
						<p>We declare that this invoice shows actual price of the services described and all that all particulars are true and correct</p>
					</div>
				</div>
				<div class="followUpPopupList">
					<div class="followUpPopupBox">
						<span>Date</span>
						<p>10-10-2023</p>
					</div>
					<div class="followUpPopupBox">
						<span>Remark</span>
						<p>We declare that this invoice shows actual price of the services described and all that all particulars are true and correct</p>
					</div>
				</div>
				<div class="followUpPopupList">
					<div class="followUpPopupBox">
						<span>Date</span>
						<p>10-10-2023</p>
					</div>
					<div class="followUpPopupBox">
						<span>Remark</span>
						<p>We declare that this invoice shows actual price of the services described and all that all particulars are true and correct</p>
					</div>
				</div>
				<div class="followUpPopupList">
					<div class="followUpPopupBox">
						<span>Date</span>
						<p>10-10-2023</p>
					</div>
					<div class="followUpPopupBox">
						<span>Remark</span>
						<p>We declare that this invoice shows actual price of the services described and all that all particulars are true and correct</p>
					</div>
				</div>
				<div class="followUpPopupList">
					<div class="followUpPopupBox">
						<span>Date</span>
						<p>10-10-2023</p>
					</div>
					<div class="followUpPopupBox">
						<span>Remark</span>
						<p>We declare that this invoice shows actual price of the services described and all that all particulars are true and correct</p>
					</div>
				</div>-->
			</div>
			<div class="closeFollowUpPopup">Close</div>
		</div>
		<!--followup popup close -->	
            <!-- canvas  -->
            <div class="canvas">
            
                <!-- canvas head  -->
                <div class="canvasHead">
                    <div class="canvasHeadBox1">
                        <h1>Error Log Management</h1>
                    </div>
                    <div class="canvasHeadBox2">
                        <a href="add-error-log.php" class="addBtn">Add Log</a>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- consultingWindow -->
                <div class="consultingWindow">
                    <div class="consultAppointmentList">
                        <div class="tabcontent" style="display: block;">
                            <div class="consultAppointmentListTable">
                                <div class="consultAppointmentListTableHead">
                                   <!-- <div class="searchBox">
                                        <input type="search" placeholder="Search..." id="search_val">
                                        <button id="search_btn"><i class="uil uil-search"></i></button>
                                    </div>-->
                                    <!--<div class="filterTable">
                                        <div class="filterTableBtn">
                                            <i class="uil uil-filter"></i>
                                        </div>
                                    </div>-->
									<div class="filterTable">
									<div class="formGroup" style="widthe:200px;display:flex">
									<select id="mySelect" style="width: 100%;
    height: 30px;
    padding: 0px 10px;
    font-size: 14px;
    font-weight: 500;
    border: 1px solid #ccc;
    outline: none;
    border-radius: 5px">
										<option value="">Filter by Status</option>
										<option value="1">Fixed</option>
										<option value="2">Processing</option>
										<option value="3">Pending</option>
									</select>
									</div>
								</div>
                        <a href="add-error-log.php" class="addBtn">Add Log</a>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Sl No</th>
                                                    <th>Issue Info</th>
                                                    <th>Date</th>
													<th>Approve Status</th>
													<th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <!--  <tr>
                                                    <td data-label="Sl No">
                                                        <p>1</p>
                                                    </td>
                                                    <td data-label="Staff Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="view-staff.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
                                                            <a href="edit-staff.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>2</p>
                                                    </td>
                                                    <td data-label="Staff Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="view-staff.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
                                                            <a href="edit-staff.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>3</p>
                                                    </td>
                                                    <td data-label="Staff Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="view-staff.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
                                                            <a href="edit-staff.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td data-label="Sl No">
                                                        <p>4</p>
                                                    </td>
                                                    <td data-label="Staff Name">
                                                        <p>Afsal K T</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>7356339750</p>
                                                    </td>
                                                    <td data-label="Branch">
                                                        <p>Palakkadu</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="view-staff.php" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
                                                            <a href="edit-staff.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
                                                            <div class="tableDeleteBtn" title="Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
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
                                        <p>No Data Available</p>
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
        
    <!-- jquery  -->
    <script src="assets/js/jquery.js"></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/4022a59704.js" crossorigin="anonymous"></script>
    <!-- text eiter -->
    <script src="assets/js/summernote-lite.js"></script>
    <!-- main -->
    <script src="assets/js/main.js"></script>	<script src="assets/errorLog/error_log.js?v=2.1"></script>
    <!-- script close -->

    <script>



        // filter popup 
        $('.filterTableBtn').click(function(){
            $('.filterSection').addClass('filterSectionActive');
            $('.shimmer').fadeIn();
        });
        $('.closeFilter').click(function(){
            $('.filterSection').removeClass('filterSectionActive');
            $('.shimmer').fadeOut();
        });
        $('.applyFilter').click(function(){
            $('.filterSection').removeClass('filterSectionActive');
            $('.shimmer').fadeOut();
        });

    </script>

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