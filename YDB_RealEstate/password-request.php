<?php
$title = "Password Request";
$file = "password-request.php";
$description = "Allows the user to reset their password";
$date = "December 1, 2019";
$banner = "Password Request";
include("./header.php");

if(isset($_SESSION['user']))
{
	header("Location: index.php");
	ob_flush();
}
$output = "";
$loginStatus="";
$sticky_user_id="";
$sticky_email="";
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	
}
?>
<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $username = trim($_POST["username"]);
    $email_address = trim($_POST["email"]);

	$conn = db_connect();


	pg_presql($conn);

	
    $result = pg_execute($conn, "password_request", array($username, $email_address));
    $records = pg_num_rows($result);
	if(!(is_user_id($username)))
	{
		$loginStatus = "You do not have an account! Please register";
	}
	else
	{
		$sticky_user_id=$username;
		$sticky_email=$email_address;
		if($records == 0)
		{

			$loginStatus = "Incorrect email. Please try again.";
		}
		else if ($records == 1)
		{
			$loginStatus = "New password sent to your email.";
			$newPass = randomPassword();
			echo $newPass;
			$newHashedPass = hash(HASH_ALGO, $newPass);
			$sql = pg_execute($conn, "user_change_password", array($newHashedPass, $username));

			$subject = 'YDB Real Estate Password Reset';
			$message = 'The randomly generated password you need to login: ' + $newPass;
			$headers = 'From: YDBRealEstate@YDB.com';
			mail($email_address, $subject, $message, $headers);
			header("Location: login.php");
			ob_flush();

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
			<h3>Email:</h3>
		</div>
		<div class="right-side-menu">
			<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
				<br>
				<input type="text" name="username" value=<?php echo $sticky_user_id;?>><br><br>
				<input type="text" name="email" value=<?php echo $sticky_email;?>><br><br>
				<input type="submit" value="Submit">
			</form>
		</div>
	</div>
	<hr>
	<p>Don't have an account? <a href="register.php">Register</a></p>
</div>
<?php
	include("footer.php");
?>