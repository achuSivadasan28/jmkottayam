<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
$index_active = '';
$all_app_active = '';
if($first_part == 'index.php' || $first_part == ''){
	$index_active = 'sidemenuLinkActive';
}else if($first_part == 'appointments.php' || $first_part == 'add-appointment.php' || $first_part == 'edit-appointment-details.php'){
	$appointment_active = 'sidemenuLinkActive';
}else if($first_part == 'profile.php' || $first_part =='edit-profile.php'){
	$profile_active = 'sidemenuLinkActive';
}else if($first_part == 'change-password.php'){
	$changePwd_active = 'sidemenuLinkActive';
}else if( $first_part == 'old-appointments.php'){
	$all_app_active = 'sidemenuLinkActive';
}
?>
<!-- sidemenu  -->
<div class="sidemenu">
    <h2>Menu</h2>
    <ul>
        <li>
            <a href="index.php" class="<?php echo $index_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-estate"></i>
                </div>
                <p>Dashboard</p>
            </a>
        </li>
        <li>
            <a href="appointments.php" class="<?php echo $appointment_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-calendar-alt"></i>
                </div>
                <p>Appointments</p>
            </a>
        </li>
		 <li>
            <a href="old-appointments.php" class="<?php echo $all_app_active;?>">
                <div class="sidemenuIcon">
                    <i class="uil uil-list-ol-alt"></i>
                </div>
                <p>All Appointments</p>
            </a>
        </li>
    </ul>
    <h2>Appearance</h2>
    <ul>
        <li>
            <a href="profile.php" class="<?php echo $profile_active;?>"> 
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
<!-- sidemenu close -->