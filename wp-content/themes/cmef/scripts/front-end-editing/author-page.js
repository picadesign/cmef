jQuery(function ($) {
	// Front End Editing for the author page.
	// Set the parent
	var info_parent = $('.author .author-information');
	$('.author .author-information .button.edit').click(function(){
		//Show/Hide the edit buttons
		$(this).hide();
		$('.image-box').hide();
		$('.new-avatar').show();
		info_parent.find('.button.save').show();
		//Use Redactor to make the description editable and the name editable.
		info_parent.find('.description-content #redactor').redactor({
			deniedTags: ['p']
		});
		info_parent.find('.profile-name h2').redactor({
			air:true,
			deniedTags: ['p']
		});
	});
	$('.author .author-information .button.save').click(function(){
		//Hide the Show Button
		$(this).hide();
		//Grab the information for the name
		var name = info_parent.find('.profile-name h2').redactor('get');
		//Break it into peices then check for more one space
		first_name = name.substr(0, name.indexOf(' '));
		last_name = name.substr(name.indexOf(' ')+1);
		//Get description save to variable
		var description = info_parent.find('.description-content #redactor').redactor('get');
		//send to ajax
		$.post(ajaxurl,{
			action: 'save_author',
			first_name: first_name,
			last_name: last_name,
			description: description,
			author_ID: $('#author_ID').val()
		},function(response){
			info_parent.find('.button.edit').show();
			info_parent.find('.profile-name h2').redactor('destroy');
			info_parent.find('.description-content #redactor').redactor('destroy');
		});
		//save the content to the author information.
		//when we get a response from ajax destroy the redactors
		//update the content on the page.
		//show the edit button
	});

	$('#wp-add-button button').addClass('green')
});