<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$s = new Speakers($_GET['sel']);
		$action = "Update Speaker";	
    } else {
		$s = new Speakers();
		$action = "Add Speaker";
    }
	
	echo $s->pushToForm();
    $infoKey = md5(time().rand());
?>

<script src="/js/libs/ajaxupload.js"></script>
<h3><?php echo $action; ?></h3>

<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>Speaker Details</legend>
        <p>
            <label for="speaker_name">Speaker Name</label>
            <input type="text" name="speaker_name" id="speaker_name" />
        </p>
        <p>
            <label for="speaker_image">Speaker Image</label>
            <input type="text" name="speaker_image" id="speaker_image" />
            <a class="uploadButton">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
            </a>
        </p>
        <p>
            <label for="bio">Biography</label>
            <textarea name="bio" id="<?php echo $infoKey ?>" class="editorContent required"><?php echo $s->bio; ?></textarea>
            <input type="hidden" id="bio" />
        </p>
        <p>
            <label for="facebook">Facebook Link:</label>
            <input type="text" name="facebook" id="facebook">
        </p>
        <p>
            <label for="twitter">Twitter Link:</label>
            <input type="text" name="twitter" id="twitter">
        </p>
        
     </fieldset>
     
    
    <fieldset>
    	<button name="users"><?php echo $action; ?></button>
        <input type="hidden" name="speaker_id" id="speaker_id" />
        <input type="hidden" name="class" id="class" value="speakers"/>
        <input type="hidden" name="create" id="create" value="forms/events/info_speakers.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>
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

        content_css : "/css/tiny_styles.css",

        width: "600",
        height: "400"
    });

    tinyMCE.triggerSave();

    var btnUpload=$('.uploadButton');
    var button = $('.uploadButton').html();

    new AjaxUpload(btnUpload, {
        action: '/ajax/ajax_upload.php',
        name: 'file_name',
        data: {'content': 1, 'folder': 'speakers'},
        onSubmit: function(file, ext){
            btnUpload.html('<img src="/images/admin/ajax-loader.gif" alt="loading"/>');
            
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                // extension is not allowed
                alert('Only JPG, PNG, GIF,  files are allowed');
                btnUpload.html(button);
                return false;
            }

            if (file.length > 59) {
                alert('The file name is too long. Please keep the file name under 60 characters.');
                btnUpload.html(button);
                return false;
            }

            if (file.indexOf(' ') > 0) {
                alert('Please remove the spaces from the file name.')
                btnUpload.html(button);
                return false;
            }

        },
        onComplete: function(file, response){
            $('#speaker_image').val(response);
            btnUpload.html(button);
        }
    });
</script>

