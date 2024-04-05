$('#add_appointment').submit(function(e){
	e.preventDefault();
	let appointment = $('#appointment').val()
	let nr_fee = $('#appointment_renewal_fee').val()
	button_loader('appointment_fee_btn')
	$.ajax({
		url:"action/appointment/insert_appointment_fee.php",
		type:"POST",
		data:{appointment:appointment,
			 nr_fee:nr_fee,
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
				window.location.reload()
				stop_loader('appointment_fee_btn')
			}, 2500)
			}
		}
	})
})

$.ajax({
	url:"action/appointment/fetch_all_appointment.php",
	success:function(appointment){
		let appointment_result = jQuery.parseJSON(appointment)
		//console.log(appointment_result)
		if(appointment_result.length){
			let appointment_data = '';
			let siNo = 1;
			if(appointment_result[0]['data_status'] !=0){
				$('.elseDesign').css('display','none')
			for(let x1=0;x1<appointment_result.length;x1++){
				if(appointment_result[x1]['status'] == 1){
					appointment_data  = '<span class="ongoing">Ongoing</span>';
				}else{
					appointment_data  = '';
				}
				$('.tableWraper table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${siNo}</p>
                                                    </td>
                                                    <td data-label="Fee">
                                                        <p>₹ ${appointment_result[x1]['appointment_fee']} ${appointment_data}</p>
                                                    </td>
													<td data-label="Fee">
                                                        <p>₹ ${appointment_result[x1]['nr']}</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>${appointment_result[x1]['added_date']}</p>
                                                    </td>
                                                </tr>`)
				siNo++;
			}
			}else{
				$('.elseDesign').css('display','flex')
			}
		}else{
			
		}
	}
})