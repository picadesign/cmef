jQuery(function ($) {									//View for lost password page
	LostPasswordView = Backbone.View.extend({
		el: $('.white-background'),
		events: {
			//'click .edit.button': 'editProfile',
			//'click .save.button': 'saveProfile'
			'click .button.green': 'submitForm'				//click on submit forgot password form fire method below.
		},
		initialize: function(){
			this.$el.html(this.$el.html());
		},
		submitForm: function(){ 							//method for the submit form button (action) submits an ajax request
			$('.alert-messages').html('');
			var email = $('form input[name=email]').val();	//email from the person requesting their lost password
			var captcha = grecaptcha.getResponse();			//gets the response from the form

			if(!captcha){									//If response is empty then they didnt verify
				$('.alert-messages').html('<div class="error">Please check "I\'m not a robot".</div>')
			}
			else{											//if the response isn't empty then they verified and we cant submit the form
				$.post(ajaxurl, {
					action: 'forgot_password',
					captcha: captcha,
					email: email
				}, function(response){
					console.log(response);
				});
			}	
		}
	});
});