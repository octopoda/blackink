// JavaScript Document //	
$(document).ready(function () {	
	
/* ===========================================
	Load Calls
   =========================================*/
	getErrors();
	
	$('.mainNav li').hover( function (e) {
		$(this).toggleClass('active');
	}, function () {
		$(this).toggleClass('active');
	});

/* ===========================================
	Site  Methods
   =========================================*/
   		
	//Add Phone 
	$('.addPhone').live('click', function (e) {
		e.preventDefault();
		$span = $(this).parent('span');
		$paragraph = $(this).parent('span').parent('p');
		
		
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: {'addPhone': 1},
			success: function (data) {
				$span.hide();
				$paragraph.after(data);
				//$('.data').html(data);	
			}
		});	
	});


	$('.alpha').live('click', function (e) {
		e.preventDefault();
		_sel = $(this).attr('sel');
		
		$.ajax({
			url: '/ajax/ajax_submit.php',
			type: 'POST',
			data: {'supplementAlpha' : _sel },
			success: function (data) {
				$('#supplements').html(data);	
			}
		});
		
	});
	

/* ===========================================
	Search Methods
   =========================================*/
	
	$("#search").autocomplete( "/ajax/ajax_submit.php",
	  {
			autofill: true,
			matchSubset: false,
			matchContains: false,
			formatItem: function(row, i, max) { return row[0]; },
			formatMatch: function(row, i, max) { return row[0]; },
			formatResult: function(row) { return row[0]; },
			extraParams: { 'searchAutoComplete': 1 }
	  });
			
	$('.pagination li a').live('click', function (e) {
		e.preventDefault();
		$pageNumber = $(this).parent('li').attr('sel');
		$search = $(this).parent('li').parent('ul').attr('sel');
		$.ajax({
			url: '/ajax/ajax_submit.php',
			type: 'POST',
			data: {'search' : $search, 'pageNumber': $pageNumber},
			success: function (data) {
				$('.mainContent article').html(data);	
			}
		})
		
	});
	
	
	$('.pagination li input').live('focusout', function (e) {
		$search = $(this).parent('li').parent('ul').attr('sel');
		$pageNumber = $(this).val();
		
		$.ajax({
			url: '/ajax/ajax_submit.php',
			type: 'POST',
			data: {'search' : $search, 'pageNumber': $pageNumber},
			success: function (data) {
				$('.mainContent article').html(data);	
			}
		})	
	})
	
	
	
	
/* ===========================================
	Error Methods
   =========================================*/	
	
	
	function getErrors() {
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'errorPlacement': 1},
			dataType: 'json',
			success: function (data) {
				//$('.data').html(data);
				$('#dialog').modal({
					style: data.style,	
					text: data.text,
					reportError: data.reportError,
				});
			}
		})	
	}
	
	function postError(type, text) {
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'addError': text, 'type': type},
			success: function (data) {
				getErrors();	
			}
		});	
	}
	



/* ===========================================
	Form Submitting
   =========================================*/

	
	$('form#formSubmit').live('submit', function(e) {
		e.preventDefault();
		
		$(this).find('[placeholder]').each(function() {
    		var input = $(this);
    		if (input.val() == input.attr('placeholder')) {
      			input.val('');
    		}
  		});
		
		var $this = $(this);
		validate($this);
		
		var $error = 1;
		var $count = $this.children('fieldset').find(':input:not(button)').hasClass('hasError'); 
		
		if ($count) {
			$error = -1;
		}
		
		if ($error == 1) {
			ajaxFormSubmit($this);	
		}
		
	});
	
	
	//Validation on Submit for Forms
	function ajaxFormSubmit(object) {
		var $datastring = object.serialize();
		_button = object.find('button');
		_html = _button.html();
		
		$.ajax({
			type: 'POST',
			url: '/ajax/ajax_submit.php',
			data: $datastring,
			onSubmit: _button.html('<img src="/images/admin/ajax-loader.gif" /> Loading').addClass('disabled'), 
			success: function (data) {
				_button.remove();
				$('.data').html(data);
				postError('message', data);
				getErrors();
			},
			error: function(xhr, textStatus, errThrown) {
                _button.html(_html);
				postError('error', 'Something went wrong with out System. Please try again later');
				getErrors();
            }
		}); 
	}


	$('.honeyPot').prepend('<p class="checkbox"><input type="checkbox" name="real" id="real"  sel="" /><label>I am not a spam bot</label></p>')


