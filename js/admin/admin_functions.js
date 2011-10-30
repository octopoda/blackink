// JavaScript Document

/* ===========================================
	Redirection  Methods
   =========================================*/		
    
	//Redirect Main Content
  	function redirectTo($string) {
		findTab($string);
		
		$.ajax({
			url: $string,
			success: function(data) {
				getErrors();
				$('#content').html(data);
			},
			error:function(xhr, status, errorThrown) { 
            	alert('The Page' + $string +'was not Found'); 
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
				$('#tabs').html(data.tabs);
				
				$.ajax ({
					url: $href,
					success: function (data) {
						if (data != null) {
							$('#content').html(data)
							getErrors();	
						} else {
							$('#content').html('I looked for your file but it is not there.')	
						}
					}, error: function (xhr, textStatus, errThrown) {
						$('#content').html('Hmm an Error..Something is missing.')
					}
				}); //Ajax
				
			},
			error: function (xhr, textStatus, errThrown) {
				postError('Error', 'Please report error ID AJ3129 to Error Reporting');	
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
				getErrors();
				$('#content').html(data);
			},
			error: function (xhr, textStatus, errThrown) {
				postError('error', 'Please report error ID MNB129 to Error Reporting');
			}
		});
	})
	
	
	function changeActiveTab(object) {
	 	object.parent('li').siblings().removeClass('active');
		object.parent('li').addClass('active');
 	}
	
	function findTab(href) {
		_a = new Array();
		_a = href.split("?");
		
		
		$('#tabs ul li').each(function () {
			if ($(this).children().attr('href') == _a[0]) {
				changeActiveTab($(this).children());	
			}
		})	
	}
	
	
	
	$('.redirect').live('click', function (e) {
		e.preventDefault();
		var href = $(this).attr('href')
		redirectTo(href);
	});	
	
	
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
	
	//Set Default Page
	$('.setDefault').live('click', function (e) {
		e.preventDefault();
		
		$this = $(this);
		$id = $(this).attr('id');
		$href = $(this).attr('href');
		
		if ($this.hasClass('active')) {
			return false;
		}
		
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'defaultId': $id, 'href': $href},
			success: function (data) {
				redirectTo(data);
			}
		})
	
	});
	
	//Change the Access of an Item
	$('#access').live('change', function () {
		if ($(this).parent().attr('class') == 'new') {
			return false;	
		}
		
		var $id = $(this).attr('sel');
		var $class = $(this).attr('class');
		var $access = $(this).val();
		var $this = $(this);
		
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { "access": $access, "class": $class, "id": $id },
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
		$column = $this.attr('title');
		$href = $this.attr('href');
		
		$this.replaceWith('<input type="text" name="'+ $column +'"  value="'+ $value +'"  link="'+ $href +'" /><button class="editSubmit" name="editSubmit" id="'+$id+'">Edit</button>');
		
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
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'id': $id, 'class': $className, 'name': $name, 'value' : $value, 'quickEdit': 1, 'href': $href },
			success: function (data) {
				//$('.data').html(data);
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
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: { 'id': $id, 'class': $class, 'href': $href , 'deleter': 1 },
			success: function (data) {
				//$('.data').html(data);
				redirectTo(data);
			}
		});
	});
	
	
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
	
	
	$('.reportError').live('click', function (e) {
		e.preventDefault();
		
		$.ajax({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: {'reportError': 1},
			onSubmit: $(this).html('Sending Email'),
			success: function (data) {
				$('.modal .close').click();
				//$('.data').html(data);
				postError('message', 'Your error has been reported.  Please give 3-4 business days for the error to be fixed.');	
			}
		});	
	});

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
			url: '/ajax/admin/admin_form_submit.php',
			data: $datastring,
			beforeSubmit: $('.data').html('loading....'),
			success: function (data) {
				//$('.data').html('data '+ data);
				redirectTo(data);
			},
			error: function(xhr, textStatus, errThrown) {
                $('.data').html('<ul class="errors"><li>Something went wrong with out System, please alert our admin with this id: AJ198473</li></ul>');
            }
		}); 
	}


/* ===========================================
	Form Actions
   =========================================*/
	
	
	$('select#menu_id').live('change', function () {
		var menu_id = $(this).val();
		
		$.ajax ({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: {'menu_id' : menu_id, 'menuChange': 1},
			dataType:'json',
			beforeSubmit: $('.listParents').html('loading...'),
			success: function (data) {
				$('.listParents').html(data.parent);
				$('.listPosition').html(data.position);		
			}
		});
	});
	
	
	$('select#parent_id').live('change', function() {
		var menu_id  = $('select#menu_id').val();
		var parent_id = $(this).val();
		
		$.ajax ({
			url: '/ajax/admin/admin_functionality.php',
			type: 'POST',
			data: {'menu_id' : menu_id, 'parent_id' : parent_id, 'parentChange': 1},
			beforeSubmit: $('.listPosition').html('loading...'),
			success: function (data) {
				$('.listPosition').html(data);		
			}
		});
	});
	
	
	$('input#content_title').live('focus', function () {
		$('#dialog').modal({
			style: 'html',
			url: 'forms/content/pop_up_content.php',
			height:400,
			width:800,	
		});		
	});
	
	
	$('#dialog .popup tr td[col="title"]').live('click', function () {
		var id = $(this).parent().attr('primary_key');
		$('input#content_id').val(id);
		$('input#content_title').val($(this).html());
		$('#mask').click();
	});
	
	
	$('.grid tr td a').live('click', function (e) {
		e.preventDefault();
		
		if ($(this).hasClass('published')) return;
		
		$(this).attr('target', '_self');
		var $link = $(this).attr('href');
		var $id = $(this).parent('td').parent('tr').attr('primary_key');
		var $url = $link + '?sel=' + $id;
	
		redirectTo($url);
	});
	
	$('.externalLink').live('change', function() {
		if ($(this).is(':checked')) {
			$('.externalInput').show();
			$('.contentInput').hide();
			$('.contentInput').children('input').val('');	
		} else {
			$('.contentInput').show();
			$('.externalInput').hide();
			$('.externalInput').children('input').val('');
		}
	});
	
	
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
	





