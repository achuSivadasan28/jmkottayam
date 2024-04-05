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
		if(staff_result_json[0]['status'] == 1){
			if(staff_result_json[0]['data_status'] == 1){
				$('#doctor_name').val(staff_result_json[0]['doctor_name'])
				$('#phnNo').val(staff_result_json[0]['phone_no'])
				$('#email').val(staff_result_json[0]['email'])
				let active_dep_id = staff_result_json[0]['department_id']
				let active_branch_id = staff_result_json[0]['branch_id']
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
	let doctor_name = $('#doctor_name').val()
	let phnNo = $('#phnNo').val()
	let email = $('#email').val()
	let department_data = $('#department_data').val()
	let branch_data = $('#branch_data').val()
	button_loader('edit_doctor_btn')
	$.ajax({
		url:"action/doctor/edit-doctor.php",
		type:"POST",
		data:{doctor_name:doctor_name,
			  phnNo:phnNo,
			  email:email,
			  department_data:department_data,
			  branch_data:branch_data,
			  val:val
			 },
		success:function(branch_result){
			console.log(branch_result)
			let branch_result_json = jQuery.parseJSON(branch_result)
			console.log(branch_result_json)
			console.log(branch_result_json[0]['status'])
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
})