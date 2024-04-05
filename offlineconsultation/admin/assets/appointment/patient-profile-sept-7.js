//fetching all datas
let urlval_all = location.href.split('=')[1];
let urlval_split = urlval_all.split('/')
let urlval = urlval_split[0];
let branch_id = urlval_split[1];
$.ajax({
		url:"action/appointment/fetch_patientprofile.php",
		type:"POST",
		data:{patient_id:urlval,
			  branch_id:branch_id,
			 },
		success:function(result_data){
			console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			
			let data_status = result_data_json[0]['data_status'];
			
			$('#patient_name').append(`${result_data_json[0]['patient_name']}`)
			$('#patient_age').append(`Age: ${result_data_json[0]['patient_age']}`)
			$('#patient_place').append(`Place: ${result_data_json[0]['patient_place']}`)
			$('#patient_phn').append(`Phone: ${result_data_json[0]['patient_phn']}`)
			$('.visits').append(`${result_data_json[0]['total_number_visit']} Visits`)
			$('.bmistatus').append(`${result_data_json[0]['weight_cat']}`)
			
			if(data_status == 0){
				 $('.elsenodata').css({
      display: 'flex'
    })
			//$('.history').append(`<h1>No data</h1>`);
			}else{
			 $('.elsenodata').css({
      display: 'none'
    })
			for (let x = 0; x < result_data_json.length; x++) {
				let appointment_status_data = '';
				    if(result_data_json[x]['status'] == 0){
							appointment_status_data = '<h3 style="color:red">Cancelled</h3>';
					}
				let template = `
<div class="consultationsCardMain">
					<div class="consultationCardHead">
						<h3>${result_data_json[x]['appointment_date']}</h3>
						${appointment_status_data}
						<h3>${result_data_json[x]['doctor_name']}</h3>
					</div>
					<hr>
					<div class="consultationsCardDetails">	
						<div class="cardLeft">
							<h4><b>BMI</b>: ${result_data_json[x]['BMI']}</h4>

							<h4><b>Blood Pressure</b>: ${result_data_json[x]['blood_pressure']}</h4>
							<h4><b>Weight</b>: ${result_data_json[x]['weight']} KG</h4>
							<h4><b>Allergies</b>: ${result_data_json[x]['allergies_if_any']}</h4>
							<h4><b>Surgery</b>: ${result_data_json[x]['any_surgeries']}</h4>
							<h4><b>Illness</b>: ${result_data_json[x]['present_Illness']}</h4></div>
						</div>
						<div class="cardRight">
						<button class="prescriptionBtn" data-id=${result_data_json[x]['id']} branch_id=${branch_id}>View Prescription</button>
						<button class="moreDetailsButton" p-id=${result_data_json[x]['id']} branch_id=${branch_id}>More details</button>	
					</div>
</div>
			
`
	$('.reportCrd').attr('patient_id',result_data_json[x]['patient_id'])
	$('.reportCrd').attr('branch_id',branch_id)
	   $('.history').append(template);
			}
			
			}
			
			}
})


let api_key_val = 'prescription_details';

	$('body').delegate('.reportCrd','click',function(e){
	e.preventDefault()
	let patient_id = $(this).attr('patient_id')
	let r_branch_id = $(this).attr('branch_id')
	//alert(appointment_id)
$('.reportsPopup').css('display','block')
		$('.shimmer').css('display','block')
	$.when(fetch_labreports(patient_id,r_branch_id)).then(function(){
		
	})
	})
														
														
														
$('body').delegate('.prescriptionBtn','click',function(e){
	e.preventDefault()
	let appointment_id = $(this).attr('data-id')
	let branch_id = $(this).attr('branch_id')
	//alert(appointment_id)
	$.when(fetch_priscription(appointment_id,branch_id)).then(function(){
		print()
	})
	})
