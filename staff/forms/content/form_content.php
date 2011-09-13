<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	unset($_SESSION['errors']);
	
	
	
	if (!empty($_GET['sel'])) {
		$content = new Content($_GET['sel']);	
		$action = "Update Content";	
	} else {
		$action = "Insert Content";	
	}
	
	$infoKey = md5(time().rand());
	
?>


<h3><?php echo $action; ?></h3>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>

<div class="header">
	<form id="formUpdate" action="/ajax/admin/admin_form_submit.php" method="POST">
		<fieldset>
        	<legend>Title and Information</legend>
            <p>
            	<label>Title</label>
            	<input type="text" id="contentTitle" name="contentTitle" />
            </p>
            <p>
            	<label for="published">Published</label>
                
            </p>
            
            <p>
            	<label for="contentAccess">Access<label>
                <select name="contentAccess" id="contentAccess">
                	<option>Everyone</option>
                    <option>Registered</option>
                    <option>Admin</option>
                    <option>Super Admin</option>
                </select>
            </p>
            
			<p>
            	<label for="content">Content</label>
            	<textarea name="content" id="<?php echo $infoKey ?>" class="editor"></textarea>
            </p>
     	      
            <p>	
            	<button><?php echo $action; ?></button>
            </p>
            
        </fieldset>
    </form>
</div>


<div class="data">
</div>
<div class="phpErrors">
</div>

<script type="text/javascript">
	
  
 
	var config =  {
			toolbar :
			[
				['Source'],
				['Cut','Copy','Paste','PasteText','PasteFromWord','-', 'SpellChecker'],
				['Undo','Redo','-','RemoveFormat'],
				['Bold','Italic','Underline'],
				['Subscript','Superscript'],
				['NumberedList','BulletedList'],
				['Link','Unlink'],
				['Image','Flash','HorizontalRule','SpecialChar','Format'],
				['Maximize', 'ShowBlocks','-','About']
			],
			width : '500',
			height : '300',
			
	}; 
		
	
	
	$( 'textarea.editor' ).ckeditor(config, function () {
		this.dataProcessor.writer.setRules( 'p',
            {
				indent : false,
				breakBeforeOpen : false,
				breakAfterOpen : false,
				breakBeforeClose : false,
				breakAfterClose : false
            });
		this.dataProcessor.writer.setRules( 'div',
			{
				indent : false,
				breakBeforeOpen : false,
				breakAfterOpen : false,
				breakBeforeClose : false,
				breakAfterClose : false
			});			
	});
	


</script>