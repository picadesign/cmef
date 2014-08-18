jQuery(function ($) {
	OurProgramsView = Backbone.View.extend({
		el: $('.form'),
		template: cmef_settings.mustache_template_path + 'our-programs-tmpl.html',
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
					ajaxurl: ajaxurl
				});
				othis.$el.append(rendered);
			});
		},
	});
});