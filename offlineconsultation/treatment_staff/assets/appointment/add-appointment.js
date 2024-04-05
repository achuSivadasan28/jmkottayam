let doctor_search = '';
let appointment_data_fee = 0;
$.when(fetch_all_doctor()).then(function(){
	create_custom_dropdowns()
	
	
})



$.ajax({
	url:"action/profile/fetch_date_details.php",
	success:function(section_data){
		$('#date').val(section_data)
			$.when(update_doctor_time_slot(section_data)).then(function(){
		
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
create_custom_dropdowns1()
function fetch_all_doctor(){   
return $.ajax({
	url:"action/doctor/fetch_doctor_no_limit.php",
	type:"POST",
	data:{doctor_search:doctor_search},
	success:function(d_result){
			let result_data_json = jQuery.parseJSON(d_result)
			//console.log(result_data_json)
			if(result_data_json[0]['status'] == 0){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
			}else{
				$('#doctor_data').empty()
				//data_status
				if(result_data_json[0]['data_status'] ==1){
					$('#doctor_data').append(`
					<option value=""></option>
					`)
				for(let x=0;x<result_data_json.length;x++){
					$('#doctor_data').append(`
					<option value="${result_data_json[x]['login_id']}">${result_data_json[x]['doctor_name_dep']}</option>
					`)
				}
				}else{
					$('#doctor_data').append(`
					<option value="">No Data</option>
					`)
				}
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
	}
})        
}

	$('body').delegate('.txtSearchValue','keyup',function(){
		let search_val = $(this).val().toLowerCase();
		$('.doctor_drop li').each(function(){
			let option_val = $(this).text().toLowerCase();
			//console.log(option_val)
			if(search_val !=''){
			if(option_val.includes(search_val)){
				$(this).css('display','flex')
			}else{
				$(this).css('display','none')
			}
			}else{
				$(this).css('display','flex')
			}
		})
	})

        // custome select box 
        function create_custom_dropdowns() {
            $('select').each(function (i, select) {
				if($(this).attr('id') == 'doctor_data'){
                if (!$(this).next().hasClass('dropdown-select')) {
                    $(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul class="doctor_drop"></ul></div></div>');
                    var dropdown = $(this).next();
                    var options = $(select).find('option');
                    var selected = $(this).find('option:selected');
                    dropdown.find('.current').html(selected.data('display-text') || selected.text());
                    options.each(function (j, o) {
                        var display = $(o).data('display-text') || '';
                        dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
                    });
                }
					 $('.dropdown-select ul').before('<div class="dd-search"><input autocomplete="off" onkeyup="filter()" class="txtSearchValue dd-searchbox" type="text" placeholder="Search..."></div>');
			}
            });
        
           
        }

        // custome select box 
        function create_custom_dropdowns1() {
            $('select').each(function (i, select) {
				if($(this).attr('id') == 'gender_data'){
                if (!$(this).next().hasClass('dropdown-select')) {
                    $(this).after('<div class="dropdown-select wide ' + ($(this).attr('class') || '') + '" tabindex="0"><span class="current"></span><div class="list"><ul class="gender_drop"></ul></div></div>');
                    var dropdown = $(this).next();
                    var options = $(select).find('option');
                    var selected = $(this).find('option:selected');
                    dropdown.find('.current').html(selected.data('display-text') || selected.text());
                    options.each(function (j, o) {
                        var display = $(o).data('display-text') || '';
                        dropdown.find('ul').append('<li class="option ' + ($(o).is(':selected') ? 'selected' : '') + '" data-value="' + $(o).val() + '" data-display-text="' + display + '">' + $(o).text() + '</li>');
                    });
                }
					           
			}
            });
        

        }
        
        // Open/close
        $(document).on('click', '.dropdown-select', function (event) {
            if($(event.target).hasClass('dd-searchbox')){
                return;
            }
            $('.dropdown-select').not($(this)).removeClass('open');
            $(this).toggleClass('open');
            if ($(this).hasClass('open')) {
                $(this).find('.option').attr('tabindex', 0);
                $(this).find('.selected').focus();
            } else {
                $(this).find('.option').removeAttr('tabindex');
                $(this).focus();
            }
        });
        
        // Close when clicking outside
        $(document).on('click', function (event) {
            if ($(event.target).closest('.dropdown-select').length === 0) {
                $('.dropdown-select').removeClass('open');
                $('.dropdown-select .option').removeAttr('tabindex');
            }
            event.stopPropagation();
        });
        
        function filter(){
            var valThis = $('.txtSearchValue').val();
            $('.dropdown-select ul > li').each(function(){
                var text = $(this).text();
                (text.toLowerCase().indexOf(valThis.toLowerCase()) > -1) ? $(this).show() : $(this).hide();         
            });
        };
        
        // Option click
        $(document).on('click', '.dropdown-select .option', function (event) {
            $(this).closest('.list').find('.selected').removeClass('selected');
            $(this).addClass('selected');
            var text = $(this).data('display-text') || $(this).text();
            $(this).closest('.dropdown-select').find('.current').text(text);
            $(this).closest('.dropdown-select').prev('select').val($(this).data('value')).trigger('change');
        });
        
        // Keyboard events
        $(document).on('keydown', '.dropdown-select', function (event) {
            var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
            // Space or Enter
            //if (event.keyCode == 32 || event.keyCode == 13) {
            if (event.keyCode == 13) {
                if ($(this).hasClass('open')) {
                    focused_option.trigger('click');
                } else {
                    $(this).trigger('click');
                }
                return false;
                // Down
            } else if (event.keyCode == 40) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    focused_option.next().focus();
                }
                return false;
                // Up
            } else if (event.keyCode == 38) {
                if (!$(this).hasClass('open')) {
                    $(this).trigger('click');
                } else {
                    var focused_option = $($(this).find('.list .option:focus')[0] || $(this).find('.list .option.selected')[0]);
                    focused_option.prev().focus();
                }
                return false;
                // Esc
            } else if (event.keyCode == 27) {
                if ($(this).hasClass('open')) {
                    $(this).trigger('click');
                }
                return false;
            }
        });
$('#number').keyup(function(){
	let phn = $(this).val()
	if(phn.length ==10 || phn.length == 12){
		clear_text('number_error')
	}else{
		text_validation_number(phn,"number_error","*Invalid Phone Number!")
	}
})

$('.confirmconfirmAlert').click(function(){
	$('.confirmconfirmAlert').text('Loading...')
	let name = $('#unique_id_name').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
	let doctor_data = $('#doctor_data').val()
	let date = $('#date').val()
	let unique_id = $('#unique_id').val()
	let time_slot = 0;
	let appointment_fee = $('#appointment').val()
	let height = $('#height').val()
	let weight = $('#weight').val()
	let blood_pressure = $('#blood_pressure').val()
	let allergies_if_any = $('#allergies_if_any').val()
	let current_medication = $('#current_medication').val()
	let present_illness = $('#present_illness').val()
	let any_surgeries = $('#any_surgeries').val()
	let any_metal_lmplantation = $('#any_metal_lmplantation').val()
	let fVisit = $('#fVisit').val()
	let WhatsApp = $('#WhatsApp').val()
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
			time_slot = $(this).val()
		}
	})
	$.ajax({
		url:"action/appointment/add_appointment.php",
		type:"POST",
		data:{name:name,
			  number:number,
			  address:address,
			  place:place,
			  age:age,
			  gender_data:gender_data,
			  doctor_data:doctor_data,
			  date:date,
			  unique_id:unique_id,
			  time_slot:time_slot,
			  height:height,
			  weight:weight,
			  blood_pressure:blood_pressure,
			  allergies_if_any:allergies_if_any,
			  current_medication:current_medication,
			  present_illness:present_illness,
			  any_surgeries:any_surgeries,
			  any_metal_lmplantation:any_metal_lmplantation,
			  fVisit:fVisit,
			  WhatsApp:WhatsApp,
			  appointment_fee:appointment_fee
			 },
		success:function(appointment_result){
			let result_data_json = jQuery.parseJSON(appointment_result)
			if(result_data_json[0]['status'] == 0){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('.confirmAlert').hide();
				$('.shimmer').fadeOut();
			}else if(result_data_json[0]['status'] == 1){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','none')
				$('.successTost').css('display','flex')
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}else if(result_data_json[0]['status'] == 1){
			setTimeout(function () {
				window.location.href="appointments.php";
			}, 2500)
			}
		}
	})
})

/**$('.confirmconfirmAlert').click(function(){
	$('.confirmconfirmAlert').text('Lodaing...')
	let name = $('#unique_id_name').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
	let doctor_data = $('#doctor_data').val()
	let date = $('#date').val()
	let unique_id = $('#unique_id').val()
	let time_slot = 0;
	let appointment_fee = $('#appointment').val()
	let height = $('#height').val()
	let weight = $('#weight').val()
	let blood_pressure = $('#blood_pressure').val()
	let allergies_if_any = $('#allergies_if_any').val()
	let current_medication = $('#current_medication').val()
	let present_illness = $('#present_illness').val()
	let any_surgeries = $('#any_surgeries').val()
	let any_metal_lmplantation = $('#any_metal_lmplantation').val()
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
			time_slot = $(this).val()
		}
	})
	$.ajax({
		url:"action/appointment/add_appointment.php",
		type:"POST",
		data:{name:name,
			  number:number,
			  address:address,
			  place:place,
			  age:age,
			  gender_data:gender_data,
			  doctor_data:doctor_data,
			  date:date,
			  unique_id:unique_id,
			  time_slot:time_slot,
			  height:height,
			  weight:weight,
			  blood_pressure:blood_pressure,
			  allergies_if_any:allergies_if_any,
			  current_medication:current_medication,
			  present_illness:present_illness,
			  any_surgeries:any_surgeries,
			  any_metal_lmplantation:any_metal_lmplantation
			 },
		success:function(appointment_result){
			let result_data_json = jQuery.parseJSON(appointment_result)
			if(result_data_json[0]['status'] == 0){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('.confirmAlert').hide();
				$('.shimmer').fadeOut();
			}else if(result_data_json[0]['status'] == 1){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','none')
				$('.successTost').css('display','flex')
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}else if(result_data_json[0]['status'] == 1){
			setTimeout(function () {
				window.location.href="appointments.php";
			}, 2500)
			}
		}
	})
})**/

$('#appointment_btn').click(function(e){
	e.preventDefault();
	clear_text('name_error')
	clear_text('number_error')
	clear_text('doctor_required')
	clear_text('time_slot_required')
	clear_text('appointment_date_error')
	button_loader('appointment_btn')
	let name = $('#unique_id_name').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
	let appointment_fee = $('#appointment').val()
	let date = $('#date').val()
	let unique_id = $('#unique_id').val()
	let time_slot = 0;
	let height = $('#height').val()
	let weight = $('#weight').val()
	let blood_pressure = $('#blood_pressure').val()
	let allergies_if_any = $('#allergies_if_any').val()
	let current_medication = $('#current_medication').val()
	let present_illness = $('#present_illness').val()
	let any_surgeries = $('#any_surgeries').val()
	let any_metal_lmplantation = $('#any_metal_lmplantation').val()
	//console.log(name)
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
			time_slot = $(this).val()
		}
	})
		
	let error_msg = text_validation(name,"name_error","*Name Required!")
	error_msg += text_validation_number(number,"number_error","*Invalid Phone Number!")
	if(date == ''){
		$('#appointment_date_error').text('*Choose Appointment Date!')
		error_msg += 1;
	}else{
		if(appointment_fee == ''){
				$('#appointment_fee').text('*Add Appointment Fee!')
				error_msg += 1;
			}else{
		if(time_slot == 0){
			$('#time_slot_required').text('*Choose Time Solt!')
			error_msg += 1;
		}
			}
	}
	
	if(error_msg == 0){
		$('.confirmAlert').css('display','block')
		$('.shimmer').fadeIn();
	}else{
		stop_loader('appointment_btn')
	}
})

