<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	
	$contact = new contactInformation();
	$address = new Address($contact->address_id);
	
	echo $contact->pushToForm();
	echo $address->pushToForm();
	
	$infoKey = md5(time().rand());
	
?>

<form id="formUpdate" method="POST">
	<fieldset>
        <legend>About Your Company</legend>
        
        <p>
            <label for="summary">Company Description</label>
            <textarea name="summary" id="<?php echo $infoKey ?>"><?php echo !empty($contact->summary) ? $contact->summary : '' ?></textarea>
        </p>
     </fieldset>   
        
     <fieldset> 
     	<legend>Company Location</legend>  
        
        <p>
            <label for="address1">Address</label>
            <input id="address1" name="address1" type="text"  class="required"   />
            <input type="hidden" name="address_id" id="address_id" /> 
        </p>
        <p>
            <label for="address2">Address 2</label>
            <input id="address2" name="address2" type="text"   />
        </p>
        <p>
            <label for="city">City</label>
            <input type="text" name="city" id="city"  class="required"  />
        </p>
         <p>
            <label for="state">State</label>
            <?php echo Address::stateSelect(); ?>
        </p>
         <p>
            <label for="zip">Zip Code</label>
            <input name="zip" id="zip" type="text" class="zip" placeholder="90210" />
        </p>
     </fieldset>   
     <fieldset>
     	<legend>Company Contacts</legend>   
       <p>
            <label for="email">Contact Email (required)</label>
            <input type="text" name="email" id="email" class="email" />
        </p>
       	
       </p>
            <label for="phonenumber">Company Phone</label>
            <input type="tel" class="usPhone" id="phonenumber" name="phonenumber" />
        <p>
        
        </p>
            <label for="faxnumber">Company Fax</label>
            <input type="tel" class="usPhone" id="faxnumber" name="faxnumber" />
        <p>
        
        <p>
            <button name="siteSettings" id="siteSettings">Submit</button>
            <input type="hidden" name="contactForm" id="contactForm" value="forms/site/info_contact.php" />
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