let urlval = location.href.split('=')[1];
$('.customerDetailsSectionBoxHeadAction').append(`<a href="edit-customer-details.php?id=${urlval}" class="edit">Edit</a>`)
fetch('action/viewcustomer.php?id=' + urlval)
  .then(Response => Response.json())
    .then(data => {
        console.log(data)
	let template =``;
	
	for(let x1=0;x1<data.length;x1++){
		 let added_date = data[x1]['added_date'];
	   let customer_name = data[x1]['customer_name'];
		 let customer_place = data[x1]['place'];
		 let customer_phn = data[x1]['phn'];
		$('.customerDetailsSectionBoxHeadProfileName h1').append(`${customer_name}`)
		$('#place').append(`${customer_place}`)
		$('#phn').append(`${customer_phn}`)
		template += ` 

       <div class="customerDetailsSectionBoxHistoryDate">
									<span>${added_date}</span>
									<div class="line"></div>
								</div>`
          let c = 0;
    for(let y=0; y<data[x1]['products'].length; y++){
c++;
		
                  template += `<div class="customerDetailsSectionBoxHistoryDetails">
									<div class="productName">${data[x1]['products'][y]['product_name']}</div>
									<div class="productQTY"><span>-</span> ${data[x1]['products'][y]['qty']} QTY</div>
								</div>
`
				  
				
	}
            
	}
	
	   $('.customerDetailsSectionBoxHistoryBox').append(template); 
})