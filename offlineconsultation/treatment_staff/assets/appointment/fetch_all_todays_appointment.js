let fun_exe = 0;
var next_btn_class = 'enableNextBtn';
let search_data = '';
let diet_plan = [];
let food_avoided_plan = [];
let appointment_data = 0;
var patient_id_data = 0;
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
//fetch_doctor_profile_data()
/*function fetch_doctor_profile_data(){
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
}*/
$('.all_appointment').click(function(){
	if($(this).prop('checked') == true){
		appointment_data = 1;
			$.when(update_session(appointment_data)).then(function(result_data){
				console.log(result_data)
				fetch_all_todays_appointments()
			})
		//$('.consultAppointmentListTableBody table thead tr').append(`<th>Doctor Name</th>`)
	}else{
		appointment_data = 0;
			$.when(update_session(appointment_data)).then(function(result_data){
				console.log(result_data)
				fetch_all_todays_appointments()
			})
	}

	
})
function update_session(appointment_data){
	return $.ajax({
		url:"action/update_session_val.php",
		type:"POST",
		data:{appointment_data:appointment_data},
		
	})
}
$.when(check_appointment_status()).then(function(result){
	console.log(result)
	appointment_data = result;
	if(appointment_data == 1){
		$('.all_appointment').attr('checked',true)
		
	}else{
		
		$('.all_appointment').attr('checked',false)
	}
	fetch_all_todays_appointments();
})


function check_appointment_status(){
	return $.ajax({
		url:"action/check_appointment_status.php",
	})
}

