jQuery(function ($) {
	OurProgramsView = Backbone.View.extend({
		el: $('.white-background'),
		template: cmef_settings.mustache_template_path + 'our-programs-tmpl.html',
		initialize: function(){
			this.$el.html(this.$el.html());
			if(document.URL.indexOf('date') > 0){
				if(document.URL.indexOf('order=ASC') > 0){
					$('.button.filter.date').addClass('headerSortUp');
					// alert(href);
				}
				else{
					$('.button.filter.date').addClass('headerSortDown');
				}
			}
			else if(document.URL.indexOf('_tfa-region') > 0){
				if(document.URL.indexOf('order=ASC') > 0){
					$('.button.filter.regions').addClass('headerSortUp');
					// alert(href);
				}
				else{
					$('.button.filter.regions').addClass('headerSortDown');
				}
			}
			else if(document.URL.indexOf('orderby=title') > 0){
				if(document.URL.indexOf('order=ASC') > 0){
					$('.button.filter.name').addClass('headerSortUp');
					// alert(href);
				}
				else{
					$('.button.filter.name').addClass('headerSortDown');
				}
			}
			else if(document.URL.indexOf('_fundraising-goal') > 0){
				if(document.URL.indexOf('order=ASC') > 0){
					$('.button.filter.goal').addClass('headerSortUp');
					// alert(href);
				}
				else{
					$('.button.filter.goal').addClass('headerSortDown');
				}
			}
		}
	});
});