<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	$media = new Media();
?>
<script src="/js/mylibs/ajaxupload.js"></script>
    
        
        
  	<h3>Upload a new File</h3>
    <p>Click upload file to start your upload.  Please prepare the file by replacing all spaces with underscores and making sure it under 60 characters long.  You can only upload these formats:</p>
    <ul class="extensionsList">
    	<li>jpg</li>
        <li>png</li>
        <li>jpeg</li>
        <li>gif</li>
        <li>pdf</li>
        <li>doc</li>
        <li>docx</li>
    </ul>
    
	<div class="uploadButton">
		<button id="upload" class="" sel="" >Upload File</button>
  		<p id="status" class="error"></p>
    	<p class="response"></p>
    	<ul id="files" ></ul>
    </div>
<script type="text/javascript">
	
	//Upload Images
$(document).ready(function () { 

		var btnUpload=$('#upload');
		var status=$('#status');
		
		new AjaxUpload(btnUpload, {
			action: '/ajax/ajax_upload.php',
			name: 'file_name',
			data: {'media': 1, 'link': 'forms/media/media.php'},
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif|pdf|doc|docx)$/.test(ext))){ 
					// extension is not allowed
					status.text('Only JPG, PNG, GIF, DOC, DOCX, or PDF files are allowed');
					return false;
				}
				$('#status').text('Uploading...');
			},
			onComplete: function(file, response){
				$('#status').text('');
				$('.response').html(response);
				redirect(response);
			}
		});
});
	
</script>


