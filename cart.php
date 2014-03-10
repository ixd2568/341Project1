<?php
	session_start();

	include('header.php');
	include('LIB_project1.php');
	
	//on remove from cart click
	$itemName = array_search("Remove", $_POST);
	
	if ($itemName!="")
	{
		//php replaces spaces and dots with underscores in keys
		$itemName = str_replace("_", " ", $itemName);
		
		if ($_SESSION['name'] != "")
		{
			removeFromCart($itemName, $_SESSION['name']);
		}
		else
		{
			//redirect to login
			echo "<script type='text/javascript'>window.location = 'login.php';</script>";
		}
	}
	
	//on empty cart click
	if ($_POST['empty'] !="")
	{		
		if ($_SESSION['name'] != "")
		{
			emptyCart($_SESSION['name']);
		}
	}
?>

		  <li><a href="index.php">Shop</a></li>
		  <li class="active"><a href="">Cart</a></li>
		  <?php if ($_SESSION['name'] == "admin") echo '<li><a href="admin.php">Admin</a></li>'; ?>
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
			<?php if ($_SESSION['name'] == "") echo '<li><a href="login.php">Log in</a></li>'; else echo '<li><a href="logout.php">Log out</a></li>';?>
		</ul>
	  </div>
	</div>
	<div id="container">
		<div id="cart">
			<?
				$dbConnection = databaseLogin();
				$query = $dbConnection->prepare('SELECT * FROM cart WHERE owner = ?');
				$query->bind_param('s', $_SESSION['name']);
				$query->execute();
				$result = $query->get_result();
				echo "<form action='cart.php' method='post'>\n";
				echo "<table class='table table-striped table-hover'>";
				echo "<tr><th>Product Name</th><th>Description</th><th>Quantity</th><th>Price</th><th></th></tr>";
				while($row = $result->fetch_assoc())
				{
					echo "<tr>"
						.	"<td>".($row['name'])."</td>"
						.	"<td>".($row['description'])."</td>"
						.	"<td>".($row['quantity'])."</td>"
						.	"<td>".($row['price'])."</td>"
						.	"<td><input id='".$row['name']."' name='".$row['name']."' type='submit' class='btn btn-primary' value='Remove'></input></td>"
						."</tr>";
				}
				echo "<tr><td></td><td></td><td></td><td></td><td><input id='empty' name='empty' type='submit' class='btn btn-primary' value='Empty Cart'></input></td></tr>";
				echo "</table></form>";
				
				$dbConnection->close();
			?>
		</div>
	</div>
</body>
</html>
