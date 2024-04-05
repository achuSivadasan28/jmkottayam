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

                <!-- message canvas  -->
                <section id="messageCanvas">
                    <div class="messageCanvasMain">

                        <!-- profile details popup  -->
                        <div class="messageProfileDetailsPopup">
                            <ul>
                                <li>
                                    <span>Unique ID <b>:</b></span>
                                    <p>AKR120622</p>
                                </li>
                                <li>
                                    <span>Name <b>:</b></span>
                                    <p>Afsal K T</p>
                                </li>
                                <li>
                                    <span>Phone <b>:</b></span>
                                    <p>7356339750</p>
                                </li>
                                <li>
                                    <span>Age <b>:</b></span>
                                    <p>24</p>
                                </li>
                                <li>
                                    <span>Gender <b>:</b></span>
                                    <p>Male</p>
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
                        <!-- profile details popup close -->

                        <div class="messageCanvasHead">
                            <div class="messageCanvasHeadBox">
                                <a href="online-appointments.php" class="backBtn">
                                    <i class="uil uil-arrow-left"></i>
                                </a>
                                <div class="messageCanvasHeadThumbnail">
                                    <img src="assets/images/avatarOrange.png" alt="">
                                </div>
                                <div class="messageCanvasHeadName">
                                    <h1>Afsal K T</h1>
                                    <span>AKR120622</span>
                                </div>
                            </div>
                            <div class="messageCanvasHeadBox">
                                <div class="viewDetailsBtn">View Details</div>
                            </div>
                        </div>
                        <div class="messageCanvasBody">
                            <div class="dateHeader">
                                <span>06/07/2022</span>
                            </div>

                            <div class="messageRecievedSection">

                                <div class="messageRecievedBox">
                                    <div class="messageBox">
                                        <p>Hi</p>
                                    </div>
                                    <div class="messageRecievedBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                    </div>
                                </div>
                                
                                <div class="messageRecievedBox">
                                    <div class="messageBox">
                                        <p>What is your name?</p>
                                    </div>
                                    <div class="messageRecievedBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                    </div>
                                </div>
                                
                                <div class="messageRecievedBox">
                                    <div class="messageBox">
                                        <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Quisquam, blanditiis assumenda aut temporibus veniam in praesentium tenetur voluptatum velit asperiores cum architecto sit unde? Nemo aliquam harum enim eligendi vel.</p>
                                    </div>
                                    <div class="messageRecievedBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                    </div>
                                </div>
                            </div>

                            <div class="messageSendSection">

                                <div class="messageSendBox">
                                    <div class="messageBox">
                                        <p>Hi</p>
                                    </div>
                                    <div class="messageSendBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                        <div class="tick tickActive">
                                            <i class="fa-solid fa-check-double"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="messageSendBox">
                                    <div class="messageBox">
                                        <p>Afsal K T</p>
                                    </div>
                                    <div class="messageSendBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                        <div class="tick tickActive">
                                            <i class="fa-solid fa-check-double"></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="messageSendBox">
                                    <div class="messageBox">
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ipsa temporibus officiis necessitatibus quibusdam aut, amet nam omnis similique quis eum minus rem. Reiciendis odio autem voluptatem provident voluptatibus dolorem et!</p>
                                    </div>
                                    <div class="messageSendBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                        <div class="tick tickActive">
                                            <i class="fa-solid fa-check-double"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="messageRecievedSection">
                                <div class="messageRecievedBox">
                                    <a href="assets/images/doctor.jpg" class="downloadFileBtn" download>
                                        <i class="uil uil-import"></i>
                                    </a>
                                    <div class="messageBox">
                                        <a href="assets/images/doctor.jpg" class="messageBoxThumbnail spotlight">
                                            <img src="assets/images/doctor.jpg" alt="">
                                        </a>
                                    </div>
                                    <div class="messageRecievedBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                    </div>
                                </div>
                            </div>                        

                            <div class="messageSendSection">

                                <div class="messageSendBox">
                                    <div class="messageBox">
                                        <a href="assets/images/avatarOrange.png" class="messageBoxThumbnail spotlight">
                                            <img src="assets/images/avatarOrange.png" alt="">
                                        </a>
                                    </div>
                                    <div class="messageSendBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                        <div class="tick tickActive">
                                            <i class="fa-solid fa-check-double"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dateHeader">
                                <span>07/07/2022</span>
                            </div>

                            <div class="messageRecievedSection">
                                <div class="messageRecievedBox">
                                    <a href="assets/images/doctor.jpg" class="downloadFileBtn" download>
                                        <i class="uil uil-import"></i>
                                    </a>
                                    <div class="messageBox">
                                        <div class="messageBoxPDF">
                                            <div class="messageBoxPDFThumbnail">
                                                <img src="assets/images/pdf.png" alt="">
                                            </div>
                                            <div class="messageBoxPDFName">
                                                <h3>file-name.pdf</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="messageRecievedBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                    </div>
                                </div>
                            </div>

                            <div class="messageSendSection">
                                <div class="messageSendBox">
                                    <div class="messageBox">
                                        <div class="messageBoxPDF">
                                            <div class="messageBoxPDFThumbnail">
                                                <img src="assets/images/pdf.png" alt="">
                                            </div>
                                            <div class="messageBoxPDFName">
                                                <h3>file-namefile-namefile-namefile-namefile-name.pdf</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="messageSendBoxFooter">
                                        <div class="msgTime">10:00 am</div>
                                        <div class="tick">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="messageCanvasFooter">
                            <div class="fileAttachBtn">
                                <i class="uil uil-paperclip"></i>
                            </div>
                            <div class="messageInputArea">
                                <input type="text" placeholder="Type here...">
                                <button><i class="uil uil-message"></i></button>
                            </div>
                        </div>
            
                        <!--upload attachment popup-->
                        <div class="uploadAttachmentPopup">
                            <div class="closeUploadAttachmentPopup">
                                <i class="uil uil-multiply"></i>
                            </div>
                            
                            <div class="formWrapper">
                                <form action="">
                                    <div class="formLeadUpload">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" multiple onchange="javascript:updateList()" title="Upload Leads">
                                            <div class="xlFileUploadIcon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                                            <label class="custom-file-label" for="file"> Upload Files</label>
                                            <span>Browse or Drag and Drop</span>
                                        </div>
                                        <ul id="fileList" class="file-list"></ul>
                                    </div>

                                    <div class="formBtnArea">
                                        <button class="leadUploadSbtBtn">Send <i class="fas fa-paper-plane"></i></button>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!--upload attachment popup close -->
                    </div>
                </section>
                <!-- message canvas close -->
            </div>

        </div>

    </main>


    <!-- script  -->
        <?php
            include "assets/includes/script/script.php";
        ?>
    <!-- script close -->

    <script>
        
				
        // upload files 
        updateList = function() {
            var input = document.getElementById('file');
            var output = document.getElementById('fileList');
            var children = "";
            for (var i = 0; i < input.files.length; ++i) {
                children +=  '<li><p>'+ input.files.item(i).name +'</p> <span class="remove-list" onclick="return this.parentNode.remove()" title="Delete"><i class="uil uil-times"></i></span>' + '</li>'
            }
            output.innerHTML = children;
        }
        
        // attach file popup 
        $('.fileAttachBtn').click(function(){
            $('.uploadAttachmentPopup').addClass('uploadAttachmentPopupActive');
        });
        $('.closeUploadAttachmentPopup').click(function(){
            $('.uploadAttachmentPopup').removeClass('uploadAttachmentPopupActive');
        });

        // viewDetailsBtn
        $('.viewDetailsBtn').click(function(){
            $('.messageProfileDetailsPopup').fadeToggle();
        });
        $(document).mouseup(function(e) 
        {
            var container = $(".messageProfileDetailsPopup");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.hide();
            }
        });

    </script>

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