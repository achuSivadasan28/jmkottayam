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

                <!-- doctor profile section  -->
                <div class="doctorProfileSection">
                    <div class="doctorProfileHead">
                        <div class="container">
                            <div class="doctorProfileHeadMain">
                                <div class="doctorProfileHeadDetails">
                                    <div class="doctorProfileHeadDetailsBox">
                                        <div class="doctorProfilethumbnail">
                                            <img src="assets/images/avatarOrange2.png" alt="">
                                        </div>
                                        <div class="doctorProfileName">
                                            <h2 id="staff_name"></h2>
                                            <span>Staff</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="doctorProfileBody">
                        <div class="doctorProfileBodyBox">
                            <div class="doctorProfileBodyBoxhead">
                                <h2>Personal Details</h2>
                                <a id="edit_data" href="">Edit</a>
                            </div>
                            <ul>
                                <li>
                                    <span>Phone <b>:</b></span>
                                    <p id="phone_num"></p>
                                </li>
                                <li>
                                    <span>Email <b>:</b></span>
                                    <p id="email"></p>
                                </li>
                               
                                <li>
                                    <span>Place <b>:</b></span>
                                    <p id="place"></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- doctor profile section close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
    <?php
    include "assets/includes/script/script.php";
    ?>
	<script src="assets/profile/fetch_profile.js?v=<?php echo $version_variable;?>"></script>
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