
let start_date = '';
let end_date = '';
let search_val = '';
let appointment_fee = [];
let payment_type = [];
fetch_all_appointment()


function fetch_all_appointment(){
	$.ajax({
		url:"action/appointment/fetch_all_appointment.php",
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
					btn_tr_style ='cursor:defaul;';
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
					counsulted_status = "Waiting List";
				}else if(result_data_json[x]['appointment_status'] == 2){
					counsulted_status = "Consulted";
					btn_tr_style ='cursor:defaul;';
					btn_tr_style_attr = 'disabled';
					button_dis_style = 'disableNextBtn';
				}
				sino++
				let style_visit = '';
				
				if(result_data_json[x]['check_appointment_count_data'] >1){
					style_visit = 'style="background:green"';
				}
				let Edit_data = `<div style="width: 40px; height: 10px"></div>`;
				
				if(result_data_json[x]['appointment_status'] == 0){
					
					if(result_data_json[x]['appointmentstatus'] == 1){
				Edit_data = `<a href="edit-appointment-details.php?id=${result_data_json[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-edit"></i>
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
                                                        <p>${result_data_json[x]['appointment_date']}</p>
                                                    </td>
<td data-label="Date">
                                                        <p>Dr . ${result_data_json[x]['doctor_name']}</p>
                                                    </td>
													<td data-label="Date">
                                                        <p>${result_data_json[x]['appointment_fee']}</p>
                                                    </td>
													<td data-label="Date">
                                                        <p>${payment_mode}</p>
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
$.ajax({
	url:'action/appointment/fetch_appointment_fee.php',
    type:'post',
	success:function(result){
		console.log(result)
		let data_result = JSON.parse(result)
		if(data_result[0]['status'] == 1){
			$('.appmnt-fee').append(`
						<div class="formGroup">
                            <input type="checkbox" class="branch_val" value="${data_result[0]['appointment_fee']}" id = "n">
                            <label for="n" status="0">N(${data_result[0]['appointment_fee']})</label>
                    	</div>
						<div class="formGroup">
                            <input type="checkbox" class="branch_val" value="${data_result[0]['nr']}" id = "nr">
                            <label for="nr" status="0">NR(${data_result[0]['nr']})</label>
                    	</div>
						<div class="formGroup">
                            <input type="checkbox" class="branch_val" value="0" id = "zero">
                            <label for="zero" status="0">ZERO</label>
                    	</div>`)
		}
	}
})
$('#serach_btn').click(function(){
	search_val = $('#search_val').val()
	fetch_all_appointment()
})


$('#date_filter').click(function(){
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	fetch_all_appointment()
})
$(".applyFilter").click(function(){
	appointment_fee = [];
	payment_type = []
	$('.appmnt-fee').find('.formGroup').each(function(){
		console.log("hi")
		if($(this).find('label').attr("status") == 1){
			appointment_fee.push($(this).find('.branch_val').val())
			
			
		
		}
	
	})
	$('.payment-type').find('.formGroup').each(function(){
		console.log("hi")
		if($(this).find('label').attr("status") == 1){
			payment_type.push($(this).find('.branch_val').val())
		}
	
	})
	
	fetch_all_appointment()
	$(".filterSection").removeClass("filterSectionActive");
	$(".shimmer").fadeOut();
	console.log(payment_type)
})
$('body').delegate(".formGroup label",'click',function(){
	if($(this).attr("status")==0){
		$(this).attr("status",1)
	}else{
		$(this).attr("status",0)
	}
	
})
