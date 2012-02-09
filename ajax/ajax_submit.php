<?php

require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/require.php');

//print_r($_POST);

if (isset($_POST['login'])) {
	$user = new Users();
	
	$email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $err = NULL;
	$refer = NULL;    
	
	if ($user->authenticate($email, $password) == false) {
	    $err = "The email / password you've given do not match anything in our system.";
    }
	
	 if ($user->isLoggedIn()) {      // did we authenticate / are we already logged in?
       $refer = $_POST['refer'];
    }
	
	echo json_encode(array(
		'error'=> $err,
		'refer'=> $refer
	));
}	


if (isset($_POST['registerUser'])) {
	$user = new Users();

	$create = $user->createUserFromForm($_POST); //Create User
	$saveUser = new Users($create);
	
	if ($user->authenticate($_POST['email'], $_POST['password'])) {
		if ($user->isLoggedIn()) redirect('/index');	
	}
	//Log in User	
}


if (isset($_POST['sendEmail'])) {
	$contact = new contactInformation();
	
	if (!isset($_POST['real'])) {
		echo "You are trying to spam us.  Please go away."; 
		return;
	}

	if ($contact->emailCompany($_POST)) {
		echo 'Your email has been sent.  Please give us 2-3 buisness days to respond.';	
	} else {
		echo "Something has gone wrong.  Please try to contact us by phone. "; 
	} 
}


if (isset($_GET['searchAutoComplete'])) {
	$display = new Display();
	$result = $display->titleSearch($_GET['q']);
	foreach($result as $row) {
		 echo $row['title']."\n";
	} 	
}

if (isset($_POST['search'])) {
	$display = new Display();
	$display->siteSearch($_POST['search'], $_POST['pageNumber']);
	
}

if (isset($_POST['forgotPassword'])) {
	echo Users::forgotPassword($_POST['email']);	
}

if (isset($_POST['changePassword'])) {
	$user = new Users($_POST['user_id']);
	$user->changePassword($_POST['newPass']);
	redirect('index.php');
}


if (isset($_POST['refill'])) {
	global $error;
	
	$refill = new Refills();
	$id = $refill->createRefillFromForm($_POST);
	
	if ($id != false) {
		$error->addMessage('You refill request has been sent.');	
	} else {
		$error->addMessage('Sorry there was an error with your refill. Please contact us for further information.');
	}
}


if (isset($_POST['supplementAlpha'])) {
	$supplement = new Supplements();
	$searchArray = $supplement->alphaSearch($_POST['supplementAlpha']);
	
	$html = '';
	
	if ($searchArray != false) {
		foreach ($searchArray as $product) {
			$html .= $supplement->displayPreviewSupplement($product);	
		}
	} else {
		$html .= '<h4>There are no products in your search.</h4>';	
	}
	
	echo $html;
}	





if (isset($_POST['addToCart'])) {
	$cart = new ShoppingCart();
	$cart->addToCart($_POST['addToCart']);
	
	$mini = $cart->miniCart();
	$button = "The item was added.";
	
	echo json_encode(array(
		'mini'=> $mini,
		'button'=> $button
	));
}


if (isset($_POST['changeQuantity'])) {
	$cart = new ShoppingCart();
	$supplement = new Supplements($_POST['ItemNumber']);
	$cart->changeQuantity($_POST['ItemNumber'], $_POST['changeQuantity']);
	
	$price = '$'.number_format($supplement->MSRP*$_POST['changeQuantity'], 2);
	$mini = $cart->miniCart();
	$total = '$'.$cart->totalPrice();
	
	echo json_encode(array(
		'singlePrice'=>$price,
		'mini'=>$mini,
		'totalPrice'=>$total
	));
		
}

if (isset($_POST['removeProduct'])) {
	$cart = new ShoppingCart();
	
	unset($_SESSION['cart'][$_POST['ItemNumber']]);	
	
	$mini = $cart->miniCart();
	$total = '$'.$cart->totalPrice();
	
	echo json_encode(array(
		'mini'=>$mini,
		'totalPrice'=>$total
	));
}





if (isset($_POST['unsetSession'])) {
	unset($_SESSION['cart']);
	echo 'Session Unset';	
}

?>