jQuery(document).ready(function($)
{
	let headerHeight = $('#wpadminbar').outerHeight()
	let footerHeight = $('#wpfooter').outerHeight()
	let marginHeight = $('#wpbody-content').css('padding-bottom')
	let welcomeHeight = 'calc(100vh - ' + headerHeight + 'px - ' + footerHeight + 'px - ' + marginHeight + ')'
	$('#welcome-container').css('min-height', welcomeHeight)
})