//setInterval(fetch_all_todays_appointments, 1000);
let appointment_id = 0;
function fetch_all_todays_appointments(){
	$('.allprev_appointments').empty();
	$('.allprev_appointments_waiting').empty()
	$.ajax({
		url:"action/appointment/fetch_all_todays_appointments_data.php",
		type:"POST",
		data:{search_data:search_data,
			 appointment_data:appointment_data,
			 },
		success:function(result_data){
			//console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			//if(result_data_json.length !=0){
			console.log(result_data_json)
			if(result_data_json[0]['data_status'] !=0){
			if(result_data_json.length !=0){
			   $('.all_pending_appointments_else').css('display','none')
			let si_no = 0;
				$('.currentConsulting_patient').css('display','none')
				$('.consultingWindowTable').css('display','none')
				$('.commentsPopup').css('display','none')
				if(result_data_json[0]['data_status']){
			for(let x=0;x<result_data_json.length;x++){
				
				
				
				si_no++
				let active = "";
				
				//commentsPopup
				if(result_data_json[x]['active'] == 1){
					
					$('.patient_history').attr('href','patients-profile.php?patient_id='+result_data_json[x]['patient_id']);
						active = "active_table_data";
						$('.currentConsulting_patient').css('display','flex')
						$('.consultingWindowTable').css('display','flex')
						
						$('.commentsPopup').css('display','block')
						$('.currentConsulting').css('display','flex')
						$('#current_patient_name').text(result_data_json[x]['name'])
						$('#current_patient_uniqueid').text(result_data_json[x]['unique_id'])
						$('#current_patient_phn').text(": "+result_data_json[x]['phone'])
						$('#current_patient_email').text(": "+result_data_json[x]['email'])
						$('#current_patient_age').text(": "+result_data_json[x]['age'])
						$('#current_patient_gender').text(": "+result_data_json[x]['gender'])
						$('#current_patient_address').text(": "+result_data_json[x]['address'])
						$('#allergies_if_any').text(": "+result_data_json[x]['allergies_if_any'])
						$('#current_medication').text(": "+result_data_json[x]['current_medication'])
						$('#any_metal_Implantation').text(": "+result_data_json[x]['any_metal_Implantation'])
						if(result_data_json[x]['first_visit'] == ''){
							$('#dofv').text('No Data')
						}else{
							$('#dofv').text(" "+result_data_json[x]['first_visit'])
						}
						
					$('#age_details').text('Age : '+result_data_json[x]['age']+', '+result_data_json[x]['gender']+','+result_data_json[x]['phone'])
						$('#current_patient_place').text(": "+result_data_json[x]['place'])
					if(result_data_json[x]['to'] == 0){
						$('.currentConsultingKeepWaitBtn').css('display','none')
					}else{
						$('.currentConsultingKeepWaitBtn').css('display','flex')
					}
						$('.currentConsultingKeepWaitBtn').attr('data-id',result_data_json[x]['id'])
					if(result_data_json[x]['present_Illness'] != ''){
								$('#present_Illness').text(": "+result_data_json[x]['present_Illness'])
							}else{
								$('#present_Illness').text(": No Data")
							}
						$('.consultedBtn').attr('data-id',result_data_json[x]['id'])
						$('.formGroupFileSaveBtn').attr('data-id',result_data_json[x]['id'])
						$('.formGroupFileSaveBtn').attr('branch_id',result_data_json[x]['branch'])
						$('.print_enable').attr('apmnt',result_data_json[x]['id'])
					$('.currentConsultingheadPrintBtn').attr('data-id',result_data_json[x]['id'])
						//fetch_all_prescription_data(result_data_json[x]['unique_id'])
					    //fetch_all_lab_reports(result_data_json[x]['patient_id'])
						//fetch_all_prescription_data_history(result_data_json[x]['unique_id'])
						//fetch_allcomments(result_data_json[x]['unique_id'])
						//fetch_allmedical(result_data_json[x]['unique_id'])
						//fetch_allsurgical(result_data_json[x]['unique_id'])
						//fetch_all_previous(result_data_json[x]['patient_id'])
						fetch_all_previous_treatment(result_data_json[x]['patient_id'],result_data_json[x]['branch'])
						fetch_all_previous_treatment_of_appointment(result_data_json[x]['id'],result_data_json[x]['branch'])
				           	print_enable(result_data_json[x]['id'])
					     $('.print_enable').attr('apmnt',result_data_json[x]['id'])
						patient_id_data = result_data_json[x]['patient_id']
						appointment_id = result_data_json[x]['id']
					$('.consultingWindowTable table tbody').empty()
					$('.currentConsulting').fadeIn();
					if(result_data_json[x]['BMI'] != undefined){
						$('.noDataSection_bmi_val').css('display','none')
					let bmi_si_no = 0;
						let bmi_val_class = '';
						let bmi_weight_cat = '';
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
						//$('.consultingWindowTable table tbody').append(`No Data`);
						$('.consultingWindowTable').append(`
								<div class="noDataSection noDataSection_bmi_val">
									<div class="noDataSectionThumbnails">
										<img src="assets/images/empty.png">
									</div>
									<div class="noDataSectionContent">
										<p>No Data</p>
									</div>
								</div>
							`);
					}
            			
						//$('.nextBtn').addClass('enableNextBtn');
            			//$('.nextBtn').removeClass('enableNextBtn');
						$('.currentConsultingKeepWaitBtn').css('display','flex')
				}
				$('.allprev_appointments').append(`<tr class="${active}">
                                                    <td data-label="Sl No">
                                                        <p>${si_no}</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>${result_data_json[x]['unique_id']}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>${result_data_json[x]['name']}</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>${result_data_json[x]['phone']}</p>
                                                    </td>
                                                    <td data-label="Address">
                                                        <p>${result_data_json[x]['address']}</p>
                                                    </td>
													<td data-label="Address">
                                                        <p>${result_data_json[x]['doctor_name']}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <div class="keepWaitBtn" data-id=${result_data_json[x]['id']}>Keep Wait</div>
                                                            <div class="nextBtn ${next_btn_class}" data-id=${result_data_json[x]['id']}>Next</div>
                                                        </div>
                                                    </td>
                                                </tr>`)
			}
}else{
	
}
}else{
	$('.all_pending_appointments_else').css('display','flex')
}
}else{
	$('.all_pending_appointments_else').css('display','flex')
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
			$('.secound_consultingNextBtn').removeClass('button_disabled_status');
			$('.secound_consultingNextBtn').addClass('button_enable_status');
			$('.secound_consultingNextBtn').prop('disabled',false)
			$('.currentConsultingheadPrintBtn').css('display','none')
			
			let data_id=$(this).attr('data-id')
			$(this).parent().parent().parent().fadeOut();
			$('.consultingWindowTable').css('display','none')
			$('.commentsPopup').css('display','none')
			//$('.nextBtn').removeClass('disableNextBtn');
            //$('.nextBtn').addClass('enableNextBtn');
			$('.allprev_appointments').children('tr:first').remove();
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
						$('.errorTost').css('display','flex')
						$('.successTost').css('display','none')
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
					$('.dite_details').prop('checked', false)
					$('.food_avoided').prop('checked', false)
					let update_result_json = jQuery.parseJSON(update_result);
					if(update_result_json[0]['status'] !=0){
						fetch_all_todays_appointments()
					}else{
						that.text('Keep Wait')
						$('.toasterMessage').text(update_result_json[0]['msg'])
						$('.errorTost').css('display','flex')
						$('.successTost').css('display','none')
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
        $("body").delegate(".button_enable_status", "click", function() {
			$('#done').fadeOut();
			$('#text').fadeIn();
			$('.consultedBtn').prop('disabled',false)
			$('.secound_consultingNextBtn').removeClass('button_enable_status')
			$('.secound_consultingNextBtn').addClass('button_disabled_status')
			$('.secound_consultingNextBtn').prop('disabled',true)
			$('.currentConsultingheadPrintBtn').css('display','none')
			$('.currentConsultingKeepWaitBtn').prop('disabled',false)
			$('.currentConsultingKeepWaitBtn').removeClass('button_disable_watting')
			//$(this).parent().parent().parent().fadeOut();
			$('.allprev_appointments ').children('tr:first').remove();
			let secound_tr = $('.allprev_appointments tr').eq(0)
			let appointment_id = $(this).attr('data-id')
			console.log(secound_tr.find('#name p').text())
			if(secound_tr.find('#name p').text() == ''){
				$('.consultingWindowNextSextionBox').css('display','none')
				//$('.all_pending_appointments_else').css('display','flex')
			}else{
				$('.consultingWindowNextSextionBox').css('display','flex')
				$('#secound_staff_name').text(secound_tr.find('#name p').text())
				$('.secound_consultingNextBtn').attr('data-id',secound_tr.find('#name p').attr('data-id'))
				$('.all_pending_appointments_else').css('display','none')
			}
			
			
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
						$('#allergies_if_any').text(": "+appointment_result_json[x]['allergies_if_any'])
						$('#current_medication').text(": "+appointment_result_json[x]['current_medication'])
						$('#any_metal_Implantation').text(": "+appointment_result_json[x]['any_metal_Implantation'])
					$('#age_details').text('Age : '+appointment_result_json[x]['age']+', '+appointment_result_json[x]['gender']+','+appointment_result_json[x]['phone'])
						$('#current_patient_place').text(": "+appointment_result_json[x]['place'])
						$('.currentConsultingKeepWaitBtn').attr('data-id',appointment_result_json[x]['id'])
						$('.consultedBtn').attr('data-id',appointment_result_json[x]['id'])
						$('.print_enable').attr('apmnt',appointment_result_json[x]['id'])
					$('.currentConsultingheadPrintBtn').attr('data-id',appointment_result_json[x]['id'])
					if(appointment_result_json[x]['first_visit'] == ''){
							$('#dofv').text('No Data')
						}else{
							$('#dofv').text(" "+appointment_result_json[x]['first_visit'])
						}
					if(appointment_result_json[x]['present_Illness'] != ''){
								$('#present_Illness').text(": "+appointment_result_json[x]['present_Illness'])
							}else{
								$('#present_Illness').text(": No Data")
							}
						fetch_all_prescription_data(appointment_result_json[x]['unique_id'])
						fetch_all_prescription_data_history(appointment_result_json[x]['unique_id'])
						fetch_allcomments(appointment_result_json[x]['unique_id'])
						fetch_allmedical(appointment_result_json[x]['unique_id'])
						fetch_allsurgical(appointment_result_json[x]['unique_id'])
						fetch_all_lab_reports(appointment_result_json[x]['patient_id'])
						fetch_all_previous(appointment_result_json[x]['patient_id'])
						fetch_all_previous_treatment(appointment_result_json[x]['patient_id'])
						patient_id_data = result_data_json[x]['patient_id']
						print_enable(appointment_result_json[x]['id'])
					$('.consultingWindowTable table tbody').empty()
					$('.currentConsulting').fadeIn();
					if(appointment_result_json[x]['BMI'] != undefined){
						$('.noDataSection_bmi_val').css('display','none')
					let bmi_si_no = 0;
						let bmi_val_class = '';
						let bmi_weight_cat = '';
						for(let bmi_val = 0;bmi_val<appointment_result_json[x]['BMI'].length;bmi_val++){
							
							if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] < 18.5){
								bmi_weight_cat = 'UnderWeight';
								bmi_val_class = '';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=18.5 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 24.9){
								bmi_weight_cat = 'Healthy Weight';
								bmi_val_class = 'bmiColor1_G';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 25 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <=29.9){
								bmi_weight_cat = 'OverWeight';
								bmi_val_class = 'bmiColor2_Y';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=30 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 34.9){
								bmi_weight_cat = 'Obese (Class1)';
								bmi_val_class = 'bmiColor3_O';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 35 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 39.9){
								bmi_weight_cat = 'Severely Obese (Class11)';
								bmi_val_class = 'bmiColor4_P';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 40 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 49.9){
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
										<td data-label="Weight">
											<p>${appointment_result_json[x]['BMI'][bmi_val]['blood_pressure']}</p>
										</td>
										<td data-label="Category">
											<p>${bmi_weight_cat}</p>
										</td>
									</tr>`)
						}
					}else{
						//$('.consultingWindowTable table tbody').append(`No Data`);
						$('.consultingWindowTable').append(`
								<div class="noDataSection noDataSection_bmi_val">
									<div class="noDataSectionThumbnails">
										<img src="assets/images/empty.png">
									</div>
									<div class="noDataSectionContent">
										<p>No Data</p>
									</div>
								</div>
							`);
					}
            			
						$('.nextBtn').addClass('disableNextBtn');
            			$('.nextBtn').removeClass('enableNextBtn');
						$('.currentConsultingKeepWaitBtn').css('display','flex')
				}
			})
            
        });


// next appointment 
        $("body").delegate(".enableNextBtn", "click", function() {
			$('#done').fadeOut();
			$('#text').fadeIn();
			$('.consultedBtn').prop('disabled',false)
			$('.consultedBtn').addClass('active_btn')
			$('#done').removeClass('active_btn')
			$('.formTagArea').empty()
			$('#treatment_btn').attr('disabled',true)
			$('.allprev_appointments tr').removeClass('active_table_data')
			$(this).parent().parent().parent().addClass('active_table_data')
			$('.secound_consultingNextBtn').removeClass('button_enable_status')
			$('.secound_consultingNextBtn').addClass('button_disabled_status')
			$('.secound_consultingNextBtn').prop('disabled',true)
			$('.currentConsultingheadPrintBtn').css('display','none')
			$('.currentConsultingKeepWaitBtn').prop('disabled',false)
			$('.currentConsultingKeepWaitBtn').removeClass('button_disable_watting')
			
			//$(this).parent().parent().parent().remove();
			let appointment_id = $(this).attr('data-id')
			let secound_tr = $('.allprev_appointments tr').eq(0)
			console.log(secound_tr.find('#name p').text())
			if(secound_tr.find('#name p').text() == ''){
				$('.consultingWindowNextSextionBox').css('display','none')
				//$('.all_pending_appointments_else').css('display','flex')
			}else{
				$('.consultingWindowNextSextionBox').css('display','flex')
				$('#secound_staff_name').text(secound_tr.find('#name p').text())
				$('.secound_consultingNextBtn').attr('data-id',secound_tr.find('#name p').attr('data-id'))
				$('.all_pending_appointments_else').css('display','none')
			}
			
			$.ajax({
				url:"action/appointment/fetch_appointment_data.php",
				type:"POST",
				data:{appointment_id:appointment_id},
				success:function(appointment_result){
					window.scrollTo({top: 0, behavior: 'smooth'});
					let appointment_result_json = jQuery.parseJSON(appointment_result)
					//console.log(appointment_result_json)
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
					$('#allergies_if_any').text(": "+appointment_result_json[x]['allergies_if_any'])
						$('#current_medication').text(": "+appointment_result_json[x]['current_medication'])
						$('#any_metal_Implantation').text(": "+appointment_result_json[x]['any_metal_Implantation'])
					$('#age_details').text('Age : '+appointment_result_json[x]['age']+', '+appointment_result_json[x]['gender']+','+appointment_result_json[x]['phone'])
						$('#current_patient_place').text(": "+appointment_result_json[x]['place'])
					if(appointment_result_json[x]['first_visit'] == ''){
							$('#dofv').text('No Data')
						}else{
							$('#dofv').text(" "+appointment_result_json[x]['first_visit'])
						}
					if(appointment_result_json[x]['to'] == 0){
						$('.currentConsultingKeepWaitBtn').css('display','none')
					}else{
						$('.currentConsultingKeepWaitBtn').css('display','flex')
					}
						$('.currentConsultingKeepWaitBtn').attr('data-id',appointment_result_json[x]['id'])
					if(appointment_result_json[x]['present_Illness'] != ''){
								$('#present_Illness').text(": "+appointment_result_json[x]['present_Illness'])
							}else{
								$('#present_Illness').text(": No Data")
							}
						$('.consultedBtn').attr('data-id',appointment_result_json[x]['id'])
						$('.print_enable').attr('apmnt',appointment_result_json[x]['id'])
					$('.patient_history').attr('href','patients-profile.php?patient_id='+appointment_result_json[x]['patient_id']);
					
					$('.currentConsultingheadPrintBtn').attr('data-id',appointment_result_json[x]['id'])
						//fetch_all_prescription_data(appointment_result_json[x]['unique_id'])
						//fetch_all_prescription_data_history(appointment_result_json[x]['unique_id'])
						//fetch_allcomments(appointment_result_json[x]['unique_id'])
						//fetch_allmedical(appointment_result_json[x]['unique_id'])
						//fetch_allsurgical(appointment_result_json[x]['unique_id'])
						//fetch_all_lab_reports(appointment_result_json[x]['patient_id'])
						fetch_all_previous(appointment_result_json[x]['patient_id'],appointment_result_json[x]['branch_id'])
						fetch_all_previous_treatment(appointment_result_json[x]['patient_id'],appointment_result_json[x]['branch_id'])
					fetch_all_previous_treatment_of_appointment(appointment_result_json[x]['id'],appointment_result_json[x]['branch_id'])
						patient_id_data = appointment_result_json[x]['patient_id']
						print_enable(appointment_result_json[x]['id'])
					$('.consultingWindowTable table tbody').empty()
					$('.currentConsulting').fadeIn();
					if(appointment_result_json[x]['BMI'] != undefined){
						$('.noDataSection_bmi_val').css('display','none')
					let bmi_si_no = 0;
						let bmi_val_class = '';
						let bmi_weight_cat = '';
						for(let bmi_val = 0;bmi_val<appointment_result_json[x]['BMI'].length;bmi_val++){
							
							if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] < 18.5){
								bmi_weight_cat = 'UnderWeight';
								bmi_val_class = '';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=18.5 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 24.9){
								bmi_weight_cat = 'Healthy Weight';
								bmi_val_class = 'bmiColor1_G';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 25 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <=29.9){
								bmi_weight_cat = 'OverWeight';
								bmi_val_class = 'bmiColor2_Y';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >=30 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 34.9){
								bmi_weight_cat = 'Obese (Class1)';
								bmi_val_class = 'bmiColor3_O';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 35 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 39.9){
								bmi_weight_cat = 'Severely Obese (Class11)';
								bmi_val_class = 'bmiColor4_P';
							}else if(appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] >= 40 && appointment_result_json[x]['BMI'][bmi_val]['BMIVal'] <= 49.9){
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
										<td data-label="Weight">
											<p>${appointment_result_json[x]['BMI'][bmi_val]['blood_pressure']}</p>
										</td>
										<td data-label="Category">
											<p>${bmi_weight_cat}</p>
										</td>
									</tr>`)
						}
					}else{
						//$('.consultingWindowTable table tbody').append(`No Data`);
						$('.consultingWindowTable').append(`
								<div class="noDataSection noDataSection_bmi_val">
									<div class="noDataSectionThumbnails">
										<img src="assets/images/empty.png">
									</div>
									<div class="noDataSectionContent">
										<p>No Data</p>
									</div>
								</div>
							`);
					}
            			
						//$('.nextBtn').addClass('enableNextBtn');
            			//$('.nextBtn').removeClass('enableNextBtn');
						$('.currentConsultingKeepWaitBtn').css('display','flex')
				}
			})
            
        });

//consulted button click
$('body').delegate('.consultedBtn','click',function(e){
	let patient_id = $(this).attr('data-id')
	let button_test = $('.active_btn').text().trim()
	if(button_test == 'Done'){
		$('.currentConsulting_patient').css('display','none')
		$('.consultingWindowTable').css('display','none')
		$('.commentsPopup').css('display','none')
		$('.consult_btn').removeClass('active_btn')
		$('#text').addClass('active_btn')
		$('.active_table_data').remove()
	}else{
	//console.log(button_test)
	e.preventDefault();
    $('#text').fadeOut();
	$('.consultedBtn').prop('disabled',true)
	$('.currentConsultingKeepWaitBtn').prop('disabled',true)
	$('.currentConsultingheadPrintBtn').css('display','none')
	$('.currentConsultingKeepWaitBtn').addClass('button_disable_watting')
    setTimeout(function(){
        $('#loading').fadeIn();
    },500);
    setTimeout(function(){
        $('#loading').fadeOut();
    },1500);
	//$.when(fetch_all_lab_details(patient_id)).then(function(){
	//$.when(fetch_all_treatment_details(patient_id)).then(function(){
	//$.when(fetch_all_die_details()).then(function(){
		//$.when(fetch_all_foods_to_be_avoided_details()).then(function(){
			//console.log(food_avoided_plan)
			//let no_of_days = $('#noofDays').val()
			//let food_remark = $('#food_remark').val()
			//let main_remark = $('.remark_data').val()
	//food_avoided_plan
    //diet_plan
	$.ajax({
		url:"action/appointment/complete_treatment_data.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(counsulted_result){
			let counsulted_result_json = jQuery.parseJSON(counsulted_result)
			if(counsulted_result_json[0]['status'] == 1){
				
					
				
			setTimeout(function(){
               $('#done').fadeIn();
				$('.consult_btn').removeClass('active_btn')
				$('#done').addClass('active_btn')
				$('.currentConsultingheadPrintBtn').css('display','flex');
				$('.active_table_data').find('.tableBtnArea').remove()
				
            },2000);
            setTimeout(function(){
               // $('.currentConsulting').fadeOut();
				//$('.consultingWindowTable').css('display','none')
				//$('.commentsPopup').css('display','none')
				$('.currentConsultingKeepWaitBtn').css('display','none')
				$('.secound_consultingNextBtn').prop('disabled',false)
				$('.secound_consultingNextBtn').removeClass('button_disabled_status');
				$('.secound_consultingNextBtn').addClass('button_enable_status');
            $('.nextBtn').removeClass('disableNextBtn');
            $('.nextBtn').addClass('enableNextBtn');
				$('.consultedBtn').prop('disabled',false)
            },2500);
            setTimeout(function(){
               // $('#done').fadeOut();
                //$('#text').fadeIn();
				//$('.dite_details').prop('checked', false)
				//$('.food_avoided').prop('checked', false)
				$('.all_waiting_appointments_else').css('display','flex')
            },3000);
			}else{
				window.location.href="../login.html"
			}
		}
	})
		//})
	//})
		//})
	//})
	}
	
})
let api = "de317f60c5d5182d99a2cf0fdc8f6175";
fetch_all_medicine()
function fetch_all_medicine(){
	const api_data = {
		api:api
	}
fetch("../../api/fetchAll_medicine.php",{
	method:"POST",
    header:{'Content-Type':'application/json'},
    body:JSON.stringify(api_data)
})
.then(response => response.json())
.then(data => {
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

$('body').delegate('.medicine_details','change',function(){
	let that = $(this)
	let product_id = $(this).val()
	let Productnopill_id = $(this).parent().parent().parent().find('.Productnopill_id').val()
	const stock_check_data = {
		product_id:product_id,
		api:api,
		Productnopill_id:Productnopill_id
	}
	fetch("../../api/check_medicine_stock.php",{
			method:"POST",
    		header:{'Content-Type':'application/json'},
    		body:JSON.stringify(stock_check_data)
	})
	.then(response_arr => response_arr.json())
	.then(data =>{
		if(data[0]['status'] == 1){
			if(data[0]['stock'] == 0){
				that.parent().find('#stock_error_msg').text('*Out of Stock!')
			}else{
				that.parent().find('#stock_error_msg').text('')
			}
		}
	})
})


$('#prescription_data_form').submit(function(e){
	e.preventDefault()
	
	if($('.main_prescription_div').find('.medicine_details').val().trim() != '' && $('.main_prescription_div').find('.no_days').val().trim() != '' && $('.main_prescription_div').find('.current').text().trim() != ''){
	$('#medicine_error').text(' ')
	$('#quantity_error').text(' ')
	$('#noof_error').text(' ')
	$('#stock_error_msg').text(' ')
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
		if($('.main_prescription_div').find('.afterFood').prop('checked') == true){
			after_food = 1
		}
		if($('.main_prescription_div').find('.beforeFood').prop('checked') == true){
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
				//$('.main_prescription_div').find('.no_days').val('')
				$('.main_prescription_div').find('.remark_data').val('')
				$('.main_prescription_div').find('.current').text('')
				$('#prescription_data').text('Save')
				$('#prescription_data').css('background-color','#557bfe')
				$('#prescription_data').attr('disabled',false)
				let current_patient_uniqueid = $('#current_patient_uniqueid').text()
				fetch_all_prescription_data(current_patient_uniqueid)
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
		let position = $(this).find('.position').val()
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
		if($(this).find('.afterFood').prop('checked') == true){
			after_food = 1
		}
		if($(this).find('.beforeFood').prop('checked') == true){
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
				  befor_food:befor_food,
				  position:position,
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
				fetch_all_prescription_data_history(current_patient_uniqueid)
				update_position(appointment_id)
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
	/*if($('.main_prescription_div').find('.medicine_details').val().trim() != ''){}else{
		$('#medicine_error').text('*Required!')
	}
	if($('.main_prescription_div').find('.current').text().trim() != ''){}else{
		$('#quantity_error').text('*Required!')
	}
	if($('.main_prescription_div').find('.no_days').val().trim() != ''){}else{
		$('#noof_error').text('*Required!')
	}*/
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

/*function fetch_all_prescription_data(current_patient_uniqueid){
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid},
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		$('.prescriptionHistory table tbody').empty()
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
			$('.prescriptionHistory table tbody').append(`<tr>
										<td>${all_prescription_json[x1]['medicine_name']}</td>
										<td>${all_prescription_json[x1]['morning_section']}</td>
										<td>${all_prescription_json[x1]['noon_section']}</td>
										<td>${all_prescription_json[x1]['evening_section']}</td>
										<td>${all_prescription_json[x1]['no_of_day']}</td>
										<td>${all_prescription_json[x1]['time']}</td>
										<td>${all_prescription_json[x1]['date_time']}</td>
									</tr>`)
		}
		}else{
			//$('.prescriptionHistory table tbody').append(`No Data`)
			$('.prescriptionHistory').append(`
								<div class="noDataSection">
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
}*/
function fetch_all_prescription_data(current_patient_uniqueid){
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription_history.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid},
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		//console.log(all_prescription_json)
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
			$('.prescriptionHistoryListMain_new').append(`<div class="prescriptionHistoryListBox">
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

function fetch_all_prescription_data_history(current_patient_uniqueid){
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid},
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		//console.log(all_prescription_json)
		$('.prescriptionHistoryListMain_history').empty()
		if(all_prescription_json[0]['data_status'] == 1){
			$('.noDataSection_prescription_history').css('display','none')
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
								<div class="noDataSection noDataSection_prescription_history">
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

$('body').delegate('.prescriptionHistoryEditBtn','click',function(){
	let prescription_id = $(this).attr('data-id')
	$('#stock_error_msg').text(' ')


	$.ajax({
		url:"action/prescription/fetch_prescription_details.php",
		type:"POST",
		data:{prescription_id:prescription_id},
		success:function(prescription_result){
			let prescription_result_json = jQuery.parseJSON(prescription_result)
			//console.log(prescription_result_json)
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

function fetch_allcomments(patient_id){
	$.ajax({
		url:"action/prescription/fetch_all_comments.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data);
			//$('.commentsPopupPreviousList_complaints').empty()
			//console.log(result_data_json)
			$('.commentsPopupPreviousList_complaints dl').empty()
			if(result_data_json[0]['data_status'] !=0){
				
				$('.noDataSection_allcomments').css('display','none')
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
				//$('.commentsPopupPreviousList_complaints dl').append(`No Data`)
				$('.commentsPopupPreviousList_complaints dl').empty()
				$('.commentsPopupPreviousList_complaints dl').append(`
								<div class="noDataSection noDataSection_allcomments">
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
				$('.noDataSection_medical_history').css('display','none')
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
				$('.commentsPopupPreviousList_medical dl').empty()
				//$('.commentsPopupPreviousList_medical dl').append(`No Data`)
				$('.commentsPopupPreviousList_medical dl').append(`
								<div class="noDataSection noDataSection_medical_history">
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

function fetch_allsurgical(patient_id){
	$.ajax({
		url:"action/prescription/fetch_all_surgical.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data);
			$('.commentsPopupPreviousList_surgical dl').empty()
			if(result_data_json[0]['data_status'] !=0){
				$('.noDataSection_surgical_history').css('display','none')
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
				//$('.commentsPopupPreviousList_surgical dl').append(`No Data`)
				$('.commentsPopupPreviousList_surgical dl').append(`
								<div class="noDataSection noDataSection_surgical_history">
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

$('.commentsTextarea_btn').click(function(e){
	e.preventDefault()
	//let commentsTextarea = $('.commentsTextarea_data .note-editable').html()
	//let commentsTextarea = $('#textAreaId').val()
	let commentsTextarea = divide()
	//console.log(commentsTextarea)
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
			//console.log(result_data)
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
	if(medicalTextarea != '<p><br></p>'){
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
			//console.log(result_data)
		}
		
	})
	}
})
$('.surgicalTextarea_btn').click(function(e){
	e.preventDefault()
	let commentsTextarea = $('.surgicalTextarea_data .note-editable').html()
	//console.log(commentsTextarea)
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
			//console.log(result_data)
		}
		
	})
	}
})
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
					//console.log(unique_id_data)
					fetch_all_prescription_data(unique_id_data)
					fetch_all_prescription_data_history(unique_id_data)
				}
			})
			
		});
		$('.closedeleteAlert').click(function(){
			$('.deleteAlert').fadeOut();
			$('.shimmer').fadeOut();
		})

