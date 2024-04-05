let fun_exe = 0;
var next_btn_class = 'disableNextBtn';
let search_data = '';
let diet_plan = [];
let food_avoided_plan = [];
let url_data = window.location.href
let url_split = url_data.split('=')
let url_val = url_split[1]
var branch_data = '';
var patient_id = '';
fetch_all_todays_appointments();
//setInterval(fetch_all_todays_appointments, 1000);
function fetch_all_todays_appointments(){
	$('.allprev_appointments').empty();
	$('.allprev_appointments_waiting').empty()
	$.ajax({
		url:"action/appointment/fetch_previous_appointments_data.php",
		type:"POST",
		data:{url_val:url_val},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			let si_no_pending = 0;
			let si_no_waiting = 0;
			if(result_data_json[0]['status'] !=0){
			$('.WaitingCount').text(result_data_json[0]['waiting_count'])
			if(result_data_json[0]['waiting_count'] == 0){
				$('.all_waiting_appointments_else').css('display','flex')
			}else{
				$('.all_waiting_appointments_else').css('display','none')
			}
			if(result_data_json[0]['pending_count'] == 0){
				next_btn_class = 'enableNextBtn';
				$('.all_pending_appointments_else').css('display','flex')
			}else{
				$('.all_pending_appointments_else').css('display','none')
			}
			if(result_data_json[0]['data_status'] == 1){
				$('.all_pending_appointments').css('display','none')
				
			for(let x=0;x<result_data_json.length;x++){
					si_no_pending++;
					if(result_data_json.length ==1){
						$('.all_pending_appointments').css('display','flex')
					}
							
						$('.currentConsulting_patient').css('display','flex')
						$('.consultingWindowTable').css('display','flex')
						$('.commentsPopup').css('display','block')
						$('#current_patient_name').text(result_data_json[x]['name'])
						$('#current_patient_uniqueid').text(result_data_json[x]['unique_id'])
						$('#current_patient_phn').text(": "+result_data_json[x]['phone'])
						$('#current_patient_email').text(": "+result_data_json[x]['email'])
						$('#current_patient_age').text(": "+result_data_json[x]['age'])
						$('#age_details').text('Age : '+result_data_json[x]['age']+', '+result_data_json[x]['gender']+','+result_data_json[x]['phone'])
						$('#current_patient_gender').text(": "+result_data_json[x]['gender'])
						$('#current_patient_address').text(": "+result_data_json[x]['address'])
						$('#current_patient_place').text(": "+result_data_json[x]['place'])
						$('#present_Illness').text(": "+result_data_json[x]['present_Illness'])
						$('.currentConsultingKeepWaitBtn').attr('data-id',result_data_json[x]['id'])
						$('.consultedBtn').attr('data-id',result_data_json[x]['id'])
				$('#remark_data').text(result_data_json[x]['main_remark'])
				if(result_data_json[0]['appointment_status'] == 2){
					$('.currentConsultingheadPrintBtn').attr('data-id',result_data_json[x]['id'])
					$('.currentConsultingheadPrintBtn').css('display','flex')
				}
						//fetch_all_prescription_data(result_data_json[x]['unique_id'])
						//fetch_allcomments(result_data_json[x]['unique_id'])
						//fetch_allmedical(result_data_json[x]['unique_id'])
						//fetch_allsurgical(result_data_json[x]['unique_id'])
						//fetch_all_food_plan(result_data_json[x]['id'])
				        //fetch_all_diet_plan(result_data_json[x]['id'])
						//fetch_all_lab_reports(result_data_json[x]['patient_id'])
						patient_id = result_data_json[x]['patient_id'];
						fetch_all_previous_treatment(result_data_json[x]['patient_id'],result_data_json[x]['branch'])
						fetch_all_invoice_report(result_data_json[x]['patient_id'],result_data_json[x]['branch'])
						branch_data = result_data_json[x]['branch'];
						let bmi_si_no = 0;
						$('.consultingWindowTable table tbody').empty()
						if(result_data_json[x]['BMI'] != undefined){
							let bmi_weight_cat = '';
							let bmi_val_class = '';
						for(let bmi_val = 0;bmi_val<result_data_json[x]['BMI'].length;bmi_val++){
							
							if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] < 18.5){
								bmi_weight_cat = 'UnderWeight';
								bmi_val_class = '';
							}else if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] >=18.5 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 24.9){
								bmi_weight_cat = 'Healthy Weight';
								bmi_val_class = 'bmiColor1_G';
							}else if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] >= 25 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <=29.9){
								bmi_weight_cat = 'OverWeight';
								bmi_val_class = 'bmiColor2_Y';
							}else if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] >=30 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 34.9){
								bmi_weight_cat = 'Obese (Class1)';
								bmi_val_class = 'bmiColor3_O';
							}else if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] >= 35 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 39.9){
								bmi_weight_cat = 'Severely Obese (Class11)';
								bmi_val_class = 'bmiColor4_P';
							}else if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] >= 40 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 49.9){
								bmi_weight_cat = 'Morbidly Obese (Class111)';
								bmi_val_class = 'bmiColor5_R';
							}else if(result_data_json[x]['BMI'][bmi_val]['BMIVal'] >=50){
								bmi_weight_cat = 'Super Obese (Class111)';
								bmi_val_class = 'bmiColor6_RRR';
							}
							
							bmi_si_no++;
							$('.consultingWindowTable table tbody').append(`<tr>
										<td data-label="1st Visit">
											<p>${bmi_si_no}</p>
										</td>
										<td data-label="Date">
											<p>${result_data_json[x]['BMI'][bmi_val]['appointment_date_new']}</p>
										</td>
										<td data-label="Height">
											<p>${result_data_json[x]['BMI'][bmi_val]['height']} CM</p>
										</td>
										<td data-label="Weight">
											<p>${result_data_json[x]['BMI'][bmi_val]['weight']} KG</p>
										</td>
										<td data-label="BMI" class="${bmi_val_class}">
											<p>${result_data_json[x]['BMI'][bmi_val]['BMIVal']}</p>
										</td>
										<td data-label="Weight">
											<p>${result_data_json[x]['BMI'][bmi_val]['blood_pressure']}</p>
										</td>
										<td data-label="Category">
											<p>${bmi_weight_cat}</p>
										</td>
									</tr>`)
						}
						}else{
							$('.consultingWindowTable table tbody').append(`No Data`);
						}
					
					}
					
					
				
			}
			}else{
				$('.all_pending_appointments').css('display','flex')
				$('.all_waiting_appointments').css('display','flex')
				$('.currentConsulting_patient').css('display','none')
				$('.consultingWindowTable').css('display','none')
				$('.commentsPopup').css('display','none')
				
			}
		}
		
	})
}

		$('#search_btn_data').click(function(e){
			e.preventDefault()
			search_data = $('#search_details').val()
			fetch_all_todays_appointments()
		})
        // keep wait
        $('.currentConsultingKeepWaitBtn').click(function(){
			
			let data_id=$(this).attr('data-id')
			$(this).parent().parent().parent().fadeOut();
			$('.consultingWindowTable').css('display','none')
			$('.commentsPopup').css('display','none')
			//$('.nextBtn').removeClass('disableNextBtn');
            //$('.nextBtn').addClass('enableNextBtn');
			$.ajax({
				url:"action/appointment/move_to_waiting_list.php",
				type:"POST",
				data:{data_id:data_id},
				success:function(update_result){
					let update_result_json = jQuery.parseJSON(update_result);
					if(update_result_json[0]['status'] !=0){
						fun_exe = 1;
						next_btn_class = 'enableNextBtn';
						fetch_all_todays_appointments()
					}else{
						$('.toasterMessage').text(update_result_json[0]['msg'])
						$('.errorTost').css('display','none')
						$('.successTost').css('display','flex')
						$('.toaster').addClass('toasterActive');
						setTimeout(function () {
							$('.toaster').removeClass('toasterActive');
						}, 2000)
						if(today_result_json[0]['status'] == 0){
						setTimeout(function () {
							window.location.href="../login.php";
						}, 2500)
						}
					}
				}
			})
        });

		function fetch_all_die_details(){
			let diet_paln_len = $('.dite_details').length
			let diet_details = 1;
			$('.dite_details').each(function(){
				if($(this).prop('checked') == true){
					diet_plan.push($(this).val())
				}
				diet_details++
				//if(diet_paln_len == diet_details){
					//console.log(diet_plan)
				//}
			})
			
		}

		function fetch_all_foods_to_be_avoided_details(){
			let food_avoided_len = $('.food_avoided').length
			let food_diet_details = 1;
			$('.food_avoided').each(function(){
				if($(this).prop('checked') == true){
					food_avoided_plan.push($(this).val())
				}
				food_diet_details++
				//if(diet_paln_len == diet_details){
					//console.log(diet_plan)
				//}
			})
		}

		$('body').delegate('.keepWaitBtn','click',function(){
			let that = $(this);
			that.text('Loading...')
			let patient_appointment_id = $(this).attr('data-id')
			$.ajax({
				url:"action/appointment/move_to_waiting_list.php",
				type:"POST",
				data:{data_id:patient_appointment_id},
				success:function(update_result){
					let update_result_json = jQuery.parseJSON(update_result);
					if(update_result_json[0]['status'] !=0){
						fetch_all_todays_appointments()
					}else{
						that.text('Keep Wait')
						$('.toasterMessage').text(update_result_json[0]['msg'])
						$('.errorTost').css('display','none')
						$('.successTost').css('display','flex')
						$('.toaster').addClass('toasterActive');
						setTimeout(function () {
							$('.toaster').removeClass('toasterActive');
						}, 2000)
						if(today_result_json[0]['status'] == 0){
						setTimeout(function () {
							window.location.href="../login.php";
						}, 2500)
						}
					}
				}
			})
		})

