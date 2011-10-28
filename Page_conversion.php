<?php
	require('includes/require.php');
	
	
	$innovation = new mysqli("localhost", "root", "root", "innovation");
	
	
//Page Content Conversion
	/*$innovation = new mysqli("localhost", "root", "root", "innovation");
	
	$sql = "SELECT * FROM PageContent";
	$result = mysqli_query($innovation, $sql);
	
	while ($row = mysqli_fetch_array($result)) {
		$pageContent = $db->escapeString($row['content']);
		
		$sql = 'INSERT INTO content (user_created, created_on, published, title, access, content, link_to, modified_on) VALUES (2, "2011-09-09 12:00", 1, "'.$row['page_name'].'", "everyone", "'. $pageContent.'", "", "2011-09-09 12:00" )';
		
		$db->query($sql);	
	} */





	
//Add Conversion
	/*$sql = "SELECT * FROM ads";
	$result = mysqli_query($innovation, $sql);
	$nTimes = 0;
	while($row = mysqli_fetch_array($result)) {
		$content = $db->escapeString($row['detail']);
		$summary = $db->escapeString($row['content']);	
		
		$sql = "INSERT INTO ads (title, published, position, user_id, placement, summary, content) VALUES ('".$row['title']."', 1, '".$nTimes."', 14, 3, '".$content."', '".$summary."')";
		$db->query($sql);
		$nTimes++;
	}
	
	echo 'complete';*/


//Navigation Content Conversion 
	/*$sql = "SELECT * FROM users U 

			JOIN master_name M ON U.userID = M.userId 
			JOIN address A ON U.userId = A.userId
			JOIN phone P ON U.userId = P.userId";
	$result = mysqli_query($innovation, $sql);
	
	
	while ($row = mysqli_fetch_array($result)) {
		
		
		$sql = "INSERT INTO users (first, last, password, email, NPINumber, company) VALUES ('".$row['firstName']."', '". $row['LastName']. "', '". $row['hashedPassword'] ."', '". $row['email']. "', '".$row['mdNumber']."', '".$row['companyName']."')";
		$db->query($sql);
		$user_id = $db->insertedID();
		
		$sql2 = "INSERT INTO address (address_1, address_2, city, zip) VALUES ('".$row['address']."', '". $row['address2']."', '".$row['city']."', '". $row['zip']."')";
		$db->query($sql2);
		$address_id = $db->insertedID();
		
		
		$sql6 = "INSERT INTO addressForUser (address_id, user_id) VALUES ({$address_id}, {$user_id})";
		$db->query($sql6);
		
		
		$sql3 = "INSERT INTO phone (phonenumber, phoneType) VALUES ('".$row['phoneNum']."', 'OP')";
		$db->query($sql3);
		$phone_id = $db->insertedID();
		
		$sql7 = "INSERT INTO phoneForUser (phone_id, user_id) VALUES ({$phone_id}, {$user_id})";
		$db->query($sql7);
		
		
		if ($row['faxNum'] != NULL) {
			$sql4 = "INSERT INTO phone (phonenumber, phoneType) VALUES ('".$row['faxNum']."', 'FX')";
			$db->query($sql4);
			$fax_id = $db->insertedID();
				
			$sql8 = "INSERT INTO phoneForUser (phone_id, user_id) VALUES ({$fax_id}, {$user_id})";
			$db->query($sql8);
		}
		
		if ($row['cellNum'] != NULL) {
			$sql5 = "INSERT INTO phone (phonenumber, phoneType) VALUES ('".$row['cellNum']."', 'CE')";
			$db->query($sql5);
			$cell_id = $db->insertedID();
			
			$sql9 = "INSERT INTO phoneForUser (phone_id, user_id) VALUES ({$cell_id}, {$user_id})";
			$db->query($sql9);
		} 
	}*/
		
		
//News Conversion
			
	/*$sql ="SELECT * FROM news";
	$result = mysqli_query($innovation, $sql);
	$nTimes = 0;
	
	while ($row = mysqli_fetch_array($result)) {	
	
		$content = $db->escapeString($row['Content']);
		$title = $db->escapeString($row['title']);
			
		$sql = "INSERT INTO news (content, published, user_created, created_on, position, title, access) VALUES ('".$content."', 1, 14, '".$row['timestamp']."', '".$nTimes."', '".$title."' , 1)";
		
		$db->query($sql);		
	
		$nTimes++;
	} */
	
	
//Navigation to Menu conversion
		/*$sql = "SELECT navigation_id FROM navigation";
		$result = $db->query($sql); 	
		
		while ($row = $db->fetchArray($result)) {
			$sql = "INSERT INTO navigationForMenus (menu_id, navigation_id) VALUES (1, ". $row['navigation_id'] .")";
			$db->query($sql);	
		}
		
		echo "complete"; */
		
		
		
//Move Add Searchable Content
		/*$result = $db->queryFill("SELECT content, content_id FROM content");
		
		if ($result != false) {
			foreach ($result as $row) {
				$id = $row['content_id'];
				$searchable = strip_tags($row['content']);
				$searchable = $db->escapeString($searchable);
				$sql = "UPDATE content SET searchable = '{$searchable}' WHERE content_id = {$id}";
				$db->query($sql);
			}
		}*/


//Add Guid to Users
		/* $result = $db->queryFill("SELECT user_id FROM users");
		
		if ($result != false) {
			foreach ($result as $row) {
				$guid = uniqid('', true);
				$db->query("UPDATE users SET guid = '{$guid}' WHERE user_id = ".$row['user_id']);	
			}
		} */


//Add Media to Database
	$sql = "SELECT * FROM uploads";
	$result = mysqli_query($innovation, $sql);
	
	while($row = mysqli_fetch_array($result)) {
		$file_name = str_replace("_", " ", $row['file_name']);
		$file_link = '/files/uploads/'. $row['file_name'];
		$sql = "INSERT INTO media (file_name, file_link) VALUES ('{$file_name}', '{$file_link}')";
		$db->query($sql);
	}
		
?>