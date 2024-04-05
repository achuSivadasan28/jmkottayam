let searchVal = '';
let start_date = '';
let end_date = '';
fetch_stock_analysis()

function fetch_stock_analysis(){
fetch('action/stock-analysis1.php?searchval='+searchVal+'&start_date='+start_date+'&end_date='+end_date)
.then(response=>response.json())
.then(data=>{
	console.log(data)
    let si_No=1;
    console.log(data)
    $('.tableWraper table tbody').empty(); 
if(data.length!=0){
	$('.elseDesign').css('display','none')
   for(let x=0;x<data.length;x++){
    $('.tableWraper table tbody').append(`
                    <tr>
                    <td data-label="Sl No">
                        <p>${si_No}</p>
                    </td>
                    <td data-label="Products Name">
                        <p>${data[x]['product_name']}</p>
                    </td>
                    <td data-label="Category">
                        <p>${data[x]['category_name']}</p>
                    </td>
                    <td data-label="Total Stocks">
                        <p>${data[x]['total_quantity_details']}</p>
                    </td>
                    <td data-label="Sold">
                     <p>${data[x]['quantity_details']}</p>
                    </td>
                    <td data-label="Left">
                        <p>${data[x]['balance_product']}</p>
                    </td>
                    <td data-label="Analysis">
                        <p class="good">${data[x]['sold_analysis']}%</p>
                    </td>
                    <td data-label="Left Analysis">
                    <p class="belowAvarage">${data[x]['blance_analysis']}%</p>
                </td>
                </tr>                              
            `)
            si_No++;
}
}else{
	$('.elseDesign').css('display','flex')
}
})
}

// serach status
$('#search_btn').click(function(){
    searchVal = $('#search_val').val();
	fetch_stock_analysis()
})


//date range filter
$('#date_btn').click(function(){
    start_date=$('#date_val').val();
    end_date=$('#date_val1').val();
	fetch_stock_analysis()
})