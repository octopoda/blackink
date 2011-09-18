// JavaScript Document
$(document).ready(function () {
 		

/* ===========================================
	Redirection  Methods
   =========================================*/		
 
	//Redirect Main Content
  	function redirectTo($string) {
		
		$.ajax({
			url: $string,
			success: function(data) {
				$('#content').html(data);				
				//Get Errors
				$.ajax({
					url: '/ajax/admin_functionality.php',
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

	//Ajax Control of Main Navigation
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
	
	
	//AJAX Control of Tabs
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
	Admin Methods
   =========================================*/
   
   
	//Position Arrows 
	$('.move').live('click', function (e) {
		$title = $(this).attr('title');
		$id = $(this).attr('sel');
		$class = $(this).parent('li').attr('class');
		$position = $(this).parent('li').attr('sel');
		$href = $(this).attr('href');
		$parent = $(this).attr('parent');
		$menu_id = $(this).attr('menu')
		
		$.ajax ({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'id': $id, 'move': $title, 'class': $class, 'position': $position, 'href': $href, 'parent' : $parent, 'menu_id': $menu_id},
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
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { "publishedId": $id, "class": $class, "published": $published },
			success: function (data) {
				$this.parent().html(data);
			}
		})
	});
	
	
	//Menu Select to change Navigation
	$('#radio input').live('change', function () {
		var $id = $(this).val();
		
		$url = 'forms/navigation/navigation.php'
		$url += '?sel=' + $id;
		
		$.ajax({
			url: $url,
			success: function (data) {
				$('#content').html(data);
			}
		})
	});
	
	//Edit 
	$('.edit').live('click', function(e) {
		e.preventDefault();
		redirectTo($(this).attr('href'));	
	})
	
	
	//Stop quick edit from editting on first click
	$('.quickEdit').live('click', function (e) {
		e.preventDefault();	
	});
	
	
	//Quick Edit Feature
	$('.quickEdit').live('dblclick', function(e)  {
		$this = $(this);
		$value = $this.html()
		$id = $this.attr('id');
		$title = $this.attr('title');
		$href = $this.attr('href');
		
		$this.replaceWith('<input type="text" name="'+ $title +'" value="'+ $value +'"  link="'+ $href +'"/><button class="editSubmit" name="editSubmit" id="'+$id+'">Edit</button>');
		
	});
	
	//Submitting the Quick Edit
	$('.editSubmit').live('click', function(e) {
		$this = $(this);
		$className = $(this).parent().attr('class');
		$id = $this.attr('id');
		$value = $this.prev('input').val();
		$href = $this.prev('input').attr('link');
		$name = $this.prev('input').attr('name');
		
		$.ajax({
			url: '/ajax/admin_form_submit.php',
			type: 'POST',
			data: { 'id': $id, 'class': $className, 'name': $name, 'value' : $value, 'quickEdit': 1, 'href': $href },
			success: function (data) {
				$('.data').html(data);
				redirectTo(data);
			}	
		})	
	}); 
	
	
	//Delete Buttons 
	$('.delete').live('click', function (e) {
		e.preventDefault();
		if (!confirm("You are about to delete this item. Is this what you want to do?")) {
			return false;
		}
		$class = $(this).attr('id');
		$id = $(this).attr('sel');
		$href = $(this).attr('href');
		
		$.ajax({
			url: '/ajax/admin_form_submit.php',
			type: 'POST',
			data: { 'id': $id, 'class': $class, 'href': $href , 'deleter': 1 },
			success: function (data) {
				$('.data').html(data);
				redirectTo(data);
			}
			
			})
			
	});

/* ===========================================
	Form Submitting
   =========================================*/
	
	$('form#formUpdate').live('submit', function(e) {
		e.preventDefault();
		
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
		var $url = object.attr('action');
		var $datastring = object.serialize();
		
		$.ajax({
			type: 'POST',
			url: '/ajax/admin/admin_form_submit.php',
			data: $datastring,
			beforeSubmit: $('.data').html('loading....'),
			success: function (data) {
				$('.data').html(data);
				redirectTo(data);
				
			},
			error: function(xhr, textStatus, errThrown) {
                $('.data').html('<ul class="errors"><li>Something went wrong with out System, please alert our admin with this id: AJ198473</li></ul>');
            }
		}); 
	}
	


/* ===========================================
	Modal Methods
   =========================================*/
	
	modal($('#dialog'));
	
	function modal ($object) {
		//Get the A tag
        
        //Get the screen height and width
        var maskHeight = $(document).height();
        var maskWidth = $(window).width();
     
        //Set height and width to mask to fill up the whole screen
        $('#mask').css({'width':maskWidth,'height':maskHeight});
         
        //transition effect    
        $('#mask').fadeIn(1000);   
        $('#mask').fadeTo("slow",0.6); 
     
        //Get the window height and width
        var winH = $(window).height();
        var winW = $(window).width();
               
        //Set the popup window to center
        $('#dialog').css('top',  winH/2-$('#dialog').height()/2);
        $('#dialog').css('left', winW/2-$('#dialog').width()/2);
     
        //transition effect
        $('#dialog').fadeIn(2000); 
	}
	
	$('.modal .close').live('click', function () {
		 //Cancel the link behavior
       
        $('.modal').hide();
        $('#mask').hide();
        
        //Clear Session
	});
	
	$('#mask').live('click', function() {
        $('.modal').hide();
        $('#mask').hide();
        
        //Clear Session
	});	


});//End Doucment Ready

