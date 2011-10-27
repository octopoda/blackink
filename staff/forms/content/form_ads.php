<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$ads = new Ads($_GET['sel']);	
		$action = "Update Advertisment";	
		$u = new Users($ads->user_id);
	} else {
		$ads = new Ads();
		$action = "Insert Advertisment";
		$u = new Users($users->user_id);	
	}
	

	
	echo $ads->pushToForm();
	echo $u->pushToForm();
	$infoKey = md5(time().rand());
	$infoKey2 = md5(time().rand());
	
?>

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
            	<label for="placement">Placement:</label>
				<select name="placement" id="placement">
                	<option value="0">FrontPage</option>
                    <option value="1">SideBar</option>
                    <option value="2" selected>Both</option>
                </select>
            </p>
            </div>
			<p>
            	<label for="summary">Front Page/Side Page Summary</label>
            	<textarea name="summary" id="<?php echo $infoKey ?>" class="editor"></textarea>
                <input type="hidden" id="summary" />
            </p>
            <p>
            	<label for="content">Content</label>
            	<textarea name="content" id="<?php echo $infoKey2 ?>" class="editor"></textarea>
                <input type="hidden" id="content" />
            </p>
            <p>	
            	<input type="hidden" name="ad_id" id="ad_id" />
                <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="addAds" id="addAds" value="forms/content/list_ads.php" />
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
	$('textarea[name="summary"]').val($('#summary').val());


</script>