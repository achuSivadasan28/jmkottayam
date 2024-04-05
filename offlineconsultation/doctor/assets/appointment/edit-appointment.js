let url_data = window.location.href;
let url_split = url_data.split('=');
let url_val = url_split[1];
let doctor_search = '';
let org_date = '';
let global_added_time_slot = 0;
//fetch appointment details from tbl_appointment and tbl_patient

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
$.ajax({
	url:"action/appointment/fetch_appointment_data_d.php",
	type:"POST",
	data:{url_val:url_val},
	success:function(result_data){
		let result_data_json = jQuery.parseJSON(result_data)
		console.log(result_data_json)
		if(result_data_json[0]['status'] == 1){
			$('#number').val(result_data_json[0]['phone'])
			$('#unique_id').val(result_data_json[0]['unique_id'])
			$('#name1').val(result_data_json[0]['name'])
			$('#address').val(result_data_json[0]['address'])
			$('#place').val(result_data_json[0]['place'])
			$('#age').val(result_data_json[0]['age'])
			$('#date').val(result_data_json[0]['appointment_date'])
			$('#date').attr('min',result_data_json[0]['c_date'])
			console.log(result_data_json[0]['first_visit'])
			$('#fVisit').val(result_data_json[0]['first_visit'])
			$('#WhatsApp').val(result_data_json[0]['whatsApp'])
			org_date = result_data_json[0]['appointment_date']
			if(result_data_json[0]['image'] != "" && result_data_json[0]['image'] != undefined){
				$('#pimage').attr('src',`${result_data_json[0]['image_url']}//jmwell_24/offlineconsultation/staff/assets/patientimages/${result_data_json[0]['image']}`)
					
					}
			$('#unique_id').val(result_data_json[0]['unique_id'])
			if(result_data_json[0]['gender'] == 'Male'){
				$('.gender_details').append(`<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked=true>
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
				$('.gender_details').append(`
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Male">Male</label>
								</span>
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked=true>
      								<label for="Female">Female</label>
								</span>
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Other">Other</label>
								</span>
`)
				
			}else if(result_data_json[0]['gender'] == 'Other'){
				$('.gender_details').append(`
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Male"  id="Male" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Male">Male</label>
								</span>
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Female" id="Female" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data">
      								<label for="Female">Female</label>
								</span>
<span style="display: flex; flex: 0 0 30%; align-item: center;">
									<input type="radio" value="Other" id="Other" style="width: 20px; height: 20px; margin-top: 0px; margin-right: 10px;" name="gender_data" checked=true>
      								<label for="Other">Other</label>
								</span>`)
				
			}
			$('#height').val(result_data_json[0]['height'])
			$('#weight').val(result_data_json[0]['weight'])
			$('#blood_pressure').val(result_data_json[0]['blood_pressure'])
			$('#allergies_if_any').val(result_data_json[0]['allergies_if_any'])
			$('#current_medication').val(result_data_json[0]['current_medication'])
			$('#present_illness').val(result_data_json[0]['present_Illness'])
			$('#any_surgeries').val(result_data_json[0]['any_surgeries'])
			$('#any_metal_lmplantation').val(result_data_json[0]['any_metal_Implantation'])
			let appointment_time_slot_id = result_data_json[0]['appointment_time_slot_id']
			global_added_time_slot = appointment_time_slot_id;
			update_doctor_time_slot(result_data_json[0]['doctor_id'],result_data_json[0]['appointment_date'],appointment_time_slot_id,0)
			
			
		}else{
			$('.toasterMessage').text(result_data_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			if(result_data_json[0]['status'] == 0){
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}
	}
})

function fetch_all_doctor($doctor_id){   
return $.ajax({
	url:"action/doctor/fetch_doctor_no_limit.php",
	type:"POST",
	data:{doctor_search:doctor_search},
	success:function(d_result){
			let result_data_json = jQuery.parseJSON(d_result)
			
			$('#date').val(result_data_json[0]['c_date'])
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
					if(result_data_json[x]['login_id'] == $doctor_id){
					$('#doctor_data').append(`
					<option value="${result_data_json[x]['login_id']}" selected="true">${result_data_json[x]['doctor_name_dep']}</option>
					`)
					}else{
					$('#doctor_data').append(`
					<option value="${result_data_json[x]['login_id']}">${result_data_json[x]['doctor_name_dep']}</option>
					`)
					}
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

$('#doctor_data').change(function(){
	let doctor_id = $(this).val()
	let date = $('#date').val();
	if(doctor_id != ''){
	clear_text('doctor_required')

	$.when(update_doctor_time_slot(doctor_id,date,0)).then(function(){
		
	})
			}
})

function update_doctor_time_slot(doctor_id,date,added_time_slot){
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
				if(org_date == date){
				if(global_added_time_slot == doctor_result_json[x1]['id']){
				$('.doctor_available_all_time_solt').append(`<label class="control" for="${doctor_result_json[x1]['id']}">
									<input type="radio" class="time_slot_data" name="topics" id="${doctor_result_json[x1]['id']}" value="${doctor_result_json[x1]['id']}" ${limit_status_data} checked=true >
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${doctor_result_json[x1]['start_time']} ${doctor_result_json[x1]['f_time_section']} - ${doctor_result_json[x1]['end_time']} ${doctor_result_json[x1]['l_time_section']}</p>
									</span>
								</label>`)
				}else{
				$('.doctor_available_all_time_solt').append(`<label class="control" for="${doctor_result_json[x1]['id']}">
									<input type="radio" class="time_slot_data" name="topics" id="${doctor_result_json[x1]['id']}" value="${doctor_result_json[x1]['id']}" ${limit_status_data}>
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${doctor_result_json[x1]['start_time']} ${doctor_result_json[x1]['f_time_section']} - ${doctor_result_json[x1]['end_time']} ${doctor_result_json[x1]['l_time_section']}</p>
									</span>
								</label>`)
				}
				}else{
				if(added_time_slot == doctor_result_json[x1]['id']){
				$('.doctor_available_all_time_solt').append(`<label class="control" for="${doctor_result_json[x1]['id']}">
									<input type="radio" class="time_slot_data" name="topics" id="${doctor_result_json[x1]['id']}" value="${doctor_result_json[x1]['id']}" ${limit_status_data} checked=true >
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${doctor_result_json[x1]['start_time']} ${doctor_result_json[x1]['f_time_section']} - ${doctor_result_json[x1]['end_time']} ${doctor_result_json[x1]['l_time_section']}</p>
									</span>
								</label>`)
				}else{
				$('.doctor_available_all_time_solt').append(`<label class="control" for="${doctor_result_json[x1]['id']}">
									<input type="radio" class="time_slot_data" name="topics" id="${doctor_result_json[x1]['id']}" value="${doctor_result_json[x1]['id']}" ${limit_status_data}>
									<span class="control__content">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${doctor_result_json[x1]['start_time']} ${doctor_result_json[x1]['f_time_section']} - ${doctor_result_json[x1]['end_time']} ${doctor_result_json[x1]['l_time_section']}</p>
									</span>
								</label>`)
				}
				}
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

function clear_text(id_clear){
	$('#'+id_clear).text(' ')
}
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

	clickImage= canvas.toDataURL('image/png');
	photo.setAttribute('src', clickImage);
}

function takePicture() {
	var context = canvas.getContext('2d');
	if (width  && height) {
		canvas.width = width;
		canvas.height = height;
		context.drawImage(video, 0, 0,width,height)
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
	$('.confirmconfirmAlert').text('Lodaing...')
	$('.confirmconfirmAlert').css('disabled',true)
	let name = $('#name1').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
	//let doctor_data = $('#doctor_data').val()
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
	let fVisit = $('#fVisit').val()
	let WhatsApp = $('#WhatsApp').val()
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
			time_slot = $(this).val()
		}
	})
	$.ajax({
		url:"action/appointment/update_appointment.php",
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
			  url_val:url_val,
			  fVisit:fVisit,
			  WhatsApp:WhatsApp,
			  image:clickImage
			 },
		success:function(appointment_result){
			let result_data_json = jQuery.parseJSON(appointment_result)
			console.log(result_data_json)
			if(result_data_json[0]['status'] == 0){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('.confirmAlert').hide();
				$('.shimmer').fadeOut();
				setTimeout(function(){
					window.location.href="../login.php"
				},1500)
			}else if(result_data_json[0]['status'] == 1){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','none')
				$('.successTost').css('display','flex')
			}else if(result_data_json[0]['status'] == 2){
				$('.toasterMessage').text(result_data_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('.confirmconfirmAlert').text('Confirm')
				//$('.appointment_btn').text('Save')
				stop_loader('appointment_btn')
				$('.confirmAlert').hide();
				$('.shimmer').fadeOut();
				$('.confirmconfirmAlert').css('disabled',false)
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

$('#appointment_btn').click(function(e){

	e.preventDefault();
	clear_text('name_error')
	clear_text('number_error')
	clear_text('doctor_required')
	clear_text('time_slot_required')
	button_loader('appointment_btn')
	let name = $('#name1').val()
	let number = $('#number').val()
	let address = $('#address').val()
	let place = $('#place').val()
	let age = $('#age').val()
	let gender_data = $('input[name="gender_data"]:checked').val()
	let doctor_data = $('#doctor_data').val()
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
	let appointment_fee = 10;
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
			time_slot = $(this).val()
		}
	})
		
	let error_msg = text_validation(name,"name_error","*Name Required!")
	error_msg += text_validation_number(number,"number_error","*Invalid Phone Number!")
	if(doctor_data == ''){
		error_msg += 1;
		$('#doctor_required').text('*Required!')
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

$('.closeconfirmAlert').click(function(){
			$('.confirmAlert').hide();
			$('.shimmer').fadeOut();
			stop_loader('appointment_btn')
})

$('#date').change(function(){
	let doctor_id = $('#doctor_data').val()
	let date = $(this).val();
	$.when(update_doctor_time_slot(doctor_id,date,0)).then(function(){
		
	})
})