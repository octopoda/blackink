<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); 
    require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php');
	
    if (isset($_SESSION['user_id'])) {
        $u = new Users($_SESSION['user_id']);
    }
	
?>

<section class="mainContent">
    <div class="row">
    <article class="eightcol">
<h2>Change Password for <?php echo $u->printName(); ?></h2>

<form id="formRedirect" method="POST" >
    <fieldset class="step">
        <h3>New Password</h3>
        <p>
            <label for ="newPass">New Password</label>
            <input id="newPass" name="newPass" type="password" class="required" />
            
        </p>
        <p>
            <label for ="verifyPass">Verify Password</label>
            <input id="verifyPass" name="verifyPass" type="password" class="equalTo" />
        </p>
    </fieldset>
    
    
    <fieldset class="step">
        <p>
            A box marked in red indicates that a field
            is missing data or filled out with invalid data.
        </p>
        <p class="submit">
        	<input type="hidden" name="user_id" value="<?php echo $u->user_id ?>">
           <input type="hidden" name="changePassword" value="/users/profile.html"  />
           <button type="submit">Change Password</button>
        </p>
    </fieldset>
</form>
 </article>
    
    <aside class="fourcol last">
        <?php include(MODULES.'sidebar.php'); ?>
    </aside>
    </div>
</section>
<div class="data"></div>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>     