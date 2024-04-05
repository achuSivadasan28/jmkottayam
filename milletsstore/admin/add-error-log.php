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
<style>
#dashboard .formWraper form .formTextareaGroup .upload__box {
  margin-top: 10px;
}

#dashboard .formWraper form .formTextareaGroup .upload__inputfile {
  width: .1px;
  height: .1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}

#dashboard .formWraper form .formTextareaGroup .upload__btn {
  display: inline-block;
  font-weight: 400;
  color: #fff;
  text-align: center;
  width: 200px;
  padding: 5px;
  -webkit-transition: all .3s ease;
  transition: all .3s ease;
  cursor: pointer;
  border: 2px solid;
  background-color: #756893;
  border-color: #756893;
  border-radius: 10px;
  line-height: 26px;
  font-size: 14px;
}

#dashboard .formWraper form .formTextareaGroup .upload__btn:hover {
  background-color: unset;
  color: black;
  -webkit-transition: all .3s ease;
  transition: all .3s ease;
}

#dashboard .formWraper form .formTextareaGroup .upload__btn-box {
  margin-bottom: 10px;
}

#dashboard .formWraper form .formTextareaGroup .upload__img-wrap {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  margin: 0 -10px;
}

#dashboard .formWraper form .formTextareaGroup .upload__img-box {
  width: 200px;
  padding: 0 10px;
  margin-bottom: 12px;
}

#dashboard .formWraper form .formTextareaGroup .upload__img-close {
  width: 24px;
  height: 24px;
  border-radius: 50%;
  background-color: rgba(0, 0, 0, 0.5);
  position: absolute;
  top: 10px;
  right: 10px;
  text-align: center;
  line-height: 24px;
  z-index: 1;
  cursor: pointer;
}
                                         
#dashboard .formWraper form .formTextareaGroup .upload__img-close:after {
  content: '\2716';
  font-size: 14px;
  color: white;
}

#dashboard .formWraper form .formTextareaGroup .img-bg {
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
  position: relative;
  padding-bottom: 100%;
}
	</style>
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
                        <h1>Add Error</h1>
                        <div class="breadCrumbs">
                            <a href="error-log.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="error-log.php">Error Log Management</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
                    <form action="" id="add_error_form">
						<div class="formTextareaGroup">
							
							<div class="upload__box">
								<div class="upload__btn-box">
									<label class="upload__btn">
										<p>Upload File</p>
										<input type="file" data-max_length="20" id="upload_img_vals" class="upload__inputfile" accept=".jpg, .jpeg, .png, .webp">
									</label>									
								</div>
								<div class="upload__img-wrap product_img_main"></div>
							</div>
								<span id="img_error"> </span>	
							</div>
                        <div class="formGrouptextarea">
                            <label for="">Issue Info</label>
							<textarea id="issue_info" required></textarea>
                        </div>
						<div class="formGroup">
                            <label for="">Priority</label>
                            <select name="" id="priority_data" required>
								<option value="">Choose Priority</option>
								<!--<option value="A">A</option>
								<option value="B">B</option>-->
                            </select>
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->

                        <div class="formBtnArea">
                            <button id="add-staff-btn" class="add_error">Submit</button>
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
    
    <!-- jquery  -->
    <script src="assets/js/jquery.js"></script>
    <!-- fontawesome -->
    <script src="https://kit.fontawesome.com/4022a59704.js" crossorigin="anonymous"></script>
    <!-- text eiter -->
    <script src="assets/js/summernote-lite.js"></script>
    <!-- main -->
    <script src="assets/js/main.js"></script>	<script src="assets/errorLog/add-error-log.js?v=2.1"></script>
    <script>
				 jQuery(document).ready(function () {
            ImgUpload();
        });
        var imgArray = [];
        function ImgUpload() {
        var imgWrap = "";

        $('.upload__inputfile').each(function () {
            $(this).on('change', function (e) {
            imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
            var maxLength = $(this).attr('data-max_length');

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
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
                    imgArray.push(f);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                    var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                    imgWrap.append(html);
                    iterator++;
                    }
                    reader.readAsDataURL(f);
                }
                }
            });
            });
        });

        $('body').on('click', ".upload__img-close", function (e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
            }
            $(this).parent().parent().remove();
        });
			$('body').on('click','#upload_img_vals',function(e){
        $('.upload__img-close').parent().parent().remove()
        })
        }
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