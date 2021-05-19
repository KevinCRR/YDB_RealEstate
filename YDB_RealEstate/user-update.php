<!-- Group# : 12
     File Name: user-update.php
     Date: 2019-10-03
     Description: This is the registration
-->
<?php
require("./header.php");
?>
	<div class="content">
    <?php
    //define(MAX_ITERATIONS,100);
	if($user == ADMIN or $user == AGENT or $user == CLIENT)
	{
		 if($_SERVER["REQUEST_METHOD"] == "GET")
		{
			$userID = $_SESSION['user'];
			$title = "Register";
			$file = "";
			$description = "";
			$date = "";
			$banner = "";
			$error = "";

			$firstName = "";
			$lastName = "";
			$email = "";
			$user_type = "";
			$user_type_final = "";
			$salutation = "";
			$salutation_final = "";
			$province = "";
			$province_final = "";
			$street_address1="";
			$street_address2="";
			$postal_code="";
			$city="";
			$primary_phone_number="";
			$secondary_phone_number="";
			$fax_number="";
			$preferred_contact_method="";
			$preferred_contact_method_final="";
	    }
		else if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$error = "";
			$userID = $_SESSION['user'];
			//the page got here from submitting the form, let's try to process
			$firstName = trim($_POST["firstname"]);
			$lastName = trim($_POST["lastname"]);
			$email = trim($_POST["email"]);
			$user_type = $_POST["userType"];
			$salutation = $_POST["salutation"];
			$province = $_POST["province"];
			$city=$_POST["city"];
			$preferred_contact_method=$_POST["preferred_contact_method"];
			$street_address1=trim($_POST["street_address1"]);
			$street_address2=trim($_POST["street_address2"]);
			$postal_code=trim($_POST["postal_code"]);
			$primary_phone_number=trim($_POST["primary_phone_number"]);
			$secondary_phone_number=trim($_POST["secondary_phone_number"]);
			$fax_number=trim($_POST["fax_number"]);

			$conn = db_connect();


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
			elseif($user_type == "null")
			{
				$error .= "Please select your transaction choice. <br>";
			}
			if($salutation == "Mr")
			{
				$salutation_final = 'Mr';
			}
			elseif($salutation == "Mrs")
			{
				$salutation_final = 'Mrs';
			}
			elseif($salutation == "Ms")
			{
				$salutation_final = 'Ms';
			}
			elseif($salutation == "null")
			{
				$error .= "Please select your salutation choice. <br>";
			}
			if($province == "ON")
			{
				$province_final = 'ON';
			}
			elseif($province == 'BC')
			{
				$province_final = 'BC';
			}
			elseif($province == 'AB')
			{
				$province_final = 'AB';
			}
			elseif($province == "null")
			{
				$error .= "Please select your province choice. <br>";
			}

			if(!isset($street_address1) || $street_address1 == "")
			{
				$street_address1 = "";
				$error .= "You must enter a Street Address in order to register.\nPlease Try Again!<br/>";
			}
			if(!is_valid_postal_code($postal_code))
			{
				$postal_code = "";
				$error .= "You must enter a correct postal code in order to register.\nPlease Try Again!<br/>";
			}

			if (!isset($primary_phone_number) || $primary_phone_number == "") {
				$primary_phone_number = "";
				$error .= "You must enter a correct primary phone number in order to register.\nPlease Try Again!<br/>";
			}
			elseif (!is_numeric($primary_phone_number)) {
				$primary_phone_number = "";
				$error .= "You must enter a correct primary phone number in order to register, you entered a letter.\nPlease Try Again!<br/>";
			}
			elseif (strlen($primary_phone_number)>PHONE_EXT_LENGTH) {
				$primary_phone_number = "";
				$error .= "You must enter a correct primary phone number in order to register, you entered more than 14 digits.\nPlease Try Again!<br/>";
			}

			if (!is_numeric($secondary_phone_number)) {
				$secondary_phone_number = "";
				$error .= "You must enter a correct secondary phone number in order to register, you entered a letter.\nPlease Try Again!<br/>";
			}
			elseif (strlen($secondary_phone_number)>PHONE_EXT_LENGTH) {
				$secondary_phone_number = "";
				$error .= "You must enter a correct secondary phone number in order to register, you entered more than 14 digits.\nPlease Try Again!<br/>";
			}

			if (!is_numeric($fax_number)) {
				$fax_number = "";
				$error .= "You must enter a correct fax number in order to register, you entered a letter.\nPlease Try Again!<br/>";
			}
			elseif (strlen($fax_number)>PHONE_EXT_LENGTH) {
				$fax_number = "";
				$error .= "You must enter a correct fax number in order to register, you entered more than 14 digits.\nPlease Try Again!<br/>";
			}

			switch ($preferred_contact_method) {
				case 'Email':
					$preferred_contact_method_final='e';
					break;

				case 'Phone Number':
					$preferred_contact_method_final='p';
					break;

				case 'Letter Post':
					$preferred_contact_method_final='l';
					break;

				default:
					$error.="Something happened with the contact method";
					break;
			}

	    if($error == "")
			{
				$user_type = $user_type_final;
				$_SESSION['salutation'] = $salutation_final;
				$_SESSION['first_name'] = $firstName;
				$_SESSION['last_name'] = $lastName;
				$today = date('Y-m-d');

				$sql = pg_execute($conn, "update_user", array($email, $user_type_final, $today, $userID));
				$sql = pg_execute($conn, "update_person", array($salutation_final,$firstName,$lastName, $street_address1, $street_address2, $city, $province_final, $postal_code, $primary_phone_number, $secondary_phone_number, $fax_number, $preferred_contact_method_final,$userID));

				$_SESSION["dashboardMessage"] = "Updated user information for : \"".$first . " " . $lastName."\"!";

				header("Location: index.php");
				ob_flush();
			}
		}
	else
	{
		header("Location: index.php");

		ob_flush();
	}
	?>
  <center>

	<hr/>
		<a class="ex2" href="./user-update.php"
		title="Clear Page"><h3>Clear Page</h3></a>

	<hr/>

  	<h3 style="color:red"><?php echo $error;?></h3>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

	<div class="side-by-side-menu">
		<div class="left-side-menu">
			<h3>First Name:</h3>
			<h3>Last Name:</h3>
			<h3>Email Address:</h3>
			<h3>I Am:</h3>
			<h3>Salutation:</h3>
			<h3>Street Address 1</h3>
			<h3>Street Address 2</h3>
			<h3>City</h3>
			<h3>Province</h3>
			<h3>Postal Code</h3>
			<h3>Primary Phone </h3>
			<h3>Secondary Phone </h3>
			<h3>Fax Number</h3>
			<h3>Preferred Contact Method</h3>
		</div>
		<div class="right-side-menu">
			<form>
				<br>

				<input type="text" name="firstname" value="<?php echo $firstName; ?>" size=20><br><br>
				<input type="text" name="lastname" value="<?php echo $lastName; ?>" size=20><br><br>
				<input type="text" name="email" value="<?php echo $email; ?>" size=20><br><br>
				<select name="userType">
					<option value="null">Select one</option>
					<option value="seller">Selling property</option>
					<option value="buyer">Buying property</option>
				</select><br><br>
				<select name="salutation">
					<option value="null">Select one</option>
					<option value="Mr">Mr</option>
					<option value="Mrs">Mrs</option>
					<option value="Ms">Ms</option>
				</select><br><br>
				<input type="text" name="street_address1" value="<?php echo $street_address1; ?>" size=20><br><br>
				<input type="text" name="street_address2" value="<?php echo $street_address2; ?>" size=20><br><br>
				<?php echo build_simple_dropdown(CITY,1); ?><br><br>
				<select name="province">
					<option value="null">Select one</option>
					<option value="ON">ON</option>
					<option value="BC">BC</option>
					<option value="AB">AB</option>
				</select><br><br>
				<input type="text" name="postal_code" value="<?php echo $postal_code; ?>" size=20><br><br>
				<input type="text" name="primary_phone_number" value="<?php echo $primary_phone_number; ?>" size=20><br><br>
				<input type="text" name="secondary_phone_number" value="<?php echo $secondary_phone_number; ?>" size=20><br><br>
				<input type="text" name="fax_number" value="<?php echo $fax_number; ?>" size=20><br><br>
				<?php echo build_radio(CONT_METHOD,'e'); ?><br><br>
				<input type="submit" name="register" value="Update">
				<input type="reset" name="reset" value="Reset">

			</form>
		</div>
	</div>


    </form>

    <hr/>
</center>
</div>
<?php
}

?>

<?php include 'footer.php'; ?>