// next appointment 
        $("body").delegate(".enableNextBtn", "click", function() {
			$(this).parent().parent().parent().fadeOut();
			let appointment_id = $(this).attr('data-id')
			$.ajax({
				url:"action/appointment/fetch_appointment_data.php",
				type:"POST",
				data:{appointment_id:appointment_id},
				success:function(appointment_result){
					let appointment_result_json = jQuery.parseJSON(appointment_result)
					let x = 0;
					//$('.currentConsulting_patient').css('display','flex')
						$('.consultingWindowTable').css('display','flex')
						$('.commentsPopup').css('display','block')
						$('.currentConsulting').css('display','flex')
						$('#current_patient_name').text(appointment_result_json[x]['name'])
						$('#current_patient_uniqueid').text(appointment_result_json[x]['unique_id'])
						$('#current_patient_phn').text(": "+appointment_result_json[x]['phone'])
						$('#current_patient_email').text(": "+appointment_result_json[x]['email'])
						$('#current_patient_age').text(": "+appointment_result_json[x]['age'])
						$('#current_patient_gender').text(": "+appointment_result_json[x]['gender'])
						$('#current_patient_address').text(": "+appointment_result_json[x]['address'])
					$('#age_details').text('Age : '+appointment_result_json[x]['age']+', '+appointment_result_json[x]['gender']+','+appointment_result_json[x]['phone'])
						$('#current_patient_place').text(": "+appointment_result_json[x]['place'])
						$('.currentConsultingKeepWaitBtn').attr('data-id',appointment_result_json[x]['id'])
						$('.consultedBtn').attr('data-id',appointment_result_json[x]['id'])
						fetch_all_prescription_data(appointment_result_json[x]['unique_id'])
						fetch_allcomments(appointment_result_json[x]['unique_id'])
						fetch_allmedical(appointment_result_json[x]['unique_id'])
						fetch_allsurgical(appointment_result_json[x]['unique_id'])
						fetch_all_food_plan(appointment_result_json[x]['id'])
				        fetch_all_diet_plan(appointment_result_json[x]['id'])
					$('.consultingWindowTable table tbody').empty()
					if(appointment_result_json[x]['BMI'] != undefined){
					let bmi_si_no = 0;
					let bmi_weight_cat = '';
					let bmi_val_class = '';
						for(let bmi_val = 0;bmi_val<appointment_result_json[x]['BMI'].length;bmi_val++){
							
							if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] < 18.5){
								bmi_weight_cat = 'UnderWeight';
								bmi_val_class = '';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=18.5 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 24.9){
								bmi_weight_cat = 'Healthy Weight';
								bmi_val_class = 'bmiColor1_G';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 25 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <=29.9){
								bmi_weight_cat = 'OverWeight';
								bmi_val_class = 'bmiColor2_Y';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=30 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 34.9){
								bmi_weight_cat = 'Obese (Class1)';
								bmi_val_class = 'bmiColor3_O';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 35 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 39.9){
								bmi_weight_cat = 'Severely Obese (Class11)';
								bmi_val_class = 'bmiColor4_P';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 40 && result_data_json[x]['BMI'][bmi_val]['BMIVal'] <= 49.9){
								bmi_weight_cat = 'Morbidly Obese (Class111)';
								bmi_val_class = 'bmiColor5_R';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=50){
								bmi_weight_cat = 'Super Obese (Class111)';
								bmi_val_class = 'bmiColor6_RRR';
							}
							bmi_si_no++;
							$('.consultingWindowTable table tbody').append(`<tr>
										<td data-label="1st Visit">
											<p>${bmi_si_no}</p>
										</td>
										<td data-label="Date">
											<p>${appointment_result_json[x]['BMI'][bmi_val]['appointment_date_new']}</p>
										</td>
										<td data-label="Height">
											<p>${appointment_result_json[x]['BMI'][bmi_val]['height']} CM</p>
										</td>
										<td data-label="Weight">
											<p>${appointment_result_json[x]['BMI'][bmi_val]['weight']} KG</p>
										</td>
										<td data-label="BMI" class="${bmi_val_class}">
											<p>${appointment_result_json[x]['BMI'][bmi_val]['BMIVal']}</p>
										</td>
										<td data-label="Category">
											<p>${bmi_weight_cat}</p>
										</td>
									</tr>`)
						}
					}else{
						$('.consultingWindowTable table tbody').append(`No Data`);
					}
            			$('.currentConsulting').fadeIn();
						$('.nextBtn').addClass('disableNextBtn');
            			$('.nextBtn').removeClass('enableNextBtn');
				}
			})
            
        });

//consulted button click
$('body').delegate('.consultedBtn','click',function(e){
	let patient_id = $(this).attr('data-id')
	e.preventDefault();
    $('#text').fadeOut();
    setTimeout(function(){
        $('#loading').fadeIn();
    },500);
    setTimeout(function(){
        $('#loading').fadeOut();
    },1500);
			setTimeout(function(){
                $('#done').fadeIn();
            },2000);
            setTimeout(function(){
                $('.currentConsulting').fadeOut();
				$('.consultingWindowTable').css('display','none')
				$('.commentsPopup').css('display','none')
            $('.nextBtn').removeClass('disableNextBtn');
            $('.nextBtn').addClass('enableNextBtn');
            },2500);
            setTimeout(function(){
                $('#done').fadeOut();
                $('#text').fadeIn();
				window.location.href="old-offline-appointments.php"
            },3000);
})
let api = "de317f60c5d5182d99a2cf0fdc8f6175";
fetch_all_medicine()
function fetch_all_medicine(){
fetch("../../api/fetchAll_medicine.php?api="+api)
.then(response => response.json())
.then(data => {
	$('.medicine_details').empty()
	$('.medicine_details').append(`<option value=""></option>`)
		data.map((x) =>{
			const {product_name,product_id} = x
			$('.medicine_details').append(`<option value="${product_id}">${product_name}</option>`)
		})
	})
.then(() => {
	
})
}

