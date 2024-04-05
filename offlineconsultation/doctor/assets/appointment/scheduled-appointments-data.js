let serach_var = '';
let start_date = '';
let end_date = '';
$.when(fetch_current_date()).then(function(current_date){
	$('#start_date').val(current_date)
	start_date = current_date
	fetch_new_online_appointment();
})
function fetch_current_date(){
	return $.ajax({
		url:"action/appointment/current_date.php"
	})
}

fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			console.log(profile_result_json)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['doctor_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				if(profile_result_json[0]['proPic'] != ''){
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				}
			}
		}
	})
}

function fetch_new_online_appointment(){
$.ajax({
	url:"action/appointment/all_scheduled_appointments.php",
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
		
		let siNo = 0;
		for(let x=0;x<appointmenent_data_json.length;x++){
			siNo++
			let button_status = '';
			if(appointmenent_data_json[x]['current_date'] != appointmenent_data_json[x]['online_confirm_date']){
				//button_status = `disabled`;
			}
			//current_date
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
                                                        <p><input type="date" class="appointment_date tableInput" min="${appointmenent_data_json[0]['current_date']}" value="${appointmenent_data_json[x]['online_confirm_date']}" style="padding:4px 6px;border:1px solid #ccc;height:30px;border-radius:4px;margin:1px" disabled></p>
														<p><input type="time" class="appointment_date tableInput" value="${appointmenent_data_json[x]['online_confirm_time']}" disabled style="padding:4px 6px;border:1px solid #ccc;height:30px;border-radius:4px;margin:1px"></p>
                                                    </td>
													
													<td data-label="Date">
                                                        <div class="tableBtnArea">
<a href="inner-patient-details.php?id=${appointmenent_data_json[x]['id']}" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
<button class="nextBtn to_appointment" data-id="${appointmenent_data_json[x]['id']}" class="" ${button_status}>Consult</button> <button class="viewDetailsBtn end_appointment" data-id="${appointmenent_data_json[x]['id']}" class="" ${button_status}>End Appointment</button></div>
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
$('body').delegate('.to_appointment','click',function(){
	let app_id = $(this).attr('data-id')
	window.location.href="online-consultation.php?id="+app_id
	//let meeting_link = $(this).parent().parent().parent().find('.google_meet').val()
	//window.open(meeting_link)
	//console.log(meeting_link)
})

$('body').delegate('.end_appointment','click',function(){
	let appointment_id = $(this).attr('data-id')
	let that = $(this)
	$('.deleteAlert').fadeIn();
    $('.shimmer').fadeIn();
	$('.confirmdeleteAlert').click(function(){
	$.ajax({
		url:"action/appointment/end_appointment.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(appointment_result){
			that.parent().parent().parent().remove()
			$('.deleteAlert').fadeOut();
    		$('.shimmer').fadeOut();
			fetch_new_online_appointment()
		}
	})
	})
})

$('.closedeleteAlert').click(function(){
      $('.deleteAlert').fadeOut();
      $('.shimmer').fadeOut();
});

$('body').delegate('.appointment_date','change',function(){
	let appointment_date = $(this).val()
	let appointment_id = $(this).parent().parent().parent().find('.to_appointment').attr('data-id')
	$.ajax({
		url:"action/appointment/update_appointment_date.php",
		type:"POST",
		data:{appointment_date:appointment_date,
			 appointment_id:appointment_id
			 },
		success:function(appointment_result){
			fetch_new_online_appointment()
		}
	})
})

$('body').delegate('.google_meet','change',function(){
	let google_meet = $(this).val()
	let appointment_id = $(this).parent().parent().parent().find('.to_appointment').attr('data-id')
	$.ajax({
		url:"action/appointment/update_appointment_meet.php",
		type:"POST",
		data:{google_meet:google_meet,
			 appointment_id:appointment_id
			 },
		success:function(appointment_result){
			fetch_new_online_appointment()
		}
	})
})

