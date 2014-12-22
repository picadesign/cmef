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
			$('.edit.button').toggle();
			$('.save.button').toggle();
			$('.edit-author-meta-information').toggle();

			var $inputs = $('.edit-author-meta-information form :input');

			var values = {};
			$inputs.each(function(){
				values[this.name] = $(this).val();
			})
			console.log(values);

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
				conf_new_password: values['conf_new_password']
			}, function(response){
				response = JSON.parse(response);
				if(response){
					console.log(response);	
				}else{
					//window.location.href = redirect;
				}
			});
			}
	});
});