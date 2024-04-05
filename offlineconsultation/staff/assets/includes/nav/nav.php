<?php
require_once 'action/sidemenu/sidemenu.php';
require_once '../_class/query.php';
$obj=new query();
$staff_name = fetch_staff_name($_SESSION['staff_login_id'],$obj);
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
        <div class="navProfile">
            <div class="navProfileBox">
                <div class="navProfileThumbnail">
                    <img src="assets/images/avatar.png" alt="">
                </div>
                <div class="navProfileName">
                    <p><?php echo $staff_name;?></p>
                    <span>Staff</span>
                </div>
            </div>
        </div>
    </div>
</div>