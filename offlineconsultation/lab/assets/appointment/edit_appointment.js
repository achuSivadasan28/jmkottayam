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
	update_position(url_val)
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
				}
						fetch_all_prescription_data(result_data_json[x]['unique_id'],url_val)
						fetch_all_prescription_data_history(result_data_json[x]['unique_id'])
						fetch_allcomments(result_data_json[x]['unique_id'])
						fetch_allmedical(result_data_json[x]['unique_id'])
						fetch_allsurgical(result_data_json[x]['unique_id'])
						fetch_all_food_plan(result_data_json[x]['id'])
				        fetch_all_diet_plan(result_data_json[x]['id'])
				
						
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
						fetch_all_prescription_data(appointment_result_json[x]['unique_id'],url_val)
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
/**$('body').delegate('.updateData','click',function(e){
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
		$.ajax({
		url:"action/appointment/edit_consulted_data.php",
		type:"POST",
		data:{patient_id:patient_id,
			 food_avoided_plan:food_avoided_plan,
			  diet_plan:diet_plan,
			  appointment_id:appointment_id
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
				//$('.consultingWindowTable').css('display','none')
				//$('.commentsPopup').css('display','none')
           // $('.nextBtn').removeClass('disableNextBtn');
            //$('.nextBtn').addClass('enableNextBtn');
            },2500);
            setTimeout(function(){
                $('#done').fadeOut();
                $('#text').fadeIn();
            },3000);
			setTimeout(function(){
                window.location.reload()
            },3200);
			}else{
				window.location.href="../login.html"
			}
		}
	})
		})
	})
})**/
//consulted button click
$('body').delegate('.updateData','click',function(e){
	let patient_id = $(this).attr('data-id')
	//console.log(patient_id)
	e.preventDefault();
    $('#text').fadeOut();
    setTimeout(function(){
        $('#loading').fadeIn();
    },500);
    setTimeout(function(){
        $('#loading').fadeOut();
    },1500);
	let no_of_days = $('#noofDays').val()
	let food_remark = $('#food_remark').val()
	let main_remark = $('.remark_data').val()
	$.when(fetch_all_die_details()).then(function(){
		$.when(fetch_all_foods_to_be_avoided_details()).then(function(){
	//food_avoided_plan
    //diet_plan
	$.ajax({
		url:"action/appointment/add_consulted_data.php",
		type:"POST",
		data:{patient_id:patient_id,
			 food_avoided_plan:food_avoided_plan,
			  diet_plan:diet_plan,
			  no_of_days:no_of_days,
			  food_remark:food_remark,
			  main_remark:main_remark
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
                //$('.currentConsulting').fadeOut();
				//$('.consultingWindowTable').css('display','none')
				//$('.commentsPopup').css('display','none')
            //$('.nextBtn').removeClass('disableNextBtn');
            //$('.nextBtn').addClass('enableNextBtn');
            },2500);
            setTimeout(function(){
                $('#done').fadeOut();
                $('#text').fadeIn();
            },3000);
			setTimeout(function(){
               window.location.reload()
            },3200);
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
	let prev_btn_text = $('#prescription_data').text() 
	$('#prescription_data').text('Loading...')
	$('#prescription_data').attr('disabled',true)
		if(prev_btn_text == 'Update'){
		let medicine_details = $('.main_prescription_div').find('.medicine_details').val()
		let medicine_name = $('.main_prescription_div').find('.current').text()
		let quantity_data = $('.main_prescription_div').find('.quantity_data').val()
		let morning_data = $('.main_prescription_div').find('.morning_data').val()
		let noon_data = $('.main_prescription_div').find('.noon_data').val()
		let evening_data = $('.main_prescription_div').find('.evening_data').val()
		let no_days = $('.main_prescription_div').find('.no_days').val()
		let after_food = 0;
		let befor_food = 0;
		if($('.main_prescription_div').find('#afterFood').prop('checked') == true){
			after_food = 1
		}
		if($('.main_prescription_div').find('#beforeFood').prop('checked') == true){
			befor_food = 1
		}
		let ps_id = $('#prescription_data').attr('data-id')
		$.ajax({
			url:"action/prescription/update_prescription.php",
			type:"POST",
			data:{medicine_details:medicine_details,
				 medicine_name:medicine_name,
				  quantity_data:quantity_data,
				  morning_data:morning_data,
				  noon_data:noon_data,
				  evening_data:evening_data,
				  no_days:no_days,
				  after_food:after_food,
				  befor_food:befor_food,
				  ps_id:ps_id
				 },
			success:function(P_result_data){
				let P_result_data_json = jQuery.parseJSON(P_result_data)
				if(P_result_data_json[0]['status'] ==1){
				$('#prescription_data').css('background-color','blue')
				$('#prescription_data').text('Success')
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
				fetch_all_prescription_data(current_patient_uniqueid,url_val)
				fetch_all_prescription_data_history(current_patient_uniqueid)
				}else{
						$('.toasterMessage').text(P_result_data_json[0]['msg'])
						$('.errorTost').css('display','flex')
						$('.successTost').css('display','none')
						$('.toaster').addClass('toasterActive');
						setTimeout(function () {
							$('.toaster').removeClass('toasterActive');
						}, 2000)
						if(P_result_data_json[0]['status'] == 0){
						setTimeout(function () {
							window.location.href="../login.php";
						}, 2500)
						}
				}
			}
		})
	}else{
		
	 let appointment_id = url_val;
		console.log(appointment_id)
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
				fetch_all_prescription_data(current_patient_uniqueid,url_val)
			},1500)
			
		}
			}
		})

			
	})
		
	})
	}
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

