<?php
	//connect to DB
	function databaseLogin()
	{
		return new MySQLi('localhost', 'ixd2568', 'mysqlpass', 'ixd2568');
	}
	
	//add item to cart for given user
	function addToCart($item, $user)
	{
		$dbConnection = databaseLogin();
		
		$query = $dbConnection->prepare('SELECT * FROM products WHERE name = ?');
		$query->bind_param('s', $item);
		$query->execute();
		$result = $query->get_result();
		
		while ($row = $result->fetch_assoc())
		{
			$itemname = $row['name'];
			$itemdesc = $row['description'];
			$itemprice = $row['price'];
			
			$query = $dbConnection->prepare("INSERT INTO cart VALUES (?, ?, ?, 1, ?)");
			$query->bind_param('ssss', $itemname, $itemdesc, $itemprice, $user);
			$query->execute();
		}
		
		$dbConnection->close();
	} 
	
	//remove item from cart for given user
	function removeFromCart($item, $user)
	{
		$dbConnection = databaseLogin();
		
		$query = $dbConnection->prepare('DELETE FROM cart WHERE name = ? AND owner = ?');
		$query->bind_param('ss', $item, $user);
		$query->execute();
		
		$dbConnection->close();
	} 
	
	//remove all items from cart for given user
	function emptyCart($user)
	{
		$dbConnection = databaseLogin();
		
		$query = $dbConnection->prepare('DELETE FROM cart WHERE owner = ?');
		$query->bind_param('s', $user);
		$query->execute();
		
		$dbConnection->close();
	} 
?>