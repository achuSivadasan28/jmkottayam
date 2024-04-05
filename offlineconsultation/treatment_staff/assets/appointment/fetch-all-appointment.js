let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let last_num = '';
let status_id = 0;
let search_val = '';
let start_date = '';
let end_date = '';
const element = document.querySelector(".pagination ul");
let totalPages = 0;
let page = 1;
		//Comments popup tab
		function openCity2(evt, cityName2) {
		  var i, x, tablinks;
		  x = document.getElementsByClassName("commentsPopupTabBox");
		  for (i = 0; i < x.length; i++) {
			x[i].style.display = "none";
		  }
		  tablinks = document.getElementsByClassName("tablink");
		  for (i = 0; i < x.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		  }
		  document.getElementById(cityName2).style.display = "flex";
		  evt.currentTarget.className += " active";
		}

$('#search_btn').click(function(){
	search_val = $('#search_val').val()
	fetch_all_appointments()
})
fetch_all_appointments()

function fetch_all_appointments(){
	$.ajax({
		url:"action/appointment/fetch_all_appointment_count.php",
		type:"POST",
		data:{search_val:search_val,
			  start_date:start_date,
		  	  end_date:end_date
			 },
		success:function(result_data){
			let result_json = jQuery.parseJSON(result_data)
			let result = result_json[0]['appointment_count']
			//console.log(result)
			//pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,result)
			//fetch_appointment_data()
		}
	})
}

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_all_appointments()
})

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

/**function pageCount_drop_down(end_limit,total_num){
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
}**/
        $('#first_row').click(function(){
			
            $('#page_num li').removeClass('navigationActive')
            $('#page_num li').each(function(){
                if($(this).text() == 1){
                    $(this).addClass('navigationActive')
                }
            })
            start_limit = 0;
            limit_range = start_limit+","+end_limit
			fetch_appointment_data()
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
            fetch_appointment_data()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_appointment_data()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_appointment_data()
        })

