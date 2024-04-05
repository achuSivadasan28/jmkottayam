$('#add-slot').submit(function(e){
	e.preventDefault()
	let start_time = $('#start_time').val()
	let end_time = $('#end_time').val()
	let no_of_slot = $('#no_of_slot').val()
	let time_slot_name = $('#time_slot_name').val()
	button_loader('slot_btn')
	$.ajax({
		url:"action/timeSlot/add_timeSlot.php",
		type:"POST",
		data:{start_time:start_time,
			 end_time:end_time,
			  no_of_slot:no_of_slot,
			  time_slot_name:time_slot_name
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
				window.location.href="appointment-slot.php";
			}, 2500)
			}
		}
	})
})
