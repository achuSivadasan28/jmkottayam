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

        <!-- slot list menu  -->
        <div class="slotListMenu">
            <div class="slotListMenuHead">
                <h1>Select Slot <i class="uil uil-angle-down"></i></h1>
            </div>
            <div class="slotListMenuBody">
                <div class="checkbox">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" class="checkbox-input" />
                        <span class="checkbox-tile">
                            <span class="checkbox-label">10:00 am - 11:00 am</span>
                            <span class="checkbox-label-2">No .of Appointments : 20</span>
                        </span>
                    </label>
                </div>
                <div class="checkbox">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" class="checkbox-input" />
                        <span class="checkbox-tile">
                            <span class="checkbox-label">10:00 am - 11:00 am</span>
                            <span class="checkbox-label-2">No .of Appointments : 20</span>
                        </span>
                    </label>
                </div>
                <div class="checkbox">
                    <label class="checkbox-wrapper">
                        <input type="checkbox" class="checkbox-input" />
                        <span class="checkbox-tile">
                            <span class="checkbox-label">10:00 am - 11:00 am</span>
                            <span class="checkbox-label-2">No .of Appointments : 20</span>
                        </span>
                    </label>
                </div>
            </div>
            <div class="slotListMenuFooter">
                <div class="slotListMenuClose">Close</div>
                <button class="slotListMenuSubmit"><i class="uil uil-plus"></i> Add</button>
            </div>
        </div>
        <!-- slot list menu close -->
        
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
                                            <h2>Dr. Muhammed Afsal K T</h2>
                                            <span>Dermatologist</span>
                                        </div>
                                    </div>
                                    <div class="doctorProfileHeadDetailsBox">
                                        <div class="blockDoctorBtn" id="myDIV">Block</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="doctorProfileBody">
                        <div class="doctorProfileBodyBox2">
                            <div class="doctorProfileBodyBoxhead">
                                <h2>Appointment Slot</h2>
                                <a href="" class="addSlotBtn">Add Slot</a>
                            </div>
                            <div class="slotList">
                                <div class="slotListBox">
                                    <div class="bloacedAlert">Blocked</div>
                                    <h2>10:00 am - 11:00 am</h2>
                                    <p>No .of Appointments : <span>20</span></p>
                                    <div class="slotListBoxBtnArea">
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
                                    <div class="tableBlockBtn" title="Block">
                                        <i class="uil uil-ban"></i>
                                    </div>
                                    <div class="tableDeleteBtn" title="Delete">
                                        <i class="uil uil-trash"></i>
                                    </div>
                                    </div>
                                </div>

                                <!-- dont remove the div, put it down -->
                                <div class="dummyDiv"></div>
                                <div class="dummyDiv"></div>
                                <!-- dont remove the div, put it down close -->

                            </div>
                        </div>
                        <div class="doctorProfileBodyBox" style="background: #fff4f1;">
                            <div class="doctorProfileBodyBoxhead">
                                <h2>Personal Details</h2>
                            </div>
                            <ul>
                                <li>
                                    <span>Phone <b>:</b></span>
                                    <p>7356339750</p>
                                </li>
                                <li>
                                    <span>Email <b>:</b></span>
                                    <p>afsalkt110@gmail.com</p>
                                </li>
                                <li>
                                    <span>Address <b>:</b></span>
                                    <p>Kottiyottuthodi (H)</p>
                                </li>
                                <li>
                                    <span>Place <b>:</b></span>
                                    <p>Palakkadu</p>
                                </li>
                            </ul>
                        </div>
                        <div class="doctorProfileBodyBox" style="background: #eaf9e6;">
                            <div class="doctorProfileBodyBoxhead">
                                <h2>Professional Details</h2>
                            </div>
                            <ul>
                                <li>
                                    <span>Designation <b>:</b></span>
                                    <p>Dermatologist</p>
                                </li>
                                <li>
                                    <span>Qualifications <b>:</b></span>
                                    <p>MBBS</p>
                                </li>
                                <li>
                                    <span>Experience <b>:</b></span>
                                    <p>10 Years</p>
                                </li>
                                <li>
                                    <span>Place <b>:</b></span>
                                    <p>Palakkadu</p>
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
    <!-- script close -->

    <script>

        // block btn
        $('.blockDoctorBtn').click(function(){
            $('.doctorProfileHead').toggleClass('doctorProfileHeadBlock');
            // $('.blockDoctorBtn').text("Unblock");
            var x = document.getElementById("myDIV");
            if (x.innerHTML === "Block") {
                x.innerHTML = "UnBlock";
            } else {
                x.innerHTML = "Block";
            }
        });

        // delete alert 
        $('.tableDeleteBtn').click(function(){
            $('.deleteAlert').fadeIn();
            $('.shimmer').fadeIn();
        });
        $('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });
        $('.confirmdeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });

        // block slot 
        $('.tableBlockBtn').click(function(){
            $(this).parent().siblings('.bloacedAlert').toggle();
        });

        // add slot 
        $('.addSlotBtn').click(function(e){
            e.preventDefault();
            $('.slotListMenu').css({
                right: '0',
                transition: '.2s'
            });
            $('.shimmer').fadeIn();
        })
        $('.slotListMenuClose').click(function(e){
            e.preventDefault();
            $('.slotListMenu').css({
                right: '-100%',
                transition: '.2s'
            });
            $('.shimmer').fadeOut();
        })
        $('.slotListMenuSubmit').click(function(e){
            e.preventDefault();
            $('.slotListMenu').css({
                right: '-100%',
                transition: '.2s'
            });
            $('.shimmer').fadeOut();
        })

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