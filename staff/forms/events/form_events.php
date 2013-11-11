<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$e = new Events($_GET['sel']);
		$action = "Update Events";	
    } else {
		$e = new Events();
		$action = "Add Event";
    }
	
    $g = new Gallery();
    $s = new Speakers();

    echo $e->pushToForm();
    $infoKey = md5(time().rand());

    $speaker_ids = array();

    foreach ($e->speakers as $speak) {
        $speaker_ids[] = $speak->speaker_id;
    }
?>

<script src="/js/libs/ajaxupload.js"></script>
<h3><?php echo $action; ?></h3>


<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>Event Setup</legend>
        <p>
            <label for="event_name">Event Name</label>
            <input type="text" name="event_name" id="event_name" />
        </p>
        <p>
            <label for="location">Town</label>
            <input type="text" name="location" id="location" />
        </p>
        <p>
            <?= Address::StateSelect('state_id', $e->state_id); ?>
        </p>
        <p>
            <label for="start_date">Start Date (mm/dd/yyyy)</label>
            <input type="text" name="start_date" id="start_date" />
        </p>
        <p>
            <label for="end_date">End Date (mm/dd/yyyy)</label>
            <input type="text" name="end_date" id="end_date" />
        </p>
        <p>
            <label for="content">Description</label>
            <textarea name="content" id="<?php echo $infoKey ?>" class="editorContent required"><?php echo $e->content; ?></textarea>
                <input type="hidden" id="content" />
        </p>
        <p>
            <label>Published</label>
            <select name="published" id="published">
                <option value="0">Unpublished</option>
                <option value="1">Published</option>
            </select>
        </p>
    </fieldset>
    <fieldset>
        <legend>Visual Details</legend>
        <p>
            <label for="color">Color Scheme</label>
            <?= $e->colorDropDown(); ?>
        </p>
             </fieldset>
     <fieldset>
         <legend>Band Details</legend>
         <p>
            <label for="band_name">Band</label>
            <input type="text" name="band_name" id="band_name"> 
         </p>
         <p>
            <label for="band_file">Band Image</label>
            <input type="text" name="band_file" id="band_file"> 
            <a class="uploadButton">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
            </a>
         </p>
         <p>
            <label for="band_twitter">Band Twitter</label>
            <input type="text" name="band_twitter" id="band_twitter"> 
         </p>
         <p>
            <label for="band_facebook">Band Facebook</label>
            <input type="text" name="band_facebook" id="band_facebook"> 
         </p>
    </fieldset>
    <fieldset>
        <legend>Drama Details</legend>
         <p>
            <label for="drama_name">Drama</label>
            <input type="text" name="drama_name" id="drama_name"> 
         </p>
         <p>
            <label for="drama_file">Drama Image</label>
            <input type="text" name="drama_file" id="drama_file"> 
            <a class="uploadButtonDrama">
                    <span class="ninjaSymbol ninjaSymbolPlus"></span>
                    <span class="text">Upload Image</span>
            </a>
         </p>
         <p>
            <label for="drama_twitter">Drama Twitter</label>
            <input type="text" name="drama_twitter" id="drama_twitter"> 
         </p>
         <p>
            <label for="drama_facebook">Drama Facebook</label>
            <input type="text" name="drama_facebook" id="drama_facebook"> 
         </p>
     </fieldset>

     <fieldset>
        <legend>Speakers</legend>
        <?php 
            $all = $s->allSpeakers();

            foreach ($all as $speaker) { 
                $checked = '';
                if (in_array($speaker->speaker_id, $speaker_ids)) {
                    $checked = 'checked="checked"';
                }
            ?>
           
           <div class="checkbox">
            <input type="checkbox" name="speakers[]" id="speakers" value="<?= $speaker->speaker_id ?>" <?= $checked; ?>> 
            <label for="speakers"><?= $speaker->speaker_name ?></label>
            </div>
                
        <?php } ?>
     </fieldset>

     <fieldset>
        <legend>Gallery</legend>
        <?= $g->gallerySelect(); ?>
        
     </fieldset>
    
    <fieldset>
    	<button name="users"><?php echo $action; ?></button>
        <input type="hidden" name="event_id" id="event_id" >
        <input type="hidden" name="class" id="class" value="events">
        <input type="hidden" name="create" id="create" value="forms/events/info_events.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>
<script type="text/javascript">
    tinyMCE.init({
        // General options
        mode : "textareas",
        theme : "advanced",
        editor_selector: "editorContent",
        plugins : "autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,preview,media,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking",

        // Theme options
        theme_advanced_buttons1 : "bold, italic, strikethrough, |, styleselect, formatselect, |, pasteword, |, bullist, numlist, blockquote, |, link, unlink, anchor, image, |, code, |, spellchecker, | ,pagebreak ",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "center",
        theme_advanced_resizing : true,

        content_css : "/css/tiny_styles.css",

        width: "600",
        height: "400"
    });


    var btnUpload=$('.uploadButton');
    var button = $('.uploadButton').html();

    new AjaxUpload(btnUpload, {
        action: '/ajax/ajax_upload.php',
        name: 'file_name',
        data: {'content': 1, 'folder':'event'},
        onSubmit: function(file, ext){
            btnUpload.html('<img src="/images/admin/ajax-loader.gif" alt="loading"/>');
            content = $('.editor').val();
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                // extension is not allowed
                alert('Only JPG, PNG, GIF,  files are allowed');
                btnUpload.html(button);
                return false;
            }

            if (file.length > 59) {
                alert('The file name is too long. Please keep the file name under 60 characters.');
                btnUpload.html(button);
                return false;
            }

            if (file.indexOf(' ') > 0) {
                alert('Please remove the spaces from the file name.')
                btnUpload.html(button);
                return false;
            }

        },
        onComplete: function(file, response){
            $('#band_file').val(response);
            btnUpload.html(button);
        }
    });



    var btnUpload=$('.uploadButtonDrama');
    var button = $('.uploadButtonDrama').html();

    new AjaxUpload(btnUpload, {
        action: '/ajax/ajax_upload.php',
        name: 'file_name',
        data: {'content': 1, 'folder':'events'},
        onSubmit: function(file, ext){
            btnUpload.html('<img src="/images/admin/ajax-loader.gif" alt="loading"/>');
            content = $('.editor').val();
            if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                // extension is not allowed
                alert('Only JPG, PNG, GIF,  files are allowed');
                btnUpload.html(button);
                return false;
            }

            if (file.length > 59) {
                alert('The file name is too long. Please keep the file name under 60 characters.');
                btnUpload.html(button);
                return false;
            }

            if (file.indexOf(' ') > 0) {
                alert('Please remove the spaces from the file name.')
                btnUpload.html(button);
                return false;
            }

        },
        onComplete: function(file, response){
            $('#drama_file').val(response);
            btnUpload.html(button);
        }
    });
</script>
