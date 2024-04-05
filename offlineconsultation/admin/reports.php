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
                        <a href="appointments.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>All Appointments</h2>
                            </div>
                        </a>
                        
                       <a href="patient_list.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-user-nurse"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Patient List</h2>
                            </div>
                        </a>
						
						<a href="doctor-report.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-user-md"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Doctor Report</h2>
                            </div>
                        </a>

						<a href="appointment-fee-report.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Appointment Fee Report</h2>
                            </div>
                        </a>
						<a href="treatment-fee-report.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-file-medical-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Treatment Fee Report</h2>
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
    <!-- script close -->
	
	<script>

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