$('#prescription_data_form').submit(function(e){
	e.preventDefault()
	if($('.main_prescription_div').find('.medicine_details').val().trim() != '' && $('.main_prescription_div').find('.no_days').val().trim() != '' && $('.main_prescription_div').find('.current').text().trim() != ''){
	$('#medicine_error').text(' ')
	$('#quantity_error').text(' ')
	$('#noof_error').text(' ')
	$('#prescription_data').text('Loading...')
	$('#prescription_data').attr('disabled',true)
	let appointment_id = $('.consultedBtn').attr('data-id');
	$.when(add_prescription_data(appointment_id)).then(function(patient_id){
		let patient_id_json = jQuery.parseJSON(patient_id);
		let patient_id_data = patient_id_json[0]['select_patient_id'];
	let prescription_len = $('.prescription_data').length
	let prescription_data = 0;
	$('.prescription_data').each(function(){
		let medicine_details = $(this).find('.medicine_details').val()
		let medicine_name = $(this).find('.current').text()
		let quantity_data = $(this).find('.quantity_data').val()
		let morning_data = 0;
		let noon_data = 0;
		let evening_data = 0;
		if($(this).find('.morning_data').val() != ''){
			morning_data = $(this).find('.morning_data').val();
		}
		if($(this).find('.noon_data').val() != ''){
			noon_data = $(this).find('.noon_data').val();
		}
		if($(this).find('.evening_data').val() != ''){
			evening_data = $(this).find('.evening_data').val();
		}
		let no_days = $(this).find('.no_days').val()
		let after_food = 0;
		let befor_food = 0;
		if($(this).find('#afterFood').prop('checked') == true){
			after_food = 1
		}
		if($(this).find('#beforeFood').prop('checked') == true){
			befor_food = 1
		}
		$.ajax({
			url:"action/prescription/add_precription.php",
			type:"POST",
			data:{appointment_id:appointment_id,
				 medicine_details:medicine_details,
				  medicine_name:medicine_name,
				  quantity_data:quantity_data,
				  morning_data:morning_data,
				  noon_data:noon_data,
				  evening_data:evening_data,
				  no_days:no_days,
				  patient_id_data:patient_id_data,
				  after_food:after_food,
				  befor_food:befor_food
				 },
			success:function(result_data){
				prescription_data++
			if(prescription_data == prescription_len){
			$('#prescription_data').css('background-color','blue')
			$('#prescription_data').text('Success')
			setTimeout(function(){
				$('.tempPanelDiv').empty()
				$('.main_prescription_div').find('.quantity_data').val(' ')
				$('.main_prescription_div').find('.morning_data').attr('checked',false)
				$('.main_prescription_div').find('.noon_data').attr('checked',false)
				$('.main_prescription_div').find('.evening_data').attr('checked',false)
				$('.main_prescription_div').find('.no_days').val('')
				$('.main_prescription_div').find('.remark_data').val('')
				$('.main_prescription_div').find('.current').text('')
				$('#prescription_data').text('Save')
				$('#prescription_data').css('background-color','#557bfe')
				$('#prescription_data').attr('disabled',false)
				let current_patient_uniqueid = $('#current_patient_uniqueid').text()
				fetch_all_prescription_data(current_patient_uniqueid)
			},1500)
			
		}
			}
		})

			
	})
		
	})
}else{
	$('#medicine_error').text('*Required!')
	$('#quantity_error').text('*Required!')
	$('#noof_error').text('*Required!')
}
})

function add_prescription_data(appointment_id){
	let remark_data = $('.remark_data').val()
	return $.ajax({
		url:"action/prescription/add_initial_prescription_data.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			 remark_data:remark_data
			 }
	})
}

function fetch_all_prescription_data(current_patient_uniqueid){
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid},
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		$('.prescriptionHistoryListMain_history').empty()
		if(all_prescription_json[0]['data_status'] == 1){
		for(let x1=0;x1<all_prescription_json.length;x1++){
			let section_data = '';
			if(all_prescription_json[x1]['morning_section'] == 1){
				if(section_data == ''){
					section_data = "Monday";
				}else{
					section_data += ",Monday";
				}
			}else if(all_prescription_json[x1]['noon_section'] == 1){
				if(section_data == ''){
					section_data = "Noon";
				}else{
					section_data += ",Noon";
				}
			}else if(all_prescription_json[x1]['evening_section'] == 1){
				if(section_data == ''){
					section_data = "Evening";
				}else{
					section_data += ",Evening";
				}
			}
			let food_section = '';
			if(all_prescription_json[x1]['after_food'] == 1){
				food_section = 'After Food';
			}else if(all_prescription_json[x1]['befor_food'] == 1){
				food_section = 'Befor Food';
			}
			$('.prescriptionHistory table tbody').append(`<tr>
										<td>${all_prescription_json[x1]['medicine_name']}</td>
										<td>${all_prescription_json[x1]['morning_section']}</td>
										<td>${all_prescription_json[x1]['noon_section']}</td>
										<td>${all_prescription_json[x1]['evening_section']}</td>
										<td>${all_prescription_json[x1]['no_of_day']}</td>
										<td>${all_prescription_json[x1]['time']}</td>
										<td>${all_prescription_json[x1]['date_time']}</td>
									</tr>`)
			$('.prescriptionHistoryListMain_history').append(`<div class="prescriptionHistoryListBox">
										<div class="prescriptionHistoryListBoxHead">
											<div class="prescriptionHistoryDate">${all_prescription_json[x1]['date_time']}</div>
											<div class="prescriptionHistoryBtnArea">


											</div>
										</div>
										<div class="prescriptionHistoryListBoxBody">
											<div class="prescriptionHistoryRow">
												<div class="prescriptionHistoryRowBox1">
													<p>${all_prescription_json[x1]['medicine_name']}</p>
												</div>
												<div class="prescriptionHistoryRowBox2">
													<div class="count">${all_prescription_json[x1]['morning_section']}</div>
													<div class="count">${all_prescription_json[x1]['noon_section']}</div>
													<div class="count">${all_prescription_json[x1]['evening_section']}</div>
												</div>
												<div class="prescriptionHistoryRowBox3">
													<p>${all_prescription_json[x1]['no_of_day']} Days</p>
												</div>
												<div class="prescriptionHistoryRowBox4">
													<p>${food_section}</p>
												</div>
											</div>
										</div>
									</div>`)
		}
		}else{
			$('.prescriptionHistory table tbody').append(`No Data`)
		}
	}
		})
}

function fetch_allcomments(patient_id){
	$.ajax({
		url:"action/prescription/fetch_all_comments.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data);
			$('.commentsPopupPreviousList_complaints dl').empty()
			if(result_data_json[0]['data_status'] !=0){
				
			for(let x=0;x<result_data_json.length;x++){
				let date = result_data_json[x]['added_date'];
				let date_details = result_data_json[x]['comment_data'];
				$('.commentsPopupPreviousList_complaints dl').append(`<dt class="PreviousListDate">
									<span>${date}</span>
								</dt>`)
				for(let x1=0;x1<date_details.length;x1++){
					$('.commentsPopupPreviousList_complaints dl').append(`<dd class="commentsPopupPreviousBox">
							${date_details[x1]['comment']}
								</dd>`)
				}
			}
			}else{
				$('.commentsPopupPreviousList_complaints dl').append(`No Data`)
			}
		}
	})
}

function fetch_allmedical(patient_id){
	$.ajax({
		url:"action/prescription/fetch_all_medical.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data);
			$('.commentsPopupPreviousList_medical dl').empty()
			if(result_data_json[0]['data_status'] !=0){
				
			for(let x=0;x<result_data_json.length;x++){
				let date = result_data_json[x]['added_date'];
				
				let date_details = result_data_json[x]['comment_data'];
				$('.commentsPopupPreviousList_medical dl').append(`<dt class="PreviousListDate">
									<span>${date}</span>
								</dt>`)
				for(let x1=0;x1<date_details.length;x1++){
					$('.commentsPopupPreviousList_medical dl').append(`<dd class="commentsPopupPreviousBox">
							${date_details[x1]['comment']}
								</dd>`)
				}
			}
			}else{
				$('.commentsPopupPreviousList_medical dl').append(`No Data`)
			}
		}
	})
}

function fetch_allsurgical(patient_id){
	$.ajax({
		url:"action/prescription/fetch_all_surgical.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data);
			$('.commentsPopupPreviousList_surgical dl').empty()
			if(result_data_json[0]['data_status'] !=0){
				
			for(let x=0;x<result_data_json.length;x++){
				let date = result_data_json[x]['added_date'];
				let date_details = result_data_json[x]['comment_data'];
				$('.commentsPopupPreviousList_surgical dl').append(`<dt class="PreviousListDate">
									<span>${date}</span>
								</dt>`)
				for(let x1=0;x1<date_details.length;x1++){
					$('.commentsPopupPreviousList_surgical dl').append(`<dd class="commentsPopupPreviousBox">
							${date_details[x1]['comment']}
								</dd>`)
				}
			}
			}else{
				$('.commentsPopupPreviousList_surgical dl').append(`No Data`)
			}
		}
	})
}

$('.commentsTextarea_btn').click(function(e){
	e.preventDefault()
	
	let commentsTextarea = $('.commentsTextarea_data .note-editable').html()
	console.log(commentsTextarea)
	let patient_id = $('#current_patient_uniqueid').text()
	if(commentsTextarea != '<p><br></p>'){
		$('.saveCommentsPopupBtn').text('Loading...')
	$('.saveCommentsPopupBtn').attr('disabled',true)
	$.ajax({
		url:"action/prescription/add_comments.php",
		type:"POST",
		data:{commentsTextarea:commentsTextarea,
			 patient_id:patient_id
			 },
		success:function(result_data){
			$('.saveCommentsPopupBtn').text('Success')
			$('.saveCommentsPopupBtn').css('background-color','blue')
			setTimeout(function(){
				$('.saveCommentsPopupBtn').attr('disabled',false)
				$('.saveCommentsPopupBtn').text('Save')
				$('.saveCommentsPopupBtn').css('background-color','#557bfe')
				$('.note-editable').html('')
				fetch_allcomments(patient_id)
			},1500)
			console.log(result_data)
		}
		
	})
	}
})

fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			console.log(profile_result_json)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}

$('.medicalTextarea_btn').click(function(){
	let medicalTextarea = $('.medicalTextarea_area .note-editable').html()
	let patient_id = $('#current_patient_uniqueid').text()
	if(commentsTextarea != '<p><br></p>'){
		$('.medicalTextarea_btn').text('Loading...')
	$('.medicalTextarea_btn').attr('disabled',true)
	$.ajax({
		url:"action/prescription/add_medical.php",
		type:"POST",
		data:{medicalTextarea:medicalTextarea,
			 patient_id:patient_id
			 },
		success:function(result_data){
			$('.medicalTextarea_btn').text('Success')
			$('.medicalTextarea_btn').css('background-color','blue')
			setTimeout(function(){
				$('.medicalTextarea_btn').attr('disabled',false)
				$('.medicalTextarea_btn').text('Save')
				$('.medicalTextarea_btn').css('background-color','#557bfe')
				$('.medicalTextarea_area .note-editable').html('')
				fetch_allmedical(patient_id)
			},1500)
			console.log(result_data)
		}
		
	})
	}
})
$('.surgicalTextarea_btn').click(function(e){
	e.preventDefault()
	let commentsTextarea = $('.surgicalTextarea_data .note-editable').html()
	console.log(commentsTextarea)
	let patient_id = $('#current_patient_uniqueid').text()
	if(commentsTextarea != '<p><br></p>'){
		$('.surgicalTextarea_btn').text('Loading...')
	$('.surgicalTextarea_btn').attr('disabled',true)
	$.ajax({
		url:"action/prescription/add_surgical.php",
		type:"POST",
		data:{commentsTextarea:commentsTextarea,
			 patient_id:patient_id
			 },
		success:function(result_data){
			$('.surgicalTextarea_btn').text('Success')
			$('.surgicalTextarea_btn').css('background-color','blue')
			setTimeout(function(){
				$('.surgicalTextarea_btn').attr('disabled',false)
				$('.surgicalTextarea_btn').text('Save')
				$('.surgicalTextarea_btn').css('background-color','#557bfe')
				$('.surgicalTextarea_data .note-editable').html('')
				fetch_allsurgical(patient_id)
			},1500)
			console.log(result_data)
		}
		
	})
	}
})

function fetch_all_food_plan(appointment_id){
	$.ajax({
		url:"action/prescription/fetch_all_food_plan.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			if(result_data_json[0]['data_status'] == 1){
				$('#food_tobe_avoid').empty();
				for(let x=0;x<result_data_json.length;x++){
					$('#food_tobe_avoid').append(`<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>${result_data_json[x]['foods_to_be_avoided']}</p>
								</li>`)
				}
			}else{
				$('#food_tobe_avoid').text('No Data')
			}
		}
	})
}

function fetch_all_diet_plan(appointment_id){
	$.ajax({
		url:"action/prescription/fetch_all_diet_plan.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			if(result_data_json[0]['data_status'] == 1){
				$('#diteBox_data').empty();
				for(let x=0;x<result_data_json.length;x++){
					$('#diteBox_data').append(`<li style="display: flex;">
									<span style="width: 10px; height: 10px; background: #5982ff; margin-right: 10px; display: flex; margin-top: 5px;"></span><p>${result_data_json[x]['diet']}</p>
								</li>`)
				}
			}else{
				$('#diteBox_data').text('No Data')
			}
		}
	})
}

$('body').delegate('.currentConsultingheadPrintBtn','click',function(e){
	e.preventDefault()
	//$('.pageLoader').css('display','flex')
	    $('.currentConsultingheadPrintBtn').empty()
		$('.currentConsultingheadPrintBtn').append(`<i class="uil uil-print"></i> Loading...`)
		let appointment_id = $(this).attr('data-id')
	$.ajax({
		url:"action/appointment/fetch_appointment_details_print.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			if(result_data_json[0]['status'] == 1){
				$('#name_data').text('Name : '+result_data_json[0]['name'])
				$('#gender_data').text(result_data_json[0]['gender'])
				$('#age_data').text(result_data_json[0]['age']+' Years')
				$('#unique_id').text(result_data_json[0]['unique_id'])
				$('#total_visit').text(result_data_json[0]['total_visit_count'])
				$('#first_visit').text(result_data_json[0]['first_visit'])
				$('#last_visit').text(result_data_json[0]['Last_visit'])
				$('#height_data').text(result_data_json[0]['height']+' cm')
				$('#weight_data').text(result_data_json[0]['weight']+' kg')
				$('#bmi_data').text(result_data_json[0]['BMI'])
				$('#weight_cat').text(result_data_json[0]['weight_cat'])
				$('#all_remark').text(result_data_json[0]['dite_remark'])
				let prescription_data = result_data_json[0]['prescription']
			
				
				if(prescription_data != undefined){
					$('.prescription_data_print').empty();
					$('.prescription_data_print').append(`<h2>Prescription</h2>`)
					
				for(let x=0;x<prescription_data.length;x++){
					let food_time = '';
					if(result_data_json[0]['prescription'][x]['after_food'] == 1){
						food_time = 'After Food';
					}else if(result_data_json[0]['prescription'][x]['befor_food'] == 1){
						food_time = 'Before Food';
					}
					let time_result =  result_data_json[0]['prescription'][x]['morning_section']+'-'+result_data_json[0]['prescription'][x]['noon_section']+'-'+result_data_json[0]['prescription'][x]['evening_section'];
					$('.prescription_data_print').append(`<p><b>${result_data_json[0]['prescription'][x]['medicine_name']}</b> ${time_result} ${result_data_json[0]['prescription'][x]['no_of_day']} days ${food_time}</p>`)
				}
				}
				let complaint_data = result_data_json[0]['comment_data']
				if(complaint_data != undefined){
				    $('.complaints_data_print').empty()
					$('.complaints_data_print').append(`<h2>Complaints</h2>`)
				for(let xy = 0; xy<complaint_data.length;xy++){
				$('.complaints_data_print').append(`<p>${complaint_data[xy]['comment']}</p>`)
				}
				}
				
					let medical_data = result_data_json[0]['medical_data']
					if(medical_data != undefined){
						$('.medical_history_print').empty()
						$('.medical_history_print').append(`<h2>Medical History</h2>`)
					for( let xy2=0 ; xy2<medical_data.length; xy2++){
					$('.medical_history_print').append(`<p>${medical_data[xy2]['comment']}</p>`)
					}
				}
					
				$('.dynamic_doctor').empty()
				$('.dynamic_doctor').append(`<ul>
							<li><b>${result_data_json[0]['doctor_name']}</b></li>
							<li>${result_data_json[0]['qualification_data']}</li>
							<li>Reg No : ${result_data_json[0]['reg_num']}</li>
							<li>${result_data_json[0]['designation_data']}</li>
					</ul>`)
					
					let surgical_data = result_data_json[0]['surgical_data']
					if(surgical_data != undefined){
						$('.Investigations_data').empty()
						$('.Investigations_data').append(`<h2>Investigations</h2>`)
					for( let xy1 = 0; xy1<surgical_data.length; xy1++){
						$('.Investigations_data').append(`<p>${surgical_data[xy1]['comment']}</p>`)
					}
				}
					
					let food_to_follow = result_data_json[0]['diet_follow']
					if(food_to_follow != undefined){
						$('.food_to_follow').empty()
						for( let xyf1 = 0; xyf1<food_to_follow.length; xyf1++){
						$('.food_to_follow').append(`<p>${food_to_follow[xyf1]['diet']}</p>`)
					}
						if(result_data_json[0]['diet_no_of_days'] != 0){
						$('.food_to_follow').append(`<li><b>No. of Days : ${result_data_json[0]['diet_no_of_days']} Days</b></li>`)
						}
					}
					
					let food_to_avoid = result_data_json[0]['food_plan']
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
						for( let xyf2 = 0; xyf2<food_to_follow.length; xyf2++){
						$('.food_to_avoid').append(`<p>${food_to_avoid[xyf2]['foods_avoid']}</p>`)
					}
					
					}
				
					
					setTimeout(function(){
						  $('.currentConsultingheadPrintBtn').empty()
						  $('.currentConsultingheadPrintBtn').append(`<i class="uil uil-print"></i> Print`)
						$('.pageLoader').css('display','none')
					window.print()
				
					},1000)
				
			}
		}
	})
	
})

