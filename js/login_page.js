$(document).ready(function(){
	var base_url = 'https://auctionintel.com/clients/';

	
	$('#loginForm').submit(function(e){
		e.preventDefault();
		var user_data = $('#loginForm').serialize();
		
			$.ajax({
					type: 'POST',
					url: base_url + 'users/auth',
					dataType: 'json',
					data: user_data,
					success:function(response){
						console.log(response);
						$('#message').html(response.message);
						$('#logText').html('Login');
						if(response.error){
							$('#responseDiv').removeClass('alert-success').addClass('alert-danger').show();
						}
						else{
							$('#responseDiv').removeClass('alert-danger').addClass('alert-success').show();
							$('#loginForm')[0].reset();
							setTimeout(function(){
								window.location = base_url+'dashboard';

							}, 3000);
						}
					}
				});



	});


	$(document).on('click', '#clearMsg', function(){
			$('#responseDiv').hide();
		});


});