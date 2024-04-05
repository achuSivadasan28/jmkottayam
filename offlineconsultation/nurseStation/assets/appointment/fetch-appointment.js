
let start_date = '';
let end_date = '';
let search_val = '';
fetch_all_appointment()

fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
			if(profile_result_json[0]['status'] == 1){
				$('#name').text(profile_result_json[0]['staff_name'])
				$('#branch').text(profile_result_json[0]['branch_name'])
				$('#pro_pic').attr('src','assets/images/profile_pic/'+profile_result_json[0]['proPic'])
				
			}
		}
	})
}

function fetch_all_appointment(){
	$.ajax({
		url:"action/appointment/fetch_all_doctor_appointment.php",
		type:"POST",
		data:{start_date:start_date,
			  end_date:end_date,
			  search_val:search_val
			 },
		success:function(result_data){
			//console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			//console.log(result_data_json)
			//console.log(result_data_json)
			//console.log(result_data_json)
			console.log(result_data_json[0]['current_date'])
			if(result_data_json[0]['current_date']!= ''){
				$('#start_date').val(result_data_json[0]['current_date'])
			}
			$('.appointment_tbl table tbody').empty()
			if(result_data_json[0]['data_status'] == 1){
				$('.elseDesign').css('display','none')
			if(result_data_json.length != 0){
			let sino = 0;
				let tr_style = '';
				let btn_tr_style = '';
				let btn_tr_style_attr = '';
				let counsulted_status = '';
				let button_dis_style = '';
			for(let x=0;x<result_data_json.length;x++){
				if(result_data_json[x]['appointmentstatus'] == 0){
					tr_style = 'opacity: .2';
					btn_tr_style ='cursor:defaul;';
					btn_tr_style_attr = 'disabled';
					button_dis_style = 'disableNextBtn';
				}else{
					tr_style = '';
					btn_tr_style ='';
					btn_tr_style_attr = '';
				}
				if(result_data_json[x]['appointment_status'] == 0){
					counsulted_status = "In Queue";
				}else if(result_data_json[x]['appointment_status'] == 1){
					counsulted_status = "Waiting List";
				}else if(result_data_json[x]['appointment_status'] == 2){
					counsulted_status = "Consulted";
					btn_tr_style ='cursor:defaul;';
					btn_tr_style_attr = 'disabled';
					button_dis_style = 'disableNextBtn';
				}
				sino++
				let style_visit = '';
				let Edit_data = `<div style="width: 40px; height: 10px"></div>`;
				
				if(result_data_json[x]['appointment_status'] == 0 && result_data_json[x]['c_date'] == result_data_json[x]['appointment_date']){
					if(result_data_json[x]['appointmentstatus'] == 1){
				Edit_data = `<a href="edit-appointment-details.php?id=${result_data_json[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-edit"></i>
                                                            </a>`;
					}
				}else{
				Edit_data = `<div style="width: 40px; height: 10px"></div>`;
				}
				
				if(result_data_json[x]['check_appointment_count_data'] >1){
					style_visit = 'style="background:green"';
				}
				$('.appointment_tbl table tbody').append(`<tr style="${tr_style}">
                                                    <td data-label="Sl No">
                                                        <p>${sino}</p>
                                                    </td>
													<td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>${result_data_json[x]['appointment_number']}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span ${style_visit}>${result_data_json[x]['unique_id']}</span>
                                                        </div>
                                                    </td>
                                                    <td data-label="Name">
                                                        <p>${result_data_json[x]['name']}</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>${result_data_json[x]['phone']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${result_data_json[x]['place']}</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>${result_data_json[x]['appointment_date']}</p>
                                                    </td>
<td data-label="Date">
                                                        <p>${counsulted_status}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                           ${Edit_data}
															<button data-id = ${result_data_json[x]['id']} class="cancelTableBtn ${button_dis_style}" style="border:none;outline:none;${btn_tr_style}" ${btn_tr_style_attr}>Cancel</button>
                                                        </div>
                                                    </td>
                                                </tr>`)
			}
			}else{
				$('.elseDesign').css('display','flex')
			}
			}else{
				$('.elseDesign').css('display','flex')
				
			}
		}
	})
}
/**
 <div class="viewDetailsBtn">View Details</div>
**/
$('#serach_btn').click(function(){
	search_val = $('#search_val').val()
	fetch_all_appointment()
})

$('#date_filter').click(function(){
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	fetch_all_appointment()
})