<?php
session_start();
if(isset($_SESSION['doctor_login_id']) and $_SESSION['doctor_role'] == 'doctor'){
	require_once '../_class/query.php';
$obj=new query();
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
                        <h1>Online Appointments</h1>
                    </div>
                </div>
                <!-- canvas head close -->

                <!-- dashboard page -->
                <div class="dashboardPage">
                    <div class="dashboardMenuList">
                        <a href="online-appointments-data.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>New Online Appointments</h2>
                                <span><b id="online_appointment_count">0</b> Appointments</span>
                            </div>
                        </a>
						 <a href="all-online-appointments.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>All Online Appointments</h2>
                                <span><b id="all_appointment_count">0</b> Appointments</span>
                            </div>
                        </a>
						<a href="scheduled-appointments.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>scheduled appointment</h2>
                                <span><b id="scheduled_appointment_data">0</b> Appointments</span>
                            </div>
                        </a>
                      <!--  <a href="old-online-appointments.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-video"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Old Online Appointments</h2>
                                <span><b>450</b> Appointments</span>
                            </div>
                        </a>-->

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
	<script src="assets/appointment/online-appointment.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->

</body>
</html>
<?php
}else{
	header("Location:../login.php");
}
?>