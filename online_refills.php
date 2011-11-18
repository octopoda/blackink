<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/require.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/header.php'); ?>
<?php 
	$site = new Site();
?>
<section class="mainContent">
  <div class="row">
  <article>
    <h1>Online Refills</h1>
    
    
    <form id="formSubmit" method="POST">
		<fieldset>
            <p>
                <label for="name">Name:</label>
                <input type="text" name="name" maxlength="30" class="required" />
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" class="email" />
            </p>
            <p>
                <label for="Phone">Phone:</label><br />
                <input type="text" name="phone" class="usPhone"/>
            </p>
            <p>
                <label for="email">Prescription Number:</label><br />
                <input type="text" name="number" class="prescription"/>
            </p>
        </fieldset>
        
        <fieldset>
            <p>
                <label>Method of Pickup</label><br />
                <select name="delivery" id="delivery">
                    <option value="1">Pick-Up</option>
                    <option value="2">Delivery</option>
                </select>
            </p>
        
            <p>
                <label for="special">Special Message:</label> <br />
                <textarea rows="10" cols="40" name="special" maxlength="400"><?php if(isset($special)) {echo $special; } ?></textarea>
            </p>
        </fieldset>
        
        
        <p>
        	<input type="hidden" name="refill" id="refill"  />
            <button type="submit" class="hey" >Send Request</button>
        </p>

        <p>Please allow a full 24 hours for processing of your prescription.<p>	
		</form>	
        
        <div class="data"></div>
  </article>
  <aside>
  	<?php include(MODULES.'sidebar.php'); ?>
  </aside>
  </div>
</section>


<?php require_once($_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'); ?>
