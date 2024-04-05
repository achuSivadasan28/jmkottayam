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
                                            <img src="assets/images/avatarOrange.png" alt="">
                                        </div>
                                        <div class="doctorProfileName">
                                            <h2 id="user_name">No Data</h2>
                                            <span>Admin</span>
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
                                <a href="edit-profile.php">Edit</a>
                            </div>
                            <ul>
                                <li>
                                    <span>Phone <b>:</b></span>
                                    <p id="phn">NO Data</p>
                                </li>
                                <!--<li>
                                    <span>Email <b>:</b></span>
                                    <p id="email">NO Data</p>
                                </li>-->
                                <li>
                                    <span>Address <b>:</b></span>
                                    <p id="address">NO Data</p>
                                </li>
                                <li>
                                    <span>Place <b>:</b></span>
                                    <p id="place">NO Data</p>
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
	header('Location:../login.php');
}
}else{
	header('Location:../login.php');
}	
?>