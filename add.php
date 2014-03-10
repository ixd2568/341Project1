<?php
	include('LIB_project1.php');
	
	//store variable names
	$oldName = $_POST['oldname'];
	$itemName = $_POST['itemname'];
	$itemDesc = $_POST['itemdesc'];
	$itemPrice = $_POST['itemprice'];
	$itemQty = $_POST['itemqty'];
	$salePrice = $_POST['saleprice'];
	$image = $_POST['image'];
	$onSale = 0;
	
	$dbConnection = databaseLogin();
		
	$query = $dbConnection->prepare('SELECT * FROM products WHERE saleprice > 0');
	$query->execute();
	$result = $query->get_result();
	
	while($row = $result->fetch_assoc())
	{
		if ($row['saleprice'] > 0)
			$onSale = $onSale + 1;
	}
	
	if ($oldName != "*New Item*")
	{
		
		
		//make sure not to violate sale limits
		if (!(($onSale >= 5) && ($salePrice > 0)) || (($onSale <= 3) && ($salePrice == 0)))
		{
			$query = $dbConnection->prepare('DELETE FROM products WHERE name = ?');
			$query->bind_param('s', $oldName);
			$query->execute();
			
			$query = $dbConnection->prepare('INSERT INTO products VALUES (?, ?, ?, ?, ?, ?)');
			$query->bind_param('ssssss', $itemName, $itemDesc, $itemPrice, $itemQty, $image, $salePrice);
			$query->execute();
		}
	}
	else
	{
		if (!(($onSale >= 5) && ($salePrice > 0)))
		{
			$query = $dbConnection->prepare('INSERT INTO products VALUES (?, ?, ?, ?, ?, ?)');
			$query->bind_param('ssssss', $itemName, $itemDesc, $itemPrice, $itemQty, $image, $salePrice);
			$query->execute();
		}
	}
	
	$dbConnection->close();
	
	echo "<script type='text/javascript'>window.location = 'admin.php';</script>";
?>