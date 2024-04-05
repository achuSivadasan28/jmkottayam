let start_limit = 0;
let end_limit = 25;
let limit_range = start_limit+','+end_limit
let last_num = '';
let searchKey = '';
$('body').delegate('#search_btn', 'click', function () {
 searchKey = $('#search_val').val();
    customers()
	fetch_devotee_count()
		
	let page = 1;
let row_count = 0;
	$.when(fetch_devotee_count()).then(function(result){
		console.log(result)
		row_count=result;
	console.log(row_count)
	})
	.then(() => {
	
let count_no = row_count/end_limit;
let totalPages = parseInt(count_no);
//console.log(totalPages)
	 if(row_count % end_limit != 0){
                    	totalPages += 1;
	 }
//calling function with passing parameters and adding inside element which is ul tag
element.innerHTML = createPagination(totalPages, page);
})

})

//customers();
function customers(){
	
fetch('action/fetchcustomerList.php?searchKey=' + searchKey+'&limit_range='+limit_range)
.then(Response => Response.json())
.then(data => {
    console.log(data)
	$('.tableWraper table tbody').empty()
        if (data.length == 0) {
			$('.elseDesign').css('display','flex')
			$('.pagination ul').css('display','none')
        }else {
			$('.elseDesign').css('display','none')
 let b = start_limit;
	for (let x = 0; x < data.length; x++) {
		 b++;
		  let template = `
         <tr>
                                                    <td data-label="Sl No">
                                                        <p>${b}</p>
                                                    </td>
                                                    <td data-label="Customer Name">
                                                        <p>${data[x]['customer_name']}</p>
                                                    </td>
                                                    <td data-label="Phone">
                                                        <p>${data[x]['customer_phn']}</p>
                                                    </td>
                                                    <td data-label="Place">
                                                        <p>${data[x]['customer_place']}</p>
                                                    </td>
                                                    <td data-label="Action">
                                                        <div class="tableBtnArea">
															<a href="view-customer-details.php?id=${data[x]['id']}" class="tableViewBtn" title="View"><i class="uil uil-eye"></i>
															</a>
															<a href="edit-customer-details.php?id=${data[x]['id']}" class="tableEditBtn" title="Edit"><i class="uil uil-pen"></i>
															</a>
															<div class="tableDeleteBtn" title="Delete" data-id="${data[x]['id']}">
																<i class="uil uil-trash"></i>
															</div>
														</div>
                                                    </td>
                                                </tr>
        `
        $('#customers').append(template);
	}
		}
})
}

function fetch_devotee_count(){
	return $.ajax({
		url:"action/fetch_customer_count.php",
		type:"POST",
		data:{Searchval:searchKey,
			
			 },
		success:function(data){
							console.log(data)
}
	})
}

//deleting customers
$(document).ready(function () {
	$('body').delegate('.tableDeleteBtn', 'click', function (e) {
        e.preventDefault();
        id = $(this).attr('data-id')
        $('.deleteAlert').fadeIn();
            $('.shimmer').fadeIn();
    });
	$('body').delegate('.closedeleteAlert', 'click', function (e) {
        e.preventDefault();
        $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
    });
   
 $('body').delegate('.confirmdeleteAlert', 'click', function () {
        $('.deleteAlert').fadeOut();
            $('.shimmer').fadeOut();
        let urlval = id;

        fetch('action/deletecustomer_status.php?id=' + urlval)
            .then(Response => Response.text())
            .then(data => {
                console.log(data)
                if (data == 'deleted') {
					
                    window.location.reload();
                } else {

                }
            })

    })

});






//pagination

const element = document.querySelector(".pagination ul");

let page = 1;
let row_count = 0;
//console.log(row_count)
//fetch_vazhipadu_count()

$.when(fetch_devotee_count()).then(function(result){
		console.log(result)
		row_count=result;
	console.log(row_count)
	
	})

	
.then(() => {
	
let count_no = row_count/end_limit;
let totalPages = parseInt(count_no);
//console.log(totalPages)
	 if(row_count % end_limit != 0){
                    	totalPages += 1;
	 }
//calling function with passing parameters and adding inside element which is ul tag
element.innerHTML = createPagination(totalPages, page);
})

function createPagination(totalPages, page){
	//console.log(totalPages)
  let liTag = '';
  let active;
  let beforePage = page - 1;
  let afterPage = page + 1;
  if(page > 1){ //show the next button if the page value is greater than 1
	 /* let last_limit_count = parseInt(page)-1;
	 // console.log(last_limit_count)
            			start_limit = last_limit_count*end_limit
            			limit_range = start_limit+','+end_limit
           	 			searchdata()*/
    liTag += `<li class="btn prev" onclick="createPagination(${totalPages}, ${page - 1})"><span><i class="fas fa-angle-left"></i> Prev</span></li>`;
  }

  if(page > 2){ //if page value is less than 2 then add 1 after the previous button
    liTag += `<li class="first numb" onclick="createPagination(${totalPages}, 1)"><span>1</span></li>`;
    if(page > 3){ //if page value is greater than 3 then add this (...) after the first li or page
      liTag += `<li class="dots"><span>...</span></li>`;
    }
  }

  // how many pages or li show before the current li
 /* if (page == totalPages) {
    beforePage = beforePage - 2;
  } else if (page == totalPages - 1) {
    beforePage = beforePage - 1;
  }
  // how many pages or li show after the current li
  if (page == 1) {
    afterPage = afterPage + 2;
  } else if (page == 2) {
    afterPage  = afterPage + 1;
  }
	*/

  for (var plength = beforePage; plength <= afterPage; plength++) {
    if (plength > totalPages) { //if plength is greater than totalPage length then continue
      continue;
    }
    if (plength == 0) { //if plength is 0 than add +1 in plength value
      plength = plength + 1;
    }
    if(page == plength){ //if page is equal to plength than assign active string in the active variable
      active = "active";
    }else{ //else leave empty to the active variable
      active = "";
    }
	  let page_num = page;
	// console.log(page_num);
          let last_limit_count = page_num-1;
            start_limit = last_limit_count*end_limit
            limit_range = start_limit+','+end_limit
			customers()
    liTag += `<li class="numb  ${active}" onclick="createPagination(${totalPages},${plength})"><span>${plength}</span></li>`;
  }

  if(page < totalPages - 1){ //if page value is less than totalPage value by -1 then show the last li or page
    if(page < totalPages - 2){ //if page value is less than totalPage value by -2 then add this (...) before the last li or page
      liTag += `<li class="dots"><span>...</span></li>`;
    }
    liTag += `<li class="last numb" onclick="createPagination(${totalPages}, ${totalPages})"><span>${totalPages}</span></li>`;
  }

  if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
	  
    liTag += `<li class="btn next" onclick="createPagination(${totalPages}, ${page + 1})"><span>Next <i class="fas fa-angle-right"></i></span></li>`;
  }
  element.innerHTML = liTag; //add li tag inside ul tag
  return liTag; //reurn the li tag
}