<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/errors.php');

	if (isset($_GET['sel'])) {
		
	} else {
		
	}
	
	$link = 'forms/site.php';
?>


<fieldset>
	<p>
    	<label for="siteName">Site Name (required)</label>
        <input type="text" name="siteName" id="siteName" autofocus required  />
    </p>
    
    <p>
    	<label for="siteDescription">Site Description</label>
        <textarea name="siteDescription" id="siteDescription"></textarea>
    </p>
    
    <p>
    	<label for="googleCode">Google Analytics Site Number</label>
        <input type="text" name="googleCode" id="googleCode" />
    </p>
    <p>
		<button name="siteSettings" id="siteSettings">Submit</button>
    </p>

</fieldset>