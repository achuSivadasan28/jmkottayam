let url=location.href;
let url_val=url.split('/');
let branch_name=url_val[2].split('.')[0]
let admin_type=url_val[3];
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
let status_val_fil='';

$('#mySelect').change(function(){
status_val_fil=$(this).val();
	fetch_staff_data()
})

$('#search_btn').click(function(){
	search_val = $('#search_val').val()
	fetch_all_staff()
})
fetch_all_staff()


		
function fetch_all_staff(){
	$.ajax({
		url:"action/errorLog/fetch_all_log_count.php",
		type:"POST",
		data:{search_val:search_val,
			  branch_id_f:branch_id_f,
			  branch_name:branch_name, 
		 	  admin_type:admin_type,
			  status_val_fil:status_val_fil,},
		success:function(result){
			//console.log(result)
			//pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,result)
			//fetch_staff_data()
		}
	})
}

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_staff_data()
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
            fetch_staff_data()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_staff_data()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_all_staff()
        })

fetch_staff_data()
function fetch_staff_data(){
$.ajax({
	url:"action/errorLog/fetch_all_errors.php",
	type:"POST",
	data:{search_val:search_val,
		 limit_range:limit_range,
		 branch_id_f:branch_id_f,
		 branch_name:branch_name, 
		 admin_type:admin_type, 
		 status_val_fil:status_val_fil, 
		 },
	success:function(result){
		console.log(result)
		let result_data_json = jQuery.parseJSON(result)			
			$('.tableWraper table tbody').empty()
				$('.pagination').css('display','flex')
				$('.elseDesign').css('display','none')
				let result_len = result_data_json.length
				if(result_len!=0){
				let si_no = 0;
				for(let x=0;x<result_len;x++){
					si_no++;
				let status_val=result_data_json[x]['error_status'];
				let status_val_fch='';	
					console.log(status_val)
				if(status_val == 1){
				status_val_fch=`<p style="color:green">${result_data_json[x]['status_val']}</p>`
				}	
				else if(status_val == 2){
				status_val_fch=`<p style="color:orange">${result_data_json[x]['status_val']}</p>`
				}
				else{
				status_val_fch=`<p style="color:red">${result_data_json[x]['status_val']}</p>`
				}
				
				let approve_status_val='';
				if(result_data_json[x]['approve_status']==1){
				approve_status_val=`<p style="color:green">Yes</p>`
				}
				else{
				approve_status_val=`<p style="color:red">No</p>`
				}	
				$('.tableWraper table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p>${si_no}</p>
                                                    </td>
                                                    <td data-label="Issue Info">
                                                        <p>${result_data_json[x]['issue_info']}</p>
                                                    </td>
													<td data-label="Date">
                                                        <p>${result_data_json[x]['added_date']}</p>
                                                    </td>
													<td data-label="Approve Status">
                                                        ${approve_status_val}
                                                    </td>
													<td data-label="Status">
                                                        ${status_val_fch}
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
                                                           <a href="#" class="tableViewBtn" title="View" data-id="${result_data_json[x]['id']}"><i class="uil uil-eye"></i>
                                                            </a> 
															<div class="FollowupQuotation" data-id="${result_data_json[x]['id']}" style="    padding: 6px 15px;
																background: darkolivegreen;
																color: white;
																text-align: center;
																width: fit-content;
																border-radius: 5px;
																cursor: pointer;
																font-size: 14px;
																transition: .3s;
																white-space: pre;">Remark</div>
                                                            <!--<div class="tableDeleteBtn" title="Delete" data-id="${result_data_json[x]['id']}">
                                                                <i class="uil uil-trash"></i>
                                                            </div>-->
                                                        </div>
                                                    </td>
                                                </tr>`)
				}
	}
		else{
		$('.pagination').css('display','none')
		$('.elseDesign').css('display','flex')	
		}
	}
})
}

        // delete alert 
		let staff_id = 0; 
		let parsent_div = ''; 
        $('body').delegate('.tableDeleteBtn','click',function(){
			staff_id = $(this).attr('data-id')
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
				url:"action/staff/delete.php",
				type:"POST",
				data:{staff_id:staff_id},
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
			fetch_staff_data()
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

$('body').delegate('.tableViewBtn', 'click', function(e){
	e.preventDefault();
	$('.followUpPopup').fadeIn();
	$('.shimmer').fadeIn();
	let err_id=$(this).attr('data-id')
	fetch('action/errorLog/fetch_all_remarks.php?id='+err_id)
	.then(Response=>Response.json())
	.then(data=>{
	console.log(data)
		$('.followUpPopupMain table tbody').empty();
		if(data.length!=0){
			let sino=0;
			for(let x=0;x<data.length;x++){
				sino++;
				let remark_done_by_admin='';
				let remark_done_status='';
				if(data[x]['remark_done_by_admin']==1){
				remark_done_status='EBS';
				}else{
				remark_done_status='JM';
				}
				$('.followUpPopupMain table tbody').append(`<tr>
                                                    <td data-label="Sl No">
                                                        <p style="white-space: nowrap;">${sino}</p>
                                                    </td>
                                                    <td data-label="Issue Info">
                                                        <p style="white-space: nowrap;">${data[x]['action_perfomed']}(${remark_done_status})</p>
                                                    </td>
													<td data-label="Issue Info">
                                                        <p style="white-space: nowrap;">${data[x]['added_date']}</p>
                                                    </td>
													<td data-label="Issue Info">
                                                        <p style="white-space: nowrap;">${data[x]['added_time']}</p>
                                                    </td>
													<td data-label="Issue Info">
                                                        <p style="white-space: nowrap;">${data[x]['remark_val']}</p>
                                                    </td>													
														</tr>`)
		/*$('.followUpPopupMain').append(`<div class="followUpPopupList">
					<div class="followUpPopupBox">
						<span>Date</span>
						<p>${data[x]['added_date']} (${data[x]['added_time']})</p>
					</div>
					<div class="followUpPopupBox">
						<span>Remark</span>
						<p>${data[x]['remark_val']}</p>
					</div>
				</div>`)*/
			}
		}
		else{
	$('.followUpPopupMain').append(`<h1>There in no data!</h1>`)	
		}
	})
})
$('body').delegate('.closeFollowUpPopup', 'click', function(){
	$('.followUpPopup').fadeOut();
	$('.shimmer').fadeOut();
})

//FollowupQuotation
let error_id='';
$('body').delegate('.FollowupQuotation', 'click', function(){
	$('.FollowupQuotationPopup').fadeIn();
	$('.shimmer').fadeIn();
	error_id=$(this).attr('data-id')
})
$('body').delegate('.closeFollowupQuotationPopup', 'click', function(){
	$('.FollowupQuotationPopup').fadeOut();
	$('.shimmer').fadeOut();
	$('#remark_val').css('border','1px solid #ccc')	
})

$('body').delegate('.confirmFollowupQuotationPopup', 'click', function(){
	let error_id_val=error_id;
	let remark_val=$('#remark_val').val().trim();
	if(remark_val ==''){
		$('#remark_val').css('border','1px solid red')
	}
	else{
	$('#remark_val').css('border','1px solid #ccc')	
	$(this).text('Loading...');
	$(this).attr('disabled',true);	
	$('#follow_up_date').css("border","1px solid #ccc");	
	let fb=new FormData();
	fb.append('remark_val',remark_val)
	fb.append('branch_name',branch_name)
	fb.append('admin_type',admin_type)
	fetch('action/errorLog/add_remark.php?id='+error_id_val,{
	method:'POST',
	body:fb	
	})
	.then(Response=>Response.json())
	.then(data=>{
	console.log(data)
		if(data ==1){
	$('#follow_up_date').val('');	
	$('#remark_val').val('');
	$(this).text('Submit');
	$(this).attr('disabled',false);			
	$('.FollowupQuotationPopup').fadeOut();
	$('.shimmer').fadeOut();
	fetch_staff_data()		
		}
	})
	}
})