<?php
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');

	$social = new Social();

	echo $social->pushToForm();

?>

<form id="formUpdate" method="POST">
	 <fieldset>
     	<legend>Social Network URLs</legend>

        <p>
            <label for="facebook_url">Facebook URL: </label>
            <input id="facebook_url" name="facebook_url" type="text"  class=""   />
            <input type="hidden" name="social_id" id="social_id" />
        </p>
        <p>
            <label for="twitter_url">Twitter URL</label>
            <input id="twitter_url" name="twitter_url" type="text"   />
        </p>
        <p>
            <label for="linkedin_url">Linked In URL</label>
            <input type="text" name="linkedin_url" id="linkedin_url"  class=""  />
        </p>
        <p>
            <label for="google_url">Google + URL</label>
            <input type="text" name="google_url" id="google_url"  class=""  />
        </p>
         <p>
            <label for="tumblr_url">Tumblr URL</label>
            <input type="text" name="tumblr_url" id="tumblr_url"  class=""  />
        </p>
        <p>
            <label for="foursquare_url">Four Square URL</label>
            <input type="text" name="foursquare_url" id="foursquare_url"  class=""  />
        </p>
        <p>
            <label for="last_fm_url">Last FM URL</label>
            <input type="text" name="last_fm_url" id="last_fm_url"  class=""  />
        </p>

        <p>
            <button name="socialSettings" id="socialSettings">Submit</button>
            <input type="hidden" name="class" id="class" value="social" />
            <input type="hidden" name="create" id="create" value="forms/site/info_social.php?sel=" />
        </p>

    </fieldset>
</form>
<div class="data"></div>

