let url_val = window.location.href
let url_split = url_val.split('=');
let last_len = url_split.length
let last_index = last_len-1;
let val = url_split[last_index];

$.ajax({
	url:"action/timeSlot/fetch_time_slot.php",
	type:"POST",
	data:{val:val},
	success:function(time_result){
		let time_result_json = jQuery.parseJSON(time_result)
		console.log(time_result_json)
		if(time_result_json[0]['status'] == 1){
			if(time_result_json[0]['data_status'] == 1){
				$('#time_slot_name').val(time_result_json[0]['slot_name'])
				$('#start-time').val(time_result_json[0]['start_time'])
				$('#end-time').val(time_result_json[0]['end_time'])
				$('#time-slot').val(time_result_json[0]['total_num_slot'])
			}else{
			$('.toasterMessage').text(time_result_json[0]['msg'])
			$('.errorTost').css('display','flex')
			$('.successTost').css('display','none')
			$('.toaster').addClass('toasterActive');
			setTimeout(function () {
				$('.toaster').removeClass('toasterActive');
			}, 2000)
			setTimeout(function () {
				window.location.href="login.html";
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
$('#edit-time-slot').submit(function(e){
	e.preventDefault()
	let start_time = $('#start-time').val()
	let end_time = $('#end-time').val()
	let time_slot = $('#time-slot').val()
	let time_slot_name = $('#time_slot_name').val()
	button_loader('time_slot_btn')
	$.ajax({
		url:"action/timeSlot/edit-time-slot.php",
		type:"POST",
		data:{start_time:start_time,
			  end_time:end_time,
			  time_slot:time_slot,
			 val:val,
			  time_slot_name:time_slot_name
			 },
		success:function(branch_result){
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
				stop_loader('time_slot_btn')
				window.location.href="appointment-slot.php";
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
				stop_loader('time_slot_btn')
				window.location.href="../login.php";
			}, 2500)
			}
		}
	})
})