<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['staff_login_id']) and $_SESSION['staff_role'] == 'staff'){
$obj=new query();
$login_id = $_SESSION['staff_login_id'];
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
	//echo $staff_unique_code;exit();
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);
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

<body>
    
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
        <!-- filter-->
		<div class="filterSection" >
            <div class="filterSectionHead">
                <h1><i class="uil uil-filter"></i> Filter</h1>
            </div>
            <div class="filterSectionBody">
				<div class="filterSectionBodyBox">
					
                    <h2>Appointment Fee</h2>
                    <div class="filterSectionBodyCheckbox appmnt-fee">
                       <!-- <div class="formGroup">
                            <input type="checkbox" id="branch1">
                            <label for="branch1">Palakkad</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="branch2">
                            <label for="branch2">Ernakulam</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="branch3">
                            <label for="branch3">Kottayam</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="branch4">
                            <label for="branch4">Idukki</label>
                        </div>-->
                    	
					</div>
                </div>
                <div class="filterSectionBodyBox">
					
                    <h2>Payment Type</h2>
                    <div class="filterSectionBodyCheckbox payment-type">
                        <div class="formGroup">
                            <input type="checkbox" id="Cash" class="branch_val" value = '2'>
                            <label for="Cash" status="0">Cash</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="pay" class="branch_val" value = '1'>
                            <label for="pay" status="0">G-pay</label>
                        </div>
                        <div class="formGroup">
                            <input type="checkbox" id="Card" class="branch_val" value = '3'>
                            <label for="Card" status="0">Card</label>
                        </div>
					</div>
                </div>
            </div>
            <div class="filterSectionFooter">
                <div class="closeFilter">Close</div>
                <div class="applyFilter">Apply</div>
            </div>
        </div>
		<!-- filter-->
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
                    <div class="canvasHeadBox2">
                        <a href="add-appointment.php" class="addBtn">Add Appointment</a>
                    </div>
                </div>
                <!-- canvas head close -->
				
				<!--<div class="consultingWindowInfo">
					<div class="consultingWindowInfoBox">
						<div class="consultingWindowInfoBoxColor" style="background:green;"></div>
						<p>Old Appointments</p>
					</div>
					<div class="consultingWindowInfoBox">
						<div class="consultingWindowInfoBoxColor" style="background:blue;"></div>
						<p>New Appointments</p>
					</div>
				</div>-->
                
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
									<div class="filterTable">
                                        <div class="filterTableBtn">
                                            <i class="uil uil-filter"></i>
                                        </div>
                                    </div>
                                    <div class="dateRange">
                                        <input type="date" id="start_date">
                                        <span></span>
                                        <input type="date" id="end_date">
                                        <button id="date_filter"><i class="uil uil-search"></i></button>
                                    </div>
                                </div>
                                <div class="consultAppointmentListTableBody">
                                    <div class="tableWraper appointment_tbl">
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
													<th>OP NO</th>
                                                    <th>Unique ID</th>
                                                    <th>Name</th>
                                                    <th>Phone</th>
                                                  
                                                    <th>Date</th>
													<th>Doctor Name</th>
													<th>Appointment Fee</th>
													<th>Payment Type</th>
													<th>Consulting Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!--<tr>
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
					
					<div class="tableLoader"></div>
					
					
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
	<script src="assets/appointment/fetch-appointment.js?v=<?php echo $version_variable;?>"></script>
    <script>
		let appointment_id = 0;
		let that = '';
        // view Details popup
        $('body').delegate('.viewDetailsBtn','click',function(){
            $('.shimmer').fadeIn();
            $('.profileDetailsPopup').fadeIn();
        });
        $('.closeProfileDetailsPopup').click(function(){
            $('.shimmer').fadeOut();
            $('.profileDetailsPopup').fadeOut();
        });

		// filter popup 
        $('body').delegate('.cancelTableBtn','click',function(){
			appointment_id = $(this).attr('data-id')
			that = $(this)
			console.log(appointment_id)
            $('.deleteAlert').fadeIn();
            $('.shimmer').fadeIn();
        });
        $('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });
        $('.confirmdeleteAlert').click(function(){
			$.ajax({
				url:"action/appointment/cancel_appointment.php",
				type:"POST",
				data:{appointment_id:appointment_id},
				success:function(calcelled_result){
					//console.log(that.parent().parent().parent())
					//that.parent().parent().parent().find('tr').css('opacity', '0.2');
					fetch_all_appointment()
					$('.deleteAlert').fadeOut();
            		$('.shimmer').fadeOut();
				}
			})
            
        });
		$(".closeFilter").click(()=>{
			$('.filterSection').removeClass("filterSectionActive")
			$('.shimmer').fadeOut();
		})
		$(".filterTableBtn").click(()=>{
			$('.filterSection').addClass("filterSectionActive")
			$('.shimmer').fadeIn();
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