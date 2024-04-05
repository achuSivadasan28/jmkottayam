<?php
$directoryURI = $_SERVER['REQUEST_URI'];
$path = parse_url($directoryURI, PHP_URL_PATH);
$components = explode('/', $path);
$arr_size = sizeof($components);
$last_index = $arr_size-1;
$first_part = $components[$last_index];
if($first_part == 'index.php' || $first_part == ''){
	$active_class_index = 'Dashboard';
 }else if($first_part == 'bills.php'){
	$active_class_index = 'Bills';
 }else if($first_part == 'generate-bill.php'){
	$active_class_index = 'Generate Bill';
 }else if($first_part == 'profile.php'){
	$active_class_index = 'Profile';
 }else if($first_part == 'edit-profile.php'){
	$active_class_index = 'Edit Profile';
 }else if($first_part == 'change-password.php'){
	$active_class_index = 'Change Password';
 }else if($first_part == 'patient-list.php'){
	$active_class_index = 'Patient List';
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
			<!---<div class="breadCrumbs">
				<a href="index.php" class="back"><i class="uil uil-angle-left-b"></i></a>
				<span>/</span>
				<a href="index.php">Dashboard</a>
			</div>--->
		</div>
        <div class="navProfile">
            <div class="navProfileBox">
                <div class="navProfileThumbnail">
                    <img src="assets/images/doctorAvatar.png" alt="">
                </div>
                <div class="navProfileName">
                    <p></p>
                    <span></span>
                </div>
            </div>
			<div class="navDropDown">
				<a href="profile.php">
					<span><i class="uil uil-user"></i></span>
					<p>Profile</p>
				</a>
				<a href="change-password.php">
					<span><i class="uil uil-key-skeleton-alt"></i></span>
					<p>Change Password</p>
				</a>
				<a href="tel:+919876543210">
					<span><i class="uil uil-question-circle"></i></span>
					<p>Help ?</p>
				</a>
				 <a href="" id="logout">
					<span><i class="uil uil-sign-out-alt"></i></span>
					<p>Log Out</p>
				</a>
			</div>
        </div>
    </div>
</div>

<script>

</script>