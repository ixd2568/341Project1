<?php
	
	session_start();
	
	//if fields are not empty
	if(isset($_POST['username']) && isset($_POST['password']))
	{
		//and credentials are valid
		if ((($_POST['username'] == 'customer') && ($_POST['password'] == 'pass')) ||
			(($_POST['username'] == 'admin') && ($_POST['password'] == 'adminpass')))
		{
			//redirect and store username in session
			$host = $_SERVER['HTTP_HOST'];
			$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
			$extra = 'index.php';
			
			$_SESSION['name'] = $_POST['username'];
			
			header("Location: http://$host$uri/$extra");
			exit();
		}
		else if (!empty($_POST))
		{
			echo "<h3 style='color:red'>Invalid username and/or password.</h3>";
		}
	}
	
	require('header.php');
?>


		  <li><a href="index.php">Shop</a></li>
		</ul>
	  </div>
	</div>
	<div id="container">
		<form action="login.php" method="post" role="form">
			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" name="username" class="form-control" placeholder="Username">
			</div>
			<div class="form-group">
				<label for="password">Password</label>
				<input type="text" name="password" class="form-control" placeholder="Password">
			</div>
			<button type="submit" class="btn btn-default"><span class='glyphicon glyphicon-log-in'></span> Log in</button>
		</form>
	</div>
</body>
</html>