$('.currentConsultingheadPrintBtn').click(function(e){
	e.preventDefault()
	$('.currentConsultingheadPrintBtn').empty()
		$('.currentConsultingheadPrintBtn').append(`<i class="uil uil-print"></i> Loading...`)
		let appointment_id = $(this).attr('data-id')
	$.ajax({
		url:"action/appointment/fetch_appointment_details_print.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			//console.log(result_data_json)
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
				if(result_data_json[0]['comment_data'] != undefined){
				let complaint_data = result_data_json[0]['comment_data']
			
				
					$('.complaints_data_print').empty()
					$('.complaints_data_print').append(`<h2>Complaints</h2>`)
				for(let xy = 0; xy<complaint_data.length;xy++){
					//console.log(complaint_data[xy]['comment'])
				$('.complaints_data_print').append(`<p>${complaint_data[xy]['comment']}</p>`)
				}
				}
				
				
					let medical_data = result_data_json[0]['medical_data']
					if(medical_data != undefined){
						$('.medical_history_print').empty()
						$('.medical_history_print').append(`<h2>Investigations</h2>`)
					for( let xy2=0 ; xy2<medical_data.length; xy2++){
					$('.medical_history_print').append(`<p>${medical_data[xy2]['comment']}</p>`)
					}
				}
					
					let surgical_data = result_data_json[0]['surgical_data']
					if(surgical_data != undefined){
						$('.Investigations_data').empty()
						$('.Investigations_data').append(`<h2>Investigations</h2>`)
					for( let xy1 = 0; xy1<surgical_data.length; xy1++){
						$('.Investigations_data').append(`<p>${surgical_data[xy1]['comment']}</p>`)
					}
				}
				$('.dynamic_doctor').empty()
				$('.dynamic_doctor').append(`<ul>
							<li><b>${result_data_json[0]['doctor_name']}</b></li>
							<li>${result_data_json[0]['qualification_data']}</li>
							<li>${result_data_json[0]['reg_num']}</li>
							<li>${result_data_json[0]['designation_data']}</li>
					</ul>`)
					
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
					//console.log(food_to_avoid)
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
						for( let xyf2 = 0; xyf2<food_to_avoid.length; xyf2++){
						$('.food_to_avoid').append(`<p>${food_to_avoid[xyf2]['foods_avoid']}</p>`)
					}
					
					}
				
					
					setTimeout(function(){
					window.print()
						$('.currentConsultingheadPrintBtn').empty()
						$('.currentConsultingheadPrintBtn').append(`<i class="uil uil-print"></i> Print`)
					},1000)
				
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
			$('.position').val(prescription_result)
			position_data = prescription_result
		}
	})
}

