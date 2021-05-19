<?php
$title = "Settings";
include("header.php");

$output = "";


if($_SERVER["REQUEST_METHOD"] == "GET")
{
	?>
	<div class="content">
		<h1><?php echo $title; ?></h1><hr>
		<div class="side-by-side-menu">
			<div class="left-side-menu">
				<h3>Username:</h3>
				<h3>Password:</h3>
				<h3>First Name:</h3>
				<h3>Last Name:</h3>
			</div>
			<div class="right-side-menu">
				<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
					<br>
					<input type="text" name="username" value=<?php if(isset($_COOKIE["LOGIN_COOKIE"])){echo $_COOKIE["LOGIN_COOKIE"];}?> disabled="disabled"><br><br>
					<input type="password" name="password"><br><br>
					<input type="submit" value="Submit">
					<input type="text" name="fName" value=<?php 
				</form>
			</div>
		</div>
		<hr>
		<p>Don't have an account? <a href="register.php">Register</a></p>
	</div>
	<?php
}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST["username"]);	
	$password = hash(HASH_ALGO, trim($_POST["password"]));
	
    $conn = db_connect();
	
    pg_presql($conn);

    $result = pg_execute($conn, "user_login", array($username, $password));

    $records = pg_num_rows($result);

	if($records == 0)
	{
		$loginStatus = "There was an issue logging you in. Please try again.";
		echo $loginStatus;
		//die();
	}
	else if($records == 1)
    {
        $loginStatus = "You've logged in.";
        /*$sqlUpDate = "update users set last_access = current_timestamp where user_id = '$username';";
        pg_query($conn, $sqlUpDate);
	 */
		$user =  pg_fetch_assoc($result, 0);
		$_SESSION['user'] = $user['user_id'];
		$result = pg_execute($conn, "user_update_last_access", array(date("Y-m-d"), $username));
        setcookie("LOGIN_COOKIE", $username, (time() + COOKIE_LIFESPAN));
		/*$sqlGetUserType = "select user_type from users where user_id = '$username';";
		$result = pg_query($conn, $sqlGetUserType);*/
		
			
			$user_type = $user['user_type'];

			if($user_type == ADMIN)
			{
				header("Location: admin.php");
				ob_flush();
			}
			else if($user_type == CLIENT)
			{
				header("LOCATION: welcome.php");
				ob_flush();
			}
			elseif($user_type == AGENT)
			{
				header("LOCATION: dashboard.php");
				ob_flush();
			}
			else if($user_type == PENDING)
			{
				$loginStatus = "Your account has not yet been approved.";
			}
			else if($user_type == DISABLED)
			{
				$loginStatus = "Your account has been disabled.";
			}
			// $result->close();
	}
}
include("footer.php");
?>
