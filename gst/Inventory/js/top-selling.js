let searchVal = '';
let start_date = '';
let end_date = '';
fetch_product_top_count()
function fetch_product_top_count(){
fetch('action/top-selling.php?searchval='+searchVal+'&start_date='+start_date+'&end_date='+end_date)
.then(Response=>Response.json())
.then(data=>{
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
                        <p>${data[x]['category']}</p>
                    </td>
                    <td data-label="Total Stocks">
                        <p>${data[x]['quantity']}</p>
                    </td>
                    <td data-label="Sold">
                     <p>${data[x]['no_quantity']}</p>
                    </td>
                    <td data-label="Left">
                        <p>${data[x]['left']}</p>
                    </td>
                    <td data-label="Analysis">
                        <p class="good">${data[x]['analysis']}%</p>
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
    searchVal=$('#search_val').val();
	fetch_product_top_count()
})

$('#date_filter').click(function(){
	start_date = $('#start_date').val()
	end_date = $('#end_date').val()
	fetch_product_top_count()
})
