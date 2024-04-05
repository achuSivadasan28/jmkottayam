<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['lab_login_id']) and $_SESSION['lab_role'] == 'lab'){
$login_id = $_SESSION['lab_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_lab'];
$staff_unique_code = $_SESSION['lab_unique_code'];
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
                        <h1>Add Report</h1>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="changePwd">
							<div class="formFileUpload">
								<div class="uploadFileBtnBox">
									<label class="" >
										<p>Test Report Name</p>
										<input type="text" id="file_name" style="height:40px; width:100%;padding:5px;color:#000;margin:5px 0px 2px 0px;border-radius:8px;font-size:14px;outline:none;border:1px solid #ccc;">
										<span id='file_error'style="font-size:14px;color:red;"></span>
									</label>
									<label class="uploadFileBtn" style ='margin:5px 0px'>
										<p>Select Report</p>
										<input type="file" data-max_length="3" class="uploadInputFile" accept="image/*,.pdf,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"multiple>
										
									</label>
								</div>
								<div class="uploadImgWrap"></div>
							</div>

							<!-- dont remove the div, put it down -->
							<div class="dummyDiv"></div>
							<!-- dont remove the div, put it down -->
							

                        <div class="formBtnArea">
                            <button id="changePwd_btn">Save</button>
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
    <!-- script close -->

      <script>
	let pdfImg = 'https://johnmariansconsultation.com/assets/images/pdfimg.png'

        // flie upload 
        jQuery(document).ready(function () {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            // $('.uploadInputFile').each(function () {
                $('body').delegate('.uploadInputFile', 'change', function(e){
					console.log('event listened')
                // $(this).on('change', function (e) {
                imgWrap = $(this).parent().parent().parent().find('.uploadImgWrap');
                var maxLength = $(this).attr('data-max_length');

                var files = e.target.files;
                var filesArr = Array.prototype.slice.call(files);
                var iterator = 0;
                filesArr.forEach(function (f, index) {
					
					console.log(f.type)

                    if (!f.type.match('application/pdf')) {
                    return;
                    }

                    if (imgArray.length > maxLength) {
                    return false
                    } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                        len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
						console.log(f)
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                        var html = "<div class='imgBgBox'><div style='background-image: url(" + pdfImg + ")' data-number='" + $(".uploadImgClose").length + "' data-file='" + f.name + "' class='imgBg'><div class='uploadImgClose'></div></div></div>";
                        imgWrap.append(html);
                        iterator++;
                        }
                        reader.readAsDataURL(f);
                    }
                    }
                });
                });
            // });

            $('body').on('click', ".uploadImgClose", function (e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                if (imgArray[i].name === file) {
                    imgArray.splice(i, 1);
                    break;
                }
                }
                $(this).parent().parent().remove();
            });
        }
        
    </script>
	<script src="assets/appointment/upload_lab_test.js"></script>
    
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