$('.closeconfirmAlert').click(function(){
			$('.confirmAlert').hide();
			$('.shimmer').fadeOut();
			stop_loader('appointment_btn')
})

/**$('#number').change(function(){
		
	let phn_number = $(this).val()
	if(phn_number.length == 10 || phn_number.length == 12){
		clear_text('name_error')
	clear_text('number_error')
	$.ajax({
		url:"action/appointment/check_number.php",
		type:"POST",
		data:{phn_number:phn_number},
		success:function(phn_result){
			let result_data_json = jQuery.parseJSON(phn_result)
			//console.log(result_data_json)
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					$('#unique_id_data').css('display','flex')
					//unique_id
					$('#unique_id').val(result_data_json[0]['unique_id'])
					$('#unique_id_name').val(result_data_json[0]['name'])
					$('#number').val(result_data_json[0]['phone'])
					$('#address').val(result_data_json[0]['address'])
					$('#place').val(result_data_json[0]['place'])
					$('#age').val(result_data_json[0]['age'])
					$('#unique_id_name').attr('disabled',true)
					$('#address').attr('disabled',true)
					if(result_data_json[0]['gender'] == 'Male'){
						$('.gender_details').empty()
						$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Male">Male</label>
								</span>`)
					}else if(result_data_json[0]['gender'] == 'Female'){
						$('.gender_details').empty()
						$('.gender_details').append(`
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Female">Female</label>
								</span>
								`)
					}else if(result_data_json[0]['gender'] == 'Other'){
						$('.gender_details').empty()
						$('.gender_details').append(`
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Other">Other</label>
								</span>`)
					}
					
				}else{
					$('#unique_id_name').attr('disabled',false)
					$('#address').attr('disabled',false)
					$('.gender_details').empty()
					$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
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
								</span>`)
					$('#unique_id_data').css('display','none')
					$('#unique_id').val("0")
				}
			}else{
				$('#unique_id_data').css('display','none')
				$('#unique_id').val("0")
				create_custom_dropdowns1()
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}
	})
	}
})**/
/**$('#doctor_data').change(function(){
	let doctor_id = $(this).val()
	let date = $('#date').val();
	if(doctor_id != ''){
	clear_text('doctor_required')

	$.when(update_doctor_time_slot(doctor_id,date)).then(function(){
		
	})
			}
})**/

