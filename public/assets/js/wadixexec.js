$(window).on('load', function () {
	if ($('#preloader').length) {
		$('#preloader').delay(100).fadeOut('slow', function () {
			$(this).remove();
		});
	}
});

function fetchurlcopy() 
{
	let copyText = document.getElementById("copyfetch");
	copyText.select();
	document.execCommand("copy");
}

function fetchurlcopy2() 
{
	let copyText = document.getElementById("copyfetch2");
	copyText.select();
	document.execCommand("copy");
}

function errorAvatar(err) {
    err.src='https://cdn.discordapp.com/embed/avatars/0.png';
}