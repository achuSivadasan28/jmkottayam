let fun_exe = 0;
var next_btn_class = 'disableNextBtn';
let search_data = '';
let diet_plan = [];
let food_avoided_plan = [];
let url_data = window.location.href
let url_split = url_data.split('=')
let url_val = url_split[1]
let g_branch_id = 0;
fetch_already_added_lab(url_val)
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
						g_branch_id = result_data_json[x]['branch_id']
						// console.log(g_branch_id)
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
						$('.consultedBtn').attr('branch_id',result_data_json[x]['branch_id'])
						$('.commentsTextarea_btn').attr('branch_id',result_data_json[x]['branch_id'])
						$('.currentConsultingheadPrintBtn').attr('branch_id',result_data_json[x]['branch_id'])
						$('#prescription_data').attr('branch_id',result_data_json[x]['branch_id'])
						$('.dite_to_follow_btn').attr('branch_id',result_data_json[x]['branch_id'])
						$('.food_to_avoid_btn').attr('branch_id',result_data_json[x]['branch_id'])
						$('.formGroupFileSaveBtn').attr('branch_id',result_data_json[x]['branch_id'])
						$('.medicalTextarea_btn').attr('branch_id',result_data_json[x]['branch_id'])
						$('.surgicalTextarea_btn').attr('branch_id',result_data_json[x]['branch_id'])
						if(result_data_json[0]['appointment_status'] == 2){
							$('.currentConsultingheadPrintBtn').attr('data-id',result_data_json[x]['id'])
							$('.currentConsultingheadPrintBtn').css('display','flex')
						}
						fetch_all_prescription_data(result_data_json[x]['unique_id'],url_val,result_data_json[x]['branch_id'])
						fetch_all_prescription_data_history(result_data_json[x]['unique_id'],result_data_json[x]['branch_id'])
						fetch_allcomments(result_data_json[x]['unique_id'],result_data_json[x]['branch_id'])
						fetch_allmedical(result_data_json[x]['unique_id'],result_data_json[x]['branch_id'])
						fetch_allsurgical(result_data_json[x]['unique_id'],result_data_json[x]['branch_id'])
						fetch_all_food_plan(result_data_json[x]['id'],result_data_json[x]['branch_id'])
						fetch_all_diet_plan(result_data_json[x]['id'],result_data_json[x]['branch_id'])
						fetch_all_previous_treatment(result_data_json[x]['patient_id'],result_data_json[x]['branch_id'])
						fetch_all_lab_reports(result_data_json[x]['patient_id'],result_data_json[x]['branch_id'])
						fetch_dite_food(url_val,result_data_json[x]['branch_id'])
						fetch_all_lab_data(url_val,result_data_json[x]['branch_id'])
						fetch_all_remarks_added(result_data_json[x]['patient_id'],result_data_json[x]['branch'])
						fetch_all_prev_dite_plan(result_data_json[x]['patient_id'],result_data_json[x]['branch'])
						$('.doctorsNoteTextarea_btn').attr('branch_id',result_data_json[x]['branch'])
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
console.log(g_branch_id)
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
			//fetch_all_prescription_data(appointment_result_json[x]['unique_id'],url_val)
			fetch_allcomments(appointment_result_json[x]['unique_id'])
			fetch_allmedical(appointment_result_json[x]['unique_id'])
			fetch_allsurgical(appointment_result_json[x]['unique_id'])
			fetch_all_food_plan(appointment_result_json[x]['id'])
			fetch_all_diet_plan(appointment_result_json[x]['id'])
			fetch_all_lab_reports(appointment_result_json[x]['patient_id'])
			fetch_all_previous_treatment(appointment_result_json[x]['patient_id'])
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
	let upd_branch_id = $(this).attr('branch_id')
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
	$.when(fetch_all_lab_details(url_val,upd_branch_id)).then(function(){
		$.when(fetch_all_treatment_details(url_val,upd_branch_id)).then(function(){
			$.when(fetch_all_die_details()).then(function(){
				$.when(fetch_all_foods_to_be_avoided_details()).then(function(){
					//food_avoided_plan
					//diet_plan
					$.ajax({
						url:"action/appointment/update_consulted_data.php",
						type:"POST",
						data:{patient_id:patient_id,
							  food_avoided_plan:food_avoided_plan,
							  diet_plan:diet_plan,
							  no_of_days:no_of_days,
							  food_remark:food_remark,
							  main_remark:main_remark,
							  upd_branch_id:upd_branch_id,
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
	})
})
let api = "de317f60c5d5182d99a2cf0fdc8f6175";
//fetch_all_medicine()
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
$('body').delegate('.medicine_details','change',function(){
	let that = $(this)
	let product_id = $(this).val()
	let Productnopill_id = $(this).parent().parent().parent().find('.Productnopill_id').val()
	let this_div = that.parent().parent().parent()
	console.log(this_div.find('.no_days').val())
	let quantity = parseInt(this_div.find('.no_days').val()) * (parseInt(this_div.find('.morning_data').val()) + parseInt(this_div.find('.noon_data ').val()) + parseInt(this_div.find('.evening_data').val()))
	console.log(quantity)
	const stock_check_data = {
		product_id:product_id,
		api:api,
		quantity:quantity
	}
	fetch("../../api/check_medicine_stock.php",{
		method:"POST",
		header:{'Content-Type':'application/json'},
		body:JSON.stringify(stock_check_data)
	})
		.then(response_arr => response_arr.json())
		.then(data =>{
		console.log(data)
		if(data[0]['status'] == 1){
			if(data[0]['stock'] == 0){
				that.parent().find('#stock_error_msg').text(`*Out of Stock! Only ${data[0]['quantity']} left`).css('fontSize','small')
				//$('#prescription_data').prop('disabled',true)
			}else{
				that.parent().find('#stock_error_msg').text('')
				//$('#prescription_data').prop('disabled',false)
			}
		}
	})
})

$('body').delegate('.no_days , .morning_data, .noon_data , .evening_data ','keyup',function(){
	//alert()
	console.log("hi")
    let that = $(this).parent().parent()
	let product_id = that.parent().parent().find('.medicine_details').val();
	
	let quantity = parseInt(that.parent().parent().find('.no_days').val()) * (parseInt(that.parent().find('.morning_data').val()) + parseInt(that.parent().find('.noon_data ').val()) + parseInt(that.parent().find('.evening_data').val()))
	console.log(quantity)
	const stock_check_data = {
		product_id:product_id,
		api:api,
		quantity:quantity
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
				console.log(data[0]['quantity'])
				that.parent().parent().find('#stock_error_msg').text(`*Out of Stock! Only ${data[0]['quantity']} left`).css('fontSize','small')
				//$('#prescription_data').prop('disabled',true)
			}else{
				that.parent().parent().find('#stock_error_msg').text('')
				//$('#prescription_data').prop('disabled',false)
			}
		}
	})
	
})
$('body').on('click','.q_check ul li',function(){
	//alert();
	console.log("hi")
    let that = $(this).parent().parent().parent().parent()
	let product_id = that.parent().parent().find('.medicine_details').val();
	
	let quantity = parseInt(that.parent().parent().find('.no_days').val()) * (parseInt(that.parent().find('.morning_data').val()) + parseInt(that.parent().find('.noon_data ').val()) + parseInt(that.parent().find('.evening_data').val()))
	console.log(quantity)
	const stock_check_data = {
		product_id:product_id,
		api:api,
		quantity:quantity
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
				console.log(data[0]['quantity'])
				that.parent().parent().find('#stock_error_msg').text(`*Out of Stock! Only ${data[0]['quantity']} left`).css('fontSize','small')
				//$('#prescription_data').prop('disabled',true)
			}else{
				that.parent().parent().find('#stock_error_msg').text('')
				//$('#prescription_data').prop('disabled',false)
			}
		}
	})
	
})
$('#prescription_data_form').submit(function(e){
	//alert("haello")
	e.preventDefault()
	if($('.main_prescription_div').find('.medicine_details').val().trim() != '' && $('.main_prescription_div').find('.no_days').val().trim() != '' && $('.main_prescription_div').find('.current').text().trim() != ''){
		$('#medicine_error').text(' ')
		$('#quantity_error').text(' ')
		$('#noof_error').text(' ')
		let prev_btn_text = $('#prescription_data').text() 
		let pres_branch_id = $('#prescription_data').attr('branch_id')
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
					  ps_id:ps_id,
					  branch_id:pres_branch_id
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
						fetch_all_prescription_data(current_patient_uniqueid,url_val,pres_branch_id)
						fetch_all_prescription_data_history(current_patient_uniqueid,pres_branch_id)
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
			$.when(add_prescription_data(appointment_id,pres_branch_id)).then(function(patient_id){
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
							  branch_id:pres_branch_id,
							 },
						success:function(result_data){
							console.log(result_data)
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
									fetch_all_prescription_data(current_patient_uniqueid,url_val,pres_branch_id)
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

function add_prescription_data(appointment_id,branch_id){
	let remark_data = $('.remark_data').val()
	return $.ajax({
		url:"action/prescription/add_initial_prescription_data.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			  remark_data:remark_data,
			  branch_id:branch_id,
			 }
	})
}

function fetch_all_prescription_data(current_patient_uniqueid,appoint_id,branch){
	
	$.ajax({
		url:"action/prescription/fetch_all_prevoius_prescription_history_edit.php",
		type:"POST",
		data:{current_patient_uniqueid:current_patient_uniqueid,
			  branch:branch,
			  url_val:appoint_id,
			  appointment_id:appoint_id,
			 },
		success:function(all_prescription){
			let all_prescription_json = jQuery.parseJSON(all_prescription)
			console.clear();
	         //console.log(branch)
			console.log(all_prescription_json)
			$('.prescriptionHistoryListMain_new').empty()
			if(all_prescription_json[0]['data_status'] == 1){
				$('.noDataSection_prescription').css('display','none')
				let tamplate = `<div class="prescriptionHistoryListTable"><table>
										<thead>
											<tr>
												<th colspan="7" style="background: #7868e6; color: white;">${all_prescription_json[0]['date_time']}</th></tr><tr>
												<th>Medicine</th>
												<th>No Of Days</th>
												<th><i class="uil uil-sun"></i></th>
												<th><i class="uil uil-sunset"></i></th>
												<th><i class="uil uil-moon"></i></th>
												<th>Medication Guidlines</th>
                                               ${(all_prescription_json[0]['edit_del_status'] == 1)?`<th>Action</th>`:``}
												
												</thead><tbody>`
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
						edit_btn = `<button  class="prescriptionHistoryEditBtn" branch_id=${branch} data-id="${all_prescription_json[x1]['id']}">
<i class="uil uil-edit"></i>
</button>`;
						delete_btn = `<button class="prescriptionHistoryDeleteBtn" branch_id=${branch} data-id="${all_prescription_json[x1]['id']}">
<i class="uil uil-trash"></i>
</button>`
					}
					tamplate += `<tr>
												<td>${all_prescription_json[x1]['medicine_name']}</td>
												<td>${all_prescription_json[x1]['no_of_day']}</td>
												<td>${all_prescription_json[x1]['morning_section']}</td>
												<td>${all_prescription_json[x1]['noon_section']}</td>
												<td>${all_prescription_json[x1]['evening_section']}</td>
												<td>${all_prescription_json[x1]['time']}</td>
												 ${all_prescription_json[0]['edit_del_status'] == 1 ? `<td><div class="prescriptionHistoryBtnArea">${edit_btn} ${delete_btn} </td>`:``}
											</div></tr>`
					
				}
				tamplate += `</tbody></table></div>`
				$('.prescriptionHistoryListMain_new').append(tamplate)
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

function fetch_all_prescription_data_history(current_patient_uniqueid,branch_id){
	//console.log("branch_id "+branch_id)
	$.ajax({
		url:"action/prescription/fetch_all_prevoius_prescription.php",
		type:"POST",
		data:{current_patient_uniqueid:current_patient_uniqueid,
			  branch_id:branch_id,
			 },
		success:function(all_prescription){
			let all_prescription_json = jQuery.parseJSON(all_prescription)
			//console.clear();
			//console.log(all_prescription_json)
			$('.prescriptionHistoryListMain_history').empty()
			if(all_prescription_json[0]['data_status'] == 1){
				$('.noDataSection_prescription_history').css('display','none')
				let template = `<div class="prescriptionHistoryListTable">
`;
				for(let x1=0;x1<all_prescription_json.length;x1++){
					template += `<table>
										<thead>
											<tr>
												<th colspan="7" style="background: #7868e6; color: white;">${all_prescription_json[x1]['added_date']}</th></tr><tr>
												<th>Medicine</th>
												<th>No Of Days</th>
												<th><i class="uil uil-sun"></i></th>
												<th><i class="uil uil-sunset"></i></th>
												<th><i class="uil uil-moon"></i></th>
												<th>Medication Guidlines</th>
												
</thead><tbody>`
					let all_prescription = all_prescription_json[x1]['prescription']
					if(all_prescription != "" && all_prescription != undefined){
						for(let y = 0; y<all_prescription.length; y++){
							template += `<tr>
												<td>${all_prescription[y]['medicine_name']}</td>
												<td>${all_prescription[y]['no_of_day']}</td>
												<td>${all_prescription[y]['morning_section']}</td>
												<td>${all_prescription[y]['noon_section']}</td>
												<td>${all_prescription[y]['evening_section']}</td>
												<td>${all_prescription[y]['time']}</td>
												
											</tr>`
						}
					}
					template += `</tbody></table>`
					
				}
				template +=`</div>`
				$('.prescriptionHistoryListMain_history').append(template)
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


function fetch_allcomments(patient_id,branch_id){
	$.ajax({
		url:"action/prescription/fetch_all_comments.php",
		type:"POST",
		data:{patient_id:patient_id,
			  branch_id:branch_id,
			 },
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
						$('.commentsPopupPreviousList_complaints dl').append(`<dd class="commentsPopupPreviousBox commentsPopupPreviousBox_complaint" data-id=${date_details[x1]['id']} >
<div class="commentsPopupPreviousBoxHead">
<div class="commentsPopupPreviousBoxHeadBtnArea">
<div class="editHistoryBtn editHistoryBtn_comment" title="Edit" data-id="${date_details[x1]['id']}" branch_id="${date_details[x1]['branch_id']}"><i class="uil uil-edit"></i></div>
<div class="deleteHistoryBtn" title="Delete" data-id="${date_details[x1]['id']}" branch_id="${date_details[x1]['branch_id']}" type="comment"><i class="uil uil-trash"></i></div>
</div>
</div>
<div class="comment-con">
${date_details[x1]['comment']} 
</div>
</dd>`)
					}
				}
			}else{
				$('.commentsPopupPreviousList_complaints dl').append(`No Data`)
			}
		}
	})
}



function fetch_allmedical(patient_id,branch_id){
	$.ajax({
		url:"action/prescription/fetch_all_medical.php",
		type:"POST",
		data:{patient_id:patient_id,
			  branch_id:branch_id,
			 },
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
						$('.commentsPopupPreviousList_medical dl').append(`<dd class="commentsPopupPreviousBox commentsPopupPreviousBox_medical" data_id=${date_details[x1]['id']}>
<div class="commentsPopupPreviousBoxHead">
<div class="commentsPopupPreviousBoxHeadBtnArea">
<div class="editHistoryBtn editHistoryBtn_medical" title="Edit" data_id="${date_details[x1]['id']}" branch_id="${branch_id}"><i class="uil uil-edit"></i></div>
<div class="deleteHistoryBtn" title="Delete" data-id="${date_details[x1]['id']}" branch_id="${branch_id}" type="medical"><i class="uil uil-trash"></i></div>
</div>
</div>
<div class="medical-history-con">
${date_details[x1]['comment']}
</div>
</dd>`)
					}
				}
			}else{
				$('.commentsPopupPreviousList_medical dl').append(`No Data`)
			}
		}
	})
}

function fetch_allsurgical(patient_id,branch_id){
	$.ajax({
		url:"action/prescription/fetch_all_surgical.php",
		type:"POST",
		data:{patient_id:patient_id,
			  branch_id:branch_id
			 },
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
						$('.commentsPopupPreviousList_surgical dl').append(`<dd class="commentsPopupPreviousBox commentsPopupPreviousBox_surgical" data-id=${date_details[x1]['id']}>
<div class="commentsPopupPreviousBoxHead">
<div class="commentsPopupPreviousBoxHeadBtnArea">
<div class="editHistoryBtn editHistoryBtn_surgical" title="Edit" data_id="${date_details[x1]['id']}" branch_id="${branch_id}"><i class="uil uil-edit"></i></div>
<div class="deleteHistoryBtn" title="Delete" data-id="${date_details[x1]['id']}" branch_id="${branch_id}" type="surgical"><i class="uil uil-trash"></i></div>
</div>
</div>
<div class="surgical_data">
${date_details[x1]['comment']}
</div>
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
	let branch_id = $(this).attr('branch_id')
	if(commentsTextarea != '<p><br></p>'){
		$('.saveCommentsPopupBtn').text('Loading...')
		$('.saveCommentsPopupBtn').attr('disabled',true)
		$.ajax({
			url:"action/prescription/add_comments.php",
			type:"POST",
			data:{commentsTextarea:commentsTextarea,
				  patient_id:patient_id,
				  data_id:data_id,
				  branch_id:branch_id,
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
					fetch_allcomments(patient_id,branch_id)
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
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
					$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}

$('.medicalTextarea_btn').click(function(e){
	e.preventDefault()
	let data_id = $(this).attr('data-id')
	let medical_branch_id = $(this).attr('branch_id')
	if(data_id == undefined){
		data_id = 0;
	}
	let medicalTextarea = $('.medicalTextarea_area .note-editable').html()
	let patient_id = $('#current_patient_uniqueid').text()
	if(commentsTextarea != '<p><br></p>'){
		$('.medicalTextarea_btn').text('Loading...')
		$('.medicalTextarea_btn').attr('disabled',true)
		$.ajax({
			url:"action/prescription/add_medical.php",
			type:"POST",
			data:{medicalTextarea:medicalTextarea,
				  patient_id:patient_id,
				  data_id:data_id,
				  medical_brnach_id:medical_branch_id,
				 },
			success:function(result_data){
				$('.medicalTextarea_btn').text('Success')
				$('.medicalTextarea_btn').css('background-color','blue')
				setTimeout(function(){
					$('.medicalTextarea_btn').attr('disabled',false)
					$('.medicalTextarea_btn').text('Save')
					$('.medicalTextarea_btn').css('background-color','#557bfe')
					$('.medicalTextarea_area .note-editable').html('')

					fetch_allmedical(patient_id,medical_branch_id)
					$('.medicalTextarea_btn').attr('data-id',0)
				},1500)
				console.log(result_data)
			}

		})
	}
})
$('.surgicalTextarea_btn').click(function(e){
	e.preventDefault()
	let data_id = $(this).attr('data-id')
	let surgical_branch_id = $(this).attr('branch_id')
	if(data_id == undefined){
		data_id = 0;
	}
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
				  patient_id:patient_id,
				  data_id:data_id,
				  surgical_branch_id:surgical_branch_id
				 },
			success:function(result_data){
				$('.surgicalTextarea_btn').text('Success')
				$('.surgicalTextarea_btn').css('background-color','blue')
				setTimeout(function(){
					$('.surgicalTextarea_btn').attr('disabled',false)
					$('.surgicalTextarea_btn').text('Save')
					$('.surgicalTextarea_btn').css('background-color','#557bfe')
					$('.surgicalTextarea_data .note-editable').html('')
					fetch_allsurgical(patient_id,surgical_branch_id)
					$('.surgicalTextarea_btn').attr('data-id',0)
				},1500)
				console.log(result_data)
			}

		})
	}
})

function fetch_all_food_plan(appointment_id,branch_id){
	$.ajax({
		url:"action/prescription/fetch_all_food_plan.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			  branch_id:branch_id,
			 },
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
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

function fetch_all_diet_plan(appointment_id,branch_id){
	$.ajax({
		url:"action/prescription/fetch_all_diet_plan.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			  branch_id:branch_id
			 },
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
	let p_brnach_id = $(this).attr('branch_id')
	$.ajax({
		url:"action/appointment/fetch_appointment_details_print.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			  p_brnach_id:p_brnach_id
			 },
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
				//console.log(food_to_avoid.length)
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
	fetch("../../api/fetchAll_medicine.php",{
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

	fetch("../../api/fetchAll_medicine.php",{
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
<div class="formGroup formGroup2">
<label>No Of Days</label>
<input type="text" class="no_days" value="15">
</div>
<div class="formGroup3">
<div class="checkBoxArea2">
<label><i class="uil uil-sun"></i></label>
<input type="text" class="morning_data" value="1">
</div>
<div class="checkBoxArea2">
<label><i class="uil uil-sunset"></i></label>
<input type="text" class="noon_data" value="0">
</div>
<div class="checkBoxArea2">
<label><i class="uil uil-moon"></i></label>
<input type="text" class="evening_data" value="1">
</div>
<span id="type_error" style="color:red"></span>
</div>

<!--<div class="formGroup formGroup2" style="margin-top: 20px;">
<label>No.Of Days</label>
<input type="text" class="no_days">
</div>-->
<div class="formGroup4">
<div class="checkBoxArea">
<input type="radio" class="morning_data afterFood" id="afterFood${addmore_c}" name="foodMed2${addmore_c}">
<label for="afterFood${addmore_c}">After Food</label>
</div>
<div class="checkBoxArea">
<input type="radio" class="noon_data beforeFood" id="beforeFood${addmore_c}" name="foodMed2${addmore_c}">
<label for="beforeFood${addmore_c}">Before Food</label>
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
	let prescription_id_branch_id = $(this).attr('branch_id')
	$('#stock_error_msg').text(' ')


	$.ajax({
		url:"action/prescription/fetch_prescription_details.php",
		type:"POST",
		data:{prescription_id:prescription_id,
			  prescription_id_branch_id:prescription_id_branch_id,
			 },
		success:function(prescription_result){
			let prescription_result_json = jQuery.parseJSON(prescription_result)
			//console.log(prescription_result_json)
			if(prescription_result_json[0]['status'] !=0){
				$('.tempPanelDiv').remove()
				$('.list ul li').each(function(){
					let medicine_val = $(this).attr('data-value')
					if(medicine_val == prescription_result_json[0]['medicine_id']){
						$('.tempPanelBtnArea .addMoreBtn').css('display','none')
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
let prescription_branch_id = 0;
let type = '';
$('body').delegate('.prescriptionHistoryDeleteBtn','click',function(){
	prescription_id = $(this).attr('data-id')
	prescription_branch_id = $(this).attr('branch_id')
	type = 'per'
	$('.deleteAlert').fadeIn();
	$('.shimmer').fadeIn();
});

// deleteAlert
$('body').delegate('.deleteHistoryBtn', 'click', function(){
	prescription_id = $(this).attr('data-id')
	console.log("prescription_id "+prescription_id)
	prescription_branch_id = $(this).attr('branch_id')
	type = $(this).attr('type')
	$('.deleteAlert').fadeIn();
	$('.shimmer').fadeIn();
})


$('.confirmdeleteAlert').click(function(){
	if(type == 'per'){
		$.ajax({
			url:"action/prescription/delete_prescription.php",
			type:"POST",
			data:{prescription_id:prescription_id,
				  prescription_branch_id:prescription_branch_id,
				 },
			success:function(p_details){
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
				let p_details_json = jQuery.parseJSON(p_details)
				let unique_id_data = p_details_json[0]['unique_id']
				//console.log(unique_id_data)
				fetch_all_prescription_data(unique_id_data,prescription_branch_id)
				fetch_all_prescription_data_history(unique_id_data,prescription_branch_id)
			}
		})
	}else if(type == 'comment'){
		$.ajax({
			url:"action/comment/delete_comment.php",
			type:"POST",
			data:{prescription_id:prescription_id,
				  prescription_branch_id:prescription_branch_id,
				 },
			success:function(p_details){
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
				let p_details_json = jQuery.parseJSON(p_details)
				let unique_id_data = p_details_json[0]['patient_id']
				//console.log(unique_id_data)
				fetch_allcomments(unique_id_data,prescription_branch_id)
				//fetch_allcomments(unique_id_data,prescription_branch_id)
				/**fetch_all_prescription_data(unique_id_data,url_val,prescription_branch_id)
					fetch_all_prescription_data_history(unique_id_data,prescription_branch_id)**/
			}
		})
	}else if(type == 'medical'){
		$.ajax({
			url:"action/comment/delete_medical_data.php",
			type:"POST",
			data:{prescription_id:prescription_id,
				  prescription_branch_id:prescription_branch_id,
				 },
			success:function(p_details){
				console.log(p_details)
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
				let p_details_json = jQuery.parseJSON(p_details)
				let unique_id_data = p_details_json[0]['patient_id']
				//console.log(unique_id_data)
				fetch_allmedical(unique_id_data,prescription_branch_id)
				//fetch_allcomments(unique_id_data,prescription_branch_id)
				/**fetch_all_prescription_data(unique_id_data,url_val,prescription_branch_id)
					fetch_all_prescription_data_history(unique_id_data,prescription_branch_id)**/
			}
		})
	}else if(type == 'surgical'){
		$.ajax({
			url:"action/comment/delete_surgical_data.php",
			type:"POST",
			data:{prescription_id:prescription_id,
				  prescription_branch_id:prescription_branch_id,
				 },
			success:function(p_details){
				console.log(p_details)
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
				let p_details_json = jQuery.parseJSON(p_details)
				let unique_id_data = p_details_json[0]['patient_id']
				//console.log(unique_id_data)
				fetch_allsurgical(unique_id_data,prescription_branch_id)
				//fetch_allcomments(unique_id_data,prescription_branch_id)
				/**fetch_all_prescription_data(unique_id_data,url_val,prescription_branch_id)
					fetch_all_prescription_data_history(unique_id_data,prescription_branch_id)**/
			}
		})
	}else if( type == 'doctor_note'){
		$.ajax({
			url:"action/comment/delete_DN_data.php",
			type:"POST",
			data:{prescription_id:prescription_id,
				  prescription_branch_id:prescription_branch_id,
				 },
			success:function(p_details){
				console.log(p_details)
				$('.deleteAlert').fadeOut();
				$('.shimmer').fadeOut();
				let p_details_json = jQuery.parseJSON(p_details)
				let unique_id_data = p_details_json[0]['patient_id']
				//console.log(unique_id_data)
				fetch_all_remarks_added(unique_id_data,prescription_branch_id)
				//fetch_allcomments(unique_id_data,prescription_branch_id)
				/**fetch_all_prescription_data(unique_id_data,url_val,prescription_branch_id)
					fetch_all_prescription_data_history(unique_id_data,prescription_branch_id)**/
			}
		})
	}

});

let dite_arr = [];
let food_arr = [];
function fetch_dite_food(url_val,g_branch_id){
	$.ajax({
		url:"action/appointment/fetch_dite_food_details.php",
		type:"POST",
		data:{url_val:url_val,
			  g_branch_id:g_branch_id,
			 },
		success:function(food_result){
			let food_result_result = jQuery.parseJSON(food_result)
			dite_arr = food_result_result[0]['all_dite_data']
			food_arr = food_result_result[0]['all_food_avoid']
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
<input type="checkbox" id="food_f${food_len}" class="food_avoided" value="${food_arr[y]}" checked>
<label for="food_f${food_len}">${food_arr[y]}</label>
</li>`)
						}else{
							$('.food_details ul').append(`<li>
<input type="checkbox" id="food_f${food_len}" class="food_avoided" value="${food_arr[y]}">
<label for="food_f${food_len}">${food_arr[y]}</label>
</li>`)
						}
					}
				})
			}else{
				for(let y=0;y<food_arr.length;y++){
					food_len++;
					$('.food_details ul').append(`<li>
<input type="checkbox" id="food_f${food_len}" class="food_avoided" value="${food_arr[y]}">
<label for="food_f${food_len}">${food_arr[y]}</label>
</li>`)

				}
			}
		}
	})
}

