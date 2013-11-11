<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$fp = new Frontpage($_GET['sel']);
		$action = "Update Front Page";	
    } else {
		$fp = new Frontpage();
		$action = "Add Front Page";
    }
	
	
	$infoKey = md5(time().rand());
	echo $fp->pushToForm();
?>


<h3><?php echo $action; ?></h3>

<form id="formUpdate" method="POST" class="frontpageForm">
    <fieldset>
        <legend>Front Page Details</legend>
        <p>
            <label for="title">Front Page Title</label>
            <input type="text" name="title" id="title" />
        </p>
        <p>
            <label for="link">Front Page Link</label>
            <input type="text" name="link" id="link">
        </p>
        <p>
            <label for="image">Image (1140X 480) </label>
            <input type="text" name="image" id="image" />
        </p>
        
        <div class="twoDropDowns clearfix">
            <p>
                <label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>
                
            </p>
        </div>

        <p class="textarea">
            <label for="content">Content</label>
            <textarea name="content" id="<?php echo $infoKey ?>" class="editorContent required"><?php echo $fp->content; ?></textarea>
            <input type="hidden" id="content" />
        </p>
     
     
    
    <fieldset>
    	<button name="fronpage"><?php echo $action; ?></button>
        <input type="hidden" name="page_id" id="page_id" />
        <input type="hidden" name="addFrontPage" id="addFrontPage" value="forms/frontpage/info_frontpage.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>
<script>
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
    
</script>