$('body').delegate('.moreDetailsButton','click',function(e){
	e.preventDefault()
	$(this).text('please wait..');
	let appointment_id = $(this).attr('p-id')
	let branch_id =  $(this).attr('branch_id')
	//alert(appointment_id)

$.when(fetch_moredetails(appointment_id,branch_id)).then(function(){
					
	})
})
	
function fetch_moredetails(appointment_id,branch_id){
return $.ajax({
		url:"../action/patient_priscription.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			 api_key_val:api_key_val,
			  branch:branch_id
			 },
		success:function(prescription_result){
			let prescription_result_jsaon = jQuery.parseJSON(prescription_result)
		
			console.log(prescription_result_jsaon)
			$('.pdetails').empty();
			$('.remarks').empty();
			console.log(prescription_result_jsaon[0]['dite_remark'])
			if(prescription_result_jsaon[0]['data-exist'] == 1){
				/*$('#name_data').text(prescription_result_jsaon[0]['name'])
				$('#gender_data').text(prescription_result_jsaon[0]['gender'])
				$('#unique_id').text(prescription_result_jsaon[0]['unique_id'])
				$('#total_visit').text(prescription_result_jsaon[0]['total_visit_count'])
				$('#first_visit').text(prescription_result_jsaon[0]['first_visit'])
				$('#last_visit').text(prescription_result_jsaon[0]['Last_visit'])
				$('#height_data').text(prescription_result_jsaon[0]['height'])
				$('#weight_data').text(prescription_result_jsaon[0]['weight'])
				$('#bmi_data').text(prescription_result_jsaon[0]['BMI'])
				$('#weight_cat').text(prescription_result_jsaon[0]['weight_cat'])*/
				$('.remarks').append(`${prescription_result_jsaon[0]['dite_remark']}`)
				
			for(let x=0;x<prescription_result_jsaon[0]['prescription'].length;x++){
					let food_time = '';
					if(prescription_result_jsaon[0]['prescription'][x]['after_food'] == 1){
						food_time = 'AF';
					}else if(prescription_result_jsaon[0]['prescription'][x]['befor_food'] == 1){
						food_time = 'BF';
					}
				let time_result =  prescription_result_jsaon[0]['prescription'][x]['morning_section']+'-'+prescription_result_jsaon[0]['prescription'][x]['noon_section']+'-'+prescription_result_jsaon[0]['prescription'][x]['evening_section'];
				
			$('.pdetails').append(`

<div class="prescriptionBox">
							<span class="prescriptions"><b>${prescription_result_jsaon[0]['prescription'][x]['medicine_name']}</b></span>
							<span class="prescriptions time">${time_result}</span>
							<span class="prescriptions afbf">${food_time}</span>
						</div>`)
					
					
				}
				
				
				
				
				
				let complaint_data = prescription_result_jsaon[0]['comment_data']
				if(complaint_data != undefined){
				$('.compl').empty()
					
				for(let xy = 0; xy<complaint_data.length;xy++){
					console.log(complaint_data)
				$('.compl').append(`<span>${complaint_data[xy]['comment']}</span>`)
				}
				}
				
				/*let medical_data = prescription_result_jsaon[0]['medical_data']
					if(medical_data != undefined){
						$('.medical_history_print').empty()
						$('.medical_history_print').append(`<h2>Medical History</h2>`)
					for( let xy2=0 ; xy2<medical_data.length; xy2++){
					$('.medical_history_print').append(`<p>${medical_data[xy2]['comment']}</p>`)
					}
				}
				
				let surgical_data = prescription_result_jsaon[0]['surgical_data']
					if(surgical_data != undefined){
						$('.Investigations_data').empty()
						$('.Investigations_data').append(`<h2>Investigations</h2>`)
					for( let xy1 = 0; xy1<surgical_data.length; xy1++){
						$('.Investigations_data').append(`<p>${surgical_data[xy1]['comment']}</p>`)
					}
				}*/
				
				let food_to_follow = prescription_result_jsaon[0]['diet_follow']
					
					if(food_to_follow != undefined){
					$('.food_follow').empty()
						for( let xyf1 = 0; xyf1<food_to_follow.length; xyf1++){
						$('.food_follow').append(`<span>${food_to_follow[xyf1]['diet']}</span>`)
					}
						/*if(prescription_result_jsaon[0]['diet_no_of_days'] != 0){
						$('.food_to_follow').append(`<li><b>No. of Days : ${food_to_follow[0]['diet_no_of_days']} Days</b></li>`)
						}*/
					}
				
				let food_to_avoid = prescription_result_jsaon[0]['food_plan']
					//console.log(food_to_avoid)
					if(food_to_avoid != undefined){
						$('.food_avoid').empty()
								//console.log(food_to_follow.length)
						for( let xyf2 = 0; xyf2<food_to_avoid.length; xyf2++){
							//console.log(food_to_avoid[xyf2]['foods_avoid'])
						$('.food_avoid').append(`<span>${food_to_avoid[xyf2]['foods_avoid']}</span>`)
					}
					
					}
				
				
				
				
				
				
			}else{
				
			}
			
		}
		
	})