$('body').delegate('.editHistoryBtn_comment','click',function(){
	let comment = $(this).parent().parent().parent().find('.comment-con').text()
	if(comment != ''){
		$('.commentsTextarea_data .note-placeholder').text(' ')
		$('.commentsTextarea_data .note-editable').html($(this).parent().parent().parent().find('.comment-con').html())
		let comment_id = $(this).attr('data-id')
		$('.commentsTextarea_btn').attr('data-id',comment_id)
	}else{
		$('.commentsTextarea_data .note-placeholder').text('Type here...')
	}
})



$('body').delegate('.editHistoryBtn_medical','click',function(){
	let medical_data = $(this).parent().parent().parent().find('.medical-history-con').text()
	if(medical_data != ''){
		$('.medicalTextarea_area .note-placeholder').text(' ')
		$('.medicalTextarea_area .note-editable').html($(this).parent().parent().parent().find('.medical-history-con').html())
		let comment_id = $(this).attr('data_id')
		$('.medicalTextarea_btn').attr('data-id',comment_id)
	}else{
		$('.medicalTextarea_area .note-placeholder').text('Type here...')
	}
})

$('body').delegate('.editHistoryBtn_surgical','click',function(){
	if($(this).parent().parent().parent().find('.surgical_data').text() != ''){
		$('.surgicalTextarea_data .note-placeholder').text(' ')
		$('.surgicalTextarea_data .note-editable').html($(this).parent().parent().parent().find('.surgical_data').html())
		let comment_id = $(this).attr('data_id')
		$('.surgicalTextarea_btn').attr('data-id',comment_id)
	}else{
		$('.surgicalTextarea_data .note-placeholder').text('Type here...')
	}
})

