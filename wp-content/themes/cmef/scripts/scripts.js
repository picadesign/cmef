(function($) {
    
    $.Loadingdotdotdot = function(el, options) {
        
        var base = this;
        
        base.$el = $(el);
                
        base.$el.data("Loadingdotdotdot", base);
        
        base.dotItUp = function($element, maxDots) {
            if ($element.text().length == maxDots) {
                $element.text("");
            } else {
                $element.append(".");
            }
        };
        
        base.stopInterval = function() {    
            clearInterval(base.theInterval);
        };
        
        base.init = function() {
        
            if ( typeof( speed ) === "undefined" || speed === null ) speed = 300;
            if ( typeof( maxDots ) === "undefined" || maxDots === null ) maxDots = 3;
            
            base.speed = speed;
            base.maxDots = maxDots;
                                    
            base.options = $.extend({},$.Loadingdotdotdot.defaultOptions, options);
                        
            base.$el.html("<span>Loading<em></em></span>");
            
            base.$dots = base.$el.find("em");
            base.$loadingText = base.$el.find("span");
            
            base.$el.css("position", "relative");
            base.$loadingText.css({
                "position": "absolute",
                "top": (base.$el.outerHeight() / 2) - (base.$loadingText.outerHeight() / 2),
                "left": (base.$el.width() / 2) - (base.$loadingText.width() / 2)
            });
                        
            base.theInterval = setInterval(base.dotItUp, base.options.speed, base.$dots, base.options.maxDots);
            
        };
        
        base.init();
    
    };
    
    $.Loadingdotdotdot.defaultOptions = {
        speed: 300,
        maxDots: 3
    };
    
    $.fn.Loadingdotdotdot = function(options) {
        
        if (typeof(options) == "string") {
            var safeGuard = $(this).data('Loadingdotdotdot');
			if (safeGuard) {
				safeGuard.stopInterval();
			}
        } else { 
            return this.each(function(){
                (new $.Loadingdotdotdot(this, options));
            });
        } 
        
    };
    
})(jQuery);


