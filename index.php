<?php
	session_start();

	include('header.php');
	include('LIB_project1.php');
	
	$itemName = array_search("Add to Cart", $_POST);
	
	if ($itemName!="")
	{
		//php replaces spaces and dots with underscores in keys
		$itemName = str_replace("_", " ", $itemName);
		
		if ($_SESSION['name'] != "")
		{
			addToCart($itemName, $_SESSION['name']);
		}
		else
		{
			//redirect to login
			echo "<script type='text/javascript'>window.location = 'login.php';</script>";
		}
	}
?>

		  <li class="active"><a href="#">Shop</a></li>
		  <li><a href="cart.php">Cart</a></li>
		  <?php if ($_SESSION['name'] == "admin") echo '<li><a href="admin.php">Admin</a></li>'; ?>
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
		  <?php if ($_SESSION['name'] == "") echo '<li><a href="login.php">Log in</a></li>'; else echo '<li><a href="logout.php">Log out</a></li>';?>
		</ul>
	  </div>
	</div>
	<div id="container">
		<h1>Sales</h1>
		<div id="sales">
			<?
				$dbConnection = databaseLogin();
		
				$query = $dbConnection->prepare('SELECT * FROM products WHERE saleprice > 0');
				$query->execute();
				$result = $query->get_result();
				echo "<form action='index.php' method='post'>\n";
				echo "				<table class='table table-striped table-hover'>\n";
				echo "					<tr><th></th><th>Product Name</th><th>Description</th><th>Price</th><th>Quantity</th><th></th></tr>\n";
				while($row = $result->fetch_assoc())
				{
					echo "					<tr>\n"
						.	"						<td><img src='img/".($row['imagename'])."'></img></td>\n"
						.	"						<td>".($row['name'])."</td>\n"
						.	"						<td>".($row['description'])."</td>\n"
						.	"						<td>".($row['price'])."</td>\n"
						.	"						<td>".($row['quantity'])."</td>\n"
						.	"						<td><input id='".$row['name']."' name='".$row['name']."' type='submit' class='btn btn-primary' value='Add to Cart'></input></td>\n"
						."					</tr>\n";
				}
				echo "				</table>\n			</form>\n";
				
				$dbConnection->close();
			?>
		</div>
		
		<h1>Catalog</h1>
		<div id="catalog">
			<?
				$dbConnection = databaseLogin();
		
				$query = $dbConnection->prepare('SELECT * FROM products');
				$query->execute();
				$result = $query->get_result();
				echo "<form action='index.php' method='post'>\n";
				echo "				<table class='table table-striped table-hover'>\n";
				echo "					<tr><th></th><th>Product Name</th><th>Description</th><th>Price</th><th>Quantity</th><th></th></tr>\n";
				while($row = $result->fetch_assoc())
				{
					echo "					<tr>\n"
						.	"						<td><img src='img/".($row['imagename'])."'></img></td>\n"
						.	"						<td>".($row['name'])."</td>\n"
						.	"						<td>".($row['description'])."</td>\n"
						.	"						<td>".($row['price'])."</td>\n"
						.	"						<td>".($row['quantity'])."</td>\n"
						.	"						<td><input id='".$row['name']."' name='".$row['name']."' type='submit' class='btn btn-primary' value='Add to Cart'></input></td>\n"
						."					</tr>\n";
				}
				echo "				</table>\n			</form>\n";
				
				$dbConnection->close();
			?>
		</div>
	</div>
</body>
</html>
