let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let search_val = '';
let start_date = '';
let end_date = '';
let last_num = '';
let Api_key = "requestingfor@patientCount";
let Api_key1 = "requestingfor@patientdetails";
let Api_value = "JhonmariansBilling";
let enc_key = '94d2b25d1d3c8646e9d0ffb8b58a8d29';
let enc_key1 = 'c85a187e4058fab7c6df585ee9600e48';
const element = document.querySelector(".pagination ul");
let totalPages = 0;
let page = 1;
fetch_patient_count()
function fetch_patient_count(){
	$.ajax({
		url:"../offlineconsultation/action/consulted_patient_count-prescription.php",
		type:"POST",
		data:{search_val:search_val,
			 enc_key:enc_key,
			  start_date:start_date,
			  end_date:end_date,
			 },
		success:function(result){
			console.log(result)
			let result_json = jQuery.parseJSON(result)
			let total_count = result_json[0]['count']
			pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,total_count)
			
		}
	})
}
$('#search_btn').click(function(){
	search_val = $('#search_val').val().trim()
	fetch_patient_count()
})

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_patient_count()
})

        function pageSplit_num(end_limit,total_num){
            $('#page_num').empty()
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

function pageCount_drop_down(end_limit,total_num){
	let current_limit = end_limit;
    $('#pagenation_drop').empty()
    while(total_num>0){
        $('#pagenation_drop').append(`<option value="${current_limit}">${current_limit}</option>`)
        total_num -= current_limit;
        if(current_limit == 15){
            current_limit = 25;
        }else{
            current_limit += 25;
        }
    }
}
        $('#first_row').click(function(){
			
            $('#page_num li').removeClass('navigationActive')
            $('#page_num li').each(function(){
                if($(this).text() == 1){
                    $(this).addClass('navigationActive')
                }
            })
            start_limit = 0;
            limit_range = start_limit+","+end_limit
			fetch_all_bill_details()
        })

        $('#last_row').click(function(){
            $('#page_num li').removeClass('navigationActive')
            $('#page_num li').each(function(){
                if($(this).text() == last_num){
                    $(this).addClass('navigationActive')
                }
            })
            start_limit = (last_num-1)*end_limit;
            limit_range = start_limit+","+end_limit
            fetch_all_bill_details()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_all_bill_details()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_patient_count()
        })


function fetch_all_bill_details(){
fetch('action/bills-prescription.php?limit='+limit_range+'&search_val='+search_val+'&start_date='+start_date+'&end_date='+end_date)
.then(Response=>Response.json())
.then(data=>{
    let si_No=start_limit;
    $('.tableWraper table tbody').empty();
	$('.elseDesign').css('display','none')
if(data.length!=0){
	$('.pagination').css('display','flex')
   for(let x=0;x<data.length;x++){
	   si_No++;
                        $('.tableWraper table tbody').append(`<tr>
                        <td data-label="Sl No">
                            <p>${si_No}</p>
                        </td>
                        <td data-label="Invoice No">
                            <p>${data[x]['invoice_no']}</p>
                        </td>
                        <td data-label="Action">
                            <div class="tableBtnArea">
                                <a href=""  data-id="${data[x]['id']}" class="tablePrintBtn" title="Print"><i class="uil uil-print"></i>
                                </a>
                            </div>
                        </td>
                        <td data-label="Customer Name">
                            <p>${data[x]['customer_name']}</p>
                        </td>
                        <td data-label="Products Name">
                            <p>${data[x]['product_name']}</p>
                        </td>
                        <td data-label="Date">
                            <p>${data[x]['date']}</p>
                        </td>
                        <td data-label="Price">
                            <p>₹ ${data[x]['price']}</p>
                        </td>
                        <td data-label="Quantity">
                            <p>${data[x]['quantity']}</p>
                        </td>
                        <td data-label="Total Amount">
                            <p>₹ ${data[x]['total_price']}</p>
                        </td>
                    </tr>
            `)
            
}
}else{
	$('.elseDesign').css('display','flex')
	$('.pagination').css('display','none')
}
})
}



// serach status
$('#search_btn').click(function(){
    search_val=$('#search_val').val();
	fetch_patient_count()
})


     
//date range filter
                $('#date_btn').click(function(){
					start_date = $('#date_val').val();
					end_date = $('#date_val1').val();
					fetch_patient_count()
                })

/**
$('.printDesignTable tbody').append(`
					<tr style="page-break-inside: avoid; page-break-after: auto;">
                            <td>${SINO}</td>
                            <td>${product_details[x]['product_name']}</td>
                            <td>${product_details[x]['quantity']}</td>
                            <td>₹ ${product_details[x]['price']}</td>
                            <td>₹ ${net_total}</td>
                            <td>₹ ${product_details[x]['net_total']}</td>
                            
                        </tr>`)
**/

function createPagination(totalPages, page){
	console.log(totalPages)
	console.log(page)
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
			fetch_patient_data()
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

function fetch_patient_data(){
	$.ajax({
	url:"../offlineconsultation/action/consulted_patient_details-prescription.php",
	type:"POST",
	data:{search_val:search_val,
		 limit_range:limit_range,
		  start_date:start_date,
		  end_date:end_date,
		  enc_key1:enc_key1
		 },
	success:function(result){
		$('.consultAppointmentListTableBody table tbody').empty()
		let result_json = jQuery.parseJSON(result)
		if(result_json[0]['data_exist'] == 1){
			let siNo = start_limit;
			for(let x1=0;x1<result_json.length;x1++){
				siNo++;
				$('.consultAppointmentListTableBody table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${siNo}</p>
                                                    </td>
                                                    <td data-label="Patient Name">
                                                        <p>${result_json[x1]['name']}</p>
                                                    </td>
                                                    <td data-label="Phone No">
                                                        <p>${result_json[x1]['phone']}</p>
                                                    </td>
                                                    <td data-label="Doctor">
                                                        <p>${result_json[x1]['doctor_name']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${result_json[x1]['place']}</p>
                                                    </td>
													<td data-label="Place">
                                                        <p>${result_json[x1]['appointment_date']}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="" class="tablePrintBtn" data-id=${result_json[x1]['appointment_id']} branch_id=${result_json[x1]['branch']} title="Print"><i class="uil uil-print"></i>
                                                            </a>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>`)
			}
		}else{
			
		}
		
	}
})
}
let api_key_val = 'prescription_details';
$('body').delegate('.tablePrintBtn','click',function(e){
	e.preventDefault()
	let appointment_id = $(this).attr('data-id')
	let branch = $(this).attr('branch_id')
	$.when(fetch_priscription(appointment_id,branch)).then(function(){
		print()
	})
	
	
})
function fetch_priscription(appointment_id,branch){
	return $.ajax({
		url:"../offlineconsultation/action/patient_priscription.php",
		type:"POST",
		data:{appointment_id:appointment_id,
			 api_key_val:api_key_val,
			  branch:branch,
			 },
		success:function(prescription_result){
			let prescription_result_jsaon = jQuery.parseJSON(prescription_result)
			//console.log(prescription_result_jsaon)
			if(prescription_result_jsaon != ''){
			$('.prescription_data_print').empty();
			console.log(prescription_result_jsaon)
				$('#name_data').text(prescription_result_jsaon[0]['name'])
				$('#gender_data').text(prescription_result_jsaon[0]['gender'])
				$('#age_data').text(prescription_result_jsaon[0]['age'])
				$('#unique_id').text(prescription_result_jsaon[0]['unique_id'])
				$('#total_visit').text(prescription_result_jsaon[0]['total_visit_count'])
				$('#first_visit').text(prescription_result_jsaon[0]['first_visit'])
				$('#last_visit').text(prescription_result_jsaon[0]['Last_visit'])
				$('#height_data').text(prescription_result_jsaon[0]['height'])
				$('#weight_data').text(prescription_result_jsaon[0]['weight'])
				$('#bmi_data').text(prescription_result_jsaon[0]['BMI'])
				$('#weight_cat').text(prescription_result_jsaon[0]['weight_cat'])
				$('#all_remark').text(prescription_result_jsaon[0]['main_remark'])
			if(prescription_result_jsaon[0]['prescription'] != undefined){
			for(let x=0;x<prescription_result_jsaon[0]['prescription'].length;x++){
					let food_time = '';
					if(prescription_result_jsaon[0]['prescription'][x]['after_food'] == 1){
						food_time = 'After Food';
					}else if(prescription_result_jsaon[0]['prescription'][x]['befor_food'] == 1){
						food_time = 'Before Food';
					}
					let time_result =  prescription_result_jsaon[0]['prescription'][x]['morning_section']+'-'+prescription_result_jsaon[0]['prescription'][x]['noon_section']+'-'+prescription_result_jsaon[0]['prescription'][x]['evening_section'];
					$('.prescription_data_print').append(`<p><b>${prescription_result_jsaon[0]['prescription'][x]['medicine_name']}</b> ${time_result} ${prescription_result_jsaon[0]['prescription'][x]['no_of_day']} days ${food_time}</p>`)
				}
			}else{
			$('.prescription_data_print').empty()
			}
				
				let complaint_data = prescription_result_jsaon[0]['comment_data']
				if(complaint_data != undefined){
				$('.complaints_data_print').empty()
					$('.complaints_data_print').append(`<h2>Complaints</h2>`)
				for(let xy = 0; xy<complaint_data.length;xy++){
				$('.complaints_data_print').append(`<p>${complaint_data[xy]['comment']}</p>`)
				}
				}else{
					$('.complaints_data_print').empty()
				}
				
				let medical_data = prescription_result_jsaon[0]['medical_data']
					if(medical_data != undefined){
						$('.medical_history_print').empty()
						$('.medical_history_print').append(`<h2>Medical History</h2>`)
					for( let xy2=0 ; xy2<medical_data.length; xy2++){
					$('.medical_history_print').append(`<p>${medical_data[xy2]['comment']}</p>`)
					}
				}else{
					$('.medical_history_print').empty()
				}
				
				let surgical_data = prescription_result_jsaon[0]['surgical_data']
					if(surgical_data != undefined){
						$('.Investigations_data').empty()
						$('.Investigations_data').append(`<h2>Investigations</h2>`)
					for( let xy1 = 0; xy1<surgical_data.length; xy1++){
						$('.Investigations_data').append(`<p>${surgical_data[xy1]['comment']}</p>`)
					}
				}else{
					$('.Investigations_data').empty()
				}
				
				let food_to_follow = prescription_result_jsaon[0]['diet_follow']
					
					if(food_to_follow != undefined){
						$('.food_to_follow').empty()
						for( let xyf1 = 0; xyf1<food_to_follow.length; xyf1++){
						$('.food_to_follow').append(`<p>${food_to_follow[xyf1]['diet']}</p>`)
					}
						if(food_to_follow[0]['diet_no_of_days'] != 0 && food_to_follow[0]['diet_no_of_days']!= undefined){
						$('.food_to_follow').append(`<li><b>No. of Days : ${food_to_follow[0]['diet_no_of_days']} Days</b></li>`)
						}
					}else{
						$('.food_to_follow').empty()
					}
				
				let food_to_avoid = prescription_result_jsaon[0]['food_plan']
					//console.log(food_to_avoid)
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
								//console.log(food_to_follow.length)
						for( let xyf2 = 0; xyf2<food_to_avoid.length; xyf2++){
							//console.log(food_to_avoid[xyf2]['foods_avoid'])
						$('.food_to_avoid').append(`<p>${food_to_avoid[xyf2]['foods_avoid']}</p>`)
					}
					
					}else{
						$('.food_to_avoid').empty()
					}
				
				$('.dynamic_doctor').empty()
				$('.dynamic_doctor').append(`<ul>
							<li><b>${prescription_result_jsaon[0]['doctor_name']}</b></li>
							<li>${prescription_result_jsaon[0]['qualification_data']}</li>
							<li>${prescription_result_jsaon[0]['reg_num']}</li>
							<li>${prescription_result_jsaon[0]['designation_data']}</li>
					</ul>`)
				//Reg No : 
			}else{
			$('.prescription_data_print').empty();
			$('.dynamic_doctor').empty()
			$('.food_to_avoid').empty()
			$('.food_to_follow').empty()
			$('.Investigations_data').empty()
			$('.medical_history_print').empty()
			$('.complaints_data_print').empty()
			}
			
			
		}
		
	})
}