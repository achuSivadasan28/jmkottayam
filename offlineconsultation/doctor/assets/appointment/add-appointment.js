let doctor_search = '';
let appointment_data_fee = 0;
$.when(fetch_all_doctor()).then(function(){
	create_custom_dropdowns()
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
/**$.ajax({
	url:"action/profile/fetch_date_details.php",
	success:function(section_data){
		$('#date').val(section_data)
			$.when(update_doctor_time_slot(section_data)).then(function(){
		
			})
	}
})**/


create_custom_dropdowns1()
function fetch_all_doctor(){   
return $.ajax({
	url:"action/doctor/fetch_doctor_no_limit.php",
	type:"POST",
	data:{doctor_search:doctor_search},
	success:function(d_result){
		console.log(d_result)
			let result_data_json = jQuery.parseJSON(d_result)
			console.log(result_data_json)
			$('#date').val(result_data_json[0]['c_date'])
			$('#date').attr('min',result_data_json[0]['c_date'])
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
			console.log(option_val)
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


$('body').delegate('.amount_paid','keyup',function(){
	payment_valid()
})

function payment_valid(){
	let total_amt = 0;
	let actual_total_amt = $('#appointment').val()
	let payment_op_amt_len = $('.amount_paid').length
	let payment_loop_count = 0;
	//$('.total_amt_entered').val(0)
	$('.amount_paid').each(function(){
		total_amt += parseInt($(this).val())
		payment_loop_count++
		console.log("actual_total_amt "+actual_total_amt)
		console.log("total_amt "+total_amt)
	/*if(payment_op_amt_len == payment_loop_count){
			$('.total_amt_entered').val(total_amt)*/
			if(actual_total_amt != total_amt){
				$('#amt_error_msg').text('*Amount Mismatched!')
				//$('.amount_mismatch_value').val(1)
			}else{
				$('#amt_error_msg').text('')
				//$('.amount_mismatch_value').val(0)
			}
		//}
	})
}


$('.oldCheck').click(function(){

if($('.oldCheck').prop('checked') == true){
	$('#appointment').val(0)
	$('.nr_type').css('display','flex')
}
else{
$('.nr_checkBox').attr('checked', false);
$('.nr_type').css('display','none')
fetch_appointment_fee()
}
})

$('.nr_checkBox').click(function(){
	if($('input[name="nr_check"]:checked').val() == 'nr'){
		$('#appointment').val(100)
	}else if($('input[name="nr_check"]:checked').val() == '0'){
		$('#appointment').val(0)
	}
})
let width = 150;
let height = 0;
let video = null;
let photo = null;
let canvas = null;
let streaming = false;
let clickImage = '';
let streamer = null;
$('#picture').click((e)=>{
	e.preventDefault();

	$('.imageCapturePopup').fadeIn();
	$('.shimmer').fadeIn();
	video = document.getElementById('video');
	canvas = document.getElementById('canvas');
	photo = document.getElementById('image');
	startbutton = document.getElementById('capture');

	navigator.mediaDevices.getUserMedia({
			video: true,
			audio: false
		})
		.then(function(stream) {
		    streamer = stream;
			video.srcObject = stream;
			video.play();
		})
		.catch(function(err) {
			console.log("An error occurred: " + err);
		});

	video.addEventListener('canplay', function(ev) {
		if (!streaming) {
			height = video.videoHeight / (video.videoWidth / width);

			if (isNaN(height)) {
				height = width * (5 / 3);
			}
			height = width * 11/12;


			video.setAttribute('width', width);
			video.setAttribute('height', height);
			canvas.setAttribute('width', width);
			canvas.setAttribute('height', height);
			streaming = true;
		}
	}, false);

	startbutton.addEventListener('click', function(ev) {
		takePicture();
		ev.preventDefault();
	}, false);

	clearPhoto();



})
$('.closeimageCapturePopup').click(function(){
	$('.imageCapturePopup').fadeOut();
	$('.shimmer').fadeOut();
	stopVideoAccess()
})
function clearPhoto() {
	var context = canvas.getContext('2d');
	context.fillStyle = "#AAA";
	context.fillRect(0, 0, canvas.width, canvas.height);

	clickImage = canvas.toDataURL('image/png');
	photo.setAttribute('src', clickImage);
}

function takePicture() {
	var context = canvas.getContext('2d');
	if (width  && height) {
		canvas.width = width;
		canvas.height = height;
		context.drawImage(video, 0, 0,width,height)
		clickImage = canvas.toDataURL('image/png');
		photo.setAttribute('src', clickImage);
		$("#pimage").attr('src',clickImage);
		console.log(clickImage)
	}else{
		clearPhoto();
	}
}


function stopVideoAccess() {
	if (streamer) {
		const tracks = streamer.getTracks();
		tracks.forEach(track => track.stop());
		video.srcObject = null;
		streamer = null;
	}
}
$('.confirmconfirmAlert').click(function(){
	$('.confirmconfirmAlert').attr('disabled',true)
	$('.confirmconfirmAlert').text('Loading...')
	let name = $('#Pname').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
	let date = $('#date').val()
	let unique_id = $('#unique_id').val()
	let appointment_fee = $('#appointment').val()
	let height = $('#height').val()
	let weight = $('#weight').val()
	let blood_pressure = $('#blood_pressure').val()
	let allergies_if_any = $('#allergies_if_any').val()
	let current_medication = $('#current_medication').val()
	let present_illness = $('#present_illness').val()
	let any_surgeries = $('#any_surgeries').val()
	let any_metal_lmplantation = $('#any_metal_lmplantation').val()
	let whatsApp = $('#WhatsApp').val()
	let Fvisit = $('#Fvisit').val()
	let branch_id = $('#branch_id').val()
	let time_slot = 0;
	let image = $('#image').attr('src')
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
			time_slot = $(this).val()
		}
	})
	$.when(check_old_patient_status()).then(function(oldpatient_status){
		$.when(check_num_visit(oldpatient_status)).then(function(num_of_visit){
			$.when(fetch_array_details()).then(function(arr){
				//console.log(arr)
					$.ajax({
						url:"action/appointment/add_appointment.php",
						type:"POST",
						data:{name:name,
			  				number:number,
			  				address:address,
			  				place:place,
			  				age:age,
			  				gender_data:gender_data,
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
			  				Fvisit:Fvisit,
			  				whatsApp:whatsApp,
			  				appointment_fee:appointment_fee,
			  				arr:arr,
			  				old_patient:oldpatient_status,
			  				num_of_visit:num_of_visit,
							branch_id:branch_id,
							image:clickImage,
			 			},
						success:function(appointment_result){
						//console.log(appointment_result)
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
										window.location.href="offline-appointments.php";
									}, 2500)
								}
							}
						})
				})
		})
	})
})

