let url_val = window.location.href
let url_split = url_val.split('=');
let last_len = url_split.length
let last_index = last_len-1;
let val = url_split[last_index];

$.ajax({
	url:"action/staff/fetch_staff_data.php",
	type:"POST",
	data:{val:val},
	success:function(staff_result){
		let staff_result_json = jQuery.parseJSON(staff_result)
		console.log(staff_result_json)
		if(staff_result_json[0]['status'] == 1){
			if(staff_result_json[0]['data_status'] == 1){
				$('#staff_name').val(staff_result_json[0]['staff_name'])
				$('#staff_phn').val(staff_result_json[0]['staff_phone'])
				$('#staff_email').val(staff_result_json[0]['staff_email'])
				if(staff_result_json[0]['role'] == 'staff'){
					$('#role_data').append(`<option value="staff" selected>Appointment Staff</option>
								<option value="treatment_staff">Treatment Staff</option>`)
				}else if(staff_result_json[0]['role'] == 'treatment_staff'){
					$('#role_data').append(`<option value="staff">Appointment Staff</option>
								<option value="treatment_staff" selected>Treatment Staff</option>`)
				}
				
				let active_branch_id = staff_result_json[0]['branch_id']
				$.ajax({
					url:"action/branch/fetch_all_branch_no_limit.php",
					success:function(branch_result){
						let branch_result_json = jQuery.parseJSON(branch_result);
						if(branch_result_json.length !=0){
							for(let x1=0;x1<branch_result_json.length;x1++){
								if(branch_result_json[x1]['id'] == active_branch_id){
									$('#staff_branch').append(`<option value="${branch_result_json[x1]['id']}" selected >${branch_result_json[x1]['branch_name']}</option>`)
								}else{
									$('#staff_branch').append(`<option value="${branch_result_json[x1]['id']}">${branch_result_json[x1]['branch_name']}</option>`)
								}
							}
						}
					}
				})
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
$('#edit_staff').submit(function(e){
	e.preventDefault()
	let staff_name = $('#staff_name').val()
	let staff_phn = $('#staff_phn').val()
	let staff_email = $('#staff_email').val()
	let staff_branch = $('#staff_branch').val()
	let staff_role = $('#role_data').val()
	button_loader('edit-branch-btn')
	$.ajax({
		url:"action/staff/edit-staff.php",
		type:"POST",
		data:{staff_name:staff_name,
			  staff_phn:staff_phn,
			  staff_email:staff_email,
			  staff_branch:staff_branch,
			  staff_role:staff_role,
			  val:val
			 },
		success:function(result_data){
			console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			$('.toasterMessage').text(result_data_json[0]['msg'])
			$('#phone_error_msg').text('')
				$('#email_error_msg').text('')
			if(result_data_json[0]['status'] == 1){
				stop_loader('edit-branch-btn')
				$('.successTost').css('display','flex')
				$('.errorTost').css('display','none')
			}else if(result_data_json[0]['status'] == 0){
				stop_loader('edit-branch-btn')
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
			}else if(result_data_json[0]['status'] == 2){
				stop_loader('edit-branch-btn')
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
				window.location.href="staff-management.php";
			}, 2500)
			}
		}
	})
})