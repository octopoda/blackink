<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
	$phones = new Phones();
?>

<section class="mainContent">
	<div class="row">
    <article class="eightcol">
    <!--<a class="fillJoin">Fill Form</a> -->
    <h2>Join our Site</h2>
    	<form id="formRedirect" method="POST">
    <fieldset>
        <h3>Personal Details</h3>
        <p>
            <label for="first">First Name:</label>
            <input name="first" id="first" type="text" class="required" />
        </p>
        <p>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last" class="required" />
        </p>
        <p>
            <label for="company">Company Name:</label>
            <input type="text" name="company" id="company" class="required" />
        </p>
        <p>
            <label for="NPINumber">NPI Number:</label>
            <input type="text" name="NPINumber" id="NPINumber" class="required" />
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"  class="email" />
        </p>
        
         </p>
            <?php echo $phones->createPhoneFields(); ?>
        <p>
        
    </fieldset>
    <fieldset>
        <h3>Location Details</h3>
        <p>
            <label for="address1">Address</label>
            <input id="address1" name="address1" type="text"  class="required"   />
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
            <?php echo Address::stateSelect('state_id'); ?>
        </p>
         <p>
            <label for="zip">Zip Code</label>
            <input name="zip" id="zip" type="text" class="zip" placeholder="90210" />
        </p>
        </p>
            
        <p>
    </fieldset>
    
    <fieldset>
        <h3>Authentication Details</h3>
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
            <input type="hidden" name="registerUser" value="1" />
        </p>
        <p class="formMessage"></p>
    </fieldset>
</form>
    </article>
    
    <aside class="fourcol last">
    	<?php include(MODULES.'sidebar.php'); ?>
    </aside>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       