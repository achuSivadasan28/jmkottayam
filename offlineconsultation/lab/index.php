<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['lab_login_id']) and $_SESSION['lab_role'] == 'lab'){
$login_id = $_SESSION['lab_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_lab'];
$staff_unique_code = $_SESSION['lab_unique_code'];
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
                        <!--<a href="offline-appointments.php" class="dashboardMenuBox todayAppointmentbox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Today's Appointments</h2>
                                <span><b id="appointment_count">0</b> New Appointments</span>
                            </div>
                        </a>-->
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
                        <!-- dont remove the div, put it down close -->

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