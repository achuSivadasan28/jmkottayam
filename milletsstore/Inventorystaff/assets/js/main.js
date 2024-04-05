
// sidemenu 
$('.navBarBox').click(function(){
	$('.sidemenu').toggleClass('sidemenuFullActive');
	$('.navBarBox').toggleClass('navBarBoxActive');
	$('.canvas').toggleClass('canvasActive');
})

//nav dropdown 
$('.navProfileBox').click(function(){
	$('.navDropDown').toggleClass('navDropDownActive')
})
$(document).mouseup(function(e) 
{
    var container = $('.navDropDown');

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) 
    {
        container.removeClass('navDropDownActive')
    }
});