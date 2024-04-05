let url = location.href.split('=')[1]
fetch('action/view-category.php?id='+url)
  .then(Response=>Response.json())
  .then(data=>{
    let si_No=1;
    console.log(data)
    $('.tableWraper table tbody').empty();
    if(data.length!=0){
		$('.elseDesign').css('display','none')
    for(let x=0; x<data.length; x++){
        $('.tableWraper table tbody').append(`
                    <tr>
                    <td data-label="Sl No">
                        <p>${si_No}</p>
                    </td>
                    <td data-label="Products Name">
                        <p>${data[x]['product_name']}</p>
                    </td>
                    <td data-label="Action">
                        <div class="tableBtnArea">
                            <div class="tableDeleteBtn" title="Delete"  data-id="${data[x]['id']}">
                                <i class="uil uil-trash"></i>
                            </div>
                        </div>
                    </td>
                </tr>
    `)
    si_No++;
    } 
    }else{
		$('.elseDesign').css('display','flex')
	}
  })

// serach status
$('#search_btn').click(function(){
    let searchVal=$('#search_val').val();
  fetch('action/search-ctg.php?searchval='+searchVal +'&id='+url)
          .then(Response=>Response.json())
          .then(data=>{

              let si_No=1;
               console.log(data)
              $('.tableWraper table tbody').empty();
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
                 <td data-label="Products Name">
                     <p>${data[x]['product_name']}</p>
                 </td>
                 <td data-label="Action">
                     <div class="tableBtnArea">
                         <div class="tableDeleteBtn" title="Delete"  data-id="${data[x]['id']}">
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
  