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
        <div class="deleteAlert dateWarn">
            <div class="deleteAlertMian">
                <div class="deleteAlertThumbnail">
                    <img src="assets/images/icon/delete-alert.gif" alt="">
                </div>
                <div class="deleteAlertContent">
                    <p>Patients Already Booked On This Date !</p>
                    <div class="deleteAlertBtnArea">
                        <div class="closedeleteAlert"style="flex:1 1 100%"> Close</div>
                    </div>
                </div>
            </div>
        </div>
		<div class="deleteAlert dateDelete">
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
                    <div class="canvasHeadBox1" style="display: flex;">
                        <h1>Available Dates</h1>
                    </div>
                    <div class="canvasHeadBox2">
                        <a href="choose-date.php" class="addBtn">Choose Date</a>
                    </div>
                </div>
                <!-- canvas head close -->
				
				<!-- Available Dates list -->
				<div class="availableDatesList">
				<!--	<div class="availableDatesListBox">
						<div class="availableDatesListBoxHead">
							<h2>January - 2023</h2>
						</div>
						<div class="availableDatesListBoxBody">
							<div class="availableDatesBox inActivDate">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>01</h3>
								<p>Monday</p>
							</div>
							<div class="availableDatesBox inActivDate">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>03</h3>
								<p>Wednesday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>04</h3>
								<p>Thursday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>16</h3>
								<p>Saturday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>25</h3>
								<p>Monday</p>
							</div>
						</div>
						<div class="availableDatesListBoxFooter">
							<div class="resetDeleteDate"><i class="uil uil-redo"></i></div>
							<div class="submitDeleteDate">Submit</div>
						</div>
					</div>
					<div class="availableDatesListBox">
						<div class="availableDatesListBoxHead">
							<h2>February - 2023</h2>
						</div>
						<div class="availableDatesListBoxBody">
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>01</h3>
								<p>Monday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>03</h3>
								<p>Wednesday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>04</h3>
								<p>Thursday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>16</h3>
								<p>Saturday</p>
							</div>
							<div class="availableDatesBox">
								<div class="removeAvailableDatesBox">
									<i class="uil uil-trash"></i>
								</div>
								<h3>25</h3>
								<p>Monday</p>
							</div>
						</div>
						<div class="availableDatesListBoxFooter">
							<div class="resetDeleteDate"><i class="uil uil-redo"></i></div>
							<div class="submitDeleteDate">Submit</div>
						</div>
					</div>-->
				</div>
				<!-- Available Dates list close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
	
	<script>
		
		// removeAvailableDatesBox
		
		
	</script>
	<script src = "assets/appointment/fetch-available-dates.js"></script>
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