let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let search_val = '';
let last_num = '';

fetch_staff_count()
function fetch_staff_count(){
	$.ajax({
		url:"action/fetch_staff_count.php",
		type:"POST",
		data:{search_val:search_val,
			 },
		success:function(result){
			pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,result)
			fetch_all_staff_details()
		}
	})
}

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_staff_count()
})

        function pageSplit_num(end_limit,total_num){
            $('#page_num').empty()
            let num = 0;
            if(total_num <=end_limit){
				$('.paginationCount').css('display','none')
                num = 1;
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
            fetch_all_staff_details()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_all_staff_details()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_staff_count()
        })

function fetch_all_staff_details(){
	$('.sckelly').css({
			display: 'flex',
		 });
fetch('action/staff-fetch.php?search_val='+search_val+'&limit='+limit_range)
.then(Response=>Response.json())
.then(data=>{
	$('#tbl_details tbody').empty()
    let si_No=start_limit;
if(data.length!=0){
	$('.elseDesign').css('display','none')
   for(let x=0;x<data.length;x++){
	   si_No++;
       //console.log(data[x]['id'])    
                        $('#tbl_details').append(`<tr>
                        <td data-label="Sl No">
                            <p>${si_No}</p>
                        </td>
                        <td data-label="Staff Name">
                            <p>${data[x]['staff_name']}</p>
                        </td>
                        <td data-label="Phone">
                            <p>${data[x]['phone']}</p>
                        </td>
                        <td data-label="Branch">
                            <p>${data[x]['branch']}</p>
                        </td>
						<td data-label="email">
                            <p>${data[x]['email']}</p>
                        </td>
                        <td data-label="Action">
                            <div class="tableBtnArea">
                                <a href="edit-staff.php?id=${data[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                </a>
                                <div class="tableDeleteBtn" title="Delete" data-id="${data[x]['id']}">
                                    <i class="uil uil-trash"></i>
                                </div>
                            </div>
                        </td>
                        </tr>`)
            
}
}else{
	$('.elseDesign').css('display','flex')
}
})
	.then(() =>{
		$('.sckelly').css({
			display: 'none',
		 });
	
	})
}

// serach staff
$('#search_btn').click(function(){
    let searchVal=$('#search_val').val();
  fetch('action/search-staff.php?searchval='+searchVal)
          .then(Response=>Response.json())
          .then(data=>{

              let si_No=1;
	   $('.tableWraper table tbody').empty();
               console.log(data)
             
         if(data.length == 0){
         $('.elseDesign').css({
              display:'flex'
         })
      } else {
          $('.elseDesign').css({
              display:'none'
          })
             for(let x=0;x<data.length;x++){
                 console.log(data)
                 $('.tableWraper table tbody').append(`<tr>
                 <td data-label="Sl No">
                     <p>${si_No}</p>
                 </td>
                 <td data-label="Staff Name">
                     <p>${data[x]['staff_name']}</p>
                 </td>
                 <td data-label="Phone">
                     <p>${data[x]['phone']}</p>
                 </td>
                 <td data-label="Branch">
                     <p></p>
                 </td>
                 <td data-label="Action">
                     <div class="tableBtnArea">
                         <a href="edit-staff.php?id=${data[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                         </a>
                         <div class="tableDeleteBtn" title="Delete" data-id="${data[x]['id']}">
                             <i class="uil uil-trash"></i>
                         </div>
                     </div>
                 </td>
                 </tr>`)
             si_No++;
      }
  }
})
})
