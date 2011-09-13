<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php');
	
	unset($_SESSION['errors']);
	
	$content = new Content();
	$content->listObjects();
	
?>


<h3 class="floatLeft">Site Content</h3>
<p><?php if (isset($_SESSION['error'])) echo $_SESSION['error']; ?></p>

<div class="header floatLeft">
	<fieldset>
    	<input type="search" value="search..." name="contentSearch" />
	</fieldset>
</div>

<div class="list">
	<table class="listing">
    	<thead>
        <tr class="tableHeader">
        	<td>Title</td>
            <td>Published</td>
            <td>Last Modified</td>
            <td>Author</td>
        </tr>
        </thead>
        <tbody>
        <?php foreach($content->objectList as $list) { ?>
            <tr>	
                <td class="<?php echo $list->title ?> title">
                    <a class="edit" href="forms/content/form_content.php?sel=<?php echo $list->content_id ?>" sel="<?php echo $list->content_id ?>">
                        <?php echo $list->title; ?>
                    </a>
                </td>
                <td><?php echo $list->published($list->content_id); ?></td>
                <td><?php echo $content->displayDate($list->modified_on); ?></td>
                <td><?php $users = new Users(); $users->getUserById($list->user_id); echo $users->printName(); ?></td>
                         	   
            </tr>
        <?php } ?>
        </tbody>
       </table>

</div>
<div class="data">
</div>

