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
            
                <!-- canvas head  -->
                <div class="canvasHead">
                    <div class="canvasHeadBox1">
                        <h1>Edit Department</h1>
                        <div class="breadCrumbs">
                            <a href="department-management.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="department-management.php">Department Management</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="edit_department">
                        <div class="formGroup">
                            <label for="">Department Name</label>
                            <input type="text" value="" id="department">
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button id="edit_department_btn">Save</button>
                        </div>
                    </form>
                </div>
                <!-- form section close -->

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
    <?php
    include "assets/includes/script/script.php";
    ?>
		<script src="assets/department/edit-department.js?v=<?php echo $version_variable;?>"></script>
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