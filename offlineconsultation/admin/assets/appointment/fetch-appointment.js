
let start_date = '';
let end_date = '';
let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let last_num = '';
let status_id = 0;
let search_val = '';
const element = document.querySelector(".pagination ul");
let totalPages = 0;
let page = 1;
//fetch_all_appointment();
fetch_all_appointment_count();
function fetch_all_appointment_count(){
	$.ajax({
		url:"action/appointment/fetch_all_appointment_count.php",
		type:"POST",
		data:{start_date:start_date,
			 end_date:end_date,
			  search_val:search_val,
			 },
		success:function(all_appointment_count){
			let all_appointment_count_json = jQuery.parseJSON(all_appointment_count)
			pageSplit_num(end_limit,all_appointment_count_json[0]['count_id'])
			//console.log(all_appointment_count)
			//createPagination
		}
	})
}

 function pageSplit_num(end_limit,total_num){
            $('#page_num').empty()
            let num = 0;
			
            if(total_num <=end_limit){
				$('.paginationCount').css('display','none')
                num = 1;
				element.innerHTML = createPagination(num, page);
            }else{
				$('.paginationCount').css('display','flex')
                let div_num = total_num/end_limit
                if(div_num <= 1){
                    num = 2;
                }else{
                    num = parseInt(div_num);
                    if(total_num % end_limit != 0){
                    	num += 1;
                	}
                }
                element.innerHTML = createPagination(num, page);
            }
            let x1 = 1;
		
           while(x1<=num){
				last_num = num;
                if(x1 == 1){
                    $('#page_num').append(`<li class="navigationActive"><span>${x1}</span></li>`)
                }else{
                    $('#page_num').append(`<li><span>${x1}</span></li>`)
                }
                x1++;
            }
        }
function fetch_all_appointment(){
	$.ajax({
		url:"action/appointment/fetch_all_appointment_admin.php",
		type:"POST",
		data:{start_date:start_date,
			  end_date:end_date,
			  search_val:search_val,
			  limit_range:limit_range
			 },
		success:function(result_data){
			console.log(result_data)
			let result_data_json = jQuery.parseJSON(result_data)
			//console.log(result_data_json)
			//console.log(result_data_json)
			console.log(result_data_json)
			if(result_data_json[0]['current_date']!= ''){
				$('#start_date').val(result_data_json[0]['current_date'])
			}
			$('.appointment_tbl table tbody').empty()
			if(result_data_json[0]['data_status'] == 1){
				$('.elseDesign').css('display','none')
			if(result_data_json.length != 0){
			let sino = start_limit;
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
					counsulted_status = "Wating List";
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
				let Edit_data = `<div style="width: 30px; height: 10px"></div>`;
				
				//if(result_data_json[x]['appointment_status'] == 0){
					
					//if(result_data_json[x]['appointmentstatus'] == 1){
				Edit_data = `<a href="edit-appointment-details.php?id=${result_data_json[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-edit"></i>
                                                            </a>`;
				//}
				//}else{
				//Edit_data = `<div style="width: 30px; height: 10px"></div>`;
				//}
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
													<td data-label="Place">
                                                        <p>Dr . ${result_data_json[x]['doctor_name']}</p>
                                                    </td>
<td data-label="Date">
                                                        <p>${counsulted_status}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
															${Edit_data}
                                                           <a href="view-appointment-details.php?id=${result_data_json[x]['id']}" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
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
	search_val = $('#search_val').val().trim()
	fetch_all_appointment_count()
})

$('#date_filter').click(function(){
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	fetch_all_appointment_count()
})

function createPagination(totalPages, page){
	//console.log("totalPages "+totalPages)
	//console.log("page "+page)
  let liTag = '';
  let active;
  let beforePage = page - 1;
  let afterPage = page + 1;
  if(page > 1){ 
    liTag += `<li class="btn prev" onclick="createPagination(${totalPages}, ${page - 1})"><span><i class="fas fa-angle-left"></i> Prev</span></li>`;
  }

  if(page > 2){ 
    liTag += `<li class="first numb" onclick="createPagination(${totalPages}, 1)"><span>1</span></li>`;
    if(page > 3){
      liTag += `<li class="dots"><span>...</span></li>`;
    }
  }


 /**if (page == totalPages) {
    beforePage = beforePage - 2;
  } else if (page == totalPages - 1) {
    beforePage = beforePage - 1;
  }

  if (page == 1) {
    afterPage = afterPage + 2;
  } else if (page == 2) {
    afterPage  = afterPage + 1;
  }**/

  for (var plength = beforePage; plength <= afterPage; plength++) {
    if (plength > totalPages) {
      continue;
    }
    if (plength == 0) { 
      plength = plength + 1;
    }
    if(page == plength){ 
      active = "active";
    }else{ 
      active = "";
    }
	  let page_num = page
	  let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_all_appointment()
    liTag += `<li class="numb ${active}" onclick="createPagination(${totalPages}, ${plength})"><span>${plength}</span></li>`;
  }

  if(page < totalPages - 1){ 
    if(page < totalPages - 2){
      liTag += `<li class="dots"><span>...</span></li>`;
    }
    liTag += `<li class="last numb" onclick="createPagination(${totalPages}, ${totalPages})"><span>${totalPages}</span></li>`;
  }

  if (page < totalPages) { 
    liTag += `<li class="btn next" onclick="createPagination(${totalPages}, ${page + 1})"><span>Next <i class="fas fa-angle-right"></i></span></li>`;
  }
  element.innerHTML = liTag; 
  return liTag; 
}