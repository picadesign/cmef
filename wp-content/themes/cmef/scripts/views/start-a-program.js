jQuery(function ($) {
	StartProgramView = Backbone.View.extend({
		el: $('.white-background'),
		template: cmef_settings.mustache_template_path + 'start-a-program-tmpl.html',
		program_name_el: '#new_program input[name="program_name"]',
		fundraising_goal_el: '#new_program input[name="fundraising_goal"]',
		number_students_el: '#new_program input[name="number_students"]',
		grade_level_el: '#new_program input[name="grade_level"]',
		tfa_region_el: '#new_program input[name="tfa_region"]',
		program_description_el: '.new-program-description',
		username_el: '#new_program input[name="username"]',
		email_el: '#new_program input[name="email"]',
		confirm_email_el: '#new_program input[name="confirm_email"]',
		password_el: '#new_program input[name="pass"]',
		confirm_password_el: '#new_program input[name="confirm_pass"]',
		corps_region_el: '#new_program input[name="corp_region"]',
		first_name_el: '#new_program input[name="first_name"]',
		last_name_el: '#new_program input[name="last_name"]',
		corps_year_el: '#new_program input[name="corp_year"]',
		phone_el: '#new_program input[name="phone"]',
		street_1_el: '#new_program input[name="street_1"]',
		street_2_el: '#new_program input[name="street_2"]',
		city_el: '#new_program input[name="city"]',
		state_el: '#new_program input[name="state"]',
		zip_el: '#new_program input[name="zip"]',
		events: {
			'click #submit-new-program': 'newProgram'
		},
		initialize: function(){
			this.render();

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
				});
				othis.$el.append(rendered);
				//othis.test = $('.new-program-description');
				$(othis.program_description_el).redactor({minHeight: 200});
				
			});
		},
		newProgram: function(event){
			var program_name = $(this.program_name_el).val();
			var fundraising_goal = $(this.fundraising_goal_el).val();
			var number_students = $(this.number_students_el).val();
			var grade_level = $(this.grade_level_el).val();
			var tfa_region = $(this.tfa_region_el).val();
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
			var author = null;
			var description = $(this.program_description_el).redactor('get');
			if(cmef_settings.userLoggedIn === true){
				$.post(ajaxurl, {
					action: 'new_program',
					program_name: program_name,
					fundraising_goal: fundraising_goal,
					number_students: number_students,
					grade_level: grade_level,
					tfa_region: tfa_region,
					author: cmef_settings.userID,
					description: description
				}, function(response){
					console.log(response);
					if(response.length > 2){
						var alerts = jQuery.parseJSON(response);
						var error = '<p class="error">' + alerts[0] + '</p>';
						$('.alert-messages').html(error);
						$('body,html').animate({
							scrollTop: 0
						}, 800);
					}
				});
			}
			else{
				$.post(ajaxurl, {
					action: 'new_program',
					program_name: program_name,
					fundraising_goal: fundraising_goal,
					number_students: number_students,
					grade_level: grade_level,
					tfa_region: tfa_region,
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
					author: false,
					description: description
				}, function(response){
					console.log(response.length);
					if(response.length > 3){
						var alerts = jQuery.parseJSON(response);
						var error = '<p class="error">' + alerts[0] + '</p>';
						$('.alert-messages').html(error);
						$('body,html').animate({
							scrollTop: 0
						}, 800);
					}
				});
			}
			
		}
	});
});