$('#date').change(function(){
	let date = $(this).val();
	$.when(update_doctor_time_slot(date)).then(function(){
		
	})
})

function update_doctor_time_slot(date){
	$('.doctor_available_all_time_solt').empty()
	$.ajax({
		url:"action/doctor/fetch_doctor_time_slot.php",
		type:"POST",
		data:{date:date
			 },
		success:function(doctor_result){
			//console.log(doctor_result)
			let doctor_result_json = jQuery.parseJSON(doctor_result)
			
			if(doctor_result_json[0]['data_status'] == 1){
			if(doctor_result_json[0]['status'] == 1){
				$('.doctor_available_all_time_solt').empty()
			for(let x1=0;x1<doctor_result_json.length;x1++){
				let limit_status_data = '';
				if(doctor_result_json[x1]['limit_status'] == 1){
					limit_status_data = "disabled";
				}
				$('.doctor_available_all_time_solt').append(`<label class="control" for="${doctor_result_json[x1]['id']}">
									<input type="radio" class="time_slot_data" name="topics" id="${doctor_result_json[x1]['id']}" value="${doctor_result_json[x1]['id']}" ${limit_status_data}>
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${doctor_result_json[x1]['start_time']} ${doctor_result_json[x1]['f_time_section']} - ${doctor_result_json[x1]['end_time']} ${doctor_result_json[x1]['l_time_section']}</p>
									</span>
								</label>`)
				if((x1+1) == doctor_result_json.length){
					$('.doctor_available_all_time_solt').append(`<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>`)
				}
			}
			}else{
				$('.toasterMessage').text(doctor_result_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('.toaster').addClass('toasterActive');
				setTimeout(function () {
					$('.toaster').removeClass('toasterActive');
				}, 2000)
				if(doctor_result_json[0]['status'] == 0){
				setTimeout(function () {
					window.location.href="../login.php";
				}, 2500)
				}
			}
				$('#select_slot_data').css('display','flex')
				$('.offlineConsultingDetails').css('display','block')
		}else{
			$('.offlineConsultingDetails').css('display','block')
			$('.doctor_available_all_time_solt').css('color','red')
			$('.doctor_available_all_time_solt').append('Time Solt Not Added')
			$('#select_slot_data').css('display','none')
		}
			
		}
	})
	
}

function text_validation(data_name,error_id,msg){
	if(data_name.trim() == ''){
		//console.log(error_id)
		$('#'+error_id).text(msg)
		return 1;
	}else{
		return 0;
	}
}

function text_validation_number(data_name,error_id,msg){
	if(data_name.trim() == ''){
		$('#'+error_id).text(msg)
		return 1;
	}else{
		if(data_name.length ==10 || data_name.length == 12){
			return 0;
		}else{
			$('#'+error_id).text(msg)
			return 1;
		}
		
	}
}

function clear_text(id_clear){
	$('#'+id_clear).text(' ')
}
fetch_appointment_fee();
function fetch_appointment_fee(){
	$.ajax({
		url:"action/appointment/fetch_appointment_fee.php",
		success:function(appointment_fee){
			let appointment_fee_json = jQuery.parseJSON(appointment_fee);
			if(appointment_fee_json[0]['status'] == 1){
				$('#appointment').val(appointment_fee_json[0]['appointment_fee'])
				appointment_data_fee = appointment_fee_json[0]['appointment_fee'];
			}
		}
	})
}

$('#number').change(function(){
		
	let phn_number = $(this).val()
	if(phn_number.length == 10 || phn_number.length == 12){
		clear_text('name_error')
	clear_text('number_error')
	$.ajax({
		url:"action/appointment/check_number.php",
		type:"POST",
		data:{phn_number:phn_number},
		success:function(phn_result){
			let result_data_json = jQuery.parseJSON(phn_result)
			console.log(result_data_json)
			$('.patientNameUl').empty()
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					for(let x1=0;x1<result_data_json.length;x1++){
						$('.patientNameUl').append(`<li>${result_data_json[x1]['name']}</li>`)
					}
				}
			}else{
				//$('#unique_id_data').css('display','none')
				//$('#unique_id').val("0")
				//create_custom_dropdowns1()
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}
	})
	}
})

		$('body').delegate('.patientNameUl li','click',(e)=>{
			$('.patientNameUl').css('display','none')
		//console.log(e.target.innerHTML);
			let thePN = $('.patientNameValue');
			thePN.val(e.target.innerHTML)
			let user_name = thePN.val()
			let phone_num = $('#number').val()
			if(phone_num.length == 10 || phone_num.length == 12){
		if(user_name != ''){
			$.ajax({
				url:"action/appointment/fetch_user_on_name.php",
				type:"POST",
				data:{user_name:user_name,
					 phone_num:phone_num
					 },
				success:function(user_result){
					
			let result_data_json = jQuery.parseJSON(user_result)
			console.log(result_data_json)
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					$('#unique_id_data').css('display','flex')
					$('#unique_id').val(result_data_json[0]['unique_id'])
					$('#address').val(result_data_json[0]['address'])
					$('#place').val(result_data_json[0]['place'])
					$('#age').val(result_data_json[0]['age'])
					$('#fVisit').val(result_data_json[0]['first_visit'])
					if(result_data_json[0]['appointment_fee'] == 0){
						
						$('#appointment').val(0)
						$('#no_appointment_fee').text(result_data_json[0]['appointment_fee_msg'])
					}else if(result_data_json[0]['appointment_fee'] == 1){
						$('#appointment').val(appointment_data_fee)
						$('#no_appointment_fee').text('')
					}
					//console.log(result_data_json[0]['whatsApp'])
					    $('#WhatsApp').val(result_data_json[0]['whatsApp'])
					if(result_data_json[0]['gender'] == 'Male'){
						$('.gender_details').empty()
						$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
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

`)
					}else if(result_data_json[0]['gender'] == 'Female'){
						$('.gender_details').empty()
						$('.gender_details').append(`
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Male">Male</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Female">Female</label>
								</span>
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Other">Other</label>
								</span>
								`)
					}else if(result_data_json[0]['gender'] == 'Other'){
						$('.gender_details').empty()
						$('.gender_details').append(`
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Male">Male</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Female">Female</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Other">Other</label>
								</span>`)
					}
					
				}else{
					$('#name').attr('disabled',false)
					$('#address').attr('disabled',false)
					$('.gender_details').empty()
					$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
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
								</span>`)
					$('#unique_id_data').css('display','none')
					$('#unique_id').val("0")
				}
			}else{
				//$('#unique_id_data').css('display','none')
				//$('#unique_id').val("0")
				//create_custom_dropdowns1()
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
				}
			})
		}
	}else{
		text_validation_number(phone_num,"number_error","*Invalid Phone Number!")
	}
		})