/**function fetch_all_lab_reports(patient_id){
	$.ajax({
		url:"action/appointment/fetch_all_lab_reports.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(lab_result){
			$('.labTestHistorySection').empty()
			let lab_result_json = jQuery.parseJSON(lab_result)
			console.log(lab_result_json)
			for(let x=0;x<lab_result_json.length;x++){
				let date_report = lab_result_json[x]['lab']
				let template_data = `<div class="labTestHistorySectionBox">
									<div class="labTestHistoryDate">${lab_result_json[x]['added_date']} OLD</div>
									<div class="labTestHistoryReport">`
										for(let y=0;y<date_report.length;y++){
											if(date_report[y]['lab_report_file'] != ''){
											template_data += `<div class="labTestHistoryReportBox">
															  <p>${date_report[y]['test_name']}</p>
																<a href="../lab/assets/fileupload/${date_report[y]['lab_report_file']}" class="labTestHistoryReportFileBtn">
																	<i class="uil uil-eye"></i>
																</a>
															  </div>`
											}else{
											template_data += `<div class="labTestHistoryReportBox">
															  <p>${date_report[y]['test_name']}</p>
																
															  </div>`
											}
										}
										
										template_data += `<!-- dont remove the div-->
										<div class="dummyDiv"></div>
										<!-- dont remove the div-->
										
									</div>
								</div>`;
								$('.labTestHistorySection').append(template_data)
			}
		}
	})
}**/
$('.FileUploadAddBtn').click(function(){
$('.commentsPopupPreviousFileUploadSectionTemplate').append(`
								<div class="commentsPopupPreviousFileUploadSectionBox" style="width :100%; display :flex; margin-top: 10px; background: #f6f7e7; border-radius: 10px; padding: 10px; flex-wrap: wrap;">
									<div class="formGroup">
										<label>File Name</label>
										<input type="text" class="report_name">
										<span style="color:red" class="file_name_error"></span>
									</div>
									<div class="formGroupFile">
										<div class="formGroupFileMain">
											<div class="formGroupFileBox1">
												<label>Upload File</label>
												<label class="uploadBtn">
  													<input type="file" class="fileInput report_file">
                                                    <p>Upload images</p>
                                                </label>
												<span style="color:red" class="file_error"></span>
											</div>
											<div class="formGroupFileBox2">
												
											</div>
										</div>
									</div>
								
								</div>`);
	})

$('body').delegate('.formGroupFileSaveBtn','click',function(e){
	e.preventDefault();
	let div_len = $('.commentsPopupPreviousFileUploadSectionBox').length
	let div_count = 0;
	$('.commentsPopupPreviousFileUploadSectionBox').each(function(){
	let parent_div = $(this)
	div_count += 1;
	let fd = new FormData();
	let file_name = parent_div.find('.report_name').val()
	let file = parent_div.find('.report_file').val().replace("C:\\fakepath\\", "");
	parent_div.find('.file_name_error').text('')
	parent_div.find('.file_error').text('')
	if(file_name != '' && file!= ''){
	$('.formGroupFileSaveBtn').text('Loading...')
	fd.append("files[]", parent_div.find('.report_file')[0].files[0]);
	fd.append("file_name",file_name);
	fd.append("file",file);
	let appointment_id = $('.consultedBtn').attr('data-id')
	fd.append("appointment_id",appointment_id);
	$.ajax({
		url:"action/upload_data/Upload_file_treatment.php",
        type:"POST",
        data:fd,
        contentType:false,
        processData:false,
		success:function(result_data){
			console.log("div_count "+div_count)
			if(div_count == div_len){
			$('.formGroupFileSaveBtn').text('save')
			$('.commentsPopupPreviousFileUploadSectionTemplate').remove();
			fetch_all_previous_treatment(patient_id)
			
			}
		}
		});
			}else{
		if(file_name == ''){
			parent_div.find('.file_name_error').text('*required!')
		}else{
			parent_div.find('.file_name_error').text('')
		}
		if(file_name == ''){
			parent_div.find('.file_error').text('*required!')
		}else{
			parent_div.find('.file_error').text('')
		}
	}
		
	})
})

function fetch_all_previous_treatment(patient_id,branch_id){
$.ajax({
	url:"action/appointment/fetch_all_previous_treatment_report.php",
	type:"POST",
	data:{patient_id:patient_id,
		 branch_id:branch_id,
		 },
	success:function(previous_result){
		let lab_result_json = jQuery.parseJSON(previous_result)
			console.log(lab_result_json)
		$('.treatment_repor').empty()
			for(let x=0;x<lab_result_json.length;x++){
				let date_report = lab_result_json[x]['treatment']
				let template_data = `<div class="labTestHistorySectionBox">
									<div class="labTestHistoryDate">${lab_result_json[x]['added_date']}</div>
									<div class="labTestHistoryReport">`
										for(let y=0;y<date_report.length;y++){
											let file_data = `<a href="add-lab-test.php?id=${date_report[y]['id']}-${branch_id}" class="labTestHistoryReportFileBtn">
																	<i class="uil uil-export"></i>
																</a>`;
											if(date_report[y]['file'] != ''){
											file_data = `<a href="assets/treatmentfileupload/${date_report[y]['file']}" class="labTestHistoryReportFileBtn">
																	<i class="uil uil-eye"></i>
																</a>

<a href="add-lab-test.php?id=${date_report[y]['id']}-${branch_id}" class="labTestHistoryReportFileBtn" style="margin-left:10px">
																	<i class="uil uil-export"></i>
																</a>
`
											}
											template_data += `<div class="labTestHistoryReportBox">
															  <p>${date_report[y]['treatment_name']}</p>
																${file_data}
															  </div>`
										}
										
										template_data += `<!-- dont remove the div-->
										<div class="dummyDiv"></div>
										<!-- dont remove the div-->
										
									</div>
								</div>`;
								$('.treatment_repor').append(template_data)
			}
	}
})
}

function fetch_all_invoice_report(url_val,branch_id){
	$('.Invoice_report').empty()
	$.ajax({
		url:"action/appointment/fetch_all_invoice_data.php",
		type:"POST",
		data:{url_val:url_val,
			 branch_id:branch_id
			 },
		success:function(invoice_report){
			
			console.log(invoice_report)
			let invoice_report_json = jQuery.parseJSON(invoice_report)
			console.log(invoice_report_json)
			if(invoice_report_json[0]['status'] == 1){
			for(let x = 0;x<invoice_report_json.length;x++){
				$('.Invoice_report').append(`<div class="labTestHistoryReportBox">
											<p>${invoice_report_json[x]['invoice_num_com']}</p>
											<a href="" class="labTestHistoryReportFileBtn invoice_print_btn" invoice_id=${invoice_report_json[x]['id']} branch_id=${branch_id}>
												<i class="uil uil-print"></i>
											</a>
										</div>`)
			}
			}else{
				
			}
		}
	})
}

