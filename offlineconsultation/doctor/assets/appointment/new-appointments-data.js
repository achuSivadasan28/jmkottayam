let serach_var = '';
let start_date = '';
let end_date = '';
fetch_new_online_appointment();
function fetch_new_online_appointment(){
$.ajax({
	url:"action/appointment/new_appointments.php",
	type:"POST",
	data:{serach_var:serach_var,
		 start_date:start_date,
		  end_date:end_date,
		 },
	success:function(appointmenent_data){
		let appointmenent_data_json = jQuery.parseJSON(appointmenent_data)
		$('.consultAppointmentListTableBody table tbody').empty()
		if(appointmenent_data_json.length !=0){
			$('.elseDesign').css('display','none')
		$('.consultAppointmentListTableBody table tbody').empty()
		let siNo = 0;
		for(let x=0;x<appointmenent_data_json.length;x++){
			siNo++
			
			$('.consultAppointmentListTableBody table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${siNo}</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>${appointmenent_data_json[x]['unique_id']}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>${appointmenent_data_json[x]['name']}</p>
                                                    </td>
													<td data-label="Name">
                                                        <p>${appointmenent_data_json[x]['booking_id']}</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>${appointmenent_data_json[x]['phone']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${appointmenent_data_json[x]['place']}</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>${appointmenent_data_json[x]['appointment_taken_date']}</p>
                                                    </td>
													<td data-label="Date">
                                                        <p><input type="date" class="appointment_date tableInput" value="${appointmenent_data_json[x]['online_confirm_date']}" style="height:30px;padding:4px 6px;outline:none;border:1px solid #ccc;border-radius:5px;margin:2px;width:80%"></p>
														<p><input type="time" class="appointment_time tableInput" value="${appointmenent_data_json[x]['online_confirm_time']}" style="height:30px;padding:4px 6px;outline:none;border:1px solid #ccc;border-radius:5px;margin:2px;width:80%"></p>
<span class="appointment_date_error" style="color:red"></span>
                                                    </td>
													<td data-label="google_meet">
                                                        <p><input type="text" class="google_meet tableInput" value="${appointmenent_data_json[x]['google_meet']}" style="height:30px;outline:none;border-radius:5px;padding:6px 4px;border:1px solid #ccc"></p>
<span class="appointment_date_google_meet" style="color:red"></span>
                                                    </td>
													<td data-label="Date">
                                                        <div class="tableBtnArea"><button class="nextBtn schedule_appointment" data-id="${appointmenent_data_json[x]['id']}" class="">schedule appointment</button></p>
                                                    </td>
                                                </tr>`)
		}
		}else{
			$('.elseDesign').css('display','flex')
		}
	}
})
}

$('#search_btn').click(function(){
	serach_var = $('#search_val').val()
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	fetch_new_online_appointment()
})

$('#date_filter_btn').click(function(){
	serach_var = $('#search_val').val()
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	fetch_new_online_appointment()
})

$('body').delegate('.schedule_appointment','click',function(){
	
	let appointment_id = $(this).attr('data-id')
	let appointment_date = $(this).parent().parent().parent().find('.appointment_date').val()
	let appointment_time = $(this).parent().parent().parent().find('.appointment_time').val()
	let google_meet = $(this).parent().parent().parent().find('.google_meet').val()
	const googleMeetLinkRegex = /^https:\/\/meet\.google\.com\/[a-zA-Z0-9-]+$/;
    const isValidGoogleMeetLink = googleMeetLinkRegex.test(google_meet);	
	let that1 = $(this)
	if(appointment_date!= '' && isValidGoogleMeetLink && appointment_time != ''){
	$('.deleteAlert').fadeIn();
    $('.shimmer').fadeIn();
		
	$('.confirmdeleteAlert').click(function(){
		let that = $(this)
		that.text('Loading...')
		
		$.ajax({
		url:"action/appointment/schedule_appointment.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			  appointment_date:appointment_date,
			  appointment_time:appointment_time,
			  google_meet:google_meet
			 },
		success:function(appointment_result){
			console.log(appointment_result)
			that.text('Success')
			that.css('background-color','blue')
			setTimeout(function(){
				that.text('Confirm')
				that.css('background-color','#f96464')
				send_wp_message(appointment_id);
				fetch_new_online_appointment()
				$('.deleteAlert').fadeOut();
    			$('.shimmer').fadeOut();
				//that.parent().parent().parent().remove()
			},2000)
		}
	})
	})
	}else{
		//that1.text('schedule appointment')
		if(appointment_date == ''){
			that1.parent().parent().parent().find('.appointment_date_error').text('*Required!')
		}
		if(appointment_time == ''){
			that1.parent().parent().parent().find('.appointment_date_error').text('*Required!')
		}
		if(!isValidGoogleMeetLink){
			that1.parent().parent().parent().find('.appointment_date_google_meet').text('*Please Enter a Valid Google Meet Link!').css('fontSize','11px')
		}
	}
})
function send_wp_message(appointment_id){
	console.log(appointment_id)
	$.ajax({
		url :"action/appointment/send_wp_messasge.php",
		type : "POST",
		data:{appointment_id:appointment_id},
		success:function(result){
			console.log(result)
		}
	})

}
$('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });
$('body').delegate('.appointment_date','change',function(){
	$(this).parent().parent().find('.appointment_date_error').text(' ')
})
$('body').delegate('.google_meet','keyup',function(){
	let google_meet = $(this).val()
	const googleMeetLinkRegex = /^https:\/\/meet\.google\.com\/[a-zA-Z0-9-]+$/;
    const isValidGoogleMeetLink = googleMeetLinkRegex.test(google_meet);
	if($(this).val() != ''){
	$(this).parent().parent().find('.appointment_date_google_meet').text(' ')
	}else{
		$(this).parent().parent().find('.appointment_date_google_meet').text('*Please Enter a Valid Google Meet Link!').css('fontSize','11px')
	}
})