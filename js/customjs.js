function previewImage() {
    document.getElementById("userPhotoImg").style.display = "block";
    var oFReader = new FileReader();
     oFReader.readAsDataURL(document.getElementById("userPhotoInput").files[0]);

    oFReader.onload = function(oFREvent) {
      document.getElementById("userPhotoImg").src = oFREvent.target.result;
    };
  };

$(document).ready(function(){
var base_url = 'https://auctionintel.com/clients/';	


 $('.modal-dialog').addClass('.modal-dialog-centered');

 /**-- DataTable --**/
	var settingsObj = {
				'undo':false,
				'redo':false,
				'insert_link':false,
				'unlink':false,
				'insert_img':false,
				'hr_line':false,
				'block_quote':false,
				'strikeout':false,
				'source':true,
				'strikeout':false,
				'indent':false,
				'outdent':false,
				'fonts':false,
				'styles':false,
				'print':false,
				'rm_format':false,
				'status_bar':false,
				'font_size':false,
				'color':false,
				'splchars':false,
				'insert_table':false,
				'select_all':false,
				'togglescreen':false
			}

  		    $('#DetailsInput').Editor(settingsObj);


			// This will set `ignore` for all validation calls
			jQuery.validator.setDefaults({
			  // This will ignore all hidden elements alongside `contenteditable` elements
			  // that have no `name` attribute
			  ignore: ":hidden, [contenteditable='true']:not([name])"
			});


			/*Bad Bidder Validation*/
			var modal_bidder = $('#biddersModal');
			var modal_form_bidder = $('#formBadBidders');

			modal_form_bidder.validate();

		    modal_form_bidder.on('submit', function (e) {
				var identity = $('#IdentityInput').val();
				var problem = $('#ProblemInput').val();
				var details = $('#formBadBidders .Editor-editor').html();

		        // if form is valid then call AJAX script
		        if (modal_form_bidder.valid()) {

		           $.ajax({
		           		type: 'POST',
		           		url: 'https://auctionintel.com/clients/dashboard/addBadBidders',
		           		data: {identity: identity, problem: problem, details: details},
		           		dataType: 'json',
		           		beforeSend:function(){
		           			$('#addMsg').html('<img src="'+base_url+'images/loader.gif" style="width:20px;"/> Adding bad bidder to list...').css({'color':'green','font-size':'14px','letter-spacing':'.5px'});
		           			$('#addMsg').show();
		           			$('#addBidderNow').attr('disabled',true);
		           		},
		           		success:function(response){

		           			if(response['status'] == 'added'){
		           				$('#addMsg').html('<img src="'+base_url+'images/icons/check.png" style="width:20px;"/>'+identity+' is added to list.').css({'color':'green','font-size':'14px','letter-spacing':'.5px'});
		           				$('#IdentityInput').val('');
		           				$('#ProblemInput').val('');
	        					$('.Editor-editor').html('');
	        					$('#addBidderNow').removeAttr('disabled');
	        					$('#IdentityInput').focus();

	        					$('.btn-comment').addClass('disabled');
                                $('.btn-delete').addClass('disabled');
                                $('#biddersCommentsWrapper').hide();

	        					$('#identityReports').DataTable().ajax.reload();
		           			}
		           		}
		           });


		        }

		        // stop default submit event of form
		        e.preventDefault();
		        e.stopPropagation();
		    });	

		    modal_bidder.on('shown.bs.modal', function (e) {
	        	$('#IdentityInput').focus();
	        	$('#addMsg').html('');
	    	});

		    modal_bidder.on('hide.bs.modal', function (e) {
		    	$('#addMsg').html('');
	        	$('#IdentityInput').val('');
	        	$('#ProblemInput').val('');
	        	$('.Editor-editor').html('');
	        	$('#addBidderNow').removeAttr('disabled');
	        	$('label.error').hide();
	    	});
			

			  	

		 var commentsEditor={
		 		'undo':false,
				'redo':false,
				'insert_link':false,
				'unlink':false,
				'insert_img':false,
				'hr_line':false,
				'block_quote':false,
				'strikeout':false,
				'source':true,
				'strikeout':false,
				'indent':false,
				'outdent':false,
				'fonts':false,
				'styles':false,
				'print':false,
				'rm_format':false,
				'status_bar':false,
				'font_size':false,
				'color':false,
				'splchars':false,
				'insert_table':false,
				'select_all':false,
				'togglescreen':false
		 } 

		 		
 		
 		$('#commentsWrapper').Editor(commentsEditor);


 		$('.comment-button').click(function(){

 			$('#post_comment').slideToggle();
 			$('#post_comment .Editor-editor').focus();


 		});

 		//element scroll
 		
 		$("[data-scroll-to]").click(function() {
		  var $this = $(this),
		      $toElement      = $this.attr('data-scroll-to'),
		      $focusElement   = $this.attr('data-scroll-focus'),
		      $offset         = $this.attr('data-scroll-offset') * 1 || 0,
		      $speed          = $this.attr('data-scroll-speed') * 1 || 500;

		  $('html, body').animate({
		    scrollTop: $($toElement).offset().top + $offset
		  }, $speed);
		  
		  if ($focusElement) $($focusElement).focus();
		});

 		/*user subscriptions*/
 		$('#upgradePlanBtn').click(function(){
  			window.open('https://subscriptions.zoho.com/portal/auctionintel/login');
		 });
		 
 		/*userimage upload*/
 		var myProfileForm = $('#updateUserInfo');

 		$("#userPhotoImg").click(function () {
		    $("#userPhotoInput").trigger('click');
		});
				

	    $('#updateUserInfo').validate();

	 	
	 	myProfileForm.on('submit',function(e){

	 		// stop default submit event of form
		        e.preventDefault();
		        var getPhoto = $('#userPhotoInput').val();
	 			var getFullName = $('#userFullName').val();
	 			var getEmail = $('#userEmail').val();
	 			var dataString = {'full_name': getFullName, 'email': getEmail}
		        	if(getPhoto == ''){
		        		
		        		$.ajax({
					 			type: 'POST',
					 			url: base_url+'users/updateProfileInfo',
					 			data: dataString,
					 			dataType: 'json',
					 			beforeSend:function(){
					 				$('#msg_update_profile').html('<img style="width: 15px;" src="'+base_url+'images/fblike-loader.gif" /> <span style="color:green;"> Updating profile.. please wait..</span>');	
					 			},
					 			success:function(response){
					 				$('#msg_update_profile').html('');				
					 				$('.profile-name').html(getFullName);
					 				$('.profile-text').html('Hello, '+getFullName+'!');
					 				}
					 			});
		        	}else{

		        		$.ajax({
				 				url: base_url+'users/updateProfilePhoto',
			                    type:'POST',
			                    data:new FormData(this),
			                    processData:false,
			                    contentType:false,
			                    cache:false,
			                    dataType:'json',
			                    beforeSend:function(){
			                    	$('#msg_update_profile').html('<img style="width: 15px;" src="'+base_url+'images/fblike-loader.gif" /> <span style="color:green;"> Updating profile.. please wait..</span>');	
			                    },
				 				success:function(response){
				 					$('#msg_update_profile').html('');
				 					$('.userImgProfile').attr('src',base_url+'user_images/'+response.new_img);

				 					console.log(response.msg);
				 					switch(response.msg){

				 						case 'updated':
					 							$.ajax({
					 								type: 'POST',
					 								url: base_url+'users/updateProfileInfo',
					 								data: dataString,
					 								dataType: 'json',
					 								success:function(response){
					 									$('.profile-name').html(getFullName);
					 									$('.profile-text').html('Hello, '+getFullName+'!');
					 									
					 								}
					 							});
				 						break;
				 						default:
				 								console.log('Error.. please try again...');
				 						break;

				 					}
				 				
				 				}
				 			});

		        	}

	 				
	 	});

	 	var userProfile = {

	 		updateProfile:function(){

	 			$.ajax({
	 				url: base_url+'users/updateProfile',
                    type:"post",
                    data:new FormData(this),
                    processData:false,
                    contentType:false,
                    cache:false,
	 				success:function(response){

	 					console.log(response);
	 				
	 				}
	 			});
	 		}
	 	}


	/* Update User Password*/
	var updatePassForm = $('#updateUserPassword');	

	updatePassForm.validate({
		rules:{
			userNewPass: {
				required: true,
				minlength: 5
				
			},
			userNewPassRepeat:{
				equalTo: "#userNewPass",
				required: true,
				minlength: 5
				
			}
		},
		messages:{
			userNewPassRepeat:{
				required: 'Confirm New Password Required.',
				equalTo: 'Please re-enter new Password.'
			},
			userPassword:{
				required: 'Please enter current Password.'
			},
			userNewPass:{
				required: 'New Password Required.'
			}

		},
		submitHandler:function(){

			var currentPass = $('#userPassword').val();	
			var newUserPass = $('#userNewPass').val();

			$.ajax({
				type: 'POST',
				url: base_url+'users/updateUserPassword',
				data: {'currentpass': currentPass, 'newpass': newUserPass},
				dataType: 'json',
				beforeSend:function(){
					$('#msg_on_update').html('<img style="width: 15px;" src="'+base_url+'images/fblike-loader.gif" /> <span style="color:green;"> Updating password.. please wait..</span>');	
				},
				success:function(response){
					console.log(response);
					switch(response.msg){

						case 'updated':
								$('#msg_on_update').html('<span style="color:green;letter-spacing:1px;">Password successfully updated. <a href="'+base_url+'users?action=logout&ref=relog-in">Re-login?</a></span>');
								$('#userPassword').val('');
								$('#userNewPass').val('');
								$('#userNewPassRepeat').val('');
								$('#userNewPass').prop('disabled', true);
								$('#userNewPassRepeat').prop('disabled', true);
								$('#btnChangedPass').addClass('disabled');

						break;

						default:
								$('#passChecker').html('<span style=" color: #ff000069;">Something happen unusual. please try again.</span>');
						
						break;
					}
					

				}
			});


		return false;
		}
	});


	$('#userPassword').on('change oninput', function(){

		var currentPass = $(this).val();
			$.ajax({
				type: 'POST',
				url: base_url+'users/checkUserPassword',
				data: {password:currentPass},
				dataType: 'json',
				beforeSend:function(){
					$('#passChecker').html('<img style="width: 15px;" src="'+base_url+'images/fblike-loader.gif" /> <span style="color:green;"> Checking current password.. please wait..</span>');
					$('#userNewPass').val('');
					$('#userNewPassRepeat').val('');
					$('#userNewPass').prop('disabled', true);
					$('#userNewPassRepeat').prop('disabled', true);
					$('#btnChangedPass').addClass('disabled');
					$('label.error').hide();
					$('#msg_on_update').html('');
				},
				success:function(response){
					console.log(response);

					switch(response.msg){
						case 'okay':
							console.log('okay');
							$('#passChecker').html('');
							$('#userNewPass').prop('disabled', false);
							$('#userNewPassRepeat').prop('disabled', false);
							$('#btnChangedPass').removeClass('disabled');
							$('#userNewPass').focus();

						break;
						default:
							console.log('not okay');
							$('#passChecker').html('<span style=" color: #ff000069;">Please check and enter current passsword.</span>');
						
						break;
					}
				}
			});
	});


});