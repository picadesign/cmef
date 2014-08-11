jQuery(function ($) {
	StartProgramView = Backbone.View.extend({
		el: $('#new-program'),
		template: cmef_settings.mustache_template_path + 'start-a-program-tmpl.html',
		initialize: function(){
			console.log('Start a Program init');
			console.log(this.el);
			this.render();
		},
		render: function(){
			$.get(this.template, function(template) {
				var rendered = Mustache.to_html(template, {});
				console.log(this.el);
		        el.html(rendered);
		        //console.log('EventView rendered');
			})
			//var rendered = Mustache.render(this.template, {});
			
	        //return view;
		}
	});
})