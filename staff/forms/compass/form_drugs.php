<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$drugs = new Drugs($_GET['sel']);
		$modDrugs = new Drugs($_GET['sel']);
		
		$action = "Update Theraputic Category";	
		$user = new Users($drugs->user_id);
		$drugs->modified_by = $users->user_id;
		
		if (!empty($modDrugs->modified_by)) {
			$modUsers = new Users($modDrugs->modified_by);
			$modName = $modUsers->printName();
			$modId = $modUsers->user_id;
		}
	} else {
		$drugs = new Drugs();
		$action = "Insert Theraputic Category";	
		$user = new Users($users->user_id);
	}
	
	echo $drugs->pushToForm();
	echo $user->pushToForm();
	$infoKey = md5(time().rand());
	$otherKey = md5(time().rand());
	
?>
<script src="/js/mylibs/ajaxupload.js"></script>

<ul class="quickMenu">
	<li><a href="/compass_preview.php" class="preview" target="_blank">
    		<span class="ninjaSymbol ninjaSymbolWatch"></span> 
        	<span class="text">Preview</span>
         </a></li>
</ul>

<h3><?php echo $action; ?></h3>

<div class="header">
	<form id="formUpdate" method="POST">
		<fieldset>
        	<p>
            	<label>Drug Name</label>
            	<input type="text" id="drugName" name="drugName" class="nospecial" />
            </p>
            <p>
            	<label>Drug Use:</label>
                <input type="text" id="drugUse" name="drugUse" class="required" />
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
                <?php echo $drugs->accessDropDown($drugs->drug_id); ?>
            </p>
            </div>
            <p>
            	<a class="uploadImageContent">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
				</a>
            </p>
			<p class="textarea">
            	<label for="content">Content</label>
            	<textarea name="content" id="<?php echo $infoKey ?>" class="editorContent required"><?php echo $drugs->content; ?></textarea>
                <input type="hidden" id="content" />
            </p>
            
            <p>	
            	<input type="hidden" name="drug_id" id="drug_id" />
                <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="modified_by" id="modified_by"  />
                <input type="hidden" name="addDrugs" id="addDrugs" value="forms/compass/info_drugs.php?sel=" />
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
		editor_selector: "editorContent",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,media,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking",

        // Theme options
        theme_advanced_buttons1 : "bold, italic, strikethrough, |, styleselect, formatselect, |, pasteword, |, bullist, numlist, blockquote, |, link, unlink, anchor, image, |, code, |, spellchecker, | ,pagebreak ",
        theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_resizing : true,
		
		content_css : "/staff/css/admin.css",
		
		width: "600",
		height: "400"
	});
	
	tinyMCE.triggerSave();
	
	var btnUpload=$('.uploadImageContent');
	var button = $('.uploadImageContent').html();
		
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
				return false;
			}
			
			if (file.length > 59) {
				alert('The file name is too long. Please keep the file name under 60 characters.');
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