$('body').delegate('.invoice_print_btn','click',function(e){
	e.preventDefault();
	let invoice_id = $(this).attr('invoice_id')
	let branch_id = $(this).attr('branch_id')
	$.when(print_invoice_data_btn(invoice_id,branch_id)).then(function(){
		setTimeout(function(){
			window.print()
		},1500)
	})
})
 function print_invoice_data(appoinment_id){
$('.printDesign').empty()
	$.ajax({
				url:"action/appointment/print_all_treatments.php",
				type:"POST",
				data:{appointment_id:appoinment_id},
		success:function(profile_result){
			let data = jQuery.parseJSON(profile_result)
			/*if(data.length!=0){
				window.print();
			}*/
			console.log(data)
			let template =``;
        let b = 0;
            
        
        for(let x1=0;x1<data.length;x1++){
      b++;
			
		template+=` <div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2>${data[0]['head']}</h2>
					<p>${data[0]['address']}</p>
                    <p>${data[0]['phn_details']}</p>
                </div>
            </div>
            <div class="printDesignProfile">
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Invoice No <b>:</b></span>
                            <p id="unique_id_text">${data[x1]['invoice_num_com']}</p>
                        </li>
                        <li>
                            <span>Customer Name <b>:</b></span>
                            <p id="customer_name_text">${data[x1]['name']}</p>
                        </li>
                        <li>
                            <span>Mobile No <b>:</b></span>
                            <p id="mob_num_text">${data[x1]['phone']}</p>
                        </li>
                    </ul>
                </div>
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Bill Date & Time<b>:</b></span>
                            <p id="order_date_text">${data[x1]['added_date']}</p>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="printDesignTable">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Treatement</th>
                            <th>Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody class="tableInvoice">`	
			
			 let c = 0;
for(let y=0; y<data[x1]['treatment_details'].length; y++){
c++;

    
              template += `<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${c}</td>
                            <td>${data[x1]['treatment_details'][y]['treatement_name']}</td>
                            <td>₹ ${data[x1]['treatment_details'][y]['treatment_amount']}</td>
                        </tr>`
			  
			  
			  
			  
}
			
			template+=` </tbody>
					
					<tbody class="taxDiv" style="border-top: 1px solid black;">
						
					</tbody>
                    <tfoot>
						<tr style="page-break-inside: avoid; page-break-after: auto; display:none;" class="delivery_charge_section">
							<td colspan="9"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="5" class="tax_val_dis"><b>Total</b></td>
                            <td colspan="3"><b id="quantity_class">${data[x1]['total_sum']}</b></td>
							 <td colspan="1"><b id="cgst"></b></td>
							 <td colspan="1"><b id="sgst"></b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <td colspan="0" style="text-align: left;"><b id="total_amt_1"></b></td>
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="12"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
                        </tr>-->
                    </tfoot>
                </table>
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
				<!--<h2>Bank Details</h2>
				<p>Account Name : JOHNMARIAN WELLNESS CLINIC</p>
				<p>Account Number : 306530123456789</p>
				<p>Branch: KALAMASSERY</p>
				<p>Account Type : Current Account</p>
				<p>IFSC Code : TMBL0000306</p>
				<p>MICR Code : 682060003</p>-->
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>`
			
			
			
			$('.printDesign').append(template);
		}
			
			
			
			
		}
	})
 }


 function print_invoice_data_btn(invoice_id,branch_id){
$('.printDesign').empty()
	$.ajax({
		url:"action/appointment/print_all_treatments_invoice.php",
		type:"POST",
		data:{invoice_id:invoice_id,
			 branch_id:branch_id
			 },
		success:function(profile_result){
			let data = jQuery.parseJSON(profile_result)
			/*if(data.length!=0){
				window.print();
			}*/
			console.log(data)
			let template =``;
        let b = 0;
            
        
        for(let x1=0;x1<data.length;x1++){
      b++;
			
		template+=` <div class="printDesignHead">
                <div class="printDesignHeadLogo">
                    <img src="assets/images/johnmariansLogo.png" alt="">
                </div>
                <div class="printDesignHeadAddress">
					<h2>${data[0]['head']}</h2>
					<p>${data[0]['address']}</p>
                    <p>${data[0]['phn_details']}</p>
                </div>
            </div>
            <div class="printDesignProfile">
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Invoice No <b>:</b></span>
                            <p id="unique_id_text">${data[x1]['invoice_num_com']}</p>
                        </li>
                        <li>
                            <span>Customer Name <b>:</b></span>
                            <p id="customer_name_text">${data[x1]['name']}</p>
                        </li>
                        <li>
                            <span>Mobile No <b>:</b></span>
                            <p id="mob_num_text">${data[x1]['phone']}</p>
                        </li>
                    </ul>
                </div>
                <div class="printDesignProfileBox">
                    <ul>
                        <li>
                            <span>Bill Date & Time<b>:</b></span>
                            <p id="order_date_text">${data[x1]['added_date']}</p>
                        </li>
                    </ul>
                </div> 
            </div>
            <div class="printDesignTable">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Treatement</th>
                            <th>Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody class="tableInvoice">`	
			
			 let c = 0;
for(let y=0; y<data[x1]['treatment_details'].length; y++){
c++;

    
              template += `<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${c}</td>
                            <td>${data[x1]['treatment_details'][y]['treatement_name']}</td>
                            <td>₹ ${data[x1]['treatment_details'][y]['treatment_amount']}</td>
                        </tr>`
			  
			  
			  
			  
}
			
			template+=` </tbody>
					
					<tbody class="taxDiv" style="border-top: 1px solid black;">
						
					</tbody>
                    <tfoot>
						<tr style="page-break-inside: avoid; page-break-after: auto; display:none;" class="delivery_charge_section">
							<td colspan="9"></td>
                            <td style="text-align: left;" class="tax_val_dis1"><b>Delivery Charge</b></td>
                            <td style="text-align: left;"><b id="total_amt_1_delivery"></b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="2" class="tax_val_dis"><b>Total</b></td>
                          
							 <td colspan="1"><b id="cgst"></b></td>
							 <td colspan="1"><b id="sgst"></b></td>
							
                            <!--<td colspan="1"><b id="total_amt_3"></b></td>-->
							<!--<td></td>-->
                            <td colspan="0" style="text-align: left;"><b id="total_amt_1">${data[x1]['total_sum']}</b></td>
                            <!--<td colspan="1"><b id="total_disc_val"></b></td>
                            <td colspan="1"><b id="g_total_amt"></b></td>-->
                        </tr>
                       <!-- <tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td colspan="7" style="border: none; text-align: right; padding-right: 10px;"><b>Total Amount</b></td>
                            <td colspan="1" style="border: none;"><b id="g_total_amt">₹ 380</b></td>
                        </tr>
                        <tr style="page-break-inside: avoid; page-break-after: auto; border-top: 1px solid black;">
                            <td colspan="12"><b id="amt_in_words"></b> - Inclusive Of All Taxes</td>
                        </tr>-->
                    </tfoot>
                </table>
            </div>
            <div class="printDesignTC" style="page-break-inside: avoid; page-break-after: auto;">
				<!--<h2>Bank Details</h2>
				<p>Account Name : JOHNMARIAN WELLNESS CLINIC</p>
				<p>Account Number : 306530123456789</p>
				<p>Branch: KALAMASSERY</p>
				<p>Account Type : Current Account</p>
				<p>IFSC Code : TMBL0000306</p>
				<p>MICR Code : 682060003</p>-->
                <h2>Terms & Conditions</h2>
                <p>You should not make any change in your current medications or health regimen before consulting a registered medical practitioner</p>
            </div>`
			
			
			
			$('.printDesign').append(template);
		}
			
			
			
			
		}
	})
 }

 		//collectFeeBtn
		$('.collectFeeBtn').click(function(){
			$('.feeCollectionPopup').fadeIn();
			$('.shimmer').fadeIn();
		})
		$('.closeFeeCollectionPopupBtn').click(function(){
			$('.feeCollectionPopup').fadeOut();
			$('.shimmer').fadeOut();
		})


$.ajax({
	url:"action/appointment/fetch_all_treatment.php",
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		console.log("treatment")
		console.log(result_data_json)
		if(result_data_json.length !=0){
		for(let x=0;x<result_data_json.length;x++){
			$('.treatment_data ul').append(`<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['treatment']}</li>`)
		}
		}
	}
})

$('body').delegate('ul li','click',function(){
	let li_id = $(this).attr('data-id')
	let treatemnt_val = $(this).text()
	$(this).parent().parent().parent().parent().find('.dropDownInputText').attr('id_val',li_id)
	$(this).parent().parent().parent().parent().find('.dropDownInputText').val(treatemnt_val)
	$(this).parent().parent().parent().parent().parent().parent().find('.treatment_amt').val('')
	$('#treatment_btn').attr('disabled',false)
})


$('body').delegate('.treatment_amt','keyup',function(){
	let total_amt = 0;
	let loop_count = 0;
	let loop_len = $('.treatment_amt').length
	$('.treatment_amt').each(function(){
		if($(this).val() != ''){
		total_amt += parseInt($(this).val())
		}
		loop_count++
		console.log("loop_count "+loop_count)
		console.log("loop_len "+loop_len)
		if(loop_count == loop_len){
			$('.total_amt_details').text('₹ '+total_amt)
		}
	})
	check_amount_mismatch()
})
$('body').delegate('.amount_recived','keyup',function(){
	check_amount_mismatch()
})
function check_amount_mismatch(){
	let loop_count = 0;
	let loop_len = $('.treatment_amt').length
	let total_amt = 0;
	$('.treatment_amt').each(function(){
		if($(this).val() != ''){
		total_amt += parseInt($(this).val())
		}
		loop_count++
		if(loop_count == loop_len){
			let amount_recived = 0
			let boc_loop = 0;
			let loop_len = $('.amount_recived').length;
			$('.amount_recived').each(function(){
				amount_recived += parseInt($(this).val())
				console.log(amount_recived)
				boc_loop++
				if(boc_loop == loop_len){
					if(amount_recived != total_amt){
						$('#amt_error').text('*Amount mismatch!')
						$('#amt_error_val').val(1)
					}else{
						$('#amt_error').text(' ')
						$('#amt_error_val').val(0)
					}
				}
			})
		}
	})
}

