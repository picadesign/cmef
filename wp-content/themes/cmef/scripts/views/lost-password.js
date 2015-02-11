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
			var email = $('form input[name=email]').val();	//email from the person requesting their lost password
			
			$.post(ajaxurl, {
				action: 'forgot_password',
				email: email
			}, function(response){
				console.log(response);
			});
		}
		
	});
});