.then(function() {
	setTimeout(function () {
$('.consultationPopup').css('display','block')
		$('.shimmer').css('display','block')
		$('.moreDetailsButton').text('more details')
		}, 1500)
	
 // console.log('Then function executed successfully');
})
}

function fetch_priscription(appointment_id,branch){
	return $.ajax({
		url:"../action/patient_priscription.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			 api_key_val:api_key_val,
			  branch:branch
			 },
		success:function(prescription_result){
			let prescription_result_jsaon = jQuery.parseJSON(prescription_result)
			console.log(prescription_result_jsaon)
			//console.log(prescription_result_jsaon)
			$('.prescription_data_print').empty();
			console.log(prescription_result_jsaon)
			if(prescription_result_jsaon[0]['data-exist'] == 1){
				$('#name_data').text(prescription_result_jsaon[0]['name'])
				$('#gender_data').text(prescription_result_jsaon[0]['gender'])
				$('#unique_id').text(prescription_result_jsaon[0]['unique_id'])
				$('#total_visit').text(prescription_result_jsaon[0]['total_visit_count'])
				$('#first_visit').text(prescription_result_jsaon[0]['first_visit'])
				$('#last_visit').text(prescription_result_jsaon[0]['Last_visit'])
				$('#height_data').text(prescription_result_jsaon[0]['height'])
				$('#weight_data').text(prescription_result_jsaon[0]['weight'])
				$('#bmi_data').text(prescription_result_jsaon[0]['BMI'])
				$('#weight_cat').text(prescription_result_jsaon[0]['weight_cat'])
				$('#all_remark').text(prescription_result_jsaon[0]['main_remark'])
			for(let x=0;x<prescription_result_jsaon[0]['prescription'].length;x++){
					let food_time = '';
					if(prescription_result_jsaon[0]['prescription'][x]['after_food'] == 1){
						food_time = 'After Food';
					}else if(prescription_result_jsaon[0]['prescription'][x]['befor_food'] == 1){
						food_time = 'Before Food';
					}
					let time_result =  prescription_result_jsaon[0]['prescription'][x]['morning_section']+'-'+prescription_result_jsaon[0]['prescription'][x]['noon_section']+'-'+prescription_result_jsaon[0]['prescription'][x]['evening_section'];
					$('.prescription_data_print').append(`<p><b>${prescription_result_jsaon[0]['prescription'][x]['medicine_name']}</b> ${time_result} ${prescription_result_jsaon[0]['prescription'][x]['no_of_day']} days ${food_time}</p>`)
				}
				
				let complaint_data = prescription_result_jsaon[0]['comment_data']
				if(complaint_data != undefined){
				$('.complaints_data_print').empty()
					$('.complaints_data_print').append(`<h2>Complaints</h2>`)
				for(let xy = 0; xy<complaint_data.length;xy++){
				$('.complaints_data_print').append(`<p>${complaint_data[xy]['comment']}</p>`)
				}
				}
				
				let medical_data = prescription_result_jsaon[0]['medical_data']
					if(medical_data != undefined){
						$('.medical_history_print').empty()
						$('.medical_history_print').append(`<h2>Medical History</h2>`)
					for( let xy2=0 ; xy2<medical_data.length; xy2++){
					$('.medical_history_print').append(`<p>${medical_data[xy2]['comment']}</p>`)
					}
				}
				
				let surgical_data = prescription_result_jsaon[0]['surgical_data']
					if(surgical_data != undefined){
						$('.Investigations_data').empty()
						$('.Investigations_data').append(`<h2>Investigations</h2>`)
					for( let xy1 = 0; xy1<surgical_data.length; xy1++){
						$('.Investigations_data').append(`<p>${surgical_data[xy1]['comment']}</p>`)
					}
				}
				
				let food_to_follow = prescription_result_jsaon[0]['diet_follow']
					
					if(food_to_follow != undefined){
						$('.food_to_follow').empty()
						for( let xyf1 = 0; xyf1<food_to_follow.length; xyf1++){
						$('.food_to_follow').append(`<p>${food_to_follow[xyf1]['diet']}</p>`)
					}
						if(prescription_result_jsaon[0]['diet_no_of_days'] != 0){
						$('.food_to_follow').append(`<li><b>No. of Days : ${food_to_follow[0]['diet_no_of_days']} Days</b></li>`)
						}
					}
				
				let food_to_avoid = prescription_result_jsaon[0]['food_plan']
					//console.log(food_to_avoid)
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
								//console.log(food_to_follow.length)
						for( let xyf2 = 0; xyf2<food_to_avoid.length; xyf2++){
							//console.log(food_to_avoid[xyf2]['foods_avoid'])
						$('.food_to_avoid').append(`<p>${food_to_avoid[xyf2]['foods_avoid']}</p>`)
					}
					
					}
				
				$('.dynamic_doctor').empty()
				$('.dynamic_doctor').append(`<ul>
							<li><b>${prescription_result_jsaon[0]['doctor_name']}</b></li>
							<li>${prescription_result_jsaon[0]['qualification_data']}</li>
							<li>${prescription_result_jsaon[0]['reg_num']}</li>
							<li>${prescription_result_jsaon[0]['designation_data']}</li>
					</ul>`)
				
			}else{
				
			}
			
		}
		
	})
}

