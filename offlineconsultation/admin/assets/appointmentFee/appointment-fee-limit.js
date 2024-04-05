
$('#add_appointment').submit(function(e){
	e.preventDefault();
	let max_visit_data = $('#max_visit_data').val()
	let month_limit = $('#month_limit').val()
	let nr_month_limit = $('#nr_month_limit').val()
	button_loader('appointment_fee_btn')
	$.ajax({
		url:"action/appointment/insert_appointment_fee_limit.php",
		type:"POST",
		data:{max_visit_data:max_visit_data,
			 month_limit:month_limit,
			 nr_month_limit:nr_month_limit
			 },
		success:function(result_data){
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
	url:"action/appointment/fetch_all_appointment_fee.php",
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
					$('#appointment').val(appointment_result[x1]['appointment_fee'])
					$('#max_visit_data').val(appointment_result[x1]['visit_limit'])
					$('#month_limit').val(appointment_result[x1]['date_limit'])
					$('#nr_appointment').val(appointment_result[x1]['nr'])
					$('#nr_month_limit').val(appointment_result[x1]['nr_date_limit'])
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
													<td data-label="visit_limit">
                                                        <p>${appointment_result[x1]['visit_limit']} Visit</p>
                                                    </td>
													<td data-label="date_limit">
                                                        <p>${appointment_result[x1]['date_limit']} Month</p>
                                                    </td>
													<td data-label="date_limit">
                                                        <p>₹ ${appointment_result[x1]['nr']}</p>
                                                    </td>
													<td data-label="date_limit">
                                                        <p>${appointment_result[x1]['nr_date_limit']} Month</p>
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