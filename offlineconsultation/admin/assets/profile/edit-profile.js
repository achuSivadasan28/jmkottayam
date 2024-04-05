$('#edit_profile').submit(function(e){
	e.preventDefault();
	button_loader('edit_profile_btn')
	let user_name = $('#user_name').val()
	let phn = $('#phn').val()
	let email = $('#email').val()
	let address = $('#address').val()
	let place = $('#place').val()
	$.ajax({
		url:"action/profile/update_profile.php",
		type:"POST",
		data:{user_name:user_name,
			  phn:phn,
			  email:email,
			  address:address,
			  place:place
			 },
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			if(result_data_json[0]['status'] == 1){
			$('.toasterMessage').text(result_data_json[0]['msg'])
			$('.errorTost').css('display','none')
			$('.successTost').css('display','flex')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				stop_loader('edit_profile_btn')
				window.location.href="profile.php";
			}, 2500)
			}else{
			$('.toasterMessage').text(branch_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				stop_loader('edit_profile_btn')
				window.location.href="../login.php";
			}, 2500)
			}
		}
	})
})

$.ajax({
	url:"action/profile/fetch_profile.php",
	success:function(result){
		
		let result_data_json = jQuery.parseJSON(result)
		if(result_data_json[0]['status'] == 1){
			$('.tableWraper table tbody').empty()
			if(result_data_json[0]['data_status'] == 1){
				$('.elseDesign').css('display','none')
				console.log(result_data_json[0]['phn'])
				if(result_data_json[0]['user_name'] != ''){
					$('#user_name').val(result_data_json[0]['user_name'])
				}
				if(result_data_json[0]['phn'] != ''){
					$('#phn').val(result_data_json[0]['phn'])
				}
				if(result_data_json[0]['email'] != ''){
					$('#email').val(result_data_json[0]['email'])
				}
				if(result_data_json[0]['address'] != ''){
					$('#address').val(result_data_json[0]['address'])
				}
				if(result_data_json[0]['place'] != ''){
					$('#place').val(result_data_json[0]['place'])
				}
				
			}else{
				$('.elseDesign').css('display','flex')
			}
		}else{
			$('.tableWraper table tbody').empty()
			$('.toasterMessage').text(result_data_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				//window.location.href="../login.php";
			}, 2500)
			}
	}
})