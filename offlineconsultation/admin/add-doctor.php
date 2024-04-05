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
                        <h1>Add Doctor</h1>
                        <div class="breadCrumbs">
                            <a href="doctor-management.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="doctor-management.php">Doctor Management</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="add-doctor">
                        <div class="formGroup">
                            <label for="">Doctor Name</label>
                            <input type="text" required id="docotor_name">
                        </div>
                        <div class="formGroup">
                            <label for="">Phone No</label>
                            <input type="number" id="phone_no" required>
							<span id="phone_error_msg" style="color:red"></span>
                        </div>
                        <div class="formGroup">
                            <label for="">Email</label>
                            <input type="email" id="email" required>
							<span id="email_error_msg" style="color:red"></span>
                        </div>
                        <div class="formGroup">
                            <label for="">Department Name</label>
                            <select id="department_data" required>
								<option value="" selected='true' disabled='true'>Department Name</option>
								
							</select>
                        </div>
						 <div class="formGroup">
                            <label for="">Role</label>
                            <select id="role_data" required>
								<option value = "doctor" > Doctor</option>
								<option value = "cheaf_doctor"> Cheaf Doctor</option>
							</select>
                        </div>
                        <div class="formGroup">
                            <label for="">Branch Name</label>
                            <select id="branch_data" required>
								<option value="" selected='true' disabled='true'>Branch Name</option>
								
							</select>
                        </div>
						<div class="formGroup">
                            <label for="html">Assign Time Slot Now</label>
                           <input type="checkbox" id="html" class="assign_time_slot" style="width: 20px; height: 20px;">
                        </div>
						<div class="formGrouptextarea offlineConsultingDetails" style="display: none;">
							<label for="">Select Slot</label>
							<div class="formSlotSection slotList">
								<!--<label class="control" for="technology">
									<input type="checkbox" name="topics" id="technology" disabled="">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>8:00 am - 9:00 am</p>
									</span>
								</label>
								<label class="control" for="health">
									<input type="checkbox" name="topics" id="health">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>9:00 am - 10:00 am</p>
									</span>
								</label>
								<label class="control" name="science">
									<input type="checkbox" name="topics" id="science">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>10:00 am - 11:00 am</p>
									</span>
								</label>
								<label class="control" name="science">
									<input type="checkbox" name="topics" id="science">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>10:00 am - 11:00 am</p>
									</span>
								</label>

								
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>-->
								<!-- dont remove the div, put it down -->
								
							</div>
						</div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button id="add-doctor-btn">Save</button>
                        </div>
                    </form>
                </div>
                <!-- form section close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
    <?php
    include "assets/includes/script/script.php";
    ?>
	<script src="assets/doctor/add-doctor.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->
	
	<script>
		$('body').delegate('.control__content', 'change', function(){
			if($('.control input').prop('checked')) {
				$('.control__content').css({
					backgroundColor: 'rgba(137, 165, 255, 0.05)',
  					border: '1px solid #d9e0ff'
				})
			} else {
				$('.control__content').css({
					backgroundColor: 'rgba(0, 255, 0, 0.126)',
  					border: '1px solid #00b400'
				})
			}
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