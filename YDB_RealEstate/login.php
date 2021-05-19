<?php
$title = "Login";
include("header.php");

$output = "";
$loginStatus="";
$sticky_user_id="";
if($_SERVER["REQUEST_METHOD"] == "GET")
{

}
?>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST["username"]);
    $password = hash(HASH_ALGO, trim($_POST["password"]));

	$conn = db_connect();


	pg_presql($conn);

	$result = pg_execute($conn, "login_query",
 	array($username, $password));
	$records = pg_num_rows($result);
    $result = pg_execute($conn, "user_login", array($username, $password));
    $records = pg_num_rows($result);

	if(!(is_user_id($username)))
	{
		$loginStatus = "You do not have an account! Please register";
	}
	else
	{
		$sticky_user_id=$username;
		if($records == 0)
		{

			$loginStatus = "Incorrect password. Please try again.";
			// echo $loginStatus;
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
			$_SESSION['userType'] = $user['user_type'];
			$result = pg_execute($conn, "user_update_last_access", array(date("Y-m-d"), $username));
			setcookie("LOGIN_COOKIE", $username, (time() + COOKIE_LIFESPAN));
			/*$sqlGetUserType = "select user_type from users where user_id = '$username';";
			$result = pg_query($conn, $sqlGetUserType);*/


				$user_type = $user['user_type'];
				$result_data = pg_execute($conn, "user_get_persons_data", array($username));
				$user_data =  pg_fetch_assoc($result_data, 0);
				$_SESSION['salutation'] = $user_data['salutation'];
				$_SESSION['first_name'] = $user_data['first_name'];
				$_SESSION['last_name'] = $user_data['last_name'];
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
					session_unset($_SESSION);
					session_destroy();
					session_start();
					header("LOCATION: aup.php");
					ob_flush();
					//$loginStatus = "Your account has been disabled.";
				}
		}
	}
	// $result->close();
}
?>
<div class="content">
	<?php if (isset($_SESSION['output'])) {
		echo "<h1>".$_SESSION['output']."</h1>";
		unset($_SESSION['output']);
	}?>
	<h1><?php echo $loginStatus;?></h1><hr/><br/>
	<h1><?php echo $title; ?></h1><hr/>
	<div class="side-by-side-menu">
		<div class="left-side-menu">
			<h3>Username:</h3>
			<h3>Password:</h3>
		</div>
		<div class="right-side-menu">
			<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
				<br>
				<input type="text" name="username" value=<?php echo $sticky_user_id;?>><br><br>
				<input type="password" name="password"><br><br>
				<input type="submit" value="Submit">
			</form>
		</div>
	</div>
	<hr>
	<p>Don't have an account? <a href="register.php">Register</a></p>
	<p>Forgot your password? <a href="password-request.php">Password Request</a></p>
</div>
<?php
	include("footer.php");
?>