jQuery(function ($) {

	window.mustache_template_path = 'wp-content/themes/cmef/scripts/mustache-templates/';
	//Initialize Masonry
	$('.masonry').imagesLoaded( function()
	{
		$('.masonry').masonry({
			itemSelector: '.project-card',
			gutter: 30,
			columnWidth: 300
		});
	});
	$(window).ready(function(){
		$('.masonry').show();
		$('.cycle-slideshow img').show();
	});
	$('.new-program-description').redactor({ minHeight: 200 });

	/**
	 * Submit Donation Form
	 */
	$('#donation-form').submit(function(event){
		//Prevent the form from actually submitting.
		event.preventDefault();
		//Change the word of the submit button.
		$(this).find('input[type=submit]').attr('value', 'Processing').attr('disabled', 'disabled');

		//Get the form information and store it in variables.
		

		var amount;
		if($('input[name=amount]:checked').val() === 'other'){
			amount = $('input[name=otheramount]').val();
		}
		else{
			amount = $('input[name=amount]:checked').val()
		}

		var donate_to_cmef = true;
		if($('input[name=donate_to_cmef]').is(":checked")){
			donate_to_cmef = true;
			amount = amount + 5;
		}
		else{
			donate_to_cmef = false;
		}

		var pay_for_transaction = true;
		if($('input[name=pay_for_transaction').val() == 'on'){
			pay_for_transaction = true;
		}
		else{
			pay_for_transaction = false;
		}

		var remain_anonymous = false;
		if($('input[name=remain_anonymous]').is(":checked")){
			remain_anonymous = true;
		}
		else{
			remain_anonymous = false;
		}
		var card_type = $('input[name=card_type]').val();
		var card_number = $('input[name=card_number]').val();
		var three_digit = $('input[name=three_digit]').val();
		var month = $('#month').val();
		var credit_card_expiry_year = $('#credit-card-expiration-year').val();
		var first_name = $('input[name=first_name]').val();
		var last_name = $('input[name=last_name]').val();
		var street = $('input[name=street]').val();
		var city = $('input[name=city]').val();
		var zip = $('input[name=zip]').val();
		var state = $('select[name=state]').val();
		var redirect = $('input[name=thank_you_url]').val();
		var program_id = $('input[name=program_id]').val();
		console.log(redirect);



		$.post(ajaxurl, {
			action: 'process_donation',
			amount: amount,
			card_type: card_type,
			card_number: card_number,
			three_digit: three_digit,
			month: month,
			credit_card_expiry_year: credit_card_expiry_year,
			first_name: first_name,
			last_name: last_name,
			street: street,
			city: city,
			zip: zip,
			state: state,
			donate_to_cmef: donate_to_cmef,
			pay_for_transaction: pay_for_transaction,
			program_id: program_id,
			remain_anonymous: remain_anonymous
		}, function(response){
			//console.log(response);
			var authorization = JSON.parse(response);
			//console.log(authorization);
			if(authorization['approved'] === false){
				var error = '<p class="error">' + authorization['response_reason_text'] + '</p>';
				$('.alert-messages').html(error);
				$('#donation-form input[type=submit]').attr('value', 'Donate!').removeAttr('disabled');
			}else{
				window.location.href = redirect;
			}
		});
	});
	var total = parseInt(0);
	var donation_amount = parseInt(0);
	var cmef_donation = parseInt(0);
	$('input[name=amount]').change(function(){
		if($(this).val() === 'other'){
			$('input[name=otheramount][type=number]').removeAttr('disabled');
		}
		else{
			$('input[name=otheramount][type=number]').attr('disabled', 'disabled');
			donation_amount = parseInt($(this).val());
			console.log(donation_amount);
		}
		cmef_donation = parseInt(cmef_donation);
		total = Math.floor(cmef_donation + donation_amount);
		$('.donate #total').html(total + '.00');
	});

	if($('input[name=donate_to_cmef]').is(':checked')){
		cmef_donation = $('input[name=donate_to_cmef]').val();
		total = parseInt(total + cmef_donation);
		$('.donate #total').html(total + '.00');
		console.log(parseInt(cmef_donation));
	}

	$('input[name=otheramount]').change(function(){
			donation_amount = parseInt($(this).val());
			console.log(donation_amount);
			total = Math.floor(cmef_donation + donation_amount);
			$('.donate #total').html(total + '.00');
	})

	$("input[name=otheramount]").bind('click keyup mouseup', function () {
		donation_amount = parseInt($(this).val());
			total = Math.floor(cmef_donation + donation_amount);
			$('.donate #total').html(total + '.00');
	});

	$('input[name=donate_to_cmef]').change(function(){
		if(!$(this).is(':checked')){
			cmef_donation = $(this).val();
			total = parseInt(total - cmef_donation);
			$('.donate #total').html(total + '.00');
		}
		else{
			cmef_donation = $(this).val();
			total = parseInt(total + cmef_donation);
			$('.donate #total').html(total + '.00');	
		}
	});












	//Load More Programs and add to the masonry
	$('.bottom-buttons .show-more').on('click', function(){
    	var offset = $('.projects').children().length;
    	console.log(offset);

    	$.post(ajaxurl, {
			//the function in ajax.php, pass the data through.
			action: 'fetch_programs',
			offset: offset,
		}, function(response){
			//remove the editor.
			//location.reload();
			var new_projects = JSON.parse(response);
			console.log(new_projects);
		

			$.get(mustache_template_path + 'project-card.html', function(template) {
				for (var key in new_projects) {
				   var program = new_projects[key];
				   console.log(program);
					var rendered = Mustache.render(template, {
						title: program['post_title'],
						author: program['author'],
						post_content: program['post_content'].substring(0,175),
						the_thumbnail: program['post_thumbnail'],
						the_permalink: program['guid'],
						percentage_raised: program['percentage_raised'],
						amount_raised: program['amount_raised'],
						fundraiser_goal: program['fundraiser_goal'],
						twitter_url: program['twitter_url'],
						linkedin_url: program['linkedin_url'],
						facebook_url: program['facebook_url'],
						google_url: program['google_url'],
						donation_url: program['donation_url']

					});
					$('.projects').append(rendered);
				}
				$('.gallery-masonry').imagesLoaded( function(){
					$('.masonry').masonry('reloadItems');
		    		$('.projects').masonry();
		    	})
	    		
			});
			//alert(response);
		})
    })








	/**
	 * Scroll to top
	 * @return {bool} Function to Scroll to the top of the page.
	 */
	$('.bottom-buttons .back-to-top').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});









	/**
	 * Style the first word of the menu item
	 * @return {null} Styles the first word.
	 */
	$('#menu-main-navigation-header li a').each(function() {
		var h = $(this).html();
		var index = h.indexOf(' ');
		if(index == -1) {
			index = h.length;
		}
		$(this).html('<span class="menu-first-word">' + h.substring(0, index) + '</span><br />' + h.substring(index, h.length));
		//$('.menu-main-navigation-header-container').toggle();
	});

	// This is for the menu item conditions
	$( 'body' ).on( 'change', '.menu-item-if-menu-enable', function() {
		$( this ).closest( '.if-menu-enable' ).next().toggle( $( this ).prop( 'checked' ) );
	} );

	//We Hid the menu so that we could change the style a bit and now we are showing it
	//The reason is because you get a flash of unstyled text which is ugly.
	$('.menu-main-navigation-header-container').toggle();

	//This is to show the login menu
	//Close the div if anywhere else is click on the screen
	$(document).on('click', function(e) {
		if ( $(e.target).closest('.full-width.header.bottom #bottom-header .bottom-header-left .sign-up').length ) {
			$('.full-width.header.bottom #bottom-header .bottom-header-left .sign-up').css('background-color', '#e8e8e8');
			$('.full-width.header.bottom #bottom-header .bottom-header-left .login-box').show();

		}else if ( ! $(e.target).closest('.full-width.header.bottom #bottom-header .bottom-header-left .login-box').length ) {
			$('.full-width.header.bottom #bottom-header .bottom-header-left .sign-up').css('background-color', '');
			$('.full-width.header.bottom #bottom-header .bottom-header-left .login-box').hide();
		}
	});

	requirejs.config({
		//By default load any module IDs from js/lib
		baseUrl: cmef_settings.templateURL + '/scripts/',
		//except, if the module ID starts with "app",
		//load it from the js/app directory. paths
		//config is relative to the baseUrl, and
		//never includes a ".js" extension since
		//the paths config could be for a directory.
		paths: {
			//app: '../app'
		},
		urlArgs: "v=" +  (new Date()).getTime()
	});

	require(['models/models'], function(models) {
		require(['collections/collections'], function(collections){
			require(['views/home', 'views/start-a-program', 'views/our-programs', 'views/single-program', 'views/resources-view'], function(){
				var ApplicationRouter = Backbone.Router.extend({
					routes: {
						"start-a-program/": "NewProgram",
						"our-programs/": "OurPrograms",
						"program/:program_name/": "SingleProgram",
						'resource/': 'Resources'
						//"*actions": "home"
					},
					initialize: function() {
						//this.headerView = new HeaderView();
						//this.headerView.render();
						//this.footerView = new FooterView();
						//this.footerView.render();
					},
					NewProgram: function() {
						this.newProgramView = new StartProgramView();
						//this.homeView.render();
					},
					OurPrograms: function(){
						this.ourProgramsView = new OurProgramsView();
					},
					SingleProgram: function(){
						this.singleProgramView = new SingleProgramView();
					},
					Resources: function(){
						this.resourcesView = new ResourcesView();
					}
				});

				app = new ApplicationRouter();
				Backbone.history.start({pushState: true, root: "/cmef/"});
			});
		});
		
	});

});