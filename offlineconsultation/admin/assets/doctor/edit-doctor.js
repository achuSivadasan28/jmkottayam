let url_val = window.location.href
let url_split = url_val.split('=');
let last_len = url_split.length
let last_index = last_len-1;
let val = url_split[last_index];
let Active_time_slot_single = [];
$.ajax({
	url:"action/doctor/fetch_doctor_data.php",
	type:"POST",
	data:{val:val},
	success:function(branch_result){
		let branch_result_json = jQuery.parseJSON(branch_result)
		console.log(branch_result_json)
		if(branch_result_json[0]['status'] == 1){
			if(branch_result_json[0]['data_status'] == 1){
				$('#doctor_name').val(branch_result_json[0]['doctor_name'])
				$('#phnNo').val(branch_result_json[0]['phone_no'])
				$('#email').val(branch_result_json[0]['email'])
				let active_dep_id = branch_result_json[0]['department_id']
				let active_branch_id = branch_result_json[0]['branch_id']
				let Active_time_slot = branch_result_json[0]['timeSlot']
				let role = branch_result_json[0]['role']
				if(role == 'doctor'){
					$('#role_data').append(`<option value="${role}" selected >Doctor</option>
											<option value ='cheaf_doctor'>Cheaf Doctor</option>`)
				}else{
					$('#role_data').append(`<option value="${role}" selected >Cheaf Doctor</option>
											<option value ='doctor'>Doctor</option>`)
				}
				
				if(Active_time_slot != undefined){
				for(let b1=0;b1<Active_time_slot.length;b1++){
					Active_time_slot_single.push(Active_time_slot[b1]['timeSlotId'])
				}
				}
				console.log(Active_time_slot_single)
				$.ajax({
					url:"action/department/fetch_all_department_no_limit.php",
					success:function(department_result){
						let department_result_json = jQuery.parseJSON(department_result);
						console.log(department_result_json)
						if(department_result_json.length !=0){
							for(let x1=0;x1<department_result_json.length;x1++){
								if(department_result_json[x1]['id'] == active_dep_id){
									$('#department_data').append(`<option value="${department_result_json[x1]['id']}" selected >${department_result_json[x1]['department_name']}</option>`)
								}else{
									$('#department_data').append(`<option value="${department_result_json[x1]['id']}">${department_result_json[x1]['department_name']}</option>`)
								}
							}
						}
					}
				})
				$.ajax({
					url:"action/branch/fetch_all_branch_no_limit.php",
					success:function(branch_result){
						let branch_result_json = jQuery.parseJSON(branch_result);
						console.log(branch_result_json)
						if(branch_result_json.length !=0){
							for(let x1=0;x1<branch_result_json.length;x1++){
								if(branch_result_json[x1]['id'] == active_branch_id){
									$('#branch_data').append(`<option value="${branch_result_json[x1]['id']}" selected >${branch_result_json[x1]['branch_name']}</option>`)
								}else{
									$('#branch_data').append(`<option value="${branch_result_json[x1]['id']}">${branch_result_json[x1]['branch_name']}</option>`)
								}
							}
						}
					}
				})
				if(branch_result_json[0]['timeSlot1'] == 1){
					$('.assign_time_slot').attr('checked',true)
					$('.offlineConsultingDetails').css('display','block')
					$.ajax({
						url:"action/doctor/fetch_all_time_slot.php",
						success:function(time_data){
							let time_data_json = jQuery.parseJSON(time_data);
							if(time_data_json[0]['data_status']!= 0){
								for(let v1=0;v1<time_data_json.length;v1++){
									let time_slot_id_v1 = time_data_json[v1]['id']
									let time_slot_v1 = time_data_json[v1]['start_time'] +' '+time_data_json[v1]['f_time_section']+' - '+time_data_json[v1]['end_time']+' '+time_data_json[v1]['l_time_section']
								
									
											if(Active_time_slot_single.includes(time_slot_id_v1)){
												
												$('.slotList').append(`<label class="control" for="technology">
									<input type="checkbox" name="topics" id="technology" checked='true' value="${time_slot_id_v1}" class="time_slot_data">
									<span class="control__content" style="flex-direction: column">
				<p>${time_data_json[v1]['slot_name']}</p>
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${time_slot_v1}</p>
									</span>
								</label>`)
											}else{
												$('.slotList').append(`<label class="control" for="technology">
									<input type="checkbox" name="topics" id="technology" value="${time_slot_id_v1}" class="time_slot_data">
									<span class="control__content" style="flex-direction: column">
<p>${time_data_json[v1]['slot_name']}</p>
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${time_slot_v1}</p>
									</span>
								</label>`)
											}
										
									
								}
								$('.slotList').append(`<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>`)
							}
							
						}
					})
				}else{
					$.ajax({
						url:"action/doctor/fetch_all_time_slot.php",
						success:function(time_data){
							let time_data_json = jQuery.parseJSON(time_data);
							if(time_data_json[0]['data_status']!= 1){
								for(let v1=0;v1<time_data_json.length;v1++){
									let time_slot_id_v1 = time_data_json[v1]['id'];
									let time_slot_v1 = time_data_json[v1]['start_time'] +' '+time_data_json[v1]['f_time_section']+' - '+time_data_json[v1]['end_time']+' '+time_data_json[v1]['l_time_section']
											$('.slotList').append(`<label class="control" for="technology">
									<input type="checkbox" name="topics" id="technology" value="${time_slot_id_v1}" class="time_slot_data">
									<span class="control__content" style="flex-direction: column">
<p>${time_data_json[v1]['slot_name']}</p>
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${time_slot_v1}</p>
									</span>
								</label>`)
								}
							}
							$('.slotList').append(`<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>`)
						}
					})
				}
				
			}else{
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}else{
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
		}
	}
})


//edit brnach
$('#edit_doctor').submit(function(e){
	e.preventDefault()
	$('#phone_error_msg').text(' ')
	$('#email_error_msg').text(' ')
	let doctor_name = $('#doctor_name').val()
	let phnNo = $('#phnNo').val()
	let email = $('#email').val()
	let department_data = $('#department_data').val()
	let branch_data = $('#branch_data').val()
	let time_slot_check_id_data = 0;
	let role = $('#role_data').val();
	if($('.assign_time_slot').prop('checked') == true){
		time_slot_check_id_data = 1;
	}
	$.when(fetch_time_slot_details()).then(function(time_slot){
	button_loader('edit_doctor_btn')
	if(phnNo.length == 10 || phnNo.length == 12){
	$.ajax({
		url:"action/doctor/edit-doctor.php",
		type:"POST",
		data:{doctor_name:doctor_name,
			  phnNo:phnNo,
			  email:email,
			  department_data:department_data,
			  branch_data:branch_data,
			  val:val,
			  time_slot:time_slot,
			  time_slot_check_id_data:time_slot_check_id_data,
			  role:role,
			 },
		success:function(branch_result){
			console.log(branch_result)
			let branch_result_json = jQuery.parseJSON(branch_result)
			if(branch_result_json[0]['status'] == 1){
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','none')
			$('.successTost').css('display','flex')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				stop_loader('edit_doctor_btn');
				window.location.href="doctor-management.php";
			}, 2500)
			}else if(branch_result_json[0]['status'] == 2){
				stop_loader('edit_doctor_btn')
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('#phone_error_msg').text(branch_result_json[0]['phn_error'])
				$('#email_error_msg').text(branch_result_json[0]['email_error'])
			}else if(branch_result_json[0]['status'] == 0){
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
		}
	
	})
	}else{
		$('#phone_error_msg').text('Invalid Phone No')
		$('#edit_doctor_btn').text('Save')
		$('#edit_doctor_btn').prop('disabled',false)
	}
})
})

