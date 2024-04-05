// fetch('action/fetch-category.php')
//     .then(Response => Response.json())
//     .then(data => {
//         console.log(data)
//         for (x = 0; x < data.length; x++) {
//             $('#category').append(`<option value=${data[x]['id']} selected="true">${data[x]['category']}</option>`);
   
//         }
//     })
   
 let urlval=window.location.href
 let urlvalp=urlval.split("=")
 let urlv=urlvalp[1];
 $.when(fetchproduct(urlv)).then(function(productresult){
   let data=jQuery.parseJSON(productresult)
    $('#p_name').val(data[0]['product_name'])
   $('#category').val(data[0]['category'])
    $('#discount').val(data[0]['discount'])
    $('#quantity').val(data[0]['quantity'])
    $('#price').val(data[0]['price'])
    let cat_id=data[0]['category_id'];
    $.when(selectparentcat()).then(function(Allcat){
        if(Allcat==0){
        }
        else{
            let Allcategory=jQuery.parseJSON(Allcat)
            for(let x=0;x<Allcategory.length;x++){
                if(Allcategory[x]['id']==cat_id){
                    $('#category').append(`<option value="${Allcategory[x]['id']}" selected="true">${Allcategory[x]['category']}</option>`)
                }
                else{
                    $('#category').append(`<option value="${Allcategory[x]['id']}">${Allcategory[x]['category']}</option>`)     
                }
            }
        }
    })
    .then(()=>{
        create_custom_dropdowns()
    })
})


$('#form_details').submit(function(e){
  e.preventDefault()
  $('#submit_btn').text('loading..')
  let p_name = $('#p_name').val()
  let category = $('#category').val()
  let discount = $('#discount').val()
  let quantity = $('#quantity').val()
  let price = $('#price').val()
  let fb = new FormData();
  fb.append('p_name',p_name)
  fb.append('category',category)
  fb.append('discount',discount)
  fb.append('quantity',quantity)
  fb.append('price',price)
  let urlval1 = location.href.split('=')[1];            
  fetch("action/edit-product.php?id="+ urlval1,{
      method:'POST',
      body:fb,
  })
  .then(Response=>Response.text())
  .then(data=>{
      console.log(data)
      if(data==1){
           setTimeout(function () {
                   $('#submit_btn').text('success');
                    $('#submit_btn').css('background-color', 'green');
                }, 1500);
            setTimeout(function () {
                   window.location.href="products.php";
                }, 2000);
      }
      else{
         
      }
  })      
})

function selectparentcat(){
    return $.ajax({
        url:"action/fetch-category.php",
    })
}

function fetchproduct(urlv){
    return $.ajax({
        url:"action/product.php",
        type:"POST",
        data:{urlv:urlv},
    })
}
