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
	$otherKey = md5(time().rand());
	
?>
<script>
	//Set up the current user_id in the form
</script>

<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>News Title</label>
            	<input type="text" id="title" name="title" class="required" />
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
            	<a class="uploadImageContent">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
				</a>
            </p>
			<p>
            	<label for="content">Content</label>
            	<textarea name="content" id="<?php echo $infoKey ?>" class="editor"><?php echo $news->content ?></textarea>
                <input type="hidden" id="content" />
            </p>
            
            <p>
            	<label for="summary">Sidebar Summary</label>
            	<textarea name="summary" id="<?php echo $infoKey ?>" class="editor"><?php echo $news->summary ?></textarea>
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
   
</div>


<div class="data">
</div>


<script type="text/javascript">
	tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,media,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking",

        // Theme options
        theme_advanced_buttons1 : "bold, italic, strikethrough, |, styleselect, formatselect, |, pasteword, |, bullist, numlist, blockquote, |, link, unlink, anchor, image, |, code, |, spellchecker, | ,pagebreak ",
        theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_resizing : true,
		
		content_css : "/css/tiny_styles.css",
		
		width: "600",
		height: "400"
	});
	
	tinyMCE.triggerSave();
	
	var btnUpload=$('.uploadImageContent');
	var button = $('.uploadImageContent').html();
	var content;	
		
	new AjaxUpload(btnUpload, {
		action: '/ajax/ajax_upload.php',
		name: 'file_name',
		data: {'content': 1},
		onSubmit: function(file, ext){
			btnUpload.html('<img src="/images/admin/ajax-loader.gif" alt="loading"/>');
			content = $('.editor').val();
			if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
				// extension is not allowed
				alert('Only JPG, PNG, GIF,  files are allowed');
				btnUpload.html(button);			
				return false;
			} 
			
			if (file.length > 59) {
				alert('This file name is too long.  Please make it less than 60 characters');
				btnUpload.html(button);			
				return false;	
			}
			
			if (file.indexOf(' ') > 0) {
				alert('Please remove the spaces from the file name.');
				btnUpload.html(button);			
				return false;	
			}
			
		},
		onComplete: function(file, response){
			var ed = tinyMCE.get('<?php echo $infoKey ?>');      // get editor instance
			var newNode = ed.getDoc().createElement ( "img" );   // create img node
			newNode.src= response;                            // add src attribute
			ed.execCommand('mceInsertContent', false, newNode.outerHTML)
			btnUpload.html(button);			
		}
	});


</script>