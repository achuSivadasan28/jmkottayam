fetch('action/profile.php')
.then(Response=>Response.json())
.then(data=>{
    console.log(data)
 if(data.length!=0)
    for(let x=0;x<data.length;x++){
               console.log(data[x])
$('.doctorProfileBody').append(`  <div class="doctorProfileBodyBox">
<div class="doctorProfileBodyBoxhead">
    <h2>Personal Details</h2>
    <a href="edit-profile.php?id=${data[x]['id']}">Edit</a>
</div>
<ul>
    <li>
        <span>Phone <b>:</b></span>
        <p>${data[x]['phone']}</p>
    </li>
    <li>
        <span>Email <b>:</b></span>
        <p>${data[x]['email']}</p>
    </li>
</ul>
</div>     
                 `);
$('.doctorProfileName h2').append(`
${data[x]['admin_name']}
`)

}
})

