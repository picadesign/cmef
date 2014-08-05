jQuery(function ($) {
	/** 
	 * Front End Editing for the author page.
	 * Set the parent
	 */
	var info_parent = $('.author .author-information');
	$('.author .author-information .button.edit').click(function(){
		//Show/Hide the edit buttons
		$(this).hide();
		info_parent.find('.button.save').css('display', 'table');
		//Use Redactor to make the description editable and the name editable.
		info_parent.find('.description-content #redactor').redactor({
			deniedTags: ['p']
		});
		$('.edit-author-meta-information').show();
	});

	/**
	 * Save the profile data.
	 */
	$('.author .author-information .button.save').click(function(){
		//Hide the Show Button
		$(this).hide();
		//Grab the information for the name
		//Break it into peices then check for more one space
		first_name = $('input[name=first_name').val();
		last_name = $('input[name=last_name').val();
		email_address = $('input[name=email_address').val();
		phone_number = $('input[name=phone_number').val();
		//Get description save to variable
		var description = info_parent.find('.description-content #redactor').redactor('get');
		//send to ajax
		$.post(ajaxurl,{
			//save the content to the author information.
			action: 'save_author',
			first_name: first_name,
			last_name: last_name,
			email_address: email_address,
			phone_number: phone_number,
			description: description,
			author_ID: $('#author_ID').val()
			//when we get a response from ajax destroy the redactors
		},function(response){
			info_parent.find('.button.edit').show();
			info_parent.find('.description-content #redactor').redactor('destroy');
			//update the content on the page.
			window.location.reload();
			$('.edit-author-meta-information').hide();
		});
	});

	/**
	 * Pass Match Checker.
	 */
});