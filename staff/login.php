<?php
	require_once('includes/header.php');
	
    $user = new Users();

    if (isset($_SESSION['user_id'])) redirect('index.php');

	//Clear out email and password
	$email = '';
	$password = '';
    
    if (isset($_POST['login'])) {   // We got our form back - process it
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        if ($user->authenticate($email, $password) == false)
        {
            $msg = "The email / password you've given do not match anything in our system.";
        }
    }
    
    if ($user->isLoggedIn()) {      // did we authenticate / are we already logged in?
        redirect('index.php'); 
        exit;        
    }


	if (isset($_POST['forgot'])) {
		$msg = forgotPassword($_POST['forgot_email'], "camper");	
	}


?>
<div id="loginWrapper">
    <div id="header" class="clearfix">
        <h1><a href="http://cadencegeneralcontracting.com" class="logo">Cadence General Contracting Services LLC.</a></h1>
        <h2>Admin Login</h2>
    </div>
    <div id="login">
    <form method="post" name="login">
        <fieldset class="steps">
            <legend>Lift Admin Login</legend>
            <p>
                <label for="email">Email</label>
                <input type="type" name="email" id="email" autocomplete="off" />
            </p>
            <p>
                <label for="password">Password</label>	
                <input type="password" name="password" id="password" autocomplete="off" />
            </p>
            <p>
                <button id="login" name ="login" type="submit" >Log In</button>
            </p>
            <p class="loginError">
                <?php  if (isset($msg)) echo $msg; ?>
            </p>
        </fieldset>
    </form>
    </div>
    
 </div>

<?php 
    require_once('includes/footer.php'); 
?>