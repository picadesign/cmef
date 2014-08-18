jQuery(function ($) {
	SingleProgramView = Backbone.View.extend({
		el: $('.white-background'),
		template: cmef_settings.mustache_template_path + 'single-program-tmpl.html',
		events: {
			'click .edit-program': 'editProgram',
		},
		initialize: function(){
			this.$el.html(this.$el.html());
		},
		editProgram: function(){
			//console.log(this);
			othis = this;
			$('.program-type').html('<select><option value="volvo">Volvo</option><option value="saab">Saab</option><option value="mercedes">Mercedes</option><option value="audi">Audi</option></select>')
			$('.description').redactor();
		}
	});
});