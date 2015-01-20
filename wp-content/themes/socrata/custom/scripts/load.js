$(document).ready(function() { 

	$('#trigger a').click(function(){
								  
		var toLoad = $(this).attr('href')+' #video';
		$('#video').fadeOut('normal',loadContent);		
		

		function loadContent() {
			$('#video').load(toLoad,'',hideTrigger(),showNewContent())
		}
		function showNewContent() {
			$('#video').fadeIn('normal');
		}
		function hideTrigger() {
			$('#trigger').hide('fast');
		}
		return false;
		
	});

});