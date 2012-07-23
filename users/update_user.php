<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
	

    if (isset($_SESSION['user_id'])) {
        $user = new Users($_SESSION['user_id']);
        $address = new Address($user->address_id);
        $phone = new Phones($user->user_id);
        $action = 'Update my Information';
    } else {
        echo '<section class="mainContent"><div class="row"><h2>There is no user to be updated.  Please try again.</h2></div></section>';
        require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php');  
        return;
    }

    function printIt($item) {
        if (isset($item)) {
            echo $item;
        } else {
            return false;
        }
    }
?>

<section class="mainContent">
	<div class="row">
    <article class="eightcol">
    <h2>Update My Information</h2>
    	<form id="formRedirect" method="POST">
    <fieldset>
        <h3>Personal Details</h3>
        <p>
            <label for="first">First Name:</label>
            <input name="first" id="first" type="text" class="required" value="<?php printIt($user->first); ?>" />
        </p>
        <p>
            <label for="last">Last Name:</label>
            <input type="text" name="last" id="last" class="required" value="<?php printIt($user->last); ?>"/>
        </p>
        <p>
            <label for="company">Company:</label>
            <input type="text" name="company" id="company" class="required" value="<?php printIt($user->company); ?>"/>
        </p>
        <p>
            <label for="NPINumber">NPINumber:</label>
            <input type="text" name="NPINumber" id="NPINumber" class="required" value="<?php printIt($user->NPINumber); ?>"/>
        </p>
        <p>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email"  class="email" value="<?php printIt($user->email); ?>" />
        </p>
        
         </p>
            <?php echo $phone->createPhoneFields(); ?>
        <p>
        
    </fieldset>
    <fieldset>
        <h3>Location Details</h3>
        <p>
            <label for="address1">Address:</label>
            <input id="address1" name="address1" type="text"  class="required" value="<?php printIt($address->address1); ?>"   />
            <input type="hidden" name="address_id" id="address_id" value="<?php printIt($address->address_id); ?>" />    
        </p>
        <p>
            <label for="address2">Address 2:</label>
            <input id="address2" name="address2" type="text"  value="<?php printIt($address->address2); ?>" />
        </p>
        <p>
            <label for="city">City:</label>
            <input type="text" name="city" id="city"  class="required" value="<?php printIt($address->city); ?>"  />
        </p>
         <p>
            <label for="state">State:</label>
            <?php echo Address::stateSelect('state_id', $address->state_id); ?>
        </p>
         <p>
            <label for="zip">Zip Code:</label>
            <input name="zip" id="zip" type="text" class="zip" placeholder="90210" value="<?php printIt($address->zip); ?>" />
        </p>
        </p>
            
        <p>
    </fieldset>
    <fieldset>
    	<p>
        	<button id="submit">Update User</button>
            <input type="hidden" name="registerUser" value="1" />
            <input type="hidden" name="user_id" id="user_id" value="<?php printIt($user->user_id); ?>"/>
        </p>
        <p class="formMessage">
        </p>
    </fieldset>
    
</form>
    </article>
    
    <aside class="fourcol last">
    	<?php include(MODULES.'sidebar.php'); ?>
    </aside>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       