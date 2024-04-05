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
                        <h1>Dashboard</h1>
                    </div>
                </div>
                <!-- canvas head close -->

                <!-- dashboard page -->
                <div class="dashboardPage">
                    <div class="dashboardMenuList">
                        <a href="today-appointments.php" class="dashboardMenuBox todayAppointmentbox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Today's Appointments</h2>
                                <span><b id="appointment_count">0</b> New Appointments</span>
                            </div>
                        </a>
                        <a href="old-offline-appointments.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Appointments history</h2>
                                <span><b id="all_appointment_count">0</b> Old Appointments</span>
                            </div>
                        </a>
                      

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <div class="dummyDiv"></div>
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down close -->
						
						<div class="doctorReport">
							<div class="doctorReportHead">
								<div class="doctorReportHeadDate">
									<input type="date" class="start_date"><span style="height:2px;background:#557bfe;width:10px;"></span><input type="date" class="end_date">
									<button id="date_filter_btn"><i class="uil uil-search"></i></button>
								</div>
							</div>
							<div class="doctorReportBody">
								<div class="doctorReportBodyBox">
									<h2>Offline</h2>
									<ul>
										<li>
											<p>New Appointments</p>
											<span>:</span>
											<h3 id = "new_off">10</h3>
										</li>
										<li>
											<p>Review Appointments</p>
											<span>:</span>
											<h3  id = "old_off">10</h3>
										</li>
										<li>
											<p>Total Appointments</p>
											<span>:</span>
											<h3 class="totlAppCount"  id = "tot_off">20</h3>
										</li>
									</ul>
								</div>
								<!--<div class="doctorReportBodyBox">
									<h2>Online</h2>
									<ul>
										<li>
											<p>New Appointments</p>
											<span>:</span>
											<h3  id = "new_on">10</h3>
										</li>
										<li>
											<p>Review Appointments</p>
											<span>:</span>
											<h3  id = "old_on">10</h3>
										</li>
										<li>
											<p>Total Appointments</p>
											<span>:</span>
											<h3 class="totlAppCount"  id = "tot_on">20</h3>
										</li>
										<li>
											<p>Missed Appointments</p>
											<span>:</span>
											<h3 class="missedAppCount"  id = "missed_on">10</h3>
										</li>
									</ul>
								</div>-->
							</div>
						</div>

                    </div>
                </div>
                <!-- dashboard page close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
	<script src="assets/appointment/todays-appointment.js"></script>
	<script src="assets/appointment/old-appointment.js"></script>
    <!-- script close -->

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