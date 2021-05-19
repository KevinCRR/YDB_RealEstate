<!-- Group# : 12
     File Name: register.php
     Date: 2019-10-03
     Description: This is the registration
-->
<?php
require("./header.php");
if(isset($_SESSION['user']))
{
	$title = "Update";
	$file = "";
	$description = "";
	$date = "";
	$banner = "";
	$error = "";
	$output = "";
	$idLogin = "";
	$passLogin = "";
	$passLoginConfirm = "";
	$securityQuestion = "";
	$securityAnswer = "";
	$securityAnswerConf = "";
	$firstName = "";
	$lastName = "";
	$email = "";
	$user_type = "";
	$user_type_final = "";
	
?>
	<div class="content">
    <?php
    //define(MAX_ITERATIONS,100);

    if($_SERVER["REQUEST_METHOD"] == "GET")
	{
        $idLogin = "";
		$passLogin = "";
		$passLoginConfirm = "";
		$securityQuestion = "";
		$securityAnswer = "";
		$securityAnswerConf = "";
		$firstName = "";
		$lastName = "";
		$email = "";
		$user_type = "";
		$user_type_final = "";
    }
	else if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//the page got here from submitting the form, let's try to process
		$idLogin = trim($_POST["idlog"]); //the name of the input box on the form, white-space removed
		$passLogin = trim($_POST["passlog"]);
		$passLoginConfirm = trim($_POST["passlogconf"]);
		$securityQuestion = trim($_POST["securityQuestion"]);
		$securityAnswer = trim($_POST["securityAnswer"]);
		$securityAnswerConf = trim($_POST["securityAnswerConf"]);
		$firstName = trim($_POST["firstname"]);
		$lastName = trim($_POST["lastname"]);
		$email = trim($_POST["email"]);
		$user_type = $_POST["userType"];
		
		$conn = db_connect();

		if(!isset($idLogin) || $idLogin == "")
		{
			$idLogin = "";
			$error .= "You must enter a Login ID in order to register. Please Try Again!<br>";
		}
		else if(strlen($idLogin) < MIN_ID_LENGTH)
		{
			$error .= "A user id must be at least ". MIN_ID_LENGTH ." characters, \"".$idLogin."\" is not long enough.<br>";
		}	
		else if(strlen($idLogin) > MAX_ID_LENGTH)
		{
			$error .= "A user id must be less than ". MAX_ID_LENGTH ." characters, \"".$idLogin."\" is too long.<br>";
		}
		else
		{
			$sql = "SELECT user_id FROM users WHERE user_id = '$idLogin';";
			$result = pg_query($conn, $sql);
			$records = pg_num_rows($result);
			if ($records == 1)
			{
				$error .= "The user id \"".$idLogin."\" already exists, Please try to register with a different id!<br>";
				$idLogin = "";
			}
		}

		if(!isset($passLogin) || $passLogin == "")
		{
            //means the user did not enter anything
            $error .= "You must enter your password in order to register.\nPlease Try Again!<br/>";
        }
		else if(strlen($passLogin) < MIN_PW_LENGTH)
		{
			$error .= "A user password must be at least ". MIN_PW_LENGTH ." characters.<br/>";
		}
		else if(strlen($passLogin) > MAX_PW_LENGTH)
		{
			$error .= "A user password must be less than ". MAX_PW_LENGTH ." characters.<br/>";
		}
		else if(strcmp($passLogin, $passLoginConfirm))
		{
			$error .= "Passwords do not match!<br/>";
		}

		if(!isset($firstName) || $firstName == "")
		{
			$firstName = "";
			$error .= "You must enter a first name in order to register.\nPlease Try Again!<br/>";
		}
		else if (preg_match("/[^a-zA-Z'-]/", $firstName))
		{
				$error .= "Your first name cannot contain a number, you entered ". $firstName . "<br/>";
				$firstName = "";
		}
		else if(strlen($firstName) > MAX_FN_LENGTH)
		{
			$error .= "Your Name must be less than ". MAX_FN_LENGTH ." characters, ". $firstName." iS too long<br/>";
			$firstName = "";
		}

		if(!isset($lastName) || $lastName == "")
		{
			$lastName = "";
			$error .= "You must enter a last name in order to register.\nPlease Try Again!<br/>";
		}
		else if (preg_match("/[^a-zA-Z'-]/", $lastName))
		{
				$error .= "Your last name cannot contain a number, you entered ". $lastName . "<br/>";
				$lastName = "";
		}
		else if(strlen($lastName) > MAX_LN_LENGTH)
		{
			$error .= "Your Last Name must be less than ". MAX_LN_LENGTH ." characters, ". $lastName." iS too long<br/>";
			$lastName = "";
		}

		if (!isset($email) || $email == "")
		{
			$email = "";
			$error .= "You must enter an email in order to register. Please Try Again!<br/>";
		}
		else if (strlen($email) > MAX_EMAIL_LENGTH)
		{
			$error .= "The email you entered cannot be greater than" . MAX_EMAIL_LENGTH .", your email is ".$email." characters.<br/>";
			$email = "";
		}
		else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= "You must enter a valid email, ".$email." is not a valid email.<br/>";
			$email = "";
		}
		
		if($user_type == "seller")
		{
			$user_type_final = AGENT;
		}
		elseif($user_type == "buyer")
		{
			$user_type_final = CLIENT;
		}
        if($error == "")
		{
			$today = date('Y-m-d');
			$sql = "INSERT INTO users(user_id, password, email_address, user_type, enrol_date, last_access)
			VALUES('$idLogin', '$passLogin', '$email', '$user_type_final', '$today', '$today');";
			pg_query($conn, $sql);
			header("LOCATION:welcome.php");
			ob_flush();
		}

    }
	?>
  <center>

	<hr/>
		<a class="ex2" href="./lab9.php"
		title="Clear Page"><h3>Clear Page</h3></a>

	<hr/>

    <h3>Description</h3>
    <p>This page illustrates the use of self-referring forms in PHP and more of html
       forms using data validation.
    </p>

    <h3><?php echo $error; ?></h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

	<div class="side-by-side-menu">
		<div class="left-side-menu">
			<h3>Login ID:</h3>
			<h3>Password:</h3>
			<h3>Confirm Password:</h3>
			<h3>Security Question:</h3>
			<h3>Security Answer:</h3>
			<h3>Confirm Answer:</h3>
			<h3>First Name:</h3>
			<h3>Last Name:</h3>
			<h3>Email Address:</h3>
			<h3>I Am:</h3>
		</div>
		<div class="right-side-menu">
			<form>
				<br>
				<input type="text" name="idlog" value="<?php echo $idLogin; ?>" size=20><br><br>
				<input type="password" name="passlog" value="" size=20><br><br>
				<input type="password" name="passlogconf" value="" size=20><br><br>
				<input type="text" name="securityQuestion" value="<?php echo $securityQuestion; ?>" size=20><br><br>
				<input type="password" name="securityAnswer" size=20><br><br>
				<input type="password" name="securityAnswerConf" size=20><br><br>
				<input type="text" name="firstname" value="<?php echo $firstName; ?>" size=20><br><br>
				<input type="text" name="lastname" value="<?php echo $lastName; ?>" size=20><br><br>
				<input type="text" name="email" value="<?php echo $email; ?>" size=20><br><br>
				<select name="userType">
					  <option value="seller">Selling property</option>
					  <option value="buyer">Buying property</option>
				</select><br><br>
				<input type="submit" name="login" value="Log In">
				<input type="reset" name="reset" value="Reset">
			</form>
		</div>
	</div>


    </form>


    <h2><?php echo $output; ?></h2>
    <hr/>
</center>
</div>
<?php
}
else
{
	header("Location: login.php");
	ob_flush();
}
?>	
	
<?php include 'footer.php'; ?>
