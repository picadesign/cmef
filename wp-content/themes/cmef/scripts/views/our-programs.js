jQuery(function ($) {
	OurProgramsView = Backbone.View.extend({
		el: $('.white-background'),
		template: cmef_settings.mustache_template_path + 'our-programs-tmpl.html',
		initialize: function(){
			this.$el.html(this.$el.html());
		}
	});
});