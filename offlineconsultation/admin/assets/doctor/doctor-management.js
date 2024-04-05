
let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let last_num = '';
let status_id = 0;
let search_val = '';

let dep_id = 0;
let branch_id_f = 0;
const element = document.querySelector(".pagination ul");
let totalPages = 0;
let page = 1;
$('#search_btn').click(function(){
	search_val = $('#search_val').val()
	fetch_all_doctor()
})
fetch_all_doctor()

function fetch_all_doctor(){
	$.ajax({
		url:"action/doctor/fetch_all_doctor_count.php",
		type:"POST",
		data:{search_val:search_val,
			  dep_id:dep_id,
			  branch_id_f:branch_id_f},
		success:function(result){
			//pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,result)
			//fetch_doctor_data()
		}
	})
}

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_doctor_data()
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
			fetch_doctor_data()
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
            fetch_doctor_data()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_doctor_data()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_all_doctor()
        })

fetch_doctor_data()
function fetch_doctor_data(){
$.ajax({
	url:"action/doctor/fetch_all_doctor.php",
	type:"POST",
	data:{search_val:search_val,
		 limit_range:limit_range,
		 dep_id:dep_id,
		 branch_id_f:branch_id_f
		 },
	success:function(result){
		console.log(result)
		let result_data_json = jQuery.parseJSON(result)
		if(result_data_json[0]['status'] == 1){
			
			$('.tableWraper table tbody').empty()
			if(result_data_json[0]['data_status'] == 1){
				$('.pagination').css('display','flex')
				$('.elseDesign').css('display','none')
				let result_len = result_data_json.length
				let si_no = 0;
				for(let x=0;x<result_len;x++){
					si_no++;
				$('.tableWraper table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${si_no}</p>
                                                    </td>
                                                    <td data-label="Doctor Name">
                                                        <p>${result_data_json[x]['doctor_name']}</p>
                                                    </td>
													<td data-label="Phone">
                                                        <p>${result_data_json[x]['phone_no']}</p>
                                                    </td>
													<td data-label="Phone">
                                                        <p>${result_data_json[x]['email']}</p>
                                                    </td>
													<td data-label="Department">
                                                        <p>${result_data_json[x]['role']=='doctor'?'Doctor':'Cheaf Doctor'}</p>
                                                    </td>
													<td data-label="Department">
                                                        <p>${result_data_json[x]['department_name']}</p>
                                                    </td>

													<td data-label="Branch">
                                                        <p>${result_data_json[x]['branch_name']}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                            <a href="edit-doctor.php?id=${result_data_json[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                                            </a>
                                                            <div class="tableDeleteBtn" title="Delete" data-id="${result_data_json[x]['id']}">
                                                                <i class="uil uil-trash"></i>
                                                            </div>
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

$.ajax({
	url:"action/branch/fetch_all_branch_no_limit.php",
	success:function(branch_result){
		let branch_result_json = jQuery.parseJSON(branch_result);
		if(branch_result_json.length !=0){
			for(let x=0;x<branch_result_json.length;x++){
				$('.branch_names').append(`<div class="formGroup">
                            <input type="checkbox" class="branch_val" value="${branch_result_json[x]['id']}" id="${branch_result_json[x]['id']}">
                            <label for="${branch_result_json[x]['id']}">${branch_result_json[x]['branch_name']}</label>
                        </div>`)
			}
	}else{
			
	}
}
})

$.ajax({
	url:"action/department/fetch_all_department_no_limit.php",
	success:function(dep_result){
		let dep_result_json = jQuery.parseJSON(dep_result);
		if(dep_result_json.length !=0){
			for(let x=0;x<dep_result_json.length;x++){
				$('.department_names').append(`<div class="formGroup">
                            <input type="checkbox" value="${dep_result_json[x]['id']}" class="dep_val" id="${dep_result_json[x]['id']}">
                            <label for="${dep_result_json[x]['id']}">${dep_result_json[x]['department_name']}</label>
                        </div>`)
			}
		}else{
			
		}
	}
})

$('.applyFilter').click(function(){
	dep_id = 0;
	branch_id_f = 0;
	$('.dep_val').each(function(){
		if($(this).prop('checked') == true){
			dep_id = $(this).val()
		}
	})
	
	$('.branch_val').each(function(){
		if($(this).prop('checked') == true){
			branch_id_f = $(this).val()
		}
	})
fetch_all_doctor()
})
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
			fetch_doctor_data()
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