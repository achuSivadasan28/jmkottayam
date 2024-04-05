$('#add-doctor').submit(function(e){
	e.preventDefault()
	let docotor_name = $('#docotor_name').val()
	let phone_no = $('#phone_no').val()
	let email = $('#email').val()
	let department_data = $('#department_data').val()
	let branch_data = $('#branch_data').val()
	let role = $('#role_data').val();
	
	button_loader('add-doctor-btn')
	$.when(fetch_all_slot()).then(function(time_slot_arr){
    if(phone_no.length == 12 || phone_no.length == 10){
	$.ajax({
		url:"action/doctor/add_doctor.php",
		type:"POST",
		data:{docotor_name:docotor_name,
			 phone_no:phone_no,
			  email:email,
			  department_data:department_data,
			  branch_data:branch_data,
			  time_slot_arr:time_slot_arr,
			  role:role,
			  
			 },
		success:function(result_data){
			console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			$('.toasterMessage').text(result_data_json[0]['msg'])
			$('#phone_error_msg').text('')
				$('#email_error_msg').text('')
			if(result_data_json[0]['status'] == 1){
				stop_loader('add-doctor-btn')
				$('.successTost').css('display','flex')
				$('.errorTost').css('display','none')
			}else if(result_data_json[0]['status'] == 0){
				stop_loader('add-doctor-btn')
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
			}else if(result_data_json[0]['status'] == 2){
				stop_loader('add-doctor-btn')
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('#phone_error_msg').text(result_data_json[0]['phn_error'])
				$('#email_error_msg').text(result_data_json[0]['email_error'])
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
				window.location.href="doctor-management.php";
			}, 2500)
			}
		}
	})
	}else{
		$('#phone_error_msg').text('invalid phone no')
		$('#add-doctor-btn').text('Save')
		$('#add-doctor-btn').prop('disabled',false)
	}			
	})
	
})

$.ajax({
	url:"action/department/fetch_all_department_no_limit.php",
	success:function(result){
		let result_json = jQuery.parseJSON(result)
		if(result_json[0]['status'] == 1){
			if(result_json[0]['data_status'] == 1){
				$('#department_data').empty()
				$('#department_data').append(`<option value="" selected='true' disabled='true'>Department Name</option>`)
				for(let dep=0;dep<result_json.length;dep++){
					$('#department_data').append(`<option value="${result_json[dep]['id']}">${result_json[dep]['department_name']}</option>`)
				}
			}else{
				$('#department_data').empty()
				$('#department_data').append(`<option value="" selected='true' disabled='true'>No Data</option>`)
			}
			
		}else{
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

$.ajax({
	url:"action/branch/fetch_all_branch_no_limit.php",
	success:function(result){
		let result_json = jQuery.parseJSON(result)
		if(result_json[0]['status'] == 1){
			if(result_json[0]['data_status'] == 1){
				$('#branch_data').empty()
				$('#branch_data').append(`<option value="" selected='true' disabled='true'>Branch Name</option>`)
				for(let brn = 0;brn<result_json.length;brn++){
					$('#branch_data').append(`<option value="${result_json[brn]['id']}">${result_json[brn]['branch_name']}</option>`)
				}
			}else{
				$('#branch_data').empty()
				$('#branch_data').append(`<option value="" selected='true' disabled='true'>No Data</option>`)
			}
			
		}else{
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

$('.assign_time_slot').click(function(){
	
	if($(this).prop('checked') == true){
		$.ajax({
			url:"action/doctor/fetch_all_time_slot.php",
			success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			if(result_data_json[0]['status'] == 1){
			$('.slotList').empty()
			if(result_data_json[0]['data_status'] == 1){
				for(let x2=0;x2<result_data_json.length;x2++){
					let block_display = "";
					if(result_data_json[x2]['time_status'] == 2){
						block_display = "disabled=''";
					}
					$('.slotList').append(`<label class="control" for="${result_data_json[x2]['id']} ">
									<input type="checkbox" name="topics" id="${result_data_json[x2]['id']}" ${block_display} value="${result_data_json[x2]['id']}" class="time_slot">
									<span class="control__content" style="flex-direction: column">
<p>${result_data_json[x2]['slot_name']}</p>
<div style="width: 100%; display: flex;">
										<div class="timeIcon">
											<i class="uil uil-clock-three"></i>
										</div>
										<p>${result_data_json[x2]['start_time']} ${result_data_json[x2]['f_time_section']} - ${result_data_json[x2]['end_time']} ${result_data_json[x2]['l_time_section']}</p>
</div>
									</span>
								</label>`);
				
				}
				$('.slotList').append(`<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>
								<div class="dummyDiv"></div>`)
			}else{
				$('.slotList').empty()
			}
		}else{
			$('.slotList').empty()
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			}
			}
		})
		$('.offlineConsultingDetails').css('display','block')
		
	}else{
		$('.offlineConsultingDetails').css('display','none')
	}
})

function fetch_all_slot(){
	let slot_id_arr = [];
	$('.time_slot').each(function(){
		if($(this).prop('checked') == true){
			let slot_id = $(this).val()
			slot_id_arr.push(slot_id)
		}
	})
	return slot_id_arr;
}