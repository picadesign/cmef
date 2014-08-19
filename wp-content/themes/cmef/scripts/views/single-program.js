jQuery(function ($) {
	SingleProgramView = Backbone.View.extend({
		el: $('.white-background'),
		template: cmef_settings.mustache_template_path + 'single-program-tmpl.html',
		events: {
			'click .button.edit-program': 'editProgram',
			'click .button.save-program': 'saveProgram',
			'click .button.image-uploader-choose-file': 'chooseFileUpload',
			'change .image-uploader': 'updateImageInputBox',
			'click .button.image-uploader-button': 'uploadImage',
			'click .uploaded-image': 'setFeaturedImage',
			'click .image-container .delete-image': 'deleteImage'
		},
		initialize: function(){
			this.$el.html(this.$el.html());
			$('.slideshow').cycle({
				autoHeight: 1,
				pagerTemplate: "<a href='#' id='pager-image'><img src='{{src}}' width=20 height=20></a>",
				fx: 'scrollHorz',
				speed: 500,
				pager: '#adv-custom-pager',
			});
		},
		editProgram: function(){
			//console.log(this);
			othis = this;
			//Show the dropdown select options
			$('.tfa-region').hide();
			$('.tfa-region-sel').removeClass('hidden');
			$('.program-type').hide();
			$('.program-type-sel').removeClass('hidden');
			$('.grade-level').hide();
			$('.grade-level-sel').removeClass('hidden');
			$('.school-name').hide();
			$('.school-name-sel').removeClass('hidden');
			$('.number-students').hide();
			$('.number-students-sel').removeClass('hidden');
			$('.goal-sel-row').removeClass('hidden');
			$('.photo-uploader-container').removeClass('hidden')
			$('.description').redactor();
			$('.button.edit-program').html('<span>Save</span>').addClass("save-program").removeClass('edit-program');
		},
		saveProgram: function(){
			//alert('Save');
			//Get the values from the form items
			var program_type = $('.select #program-type option:selected').attr('data-term-id')
			var tfa_region = $('.select #tfa-region option:selected').attr('data-term-id')
			var school_name = $('.school-name-sel input').val()
			var grade_level = $('.select #grade-level option:selected').attr('data-term-id')
			var number_students = $('.number-students-sel input').val()
			var description = $('.description').redactor('get');
			var program_id = $('input[name="post_id"]').val();
			var goal = $('.goal-sel input').val();

			//Send the information to ajax
			$.post(ajaxurl, {
				action: 'update_program',
				program_type: program_type,
				tfa_region: tfa_region,
				school_name: school_name,
				grade_level: grade_level,
				number_students: number_students,
				description: description,
				program_id: program_id,
				goal: goal
			}, function(response){
				console.log(response);
				$('.tfa-region').html($('.select #tfa-region option:selected').val()).show();
				$('.tfa-region-sel').addClass('hidden');
				$('.program-type').html($('.select #program-type option:selected').val()).show();
				$('.program-type-sel').addClass('hidden');
				$('.grade-level').html($('.select #grade-level option:selected').val()).show();
				$('.grade-level-sel').addClass('hidden');
				$('.school-name').html($('.school-name-sel input').val()).show();
				$('.school-name-sel').addClass('hidden');
				$('.number-students').html($('.number-students-sel input').val()).show();
				$('.number-students-sel').addClass('hidden');
				$('.goal-sel-row').addClass('hidden');
				$('.photo-uploader-container').addClass('hidden')
				$('.description').redactor('destroy');
				$('.button.save-program').html('<span>Edit</span>').addClass("edit-program").removeClass('save-program');
			})
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
						program_id: $('#photo_upload').attr('data-program-id')
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
			var programID = $('#photo_upload').attr('data-program-id');
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
		}
	});
});