function fetch_all_lab_reports(patient_id){
	$.ajax({
		url:"action/appointment/fetch_all_lab_reports.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(lab_result){
			$('.lab_report_section').empty()
			let lab_result_json = jQuery.parseJSON(lab_result)
			//console.log(lab_result_json)
			for(let x=0;x<lab_result_json.length;x++){
				let date_report = lab_result_json[x]['lab']
				let template_data = `<div class="labTestHistorySectionBox">
									<div class="labTestHistoryDate">${lab_result_json[x]['added_date']} OLD</div>
									<div class="labTestHistoryReport">`
										for(let y=0;y<date_report.length;y++){
											if(date_report[y]['lab_report_file'] != ''){
											template_data += `<div class="labTestHistoryReportBox">
															  <p>${date_report[y]['test_name']}</p>
																<a href="../lab/assets/fileupload/${date_report[y]['lab_report_file']}" class="labTestHistoryReportFileBtn spotlight">
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
								$('.lab_report_section').append(template_data)
			}
		}
	})
}

function counsultation_details_print(){

}

$.ajax({
	url:"action/appointment/fetch_all_lab_details.php",
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		if(result_data_json.length !=0){
		for(let x=0;x<result_data_json.length;x++){
			$('.lab_report ul').append(`<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['test_name']} (${result_data_json[x]['mrp']})</li>`)
		}
		}
	}
})



function fetch_all_lab_details(patient_id){
	let test_len = $('.lab_tagName').length
	let test_x = 0;
	if(test_len !=0){
	$('.lab_tagName').each(function(){
		let test_id = $(this).attr('data_id')
		//console.log(test_id)
		$.ajax({
			url:"action/appointment/add_lab_report.php",
			type:"POST",
			data:{test_id:test_id,
				  patient_id:patient_id
				 },
			success:function(test_result){
				//console.log(test_result)
				test_x++
				
			}
		})
		if(test_len == test_x){
				return 	
		}
	})
	}
}
function fetch_all_treatment_details(patient_id){
	let test_len = $('.treatment_tagName').length
	let test_x = 0;
	if(test_len !=0){
	$('.treatment_tagName').each(function(){
		let test_id = $(this).attr('data_id')
		//console.log(test_id)
		$.ajax({
			url:"action/appointment/add_treatment_report.php",
			type:"POST",
			data:{test_id:test_id,
				  patient_id:patient_id
				 },
			success:function(test_result){
				console.log(test_result)
				test_x++
				
			}
		})
		if(test_len == test_x){
				return 	
		}
	})
	}
}
function fetch_all_previous(patient_id,branch_id){
$.ajax({
	url:"action/appointment/fetch_all_previous_report.php",
	type:"POST",
	data:{patient_id:patient_id,
		 branch_id:branch_id
		 },
	success:function(previous_result){
		let lab_result_json = jQuery.parseJSON(previous_result)
			console.log(lab_result_json)
		$('.lab_report_section').empty()
			for(let x=0;x<lab_result_json.length;x++){
				let date_report = lab_result_json[x]['lab']
				let template_data = `<div class="labTestHistorySectionBox">
									<div class="labTestHistoryDate">${lab_result_json[x]['added_date']}</div>
									<div class="labTestHistoryReport">`
										for(let y=0;y<date_report.length;y++){
											template_data += `<div class="labTestHistoryReportBox">
															  <p>${date_report[y]['test_name']}</p>
																<a href="../lab/assets/fileupload/${date_report[y]['lab_report_file']}" class="labTestHistoryReportFileBtn">
																	<i class="uil uil-eye"></i>
																</a>
															  </div>`
										}
										
										template_data += `<!-- dont remove the div-->
										<div class="dummyDiv"></div>
										<!-- dont remove the div-->
										
									</div>
								</div>`;
								$('.lab_report_section').append(template_data)
			}
	}
})
}

function fetch_all_previous_treatment(patient_id,branch_id){
	console.log("patient_id"+patient_id)
$.ajax({
	url:"action/appointment/fetch_all_previous_treatment_report.php",
	type:"POST",
	data:{patient_id:patient_id,
		 branch_id:branch_id
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
											file_data = `<a href="add-lab-test.php?id=${date_report[y]['id']}-${branch_id}" class="labTestHistoryReportFileBtn">
																	<i class="uil uil-export"></i>
																</a>
<a href="${date_report[y]['url']}${date_report[y]['file']}" class="labTestHistoryReportFileBtn" style="margin-left:10px">
																	<i class="uil uil-eye"></i>
																</a>`
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

function fetch_all_previous_treatment_of_appointment(appointment_id,branch_id){
$.ajax({
	url:"action/appointment/fetch_all_previous_treatment_appointment_report.php",
	type:"POST",
	data:{appointment_id:appointment_id,
		 branch_id:branch_id
		 },
	success:function(previous_result){
		let lab_result_json = jQuery.parseJSON(previous_result)
		//console.log(lab_result_json)
		let loop_count = 0;
		let total_len = lab_result_json.length
		$('.feeCollectionPopupBody').empty()
		if(lab_result_json.length){
			$('#treatment_btn').attr('disabled',false)
		for(let t = 0;t<lab_result_json.length;t++){
			$('.feeCollectionPopupBody').append(`<div class="feeCollectionPopupBox">
						<p treatment_id = ${lab_result_json[t]['treatment_id']}>${lab_result_json[t]['treatment_name']}</p>
						<input type="number" class="${lab_result_json[t]['treatment_name']}amt treatment_amt" value="">
						<span class="error_num"></span>
					</div>`)
			loop_count++;
			if(loop_count == total_len){
				$.ajax({
					url:"action/appointment/fetch_payment_mode.php",
					success:function(payment_result){
						console.log(payment_result)
					}
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
			}
		}
	}else{
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
	}
	}
})
}

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
	$(this).prop('disabled',true)
	let that = $(this)
	let validation_val = $('#amt_error_val').val()
	let appointment_id_data = $('.consultedBtn').attr('data-id')
	let valid = 0
	let amt_input = $('.treatment_amt').length
	let amt_loop_c = 0
	$('.treatment_amt').each(function(){
		let treatmentText = $(this).parent().find('p').text()
		let treatmentVal = $(this).parent().parent().find('.dropDownInputText').val() 
		if($(this).val() === '' || ($(this).val() == 0 && treatmentVal !=='') || ($(this).val() == 0 && treatmentText != "") ){
			$(this).parent().find('.error_num').css('color','red')
			$(this).parent().find('.error_num').text('*Required!')
			valid++
			//alert();
			//exit(0);
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
		console.log(invoice_id_json)
		let id = invoice_id_json[0]['id']
		let invoice_branch = invoice_id_json[0]['branch_id']
		 $('.print_enable').attr('invoice_id',id)
		let treatment_count = 0;
		let treatment_len = $('.feeCollectionPopupBox').length
		console.log("treatment_len "+treatment_len)
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
														console.log(amt_result)
														mood_loop++
														if(mood_loop == mood_len){
														let new_treatment_count = $('.feeCollectionPopupAddTreatmentSectionTemp').length
														let new_treatment_count_loop = 0;
														$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
															let new_treatment_id = $(this).find('.treatment_data').val()
															console.log(new_treatment_id)
														})
															$('.collectFeeBtn').css('display','none')
															$('.print_enable').css('display','flex')
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
									<input type="text" class="dropDownInputText" disabled="" style="box-shadow: rgba(0, 0, 0, 0.06) 0px 0px 20px;position:relative;index:-1;">
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
														console.log(amt_result)
														mood_loop++
														if(mood_loop == mood_len){
														let new_treatment_count = $('.feeCollectionPopupAddTreatmentSectionTemp').length
														let new_treatment_count_loop = 0;
														$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
															let new_treatment_id = $(this).find('.treatment_data').val()
															console.log(new_treatment_id)
														})
															$('.collectFeeBtn').css('display','none')
															$('.print_enable').css('display','flex')
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
														console.log(amt_result)
														mood_loop++
														if(mood_loop == mood_len){
														let new_treatment_count = $('.feeCollectionPopupAddTreatmentSectionTemp').length
														let new_treatment_count_loop = 0;
														$('.feeCollectionPopupAddTreatmentSectionTemp').each(function(){
															let new_treatment_id = $(this).find('.treatment_data').val()
															console.log(new_treatment_id)
														})
															$('.collectFeeBtn').css('display','none')
															$('.print_enable').css('display','flex')
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

fetch_print_data()
function fetch_print_data(id){
	
	$.ajax({
		url:"action/appointment/fetch_all_invoice_data.php",
		type:"POST",
		data:{id:id},
		success:function(treatment_print_data){
			console.log(treatment_print_data)
			
			
			
		}
	})
}

function create_invoice_treatment(appointmnet_data_id){
	return $.ajax({
		url:"action/appointment/add_treatment_invoic.php",
		type:"POST",
		data:{appointment_id:appointmnet_data_id},
		
	})
}
/*$('.medicalTextarea_btn').click(function(){
	let medicalTextarea = $('.medicalTextarea_area .note-editable').html()
	let patient_id = $('#current_patient_uniqueid').text()
	if(medicalTextarea != '<p><br></p>'){
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
})*/


//fetch dite
fetch_dite_plan()
function fetch_dite_plan(){
$.ajax({
	url:"action/appointment/fetch_dite_pan.php",
	success:function(dite_result){
		let dite_result_json = jQuery.parseJSON(dite_result);
		$('#dite_details_to_follow').empty()
		if(dite_result_json.length !=0){
			for(let x = 0;x<dite_result_json.length;x++){
				$('#dite_details_to_follow').append(`<li>
										<input type="checkbox" id="diet${dite_result_json[x]['id']}" value="${dite_result_json[x]['dite']}" class="dite_details">
										<label for="diet${dite_result_json[x]['id']}">${dite_result_json[x]['dite']}</label>
									</li>`)
			}
		}
	}
})
}

fetch_food_to_avoid()
function fetch_food_to_avoid(){
$.ajax({
	url:"action/appointment/fetch_food_to_avoid.php",
	success:function(food_to_avoid_result){
		let food_to_avoid_result_json = jQuery.parseJSON(food_to_avoid_result);
		$('#food_to_be_avoid_data').empty()
		if(food_to_avoid_result_json.length !=0){
			for(let x = 0;x<food_to_avoid_result_json.length;x++){
				$('#food_to_be_avoid_data').append(`<li>
										<input type="checkbox" id="food_f${food_to_avoid_result_json[x]['id']}" class="food_avoided" value="${food_to_avoid_result_json[x]['food_to_avoid']}">
										<label for="food_f${food_to_avoid_result_json[x]['id']}">${food_to_avoid_result_json[x]['food_to_avoid']}</label>
									</li>`)
			}
		}
	}
})
}

//dietBoxFormGroupInput
		$('.dite_to_follow_btn').click(function(){
			var dietBoxFormGroupInput = $(this).parent().find('.dietBoxFormGroupInput_dite').val();
			if(dietBoxFormGroupInput != ''){
			let that = $(this)
			$.ajax({
				url:"action/appointment/add_dite_plan.php",
				type:"POST",
				data:{dietBoxFormGroupInput:dietBoxFormGroupInput},
				success:function(dite_added_result){
					let dite_added_result_json = jQuery.parseJSON(dite_added_result)
					for(let x1 = 0;x1<dite_added_result_json.length;x1++){
						if(dite_added_result_json[0]['status'] == 1){
							if(dite_added_result_json[0]['data_exist'] !=0){
								$('#dite_pan_exist').text(dite_added_result_json[0]['data_exist_Msg'])
							}else{
								$('#dite_pan_exist').text('')
								that.parent().find('.dietBoxFormGroupInput_dite').val('');
								fetch_dite_plan()
								/**that.parent().parent().parent().find('ul').append(`<li>
										<input type="checkbox" id="diet1" value="${dietBoxFormGroupInput}" class="dite_details">
										<label for="diet1">${dietBoxFormGroupInput}</label>
									</li>`)**/
							}
						}else{
							window.location.href="../login.php";
						}
					}
				}
			})
			}
			
		})

//food to be avoid
		$('.food_to_avoid_btn').click(function(){
			var new_food_to_avoid = $(this).parent().find('.new_food_to_avoid').val();
			if(new_food_to_avoid != ''){
			let that = $(this)
			$.ajax({
				url:"action/appointment/add_food_to_avoid.php",
				type:"POST",
				data:{new_food_to_avoid:new_food_to_avoid},
				success:function(dite_added_result){
					let dite_added_result_json = jQuery.parseJSON(dite_added_result)
					for(let x1 = 0;x1<dite_added_result_json.length;x1++){
						if(dite_added_result_json[0]['status'] == 1){
							if(dite_added_result_json[0]['data_exist'] !=0){
								$('#food_data_exist').text(dite_added_result_json[0]['data_exist_Msg'])
							}else{
								$('#food_data_exist').text('')
								that.parent().find('.new_food_to_avoid').val('');
								fetch_food_to_avoid()
								/**that.parent().parent().parent().find('ul').append(`<li>
										<input type="checkbox" id="diet1" value="${dietBoxFormGroupInput}" class="dite_details">
										<label for="diet1">${dietBoxFormGroupInput}</label>
									</li>`)**/
							}
						}else{
							window.location.href="../login.php";
						}
					}
				}
			})
			}
			
		})


$('body').delegate('.formGroupFileSaveBtn','click',function(e){
	e.preventDefault();
	let branch_id = $(this).attr('branch_id')
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
			console.log(result_data)
			console.log("div_count "+div_count)
			if(div_count == div_len){
			$('.formGroupFileSaveBtn').text('save')
			$('.commentsPopupPreviousFileUploadSectionTemplate').remove();
			//$('.commentsPopupPreviousFileUploadSectionBox').remove();
				parent_div.find('.report_name').val('')
			fetch_all_previous_treatment(patient_id_data,branch_id)
			
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

		
		//collectFeeBtn
		$('.collectFeeBtn').click(function(){
			$('.feeCollectionPopup').fadeIn();
			$('.shimmer').fadeIn();
		})
		$('.closeFeeCollectionPopupBtn').click(function(){
			$('.feeCollectionPopup').fadeOut();
			$('.shimmer').fadeOut();
		})

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

function print_enable(apmnt_id){
	$.ajax({
		url:"action/appointment/check_fee_status.php",
		type:"POST",
		data:{apmnt_id:apmnt_id},
		success:function(result_data){
			if(result_data == 1){
				$('.collectFeeBtn').css('display','none')
				$('.print_enable').css('display','flex')
			}else {
				$('.collectFeeBtn').css('display','flex')
				$('.print_enable').css('display','none')
			}
		}
	})
}

//print button enable
//print_enable();
//function print_enable(apmnt_id){

//	let app =apmnt_id; 
	
	/**		$.ajax({
				url:"action/appointment/print_buttonenable.php",
				type:"POST",
				data:{appointment_id:apmnt_id},
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			console.log(profile_result_json)
			if(profile_result_json[0]['consulted_status'] == 1){
				$('.print_enable').css('display','flex')
				
			}else if(profile_result_json[0]['consulted_status'] == 2){
			$('.print_enable').css('display','none')
			}
		}
	})
	
	
}**/


//print_button click
$('.print_enable').click(function(e){
	e.preventDefault();
	$(this).text('Loading...')
	let that = $(this)
	let appoinment_id = $(this).attr('apmnt');
$.when(print_invoice_data(appoinment_id)).then(function(){
	setTimeout(function(){
		that.text('Print')
		window.print()
	},2000)
	
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

/** $.ajax({
 	url:"action/appointment/fetch_all_treatment.php",
	 success:function(treatment_result){
		 let treatment_result_json = jQuery.parseJSON(treatment_result)
		 console.log(treatment_result_json)
	 	for(let x = 0;x<treatment_result_json.length;x++){
			$('.treatment_data').append(`<option value="${treatment_result_json[x]['id']}">${treatment_result_json[x]['treatment']}</option>`)
		}
	 }
 })**/

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


