jQuery(function ($) {
	ProfileView = Backbone.View.extend({
		el: $('.white-background'),
		events: {
			'click .edit.button': 'editProfile',
			'click .save.button': 'saveProfile'
		},
		initialize: function(){
			this.$el.html(this.$el.html());
		},
		editProfile: function(){
			$('.edit.button').toggle();
			$('.save.button').toggle();
			$('.edit-author-meta-information').toggle();
			$('.image-box').toggle();
			$('.new-avatar').toggle();
			$('#redactor').redactor();
		},
		saveProfile: function(){
			var $inputs = $('.edit-author-meta-information form :input');
			var values = {};
			$inputs.each(function(){
				values[this.name] = $(this).val();
			})

			$.post(ajaxurl, {
				action: 'save_profile',
				description: $('#redactor').redactor('get'),
				author_ID:['author_id'],
				first_name: values['first_name'],
				last_name: values['last_name'],
				street1: values['street1'],
				street2: values['street2'], 
				city: values['city'],
				zip: values['zip'],
				state: values['state'],
				old_password: values['old_password'],
				new_password: values['new_password'],
				conf_new_password: values['conf_new_password'],
				phone: values['phone_number'],
				email_address: values['email_address']
			}, function(response){
				response = JSON.parse(response);
				if(response.status == 'error'){
					console.log(response);	
					var error = '<p class="error">' + response.message + '</p>';
						$('.edit-author-meta-information .alert-messages').html(error);
				}else{
					$('.edit.button').toggle();
					$('.save.button').toggle();
					$('.edit-author-meta-information').toggle();
					$('#redactor').redactor('destroy');
					//TODO: website is throwing all sort of require.js errors try reversing what I did on this and the previous ajax file. 
					//window.location.href = redirect;
				}
			});
			}
	});
});