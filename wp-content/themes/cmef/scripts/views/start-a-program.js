jQuery(function ($) {
	StartProgramView = Backbone.View.extend({
		el: $('.white-background.page.box-shadow'),
		cachedEl: $('.white-background'),
		//template: cmef_settings.mustache_template_path + 'start-a-program-tmpl.html',
		program_name_el: '#new_program input[name="program_name"]',
		fundraising_goal_el: '#new_program input[name="fundraising_goal"]',
		number_students_el: '#new_program input[name="number_students"]',
		grade_level_el: '#new_program select[name="grade_level"]',
		tfa_region_el: '#new_program select[name="tfa_region"]',
		program_description_el: '.new-program-description',
		username_el: '#register input[name="username"]',
		email_el: '#register input[name="email"]',
		confirm_email_el: '#register input[name="confirm_email"]',
		password_el: '#register input[name="pass"]',
		confirm_password_el: '#register input[name="confirm_pass"]',
		corps_region_el: '#register input[name="corp_region"]',
		first_name_el: '#register input[name="first_name"]',
		last_name_el: '#register input[name="last_name"]',
		corps_year_el: '#register input[name="corp_year"]',
		phone_el: '#register input[name="phone"]',
		street_1_el: '#register input[name="street_1"]',
		street_2_el: '#register input[name="street_2"]',
		city_el: '#register input[name="city"]',
		state_el: '#register input[name="state"]',
		zip_el: '#register input[name="zip"]',
		events: {
			'click #submit-new-program': 'newProgram',
			'click #submit-registration': 'newRegistration',
			'click .button.image-uploader-choose-file': 'chooseFileUpload',
			'change .image-uploader': 'updateImageInputBox',
			'click .button.image-uploader-button': 'uploadImage',
			'click .uploaded-image': 'setFeaturedImage',
			'click .image-container .delete-image': 'deleteImage',
			'click .program-complete': 'programRedirect'
		},
		initialize: function(){
			$("#accordion").accordion({ 
				animated: 'bounceslide',
				collapsible: false, 
				heightStyle: "content"
			});
		},
		render: function(){
			othis = this;
			$.get(this.template, function(template) {
				var rendered = Mustache.render(template, {
					post_title: postData.post_title,
					ID: postData.ID,
					post_author: postData.post_author,
					post_date: postData.post_date,
					post_date_gmt: postData.post_date_gmt,
					post_content: postData.post_content,
					post_title: postData.post_title,
					post_excerpt: postData.post_excerpt,
					post_status: postData.post_status,
					comment_status: postData.comment_status,
					ping_status: postData.ping_status,
					post_password: postData.post_password,
					post_name: postData.post_name,
					to_ping: postData.to_ping,
					pinged: postData.pinged,
					post_modified: postData.post_modified,
					post_modified_gmt: postData.post_modified_gmt,
					post_content_filtered: postData.post_content_filtered,
					post_parent: postData.post_parent,
					guid: postData.guid,
					menu_order: postData.menu_order,
					post_type: postData.post_type,
					post_mime_type: postData.post_mime_type,
					comment_count: postData.comment_count,
					ancestors: postData.ancestors,
					filter: postData.filter,
					userLoggedIn: cmef_settings.userLoggedIn,
					ajaxurl: ajaxurl
				});
				othis.$el.append(rendered);
				//othis.test = $('.new-program-description');
				$(othis.program_description_el).redactor({minHeight: 200});
				
				
			});
		},
		alertAction: function(response){
			var alerts = jQuery.parseJSON(response);
			
			if(alerts.alert != 'success'){
				//console.log(description);
				var error = '<p class="error">' + alerts.alert + '</p>';
				$('.alert-messages').html(error);
				$('body,html').animate({
					scrollTop: 0
				}, 800);
			}
			else if(alerts.alert === 'success'){
				$('.alert-messages').html('');
				var active = $( "#accordion" ).accordion( "option", "active" );
				$("#accordion").accordion({ 
					animated: 'bounceslide',
					collapsible: false, 
					heightStyle: "content",
					active: active + 1
				});
			}
		},
		newRegistration: function(){
			var username = $(this.username_el).val();
			var email = $(this.email_el).val();
			var confirm_email = $(this.confirm_email_el).val();
			var corps_region = $(this.corps_region_el).val();
			var first_name = $(this.first_name_el).val();
			var last_name = $(this.last_name_el).val();
			var corps_year = $(this.corps_year_el).val();
			var phone = $(this.phone_el).val();
			var street_1 = $(this.street_1_el).val(); 
			var street_2 = $(this.street_2_el).val();
			var city = $(this.city_el).val();
			var state = $(this.state_el).val();
			var zip = $(this.zip_el).val();
			othis = this;

			var obutton = $("#submit-registration .button-text");
			obuttonhtml = obutton.html()
			obutton.text('Please Wait').after('<span class="loading" style="padding-top:8px;"><img src="../wp-content/themes/cmef/images/waiting.gif" alt="" /></span>').parent('#submit-registration').addClass('disabled')

			$.post(ajaxurl, {
				action: 'new_registration',
				username: username,
				email: email,
				confirm_email: confirm_email,
				corps_region: corps_region,
				first_name: first_name,
				last_name: last_name,
				corps_year: corps_year,
				phone: phone,
				street_1: street_1,
				street_2: street_2,
				city: city,
				state: state,
				zip: zip,
			}, function(response){
				var alerts = jQuery.parseJSON(response);
				othis.alertAction(response);
				console.log(alerts);
				obutton.html(obuttonhtml).siblings('.loading').remove()
				obutton.parent('#submit-registration').removeClass('disabled');
				if(alerts.alert === 'success'){
					$('#new_program').attr('data-user-id', alerts.user_id);
				}
			});
		},
		newProgram: function(event){
			othis = this
			var program_name = $(this.program_name_el).val();
			var fundraising_goal = $(this.fundraising_goal_el).val();
			var number_students = $(this.number_students_el).val();
			var grade_level = $(this.grade_level_el).val();
			var tfa_region = $(this.tfa_region_el).val();
			var author = $('#new_program').attr('data-user-id');
			var description = $(this.program_description_el).redactor('get');
			var organization_name = $('input[name=school_name]').val();

			//Change the state of the button
			var obutton = $("#submit-new-program .button-text");
			obuttonhtml = obutton.html()
			obutton.text('Please Wait').after('<span class="loading" style="padding-top:8px;"><img src="../wp-content/themes/cmef/images/waiting.gif" alt="" /></span>').parent('#submit-new-program').addClass('disabled')

			$.post(ajaxurl, {
				action: 'new_program',
				program_name: program_name,
				fundraising_goal: fundraising_goal,
				number_students: number_students,
				grade_level: grade_level,
				tfa_region: tfa_region,
				author: author,
				description: description,
				organization_name: organization_name
			}, function(response){
				var alerts = jQuery.parseJSON(response);
				othis.alertAction(response);
				console.log(alerts.new_program_id);
				obutton.html(obuttonhtml).siblings('.loading').remove()
				obutton.parent('#submit-new-program').removeClass('disabled');
				// If everything processes correctly we should see a success message and if that is there we will some information to the DOM for the photo uploader to get.
				if(alerts.alert === 'success'){
					$('#photo_upload').attr('data-new-program-id', alerts.new_program_id)
					$('.program-complete').attr('href', alerts.new_program)
				}
			});
		},
		chooseFileUpload: function(){
			$('input[name="image"]').click();
		},
		updateImageInputBox: function(){
			var imageVal = $('input[name="image"]').val().replace("C:\\fakepath\\", "");;
			$('.image-uploader-placeholder').val(imageVal);
		},
		uploadImage: function(){
			var obutton = $(".image-uploader-button .button-text");
			
			$('.alert-messages').html('');
			if($('.image-uploader-placeholder').val() != ''){
				obuttonhtml = obutton.html()
				obutton.text('Please Wait').after('<span class="loading" style="padding-top:8px;"><img src="../../wp-content/themes/cmef/images/waiting.gif" alt="" /></span>').parent('.image-uploader-button').addClass('disabled')
				$('#photo_upload').ajaxSubmit({
					data: {
						program_id: $('#photo_upload').attr('data-new-program-id')
					},
					success: function(response){
						var image = jQuery.parseJSON(response);
						$('.image-uploader-placeholder').val('');
						var imageContainer = $('.uploaded-images');
						var newImgContainer = $('<div class="image-container"><div class="delete-image">&#x2716;</div></div>')
						var newImg = $('<img src="" class="uploaded-image" />');
						newImg.attr('src', image[0]).attr('data-image-id', image[4]);
						newImgContainer.append(newImg);
						imageContainer.append(newImgContainer);
						obutton.html(obuttonhtml).siblings('.loading').remove()
						obutton.parent('.image-uploader-button').removeClass('disabled');
					}
				})
			}else{
				$('.alert-messages').append('<p class="error">Please select an image.</p>')
			}
		},
		setFeaturedImage: function(ev){
			var imageID = $(ev.target).attr('data-image-id')
			var programID = $('#photo_upload').attr('data-new-program-id');
			$.post(ajaxurl, {
				action: 'make_featured',
				program_ID: parseInt(programID),
				image_ID: imageID
			}, function(ajaxresponse){
				$('.featured-text').remove();
				$(ev.target).parent('.image-container').append('<div class="featured-text">Cover Image</div>');
			})
		},
		deleteImage: function(ev){
			var imageID = $(ev.target).siblings('img').attr('data-image-id');
			console.log(imageID);
			$.post(ajaxurl, {
				action: 'delete_image',
				image_ID: imageID
			}, function(ajaxresponse){
				var response = $.parseJSON(ajaxresponse);
				console.log(response);
				if(response != false){
					$(ev.target).parent('.image-container').remove();
				}
			})
		},
		programRedirect: function(ev){

		}
	});
});