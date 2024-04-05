/**let url_val = window.location.href
let url_split = url_val.split('=');
let last_len = url_split.length
let last_index = last_len-1;
let val = url_split[last_index];**/

$.ajax({
	url:"action/profile/fetch_all_profile_details.php",
	success:function(profile_result){
		let profile_result_json = jQuery.parseJSON(profile_result)
		if(profile_result_json[0]['status'] == 1){
			$('#staff_phone').val(profile_result_json[0]['staff_phone'])
			$('#staff_name').val(profile_result_json[0]['staff_name'])
			let branch_id = profile_result_json[0]['branch_id']
			$.ajax({
				url:"action/branch/fetch_all_branch.php",
				success:function(all_branch_result){
					let all_branch_result_json = jQuery.parseJSON(all_branch_result)
					for(let x1=0;x1<all_branch_result_json.length;x1++){
						if(all_branch_result_json[x1]['id'] == branch_id){
							$('#branch_data').append(`<option value="${all_branch_result_json[x1]['id']}" selected>${all_branch_result_json[x1]['branch_name']}</option>`)
						}else{
							$('#branch_data').append(`<option value="${all_branch_result_json[x1]['id']}">${all_branch_result_json[x1]['branch_name']}</option>`)
						}
					}
				}
			})
			//$('#edit_data').attr('href','edit-profile.php?id='+profile_result_json[0]['login_id'])
			$('#edit_data').attr('href','edit-profile.php')
		}else{
			$('.toasterMessage').text(profile_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
		}
	}
})

$('#staff_edit').submit(function(e){
	e.preventDefault()
	let staff_name = $('#staff_name').val()
	let staff_phone = $('#staff_phone').val()
	let branch_data = $('#branch_data').val()
	button_loader('edit_profile_btn')
	$('#phn_number_error').text('')
	$.ajax({
		url:"action/profile/edit_profile_data.php",
		type:"POST",
		data:{staff_name:staff_name,
			 staff_phone:staff_phone,
			  branch_data:branch_data
			 },
		success:function(result){
			let result_json = jQuery.parseJSON(result)
			if(result_json[0]['status'] == 1){
				if(result_json[0]['data_status'] == 0){
					stop_loader("edit_profile_btn")
				$('.toasterMessage').text(result_json[0]['msg'])
				$('.errorTost').css('display','flex')
				$('.successTost').css('display','none')
				$('#phn_number_error').text('*Phone Number Already Exist!')
					$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
				}else{
				$('.toasterMessage').text(result_json[0]['msg'])
				$('.errorTost').css('display','none')
				$('.successTost').css('display','flex')
				setTimeout(function () {
				window.location.href="profile.php";
				}, 2500)
				$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
				}
			}else{
			$('.toasterMessage').text(result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			setTimeout(function () {
				window.location.href="../login.php";
			}, 2500)
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			}
		}
	})
})

