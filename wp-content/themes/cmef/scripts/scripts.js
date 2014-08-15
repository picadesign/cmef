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
	$( window ).load( function()
	{
		$('.masonry').masonry({
			itemSelector: '.project-card',
			gutter: 30,
			columnWidth: 300
		});
	});
	$(window).ready(function(){
		$('.masonry').show();
		//$('.cycle-slideshow img').show();
	});

	$('.new-program-description').redactor({ minHeight: 200 });



	/**
	 * Front-end editing Program
	 */
	$('.single-program .edit-program').click(function(){
		console.log('Edit Program');
		$('.single-program .description').redactor();
		var program_type = [
			{val: 'Field Trip', text: 'Field Trip'},
			{val: 'Scholarship', text: 'Scholarship Fund'},
			{val: 'Technology', text: 'Technology'},
			{val: 'Other', text: 'Other'}
		];

		var tfa_region = [
			{val: "All Regions", text: "All Regions"},
			{val: "Alabama", text: "Alabama"},
			{val: "Appalachia", text: "Appalachia"},
			{val: "Arkansas", text: "Arkansas"},
			{val: "Baltimore", text: "Baltimore"},
			{val: "Bay Area", text: "Bay Area"},
			{val: "Charlotte", text: "Charlotte"},
			{val: "Chicago", text: "Chicago"},
			{val: "Colorado", text: "Colorado"},
			{val: "Connecticut", text: "Connecticut"},
			{val: "D.C. Region", text: "D.C. Region"},
			{val: "Dallas-Fort Worth", text: "Dallas-Fort Worth"},
			{val: "Delaware", text: "Delaware"},
			{val: "Detroit", text: "Detroit"},
			{val: "Eastern North Carolina", text: "Eastern North Carolina"},
			{val: "Greater Nashville", text: "Greater Nashville"},
			{val: "Greater New Orleans-Louisiana Delta", text: "Greater New Orleans-Louisiana Delta"},
			{val: "Greater Philadelphia", text: "Greater Philadelphia"},
			{val: "Hawai'i", text: "Hawai'i"},
			{val: "Houston", text: "Houston"},
			{val: "Indianapolis", text: "Indianapolis"},
			{val: "Jacksonville", text: "Jacksonville"},
			{val: "Kansas City", text: "Kansas City"},
			{val: "Las Vegas Valley", text: "Las Vegas Valley"},
			{val: "Los Angeles", text: "Los Angeles"},
			{val: "Massachusetts", text: "Massachusetts"},
			{val: "Memphis", text: "Memphis"},
			{val: "Metro Atlanta", text: "Metro Atlanta"},
			{val: "Miami-Dade", text: "Miami-Dade"},
			{val: "Milwaukee", text: "Milwaukee"},
			{val: "Mississippi", text: "Mississippi"},
			{val: "New Jersey", text: "New Jersey"},
			{val: "New Mexico", text: "New Mexico"},
			{val: "New York", text: "New York"},
			{val: "Northeast Ohio-Cleveland", text: "Northeast Ohio-Cleveland"},
			{val: "Oklahoma", text: "Oklahoma"},
			{val: "Phoenix", text: "Phoenix"},
			{val: "Rhode Island", text: "Rhode Island"},
			{val: "Rio Grande Valley", text: "Rio Grande Valley"},
			{val: "Sacramento", text: "Sacramento"},
			{val: "San Antonio", text: "San Antonio"},
			{val: "San Diego", text: "San Diego"},
			{val: "South Carolina", text: "South Carolina"},
			{val: "South Dakota", text: "South Dakota"},
			{val: "South Louisiana", text: "South Louisiana"},
			{val: "Southwest Ohio", text: "Southwest Ohio"},
			{val: "St. Louis", text: "St. Louis"},
			{val: "Twin Cities", text: "Twin Cities"},
			{val: "Washington", text: "Washington"},
		];

		var program_type_el = $('.program-type');
		program_type_el.html('<select></select>');
		var program_sel_el = $(program_type_el).find('select').attr('name', 'program-type')

		var tfa_region_el = $('.tfa-region');
		tfa_region_el.html('<select></select>');
		var tfa_region_sel_el = $(tfa_region_el).find('select').attr('name', 'tfa-region')
		//$('<option>').appendTo(program_sel_el).attr('value', 'Field Trip').text('Field Trip');
		for(index in program_type){
			var opt = document.createElement("option");
			opt.value = program_type[index].val;
			opt.innerHTML = program_type[index].text;

			program_sel_el.append(opt);
		}
		for(index in tfa_region){
			var opt = document.createElement("option");
			//console.log(tfa_region[index]);
			opt.value = tfa_region[index].val;
			opt.innerHTML = tfa_region[index].text;

			tfa_region_sel_el.append(opt);
		}
	})




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
				$('.masonry').masonry('reloadItems');
    		$('.projects').masonry();
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

	require(['views/views', 'models/models', 'collections/collections'], function(home, models, collection) {

		var ApplicationRouter = Backbone.Router.extend({
			routes: {
				"home/start-a-program/": "NewProgram",
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
			}
		});

		app = new ApplicationRouter();
		Backbone.history.start({pushState: true, root: "/cmef/"});
	});

});