<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
	$user = new Users($_SESSION['user_id']);
    $address = new Address($user->address_id);
    $phones = new Phones($user->user_id);


?>

<section class="mainContent profile">
	<div class="row">
    <article class="eightcol">
    <h1><?php echo $user->printName(); ?></h1>
    <h3>Your Information</h3>
    <dl class="clearfix">
        <dt>Email: </dt>
        <dd><?php echo $user->email; ?></dd>
        <dt>Company</dt>
        <dd><?php echo $user->company ?></dd>
        <dt>NPI Number:</dt>
        <dd>xxxxxxxxxx </dd>
        <dt>Phone(s):</dt>
        <dd><?php echo $phones->printPhones(); ?></dd>
        <dt>Address:</dt>
        <dd><?php echo $address->printAddress(); ?></dd>
    </dl>	
    
    <div class="buttonSet" >
        <a class="button" href="/users/update_user.html">Change my Information</a>
        <a class="button" href="/users/changePassword.html">Change Password</a>
    </div>
    
    
</form>
    </article>
    
    <aside class="fourcol last">
    	<?php include(MODULES.'sidebar.php'); ?>
    </aside>
    </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>        
       