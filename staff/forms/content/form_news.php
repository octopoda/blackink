<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	$u_id;

	if (!empty($_GET['sel'])) {
		$news = new News($_GET['sel']);	
		$action = "Update News";	
		$u = new Users($news->user_id);
	} else {
		$news = new News();
		$action = "Insert News";
		$u = new Users($users->user_id);	
	}
	

	
	echo $news->pushToForm();
	echo $u->pushToForm();
	$infoKey = md5(time().rand());
	
?>
<script>
	//Set up the current user_id in the form
</script>

<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>Title</label>
            	<input type="text" id="title" name="title" />
            </p>
            <div class="twoDropDowns clearfix">
            <p>
            	<label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>
                
            </p>
            
            <p class="new">
            	<label for="access">Access:</label>
				<?php echo $news->accessDropDown($news->news_id) ?>
            </p>
            </div>
			<p>
            	<label for="content">Content</label>
            	<textarea name="content" id="<?php echo $infoKey ?>" class="editor"></textarea>
                <input type="hidden" id="content" />
            </p>
     	      
            <p>	
            	<input type="hidden" name="news_id" id="news_id" />
                <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="addNews" id="addNews" value="forms/content/list_news.php" />
                <button><?php echo $action; ?></button>
            </p>
            
        </fieldset>
    </form>
    
    <?php if($action=="Update News") : ?>
    <section>
    	
    	<p>This content was Authored by : <?php echo $u->printName(); ?> on <?php echo $news->displayDate($news->created_on); ?>
        
    </section>
    <?php endif; ?>
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
	
	
	$('textarea[name="content"]').val($('#content').val());


</script>