$('#date_filter_btn').click(function(){
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	search_val = $('#search_val').val()
	fetch_all_appointments()
})
//fetch_appointment_data()
function fetch_appointment_data(){
$.ajax({
	url:"action/appointment/fetch_all_appointment.php",
	type:"POST",
	data:{search_val:search_val,
		 limit_range:limit_range,
		  start_date:start_date,
		  end_date:end_date,
		 },
	success:function(result){
	
		let result_data_json = jQuery.parseJSON(result)
	console.log(result_data_json)
		if(result_data_json[0]['status'] == 1){
			
			$('.tableWraper table tbody').empty()
			if(result_data_json[0]['data_status'] == 1){
				$('.pagination').css('display','flex')
				$('.elseDesign').css('display','none')
				let result_len = result_data_json.length
				let si_no = start_limit;
				let print_data = ``;
				
				for(let x=0;x<result_len;x++){
					si_no++;
					let appoint_status = 'Pending';
					 print_data = '';
					if(result_data_json[x]['appointment_status'] == 2){
						print_data = `<a  href="#" class="currentConsultingheadPrintBtn tablePrintBtn" data-id=${result_data_json[x]['app_id']}><i class="uil uil-print"></i></a>`;
						appoint_status = 'Counsulted';
					}
				$('.tableWraper table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${si_no}</p>
                                                    </td>
                                                    <td data-label="Unique ID">
                                                        <div class="UniqueId">
                                                            <span>${result_data_json[x]['unique_id']}</span>
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
													<td data-label="appointment_status">
                                                        <p>${appoint_status}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
														<a href="view-appointment-details.php?id=${result_data_json[x]['app_id']}" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                                            </a>
                                                          
															${print_data}
                                                            <div class="viewDetailsBtn addCommentsBtn" data-id=${result_data_json[x]['unique_id']}>View Details</div>
                                                        </div>
                                                    </td>
                                                </tr>`)
				}
			}else{
				$('.elseDesign').css('display','flex')
				$('.pagination').css('display','none')
			}
		}else{
			$('.pagination').css('display','none')
			$('.tableWraper table tbody').empty()
			$('.toasterMessage').text(result_data_json[0]['msg'])
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
}

        // delete alert 
		let doctor_id = 0; 
		let parsent_div = ''; 
        $('body').delegate('.tableDeleteBtn','click',function(){
			doctor_id = $(this).attr('data-id')
			parsent_div = $(this).parent().parent().parent()
            $('.deleteAlert').fadeIn();
            $('.shimmer').fadeIn();
        });
        $('.closedeleteAlert').click(function(){
            $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        });
        $('.confirmdeleteAlert').click(function(){
			$.ajax({
				url:"action/doctor/delete.php",
				type:"POST",
				data:{doctor_id:doctor_id},
				success:function(result_data){
					console.log(result_data)
					let result_data_json = jQuery.parseJSON(result_data);
					if(result_data_json[0]['status'] == 1){
						$('.deleteAlert').fadeOut();
            			$('.shimmer').fadeOut();
						parsent_div.remove();
					}else{
						$('.tableWraper table tbody').empty()
						$('.toasterMessage').text(result_data_json[0]['msg'])
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
            
        });

        // Comments popup 
let patient_pk_id = 0;
        $('body').delegate('.addCommentsBtn','click',function(){
            $('.profileDetailsPopup').fadeIn();
            $('.shimmer').fadeIn();
			 patient_pk_id = $(this).attr('data-id')
			fetch_all_prescription_data(patient_pk_id)
			fetch_allcomments(patient_pk_id)
			fetch_basic_details(patient_pk_id)
			
        });
        $('.closeCommentsPopupBtn').click(function(){
            $('.profileDetailsPopup').fadeOut();
            $('.shimmer').fadeOut();
        });
function fetch_basic_details(patient_pk_id){
	$.ajax({
		url:"action/prescription/fetch_user_basic_details.php",
		type:"POST",
		data:{patient_pk_id:patient_pk_id},
		success:function(parent_result){
			let parent_result_json = jQuery.parseJSON(parent_result)
			if(parent_result_json[0]['status'] !=0){
			$('#unique_code').text(parent_result_json[0]['patient_pk_id'])
			$('#patient_name').text(parent_result_json[0]['name'])
			$('#visit').text(parent_result_json[0]['count'])
			$('#age').text(parent_result_json[0]['age'])
			$('#gender').text(parent_result_json[0]['gender'])
			$('#phnnumber').text(parent_result_json[0]['phone'])
			$('#addressData').text(parent_result_json[0]['address'])
			$('#place').text(parent_result_json[0]['place'])
			}else{
				window.location.href="../login.php";
			}
		}
	})
}

function fetch_all_prescription_data(current_patient_uniqueid){
	$.ajax({
	url:"action/prescription/fetch_all_prevoius_prescription.php",
	type:"POST",
	data:{current_patient_uniqueid:current_patient_uniqueid},
	success:function(all_prescription){
		let all_prescription_json = jQuery.parseJSON(all_prescription)
		$('.prescriptionHistory table tbody').empty()
		if(all_prescription_json[0]['data_status'] == 1){
		for(let x1=0;x1<all_prescription_json.length;x1++){
			let section_data = '';
			if(all_prescription_json[x1]['morning_section'] == 1){
				if(section_data == ''){
					section_data = "Monday";
				}else{
					section_data += ",Monday";
				}
			}else if(all_prescription_json[x1]['noon_section'] == 1){
				if(section_data == ''){
					section_data = "Noon";
				}else{
					section_data += ",Noon";
				}
			}else if(all_prescription_json[x1]['evening_section'] == 1){
				if(section_data == ''){
					section_data = "Evening";
				}else{
					section_data += ",Evening";
				}
			}
			$('.prescriptionHistory table tbody').append(`<tr>
										<td>${all_prescription_json[x1]['medicine_name']}</td>
										<td>${all_prescription_json[x1]['quantity']}</td>
										<td>${section_data}</td>
										<td>${all_prescription_json[x1]['no_of_day']}</td>
										<td>${all_prescription_json[x1]['date_time']}</td>
									</tr>`)
		}
		}else{
			$('.prescriptionHistory table tbody').append(`No Data`)
		}
	}
		})
}


function fetch_allcomments(patient_id){
	
	$.ajax({
		url:"action/prescription/fetch_all_comments.php",
		type:"POST",
		data:{patient_id:patient_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data);
			console.log(result_data_json)
			$('.commentsPopupPreviousList dl').empty()
			console.log(result_data_json[0]['data_status'])
			if(result_data_json[0]['data_status'] !=0){
				$('.elseDesign_comments').css('display','none')
			for(let x=0;x<result_data_json.length;x++){
				let date = result_data_json[x]['added_date'];
				let date_details = result_data_json[x]['comment_data'];
				$('.commentsPopupPreviousList dl').append(`<dt class="PreviousListDate">
									<span>${date}</span>
								</dt>`)
				for(let x1=0;x1<date_details.length;x1++){
					$('.commentsPopupPreviousList dl').append(`<dd class="commentsPopupPreviousBox">
							${date_details[x1]['comment']}
								</dd>`)
				}
			}
			}else{
				console.log("haii")
				$('.elseDesign_comments').css('display','flex')
			}
		}
	})
}

fetch_doctor_profile_data()
function fetch_doctor_profile_data(){
	$.ajax({
		url:"action/profile/profile_data.php",
		success:function(profile_result){
			let profile_result_json = jQuery.parseJSON(profile_result)
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
			fetch_appointment_data()
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

$('body').delegate('.currentConsultingheadPrintBtn','click',function(e){
	e.preventDefault()
	$('.pageLoader').css('display','flex')
	//$('.currentConsultingheadPrintBtn').empty()
		//$(this).append(`<i class="uil uil-print"></i> Loading...`)
		let appointment_id = $(this).attr('data-id')
	$.ajax({
		url:"action/appointment/fetch_appointment_details_print.php",
		type:"POST",
		data:{appointment_id:appointment_id},
		success:function(result_data){
			let result_data_json = jQuery.parseJSON(result_data)
			
			if(result_data_json[0]['status'] == 1){
				$('#name_data').text('Name : '+result_data_json[0]['name'])
				$('#gender_data').text(result_data_json[0]['gender'])
				$('#age_data').text(result_data_json[0]['age']+' Years')
				$('#unique_id').text(result_data_json[0]['unique_id'])
				console.log(result_data_json[0]['total_visit_count'])
				$('#total_visit').text(result_data_json[0]['total_visit_count'])
				$('#first_visit').text(result_data_json[0]['first_visit'])
				$('#last_visit').text(result_data_json[0]['Last_visit'])
				$('#height_data').text(result_data_json[0]['height']+' cm')
				$('#weight_data').text(result_data_json[0]['weight']+' kg')
				$('#bmi_data').text(result_data_json[0]['BMI'])
				$('#weight_cat').text(result_data_json[0]['weight_cat'])
				$('#all_remark').text(result_data_json[0]['dite_remark'])
				let prescription_data = result_data_json[0]['prescription']
				if(prescription_data != undefined){
					$('.prescription_data_print').empty();
					$('.prescription_data_print').append(`<h2>Prescription</h2>`)
					
				for(let x=0;x<prescription_data.length;x++){
					let food_time = '';
					if(result_data_json[0]['prescription'][x]['after_food'] == 1){
						food_time = 'After Food';
					}else if(result_data_json[0]['prescription'][x]['befor_food'] == 1){
						food_time = 'Before Food';
					}
					let time_result =  result_data_json[0]['prescription'][x]['morning_section']+'-'+result_data_json[0]['prescription'][x]['noon_section']+'-'+result_data_json[0]['prescription'][x]['evening_section'];
					$('.prescription_data_print').append(`<p><b>${result_data_json[0]['prescription'][x]['medicine_name']}</b> ${time_result} ${result_data_json[0]['prescription'][x]['no_of_day']} days ${food_time}</p>`)
				}
				let complaint_data = result_data_json[0]['comment_data']
				if(complaint_data != undefined){
				//$('.complaints_data_print').empty()
					$('.complaints_data_print').append(`<h2>Complaints</h2>`)
				for(let xy = 0; xy<complaint_data.length;xy++){
				$('.complaints_data_print').append(`<p>${complaint_data[xy]['comment']}</p>`)
				}
				}
				
					let medical_data = result_data_json[0]['medical_data']
					if(medical_data != undefined){
						$('.medical_history_print').empty()
						$('.medical_history_print').append(`<h2>Medical History</h2>`)
					for( let xy2=0 ; xy2<medical_data.length; xy2++){
					$('.medical_history_print').append(`<p>${medical_data[xy2]['comment']}</p>`)
					}
				}
					
					let surgical_data = result_data_json[0]['surgical_data']
					if(surgical_data != undefined){
						$('.Investigations_data').empty()
						$('.Investigations_data').append(`<h2>Investigations</h2>`)
					for( let xy1 = 0; xy1<surgical_data.length; xy1++){
						$('.Investigations_data').append(`<p>${surgical_data[xy1]['comment']}</p>`)
					}
				}
					
					let food_to_follow = result_data_json[0]['diet_follow']
					if(food_to_follow != undefined){
						$('.food_to_follow').empty()
						for( let xyf1 = 0; xyf1<food_to_follow.length; xyf1++){
						$('.food_to_follow').append(`<p>${food_to_follow[xyf1]['diet']}</p>`)
					}
						if(result_data_json[0]['diet_no_of_days'] != 0){
						$('.food_to_follow').append(`<li><b>No. of Days : ${result_data_json[0]['diet_no_of_days']} Days</b></li>`)
						}
					}
					
					let food_to_avoid = result_data_json[0]['food_plan']
					if(food_to_avoid != undefined){
						$('.food_to_avoid').empty()
						for( let xyf2 = 0; xyf2<food_to_follow.length; xyf2++){
						$('.food_to_avoid').append(`<p>${food_to_avoid[xyf2]['foods_avoid']}</p>`)
					}
					
					}
				}
				$('.dynamic_doctor').empty()
				$('.dynamic_doctor').append(`<ul>
							<li><b>${result_data_json[0]['doctor_name']}</b></li>
							<li>${result_data_json[0]['qualification_data']}</li>
							<li>Reg No : ${result_data_json[0]['reg_num']}</li>
							<li>${result_data_json[0]['designation_data']}</li>
					</ul>`)
					
					setTimeout(function(){
						$('.pageLoader').css('display','none')
					window.print()
						//$('.currentConsultingheadPrintBtn').empty()
						//$('.currentConsultingheadPrintBtn').append(`<i class="uil uil-print"></i> Print`)
					},1000)
				
			}
		}
	})
	
})