function validateion_fee_collection(){
	let valid = 0
	let amt_input = $('.treatment_amt').length
	let amt_loop_c = 0
	$('.treatment_amt').each(function(){
		if($(this).val()==''){
			$(this).parent().find('.error_num').css('color','red')
			$(this).parent().find('.error_num').text('*Required!')
			valid++
		}else{
		$(this).parent().find('.error_num').text('')
		}
		amt_loop_c++
		if(amt_loop_c == amt_input){
			console.log("valid valid"+valid)
			return valid
		}
	})
}

$('#treatment_btn').click(function(e){
	e.preventDefault()
	let that = $(this)
	that.prop('disabled',true)
	let validation_val = $('#amt_error_val').val()
	let appointment_id_data = $('.consultedBtn').attr('data-id')
	let valid = 0
	let amt_input = $('.treatment_amt').length
	let amt_loop_c = 0
	$('.treatment_amt').each(function(){
		if($(this).val()==''){
			$(this).parent().find('.error_num').css('color','red')
			$(this).parent().find('.error_num').text('*Required!')
			valid++
		}else{
		$(this).parent().find('.error_num').text('')
		}
		amt_loop_c++
		if(amt_loop_c == amt_input){
			if(valid == 0){
		if(validation_val == 0){
			that.text('Loading...')
	$.when(create_invoice_treatment(appointment_id_data)).then(function(invoice_id){
		let invoice_id_json = jQuery.parseJSON(invoice_id)
		let id = invoice_id_json[0]['id']
		let invoice_branch = invoice_id_json[0]['branch_id']
		 $('.print_enable').attr('invoice_id',id)
		let treatment_count = 0;
		let treatment_len = $('.feeCollectionPopupBox').length
		if(treatment_len != 0){
	$('.feeCollectionPopupBox').each(function(){
		let treatement_id = $(this).find('p').attr('treatment_id')
		let treatement_name = $(this).find('p').text()
		let treatment_amt = $(this).find('.treatment_amt').val()
		  $.ajax({
			   url:"action/appointment/add_treatment_data.php",
			   type:"POST",
			   data:{treatement_id:treatement_id,
				 treatement_name:treatement_name,
				  treatment_amt:treatment_amt,
				  id:id,
				  invoice_branch:invoice_branch,
				 },
				success:function(result){
					console.log(result)
					treatment_count++
					if(treatment_count == treatment_len){
						//add new treatment
						let new_treatment_data = $('.feeCollectionPopupAddTreatmentSectionTemp').length
						let new_treatment_loop = 0;
						if(new_treatment_data != 0){
						$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
							let new_treatement_id = $(this).find('.dropDownInputText').attr('id_val')
							let new_treatement_name = $(this).find('.dropDownInputText').val()
							let new_treatment_amt = $(this).find('.treatment_amt').val()
								$.ajax({
									url:"action/appointment/add_treatment_data.php",
									type:"POST",
			   						data:{treatement_id:new_treatement_id,
				 					treatement_name:new_treatement_name,
				  					treatment_amt:new_treatment_amt,
				  					id:id,
				  					invoice_branch:invoice_branch,
				 					},
									success:function(new_result){
										console.log(new_result)
										new_treatment_loop++
										if(new_treatment_loop == new_treatment_data){
										$.ajax({
											url:"action/appointment/update_invoice_last.php",
											type:"POST",
											data:{id:id},
											success:function(invoice_result){
												console.log(invoice_result)
												//add payment type
												let mood_len = $('.paymentMoodBox').length
												let mood_loop = 0;
												$('.paymentMoodBox').each(function(){
												let payment_type = $(this).find('select').val()
												let amt = $(this).find('.amount_recived').val()
													$.ajax({
														url:"action/appointment/add_treatment_payment_mode.php",
														type:"POST",
														data:{payment_type:payment_type,
										 					amt:amt,
										  					id:id,
										  					invoice_branch:invoice_branch
										 				},
													success:function(amt_result){
														fetch_all_invoice_report(patient_id,branch_data)
														console.log(amt_result)
														mood_loop++
														if(mood_loop == mood_len){
														let new_treatment_count = $('.feeCollectionPopupAddTreatmentSectionTemp').length
														let new_treatment_count_loop = 0;
														$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
															let new_treatment_id = $(this).find('.treatment_data').val()
															console.log(new_treatment_id)
														})
															//$('.collectFeeBtn').css('display','none')
															//$('.print_enable').css('display','flex')
															that.text('Success')
															that.css('background-color','blue')
															$.when(print_invoice_data(appointment_id_data)).then(function(){
																
																setTimeout(function(){
																	$('.feeCollectionPopup').fadeOut();
																	$('.shimmer').fadeOut();
																	//that.text('Print')
																	$('.total_amt_details').empty()
																	$('.total_amt_details').append('₹ 0')
																	that.text('Save')
																	that.css('background-color','#557bfe')
																	$('.feeCollectionPopupAddTreatmentSectionTempCopy').empty()
																	$('.feeCollectionPopupAddTreatmentSectionTemp').empty()
																	//feeCollectionPopupAddTreatmentSectionTemp
																	let template = `<div class="feeCollectionPopupAddTreatmentSectionTemp">
						<div class="formGroup">
							<label>Treatment</label>
							<div class="dropDownSection">
								<div class="dropDownInput">
									<input type="text" class="dropDownInputText" disabled="" style="box-shadow: rgba(0, 0, 0, 0.06) 0px 0px 20px;">
								</div>

								<div class="dropDownPopup">
									<div class="dropDownSearch">
										<input type="search" class="searchDropDown-field" placeholder="Search...">
									</div>

									<div class="dropDownPopuplist singleSelect lab_report">
										<ul>`;
					 $.ajax({
				url:"action/appointment/fetch_all_treatment.php",
				success:function(result_data){
				let result_data_json = jQuery.parseJSON(result_data)
				console.log("treatment")
				console.log(result_data_json)
					let lab_len = result_data_json.length
					let loop_c = 1;
				if(result_data_json.length !=0){ 
				for(let x=0;x<result_data_json.length;x++){
				template += `<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['treatment']}</li>`
				loop_c++
				if(lab_len == loop_c){
				template += `</ul>
										<div class="elseDesign" style="display: none;">
											<div class="elseDesignthumbnail">
												<img src="assets/images/empty.png" alt="">
											</div>
											<p>No Data Available</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="formGroup">
							<label>Amount</label>
							<input type="number" class="treatment_amt" value="0">
							<span class="error_num"></span>
						</div>
						<div class="feeCollectionPopupAddTreatmentSectionTempBtnArea">
							<div class="feeCollectionPopupAddTreatmentSectionTempDeleteBtn">Remove</div>
						</div>
					</div>`;
			$('.feeCollectionPopupAddTreatmentSectionTempCopy').append(template)
			}
}
}
}
})
																	//#557bfe
																	window.print()
															},2000)
	
														})
													}
												}
										})
									})
								}
							})
									}
									}
								})
							
						})
						}else{
						$.ajax({
											url:"action/appointment/update_invoice_last.php",
											type:"POST",
											data:{id:id},
											success:function(new_result){
												console.log(new_result)
												//add payment type
												let mood_len = $('.paymentMoodBox').length
												let mood_loop = 0;
												$('.paymentMoodBox').each(function(){
												let payment_type = $(this).find('select').val()
												let amt = $(this).find('.amount_recived').val()
													$.ajax({
														url:"action/appointment/add_treatment_payment_mode.php",
														type:"POST",
														data:{payment_type:payment_type,
										 					amt:amt,
										  					id:id,
										  					invoice_branch:invoice_branch
										 				},
													success:function(amt_result){
														fetch_all_invoice_report(patient_id,branch_data)
														console.log(amt_result)
														mood_loop++
														if(mood_loop == mood_len){
														let new_treatment_count = $('.feeCollectionPopupAddTreatmentSectionTemp').length
														let new_treatment_count_loop = 0;
														$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
															let new_treatment_id = $(this).find('.treatment_data').val()
															console.log(new_treatment_id)
														})
															//$('.collectFeeBtn').css('display','none')
															//$('.print_enable').css('display','flex')
															that.text('Success')
															that.css('background-color','blue')
															$.when(print_invoice_data(appointment_id_data)).then(function(){
																setTimeout(function(){
																	$('.feeCollectionPopup').fadeOut();
																	$('.shimmer').fadeOut();
																	$('.total_amt_details').empty()
																	$('.total_amt_details').append('₹ 0')
																	//that.text('Print')
																	that.text('Save')
																	that.css('background-color','#557bfe')
																	$('.feeCollectionPopupAddTreatmentSectionTempCopy').empty()
																	$('.feeCollectionPopupAddTreatmentSectionTemp').empty()
																	let template = `<div class="feeCollectionPopupAddTreatmentSectionTemp">
						<div class="formGroup">
							<label>Treatment</label>
							<div class="dropDownSection">
								<div class="dropDownInput">
									<input type="text" class="dropDownInputText" disabled="" style="box-shadow: rgba(0, 0, 0, 0.06) 0px 0px 20px;">
								</div>

								<div class="dropDownPopup">
									<div class="dropDownSearch">
										<input type="search" class="searchDropDown-field" placeholder="Search...">
									</div>

									<div class="dropDownPopuplist singleSelect lab_report">
										<ul>`;
					 $.ajax({
				url:"action/appointment/fetch_all_treatment.php",
				success:function(result_data){
				let result_data_json = jQuery.parseJSON(result_data)
				console.log("treatment")
				console.log(result_data_json)
					let lab_len = result_data_json.length
					let loop_c = 1;
				if(result_data_json.length !=0){ 
				for(let x=0;x<result_data_json.length;x++){
				template += `<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['treatment']}</li>`
				loop_c++
				if(lab_len == loop_c){
				template += `</ul>
										<div class="elseDesign" style="display: none;">
											<div class="elseDesignthumbnail">
												<img src="assets/images/empty.png" alt="">
											</div>
											<p>No Data Available</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="formGroup">
							<label>Amount</label>
							<input type="number" class="treatment_amt" value="0">
							<span class="error_num"></span>
						</div>
						<div class="feeCollectionPopupAddTreatmentSectionTempBtnArea">
							<div class="feeCollectionPopupAddTreatmentSectionTempDeleteBtn">Remove</div>
						</div>
					</div>`;
			$('.feeCollectionPopupAddTreatmentSectionTempCopy').append(template)
			}
}
}
}
})
																	//#557bfe
																	window.print()
															},2000)
	
														})
													}
												}
										})
									})
								}
							})
						}
						
					}
				}
		    })
		
	})
		}else{
						let new_treatment_data = $('.feeCollectionPopupAddTreatmentSectionTemp').length
						let new_treatment_loop = 0;
			console.log("new_treatment_data "+new_treatment_data)
						if(new_treatment_data != 0){
						$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
							let new_treatement_id = $(this).find('.dropDownInputText').attr('id_val')
							let new_treatement_name = $(this).find('.dropDownInputText').val()
							let new_treatment_amt = $(this).find('.treatment_amt').val()
								$.ajax({
									url:"action/appointment/add_treatment_data.php",
									type:"POST",
			   						data:{treatement_id:new_treatement_id,
				 					treatement_name:new_treatement_name,
				  					treatment_amt:new_treatment_amt,
				  					id:id,
				  					invoice_branch:invoice_branch,
				 					},
									success:function(invoice_result){
										console.log(invoice_result)
										new_treatment_loop++
										if(new_treatment_loop == new_treatment_data){
										$.ajax({
											url:"action/appointment/update_invoice_last.php",
											type:"POST",
											data:{id:id},
											success:function(){
												//add payment type
												let mood_len = $('.paymentMoodBox').length
												let mood_loop = 0;
												$('.paymentMoodBox').each(function(){
												let payment_type = $(this).find('select').val()
												let amt = $(this).find('.amount_recived').val()
													$.ajax({
														url:"action/appointment/add_treatment_payment_mode.php",
														type:"POST",
														data:{payment_type:payment_type,
										 					amt:amt,
										  					id:id,
										  					invoice_branch:invoice_branch
										 				},
													success:function(amt_result){
														fetch_all_invoice_report(patient_id,branch_data)
														console.log(amt_result)
														mood_loop++
														if(mood_loop == mood_len){
														let new_treatment_count = $('.feeCollectionPopupAddTreatmentSectionTemp').length
														let new_treatment_count_loop = 0;
														$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
															let new_treatment_id = $(this).find('.treatment_data').val()
															console.log(new_treatment_id)
														})
															//$('.collectFeeBtn').css('display','none')
															//$('.print_enable').css('display','flex')
															that.text('Success')
															that.css('background-color','blue')
															$.when(print_invoice_data(appointment_id_data)).then(function(){
																setTimeout(function(){
																	$('.feeCollectionPopup').fadeOut();
																	$('.shimmer').fadeOut();
																	$('.total_amt_details').empty()
																	$('.total_amt_details').append('₹ 0')
																	//that.text('Print')
																	that.text('Save')
																	that.css('background-color','#557bfe')
																	$('.feeCollectionPopupAddTreatmentSectionTempCopy').empty()
																	$('.feeCollectionPopupAddTreatmentSectionTemp').empty()
																	let template = `<div class="feeCollectionPopupAddTreatmentSectionTemp">
						<div class="formGroup">
							<label>Treatment</label>
							<div class="dropDownSection">
								<div class="dropDownInput">
									<input type="text" class="dropDownInputText" disabled="" style="box-shadow: rgba(0, 0, 0, 0.06) 0px 0px 20px;">
								</div>

								<div class="dropDownPopup">
									<div class="dropDownSearch">
										<input type="search" class="searchDropDown-field" placeholder="Search...">
									</div>

									<div class="dropDownPopuplist singleSelect lab_report">
										<ul>`;
					 $.ajax({
				url:"action/appointment/fetch_all_treatment.php",
				success:function(result_data){
				let result_data_json = jQuery.parseJSON(result_data)
				console.log("treatment")
				console.log(result_data_json)
					let lab_len = result_data_json.length
					let loop_c = 1;
				if(result_data_json.length !=0){ 
				for(let x=0;x<result_data_json.length;x++){
				template += `<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['treatment']}</li>`
				loop_c++
				if(lab_len == loop_c){
				template += `</ul>
										<div class="elseDesign" style="display: none;">
											<div class="elseDesignthumbnail">
												<img src="assets/images/empty.png" alt="">
											</div>
											<p>No Data Available</p>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="formGroup">
							<label>Amount</label>
							<input type="number" class="treatment_amt" value="">
							<span class="error_num"></span>
						</div>
						<div class="feeCollectionPopupAddTreatmentSectionTempBtnArea">
							<div class="feeCollectionPopupAddTreatmentSectionTempDeleteBtn">Remove</div>
						</div>
					</div>`;
			$('.feeCollectionPopupAddTreatmentSectionTempCopy').append(template)
			}
}
}
}
})
																	//#557bfe
																	window.print()
															},2000)
	
														})
													}
												}
										})
									})
								}
							})
									}
									}
								})
							
						})
						}
		}
	})
}
			}
		}
	
})
	
})