function set_arry(dite){
	console.log(dite)
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


function fetch_already_added_lab(patitent_id){
	$.ajax({
		url:"action/appointment/fetch_all_lab_details_assigned.php",
		type:"POST",
		data:{patitent_id:patitent_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)

			}

	})
}

function fetch_all_lab_details(patient_id,branch_id){

}
$('body').delegate('.labtestcheck','change',function(){
	let testId = $(this).val();
	let checkStatus = $(this).prop('checked')
	console.log(testId,checkStatus,url_val,g_branch_id)
	$.ajax({
		url:"action/appointment/add_lab_report.php",
		type:"POST",
		data:{patient_id:url_val,
			  branch_id:g_branch_id,
			  test_id:testId,
			  check_status:checkStatus},
		success:function(result_data){
			console.log(result_data);

		}
	})

})
$('.closedeleteAlert').click(function(){
	$('.deleteAlert').fadeOut();
	$('.shimmer').fadeOut();
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
					let file_data = ``;
					if(date_report[y]['file'] != ''){
						file_data = `<a href="assets/treatmentfileupload/${date_report[y]['file']}" class="labTestHistoryReportFileBtn">
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

$.ajax({
	url:"action/appointment/fetch_all_treatment_details.php",
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		console.log(result_data_json)
		if(result_data_json.length !=0){
			for(let x=0;x<result_data_json.length;x++){
				$('.treatment_data ul').append(`<li data-id=${result_data_json[x]['id']}>${result_data_json[x]['treatment']}</li>`)
			}
		}
	}
})

function fetch_all_treatment_details(patient_id,branch_id){
	let test_len = $('.treatment_tagName').length
	let test_x = 0;
	if(test_len !=0){
		$('.treatment_tagName').each(function(){
			let test_id = $(this).attr('data_id')
			console.log(test_id)
			$.ajax({
				url:"action/appointment/add_treatment_report.php",
				type:"POST",
				data:{test_id:test_id,
					  patient_id:patient_id,
					  branch_id:branch_id
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
function fetch_all_remarks_added(patient_id,branch_id){
	$.ajax({
		url:"action/appointment/fetch_all_remark_data.php",
		type:"POST",
		data:{patient_id:patient_id,
			  branch_id:branch_id
			 },
		success:function(all_remark_data){
			$('.commentsPopupPreviousList_doctors_note dl').empty()
			let all_remark_data_json = jQuery.parseJSON(all_remark_data)
			//console.clear()
			console.log(all_remark_data_json)
			if(all_remark_data_json.length !=0){
				$('.edit_data_DN').css('display','flex')
				$('.elseDesign_DN').css('display','none')
				for(let x = 0;x<all_remark_data_json.length;x++){
					$('.commentsPopupPreviousList_doctors_note dl').append(`<dt class="PreviousListDate">
<span>${all_remark_data_json[x]['appointment_date']}</span>
</dt>`)
					$('.commentsPopupPreviousList_doctors_note dl').append(`<dd class="commentsPopupPreviousBox"><div class="commentsPopupPreviousBoxHead">
<div class="commentsPopupPreviousBoxHeadBtnArea">
<div class="editHistoryBtn editHistoryBtn_doctor_note" title="Edit" data_id="${all_remark_data_json[x]['id']}" branch_id="${branch_id}"><i class="uil uil-edit"></i></div>
<div class="deleteHistoryBtn" title="Delete" data-id="${all_remark_data_json[x]['id']}" branch_id="${branch_id}" type="doctor_note"><i class="uil uil-trash"></i></div>
</div>
</div>
<div class="doctor_note">
${all_remark_data_json[x]['dite_remark']}
</div>
</dd>`)
				}
				//commentsPopupPreviousList_doctors_note
			}else{
				$('.edit_data_DN').css('display','none')
				$('.elseDesign_DN').css('display','flex')
			}
		}
	})
}

function fetch_all_lab_reports(patient_id,branch_id){
	$.ajax({
		url:"action/appointment/fetch_all_lab_reports.php",
		type:"POST",
		data:{patient_id:patient_id,
			  branch_id:branch_id,
			 },
		success:function(lab_result){
			$('.lab_report_section').empty()
			let lab_result_json = jQuery.parseJSON(lab_result)
			console.log("<h1>lab LAb</h1>")
			
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
				$('.lab_report_section').append(template_data)
			}
		}
	})
}

// Define a global array to store selected files
let selectedFiles = [];
selectedFiles.push([])
selectedFiles.push([])
selectedFiles.push([])

$('body').delegate('.fileInput', 'change', function(e) {
    let file_length = e.target.files.length;
    console.log($(this).index('.fileInput'));
    let currentIndex = $(this).index('.fileInput')
    for (let i = 0; i < file_length; i++) {
        const file = e.target.files[i];
        
        // Add the selected file to the global array
        selectedFiles[currentIndex].push(file);
        
        console.log(file_length);
        $(this).parent().parent().parent().find('.formGroupFileBox2').append(`
            <div class="formFileBox">
                <p>${file.name}</p>
                <div class="closeFormFileBox"><i class="uil uil-times"></i></div>
            </div>`
        );
    }
});

$('body').delegate('.closeFormFileBox', 'click', function() {
    const fileName = $(this).parent().find('p').text();
    let currentIndex = $(this).parent().parent().parent().parent().find('.fileInput').index('.fileInput')
	
    // Remove the selected file from the global array
    selectedFiles[currentIndex] = selectedFiles[currentIndex].filter(file => file.name !== fileName);
    
    $(this).parent().remove();
	
});

// You can access the selectedFiles array globally to access the selected files.

let valid_c = 0;
function check_file_validation(){
	valid_c = 0  
	let cIndex = 0;
	$('.commentsPopupPreviousFileUploadSectionBox').each(function(){
		
		
		let file_length = selectedFiles[cIndex].length
		
		let fixed_length =  3;
		console.log(file_length)
		if(file_length > fixed_length){
			$(this).find('.file_error').text("*you can only upload maximum  3 files at once").css("fontSize","small");
            valid_c = 1;
			console.log("hi")
			console.log(file_length)
		}
		if($(this).find('.report_name') == ""){

			$(this).find('.file_error').text('*required!')
			valid_c = 1;
		}
		cIndex++;
	})
}

$('body').delegate('.formGroupFileSaveBtn','click',function(e){
	e.preventDefault();
	$.when(check_file_validation()).then(()=>{
		let lab_branch_id = $(this).attr('branch_id')
		let div_len = $('.commentsPopupPreviousFileUploadSectionBox').length
		let div_count = 0;


		if(valid_c == 0){
			let cIndex = 0;
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
					for(let i = 0;i < selectedFiles[cIndex].length ; i++){
						
						fd.append("files[]", selectedFiles[cIndex][i]);
					}
					
					
					fd.append("file_name",file_name);
					
					fd.append("branch_id",lab_branch_id);
					let appointment_id = $('.consultedBtn').attr('data-id')
					fd.append("appointment_id",appointment_id);
					$.ajax({
						url:"action/upload_data/Upload_file.php",
						type:"POST",
						data:fd,
						contentType:false,
						processData:false,
						success:function(result_data){
							console.log(result_data)
							//console.log("div_count "+div_count)
							if(div_count == div_len){
								$('.formGroupFileSaveBtn').text('save')
								$('.commentsPopupPreviousFileUploadSectionBox').remove();
								fetch_all_lab_reports(patient_id_data,lab_branch_id)
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
<input type="file" class="fileInput report_file" max-length ='3' multiple>
<p>Upload images</p>
</label>
<span style="color:red" class="file_error"></span>
</div>
<div class="formGroupFileBox2">

</div>
</div>
</div>

</div>`);	
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
			selectedFiles[cIndex] = [];
			cIndex++;
			})
		}

	})

})

