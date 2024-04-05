$('#addstaff').submit(function(e){
	e.preventDefault()
	$('#phone_error_msg').text('')
	$('#email_error_msg').text('')
	button_loader('add-staff-btn')
	let staff_name = $('#staff_name').val()
	let staff_phn = $('#staff_phn').val()
	let staff_email = $('#staff_email').val()
	let branch_name = $('#branch_name').val()
	$.ajax({
		url:"action/staff/add-lab-staff.php",
		type:"POST",
		data:{staff_name:staff_name,
			  staff_phn:staff_phn,
			  branch_name:branch_name,
			  staff_email:staff_email
			 },
		success:function(result_data){
			console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			$('.toasterMessage').text(result_data_json[0]['msg'])
			
			if(result_data_json[0]['status'] == 1){
				stop_loader('add-staff-btn')
				$('.successTost').css('display','flex')
				$('.errorTost').css('display','none')
			}else if(result_data_json[0]['status'] == 0){
				stop_loader('add-staff-btn')
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
			}else if(result_data_json[0]['status'] == 2){
				stop_loader('add-staff-btn')
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
				window.location.href="lab-station.php";
			}, 2500)
			}
		}
	})
})

$.ajax({
	url:"action/branch/fetch_all_branch_no_limit.php",
	success:function(branch_result){
		let branch_result_json = jQuery.parseJSON(branch_result)
		if(branch_result_json.length !=0){
			$('#branch_name').append(`<option value="" disabled=true selected=true>Branch</option>`)
			if(branch_result_json[0]['data_status'] !=0){
		for(let x=0;x<branch_result_json.length;x++){
			$('#branch_name').append(`<option value="${branch_result_json[x]['id']}">${branch_result_json[x]['branch_name']}</option>`)
		}
			}else{
				$('#branch_name').append(`<option value="" disabled=true selected=true>No Data</option>`)
			}
		}else{
			$('#branch_name').append(`<option value="" disabled=true selected=true>No Data</option>`)
		}
	}
})