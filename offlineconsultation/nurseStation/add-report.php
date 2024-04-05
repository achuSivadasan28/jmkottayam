<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['nurse_login_id']) and $_SESSION['nurse_role'] == 'nurse'){
$login_id = $_SESSION['nurse_login_id'];
$obj = new query();
$api_key_value = $_SESSION['api_key_value_nurse'];
$staff_unique_code = $_SESSION['nurse_unique_code'];
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
						<div class="templateDiv">
							<div class="formFileUpload">
								<div class="uploadFileBtnBox">
									<label class="uploadFileBtn">
										<p>Upload File</p>
										<input type="file" data-max_length="20" class="uploadInputFile" multiple>
									</label>
								</div>
								<div class="uploadImgWrap"></div>
							</div>
							<div class="formGroup">
								<label for="">Name</label>
								<input type="text" class="file_name">
							</div>
							<div class="formGrouptextarea">
								<label for="">Remark</label>
								<textarea class="file_remark"></textarea>
							</div>

							<!-- dont remove the div, put it down -->
							<div class="dummyDiv"></div>
							<!-- dont remove the div, put it down -->
							
						</div>
						
						<div class="appendDiv"></div>
						
						<div class="templateAddBtnArea">
							<div class="templateAddBtn">Add</div>
						</div>

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
		
		// templateAddBtn
		$('.templateAddBtn').click(function(){
			var appendDiv = $('.appendDiv');
			var templateDiv = `<div class="templateDiv">
							<div class="formFileUpload">
								<div class="uploadFileBtnBox">
									<label class="uploadFileBtn">
										<p>Upload File</p>
										<input type="file" data-max_length="20" class="uploadInputFile" multiple>
									</label>
								</div>
								<div class="uploadImgWrap"></div>
							</div>
							<div class="formGroup">
								<label for="">Name</label>
								<input type="text" class="file_name">
							</div>
							<div class="formGrouptextarea">
								<label for="">Remark</label>
								<textarea class="file_remark"></textarea>
							</div>

							<!-- dont remove the div, put it down -->
							<div class="dummyDiv"></div>
							<!-- dont remove the div, put it down -->
							
							<div class="templateRemoveBtnArea">
								<div class="templateRemoveBtn">Remove</div>
							</div>
						</div>`;
			appendDiv.append(templateDiv);
		})
		$('body').delegate('.templateRemoveBtn', 'click', function(){
			$(this).parent().parent().remove();
		})
		
		let url_val = window.location.href
		let url_split = url_val.split("=")
		let url_details = url_split[1]
		
		

        // flie upload 
        jQuery(document).ready(function () {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            // $('.uploadInputFile').each(function () {
                $('body').delegate('.uploadInputFile', 'change', function(e){
                // $(this).on('change', function (e) {
                imgWrap = $(this).parent().parent().parent().find('.uploadImgWrap');
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
                        var html = "<div class='imgBgBox'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".uploadImgClose").length + "' data-file='" + f.name + "' class='imgBg'><div class='uploadImgClose'></div></div></div>";
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
		$('#changePwd_btn').click(function(e){
			$(this).text('Loading...')
			let temp_count = $('.templateDiv').length;
			let temp_data = 0;
			e.preventDefault()
			$('.templateDiv').each(function(){
				let fd = new FormData();
				let file_name = $(this).find('.uploadInputFile').val().replace("C:\\fakepath\\", "");
				let file_data_name = $(this).find('.file_name').val()
				let file_remark = $(this).find('.file_remark').val()
				fd.append("file_name",file_name);
				fd.append("file_data_name",file_data_name);
				fd.append("file_remark",file_remark);
				fd.append("url_details",url_details);
				fd.append("files[]", $(this).find('.uploadInputFile')[0].files[0])
				$.ajax({
				  url:"action/upload_data/Upload_file.php",
                  type:"POST",
                  data:fd,
                  contentType:false,
                  processData:false,
				  success:function(result_data){
				  	console.log(result_data)
					  temp_data++
					  if(temp_data == temp_count){
					  		history.back()
					  }
				  }
				})
			})
		})
		
		function insert_file(){
          let fd = new FormData();
		  fd.append("files[]", $(this).find('#chooseFile')[0].files[0])
		}
		
		function insert_file_data(fd){
					 return $.ajax({
                        url:"action/Upload_file.php",
                        type:"POST",
                        data:fd,
                        contentType:false,
                        processData:false,
                    })
				}
        
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