function fetch_all_lab_data(id,branch_id){
	let result_data_lab = '';
	let result_data_sub = '';
	let result_data_sublab = '';
	let fd = new FormData();
	console.log(branch_id)
	fd.append('id',id)
	fd.append('branch_id',branch_id)
	console.log(url_val)
	$.ajax({

		url:"action/appointment/fetch_all_lab_details1.php",
		type:'post',
		data:fd,
		contentType:false,
		processData:false,
		success:function(result_data){
			$(".labTestListSection").empty();
			let result_data_json = jQuery.parseJSON(result_data)
			let template_div = '';
			console.log(result_data_json)
			if(result_data_json.length !=0){
				for(let x=0;x<result_data_json.length;x++){
					template_div = `<div class="labTestListSectionBox">
<div class="labTestListSectionBoxHead">${result_data_json[x]['category_name']}</div>
<ul>`;
					result_data_lab = result_data_json[x]['category'];
					if(result_data_lab != undefined){

						for(let y = 0;y<result_data_lab.length;y++){
							template_div += `<li>
<input type="checkbox" class="labtestcheck" id="${result_data_lab[y]['test']}" value="${result_data_lab[y]['test_id']}"${result_data_lab[y]['check_status']&&'checked'}>
<label for="${result_data_lab[y]['test']}">${result_data_lab[y]['test']}</label>
</li>`
						}
					}
					template_div += `         </ul>	`
					result_data_sub = result_data_json[x]['subcategory'];
					//console.log(result_data_sub)
					if(result_data_json[x]['subcategory'] != undefined){
						for(let y = 0 ; y<result_data_sub.length;y++){
							result_data_sublab = result_data_sub[y]['subcategorytest'];
							console.log(result_data_sublab);
							if(result_data_sublab != undefined){
								template_div +=`<h3>${result_data_sub[y]['subcategory_name'].toUpperCase()}</h3><ul>`
								for(let z = 0; z<result_data_sublab.length;z++){
									//console.log(result_data_sublab[x]['check_status'])
									template_div += `<li>
<input type="checkbox" class = "labtestcheck" id="${result_data_sublab[z]['test']}" value="${result_data_sublab[z]['test_id']}" ${result_data_sublab[z]['check_status'] && 'checked'}>
<label for="${result_data_sublab[z]['test']}">${result_data_sublab[z]['test']}</label>
</li>`
								}
							}
							template_div += `</ul>`
						}

					}

					template_div += `																			
</div>`;
					$(".labTestListSection").append(template_div);

				}

			}
		}
	}).then(()=>{$(".labTestListSection").append(`<div class="dummyDiv"></div>
<div class="dummyDiv"></div>`)})
}
function fetch_all_prev_dite_plan(patient_id,barnch_id){
	$.ajax({
		url:"action/appointment/fetch_all_prev_dite_plan.php",
		type:"POST",
		data:{patient_id:patient_id,
			  barnch_id:barnch_id,
			 },
		success:function(dite_result){
			let dite_result_json = jQuery.parseJSON(dite_result)
			//console.clear();
			console.log(dite_result_json)
			$('.pervoius_dite_plan').empty()
			$('.pervoius_dite_plan').append(`<h2>Previous Diet Plan</h2>`)
			let dite_exe_data = 0;
			if(dite_result_json.length !=0){
				for(let x = 0;x<dite_result_json.length;x++){
					let no_date = dite_result_json[x]['diet_no_of_days']
					let dite_data = dite_result_json[x]['dite']
					let food_avoid = dite_result_json[x]['food_avoid']
					let appointment_date = dite_result_json[x]['appointment_date']
					//console.log(dite_data)
					//console.log(food_avoid)
					let template_dite_plan = `
<div class="PreviousDietPlanBox">
<h3>${appointment_date}</h3>
`;
					if(dite_data != undefined){
						if(dite_data.length!=0){
							template_dite_plan += `<div class="PreviousDietPlanBoxList">
<h3>Diet to be followed</h3>
<ul>`
							let exe_dite = 0;
							for(let x1 = 0;x1<dite_data.length;x1++){
								exe_dite++
								console.log("dite "+dite_data[x1]['dite_data'])
								template_dite_plan += `<li>${dite_data[x1]['dite_data']}</li>`;
								if(exe_dite == dite_data.length){
									template_dite_plan += `</ul>
</div>`
									if(food_avoid != undefined){
										if(food_avoid.length !=0){
											template_dite_plan += `<div class="PreviousDietPlanBoxList">
<h3>Foods to be avoided</h3>
<ul>`;
											let food_exe = 0;
											for(let y = 0;y<food_avoid.length; y++){
												food_exe++;
												console.log("food_avoid "+food_avoid[y]['food_avoid_data'])
												template_dite_plan += `<li>${food_avoid[y]['food_avoid_data']}</li>`
												if(food_exe == food_avoid.length){
													template_dite_plan += `</ul></div>
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>10 days</li>
</ul>
</div>
</div>
`;
													$('.pervoius_dite_plan').append(template_dite_plan)
												}
											}
										}else{
											template_dite_plan += `
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
											$('.pervoius_dite_plan').append(template_dite_plan)
										}

									}else{
										template_dite_plan += `
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
										$('.pervoius_dite_plan').append(template_dite_plan)
									}
								}
							}

						}else{
							if(food_avoid.length !=0){
								template_dite_plan += `<div class="PreviousDietPlanBoxList">
<h3>Foods to be avoided</h3>
<ul>`;
								let food_exe = 0;
								for(let y = 0;y<food_avoid.length; y++){
									food_exe++;
									template_dite_plan += `<li>${food_avoid[y]['food_avoid_data']}</li>`
									if(food_exe == food_avoid.length){
										template_dite_plan += `</ul></div>
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
										$('.pervoius_dite_plan').append(template_dite_plan)
									}
								}
							}else{
								template_dite_plan += `
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
								$('.pervoius_dite_plan').append(template_dite_plan)
							}
						}
					}else{
						if(food_avoid != undefined){
							if(food_avoid.length !=0){
								template_dite_plan += `<div class="PreviousDietPlanBoxList">
<h3>Foods to be avoided</h3>
<ul>`;
								let food_exe = 0;
								for(let y = 0;y<food_avoid.length; y++){
									food_exe++;
									template_dite_plan += `<li>${food_avoid[y]['food_avoid_data']}</li>`
									if(food_exe == food_avoid.length){
										template_dite_plan += `</ul></div>
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
										$('.pervoius_dite_plan').append(template_dite_plan)
									}
								}
							}else{
								template_dite_plan += `
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
								$('.pervoius_dite_plan').append(template_dite_plan)
							}
						}else{

							template_dite_plan += `
<div class="PreviousDietPlanBoxList">
<h3>No.of days</h3>
<ul>
<li>${no_date} days</li>
</ul>
</div>
</div>
`;
							$('.pervoius_dite_plan').append(template_dite_plan)
						}
					}


					//pervoius_dite_plan
					dite_exe_data++
					if(dite_exe_data == dite_result_json.length){
						//$('.pervoius_dite_plan').append(template_dite_plan)
					}
				}
			}else{
				$('.pervoius_dite_plan').append(`<h2>No Previous Diet Plan</h2>`)
			}
		}
	})
}
$('.doctorsNoteTextarea_btn').click(function(){
	$('#doctor_btn_data').text('')
	let data_id = $(this).attr('data-id')
	console.log("data_id "+data_id)
	let medical_branch_id = $(this).attr('branch_id')
	if(data_id == undefined){
		data_id = 0;
	}
	if(data_id !=0){
		let medicalTextarea = $('.doctorsNoteTextarea_data .note-editable').html()
		let patient_id = $('#current_patient_uniqueid').text()
		let medical_brnach_id = $(this).attr('branch_id')
		if(medicalTextarea != '<p><br></p>'){
			$('.doctorsNoteTextarea_btn').text('Loading...')
			$('.doctorsNoteTextarea_btn').attr('disabled',true)
			//add_doctores_note.php
			$.ajax({
				url:"action/prescription/add_doctores_note.php",
				type:"POST",
				data:{medicalTextarea:medicalTextarea,
					  patient_id:patient_id,
					  medical_brnach_id:medical_brnach_id,
					  data_id:data_id,
					 },
				success:function(result_data){
					let result_data_json = jQuery.parseJSON(result_data)
					console.log(result_data_json)
					$('.doctorsNoteTextarea_btn').text('Success')
					$('.doctorsNoteTextarea_btn').css('background-color','blue')
					setTimeout(function(){
						$('.doctorsNoteTextarea_btn').attr('disabled',false)
						$('.doctorsNoteTextarea_btn').text('Save')
						$('.doctorsNoteTextarea_btn').css('background-color','#557bfe')
						$('.doctorsNoteTextarea_data .note-editable').html('')
						let patient_id = result_data_json[0]['patient_id']
						fetch_all_remarks_added(patient_id,medical_brnach_id)
						$('.doctorsNoteTextarea_btn').attr('data-id',0)
					},1500)
					//console.log(result_data)
				}

			})
		}
	}else{
		$('#doctor_btn_data').text('*Only Edit')
	}
})
$('body').delegate('.editHistoryBtn_doctor_note','click',function(){
	let comment = $(this).parent().parent().parent().find('.doctor_note').text()
	//console.log("comment "+comment)
	if(comment != ''){
		//$('.commentsTextarea_data .note-placeholder').text(' ')
		$('.doctorsNoteTextarea_data .note-placeholder').text(' ')
		//$('.doctorsNoteTextarea_data .note-editable').text('')
		//$('#textAreaId').val("")
		$('.doctorsNoteTextarea_data .note-editable').html($(this).parent().parent().parent().find('.doctor_note').html())
		let comment_id = $(this).attr('data_id')
		$('.doctorsNoteTextarea_btn').attr('data-id',comment_id)
	}else{
		$('.doctorsNoteTextarea_data .note-placeholder').text('Type here...')
	}
})

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
				
				if(ext !== 'png' && ext!== 'jpg' && ext !== 'jpeg' && ext !== 'webp'){
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

