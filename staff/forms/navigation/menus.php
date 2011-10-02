<?php 
	require_once($_SERVER['DOCUMENT_ROOT']. '/staff/includes/admin_require.php'); 
	require_once($_SERVER['DOCUMENT_ROOT']. '/includes/errors.php');

	if (isset($_GET['sel'])) {
		
	} else {
		
	}
	
	$menu = new Menus();
	$link = '/staff/forms/navigation/menus.php';
	
?>

<script>
	$(function () {
		$('#addMenu').hide();
		
		$('.quickMenu .addMenu').click(function () {
			$('#addMenu').slideDown(800);	
		})
	});
</script>



<section>
<h3>Menus</h3>
<p>Double click on the title to edit the Menu name.</p>

<ul class="quickMenu">
	<li><a class="addMenu">
		<span class="ninjaSymbol ninjaSymbolPlus"></span>
		<span class="text"> Add Menu</span>
		</a>
	</li>
</ul>
<div class="list">
	<table class="navigationList">
    	<thead>
        	<tr>
            	<th>Title</th>
                <th width="80">Published</th>
                <th width="100">Access</th>
                <th>Delete</th>
            </tr>
        </thead>
    	<tbody>
    
	<?php  
		$menu->listMenus();
		if ($menu->menuList != false) {
		foreach ($menu->menuList as $list) {	?>
			<tr>
				<td class="menus"><a id="<?php echo $list->menu_id ?>" title="menu_name" href="<?php echo $link ?>" class="quickEdit"><?php echo $list->menu_name; ?></span></td>
				<td><?php echo $list->published($list->menu_id); ?></td>
				<td><?php echo $list->accessDropDown($list->access, $list->menu_id); ?></td>
				<td><a class="delete ninjaSymbol ninjaSymbolClear" id="menus" sel="<?php echo $list->menu_id ?>" href="<?php echo $link ?>"></a></td>
			</tr>
	
	<?php } } else {?>
    		<tr>
            	<td colspan="4">There are no menus in your database.  Please add a menu.</td>
            </tr>
    <?php } ?>
	</tbody>
    </table>
</div>
</section>


<section id="addMenu">

<h3>Add Another Menu</h3>

<form id="formUpdate">
	<fieldset>
		<p>
			<label for="menu_name">Menu Name</label>
			<input type="text" maxlength="60" id="menu_name" name="menu_name"  />
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
			<?php echo $menu->accessDropDown(1) ?>
		</p>
		</div>
		<p>
			<button type="submit">Add Menu</button>
            <input type="hidden" name="addMenu" value="<?php echo $link ?>" />
		</p>
	</fieldset>
</form>


</section>
<div class="data">
</div>

