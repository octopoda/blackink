<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/staff/includes/admin_require.php');
	
	if (!empty($_GET['sel'])) {
		$v = new Videos($_GET['sel']);
		$action = "Update Video";	
        $class = "updateVideo";
		
	} else {
		$v = new Videos();
		$action = "Add Video";
        $class = "addVideo";	
	}
	
	
	
	echo $v->pushToForm();
?>


<h3><?php echo $action; ?></h3>

<form id="formUpdate" method="POST" class="usersForm">
    <fieldset>
        <legend>Video Details</legend>
        <p>
            <label for="title">Video Title</label>
            <input type="text" name="title" id="title" />
        </p>
        <p>
            <label for="shareLink">Video Link</label>
            <input type="text" name="shareLink" id="shareLink">
        </p>
        <p>
            <label for="posterImage">Poster Image</label>
            <input type="text" name="posterImage" id="posterImage" />
        </p>
        
        <div class="twoDropDowns clearfix">
            <p>
                <label>Published</label>
                <select name="published" id="published">
                    <option value="0">Unpublished</option>
                    <option value="1">Published</option>
                </select>
                
            </p>
            
            <p class="new">
                <label for="access">Access:</label>
                <?php echo $v->accessDropDown($v->video_id) ?>
            </p>
        </div>
     
     
    
    <fieldset>
    	<button name="users"><?php echo $action; ?></button>
        <input type="hidden" name="video_id" id="video_id" />
        <input type="hidden" name="publishDate" id="publishDate" />
        <input type="hidden" name="addVideo" id="addVideo" value="forms/videos/info_videos.php?sel=" />
    </fieldset>

</form>

<div class="data"></div>


