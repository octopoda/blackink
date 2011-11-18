<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); ?>
<?php 
	$site = new Site();
?>

<section class="mainContent">
  <div class="row">
  <article>
    <h2>Contact Us</h2>
    
    <address>
    	<?php $display->printAddress(); ?>
    </address>
    
    <p class="phones">
    	<?php $display->printPhones(); ?>
    </P>
    <form id="formSubmit" method="POST">
      <fieldset>
        <p>
          <label for="name">Name:</label>
          <input type="text" name="name" id="name" class="required" autocomplete="off" />
        </p>
        <p>
          <label for="email">Email:</label>
          <input type="email" name="email" id="email" class="email" autocomplete="off" />
        </p>
        <p class="honeyPot">
        </p>
        <p>
          <label for="phone">Phone:</label>
          <input type="phone" name="phone" id="phone"  placeholder="e.g. (972) 867-5309" autocomplete="off" />
        </p>
        <p>
          <label for="subject">Subject:</label>
          <input type="type" name="subject" id="subject" class="required" autocomplete="off" />
        </p>
        <p>
          <label for="message">Message:</label>
          <textarea type="text" name="message" id="message" class="required" autocomplete="off" rows=10 ></textarea>
        </p>
        <p class="submitArea">
          <input type="hidden" name="sendEmail" value="1" />
          <button name="sendEmail" id="sendEmail" class="button" >E-Mail Us.</button>
        </p>
        <p class="message"> </p>
      </fieldset>
    </form>
  </article>
  <aside>
  	<?php include(MODULES.'sidebar.php'); ?>
  </aside>
  </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
