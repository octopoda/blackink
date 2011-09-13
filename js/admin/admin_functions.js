// JavaScript Document
$(document).ready(function () {
    
	
	
	//Set height of Secondary and Main 
  	function redirectTo($string) {
		$.ajax({
			url: $string,
			success: function(data) {
				$('#contentWrapper').html(data);
				
				//Get Errors
				$.ajax({
					url: '/ajax/ajax_form_submit.php',
					type: 'POST',
					data: {'errorPlacement': 1},
					success: function (data) {
						$('.errorPlacement').html(data);			
					}
				})
				
            },
			error:function(xhr, status, errorThrown) { 
            	alert('That Page was not Found'); 
        	}
		});
	}

	
	$('#navigation ul li a').click(function (e) {
		e.preventDefault();
		
		var $this = $(this);
		var $sel =  $this.attr('sel');
		var $href = $this.attr('href');
		
		changeActiveTab($this);
	
		$.ajax({
			url: 'handlers/navigation.php',
			type: 'POST',
			data: {'sel' : $sel, 'href': $href},
			dataType: 'json',
			success: function (data) {
				//$('#tabs').html(data);
				$('#tabs').html(data.tabs);
				
				$.ajax ({
					url: $href,
					success: function (data) {
						
						if (data != null) {
							$('#content').html(data)	
						} else {
							$('#content').html('I looked for your file but it is not there.')	
						}
					}, error: function (xhr, textStatus, errThrown) {
						$('#content').html('Hmm an Error..Something is missing.')
					}
				});
			},
			error: function (xhr, textStatus, errThrown) {
				alert('Error: Please report error ID MNB129 to Error Reporting');	
			}
		});
		
	});
	
	
	$('#tabs ul li a').live('click', function (e) {
		e.preventDefault();	
		$this = $(this);
		$href= $this.attr('href');
		
		changeActiveTab($this);
		
		$.ajax({
			url: $href,
			type: 'POST',
			success: function (data) {
				$('#content').html(data);
			},
			error: function (xhr, textStatus, errThrown) {
				alert('Error: Please report error ID MNB129 to Error Reporting');
			}
		});
	})
	
	
	function changeActiveTab(object) {
	 	object.parent('li').siblings().removeClass('active');
		object.parent('li').addClass('active');
 	}
	
	
});
