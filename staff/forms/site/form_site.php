<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	
	$site = new Site();
	echo $site->pushToForm();
	
	$link = 'forms/site.php';
?>

<form id="formUpdate" method="POST">
	<fieldset>
        <p>
            <label for="siteName">Site Name (required)</label>
            <input type="text" name="siteName" id="siteName" autofocus class="required" />
            <input type="hidden" name="site_id" id="site_id" value="1" />
        </p>
        
        <p>
            <label for="siteURL">Site URL (required)</label>
            <input type="text" name="siteURL" id="siteURL" class="required" />
        </p>
        
        <p>
            <label for="siteDescription">Site Description</label>
            <textarea name="siteDescription" id="siteDescription"></textarea>
        </p>
        
        <p>
            <label for="keywords">Keywords (seperate with comma)</label>
            <input type="text" name="keywords" id="keywords" />
        </p>
        
        <p>
            <label for="googleCode">Google Analytics Site Number</label>
            <input type="text" name="googleCode" id="googleCode" />
        </p>
        
        <p>
            <button name="siteSettings" id="siteSettings">Submit</button>
            <input type="hidden" name="siteForm" id="siteForm" value="forms/site/info_site.php" />
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
        theme_advanced_buttons1 : "",
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