
let start_date = '';
let end_date = '';
let search_val = '';
let appointment_fee = [];
let payment_type = [];
fetch_all_appointment()


function fetch_all_appointment(){
	$.ajax({
		url:"action/appointment/fetch_all_refer_appointment.php",
		type:"POST",
		data:{start_date:start_date,
			  end_date:end_date,
			  search_val:search_val,
			  appointment_fee:appointment_fee,
			  payment_type:payment_type,
			 },
		success:function(result_data){
			//console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			console.log(result_data_json)
			//console.log(result_data_json)
			//console.log(result_data_json)
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
				let payment_mode = '';
			for(let x=0;x<result_data_json.length;x++){
				if(result_data_json[x]['filter_status'] != 0){
					payment_mode = "";
					if(result_data_json[x]['appointmentstatus'] == 0){
					tr_style = 'opacity: .2';
					btn_tr_style ='cursor:default;';
					btn_tr_style_attr = 'disabled';
					button_dis_style = 'disableNextBtn';
				}else{
					tr_style = '';
					btn_tr_style ='';
					btn_tr_style_attr = '';
				}
				if(result_data_json[x]['payment_id'] == 2){
					payment_mode = 'Cash';
					
				}else if(result_data_json[x]['payment_id'] == 1){
					payment_mode = 'G-pay';
				
				}else if(result_data_json[x]['payment_id'] == 3){
					payment_mode = 'Card';
				}
				if(result_data_json[x]['appointment_status'] == 0){
					counsulted_status = "In Queue";
				}else if(result_data_json[x]['appointment_status'] == 1){
					counsulted_status = "Refer List";
				}else if(result_data_json[x]['appointment_status'] == 2){
					counsulted_status = "Consulted";
					btn_tr_style ='cursor:default;';
					btn_tr_style_attr = 'disabled';
					button_dis_style = 'disableNextBtn';
				}
				sino++
				let style_visit = '';
				
				if(result_data_json[x]['check_appointment_count_data'] >1){
					style_visit = 'style="background:green"';
				}
				let Edit_data = `<div style="width: 40px; height: 10px"></div>`;
				
				if(result_data_json[x]['appointment_status'] == 1){
					
					if(result_data_json[x]['appointmentstatus'] == 1){
				Edit_data = `<a href="edit-appointment-refer.php?id=${result_data_json[x]['id']}" class="tableProceedBtn" title="Edit">Proceed
                                                            </a>`;
					}
				}else{
				Edit_data = `<div style="width: 40px; height: 10px"></div>`;
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
                                                    <td data-label="Date">
                                                        <p>${result_data_json[x]['branch_id']}</p>
                                                    </td>
                                                    <td data-label="Date">
                                                        <p>${result_data_json[x]['appointment_date']}</p>
                                                    </td>
													<td data-label="Date">
                                                        <p> ${result_data_json[x]['doctor_name']}</p>
                                                    </td>
													<td data-label="Date">
                                                        <p>${counsulted_status}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                           ${Edit_data}
															
															<!--<div >Proceed</div>-->
                                                        </div>
                                                    </td>
                                                </tr>`)
				
				}
				
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
