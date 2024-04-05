<?php
session_start();
include_once 'action/security/security.php';
include_once 'action/security/unique_code.php';
include_once '../_class/query.php';
if(isset($_SESSION['staff_login_id']) and $_SESSION['staff_role'] == 'staff'){
$obj=new query();
$login_id = $_SESSION['staff_login_id'];
$api_key_value = $_SESSION['api_key_value_staff'];
$staff_unique_code = $_SESSION['staff_unique_code'];
$Api_key = fetch_Api_Key($obj);
$admin_live_unique_code = fetch_unique_code($obj,$login_id);
$check_security = check_security_details($Api_key,$admin_live_unique_code,$api_key_value,$staff_unique_code);

	//echo $check_security;exit();
	
	$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
if($check_security == 1){
$v = 1;
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
    <!-- head close -->

<body>
    	<style>
		.patientNameUl{
			background:#f5f2f2;
			border-radius:10px;
			display:none;
		}
		
		.patientNameUl li{
			list-style:none;
			padding:10px;
			font-size:12px;
		}
		.patientNameUl li:hover{
			cursor:pointer;
			background:#c8c4c4;
			border-radius:5px;
		}
	</style>
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

		<!-- image capture -->
		<div class="imageCapturePopup">
			<div class="imageCaptureSection">
				<div class="imageCaptureSectionMain">
					<div class="imageCaptureVideo">
						<video id="video" autoplay></video>
					</div>
					<div class="imageCaptureImage">
						<canvas id="canvas" style="display: none;"></canvas>
						<img id="image" />
					</div>
				</div>
				<div class="imageCaptureBtn">
					<div class="closeimageCapturePopup">Close</div>
					<button id="capture">Capture Image</button>
				</div>
			</div>
		</div>
		<!-- image capture -->

        <!-- delete alert  -->
        <div class="confirmAlert">
			<div class="confirmAlertMian">
                <div class="confirmAlertThumbnail">
                    <img src="assets/images/icon/confirmed.gif" alt="">
                </div>
                <div class="confirmAlertContent">
                    <p>Do you want to Confirm ?</p>
                    <div class="confirmAlertBtnArea">
                        <div class="closeconfirmAlert">No</div>
                        <button class="confirmconfirmAlert" style="border:none;">Confirm</button>
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
                <div class="canvasHead">
                    <div class="canvasHeadBox1">
                        <h1>Add Appointment</h1>
                        <div class="breadCrumbs">
                            <a href="appointments.php" class="back"><i class="uil uil-angle-left-b"></i></a>
                            <span>/</span>
                            <a href="appointments.php">Appointments</a>
                        </div>
                    </div>
                </div>
                <!-- canvas head close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
					<h2 style="font-size: 20px; font-weight: 500;">Personal Details</h2>
                    <form action="" id="add_appointment_frm">
                         <div class="formGroup profileUpload " style='flex: 0 0 100%'>
                            <label for="">Photo</label>
							<div class="col-ting">
                                <div class="control-group file-upload" id="logo-upload">
                                    <div class="image-box text-center">
                                        <img id="pimage" src="assets/images/user.png"alt="">
                                        <div class="editPen"id="picture"><i class="uil uil-camera"></i></div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
						<div class="formGroup">
                            <label for="">Phone</label>
                            <input type="number" id="number" required>
							<input type="hidden" id="branch_id" value=''>
							<span id="number_error" style="color:red"></span>
							<span id="branch_name" style="color:green"></span>
                        </div>
						<div class="formGroup" id="unique_id_data" style="display:none">
                            <label for="">Unique Id</label>
                            <input type="text" id="unique_id" value="0" disabled>
							
                        </div>
                        <div class="formGroup">
                            <label for="">Patient Name</label>
                            <input class="patientNameValue" type="text" id="name" value="" required>
							<ul class="patientNameUl">
								
							</ul>
							<span id="name_error" style="color:red"></span>
							
                        </div>
                        
                        <div class="formGroup">
                            <label for="">Gender</label>
							<div class="formGroupCheckbox gender_details" style="display: flex; align-items: center; width: 100%; justify-content: space-between; margin-top: 20px;">
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Male">Male</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Female">Female</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Other">Other</label>
								</span>
							</div>
                        </div>
						
						<div class="formGroup op" style="display:flex;flex-direction:column;justify-content:center;">
							 <label for="oldPatient">Old patient</label>
							 <input type="checkbox" style="height:30px;width:30px;" class="oldCheck"/>
						</div>
						 <div class="formGroup oldVisitCount" style="display:none;">
							 <label for="oldVisits">No.of old visits</label>
							 <input type='number' id="numofvisit"/>
						</div>
						
						<div class="dummyDiv"></div>
						
						<div class="formGrouptextarea">
                            <label for="">Address</label>
							<textarea id="address" autocomplete="off"></textarea>
                        </div>
                        <div class="formGroup">
                            <label for="">Place</label>
                            <input type="text" id="place" >
                        </div>
						
                        <div class="formGroup">
                            <label for="">Age</label>
                            <input type="number" id="age" >
							<span id="age_error" style="color:red"></span>
                        </div>
						
						<div class="formGroup">
                            <label for="">First Visit</label>
                            <input type="date" id="Fvisit" >
                        </div>
						<div class="formGroup">
                            <label for="">whatsApp</label>
                            <input type="text" id="WhatsApp">
                        </div>
						
						<div class="dummyDiv"></div>
						
                       <!-- <div class="formGroup">
                            <label for="">Gender</label>
                            <div class="formSelect">
                                <select name="" id="gender_data" >
                                    <option value="" selected disabled></option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>-->  
                    </form>
                </div>
				
				<div class="formWraper">
					<h2 style="font-size: 20px; font-weight: 500;">Appointment Details</h2>
                    <form action="" id="add_appointment_frm">
						 <div class="formGroup">
                            <label for="">Date</label>
                            <input type="date" id="date" required>
                        </div>
						<div class="formGroup previousDoctor" style="display:none">
                            <label for="">Previous Doctor</label>
                            <input type="text" id="pvDoctor" disabled>
                        </div>
                        <div class="formGroup">
                            <label for="">Select Doctor</label>
                            <div class="formSelect">
                                <select name="" id="doctor_data" >
                                
                                </select>
                            </div>
							<span id="doctor_required" style="color:red"></span>
                        </div>
                       <div class="formGroup nr_type" style="display:none;flex-direction:row;justify-content:space-around;">
						   <div style="display:flex;flex-direction:column;">
							<label for="oldPatient">NR</label>
							 <input type="radio" name="nr_check" value="nr" style="height:30px;width:30px;" class="nr_checkBox"/>
						   </div>
						   <div style="display:flex;flex-direction:column;">
						     <label for="oldPatient">Zero</label>
							 <input type="radio" name="nr_check" value="0" style="height:30px;width:30px;" class="nr_checkBox"/>
							   </div>
						</div>
						
						<div class="formGroup">
                            <label for="">Appointment Fee</label>
                            <input type="number" id="appointment" disabled required>
							<span id="appointment_fee" style="color:red"></span>
							<span id="no_appointment_fee" style="color:blue"></span>
                        </div>

                        <!-- dont remove the div, put it down -->
                        <div class="dummyDiv"></div>
                        <!-- dont remove the div, put it down -->
						
						<div class="formGrouptextarea offlineConsultingDetails" style="display: none;">
							<label for="" id="select_slot_data">Select Slot</label>
							<div class="formSlotSection doctor_available_all_time_solt">
								<!--<label class="control" for="technology">
									<input type="radio" name="topics" id="technology" disabled="">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>8:00 am - 9:00 am</p>
									</span>
								</label>
								<label class="control" for="health">
									<input type="radio" name="topics" id="health">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>9:00 am - 10:00 am</p>
									</span>
								</label>
								<label class="control" name="science">
									<input type="radio" name="topics" id="science">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>10:00 am - 11:00 am</p>
									</span>
								</label>
								<label class="control" name="science">
									<input type="radio" name="topics" id="science">
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>10:00 am - 11:00 am</p>
									</span>
								</label>-->

								<!-- dont remove the div, put it down -->
								<!--<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>-->
								<!-- dont remove the div, put it down -->
								
							</div>
							<span id="time_slot_required" style="color:red"></span>
						</div>

                       
                    </form>
                </div>
                <!-- form section close -->
				
				<!-- Payment mode -->
				<div class="formWraper">
					<h2 style="font-size: 20px; font-weight: 500;margin-bottom:10px;">Payment Mode</h2>
                    <form action="" id="paymentMode">
					
					<div class="given_payment" style="width: 100%; display: flex; justify-content: space-between;
    flex-wrap: wrap;">
						 <div class="formGroup">
                            <label for="">Choose mode of payment</label>
                            <select class="payment_details">
						<option value="0">Choose Payment</option>
<option value="1">Gpay</option>
<option value="2">Cash</option>
<option value="3">Card</option>
							 </select>
							 <span id="amt_error_msg" style="color:red"></span>
							 <span class="payment_option_error" style="color:red;"></span>
                        </div>
						
                        <div class="formGroup">
                            <label for="">Amount</label>
                            <input type='number' class="amount_paid"/>
                        </div>
						
						
						
						<div class="addMoreButton" style="display: flex; justify-content: flex-start; flex: 0 0 22%; align-items: flex-end;">
							<button style="background:#1a8843;padding:10px 20px;border:none;border-radius:5px;color:#fff;cursor:pointer;" class='addButn'>Add Another</button>
						</div>
						
						<div class="dummyDiv"></div>
					
						</div>
					
                    </form>
                </div>
				
				<!-- Payment mode close -->
                
                <!-- form wraper  -->
                <div class="formWraper">
					<h2 style="font-size: 20px; font-weight: 500;">BMI Details</h2>
                    <form action="" id="patient_illness_form">
						<div class="formGroup">
                            <label for="">Height In CM</label>
                            <input type="text" id="height">
                        </div>
						<div class="formGroup">
                            <label for="">Weight In KG</label>
                            <input type="number" id="weight">
                        </div>
						<div class="formGroup">
                            <label for="">Blood Pressure</label>
                            <input type="text" id="blood_pressure" >
							<span id="blood_p_error" style="color:red"></span>
                        </div>
						
						<div class="formGroup">
                            <label for="">Allergies if any</label>
                            <input type="text" id="allergies_if_any">
                        </div>
						<div class="formGroup">
                            <label for="">Current Medication</label>
                            <input type="text" id="current_medication">
                        </div>
						<div class="formGroup">
                            <label for="">Present Illness</label>
                            <input type="text" id="present_illness">
                        </div>
						<div class="formGroup">
                            <label for="">Any Surgeries, If Yes (Mention)</label>
                            <input type="text" id="any_surgeries">
                        </div>
						<div class="formGroup">
                            <label for="">Any metal Implantation, If Yes (Mention)</label>
                            <input type="text" id="any_metal_lmplantation">
                        </div>
						<div class="formGroup"></div>
						 <div class="formBtnArea">
                            <button id="appointment_btn">Save</button>
                        </div>
						
					</form>
				</div>

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
   <script src="assets/appointment/add-appointment.js?v=<?php echo $version_variable;?>"></script>
	<script>

		
		
		let oldPatientCheckBox = document.querySelector('.oldCheck');
		let oldVisitInput = document.querySelector('.oldVisitCount');
		
		oldPatientCheckBox.addEventListener('change',function(){
			if(this.checked){
				$('.oldVisitCount').css('display','flex');
			}else{
				$('.oldVisitCount').css('display','none');
			}
		})
		
		
		
		//add more button//
		 let addMorebtn = document.querySelector('.addButn');
		let parentForm = document.querySelector('#paymentMode');
		
		
				addMorebtn.addEventListener('click',function(e){
			e.preventDefault();
			
			//console.log(parent_div)
		let template = `


<div class= "given_payment" style="width: 100%; display: flex; justify-content: space-between;
    flex-wrap: wrap;"> <div class="formGroup">
                            <label for="">Choose mode of payment</label>
                            <select class="payment_details" id="payment_details">
<option value="0">Choose Payment</option>
<option value="1">Gpay</option>
<option value="2">Cash</option>
<option value="3">Card</option>
</select>
<span class="payment_option_error" style="color:red;"></span>
                        </div>

                        <div class="formGroup">
                            <label for="">Amount</label>
                            <input type='number' class="amount_paid"/>
                        </div>
<div class="addMoreButton" style="display: flex; justify-content: flex-start; flex: 0 0 22%; align-items: flex-end;">
							<button style="background:red;padding:10px 20px;border:none;border-radius:5px;color:#fff;cursor:pointer;" class='removeButn'>Remove</button>
						</div>
						<div class="dummyDiv"></div>
</div>`
		

			parentForm.insertAdjacentHTML('beforeend',template);
		})
		
		//add more button//
		
		$('body').delegate('.removeButn', 'click', function(e){
			e.preventDefault();
			$(this).parent().parent().remove();
		})
		
		
		
		
		
		
		
	let patientNameLi = $('.patientNameUl li');
	let thePatientName =  $('.patientNameValue');
		
	      thePatientName.click(()=>{
		$('.patientNameUl').css('display','block')
	})	
		
				/*$('.patientNameValue').keyup((e)=>{
					//console.log(e.target.value.toLowerCase())
					let theUserSearch = e.target.value.toLowerCase()
					  if(e.target.value === ''){
					  		$('.patientNameUl').css('display','block');
						  	patientNameLi.css('display','block');
					  }
					patientNameLi.length
					for(let i=0; i<patientNameLi.length; i++){
						patientNameLi.length
						let theLiVal = patientNameLi[i].innerHTML.toLowerCase()
						if(theLiVal.includes(theUserSearch)){
							console.log(theLiVal)
							patientNameLi[i].style.display = 'block';
								
					}else{
						patientNameLi[i].style.display = 'none';
					}
					}
				})*/
		
		
	/*patientNameLi.click((e)=>{
		$('.patientNameUl').css('display','none')
		console.log(e.target.innerHTML);
		let thePN = $('.patientNameValue');
		thePN.val(e.target.innerHTML)
		
	})*/
		
$('body').click((e)=>{
	if(e.target.className === 'patientNameValue'){
		$('.patientNameUl').css('display','block');	
	}else{
		$('.patientNameUl').css('display','none');	
	}
})
$('.buttonClose').click(function(){
	$('#cameraDiv').css('display','none');
})

       
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