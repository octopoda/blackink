<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	$contact = new contactInformation();
?>

<ul class="quickMenu">
	<li><a href="forms/site/form_contact.php" class="redirect">
    		<span class="ninjaSymbol ninjaSymbolEdit"></span> 
        	<span class="text">Edit Information</span>
         </a></li>
</ul>

<h3 class="floatLeft">Company Contact Information</h3>

<div>
	<h4>About Your Company</h4>
	<dl class="clearfix">
    	<dt>Company Description:</dt>
        	<dd><?php echo $contact->summary; ?></dd>
    </dl>
 	
 	<h4>Contact Information</h4>
    <dl class="clearfix">
    	<dt>Company Email:</dt>
        	<dd><?php echo $contact->email; ?></dd>
        <dt>Company Address:</dt>
        	<dd><?php echo $contact->address->printAddress(); ?></dd>
		<dt>Phone Number:</dt>
        	<dd><?php echo $contact->phonenumber; ?></dd>
        <dt>Fax Number:</dt>
        	<dd><?php echo $contact->faxnumber; ?></dd>
    </dl>
</div>

<div class="data"></div>

