fetch('action/dashboard.php')
    .then(Response => Response.json())
    .then(data => {
        console.log(data)
        $('.navProfileName p').text(data[0]['user'])
        $('.navProfileName span').text(data[0]['srole'])
    })