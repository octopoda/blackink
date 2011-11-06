<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
?>

<header>
	<hgroup>
    	<h1><a href="/index.php"><?php echo $site->siteName; ?></a></h1>
    </hgroup>
	<nav>
    	<?php $display->displayMenu('Quick Menu'); ?>
    </nav>
    
    
</header>
<section>
	<nav>
    	<?php $display->displayMenu('Main Menu'); ?>
    </nav>
</section>
<div class="mainContent">
	<section>
    <h3>Join our Site</h3>
    	<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>Personal Details</legend>
        <p>
            <label for="first">First Name:</label>
            <input name="first" id="first" type="text" class="required" />
        </p>
        <p>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last" class="required" />
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email"  class="required email" />
        </p>
        <p>
            <label for="NPINumber">NPI Number:</label>
            <input type="text" name="NPINumber" id="NPINumber" class="required numeric" />
        </p>
        <p>
            <label for="company">Company</label>
            <input type="text" name="company" id="company" class="required" />
        </p>
        
    </fieldset>
    <fieldset>
        <legend>Location Details</legend>
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
        </p>
            
        <p>
    </fieldset>
    
    <fieldset>
        <legend>Authentication Details</legend>
        <p>
            <label for="password">Password</label>
            <input id="password" name="password" type="password"  class="required"  />
        </p>
        <p>
            <label for="confirmPassword">Confirm Password</label>
            <input id="confirmPassword" name="confirmPassword" type="password" class="equalTo"  />
        </p>
    </fieldset>
    <fieldset>
    	<p>
        	<button id="submit" name="addUser">Join Now</button>
        </p>
    </fieldset>
</form>
    </section>
    
    <aside>
    </aside>
</div>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       