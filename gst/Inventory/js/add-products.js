fetch('action/fetch-category.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        for (x = 0; x < data.length; x++) {
            $('#category').append(`<option value=${data[x]['id']}>${data[x]['category']}</option>`);
   
        }

    })
    .then(()=>{
        create_custom_dropdowns()
    })

    //add products
    
    $('#form_act').submit(function(e){
        e.preventDefault()
         $('.submitBtn').text('Loading...')
    let p_name = $('#p_name').val()
    let price = $('#price').val()
    let discount = $('#discount').val()
    let quantity = $('#quantity').val()
    let select=$('#category').val()  
    let fb = new FormData();
    fb.append('p_name', p_name)
    fb.append('select', select)
    fb.append('price', price)
    fb.append('discount', discount)
    fb.append('quantity', quantity)
    fetch('action/add-products.php',{
        method:'POST',
        body:fb,
    })
    .then(Response=>Response.text())
    .then(data=>{
        console.log(data)
        if(data==1){
            $('.submitBtn').removeAttr('disabled');
            $('.submitBtn').text('data not inserted');

        }
        else {
           
            setTimeout(function () {
                $('.submitBtn').text('success');
                 $('.submitBtn').css('background-color', 'green');
             }, 1500);
         setTimeout(function () {
                window.location.href="products.php";
             }, 2000);
        //window.location.href="index.html";
        }
    })

})