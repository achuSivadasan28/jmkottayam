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

                <!-- doctor profile section  -->
                <div class="doctorProfileSection">
                    <div class="doctorProfileHead">
                        <div class="container">
                            <div class="doctorProfileHeadMain">
                                <div class="doctorProfileHeadDetails">
                                    <div class="doctorProfileHeadDetailsBox">
                                        <div class="doctorProfilethumbnail">
                                            <img id="pro_pic1" src="assets/images/avatar.png" alt="">
                                        </div>
                                        <div class="doctorProfileName">
                                            <h2 id="profile_name"></h2>
                                            <span id="staff_profile_branch"></span>
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
                                <a href="edit-personal-details.php"><i class="uil uil-edit-alt"></i> Edit</a>
                            </div>
                            <ul>
                                <li>
                                    <span>Phone <b>:</b></span>
                                    <p id="phnNum"></p>
                                </li>
                                <li>
                                    <span>Email <b>:</b></span>
                                    <p id="email"></p>
                                </li>
                                <li>
                                    <span>Department <b>:</b></span>
                                    <p id="address"></p>
                                </li>
                                <li>
                                    <span>Branch <b>:</b></span>
                                    <p id="place"></p>
                                </li>
                            </ul>
                        </div>
                        <div class="doctorProfileBodyBox">
                            <div class="doctorProfileBodyBoxhead">
                                <h2>Professional Details</h2>
                                <a href="edit-professional-details.php"><i class="uil uil-edit-alt"></i> Edit</a>
                            </div>
                            <ul>
                                <li>
                                    <span>Designation <b>:</b></span>
                                    <p id="designation_data"></p>
                                </li>
                                <li>
                                    <span>Qualifications <b>:</b></span>
                                    <p id="qualification_data"></p>
                                </li>
                                <li>
                                    <span>Experience <b>:</b></span>
                                    <p id="experiance_data"></p>
                                </li>
                                <li>
                                    <span>Reg Number <b>:</b></span>
                                    <p id="reg_num"></p>
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
	<script src="assets/profile/profile.js?v=<?php echo $version_variable;?>"></script>
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