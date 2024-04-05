let fun_exe = 0;
var next_btn_class = 'disableNextBtn';
let search_data = '';
let diet_plan = [];
let food_avoided_plan = [];
let url_data = window.location.href
let url_split = url_data.split('=')
let url_val = url_split[1]
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
				if(result_data_json[0]['appointment_status'] == 2){
					$('.currentConsultingheadPrintBtn').attr('data-id',result_data_json[x]['id'])
					$('.currentConsultingheadPrintBtn').css('display','flex')
				}		let branch_id = result_data_json[x]['branch_id']
						//fetch_all_prescription_data(result_data_json[x]['unique_id'])
						//fetch_allcomments(result_data_json[x]['unique_id'])
						//fetch_allmedical(result_data_json[x]['unique_id'])
						//fetch_allsurgical(result_data_json[x]['unique_id'])
						//fetch_all_food_plan(result_data_json[x]['id'])
				        //fetch_all_diet_plan(result_data_json[x]['id'])
						fetch_all_lab_data(url_val,branch_id)
						fetch_all_appointment_data(url_val,branch_id)
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
										<td data-label="BMI">
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
	$.when(fetch_all_die_details()).then(function(){
		$.when(fetch_all_foods_to_be_avoided_details()).then(function(){
	//food_avoided_plan
    //diet_plan
	$.ajax({
		url:"action/appointment/add_consulted_data.php",
		type:"POST",
		data:{patient_id:patient_id,
			 food_avoided_plan:food_avoided_plan,
			  diet_plan:diet_plan
			 },
		success:function(counsulted_result){
			let counsulted_result_json = jQuery.parseJSON(counsulted_result)
			if(counsulted_result_json[0]['status'] == 1){
				$('.WaitingCount').text(counsulted_result_json[0]['pending_count'])
				if(counsulted_result_json[0]['pending_count'] == 0){
					$('.all_waiting_appointments_else').css('display','flex')
				}
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
            },3000);
			}else{
				window.location.href="../login.html"
			}
		}
	})
		})
	})
})
let api = "de317f60c5d5182d99a2cf0fdc8f6175";
fetch_all_medicine()
function fetch_all_medicine(){
fetch("https://jmwell.in/api/fetchAll_medicine.php?api="+api)
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
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['staff_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				//$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				
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

function fetch_all_lab_data(url_val,branch_id){
$.ajax({
	url:"action/appointment/fetch_all_lab_data.php",
	type:"POST",
	data:{url_val:url_val,
		 branch_id:branch_id,
		 },
	success:function(lab_result){
		let lab_result_json = jQuery.parseJSON(lab_result)
		$('.commentsPopupPreviousMain').empty()
		if(lab_result_json.length!=0){
			for(let x=0;x<lab_result_json.length;x++){
				$('.commentsPopupPreviousMain').append(`<div class="commentsPopupPrevious">
								<h2>${lab_result_json[x]['test_name']}</h2>
								<div class="labTestList">
									<a href="add-lab-test.php?id=${lab_result_json[x]['id']}-${url_val}" class="labTestListBox">${lab_result_json[x]['test_name']}</a>
								</div>
							</div>`)
			}
		}else{
			$('.commentsPopupPreviousMain').append(`<div class="elseDesign" style="display:flex">
								<div class="elseDesignthumbnail">
									<img src="assets/images/empty.png" alt="">
								</div>
								<p>No Data</p>
							</div>`)
		}
	}
})
}
function fetch_all_appointment_data(url_val,branch_id){
$.ajax({
	url:"action/appointment/fetch_all_appointments_data.php",
	type:"POST",
	data:{url_val:url_val,
		 branch_id:branch_id
		 },
		success:function(lab_result){
			$('.labTestHistorySection').empty()
			let lab_result_json = jQuery.parseJSON(lab_result)
			console.log(lab_result_json)
		
			for(let x=0;x<lab_result_json.length;x++){
				let date_report = lab_result_json[x]['lab']
				//let date_report_files = "";
				let template_data = `<div class="labTestHistorySectionBox">
<div class="labTestHistoryDate">${lab_result_json[x]['added_date']}</div>
<div class="labTestHistoryReport">`
				for(let y=0;y<date_report.length;y++){
					if(date_report[y]['report_status'] == 1){
						template_data += `<div class="labTestHistoryReportBox">
<p>${date_report[y]['test_name']}</p>`;
						
			
			if(date_report[y]['test'] != undefined){
				let date_report_files = date_report[y]['test']
				
            for(let z = 0;z < date_report_files.length; z++){
				if(z == 0){
				template_data += `<a href="${date_report_files[z]['file_status_file']}" lab_name="${date_report[y]['test_name']}" class="labTestHistoryReportFileBtn">
<i class="uil uil-eye"></i>
</a>`}else{
	template_data += `<a style ="display:none"href="${date_report_files[z]['file_status_file']}" lab_name="${date_report[y]['test_name']}" class="labTestHistoryReportFileBtn">
<i class="uil uil-eye"></i>
</a>`

}
				
			}
			}
						
						template_data += `</div>`
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
}

$('.upload_lab_data').click(function(){
	window.location.href="upload-lab-test.php?id="+url_val;
})

$('body').delegate('.currentConsultingheadPrintBtn','click',function(e){
	$(this).text('Loading...')
	let appointment_id = $(this).attr('data-id')
	e.preventDefault()
	$.ajax({
		url:"action/appointment/print_treatment.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(p_result){
			let result_data_json = jQuery.parseJSON(p_result)
			console.log(result_data_json)
			let treatment_sub_arr = result_data_json[0]['treatment']
			console.log(treatment_sub_arr)
			if(treatment_sub_arr != 'undefined'){
			$('#name_data_p').text('Name : '+result_data_json[0]['name'])
				$('#gender_data_p').text(result_data_json[0]['gender'])
				$('#age_data_p').text(result_data_json[0]['age']+' Years')
				$('#unique_id_p').text(result_data_json[0]['unique_id'])
				$('#total_visit_p').text(result_data_json[0]['total_visit_count'])
				$('#first_visit_p').text(result_data_json[0]['first_visit'])
				$('#last_visit_p').text(result_data_json[0]['Last_visit'])
				$('#height_data_p').text(result_data_json[0]['height']+' cm')
				$('#weight_data_p').text(result_data_json[0]['weight']+' kg')
				$('#bmi_data_p').text(result_data_json[0]['BMI'])
				$('#weight_cat_p').text(result_data_json[0]['weight_cat'])
				$('#all_remark_p').text(result_data_json[0]['dite_remark'])
				
				if(treatment_sub_arr.length !=0){
					let y = 0;
					$('.labTestDetails').empty()
					$('.labTestDetails').append(`<h2>Lab Test</h2>`)
					for(let x = 0;x<treatment_sub_arr.length;x++){
						$('.labTestDetails').append(`<p>${treatment_sub_arr[x]['treatment_name']}</p>`)
						y = x+1;
						if(treatment_sub_arr.length == y){
						print();
						$('.currentConsultingheadPrintBtn').text('Print')
						}
					}
				}
		}else{
			$('.currentConsultingheadPrintBtn').text('Print')
		}
				
		}
	})
	
});
// labTestHistoryReportFileBtn
		$('body').delegate('.labTestHistoryReportFileBtn', 'click', function(e){
            e.preventDefault();
			let template = '';
				$('.imagePreviewPopupBody').empty();
			$(this).parent().find('.labTestHistoryReportFileBtn').each(function(){
				let tab_data = $(this).attr('lab_name')
				let href = $(this).attr('href')
                console.clear();
				console.log(href)
				let file_name = href.split('/')[ href.split('/').length - 1]

				let extension = file_name.split('.');
				let ext = extension[extension.length - 1]
				
				$('#title_data').text(tab_data)
				console.log(extension) 
				
				if(ext == 'pdf'){
					template += `<div class="imagePreviewPopupBodyImg">
						
						<iframe src="${href}" width = "100%" height = "100%"></iframe>
				    </div>`
					
				}else{
					template += `<div class="imagePreviewPopupBodyImg">
						
						<img src="${href}" >
				    </div>`
					//$('.imagePreviewPopup').find('img').attr('src',href)
				}

				$('.imagePreviewPopup').fadeIn();
				$('.shimmer').fadeIn();
			
			})
			$('.imagePreviewPopupBody').append(template)
			$('.imagePreviewPopupBodyImg').eq(0).css("display","block")
			
		})


$('body').delegate('.closeImagePreviewPopup', 'click', function(){
			$('.imagePreviewPopup').fadeOut();
			$('.shimmer').fadeOut();
			$('.imagePreviewPopup').find('iframe').attr('src','')
			$('.imagePreviewPopup').find('img').attr('src','')
		})


