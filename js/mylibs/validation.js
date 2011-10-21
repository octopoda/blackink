// JavaScript Document
//

	var $message = "This field is required";
	
	//Check to see if any validations failed on each input
	$('.required').live('focus', function () { clearPaint($(this));  });
	$('.required').live('focusout', function() { if (required($(this).val())) cssPaint($(this));});
	
	$('.email').live('focus', function () { clearPaint($(this));  });
	$('.email').live('focusout', function () { if (email($(this).val())) cssPaint($(this));});
	
	$('.usPhone').live('focus', function () { clearPaint($(this)); });
	$('.usPhone').live('focusout', function () { if (usPhone($(this).val())) cssPaint ($(this)); });
	
	$('.date').live('focus', function () { clearPaint($(this)); });
	$('.date').live('focusout', function () { if (date($(this).val())) cssPaint ($(this)); });
	
	$('.age').live('focus', function () { clearPaint($(this)); });
	$('.age').live('focusout', function () { if (age($(this).val())) cssPaint ($(this)); });
	
	$('.adminAge').live('focus', function () { clearPaint($(this)); });
	$('.adminAge').live('focusout', function () { if (adminAge($(this).val())) cssPaint ($(this)); });
	
	$('.futureDate').live('focus', function () { clearPaint($(this)); });
	$('.futureDate').live('focusout', function () { if (futureDate($(this).val())) cssPaint ($(this)); });
	
	$('.numeric').live('focus', function () { clearPaint($(this)); });
	$('.numeric').live('focusout', function () { if (numeric($(this).val())) cssPaint ($(this)); });
	
	$('.zip').live('focus', function () { clearPaint($(this)); });
	$('.zip').live('focusout', function () { if (zip($(this).val())) cssPaint ($(this)); });
	
	$('.equalTo').live('focus', function () { clearPaint($(this)); });
	$('.equalTo').live('focusout', function () { if (equalTo($(this).val(), $(this))) cssPaint ($(this)); });
	
	$('.ac_input').live('focus', function () { clearPaint($(this)); });
	
	$('.isChecked').live('click', function () { clearPaint($(this)); $('.message').html('')});
	
	$('.diable').live('click', function (e) {e.preventDefault();});
	
	
	
	