/* ===========================================
	Individaul Forms 
   =========================================*/
	
	//Submit for Login Form
	$('form#formLogin').submit(function(e) {
		
		
		e.preventDefault();
		
		var $datastring = $(this).serialize();

		_button = $(this).find('button');
		_html = _button.html();
		
		
		$.ajax({
			type: 'POST',
			url: '/ajax/ajax_submit.php',
			data: $datastring,
			dataType : 'json',
			onSubmit: _button.html('<img src="/images/admin/ajax-loader.gif" /> Loading').addClass('disabled'), 
			success: function (data) {
				if (data.refer != null) {
					window.location = data.refer;					
				} else if (data.error != null){
					_button.html(_html).removeClass('disabled');
					$('.formMessage').html(data.error);
				}
			},
			error: function(xhr, textStatus, errThrown) {
                _button.html(_html);
				postError('error', 'Something went wrong with out System. Please try again later');
				getErrors();
            }
		}); 
	});


/* ===========================================
	Form Actions
   =========================================*/
	
	$('[placeholder]').focus(function() {
		var input = $(this);
		if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		}
	}).blur(function() {
	  	var input = $(this);
	  	if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
	  	}
	}).blur();
});

/* ===========================================
	Rotating Ads
   =========================================*/

//Setup Numbers Panel
	var $panels = $('.scroll > div'); //Set Array of Panels
	var $container = $('.ads .scroll'); //Set up Scroll Container
	var $ads = $('.ads'); //Set up main Container
	
	var $html = '<ul>';
	for(var i = 0; i <= $panels.length -1; i++) {
		$html = $html + '<li class="'+i+' ir" sel="'+i+'">' + i + '</li>';	
	}
	$html = $html + '</ul>';
	
	$('.numbers').html($html);
	
	//Set the position of Numbers
	var numWidth = ($panels.length * 20)/2;
	var adWidth = ($('.ads').width())/2;
	var numLeft =  adWidth - numWidth; 
	$('.numbers').css({ left: numLeft });
		
	var $numbers = $('.numbers ul li');  //Build Array for Numbers
	var cWidth = ($panels[0].offsetWidth + 30 ) * $panels.length; //Set width for .scroll from # of Panels placed together
	
	$container.css({ width: cWidth }) //Set Scroll Container
	$panels.css({ float: 'left', position: 'relative' }); //Float panels to left and add relative for IE7
	$ads.css({overflow:'hidden'}); //Hide the Panels outside of Ads
	
	var nTimes = 0;	//Counter for Number of times through animatiom
	$('.numbers ul li:first-child').addClass('active'); //Add Active attribute to First li in Numbers
	
	//Setup Interval to run every 3 Seconds
	setInterval(function () {
		panelAnimate($panels[nTimes]);
		numbersChange();
		
	}, 10000);
	
	
	//Animate Objects
	function panelAnimate(object) {
		if (nTimes >= $panels.length -1) {
			nTimes = 0; 
		} else {
			nTimes++;
		}
		
		var objectWidth = object.offsetWidth;
		objectWidth = -objectWidth *nTimes;
		
		$container.animate({
			left: objectWidth
		}, 500);
	}
	
	//Setup Number Panel
	function numbersChange () {
		$('.numbers ul').children('li').removeClass('active');
		
		var className = nTimes;
		$('.numbers ul .' + className).addClass('active');	
	}










