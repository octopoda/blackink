<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/includes/header.php');
	$site = new Site();
    
    if (isset($_SESSION['user_id'])) redirect('index.php');
?>


<section class="login">
    <div>
    <header class="clearfix">
        <hgroup>
        	<h1><a href="/index.php" class="logo"><?php echo $site->siteName ?></a></h1>
        </hgroup>
    </header>
    <form method="post" name="login" id="formSubmit">
        <fieldset >
            <legend><?php echo $site->siteName ?> Login</legend>
            <p>
                <label for="email">Email</label>
                <input type="type" name="email" id="email" autocomplete="off" />
            </p>
            <p>
                <label for="password">Password</label>	
                <input type="password" name="password" id="password" autocomplete="off" />
                <input type="hidden" name="login" value="1" />
            </p>
            <p>
                <button id="login" name ="login" type="submit" >Log In</button>
            </p>
            <p class="message"></p>
        </fieldset>
    </form>
    <nav>
    	<ul>
    		<li><a href="/forgot_password.html">Forgot Password</a></li>
    	</ul>
    </nav>
    
</section>

<?php 
    require_once('includes/footer.php'); 
?>