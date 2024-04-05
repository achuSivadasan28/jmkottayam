<?php
include_once 'action/sidemenu/sidemenu.php';
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['staff_login_id']) and $_SESSION['staff_role'] == 'staff'){
$obj=new query();
$login_id = $_SESSION['staff_login_id'];
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
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
	<style>
		.cardSub{
			margin-top:10px;
		}
	</style>
    
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
                                <h2>Appointments</h2>
                            </div>
                        </a>
						<a href="refer-appointments.php" class="dashboardMenuBox" style="display:none">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-calendar-alt"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Referred Appointment</h2>
                            </div>
                        </a>
                        <a href="profile.php" class="dashboardMenuBox">
                            <div class="dashboardMenuBoxIcon">
                                <i class="uil uil-user-square"></i>
                            </div>
                            <div class="dashboardMenuBoxDetails">
                                <h2>Profile Management</h2>
                            </div>
                        </a>
						

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down close -->

                    </div>
					<div style="display:flex;font-family: 'Montserrat', sans-serif;background:white;padding:15px;margin-top:10px;border-radius:5px;width:49%;box-shadow: 0 0 15px rgba(11, 10, 10, 0.046);">
						<div style="width:10px;display:flex;justify-content:center;height:150px;align-items:center; background: linear-gradient(to right,#557bfe, #fff);margin-right:20px;border-radius:3px;">
						 <!-- <i style="font-size:52px;font-weight: 400;" class="uil uil-calendar-alt"></i>-->
						</div>
						<div style="display:flex;justify-content:space-between;width:80%;">
							<div>
						<h2 style="font-size: 18px;font-weight:600;color:black;color:#557bfe;">Today's patients</h2>
						<div style="display:flex;flex-direction:column;">
							<span class="cardSub total_patients"></span>
							<span class="cardSub total_new_patient"></span>
							<span class="cardSub total_nr_patient"></span>
							<span class="cardSub total_re_patient"></span>			
						</div>
							</div>
							<div>
						<h2 style="font-size: 18px;font-weight:600;color:black;color:#557bfe;">Today's collection</h2>
						<div style="display:flex;flex-direction:column;">
							<span class="cardSub total_collection"></span>
							<span class="cardSub total_cash"></span>
							<span class="cardSub total_online"></span>	
							<span class="cardSub total_card"></span>	
						</div>
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
    <!-- script close -->
<script>
	$.ajax({
		url:"action/appointment/fetch_all_appointment_report.php",
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			let total_p = result_data_json[0]['new_patient_count']+result_data_json[0]['old_patient_count']
			$('.total_patients').append(`Total patients : ${total_p}`)
			$('.total_new_patient').append(`Total new patients : ${result_data_json[0]['new_patient_count']}`)
			$('.total_nr_patient').append(`Total NR patients : ${result_data_json[0]['total_num_nr']}`)
			$('.total_re_patient').append(`Total Re patients :  ${result_data_json[0]['total_re_visit']}`)
			
			$('.total_collection').append(`Total collection : ${result_data_json[0]['total_appointment_fee']}`)
			$('.total_cash').append(`Total Cash       : ${result_data_json[0]['ap_total_cash']}`)
			$('.total_online').append(`Total Online : ${result_data_json[0]['ap_total_gpay']}`)
			$('.total_card').append(`Total Card : ${result_data_json[0]['ap_total_card']}`)
			
		}
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