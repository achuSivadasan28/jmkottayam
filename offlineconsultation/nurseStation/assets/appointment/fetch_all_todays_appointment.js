let fun_exe = 0;
var next_btn_class = 'enableNextBtn';
let search_data = '';
let diet_plan = [];
let food_avoided_plan = [];
let appointment_data = 0;
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
			for(let x=0;x<result_data_json.length;x++){
				si_no++
				let active = "";
				
				//commentsPopup
				if(result_data_json[x]['active'] == 1){
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
					$('#age_details').text('Age : '+result_data_json[x]['age']+', '+result_data_json[x]['gender']+','+result_data_json[x]['phone'])
						$('#current_patient_place').text(": "+result_data_json[x]['place'])
					if(result_data_json[x]['to'] == 0){
						$('.currentConsultingKeepWaitBtn').css('display','none')
					}else{
						$('.currentConsultingKeepWaitBtn').css('display','flex')
					}
						$('.currentConsultingKeepWaitBtn').attr('data-id',result_data_json[x]['id'])
					$('.addReportBtn').attr('href','add-report.php?id='+result_data_json[x]['unique_id'])
					//console.log(result_data_json[x]['id'])
					if(result_data_json[x]['present_Illness'] != ''){
								$('#present_Illness').text(": "+result_data_json[x]['present_Illness'])
							}else{
								$('#present_Illness').text(": No Data")
							}
						$('.consultedBtn').attr('data-id',result_data_json[x]['id'])
					$('.currentConsultingheadPrintBtn').attr('data-id',result_data_json[x]['id'])
						fetch_all_prescription_data(result_data_json[x]['unique_id'])
						fetch_report_data(result_data_json[x]['unique_id'])
						fetch_all_prescription_data_history(result_data_json[x]['unique_id'])
						fetch_allcomments(result_data_json[x]['unique_id'])
						fetch_allmedical(result_data_json[x]['unique_id'])
						fetch_allsurgical(result_data_json[x]['unique_id'])
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
											<p>${result_data_json[x]['BMI'][bmi_val]['height']} KG</p>
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
                                                            
                                                            <div class="nextBtn ${next_btn_class}" data-id=${result_data_json[x]['id']}>Next</div>
                                                        </div>
                                                    </td>
                                                </tr>`)
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
					$('#age_details').text('Age : '+appointment_result_json[x]['age']+', '+appointment_result_json[x]['gender']+','+appointment_result_json[x]['phone'])
						$('#current_patient_place').text(": "+appointment_result_json[x]['place'])
						$('.currentConsultingKeepWaitBtn').attr('data-id',appointment_result_json[x]['id'])
						$('.consultedBtn').attr('data-id',appointment_result_json[x]['id'])
					$('.currentConsultingheadPrintBtn').attr('data-id',appointment_result_json[x]['id'])
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
					console.log(appointment_result_json)
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
					$('.currentConsultingheadPrintBtn').attr('data-id',appointment_result_json[x]['id'])
						fetch_all_prescription_data(appointment_result_json[x]['unique_id'])
						fetch_all_prescription_data_history(appointment_result_json[x]['unique_id'])
						fetch_allcomments(appointment_result_json[x]['unique_id'])
						fetch_allmedical(appointment_result_json[x]['unique_id'])
						fetch_allsurgical(appointment_result_json[x]['unique_id'])
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
											<p>${appointment_result_json[x]['BMI'][bmi_val]['height']} KG</p>
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
	console.log(button_test)
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
	$.when(fetch_all_die_details()).then(function(){
		$.when(fetch_all_foods_to_be_avoided_details()).then(function(){
			let no_of_days = $('#noofDays').val()
			let food_remark = $('#food_remark').val()
			let main_remark = $('.remark_data').val()
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
			  main_remark:main_remark,
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
            },3000);
			}else{
				window.location.href="../login.html"
			}
		}
	})
		})
	})
	}
	
})
let api = "de317f60c5d5182d99a2cf0fdc8f6175";
fetch_all_medicine()
function fetch_all_medicine(){
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
	const stock_check_data = {
		product_id:product_id,
		api:api
	}
	fetch("https://jmwell.in/api/check_medicine_stock.php",{
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
		console.log(all_prescription_json)
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
			
			if(result_data_json[0]['data_status'] !=0){
				$('.commentsPopupPreviousList_complaints dl').empty()
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
				if(profile_result_json[0]['proPic'] != ''){
				//$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
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
				if(result_data_json[0]['comment_data'] != undefined){
				let complaint_data = result_data_json[0]['comment_data']
			
				
					$('.complaints_data_print').empty()
					$('.complaints_data_print').append(`<h2>Complaints</h2>`)
				for(let xy = 0; xy<complaint_data.length;xy++){
					console.log(complaint_data[xy]['comment'])
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
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
						for( let xyf2 = 0; xyf2<food_to_follow.length; xyf2++){
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

function fetch_report_data(unique_id){
	$.ajax({
		url:"action/appointment/fetch_report_data.php",
		type:"POST",
		data:{unique_id:unique_id},
		success:function(report_result){
			let report_result_json = jQuery.parseJSON(report_result)
			if(report_result_json.length!=0){
				for(let x = 0;x<report_result_json.length;x++){
				$('.previousReport').append(`<div class="previousReportBox">
									<p>${report_result_json[x]['file_name']}</p>
									<a href="" class="previousReportBoxIcon" data-id=${report_result_json[x]['id']}>
										<i class="uil uil-eye"></i>
									</a>
								</div>`)
				}
			}
		}
	})
}

		$('body').delegate('.previousReportBoxIcon','click',function(e){
			e.preventDefault();
			let data_id = $(this).attr('data-id')
			$.ajax({
				url:"action/appointment/fetch_report_details.php",
				type:"POST",
				data:{data_id:data_id},
				success:function(report_details){
					let report_details_json = jQuery.parseJSON(report_details)
					console.log(report_details_json[0]['file'])
				    $('#test_data1').text(report_details_json[0]['file_name'])//report_details_json[0]['file']
					$('#report_dataImg').attr('src',"assets/fileupload/"+report_details_json[0]['file'])
					$('#report_dataImg_link').attr('href',"assets/fileupload/"+report_details_json[0]['file'])
					//fileupload
					
			$('.previuosReportPopup').fadeIn();
			$('.shimmer').fadeIn();
				}
			})
			
		})

function counsultation_details_print(){

}
