// JavaScript Document
$(document).ready(function () {
 	//SEtup Ajax Errors
 	/* $.ajaxSetup({
		error:function(x,e){
			if(x.status==0){
			alert('You are offline!!\n Please Check Your Network.');
			}else if(x.status==404){
			alert('Requested URL not found.');
			}else if(x.status==500){
			alert('Internel Server Error.');
			}else if(e=='parsererror'){
			alert('Error.\nParsing JSON Request failed.');
			}else if(e=='timeout'){
			alert('Request Time out.');
			}else {
			alert('Unknow Error.\n'+x.responseText);
			}
		}
	}); */
	
	
	//Set height of Secondary and Main 
  	function redirectTo($string) {
		
		$.ajax({
			url: $string,
			success: function(data) {
				$('#content').html(data);				
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
	
	
/* ===========================================
	Error Methods
   =========================================*/
   
   
	///Move Up and Down Arrows 
	$('.move').live('click', function (e) {
		$title = $(this).attr('title');
		$id = $(this).attr('sel');
		$class = $(this).parent('li').attr('class');
		$position = $(this).parent('li').attr('sel');
		$href = $(this).attr('href');
		$parent = $(this).attr('parent');
		
		$.ajax ({
			url: '/ajax/admin/admin_form_submit.php',
			type: 'POST',
			data: { 'id': $id, 'move': $title, 'class': $class, 'position': $position, 'href': $href, 'parent' : $parent},
			success: function (data) {
				redirectTo(data);
			}
		}); 
		
		e.preventDefault();
	});
	
	
	//Publish and unpublish items.
	$('.published').live('click', function () {
		
		var $id = $(this).attr('id');
		var $class = $(this).attr('sel');
		var $published = $(this).attr('published');
		var $this = $(this);
		if ($published == 'yes') $published = true;
		
		$.ajax({
			url: '/ajax/admin/admin_form_submit.php',
			type: 'POST',
			data: { "publishedId": $id, "class": $class, "published": $published },
			success: function (data) {
				$this.parent().html(data);
			}
		})
	});


/* ===========================================
	Error Methods
   =========================================*/
	
	//Error Box actions
	$('.errorClose').live('click', function(e) {
		$.ajax({
			url: '/ajax/admin/admin_form_submit.php',
			type : 'POST',
			data: {'closeError' : 1},
			success: function (data) {
				$('#errorWrapper').remove();
			}
		})
	});
	
	
	$('.reportError').live('click', function(e) {
		redirectTo('forms/report_errors.php');
		$('.errorClose').click();
	});
});