//Validation Functions no validation errors returns false
	
	//Paints input box red when error
	function cssPaint(object) {
		object.addClass('hasError');
		object.after('<span class="validationError">'+ $message +'</span>');
		$('form button').addClass('disabled');
	}
	
	function clearPaint(object) {
		object.removeClass('hasError');
		object.next('span.validationError').remove();
		$('form button').removeClass('disabled');
	}
	 
	//Checks for required
	function required(value) {
		if (value.length == 0) {
			$message = "This field is required";
			return true;	
		}
		
		return false;
	}
	
	//Checks for email
	function email(value) {
		 value = value.replace(" ", "").replace("\t", "");
		 
		 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
		
		 if (value.length == 0) {
			$message = "Your email is required";
			return true; 
		 } else {
			if (!emailReg.test(value)) {
				$message = "Please provide a valid email";
				return true;
			} 
			return false;
		 }
	}
	
	//Check to see if inputs are equal
	function equalTo (value, element) {
		var target = element.parent('p').prev('p').children('input').val();
		
		if (value != target) {
			$message = 'The passwords do not match';
			return true;
		} 
		
		return false
	}
	
	//Numeric Values Only
	function numeric(value){
		  if (value.length == 0) {
			$message = "this field is required";
			return true;  
		  }
		 
		  var numReg = /^[-]?\d*\.?\d*$/;
		  
		  if (!numReg.test(value)) {
			$message = "All values must be numeric";
			return true;  
		  }
		  
		  return false;
	}
	
	function zip(value) {
		if (value.length == 0) return true;
		 
		var numZip = /^\d{5}(-\d{4})?$/;
		if  (!numZip.test(value)) {
			$message = "Please enter a valid zip";
			return true;	
		}
		
		return false;
	}
	
	
	
	// (000)000-0000, (000) 000-0000, 000-000-0000, 000.000.0000, 000 000 0000, 0000000000
	function usPhone(value){
 		 if (value.length == 0) return true;
		 
		 var phoneReg = /^\(?[2-9]\d{2}[\)\.-]?\s?\d{3}[\s\.-]?\d{4}$/;
 		 if (!phoneReg.test(value)) {
			$message = "Please enter a valid US phone (xxx)xxx-xxxx";
			return true; 
		 }
		 
		 return false;
	}
	
	// mm dd yyyy, mm/dd/yyyy, mm.dd.yyyy, mm-dd-yyyy
	function date(value) {
  		
		if (value.length == 0) return true;
		
		var dateReg = /^(\d{2})[\/](\d{2})[\/](\d{4})$/;
		
		if (!dateReg.test(value)) {
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
		var result = value.match(dateReg);
		
		var m = result[1];
		var d = parseInt(result[2]);
		var y = parseInt(result[3]);
		
		
		var currentYear = new Date().getFullYear();
		var currentDay = new Date().getDate();
		var currentMonth = new Date().getMonth();
		
		if (m < 1 || m > 12 || y < 1900 || y > currentYear) {
			
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
	
		//Make sure its a correct Date
		if(m == 2){
			var days = ((y % 4) == 0) ? 29 : 28;
		}else if(m == 4 || m == 6 || m == 9 || m == 11){
			var days = 30;
		}else{
			var days = 31;
		}
		
		if (d < 1 && d > days) {
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
		return false;
	}
	
	
	//mm dd yyyy, mm/dd/yyyy, mm.dd.yyyy, mm-dd-yyyy and is in the future
	function futureDate(value) {
		if (value.length == 0) return true;
		
		var dateReg = /^(\d{2})[\/](\d{2})[\/](\d{4})$/;	
		
		if (!dateReg.test(value)) {
			$message = "Please Enter Valid Date mm/dd/yyyy";
			return true;	
		}
		
		
		
		var result = value.match(dateReg);
		var m = parseInt(result[1]);
		var d = parseInt(result[2]);
		var y = parseInt(result[3]);
		
		var currentYear = new Date().getFullYear();
		var currentDay = new Date().getDate();
		var currentMonth = new Date().getMonth();
		
		
		
		if(m < 1 || m > 12 || y < 1900 ) {
			$message = "Please Enter Valid Date mm/dd/yyyy";
			return true;
		}
		
		
		
		//Make sure its a correct Date
		if(m == 2){
			var days = ((y % 4) == 0) ? 29 : 28;
		}else if(m == 4 || m == 6 || m == 9 || m == 11){
			var days = 30;
		}else{
			var days = 31;
		}
		
		if (d < 1 && d > days) {
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
		
		
		if (y < currentYear) {
			$message = "Must be a future Date";
			return true;	
		} else if (y == currentYear && m < currentMonth+1) {
			$message = "Must be a future Date";
			return true;		
		} else if (y == currentYear && m == currentMonth+1) {
			if (d < currentDay) {
				$message = "Must be a future Date";
				return true;			
			}
		}
	}
	
	function age(value) {
		if (value.length == 0) return true;
		
		var dateReg = /^(\d{2})[\/](\d{2})[\/](\d{4})$/;
		
		if (!dateReg.test(value)) {
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
		var result = value.match(dateReg);
		
		var m = result[1];
		var d = parseInt(result[2]);
		var y = parseInt(result[3]);
		
		
		var currentYear = new Date().getFullYear();
		var currentDay = new Date().getDate();
		var currentMonth = new Date().getMonth();
		
		if (m < 1 || m > 12 || y < 1900 || y > currentYear) {
			
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
	
		//Make sure its a correct Date
		if(m == 2){
			var days = ((y % 4) == 0) ? 29 : 28;
		}else if(m == 4 || m == 6 || m == 9 || m == 11){
			var days = 30;
		}else{
			var days = 31;
		}
		
		if (d < 1 && d > days) {
			$message = "Please enter a valid date. mm/dd/yyyyy";
			return true;
		}
		
		
		//Check to see if they are over 13
		if(currentYear - y < 13 ) {
			$message = 'You must be over 13 to attend LIFT Camp.';
			 window.location = '/confirm/under_thirteen.php'
			return true;
		} else if (currentYear - y == 13 && m > currentMonth + 1){
			$message = 'You must be over 13 to attend LIFT Camp.';
			 window.location = '/confirm/under_thirteen.php'
			return true;
		} else if (currentYear - y == 13 && m == currentMonth + 1) {
			if (d > currentDay) {
				$message = 'You must be over 13 to attend LIFT Camp.';
				 window.location = '/confirm/under_thirteen.php'
				return true;	
			}
		}
		
		return false;	
	}
	
	
	
	function isChecked($object) {
		if (!$object.is(':checked')) {
			return true;
		} 
		return false;
	}
	
//	
function disable (form) {
		
}
	
	
function validate(form) {
	form.children('fieldset').find(':input:not(button)').each(function () {
		
		
		
		var $this 		= $(this);
		var $class   	= $this.attr('class');
		var $value		= $this.val();
		
		
		switch ($class) {
			case 'required':
				if (required($value)) { cssPaint($this) };
				break;
			case 'email':
				if (email($value)) { cssPaint($this) };
				break;
			case 'date':
				if (date($value)) {cssPaint($this)};
				break;
			case 'age':
				if (age($value)) {cssPaint($this)};
				break;
			case 'usPhone':
				if (usPhone($value)) {cssPaint ($this)};
				break;
			case 'numeric':
				if (numeric($value)) {cssPaint ($this)};
				break;
			case 'zip':
				if (zip($value)) {cssPaint ($this)};
				break;
			case 'equalTo':
				if (equalTo($value, $this)) {cssPaint ($this)} ;
				break;
			case 'isChecked':
				if (isChecked($this.attr('checked'))) {
					$this.addClass('hasError');
					$('.message').html("<p>Please comply with our privacy policy.</p>"); 
				} 
			
		}
		
		
		$(this).children('button').addClass('disable');
	});
	
};
			

