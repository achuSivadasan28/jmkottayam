<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
if($first_part == 'index.php' || $first_part == ''){
	$active_class_index = 'Dashboard';
}else if($first_part == 'old-appointments.php'){
	$active_class_index = 'Old Appointments';
}else if($first_part == 'old-offline-appointments.php'){
	$active_class_index = 'Old Offline Appointments';
}else if($first_part == 'offline-appointments.php'){
	$active_class_index = 'Offline Appointments';
}else if($first_part == 'offline-waiting-list.php'){
	$active_class_index = 'Offline Appointments';
}else if($first_part == 'appointments.php'){
	$active_class_index = 'Appointments';
}else if($first_part ==   'add-appointment.php'){
	$active_class_index = 'Add Appointment';
}
?>
<div class="nav">
    <div class="container">
        <a href="index.php" class="navLogo">
            <img src="assets/images/johnmariansLogo.png" alt="">
        </a>
        <div class="navBar">
            <div class="navBarBox">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
		<div class="navHeadBox1">
			<h1><?php echo $active_class_index;?></h1>
			<div class="breadCrumbs">
				<!---<a href="settings.php" class="back"><i class="uil uil-angle-left-b"></i></a>
				<!---<span>/</span>
				<a href="settings.php">Settings</a>--->
			</div>
		</div>
        <div class="navProfile">
            <div class="navProfileBox">
                <div class="navProfileThumbnail">
                    <img id="pro_pic" src="assets/images/avatarOrange2.png" alt="">
                </div>
                <div class="navProfileName">
                    <p id="name"></p>
                    <span id="branch"></span>
                </div>
				<div class="navProfileDown">
					<i class="uil uil-angle-down"></i>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="navDropdown">
	<ul>
		<li>
			<a href="profile.php" class="<?php echo $profile_data;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-user"></i>
                </div>
                <p>Profile</p>
            </a>
		</li>
        <li>
            <a href="change-password.php" class="<?php echo $changePwd_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-key-skeleton-alt"></i>
                </div>
                <p>Change Password</p>
            </a>
        </li>
        <li>
            <a href="tel:+919876543210">
                <div class="sidemenuIcon">
                    <i class="uil uil-question-circle"></i>
                </div>
                <p>Help ?</p>
            </a>
        </li>
        <li>
            <a href="action/logout/logout_action.php">
                <div class="sidemenuIcon">
                    <i class="uil uil-sign-out-alt"></i>
                </div>
                <p>Log Out</p>
            </a>
        </li>
	</ul>
</div>