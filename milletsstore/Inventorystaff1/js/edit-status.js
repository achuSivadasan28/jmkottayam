let urlval=location.href.split('=')[1]
fetch("action/staff.php?id="+ urlval)
.then(Response=>Response.json())
.then(data=>{
  console.log(data)
  for(let x=0; x<data.length; x++){
    $('#sname').val(data[x]['sname'])
    $('#phone').val(data[x]['phone'])
	$('.current').text(data[x]['branch'])
	  let role = data[x]['role'];
	  if(role == '1'){
			$('#role_data').append(`<option value="1" selected>Counter Staff</option>
								<option value="2">Inventory Manager</option>`)	  
	  }else{
	  	$('#role_data').append(`<option value="1">Counter Staff</option>
								<option value="2" selected>Inventory Manager</option>`)	  
	  }
  }
})


$('#form_details').submit(function(e){
    e.preventDefault()
    $('#submit_btn').text('loading..')
    let sname = $('#sname').val()
    let phone = $('#phone').val()
	let branch = $('.current').text()
	let role_data = $('#role_data').text()
    let fb = new FormData();
    fb.append('sname',sname)
    fb.append('phone',phone)
	fb.append('branch',branch)
	fb.append('role_data',role_data)
    let urlval1 = location.href.split('=')[1];            
    fetch("action/edit-staff.php?id="+ urlval1,{
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
                     window.location.href="staff-management.php";
                  }, 2000);
        }
        else{
           
        }
    })      
})
