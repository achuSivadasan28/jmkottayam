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

        <!-- delete alert  -->
        <div class="deleteAlert">
            <div class="deleteAlertMian">
                <div class="deleteAlertThumbnail">
                    <img src="assets/images/icon/delete-alert.gif" alt="">
                </div>
                <div class="deleteAlertContent">
                    <p>Do you want to delete ?</p>
                    <div class="deleteAlertBtnArea">
                        <div class="closedeleteAlert">No</div>
                        <div class="confirmdeleteAlert">Delete</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- delete alert close -->
        
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
                <div class="canvasHead" style="display: flex;">
                    <div class="canvasHeadBox1" style="display: none;">
                        <h1>Appointment Slot</h1>
                        <div class="breadCrumbs">
                            <a href="core-data.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="core-data.php">Core Data</a>
                        </div>
                    </div>
                    <div class="canvasHeadBox2" style="margin-left :auto;">
                        <a href="add-slot.php" class="addBtn">Add Slot</a>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- slot list -->
                <div class="slotList">
                   <!-- <div class="slotListBox">
                        <div class="bloacedAlert">Blocked</div>
                        <h2>10:00 am - 11:00 am</h2>
                        <p>No .of Appointments : <span>20</span></p>
                        <div class="slotListBoxBtnArea">
                        <a href="edit-slot.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                        </a>
                        <div class="tableBlockBtn" title="Block">
                            <i class="uil uil-ban"></i>
                        </div>
                        <div class="tableDeleteBtn" title="Delete">
                            <i class="uil uil-trash"></i>
                        </div>
                        </div>
                    </div>
                    <div class="slotListBox">
                        <div class="bloacedAlert">Blocked</div>
                        <h2>11:00 am - 12:00 pm</h2>
                        <p>No .of Appointments : <span>20</span></p>
                        <div class="slotListBoxBtnArea">
                        <a href="edit-slot.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                        </a>
                        <div class="tableBlockBtn" title="Block">
                            <i class="uil uil-ban"></i>
                        </div>
                        <div class="tableDeleteBtn" title="Delete">
                            <i class="uil uil-trash"></i>
                        </div>
                        </div>
                    </div>
                    <div class="slotListBox">
                        <div class="bloacedAlert">Blocked</div>
                        <h2>12:00 pm - 01:00 pm</h2>
                        <p>No .of Appointments : <span>20</span></p>
                        <div class="slotListBoxBtnArea">
                        <a href="edit-slot.php" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                        </a>
                        <div class="tableBlockBtn" title="Block">
                            <i class="uil uil-ban"></i>
                        </div>
                        <div class="tableDeleteBtn" title="Delete">
                            <i class="uil uil-trash"></i>
                        </div>
                        </div>
                    </div>-->

                    <!-- dont remove the div, put it down -->
                    <div class="dummyDiv"></div>
                    <div class="dummyDiv"></div>
                    <!-- dont remove the div, put it down close -->

                </div>
                <!-- slot list close -->
					
					<div class="eleseBox" style="display:none">
						<div class="eleseBoxThumbnail">
							<img src="assets/images/empty.png">
						</div>
						<p>No Data Available</p>
					</div>
					
					<style>
						.eleseBox{
							width: 100%;
							margin-top: 30px;
							display: flex;
							justify-content: center;
							align-items: center;
							flex-direction: column;
						}
						.eleseBox .eleseBoxThumbnail{
							width: 200px;
						}
						.eleseBox .eleseBoxThumbnail img{
							width:100%;
							height: 100%;
							object-fit: contain;
						}
						.eleseBox p{
							font-size: 20px;
							font-weight: 500;
							margin-top: 20x;
						}
					</style>

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
	<script src="assets/timeSlot/fetch_all_time_slot.js?v=<?php echo $version_variable;?>"></script>
    <!-- script close -->

    <script>



    </script>

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