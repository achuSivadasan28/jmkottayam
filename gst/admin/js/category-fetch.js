let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let search_val = '';
let last_num = '';

fetch_cat_count()
function fetch_cat_count(){
	$.ajax({
		url:"action/fetch_cat_count.php",
		type:"POST",
		data:{search_val:search_val,
			 },
		success:function(result){
			console.log(result)
			pageCount_drop_down(end_limit,result)
			pageSplit_num(end_limit,result)
			fetch_all_cat_details()
		}
	})
}

$('#pagenation_drop').change(function(){
    let page_count_val = $(this).val()
    limit_range = start_limit+","+page_count_val;
    end_limit = page_count_val;
	fetch_bill_count()
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
			fetch_all_cat_details()
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
            fetch_all_cat_details()
        })

        $('body').delegate('#page_num li','click',function(){
            let page_num = $(this).text()
            $('#page_num li').removeClass('navigationActive')
            $(this).addClass('navigationActive')
            let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			fetch_all_cat_details()
        })
        $('#pagenation_drop').change(function(){
            let page_count_val = $(this).val()
            limit_range = start_limit+","+page_count_val;
            last_limit = page_count_val;
            end_limit = page_count_val;
            fetch_cat_count()
        })

function fetch_all_cat_details(){
fetch('action/category-fetch.php?search_val='+search_val+'&limit='+limit_range)
.then(Response=>Response.json())
.then(data=>{
    let si_No=start_limit;
	$('#tbl_details tbody').empty()
if(data.length!=0){
	$('.elseDesign').css('display','none')
	
   for(let x=0;x<data.length;x++){
	   si_No++;
                        $('#tbl_details').append(`<tr>
                        <td data-label="Sl No">
                            <p>${si_No}</p>
                        </td>
                        <td data-label="Category Name">
                            <p>${data[x]['category']}</p>
                        </td>
                        <td data-label="Products">
                            <p>${data[x]['post']}</p>
                        </td>
                        <td data-label="Action">
                            <div class="tableBtnArea">
                                <a href="view-category.php?id=${data[x]['id']}" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
                                </a>
                                <a href="edit-category.php?id=${data[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
                                </a>
                                <div class="tableDeleteBtn" title="Delete" data-id="${data[x]['id']}">
                                    <i class="uil uil-trash"></i>
                                </div>
                            </div>
                        </td>
                    </tr>
            `)
            
}
}else{
	$('.elseDesign').css('display','flex')
	
}
})
}



// serach status
$('#search_btn').click(function(){
    search_val=$('#search_val').val();
	fetch_cat_count()
})