<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	$u = new Users($_SESSION['user_id']);
?>

<form id="formUpdate" method="POST">
	<fieldset>
        <legend>Report an Error</legend>
        <p>Please be very specific about how your recieved the error.</p>
        <p>
            <label for="error">Error</label>
            <textarea name="error" id="error"></textarea>
        </p>
        <p>
        	<input type="hidden" name="reportError" id="reportError" value="1" />
            <input type="hidden" name="errorId" id="errorId" value="<?php echo $u->user_id ?>" />
            <button type="submit">Report Error</button>
        </p>
     </fieldset>   
</form>
<div class="data"></div>

<script>
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
</script>