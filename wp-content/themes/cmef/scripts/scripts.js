/*
 *  jquery-maskmoney - v3.0.2
 *  jQuery plugin to mask data entry in the input text in the form of money (currency)
 *  https://github.com/plentz/jquery-maskmoney
 *
 *  Made by Diego Plentz
 *  Under MIT License (https://raw.github.com/plentz/jquery-maskmoney/master/LICENSE)
 */
!function($){"use strict";$.browser||($.browser={},$.browser.mozilla=/mozilla/.test(navigator.userAgent.toLowerCase())&&!/webkit/.test(navigator.userAgent.toLowerCase()),$.browser.webkit=/webkit/.test(navigator.userAgent.toLowerCase()),$.browser.opera=/opera/.test(navigator.userAgent.toLowerCase()),$.browser.msie=/msie/.test(navigator.userAgent.toLowerCase()));var a={destroy:function(){return $(this).unbind(".maskMoney"),$.browser.msie&&(this.onpaste=null),this},mask:function(a){return this.each(function(){var b,c=$(this);return"number"==typeof a&&(c.trigger("mask"),b=$(c.val().split(/\D/)).last()[0].length,a=a.toFixed(b),c.val(a)),c.trigger("mask")})},unmasked:function(){return this.map(function(){var a,b=$(this).val()||"0",c=-1!==b.indexOf("-");return $(b.split(/\D/).reverse()).each(function(b,c){return c?(a=c,!1):void 0}),b=b.replace(/\D/g,""),b=b.replace(new RegExp(a+"$"),"."+a),c&&(b="-"+b),parseFloat(b)})},init:function(a){return a=$.extend({prefix:"",suffix:"",affixesStay:!0,thousands:",",decimal:".",precision:2,allowZero:!1,allowNegative:!1},a),this.each(function(){function b(){var a,b,c,d,e,f=s.get(0),g=0,h=0;return"number"==typeof f.selectionStart&&"number"==typeof f.selectionEnd?(g=f.selectionStart,h=f.selectionEnd):(b=document.selection.createRange(),b&&b.parentElement()===f&&(d=f.value.length,a=f.value.replace(/\r\n/g,"\n"),c=f.createTextRange(),c.moveToBookmark(b.getBookmark()),e=f.createTextRange(),e.collapse(!1),c.compareEndPoints("StartToEnd",e)>-1?g=h=d:(g=-c.moveStart("character",-d),g+=a.slice(0,g).split("\n").length-1,c.compareEndPoints("EndToEnd",e)>-1?h=d:(h=-c.moveEnd("character",-d),h+=a.slice(0,h).split("\n").length-1)))),{start:g,end:h}}function c(){var a=!(s.val().length>=s.attr("maxlength")&&s.attr("maxlength")>=0),c=b(),d=c.start,e=c.end,f=c.start!==c.end&&s.val().substring(d,e).match(/\d/)?!0:!1,g="0"===s.val().substring(0,1);return a||f||g}function d(a){s.each(function(b,c){if(c.setSelectionRange)c.focus(),c.setSelectionRange(a,a);else if(c.createTextRange){var d=c.createTextRange();d.collapse(!0),d.moveEnd("character",a),d.moveStart("character",a),d.select()}})}function e(b){var c="";return b.indexOf("-")>-1&&(b=b.replace("-",""),c="-"),c+a.prefix+b+a.suffix}function f(b){var c,d,f,g=b.indexOf("-")>-1&&a.allowNegative?"-":"",h=b.replace(/[^0-9]/g,""),i=h.slice(0,h.length-a.precision);return i=i.replace(/^0*/g,""),i=i.replace(/\B(?=(\d{3})+(?!\d))/g,a.thousands),""===i&&(i="0"),c=g+i,a.precision>0&&(d=h.slice(h.length-a.precision),f=new Array(a.precision+1-d.length).join(0),c+=a.decimal+f+d),e(c)}function g(a){var b,c=s.val().length;s.val(f(s.val())),b=s.val().length,a-=c-b,d(a)}function h(){var a=s.val();s.val(f(a))}function i(){var b=s.val();return a.allowNegative?""!==b&&"-"===b.charAt(0)?b.replace("-",""):"-"+b:b}function j(a){a.preventDefault?a.preventDefault():a.returnValue=!1}function k(a){a=a||window.event;var d,e,f,h,k,l=a.which||a.charCode||a.keyCode;return void 0===l?!1:48>l||l>57?45===l?(s.val(i()),!1):43===l?(s.val(s.val().replace("-","")),!1):13===l||9===l?!0:!$.browser.mozilla||37!==l&&39!==l||0!==a.charCode?(j(a),!0):!0:c()?(j(a),d=String.fromCharCode(l),e=b(),f=e.start,h=e.end,k=s.val(),s.val(k.substring(0,f)+d+k.substring(h,k.length)),g(f+1),!1):!1}function l(c){c=c||window.event;var d,e,f,h,i,k=c.which||c.charCode||c.keyCode;return void 0===k?!1:(d=b(),e=d.start,f=d.end,8===k||46===k||63272===k?(j(c),h=s.val(),e===f&&(8===k?""===a.suffix?e-=1:(i=h.split("").reverse().join("").search(/\d/),e=h.length-i-1,f=e+1):f+=1),s.val(h.substring(0,e)+h.substring(f,h.length)),g(e),!1):9===k?!0:!0)}function m(){r=s.val(),h();var a,b=s.get(0);b.createTextRange&&(a=b.createTextRange(),a.collapse(!1),a.select())}function n(){setTimeout(function(){h()},0)}function o(){var b=parseFloat("0")/Math.pow(10,a.precision);return b.toFixed(a.precision).replace(new RegExp("\\.","g"),a.decimal)}function p(b){if($.browser.msie&&k(b),""===s.val()||s.val()===e(o()))a.allowZero?a.affixesStay?s.val(e(o())):s.val(o()):s.val("");else if(!a.affixesStay){var c=s.val().replace(a.prefix,"").replace(a.suffix,"");s.val(c)}s.val()!==r&&s.change()}function q(){var a,b=s.get(0);b.setSelectionRange?(a=s.val().length,b.setSelectionRange(a,a)):s.val(s.val())}var r,s=$(this);a=$.extend(a,s.data()),s.unbind(".maskMoney"),s.bind("keypress.maskMoney",k),s.bind("keydown.maskMoney",l),s.bind("blur.maskMoney",p),s.bind("focus.maskMoney",m),s.bind("click.maskMoney",q),s.bind("cut.maskMoney",n),s.bind("paste.maskMoney",n),s.bind("mask.maskMoney",h)})}};$.fn.maskMoney=function(b){return a[b]?a[b].apply(this,Array.prototype.slice.call(arguments,1)):"object"!=typeof b&&b?($.error("Method "+b+" does not exist on jQuery.maskMoney"),void 0):a.init.apply(this,arguments)}}(window.jQuery||window.Zepto);

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


	$('input[name=otheramount]').maskMoney({
		prefix:'$',
		precision:0
	});



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
			var regex = new RegExp(',', 'g');					//regex to replace all instance variables (found at 'http://stackoverflow.com/questions/6064956/replace-all-occurrences-in-a-string')
			amount = amount.replace(regex, '');
			amount = amount.replace('$', '');
			amount = parseInt(amount);
		}
		else{
			amount = $('input[name=amount]:checked').val()
		}

		var donate_to_cmef = true;
		if($('input[name=donate_to_cmef]').is(":checked")){
			donate_to_cmef = true;
		}
		else{
			donate_to_cmef = false;
		}

		var pay_for_transaction = true;
		if($('input[name=pay_for_transaction').is(':checked')){
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
		var email = $('input[name=email]').val()
		console.log(redirect);


		var secure_ajaxurl = ajaxurl.replace("http", "https");
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
			remain_anonymous: remain_anonymous,
			email: email
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

	//Below is used to updated the total donation text. DOES NOT CONTROL THE ACTUAL AUTHORIZED AMOUNT. THAT IS CONTROLLED ABOVE
	$('input[name=amount]').change(function(){
		if($(this).val() == 'other'){
    		$('input[name=otheramount]').prop('disabled', false);
			amount = 0;
		}
		else{
			$('input[name=otheramount]').prop('disabled', true);
			amount = parseInt($(this).val())
		}
		if($('input[name=pay_for_transaction]').is(':checked')){
			amount += .10;
		}
		if($('input[name=donate_to_cmef]').is(':checked')){
			amount += 5;
		}
		$('#donation-form #total').html(amount.toFixed(2))
		console.log(amount)
	})

	$('input[name=otheramount]').bind('change keydown keyup',function(){
		var regex = new RegExp(',', 'g');					//regex to replace all instance variables (found at 'http://stackoverflow.com/questions/6064956/replace-all-occurrences-in-a-string')
		amount = $(this).val();
		amount = amount.replace(regex, '');
		amount = amount.replace('$', '');
		amount = parseFloat(amount)
		if($('input[name=pay_for_transaction]').is(':checked')){
			amount += .10;
		}
		if($('input[name=donate_to_cmef]').is(':checked')){
			amount += 5;
		}
		$('#donation-form #total').html(amount.toFixed(2))
		console.log(amount)
	})

	$('input[name=pay_for_transaction]').change(function(){
		amount = $('#donation-form #total').html();
		amount = parseFloat(amount);

		if($('input[name=pay_for_transaction]').is(':checked')){
			amount += .10;
		}
		else{
			amount -= .10;
		}
		$('#donation-form #total').html(amount.toFixed(2))
		console.log(amount)
	})

	$('input[name=donate_to_cmef]').change(function(){
		amount = $('#donation-form #total').html();
		amount = parseFloat(amount);

		if($('input[name=donate_to_cmef]').is(':checked')){
			amount += 5;
		}
		else{
			amount -= 5;
		}
		$('#donation-form #total').html(amount.toFixed(2))
		console.log(amount)
	})

	//REUSABLE CODE
	function checkCardType(number){
		var cardTypes = {
			discover: [
				[6011],
				[622126, 622925],
				[644, 649],
				[65]
			],
			visa: [
				[4]
			],
			amex: [
				[34],
				[37]
			],
			mastercard: [
				[50, 55]
			]
		}
		for(var i in cardTypes){
			//console.log(cardTypes[i]);
			for(var index in cardTypes[i]){   //get the ranges in the algorithm
				//console.log(cardTypes[i][index]);
				if(cardTypes[i][index].length == 1 && number.indexOf(cardTypes[i][index][0]) == 0){ //if the length is only 1 then there is only 1 possible prefix for the card
					return i;
				}
				else if(cardTypes[i].length == 2){ //if the lenght is 2 then their is a range that the cards can be in.
					return i;
				}
			}
		}
		//console.log(cardTypes.length);
	}

	$('input[name=card_number]').bind("keyup change", function(){

		var input = $(this).val();		// value of the card_number input
		var cardType = checkCardType(input);

		// remove the dark calss and update the card to the right one, change the card to dark
		$('.card').removeClass('dark');
		$('.' + cardType).addClass('dark');
		console.log(cardType);
	})












	//Load More Programs and add to the masonry
	$('.bottom-buttons .show-more').on('click', function(){
    	$.post(ajaxurl, {
			//the function in ajax.php, pass the data through.
			action: 'fetch_programs',
			offset: $('.projects').children().length,
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
			require(['views/home', 'views/start-a-program', 'views/our-programs', 'views/single-program', 'views/resources-view', 'views/profile', 'views/lost-password'], function(){
				var ApplicationRouter = Backbone.Router.extend({
					routes: {
						"start-a-program/": "NewProgram",
						"our-programs/": "OurPrograms",
						"program/:program_name/": "SingleProgram",
						'resource/': 'Resources',
						'author/:username/': 'ProfilePage',
						'lost-password/': 'LostPasswordPage',
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
					},
					ProfilePage: function(){
						this.profileView = new ProfileView();
					},
					LostPasswordPage: function(){							// create a view for the lost password page
						this.lostpasswordView = new LostPasswordView();
					}	
				});

				app = new ApplicationRouter();
				Backbone.history.start({pushState: true, root: "/cmef/"});
			});
		});
		
	});

});