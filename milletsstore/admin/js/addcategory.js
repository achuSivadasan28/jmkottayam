
    $('#category_details').submit(function(e){
        e.preventDefault()
         $('#submit_btn').text('Loading...')
    
    let category = $('#category').val()
	let address = $('#address').val()
	let gstNum = $('#gstNum').val()
	let phnNum = $('#phnNum').val()
    let fb = new FormData();
    fb.append('category', category)
	fb.append('address', address)
	fb.append('gstNum', gstNum)
	fb.append('phnNum', phnNum)

    fetch('action/add-category.php',{
        method:'POST',
        body:fb,
    })
    .then(Response=>Response.text())
    .then(data=>{
        console.log(data)
        if(data==1){
            $('#submit_btn').removeAttr('disabled');
            $('#submit_btn').text('data not inserted');

        }
        else {
           
            setTimeout(function () {
                $('#submit_btn').text('success');
                 $('#submit_btn').css('background-color', 'green');
             }, 1500);
         setTimeout(function () {
                window.location.href="category.php";
             }, 2000);
        //window.location.href="index.html";
        }
    })

})