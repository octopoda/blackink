// JavaScript Document //	
	
	
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

	
	$('form#formUpdate').live('submit', function(e) {
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
			beforeSubmit: $('.data').html('loading....'),
			success: function (data) {
				$('.data').html('data '+ data);
				
			},
			error: function(xhr, textStatus, errThrown) {
                $('.data').html('<ul class="errors"><li>Something went wrong with out System, please alert our admin with this id: AJ198473</li></ul>');
            }
		}); 
	}



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
	
















