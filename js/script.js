// JavaScript Document //	
	
/* ===========================================
	Load Calls
   =========================================*/
	getErrors();



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
		
		$.ajax({
			type: 'POST',
			url: '/ajax/ajax_submit.php',
			data: $datastring,
			success: function (data) {
				$('.message').html(data);
			},
			error: function(xhr, textStatus, errThrown) {
                postError('Something went wrong with out System. Please try again later');
				getErrors();
            }
		}); 
	}


	$('.honeyPot').prepend('<p class="checkbox"><input type="checkbox" name="real" id="real"  sel="" /><label>I am not a spam bot</label></p>')


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
	
