function fetch_all_prescription_data(current_patient_uniqueid,appointment_id){
	
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription_history_edit.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid,
		 appointment_id:appointment_id
		 },
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		console.log(all_prescription_json)
		$('.prescriptionHistoryListMain_new').empty()
		if(all_prescription_json[0]['data_status'] == 1){
			$('.noDataSection_prescription').css('display','none')
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
		
				
			
			$('.prescriptionHistoryListMain_new').append(`<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">${all_prescription_json[x1]['date_time']}</div>
										<div class="prescriptionHistoryBtnArea">
											<button  class="prescriptionHistoryEditBtn" data-id="${all_prescription_json[x1]['id']}">
												<i class="uil uil-edit"></i>
											</button>
											<button class="prescriptionHistoryDeleteBtn" data-id="${all_prescription_json[x1]['id']}">
												<i class="uil uil-trash"></i>
											</button>
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
												<p>${all_prescription_json[x1]['time']} </p>
											</div>
										</div>
									</div>
								</div>`)
		}
		}else{
			//$('.prescriptionHistoryListMain').append(`No Data`)
			$('.prescriptionHistoryListMain_new').append(`
								<div class="noDataSection noDataSection_prescription">
									<div class="noDataSectionThumbnails">
										<img src="assets/images/empty.png">
									</div>
									<div class="noDataSectionContent">
										<p>No Data</p>
									</div>
								</div>
							`);
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
			console.log(result_data_json)
			$('.commentsPopupPreviousList_complaints dl').empty()
			if(result_data_json[0]['data_status'] !=0){
				
			for(let x=0;x<result_data_json.length;x++){
				let date = result_data_json[x]['added_date'];
				let date_details = result_data_json[x]['comment_data'];
				$('.commentsPopupPreviousList_complaints dl').append(`<dt class="PreviousListDate">
									<span>${date}</span>
								</dt>`)
				for(let x1=0;x1<date_details.length;x1++){
					$('.commentsPopupPreviousList_complaints dl').append(`<dd class="commentsPopupPreviousBox" data-id=${date_details[x1]['id']}>
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

function fetch_all_prescription_data_history(current_patient_uniqueid){
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid},
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		console.log(all_prescription_json)
		$('.prescriptionHistoryListMain_history').empty()
		if(all_prescription_json[0]['data_status'] == 1){
			$('.noDataSection_previous_priscription_history').css('display','none')
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
			let edit_btn = '';
			let delete_btn = '';
			if(all_prescription_json[0]['edit_del_status'] == 1){
				edit_btn = `<button  class="prescriptionHistoryEditBtn" data-id="${all_prescription_json[x1]['id']}">
												<i class="uil uil-edit"></i>
											</button>`;
				delete_btn = `<button class="prescriptionHistoryDeleteBtn" data-id="${all_prescription_json[x1]['id']}">
												<i class="uil uil-trash"></i>
											</button>`
			}
			$('.prescriptionHistoryListMain_history').append(`<div class="prescriptionHistoryListBox">
									<div class="prescriptionHistoryListBoxHead">
										<div class="prescriptionHistoryDate">${all_prescription_json[x1]['date_time']}</div>
										<div class="prescriptionHistoryBtnArea">
											${edit_btn}
											${delete_btn}
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
												<p>${all_prescription_json[x1]['time']} </p>
											</div>
										</div>
									</div>
								</div>`)
		}
		}else{
			//$('.prescriptionHistoryListMain').append(`No Data`)
			$('.prescriptionHistoryListMain_history').append(`
								<div class="noDataSection noDataSection_previous_priscription_history">
									<div class="noDataSectionThumbnails">
										<img src="assets/images/empty.png">
									</div>
									<div class="noDataSectionContent">
										<p>No Data</p>
									</div>
								</div>
							`);
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
	let data_id = $(this).attr('data-id')
	if(data_id == undefined){
		data_id = 0;
	}
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
			 patient_id:patient_id,
			  data_id:data_id
			 },
		success:function(result_data){
			console.log(result_data)
			$('.saveCommentsPopupBtn').text('Success')
			$('.saveCommentsPopupBtn').css('background-color','blue')
			setTimeout(function(){
				$('.saveCommentsPopupBtn').attr('disabled',false)
				$('.saveCommentsPopupBtn').text('Save')
				$('.saveCommentsPopupBtn').css('background-color','#557bfe')
				$('.note-editable').html('')
				fetch_allcomments(patient_id)
				$('.commentsTextarea_btn').attr('data-id',0)
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
					console.log(food_to_avoid.length)
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
						for( let xyf2 = 0; xyf2<food_to_avoid.length; xyf2++){
							//console.log(food_to_avoid[xyf2]['foods_avoid'])
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

fetch_all_medicine1()
function fetch_all_medicine1(){
	
	const api_data = {
		api:api
	}
fetch("https://jmwell.in/api/fetchAll_medicine.php",{
	method:"POST",
    header:{'Content-Type':'application/json'},
    body:JSON.stringify(api_data)
})
.then(response => response.json())
.then(data => {
	console.log(data)
	$('.medicine_details').empty()
	if(data[0]['status'] == 1){
	$('.medicine_details').append(`<option value=""></option>`)
		data.map((x) =>{
			const {product_name,product_id,stock} = x
			$('.medicine_details').append(`<option value="${product_id}">${product_name}</option>`)
		})
	}else{
		
	}
	})
.then(() => {
	create_custom_dropdowns()
})
}

let addmore_c = 0;
		let position_data = 0;
		//medicine add more 
		$('.addMoreBtn').click(function(){
			position_data++
			addmore_c++
			let api = 'de317f60c5d5182d99a2cf0fdc8f6175';
			let theParenrtEl = $('.tempPanelDiv');
			let theTemplate = `<div class="tempPanel prescription_data">
										<div class="formGroup">
											<label>Medicine</label>
											<div class="formSelect">
												<select name="" class="medicine_details">
												<option value=""></option>`;
												const api_data = {
													api:api
												}		
			
											fetch("https://jmwell.in/api/fetchAll_medicine.php",{
												method:"POST",
    											header:{'Content-Type':'application/json'},
    											body:JSON.stringify(api_data)																})
												.then(response => response.json())
												.then(data => {
																																			console.log(data)
														data.map((x) =>{
															const {product_name,product_id} = x
									theTemplate +=`<option value="${product_id}">${product_name}												</option>`;
														})
													})
			.then(() => {
												theTemplate +=`</select>
<span id="stock_error_msg" style="color:red"></span>
<input type="hidden" class="position" value=${position_data}>
											
											</div>
										</div>										
										<div class="formGroup3">
											<div class="checkBoxArea2">
												<label><i class="uil uil-sun"></i></label>
												<input type="text" class="morning_data">
											</div>
											<div class="checkBoxArea2">
												<label><i class="uil uil-sunset"></i></label>
												<input type="text" class="noon_data">
											</div>
											<div class="checkBoxArea2">
												<label><i class="uil uil-moon"></i></label>
												<input type="text" class="evening_data">
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No Of Days</label>
											<input type="text" class="no_days">
										</div>
										<!--<div class="formGroup formGroup2" style="margin-top: 20px;">
											<label>No.Of Days</label>
											<input type="text" class="no_days">
										</div>-->
										<div class="formGroup4">
											<div class="checkBoxArea">
												<label for="afterFood">After Food</label>
												<input type="radio" class="morning_data" id="afterFood" name="foodMed2${addmore_c}">
											</div>
											<div class="checkBoxArea">
												<label for="beforeFood">Before Food</label>
												<input type="radio" class="noon_data" id="beforeFood" name="foodMed2${addmore_c}">
											</div>
											<span id="type_error" style="color:red"></span>
										</div>
										<!--<div class="formGrouptextarea">
											<label>Chief History</label>
											<textarea class="remark_data"></textarea>
										</div>-->
										<div class="tempPanelBtnArea">
											<div class="removeMoreBtn">Remove</div>
										</div>
									</div>`;
			theParenrtEl.append(theTemplate)
			create_custom_dropdowns()
																																			})
			/**$('.dropdown-select ul').before('<div class="dd-search"><input id="txtSearchValue" autocomplete="off" onkeyup="filter()" class="dd-searchbox" type="text"></div>')**/
			
		})

$('body').delegate('.prescriptionHistoryEditBtn','click',function(){
	let prescription_id = $(this).attr('data-id')
	$.ajax({
		url:"action/prescription/fetch_prescription_details.php",
		type:"POST",
		data:{prescription_id:prescription_id},
		success:function(prescription_result){
			let prescription_result_json = jQuery.parseJSON(prescription_result)
			console.log(prescription_result_json)
			if(prescription_result_json[0]['status'] !=0){
				
				$('.tempPanelDiv').remove()
				$('.list ul li').each(function(){
					let medicine_val = $(this).attr('data-value')
					if(medicine_val == prescription_result_json[0]['medicine_id']){
					
						$('.tempPanelBtnArea').css('display','none')
						$('#prescription_data').text('Update')
						$('#prescription_data').attr('data-id',prescription_id)
						let medicine_name = $(this).text()
						$('.main_prescription_div .current').text(medicine_name)
						$('.main_prescription_div .medicine_details option[value="'+medicine_val+'"]').prop('selected', true)
						$('.main_prescription_div .morning_data').text(prescription_result_json[0]['morning_section'])
						$('.morning_data').val(prescription_result_json[0]['morning_section'])
						$('.noon_data').val(prescription_result_json[0]['noon_section'])
						$('.evening_data').val(prescription_result_json[0]['evening_section'])
						$('.no_days').val(prescription_result_json[0]['no_of_day'])
						if(prescription_result_json[0]['after_food'] == 1){
							$('#afterFood').prop('checked',true)
						}else if(prescription_result_json[0]['befor_food'] == 1){
							$('#beforeFood').prop('checked',true)
						}
						
					}else{
						
					 /**$('.toasterMessage').text('Medicine Is Not In The Pharmacy Right Now!')
						$('.errorTost').css('display','flex')
						$('.successTost').css('display','none')
						$('.toaster').addClass('toasterActive');
						setTimeout(function () {
							$('.toaster').removeClass('toasterActive');
						}, 3000)**/
					}
				})
			}else{
					$('.toasterMessage').text(prescription_result_json[0]['msg'])
						$('.errorTost').css('display','flex')
						$('.successTost').css('display','none')
						$('.toaster').addClass('toasterActive');
						setTimeout(function () {
							$('.toaster').removeClass('toasterActive');
						}, 2000)
						if(prescription_result_json[0]['status'] == 0){
						setTimeout(function () {
							window.location.href="../login.php";
						}, 2500)
			}
		}
	}
})
})

function update_position(appointment_id_data){
	$.ajax({
		url:"action/appointment/check_prescription_data.php",
		type:"POST",
		data:{appointment_id_data:appointment_id_data},
		success:function(prescription_result){
			console.log(prescription_result)
			$('.position').val(prescription_result)
			position_data = prescription_result
		}
	})
}

let prescription_id = 0
		$('body').delegate('.prescriptionHistoryDeleteBtn','click',function(){
			prescription_id = $(this).attr('data-id')
			$('.deleteAlert').fadeIn();
			$('.shimmer').fadeIn();
		});
$('.confirmdeleteAlert').click(function(){
			$.ajax({
				url:"action/prescription/delete_prescription.php",
				type:"POST",
				data:{prescription_id:prescription_id},
				success:function(p_details){
					$('.deleteAlert').fadeOut();
					$('.shimmer').fadeOut();
					let p_details_json = jQuery.parseJSON(p_details)
					let unique_id_data = p_details_json[0]['unique_id']
					console.log(unique_id_data)
					fetch_all_prescription_data(unique_id_data,url_val)
					fetch_all_prescription_data_history(unique_id_data)
				}
			})
			
		});

let dite_arr = ['Grain-Free Diet/Weight Management Diet','Low Protein Diet','Low Carb Diet','Wellness Diet'];
let food_arr = ['Milk, Milk with tea, Ice Cream','Wheat, Maida, Oats, Rava, Atta','Soy Products','Coffee','Tea','Sugar','Salt','Egg','Meat','Fish','Brinjal','Ladies Finger','Tomato'];
$.ajax({
	url:"action/appointment/fetch_dite_food_details.php",
	type:"POST",
	data:{url_val:url_val},
	success:function(food_result){
		let food_result_result = jQuery.parseJSON(food_result)
		console.log(food_result_result)
		let diet_no_of_days = food_result_result[0]['diet_no_of_days'];
		let dite = food_result_result[0]['dite'];
		let dite_remark = food_result_result[0]['dite_remark'];
		let food = food_result_result[0]['food'];
		let main_remark = food_result_result[0]['main_remark'];
		if(diet_no_of_days !=0){
		   	$('#noofDays').val(diet_no_of_days)
		   }
		$('#food_remark').val(dite_remark)
		$('.remark_data').val(main_remark)
		let food_len = '';
		if(dite[0]['dite_data_status'] != 0){
		for(let x1=0;x1<dite_arr.length;x1++){
			   //dite_data_status
				//console.log("main "+dite_arr[x1])
				$.when(set_arry(dite)).then(function(dite_data_arr){
					food_len = dite_arr.length
					console.log(dite_data_arr)
				if(dite_data_arr.includes(dite_arr[x1])){
					$('.dite_details ul').append(`<li>
									<input type="checkbox" id="diet${x1}" value="${dite_arr[x1]}" class="dite_details" checked>
      								<label for="diet${x1}">${dite_arr[x1]}</label>
								</li>`)
				}else{
					$('.dite_details ul').append(`<li>
									<input type="checkbox" id="diet${x1}" value="${dite_arr[x1]}" class="dite_details">
      								<label for="diet${x1}">${dite_arr[x1]}</label>
								</li>`)
				}
					})
		}
			}else{
				for(let x1=0;x1<dite_arr.length;x1++){
					$('.dite_details ul').append(`<li>
									<input type="checkbox" id="diet${x1}" value="${dite_arr[x1]}" class="dite_details">
      								<label for="diet${x1}">${dite_arr[x1]}</label>
								</li>`)
	
		}
			}
		
		if(food[0]['food_data_status'] !=0){
			$.when(set_arry1(food)).then(function(food_data_arr){
				
				for(let y=0;y<food_arr.length;y++){
					food_len++;
					console.log(food_arr[y])
					if(food_data_arr.includes(food_arr[y])){
						$('.food_details ul').append(`<li>
									<input type="checkbox" id="diet${food_len}" class="food_avoided" value="${food_arr[y]}" checked>
      								<label for="diet${food_len}">${food_arr[y]}</label>
								</li>`)
					}else{
						$('.food_details ul').append(`<li>
									<input type="checkbox" id="diet${food_len}" class="food_avoided" value="${food_arr[y]}">
      								<label for="diet${food_len}">${food_arr[y]}</label>
								</li>`)
					}
				}
			})
		}else{
			for(let y=0;y<food_arr.length;y++){
					food_len++;
						$('.food_details ul').append(`<li>
									<input type="checkbox" id="diet${food_len}" class="food_avoided" value="${food_arr[y]}">
      								<label for="diet${food_len}">${food_arr[y]}</label>
								</li>`)
					
				}
		}
	}
})

$('body').delegate('.commentsPopupPreviousBox','click',function(){
	if($(this).text() != ''){
		$('.note-placeholder').text(' ')
		$('.note-editable').text($(this).text())
		let comment_id = $(this).attr('data-id')
		$('.commentsTextarea_btn').attr('data-id',comment_id)
	}else{
		$('.note-placeholder').text('Type here...')
	}
})

function set_arry(dite){
	let data_arr = [];
	for(let x=0;x<dite.length;x++){
		data_arr.push(dite[x]['dite_data'])
	}
	return data_arr
}
function set_arry1(dite){
	let data_arr = [];
	for(let x=0;x<dite.length;x++){
		data_arr.push(dite[x]['food_data'])
	}
	return data_arr	
}