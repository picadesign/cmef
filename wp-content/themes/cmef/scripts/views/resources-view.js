jQuery(function($){
	ResourcesView = Backbone.View.extend({
		el: $('.white-background'),
		events: {
			'hover .star': 'hoverStars',
			'click .star': 'rateResource'
		},
		initialize: function(){
			this.$el.html(this.$el.html())
		},
		hoverStars: function(event){
			if($(event.target).hasClass('two')){
				$(event.target).hover(function(){
					$(event.target).prev().addClass('hovered');
				}, function(){
					$(event.target).prev().removeClass('hovered');
				})
			}
			else if($(event.target).hasClass('three')){
				$(event.target).hover(function(){
					$(event.target).prev().addClass('hovered');
					$(event.target).prev().prev().addClass('hovered');
				}, function(){
					$(event.target).prev().removeClass('hovered');
					$(event.target).prev().prev().removeClass('hovered');
				})
			}
			else if($(event.target).hasClass('four')){
				$(event.target).hover(function(){
					$(event.target).prev().addClass('hovered');
					$(event.target).prev().prev().addClass('hovered');
					$(event.target).prev().prev().prev().addClass('hovered');
				}, function(){
					$(event.target).prev().removeClass('hovered');
					$(event.target).prev().prev().removeClass('hovered');
					$(event.target).prev().prev().prev().removeClass('hovered');
				})
			}
			else if($(event.target).hasClass('five')){
				$(event.target).hover(function(){
					$(event.target).prev().addClass('hovered');
					$(event.target).prev().prev().addClass('hovered');
					$(event.target).prev().prev().prev().addClass('hovered');
					$(event.target).prev().prev().prev().prev().addClass('hovered');
				}, function(){
					$(event.target).prev().removeClass('hovered');
					$(event.target).prev().prev().removeClass('hovered');
					$(event.target).prev().prev().prev().removeClass('hovered');
					$(event.target).prev().prev().prev().prev().removeClass('hovered');
				})
			}
		},
		addRating: function(rating, resource_id){
			console.log(rating);
			console.log(resource_id);
			$.post(ajaxurl, {
				action: 'add_rating',
				rating: rating,
				resource_id: resource_id
			}, function(response){
				console.log(response);
			})
		},
		rateResource: function(){
			var resource_id = $(event.target).parent().attr('data-resource-id');
			if($(event.target).hasClass('one')){
				console.log(this);
				this.addRating(1, resource_id);
			}
			else if($(event.target).hasClass('two')){
				this.addRating(2, resource_id);
			}
			else if($(event.target).hasClass('three')){
				this.addRating(3, resource_id);
			}
			else if($(event.target).hasClass('four')){
				this.addRating(4, resource_id);
			}
			else if($(event.target).hasClass('five')){
				this.addRating(5, resource_id);
			}
		}
	})
})