function fetch_time_slot_details(){
	let solt_arr = [];
	$('.time_slot_data').each(function(){
		if($(this).prop('checked') == true){
		let slot_id = $(this).val()
		solt_arr.push(slot_id)
		
		}
	})
	return solt_arr
}

$('.assign_time_slot').click(function(){
	if($(this).prop('checked') == true){
		$('.offlineConsultingDetails').css('display','block')
		if(Active_time_slot_single.length == 0){
			fetch_all_time_slot()
		}
	}else{
		$('.offlineConsultingDetails').css('display','none')
	}
})

function fetch_all_time_slot(){
	$('.slotList').empty()
				$.ajax({
						url:"action/doctor/fetch_all_time_slot.php",
						success:function(time_data){
							let time_data_json = jQuery.parseJSON(time_data);
						
							if(time_data_json[0]['data_status']!= 0){
								for(let v1=0;v1<time_data_json.length;v1++){
									let time_slot_id_v1 = time_data_json[v1]['id']
									
									let time_slot_v1 = time_data_json[v1]['start_time'] +' '+time_data_json[v1]['f_time_section']+' - '+time_data_json[v1]['end_time']+' '+time_data_json[v1]['l_time_section']
								
											$('.slotList').append(`<label class="control" for="technology">
									<input type="checkbox" name="topics" id="technology" value="${time_slot_id_v1}" class="time_slot_data">
									<span class="control__content" style="flex-direction: column">
<p>${time_data_json[v1]['slot_name']}</p>
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${time_slot_v1}</p>
									</span>
								</label>`)
											
										
									
								}
							}
							$('.slotList').append(`<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>`)
						}
					})
				}