$('.feeCollectionPopupBody').append(`<div class="paymentMood">
						<h2>Payment Mode</h2>
						<div class="paymentMoodBox">
							<select>
								<option value="1">Gpay</option>
								<option value="2">Cash</option>
								<option value="3">Card</option>
							</select>
							<input type="number" class="amount_recived">
							<div class="addPaymentMoodBtn">Add</div>
						</div>
						<div class="paymentMoodBoxTemplate"></div>
					</div>`)

//addPaymentMoodBtn
		$('body').delegate('.addPaymentMoodBtn','click',function(){
			var teplate = `<div class="paymentMoodBox">
							<select>
								<option value="1">Gpay</option>
								<option value="2">Cash</option>
								<option value="3">Card</option>
							</select>
							<input type="number" class="amount_recived">
							<div class="removePaymentMoodBtn">Remove</div>
						</div>`;
			$('.paymentMoodBoxTemplate').append(teplate)
		})

$('body').delegate('.removePaymentMoodBtn', 'click', function(){
			$(this).parent().remove();
			check_amount_mismatch()
		})

function create_invoice_treatment(appointmnet_data_id){
	return $.ajax({
		url:"action/appointment/add_treatment_invoic.php",
		type:"POST",
		data:{appointment_id:appointmnet_data_id},
		
	})
}