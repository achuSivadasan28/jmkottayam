let urlval=location.href.split('=')[1]
fetch("action/category.php?id="+ urlval)
.then(Response=>Response.json())
.then(data=>{
  console.log(data)
  for(let x=0; x<data.length; x++){
    $('#category').val(data[x]['category'])
	$('#address').val(data[x]['address'])
	$('#gstNum').val(data[x]['gstNum'])
	$('#phnNum').val(data[x]['phnNum'])
  }
})

$('#form_details').submit(function(e){
    e.preventDefault()
    $('#submit_btn').text('loading..')
    let category = $('#category').val()
	let address = $('#address').val()
	let gstNum = $('#gstNum').val()
	let phnNum = $('#phnNum').val()
    let fb = new FormData();
    fb.append('category',category)
	fb.append('address',address)
	fb.append('gstNum',gstNum)
	fb.append('phnNum',phnNum)
    let urlval1 = location.href.split('=')[1];            
    fetch("action/edit-category.php?id="+ urlval1,{
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
                     window.location.href="category.php";
                  }, 2000);
        }
        else{
           
        }
    })      
})