$('.patientNameValue').keyup(function(e){
	let user_name = $(this).val()
	let phone_num = $('#number').val()
	if(phone_num.length == 10 || phone_num.length == 12){
		if(user_name != ''){
			$.ajax({
				url:"action/appointment/fetch_user_on_name.php",
				type:"POST",
				data:{user_name:user_name,
					 phone_num:phone_num
					 },
				success:function(user_result){
			let result_data_json = jQuery.parseJSON(user_result)
			//console.log(result_data_json)
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					$('#unique_id_data').css('display','flex')
					$('#unique_id').val(result_data_json[0]['unique_id'])
					//$('#name').attr('disabled',true)
					//$('#address').attr('disabled',true)
					//$('#name').val(result_data_json[0]['name'])
					//$('.patientNameUl').append(`<li>${result_data_json[0]['name']}</li>`)
					//$('#number').val(result_data_json[0]['phone'])
					$('#address').val(result_data_json[0]['address'])
					$('#place').val(result_data_json[0]['place'])
					$('#age').val(result_data_json[0]['age'])
					if(result_data_json[0]['appointment_fee'] == 0){
						$('#appointment').val(0)
						$('#no_appointment_fee').text(result_data_json[0]['appointment_fee_msg'])
					}else if(result_data_json[0]['appointment_fee'] == 1){
						$('#appointment').val(appointment_data_fee)
						$('#no_appointment_fee').text('')
					}
					if(result_data_json[0]['gender'] == 'Male'){
						$('.gender_details').empty()
						$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
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

`)
					}else if(result_data_json[0]['gender'] == 'Female'){
						$('.gender_details').empty()
						$('.gender_details').append(`
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Male">Male</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Female">Female</label>
								</span>
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Other">Other</label>
								</span>
								`)
					}else if(result_data_json[0]['gender'] == 'Other'){
						$('.gender_details').empty()
						$('.gender_details').append(`
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Male">Male</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Female">Female</label>
								</span>
								<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked>
      								<label for="Other">Other</label>
								</span>`)
					}
					
				}else{
					$('#appointment').val(appointment_data_fee)
					$('#name').attr('disabled',false)
					$('#address').attr('disabled',false)
					$('.gender_details').empty()
					$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
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
								</span>`)
					$('#unique_id_data').css('display','none')
					$('#unique_id').val("0")
				}
			}else{
				//$('#unique_id_data').css('display','none')
				//$('#unique_id').val("0")
				//create_custom_dropdowns1()
			}
			$('.toaster').addClass('toasterActive');
		setTimeout(function () {
			$('.toaster').removeClass('toasterActive');
		}, 2000)
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
				}
			})
		}
	}else{
		text_validation_number(phone_num,"number_error","*Invalid Phone Number!")
	}
	
				let theUserSearch = e.target.value.toLowerCase()
					  if(e.target.value === ''){
					  		$('.patientNameUl').css('display','block');
						  	$('.patientNameUl li').css('display','block');
					  }
					$('.patientNameUl li').length
					for(let i=0; i<$('.patientNameUl li').length; i++){
						$('.patientNameUl li').length
						let theLiVal = $('.patientNameUl li')[i].innerHTML.toLowerCase()
						if(theLiVal.includes(theUserSearch)){
							console.log(theLiVal)
							$('.patientNameUl li')[i].style.display = 'block';
								
					}else{
						$('.patientNameUl li')[i].style.display = 'none';
					}
					}
	
})