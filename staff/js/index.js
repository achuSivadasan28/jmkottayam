fetch('action/dashboard.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        $('.navProfileName p').append(`${data[0]['sname']}`)
        $('.navProfileName span').append(`${data[0]['srole']}`)
    })