function fetch_labreports(patient_id,branch_id){
$.ajax({
		url:"../action/fetch_lab_reports.php",
		type:"POST",
		data:{patient_id:patient_id,
			  branch_id:branch_id,
 		},
	success:function(lab_result){
			$('#reportsection').empty()
		let lab_result_json = jQuery.parseJSON(lab_result)
		console.log(lab_result_json)
		if(lab_result_json.length==0){
			
		 $('.labnodata').css({
      display: 'flex'
    })
		}else{
			 $('.labnodata').css({
      display: 'none'
    })
		for(let x=0;x<lab_result_json.length;x++){
			let date_report = lab_result_json[x]['lab']
			let template_data = `<div class="reportCard">

<div class="reportsCardHead">
							<h3>${lab_result_json[x]['added_date']}</h3>
							
						</div>
<div class="reportCardBody">
`
									for(let y=0;y<date_report.length;y++){
										if(date_report[y]['lab_report_file'] != ''){
										template_data += `

<div class="reportDetails">
								<h4>${date_report[y]['test_name']} </h4>
<a href="../lab/assets/fileupload/${date_report[y]['lab_report_file']}" target="blank"><i class="fa-solid fa-eye"></i></a>
								
							</div>
`
										}else{
										template_data += `<div class="reportDetails">
								<h4>${date_report[y]['test_name']} </h4>
 </div>`
										}
									}
									
									template_data += `</div>
</div>
						`;
							$('#reportsection').append(template_data)
		}
	}
		
	}
})
}
