jQuery(function ($) {
	SingleProgramView = Backbone.View.extend({
		el: $('.white-background'),
		events: {
			'click .button.edit-program': 'editProgram',
			'click .button.save-program': 'saveProgram',
			'click .button.image-uploader-choose-file': 'chooseFileUpload',
			'change .image-uploader': 'updateImageInputBox',
			'click .button.image-uploader-button': 'uploadImage',
			'click .uploaded-image': 'setFeaturedImage',
			'click .image-container .delete-image': 'deleteImage',
			'click .button.add-expense': 'addExpense',
			'click .button.choose-expense-image': 'chooseExpenseImage',
			'change input[name="expense-image"]': 'updateExpenseImageText',
			'click .button.submit-expense': 'submitExpense',
			'click .delete-expense': 'deleteExpense',
			'click .print': 'printParentElement',
			'click .closediv': 'closeDiv'
		},
		initialize: function(){
			this.$el.html(this.$el.html());
			$('.slideshow').cycle({
				autoHeight: 1,
				pagerTemplate: "<a href='#' id='pager-image'><img src='{{href}}' width=20 height=20></a>",
				fx: 'scrollHorz',
				speed: 500,
				pager: '#adv-custom-pager',
				slides: '> a'
			});
			$('.slideshow').removeClass('hidden')
			$( "#tabs" ).tabs({active: 1});
			$('#tabs').removeClass('hidden')
			$.tablesorter.addParser({ 
			    // set a unique id 
			    id: 'thousands',
			    is: function(s) { 
			        // return false so this parser is not auto detected 
			        return false; 
			    }, 
			    format: function(s) {
			        // format your data for normalization 
			        return s.replace('$','').replace(/,/g,'');
			    }, 
			    // set type, either numeric or text 
			    type: 'numeric' 
			}); 
			$("#donation-table").tablesorter({
				headers: {
		            2: {//zero-based column index
		                sorter:'thousands'
		            }
		        }
		    });
		    $("#expense-table").tablesorter({
				headers: {
					0: {
						sorter: false
					},
		            3: {//zero-based column index
		                sorter:'thousands'
		            }
		        }
		    }); 

		    $('.memo').redactor();

		    $('.goal-sel input').maskMoney({
		    	prefix:'$',
				precision:0
		    })

		    $('input[name=expense-amount').maskMoney({
		    	prefix:'$',
		    	precision:0
		    })
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
			$('.organization-name').hide();
			$('.organization-name-sel').removeClass('hidden');
			$('.number-students').hide();
			$('.number-students-sel').removeClass('hidden');
			$('.goal-sel-row').removeClass('hidden');
			$('.photo-uploader-container').removeClass('hidden')
			$('.description').redactor();
			$('.title').redactor();
			$('.button.edit-program').html('<span>Save</span>').addClass("save-program").removeClass('edit-program');
		},
		saveProgram: function(){
			//alert('Save');
			//Get the values from the form items
			var program_type = $('.select #program-type option:selected').attr('data-term-id');		//The input for the program type box
			var tfa_region = $('.select #tfa-region option:selected').attr('data-term-id')			//The input for the tfa region box
			var organization_name = $('.organization-name-sel input').val()							//The value for the org name
			var grade_level = $('.select #grade-level option:selected').attr('data-term-id')		//The input for grade level box
			var number_students = $('.number-students-sel input').val()								//The vale
			var description = $('.description').redactor('get');
			var program_id = $('input[name="post_id"]').val();
			var goal = $('.goal-sel input').val();

			var regex = new RegExp(',', 'g');					//regex to replace all instance variables (found at 'http://stackoverflow.com/questions/6064956/replace-all-occurrences-in-a-string')
				goal = goal.replace(regex, '');
				goal = goal.replace('$', '');

			//Send the information to ajax
			$.post(ajaxurl, {
				action: 'update_program',
				program_type: program_type,
				tfa_region: tfa_region,
				organization_name: organization_name,
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
				$('.organization-name').html($('.organization-name-sel input').val()).show();
				$('.organization-name-sel').addClass('hidden');
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
		},
		addExpense: function(){
			$('.new-expense').removeClass('hidden');
			$('.button.add-expense').hide();
		},
		chooseExpenseImage: function(){
			console.log('choose image');
			$('input[name="expense-image"]').click();
		},
		updateExpenseImageText: function(){
			var imageVal = $('input[name="expense-image"]').val().replace("C:\\fakepath\\", "");;
			$('input[name="expense-image-name"]').val(imageVal);	
		},
		submitExpense: function(){
			var regex = new RegExp(',', 'g');					//regex to replace all instance variables (found at 'http://stackoverflow.com/questions/6064956/replace-all-occurrences-in-a-string')
			
			var amount = $('input[name="expense-amount"]').val(); 	//the value of the input on the page
				amount = amount.replace(regex, ''); //remove the commas (need regex to remove all and not just the first one)
				amount = amount.replace('$', ''); //remove the leading $
				console.log(amount);

			$('#expense_photo_upload').ajaxSubmit({
				data: {
					amount: amount,
					program_id: $('#expense_photo_upload').attr('data-program-id'),
					memo: $('.memo').redactor('get')
				},
				success: function(response){
					//var image = jQuery.parseJSON(response);
					//$('.image-uploader-placeholder').val('');
					//var imageContainer = $('.uploaded-images');
					//var newImgContainer = $('<div class="image-container"><div class="delete-image">&#x2716;</div></div>')
					//var newImg = $('<img src="" class="uploaded-image" />');
					//newImg.attr('src', image[0]).attr('data-image-id', image[4]);
					//newImgContainer.append(newImg);
					//imageContainer.append(newImgContainer);
					//obutton.html(obuttonhtml).siblings('.loading').remove()
					//obutton.parent('.image-uploader-button').removeClass('disabled');
					if(response != 'success'){
						var error = '<p class="error">' + response + '</p>';
						$('.new-expense .alert-messages').html(error);
					}
					else if(response == 'success'){
						$('.new-expense').addClass('hidden');
						$('.button.add-expense').show();
						location.reload();
					}
				}
			})
		},
		deleteExpense: function(){
			console.log("delete")
			var expense_id = $('.delete-expense').attr('data-expense-id');
		},
		printParentElement: function(){
			$('.print').parent().printElement();
		},
		closeDiv: function(){
			$('.closediv').parent().addClass('hidden');
			$('.add-expense').show();
		}
	});
});