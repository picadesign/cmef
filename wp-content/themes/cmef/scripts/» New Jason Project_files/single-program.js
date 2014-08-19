jQuery(function ($) {
	SingleProgramView = Backbone.View.extend({
		el: $('.white-background'),
		template: cmef_settings.mustache_template_path + 'single-program-tmpl.html',
		events: {
			'click .button.edit-program': 'editProgram',
			'click .button.save-program': 'saveProgram'
		},
		initialize: function(){
			this.$el.html(this.$el.html());
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

			//Send the information to ajax
			$.post(ajaxurl, {
				action: 'update_program',
				program_type: program_type,
				tfa_region: tfa_region,
				school_name: school_name,
				grade_level: grade_level,
				number_students: number_students,
				description: description,
				program_id: program_id
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
				$('.description').redactor('destroy');
				$('.button.save-program').html('<span>Edit</span>').addClass("edit-program").removeClass('save-program');
			})
		}
	});
});