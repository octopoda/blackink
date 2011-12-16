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
            	<label>Advertisment Title</label>
            	<input type="text" id="title" name="title" class="nospecial" />
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
			<p class="textarea">
            	<label for="summary">Front Page/Side Page Summary</label>
            	<textarea name="summary" id="<?php echo $info_key ?>" class="editor"><?php echo $ads->summary; ?></textarea>
                <input type="hidden" id="summary" />
            </p>
            <p>
            	<a class="uploadImageContent">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
				</a>
            </p>
            <p class="textarea">
            	<label for="content">Content</label>
            	<textarea name="content" id="<?php echo $infoKey2 ?>" class="editor"><?php echo $ads->content; ?></textarea>
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
		
		content_css : "/css/user_styling.css",
		
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
				return false;
			}
			
			if (file.length > 59) {
				alert('The file name is too long.  Please keep file names under 60 characters.');
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