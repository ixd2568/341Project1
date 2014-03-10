<?php
	session_start();

	include('header.php');
	include('LIB_project1.php');
	
	//if the user isn't logged in as admin
	if ($_SESSION['name'] != "admin")
	{
		//redirecting via JS because headers are already sent
		echo "<script type='text/javascript'>window.location = 'login.php';</script>";
	}
?>


		  <li><a href="shop.php">Shop</a></li>
		  <li><a href="cart.php">Cart</a></li>
		  <?php if ($_SESSION['name'] == "admin") echo '<li class="active"><a href="admin.php">Admin</a></li>'; ?>
		</ul>
		
		<ul class="nav navbar-nav navbar-right">
		  <?php if ($_SESSION['name'] == "") echo '<li><a href="login.php">Log in</a></li>'; else echo '<li><a href="logout.php">Log out</a></li>';?>
		</ul>
	  </div>
	</div>
	<div id="container">
		<?php 
			//if an item is being edited
			if ($_POST['select'] !="")
			{
				$itemname = "";
				$itemdesc = "";
				$itemprice = "";
				$itemqty = "";
				$saleprice = "";
				
				//and it already exists
				if ($_POST['select'] !="*New Item*")
				{
					//fill out the fields
					$dbConnection = databaseLogin();
				
					$query = $dbConnection->prepare('SELECT * FROM products WHERE name = ?');
					$query->bind_param('s', $_POST['select']);
					$query->execute();
					$result = $query->get_result();
					
					while($row = $result->fetch_assoc())
					{
						$itemname = $row['name'];;
						$itemdesc = $row['description'];;
						$itemprice = $row['price'];;
						$itemqty = $row['quantity'];;
						$saleprice = $row['saleprice'];;
					}
					
					$dbConnection->close();
				}
				
				//otherwise they're blank
				echo '<form class="form-horizontal" action="add.php" method="post">
					<fieldset>
						<legend>Editing</legend>
						<div class="form-group">
							<div class="col-lg-10">
								<input class="form-control" id="oldname" name="oldname" placeholder="Current Name" disabled="" type="text" value="Current Name: '.$_POST['select'].'">
							</div>
							<div class="col-lg-10">
								<input class="form-control" id="itemname" name="itemname" placeholder="Item Name" type="text" value="'.$itemname.'">
							</div>
							<div class="col-lg-10">
								<input class="form-control" id="itemdesc" name="itemdesc" placeholder="Item Description" type="text" value="'.$itemdesc.'">
							</div>
							<div class="col-lg-10">
								<input class="form-control" id="itemprice" name="itemprice" placeholder="Item Price" type="text" value="'.$itemprice.'">
							</div>
							<div class="col-lg-10">
								<input class="form-control" id="itemqty" name="itemqty" placeholder="Item Quantity" type="text" value="'.$itemqty.'">
							</div>
							<div class="col-lg-10">
								<input class="form-control" id="saleprice" name="saleprice" placeholder="Sale Price" type="text" value="'.$saleprice.'">
							</div>
							<div class="col-lg-10">
								<select class="form-control" id="image" name="image">';
									$dbConnection = databaseLogin();
				
									$query = $dbConnection->prepare('SELECT * FROM products');
									$query->execute();
									$result = $query->get_result();
									
									while($row = $result->fetch_assoc())
									{
										echo "<option>".$row['imagename']."</option>";
									}
									
									$dbConnection->close();
							echo '</select>
							<button type="submit" class="btn btn-primary">Add</button>
							</div>
						</div>
					</fieldset>
				</form>';
			}
		?>
		
		<form class="form-horizontal"  action='admin.php' method='post'>
			<fieldset>		
				<legend>Select Item to Edit</legend>
				<div class="form-group">
					<div class="col-lg-10">
						<select class="form-control" id="select" name="select">
							<option>*New Item*</option>
						<?php
							//connect to db and retrieve items
							$dbConnection = databaseLogin();
				
							$query = $dbConnection->prepare('SELECT * FROM products');
							$query->execute();
							$result = $query->get_result();
							
							while($row = $result->fetch_assoc())
							{
								echo "<option>".$row['name']."</option>";
							}
							
							$dbConnection->close();
						?>
						</select>
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</div>
		  </fieldset>
		</form>
	</div>
</body>
</html>

