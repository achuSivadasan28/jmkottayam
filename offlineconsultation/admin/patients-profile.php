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

$head = '';
$address = '';
$phn_details = '';
$gmail = '';
$website = '';
$select_address_data = $obj->selectData("head,address,phn_details,gmail,website","tbl_address","");
if(mysqli_num_rows($select_address_data)>0){
	while($select_address_data_row = mysqli_fetch_array($select_address_data)){
		$head = $select_address_data_row['head'];
		$address = $select_address_data_row['address'];
		$phn_details = $select_address_data_row['phn_details'];
		$gmail = $select_address_data_row['gmail'];
		$website = $select_address_data_row['website'];
	}
}
	$version_variable = '';
$select_version = $obj->selectData("id,version_id","tbl_version","");
	if(mysqli_num_rows($select_version)){
	while($select_version_row = mysqli_fetch_array($select_version)){
$version_variable = $select_version_row['version_id'];
		
	}
	}
?>
<!DOCTYPE html>
<html lang="en">

    <!-- head -->
    <?php
        include "assets/includes/head/head.php";
    ?>
	<head>
		<link rel='stylesheet' href="assets/css/styles.css"/>
	</head>
    <!-- head close -->

<body>
	<style>
		.shimmer{
			z-index:150;
			position:fixed;
			height:100vh;
			width:100vw;
			background:#7a7a7a85;
			display:none;
		}
		
		.basicDetails{
			background:#fff;
			height:200px;
			width:50%;
			border-radius:10px;
			padding:10px;
			display:flex;
		}
		.bdLeft{
			display:flex;
			justify-content:space-around;
			align-items:center;
		}
		.bdDetails{
			margin-left:10px;
			font-weight:500;
		}
		.bdDetails h2{
			font-size:24px;
			    font-weight: 500;
			margin-bottom:10px;
		}
		.bdDetails h4{
		 font-weight: 300;
		}
		.bdLeft img{
			height:100%;
			width:200px;
			object-fit :contain;
			border-radius:10px;
		}
		.bdRight{
			color:grey;
			border-radius:10px;
			width:100%;
			background:#fff;
			margin-left:20px;
			
		}
		.card{
			background:red;
			padding:15px 40px 15px 40px;
			color:#fff;
			border-radius:10px;
		}
		.cards{
			display:flex;
		}
		.consultationsCardMain{
			background:#fff;
			padding:10px;
			border-radius:10px;
			margin-top:15px;
		}
		.consultationCardHead{
			display:flex;
			justify-content:space-between;
			
		}
		.consultationCardHead h3{
			border:1px solid lightgrey;
			padding:6px 10px;
			border-radius:5px;
			font-size:14px;	
			margin-bottom:10px;
			font-weight:400;
		}
		.consultationsCardDetails{
			padding:10px;
		}
		.cardLeft{
			display:flex;
		}
		.consultationsCardDetails h4{
			font-weight:400;
			margin:10px;
			font-size:16px;
			background:#f4f4f4;
			border-radius:8px;
			padding:10px;
		}
		.cardRight{
			display:flex;
			justify-content:flex-end;
		}
		.moreDetailsButton{
			background:#68ac68;
			color:#fff;
			padding:10px;
			font-size:12px;
			border:none;
			border-radius:8px;
			cursor:pointer;
			margin-left:15px;
		}
		.prescriptionBtn{
				background:#648ead;
			font-size:12px;
			color:#fff;
			padding:10px;
			border:none;
			border-radius:8px;
			cursor:pointer;
		}
		.prescriptionBtn:hover{
			background:#5582a2;
		}
		.moreDetailsButton:hover{
			background:#4da94d;
		}
		hr{
			background:red;
		}
		.tabs{
			display:flex;
			align-items:center;
			background:#fff;
			height:200px;
			width:49%;
			border-radius:10px;
			padding:10px;
			display:flex;
		}
		.tabCards{
			cursor:pointer;
			display:flex;
			flex-direction:column;
			align-items:center;
			justify-content:center;
			margin:10px;
			border-radius:10px;
			padding:10px;
			width:125px;
			height:125px;
			border:0.2px solid #e1e1e1;
		}
		.tabCards:hover{
		border:0.2px solid #a2a29f;
		}
		.tabCards img{
			height:50px;
			width:50px;
		}
		.tabCards p{
			margin-top:10px;
		font-size:12px;
			font-weight:500;
		}
		.consultationPopup{
			position:fixed;
			z-index:200;
			background:#fff;
			height:70vh;
			width:80vw;
			margin-top:15px;
			padding:10px;
			border-radius:10px;
			display:none;
			overflow-y:scroll;
		}
		.presTitle{
			font-size:14px;
			font-weight:500;
			/*border:0.5px solid lightgrey;*/
			padding:8px 12px;
			margin:10px 0px;
			width:200px;
			border-radius:8px;
			display:flex;
			justify-content:center;
			background-image: linear-gradient(118deg, #5280cd, #1e7e35);
			color:#fff;
		}
		.consultationPrescriptionMain{
			display:flex;
		/*	border:0.2px solid #bdbdbd;*/
			/*background:#efefef;*/
			border-radius:5px;
			flex-wrap:wrap;
			margin-bottom:10px;
		}
		.prescriptionBox{
			align-items:center;
			/*border:0.5px solid #cccccc;*/
			padding:10px;
			width:auto;
			display:flex;
			justify-content:space-between;
			margin:10px;
			background:#fff;
			box-shadow: 1px 1px 5px 0px #ccc;
			border-radius:8px;
			gap:10px;
		}
		.afbf{
		color:green;
			font-weight:bold;
		}
		.time{
			background:#256603;
			color:#fff;
			padding:2px 10px;
			border-radius:5px;
		}
		.complaintsBox{
			   /* background-image: linear-gradient(360deg, #ffffff54, #e5ff9554);*/
			border-radius:10px;
			margin:10px 0px;
			border:1px solid #e4e4e4;
			box-shadow:1px 1px 5px 0px #ccc;
			font-weight:400;
			padding:10px;
			width:390px;
			display:flex;
			flex-direction:column;
			
		}
		.remarks{
			/* background-image: linear-gradient(360deg, #ffffff54, #5fe89c54);*/
			border-radius:10px;
			border:1px solid #e4e4e4;
			box-shadow: 1px 1px 5px 0px #ccc;
			margin:10px 0px;
			font-weight:400;
			padding:10px;
			width:50%;
			display:flex;
			flex-direction:column;
		}
		.buttonClose{
			background:#d80000;
			height:30px;
			padding:0px 20px;
			font-weight:500;
			color:#fff;
			border-radius:5px;
			border:none;
			cursor:pointer;
			right:0;
		}
		.buttonClose:hover{
					background:red;	
		}
		
		.reportsPopup{
			/*background:#fff;
			padding:10px;
			border-radius:10px;
			display:none;*/
			
			position:fixed;
			z-index:200;
			background:#fff;
			height:70vh;
			width:80vw;
			margin-top:15px;
			padding:10px;
			border-radius:10px;
			display:none;
			overflow-y:scroll;
		}
		.reportCard{
			/*box-shadow: 1px 0px 15px -8px rgba(0,0,0,0.63);*/
			background:#f0fcf987;
			border:0.2px solid lightgrey;
			border-radius:8px;
			padding:10px;
			margin-bottom:10px;
		}
		.reportsCardHead{
			display:flex;
			justify-content:space-between;
		}
		.reportsCardHead h3{
			border: 1px solid lightgrey;
			padding: 6px 10px;
			border-radius: 5px;
			font-size: 14px;
			margin-bottom: 10px;
			font-weight: 400;
		}
		.reportDetails{
			display:flex;
			align-items:center;
			box-shadow: 1px 0px 15px -8px rgba(0,0,0,0.63);
			padding:10px 20px;
			width:350px;
			border-radius:8px;
			justify-content:space-between;
			margin:5px;
		}
		.reportDetails i{
			margin-left:10px;
			background:#57ab27a8;
			color:#fff;
			font-weight:300;
			border-radius:5px;
			padding: 6px;
			cursor:pointer;
		}
		.reportDetails h4{
			font-weight:500;
		}
		.reportCardBody{
			padding:10px 0px;
			display:flex;
			flex-wrap:wrap;
			
		}
		.reportHeading{
			font-size:14px;
			font-weight:500;
			/*border:0.5px solid lightgrey;*/
			padding:8px 12px;
			margin:10px 0px;
			width:200px;
			border-radius:8px;
			display:flex;
			justify-content:center;
			background-image: linear-gradient(118deg, #5280cd, #1e7e35);
			color:#fff;
		}
		.elseDesign{
			display:none;
			justify-content:center;
			align-items:center;
			background:#fff;
			border-radius:10px;
			padding:15px;
			margin-top :10px;
		}
	</style>
	
	
      <!-- print design  -->
		<div class="printPage">
			<div class="printPageHead">
				<h1><div class="printPageHeadLogo"><img src="assets/images/johnmariansLogo.png" alt=""style="width:100%"></div> WELLNESS CLINIC</h1>
				<p>A Speciality Health Care</p>
			</div>
			<div class="printPageProfile">
				<div class="printPageProfileRow">
					<div class="name" id="name_data"></div>
					<div class="gender">Gender : <b id="gender_data"></b></div>
					<div class="age">Age : <b id="age_data"></b></div>
					<div class="id">ID : <b id="unique_id">JMW/2022/3</b></div>
					<div class="totalVisit">Total Visit : <b id="total_visit">3</b></div>
					<div class="FirstVisit">First Visit : <b id="first_visit"></b></div>
					<div class="LastVisit">Last Visit : <b id="last_visit"></b></div>
					<div class="LastVisit2 p_height">Height : <b id="height_data"></b></div>
					<div class="LastVisit2 p_weight">Weight : <b id="weight_data"></b></div>
					<div class="LastVisit2 p_bmi">BMI : <b id="bmi_data">s</b></div>
					<div class="LastVisit2 p_category">Category : <b id="weight_cat"></b></div>
					
					
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
					<div class="dummyDiv"></div>
				</div>
			</div>
			<div class="printPageBody">
				<div class="printPageBodyRow1">
					<div class="printPageBox">
						<h2>Consulted by</h2>
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<div class="doctorDetailBox dynamic_doctor">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<!--<div class="doctorDetailBox dynamic_doctor">
							<ul>
								<li><b>Dr Reshma Biju</b></li>
								<li>BNYS, DNHE</li>
								<li>TCMC 380</li>
								<li>Naturopathy Yoga Physician</li>
							</ul>
						</div>-->
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
						<div class="doctorDetailBox">
							<ul>
								<li><b></b></li>
								<li></li>
								<li></li>
								<li></li>
							</ul>
						</div>
					</div>
					<div class="printPageBox prescription_data_print">
						<h2>Prescription</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.	</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
					<div class="printPageBox complaints_data_print">
						<h2>Complaints</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
				</div>
				<div class="printPageBodyRow1">
					<div class="printPageBox medical_history_print">
						<h2>Medical History</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
					<div class="printPageBox Investigations_data">
						<h2>Investigations</h2>
						<!--<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
						<p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
						<p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>-->
					</div>
				</div>
				<div class="printPageBodyRow1">
					<div class="printPageBox">
						<h2>Diet to be followed / പാലിക്കേണ്ട ഭക്ഷണക്രമം.</h2>
						<ul class="food_to_follow">
						<!--	<li>Weight Management Diet</li>
							<li>Low Protein Diet</li>
							<li>Low Carb Diet</li>-->
							
							<!--<li><b>No. of Days : 10 Days</b></li>-->
						</ul>
					</div>
					<div class="printPageBox">
						<h2>Foods to be avoided / ഒഴിവാക്കേണ്ടവ.</h2>
						<ul class="food_to_avoid">
							<!--<li>Milk, Milk with tea, Ice Cream</li>
							<li>Wheat, Maida, Oats, Rava, Atta</li>
							<li>Soy Products</li>
							<li>Coffee</li>-->
						</ul>
					</div>
				</div>
				<div class="printPageBodyRow2">
					<div class="printPageBox">
						<h2>Remark</h2>
						<p id="all_remark"></p>
					</div>
				</div>
			</div>
			<div class="printPageFooter">
				<h1><div class="printPageFooterLogo"><img src="assets/images/johnmariansLogo.png" alt="" style="width:100%"></div> WELLNESS HOSPITAL</h1>
				<p><i class="uil uil-location-point"></i> P.P Road kottayam,Meenachil p.o, Pala, Kottayam- 686577 <br><i class="uil uil-phone-alt"></i> Ph: (Reg) +91 95627 32575 <i class="uil uil-envelope"></i> johnmarianwellness@gmail.com <i class="uil uil-globe"></i> www.drmanojjohnson.com</p>
			</div>
		</div>
        <!-- print design close -->
	
    
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
           <!-- basic details card  -->  
				<div style="display:flex;justify-content:space-between;">
     <div class="basicDetails">
		 <div class="bdLeft">
			 <img src="assets/images/avatar1.png" alt="image" id="profile_photo"/>
		 </div>
		 <div class="bdRight">
			  <div class="bdDetails">
				 <h2 id="patient_name"></h2>
				  <h4 id="patient_age" style="margin-bottom:10px;font-weight:400;"></h4>
				 <h4 id="patient_place" style="margin-bottom:10px;font-weight:400;"></h4>
				 <h4 id="patient_phn" style="margin-bottom:10px;font-weight:400;"></h4>
			 </div>
			<div class="cards">
				 <span class="card visits" style="background:#339c8a;"></span>
				 <span class="card bmistatus" style="background:#89a229;margin-left:15px;"></span>
			 </div>
		 </div>
		 
	</div>	
					<div class="tabs">
						<div class="tabCards reportCrd">
							<img src="assets/images/rpts.png" alt="Reports"/>
							<p>Reports</p>
						</div>
						<div class="tabCards treatCrd">
							<img src="assets/images/trtmnts.png" alt="Reports"/>
							<p>Treatments</p>
						</div>
					</div>
				</div>
				      <!-- basic details card close -->   
				
				      <!-- consultations card  -->  
				<div class="history">
				<!--<div class="consultationsCardMain">
					<div class="consultationCardHead">
						<h3>14-02-2022</h3>
						<h3>Dr.Divya Sujith</h3>
					</div>
					<hr>
					<div class="consultationsCardDetails">	
						<div class="cardLeft">
							<h4><b>BMI</b>: 22</h4>
							<h4><b>Blood Pressure</b>: 82</h4>
							<h4><b>Weight</b>: 72 KG</h4>
							<h4><b>Allergies</b>: NIL</h4>
							<h4><b>Surgery</b>: NIL</h4>
							<h4><b>Illness</b>: Fever</h4></div>
						</div>
						<div class="cardRight">
						<button class="prescriptionBtn">View Prescription</button>
						<button class="moreDetailsButton">More details</button>	
					</div>
				</div>

			<div class="consultationsCardMain">
					<div class="consultationCardHead">
						<h3>14-02-2022</h3>
						<h3>Dr.Divya Sujith</h3>
					</div>
					<hr>
					<div class="consultationsCardDetails">	
						<div class="cardLeft">
							<h4><b>BMI</b>: 22</h4>
							<h4><b>Blood Pressure</b>: 82</h4>
							<h4><b>Weight</b>: 72 KG</h4>
							<h4><b>Allergies</b>: NIL</h4>
							<h4><b>Surgery</b>: NIL</h4>
							<h4><b>Illness</b>: Fever</h4></div>
						</div>
						<div class="cardRight">
						<button class="prescriptionBtn">View Prescription</button>
						<button class="moreDetailsButton">More details</button>	
					</div>
				</div>
				
				<div class="consultationsCardMain">
					<div class="consultationCardHead">
						<h3>14-02-2022</h3>
						<h3>Dr.Divya Sujith</h3>
					</div>
					<hr>
					<div class="consultationsCardDetails">	
						<div class="cardLeft">
							<h4><b>BMI</b>: 22</h4>
							<h4><b>Blood Pressure</b>: 82</h4>
							<h4><b>Weight</b>: 72 KG</h4>
							<h4><b>Allergies</b>: NIL</h4>
							<h4><b>Surgery</b>: NIL</h4>
							<h4><b>Illness</b>: Fever</h4></div>
						</div>
						<div class="cardRight">
						<button class="prescriptionBtn">View Prescription</button>
						<button class="moreDetailsButton">More details</button>	
					</div>
				</div>-->
				
				<!--<div class="consultationsCardMain">
					<div class="consultationCardHead">
						<h3>14-02-2022</h3>
						<h3>Dr.Divya Sujith</h3>
					</div>
					<hr>
					<div class="consultationsCardDetails">	
						<div class="cardLeft">
							<h4><b>BMI</b>: 22</h4>
							<h4><b>Blood Pressure</b>: 82</h4>
							<h4><b>Weight</b>: 72 KG</h4>
							<h4><b>Allergies</b>: NIL</h4>
							<h4><b>Surgery</b>: NIL</h4>
							<h4><b>Illness</b>: Fever</h4></div>
						</div>
						<div class="cardRight">
						<button class="prescriptionBtn">View Prescription</button>
						<button class="moreDetailsButton">More details</button>	
					</div>
				</div>-->
				</div>
				      <!-- consultations card close -->    
				
				
				
				      <!-- consultations popup -->  
				<div class="consultationPopup">
					 <!-- prescription items--> 
					<div style="display:flex; justify-content:space-between;">
						<h2 class="presTitle">Prescriptions</h2>
						<button class="buttonClose">Close</button>
					</div>
					<div class="consultationPrescriptionMain pdetails">
						
						 
						<!--<div class="prescriptionBox">
							<span class="prescriptions"><b>Omega 3</b></span>
							<span class="prescriptions time">1 0 1</span>
							<span class="prescriptions afbf">AF</span>
						</div>
						
						<div class="prescriptionBox">
							<span class="prescriptions"><b>Omega 3</b></span>
							<span class="prescriptions time">1 0 1</span>
							<span class="prescriptions afbf">AF</span>
						</div>-->
	
					</div>
					 <!-- prescription items close--> 
					
					 <!-- complaints--> 
					<div class="complaintsMain">
						<div style="display:flex; justify-content:space-between;">
							<h2 class="presTitle" >Complaints</h2>
							<h2 class="presTitle">Diet</h2>
							<h2 class="presTitle">Foods to avoid</h2>
						</div>
						
						
						<div style="display:flex; justify-content:space-between;gap:10px">
						<div class="complaintsBox compl">
							<!--<span>Hypothyroidism TSH>2.8</span>-->
						
						</div>
						
						<div class="complaintsBox food_follow">
							<!--<span>Grain-free diet</span>-->
						
						</div>
							
						<div class="complaintsBox food_avoid">
							<!--<span>Wheat</span>
							<span>Milk</span>-->
						</div>
						
						</div>
						
						
						<div class="remarksBox">
							<p class="presTitle" >Remarks</p>
							<span class="remarks">
								
							</span>
													</div>

					
					</div>
					<!-- complaints close--> 
					
				</div>
				
				      <!-- consultations popup close-->    
				
				
				
				<!-- reports popup-->
				<div class="reportsPopup">
					<div style="display:flex;justify-content:Space-between;">
						<h3 class="reportHeading">Reports</h3>
						<button class="buttonClose repClose">Close</button>
					</div>
					<!-- child divs-->
					
					<div class="elseDesign labnodata">
					<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
						<img style="width:250px;"src="assets/images/no-res.png" alt="No Data"/>
						<p>No Data Found</p>
					</div>
				</div>
					
						<div id="reportsection">
						
						<!--<div class="reportsCardHead">
							<h3>14-01-2023</h3>
							<h3>Dr.Parvathy</h3>
						</div>
						<hr>
						<!--Report details -->
						<!--<div class="reportCardBody">
							<div class="reportDetails">
								<h4>Report Name </h4>
								<a href="https://www.google.co.in" target="blank"><i class="fa-solid fa-eye"></i></a>
							</div>
							<div class="reportDetails">
								<h4>Report Name </h4>
								<a href="https://www.google.co.in" target="blank"><i class="fa-solid fa-eye"></i></a>
							</div>
							<div class="reportDetails">
								<h4>Report Name </h4>
								<a href="https://www.google.co.in" target="blank"><i class="fa-solid fa-eye"></i></a>
							</div>
						</div>
							Report details close
						
					</div>-->
					<!-- child divs close-->
					</div>
				</div>
				<!-- reports popup close-->
				
				
				<!-- else design-->
				<div class="elseDesign elsenodata">
					<div style="display:flex;flex-direction:column;align-items:center;justify-content:center;">
						<img style="width:250px;"src="assets/images/no-res.png" alt="No Data"/>
						<p>No Data Found</p>
					</div>
				</div>
				<!-- else design close-->
				
				
           

            </div>
            <!-- canvas close -->

        </section>
        <!-- dashboard close -->

    </main>


    <!-- script  -->
    <?php
    include "assets/includes/script/script.php";
    ?>
	
	<script>
	
	let thePopupClose = document.querySelector('.buttonClose');
	let thePopup = document.querySelector('.consultationPopup'); 
	let theShimmer = document.querySelector('.shimmer'); 
	let moreBtn = document.querySelector('.moreDetailsButton');  
		
	//popup close//	
		thePopupClose.addEventListener('click',()=>{
			thePopup.style.display = 'none';
			theShimmer.style.display = 'none';
		});
	//popup close//
		
	//popup open//
		/*moreBtn.addEventListener('click',()=>{
			theShimmer.style.display = 'flex';
			thePopup.style.display = 'block';
		});*/
		
	//popup open//
		
		
		//report popup start//
		let reportCrd = document.querySelector('.reportCrd');
		let repClose = document.querySelector('.repClose');
		let repPopUp = document.querySelector('.reportsPopup'); 
		
		/*reportCrd.addEventListener('click',function(){
			repPopUp.style.display = 'block';
			theShimmer.style.display = "flex";
		})*/
		
		repClose.addEventListener('click',function(){
			repPopUp.style.display = 'none';
			theShimmer.style.display = "none";
		})
		
		//report popup end//
		
		
		
	</script>
    <!-- script close -->
    <script src="assets/appointment/patient_profile.js?v=<?php echo $version_variable;?>"></script>
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