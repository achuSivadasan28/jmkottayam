let urlval=location.href.split('=')[1]
fetch("action/staff.php?id="+ urlval)
.then(Response=>Response.json())
.then(data=>{
  console.log(data)
  for(let x=0; x<data.length; x++){
    $('#s_name').val(data[x]['sname'])
    $('#phone').val(data[x]['phone'])
  }
})


$('#form_details').submit(function(e){
    e.preventDefault()
    $('#submit_btn').text('loading..')
    let sname = $('#s_name').val()
    let phone = $('#phone').val()
    let fb = new FormData();
    fb.append('sname',sname)
    fb.append('phone',phone)
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
                     window.location.href="profile.php";
                  }, 2000);
        }
        else{
           
        }
    })      
})