function check_old_patient_status(){
	if($('.oldCheck').prop('checked') == true){
		return 1
	}else{
		return 0
	}
}

function check_num_visit(oldpatient_status){
	let num_of_visit = '';
	if(oldpatient_status == 1){
		 num_of_visit =$('#numofvisit').val();
	}
	return num_of_visit
}

function fetch_array_details(){
	let arr=[];
	let theThing = $('.given_payment')
	let i=0
	for(i=0; i<theThing.length;i++){
	let obj = {
	'payment_type': theThing[i].querySelector('.payment_details').value,
	'payment_amnt': theThing[i].querySelector('.amount_paid').value,
	}
	arr.push(obj)
	//return arr
		let i_val = i+1;
	//console.log("loop ;"+theThing.length)	
	//console.log("i_val :"+i_val)
	if(theThing.length == i_val){
		//console.log(arr)
		return arr
	}
	}
	
}

$('#appointment_btn').click(function(e){
	e.preventDefault();
	clear_text('name_error')
	clear_text('number_error')
	clear_text('doctor_required')
	clear_text('time_slot_required')
	button_loader('appointment_btn')
	let name = $('#Pname').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
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
		
	let error_msg = text_validation(name,"name_error","*Name Required!")
	error_msg += text_validation_number(number,"number_error","*Invalid Phone Number!")
		if(appointment_fee == ''){
				$('#appointment_fee').text('*Add Appointment Fee!')
				error_msg += 1;
			}else{
		if(time_slot == 0){
			$('#time_slot_required').text('*Choose Time Solt!')
			error_msg += 1;
		}
			}
	
	if(blood_pressure == ''){
		error_msg += 1;
		$('#blood_p_error').text('*Required!')
	}else{
		$('#blood_p_error').text('')
	}
	
	
	if(appointment_fee!=0){
	
let payment_option_len = $('.payment_details').length
let payment_option_loop = 0;
let payment_val = 0
		$('.payment_details').each(function(){
			if($(this).val() == 0){
				payment_val = 1
				$(this).parent().find('.payment_option_error').text('*Payment Type Is Required!')
			}else{
				$(this).parent().find('.payment_option_error').text('')
			}
			payment_option_loop++
			console.log("payment_option_len "+payment_option_len)
			console.log("payment_option_loop "+payment_option_loop)
			console.log("payment_val "+payment_val)
			if(payment_option_len == payment_option_loop){
				if(payment_val !=0){
					error_msg += 1;
				}else{
					
				}
			}
	
		})
	
	
	let total_amt_to_pay = 0;
	let apnmnt_amt = $('#appointment').val()
	let payment_op_amt_len = $('.amount_paid').length
	let payment_loop_count = 0;
$('.amount_paid').each(function(){
		total_amt_to_pay += parseInt($(this).val())
		payment_loop_count++
	if(payment_op_amt_len == payment_loop_count){
if(apnmnt_amt != total_amt_to_pay){
				$('#amt_error_msg').text('*Amount Mismatched!')
				error_msg += 1;
			}else{
				$('#amt_error_msg').text('')
				
			}
	}
		})
	

}else{

	}
	
	
	
	console.log(error_msg)
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
$('#blood_pressure').keyup(function(){
	console.log("haiii")
	let blood_p = $(this).val().trim()
	if(blood_p != ''){
		$('#blood_p_error').text('')
	}else{
		
		$('#blood_p_error').text('*Required')
	}
})
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
			if(result_data_json[0]['branch_id'] != undefined){
				$('#branch_id').val(result_data_json[0]['branch_id'])
				$('#branch_name').text(result_data_json[0]['branch_name'])
			}else {
				$('#branch_id').val(0)
				$('#branch_name').text('')
			}
			$('.patientNameUl').empty()
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					$('.nr_type').css('display','flex')
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

$('#doctor_data').change(function(){
	let doctor_id = $(this).val()
	let date = $('#date').val();
	if(doctor_id != ''){
	clear_text('doctor_required')

	$.when(update_doctor_time_slot(doctor_id,date)).then(function(){
		
	})
			}
})

$('#date').change(function(){
	let doctor_id = $('#doctor_data').val()
	let date = $(this).val();
	$.when(update_doctor_time_slot(doctor_id,date)).then(function(){
		
	})
})

function update_doctor_time_slot(doctor_id,date){
	$('.doctor_available_all_time_solt').empty()
	$.ajax({
		url:"action/doctor/fetch_doctor_time_slot.php",
		type:"POST",
		data:{doctor_id:doctor_id,
			 date:date
			 },
		success:function(doctor_result){
			console.log(doctor_result)
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
		console.log(error_id)
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
		$('body').delegate('.patientNameUl li','click',(e)=>{
			$('.patientNameUl').css('display','none')
		//console.log(e.target.innerHTML);
			let thePN = $('.patientNameValue');
			thePN.val(e.target.innerHTML)
			let user_name = thePN.val()
			console.log(user_name)
			let phone_num = $('#number').val()
			let branch_id = $('#branch_id').val();
			if(phone_num.length == 10 || phone_num.length == 12){
		if(user_name != ''){
			$.ajax({
				url:"action/appointment/fetch_user_on_name.php",
				type:"POST",
				data:{user_name:user_name,
					 phone_num:phone_num,
					  branch_id:branch_id,
					 },
				success:function(user_result){
					
			let result_data_json = jQuery.parseJSON(user_result)
			console.log(result_data_json)
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					$('.nr_checkBox').attr('checked', false);
					$('.op').css('display','none')
					$('.oldVisitCount').css('display','none')
					$('#unique_id_data').css('display','flex')
					if(result_data_json[0]['doctor_name'] != ''){
						$('#pvDoctor').val(result_data_json[0]['doctor_name'])
						$('.previousDoctor').css('display','flex')
					}else{
						$('.previousDoctor').css('display','none')
					}
					$('#unique_id').val(result_data_json[0]['unique_id'])
					//$('#name').attr('disabled',true)
					//$('#address').attr('disabled',true)
					//$('#name').val(result_data_json[0]['name'])
					//$('.patientNameUl').append(`<li>${result_data_json[0]['name']}</li>`)
					//$('#number').val(result_data_json[0]['phone'])
					if(result_data_json[0]['image'] != "" && result_data_json[0]['image'] != undefined){
						$('#pimage').attr('src',`${result_data_json[0]['image_url']}/jmwell_universe/pala_jmwell/offlineconsultation/staff/assets/patientimages/${result_data_json[0]['image']}`)
					
					}
					$('#address').val(result_data_json[0]['address'])
					$('#place').val(result_data_json[0]['place'])
					$('#age').val(result_data_json[0]['age'])
					$('#WhatsApp').val(result_data_json[0]['whatsApp'])
					$('#Fvisit').val(result_data_json[0]['first_visit'])
					if(result_data_json[0]['appointment_fee'] == 0){
						$('#appointment').val(0)
						$('#no_appointment_fee').text(result_data_json[0]['appointment_fee_msg'])
					}else if(result_data_json[0]['appointment_fee'] == 1){
						$('#appointment').val(result_data_json[0]['appointment_fee_nr'])
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
					$('#Pname').attr('disabled',false)
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



$('#numofvisit').keyup(function(e){
			let current_visit = $(this).val();
			if( current_visit !=''){
				$.ajax({
				url:"action/appointment/fetchcurrentapmntfee.php",
				type:"POST",
				data:{current_visit:current_visit,
},
				success:function(user_result){
			let result_data_json = jQuery.parseJSON(user_result)
			console.log(result_data_json)
					$('#appointment').val(result_data_json[0]['appointmentfee'])
				}
				})
				
			}
		})

$('.patientNameValue').keyup(function(e){
	let user_name = $(this).val();
	let phone_num = $('#number').val();
	let branch_id = $('#branch_id').val();
	if(phone_num.length == 10 || phone_num.length == 12){
		if(user_name != ''){
			$.ajax({
				url:"action/appointment/fetch_user_on_name.php",
				type:"POST",
				data:{user_name:user_name,
					 phone_num:phone_num,
					  branch_id:branch_id
					 },
				success:function(user_result){
			let result_data_json = jQuery.parseJSON(user_result)
			console.log(result_data_json)
			if(result_data_json[0]['status'] == 1){
				if(result_data_json[0]['data_exist'] == 1){
					$('.op').css('display','none')
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
					$('#WhatsApp').val(result_data_json[0]['whatsApp'])
					console.log(result_data_json[0]['whatsApp'])
					$('#age').val(result_data_json[0]['age'])
					console.log(appointment_data_fee)
					if(result_data_json[0]['appointment_fee'] == 0){
						$('#appointment').val(0)
						$('#no_appointment_fee').text(result_data_json[0]['appointment_fee_msg'])
					}else if(result_data_json[0]['appointment_fee'] == 1){
						$('#appointment').val(result_data_json[0]['appointment_fee_nr'])
						$('#no_appointment_fee').text(' ')
						//$('#appointment').val(result_data_json[0]['appointment_fee_nr'])
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
					$('.op').css('display','flex')
					$('#appointment').val(appointment_data_fee)
					$('#Pname').attr('disabled',false)
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