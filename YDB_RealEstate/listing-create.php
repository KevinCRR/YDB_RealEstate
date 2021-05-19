<!-- Group# : 12
     File Name: listing-create.php
     Date: 2019-10-03
     Description: Deliverable 3  page for creating the real estate listings.
-->
<?php
/*
	$title = "";
	$file = "";
	$description = "";
	$date = "	Nov 11, 2019";
	$banner = "";
*/
	require("./header.php");
?>


<?php
	if($user == ADMIN or $user == AGENT)
	{
	// When page loads
		if($_SERVER["REQUEST_METHOD"] == "GET")
		{

			$invalid_House_No = '';
			$invalid_Street_name = '';
			$invalid_postal_code = '';
			$invalid_price = '';
			$error = '';

			//NOTE: vars written this way so they protect the integrity of listings table
			$id_Of_Listing = '';
			$price_Of_Listing = '';
			$headline_Of_Listing = '';
			$description_Of_Listing = 'Your Description here...';
			$postal_Code_Of_Listing = '';
			$city_Of_Listing = 1;
			$property_value=1;
			$num_Of_Bedrooms = 1;
			$num_Of_Bathrooms = 1;
			$num_Of_ParkingSpots = 1;
			$num_Of_Stories = 1;
			$type_Of_Cooling = 1;
			$type_Of_Heating = 1;
			$listing_Type = 1;;
			$create_Date = '';
			$modified_Date = '';
			$listing_status = 1;

			//other vars that are not sql related
			$num_Of_House = '';
			$name_Of_street = '';
			$postal_code_1 = '';
			$postal_code_2 = '';

		}
		//when user submits
		else if($_SERVER["REQUEST_METHOD"] == "POST")
		{

			$sql2 = "SELECT listing_id
							FROM listings
							ORDER BY listing_id DESC
							LIMIT 1";

			$result2 = pg_query($conn, $sql2);
			$lastListingId = pg_fetch_assoc($result2);

			//
			// if(isset($_SESSION['user']) ? isset($_SESSION['user']) : '')
			// {

				$userID = $_SESSION["user"];
			// }

			//errors
			$invalid_House_No = '';
			$invalid_Street_name = '';
			$invalid_postal_code = '';
			$invalid_price = '';
			$error = 'There were errors found in your input: <br/>';

			// Vars that will be update later might need
			// to delete from here.
			$id_Of_Listing = $newListingId = isset($lastListingId['listing_id']) ? $lastListingId['listing_id'] : '';
			++$id_Of_Listing;
			$create_Date = date("Y-m-d");
			$modified_Date = date("Y-m-d");

			// Assingn id's of form to vars
			$headline_Of_Listing = $_POST["headLine"];
			$description_Of_Listing = $_POST["description"];
			$city_Of_Listing = intval(get_value(CITY,$_POST["city"]));

			//Validate
			$postal_code_1 = trim($_POST["zipCode1"]);
			$postal_code_2 = trim($_POST["zipCode2"]);
			$postal_Code_Of_Listing = $postal_code_1 . '-' .$postal_code_2;
			$price_Of_Listing = trim($_POST["propertyPrice"]);

			$options_Of_Listing = $_POST[PRPRT_OPTNS];
			$property_value=0;
        	for ($i=0; $i <count($options_Of_Listing); $i++) {
            $property_value+=get_value(PRPRT_OPTNS ,$options_Of_Listing[$i]);
        	}
			
			$num_Of_Stories = get_value(STORIES,$_POST["stories"]);
			$num_Of_Bedrooms = get_value(BED,$_POST["bedrooms"]);
		    $num_Of_Bathrooms = get_value(BATH,$_POST["bathrooms"]);
			$num_Of_ParkingSpots = get_value(PARKING,$_POST["parking_space"]);
			$type_Of_Cooling = get_value(COOL,$_POST["cooling"]);
			$type_Of_Heating = get_value(HEAT,$_POST["heating"]);
			$listing_Type = get_value(TYPE,$_POST["type_of_listing"]);
			$name_Of_street = $_POST["streetName"];
			$listing_status = get_value(LIST_STATUS,$_POST["listing_status"]);
			$num_Of_House = trim($_POST["houseNum"]);


			// postal code validated
			// price
			// numOfRooms
			// house ROOMS
			// street name


			//VALIDATION:

			//invalid_House_No
			//invalid_Street_name
			//invalid_postal_code
			//invalid_price
			//invalidrooms


			//house Number
			if(!isset($num_Of_House) || $num_Of_House == '')
			{
				$invalid_House_No = "You must enter a house number.\nPlease Try Again!<br/>";
				$error .= "House Number cannot be empty <br/>";
			}

			//street Name
			if(!isset($name_Of_street) || $name_Of_street == '')
			{
				$invalid_Street_name = "You must enter a street name.\nPlease Try Again!<br/>";
				$error .= "Street Name cannot be empty <br/>";
			}

			if($invalid_House_No == '' && $invalid_Street_name == '')
			{
				$full_address  = $num_Of_House . " " . $name_Of_street;

				if(strlen($full_address)>MAX_STREET_ADDRESS)
				{
					$invalid_Street_name = "House number and Street Name cannot exceed more than ". MAX_STREET_ADDRESS." Characters \nPlease Try Again!<br/>";
					$error .= "Street No and Name is too long!<br/>";

					$full_address = '';
				}
			}

			//postal code
			if(!isset($postal_Code_Of_Listing) || $postal_Code_Of_Listing == '')
			{
				$invalid_postal_code = "You must enter a number for your postal code.\nPlease Try Again!<br/>";
				$error .= "Postal Code Cannot be empty <br/>";
			}
			elseif(!is_valid_postal_code($postal_Code_Of_Listing))
			{
				$invalid_postal_code = "You must enter a correct postal code in order to create listing. <br/> You entered: ".$postal_Code_Of_Listing.
				"Example: \"L1X-1Y8\" \nPlease Try Again!<br/>";
				//empty var so it clears fields from sticky
				$error .= "Postal Code is not valid <br/>";
				$postal_Code_Of_Listing = '';
				$postal_code_1 = '';
				$postal_code_2 = '';
			}

			//price
			if(!isset($price_Of_Listing) || $price_Of_Listing == '') //Is the input empty?
			{
				$invalid_price = "You must enter a number for price.\nPlease Try Again!<br/>";
				$error .= "Price field cannot be empty <br/>";
			}
			elseif(!is_numeric($price_Of_Listing)) //is the input numeric?
			{
				$invalid_price =  "Your input for price must be numeric. You entered: ".$price_Of_Listing.
				" \nPlease Try Again! Example: 2002933<br/>";

				$error .= "Price must be numeric <br/>";
				$price_Of_Listing = '';
			}

			//Upload image function
			// $image=$_FILES;
			// $img_path=upload_image($image);
			//Returns the path unless there's an error
			if ($img_path=="error") {
				$error.="There was an error uploading the image. <br/>";
			}
			//if no errors
			if($error == 'There were errors found in your input: <br/>')
			{
				$error = '';
				$full_address  = $num_Of_House . " " . $name_Of_street;

				// deleted the wall of comments

				//Added img path variable
				$updateListing = pg_execute("listing_create", array($id_Of_Listing, $userID,$listing_status,$price_Of_Listing,
				$headline_Of_Listing,$description_Of_Listing,$postal_Code_Of_Listing,$img_path,$full_address,$city_Of_Listing,$property_value,$num_Of_Bedrooms,$num_Of_Bathrooms,
				$num_Of_ParkingSpots,$num_Of_Stories,$type_Of_Cooling,$type_Of_Heating,$listing_Type,$create_Date,$modified_Date));

				 $_SESSION["dashboardMessage"] = "New listing \"".$headline_Of_Listing."\" has been created!";

				 header("Location: dashboard.php");

				 ob_flush();
			}
		};
	}
	else
	{
		header("Location: index.php");

		ob_flush();
	}

?>
  <div class="content">
  <center>

		 <h3 style="color:red"><?php echo $error;?></h3>
    <!-- FORM TO CREATE LISTING-->
    <form action="" method="POST">
		<!-- HEADLINE -->
		<div>
			<b>Headline: </b>
			<input type="text" name="headLine" value="<?php echo $headline_Of_Listing; ?>" size=100>
		</div>


		<!-- DESCRIPTION -->
		<div>

				<br/>
				<b>description</b>
				<textarea name="description"
					rows = "3"
					cols = "80"><?php echo $description_Of_Listing; ?></textarea>
	 </div>

		<!-- INSERT PICTURE -->
		<div>
			<br/>
			<center><b>Inset Picture:</b>
				<input type="file" name="image" id="image" accept="image/*"></center>
			<hr/>
		</div>

		<!-- TYPE OF HOUSE -->
		<div>
			<br/>
			<b>Type</b>
			<?php echo build_simple_dropdown(TYPE,$listing_Type); ?>

				<!-- STATUS -->
			<b>Status</b>
			<?php echo build_simple_dropdown(LIST_STATUS,$listing_status); ?>
		</div>

		<div>
			<br/>
			<h3 style="color:red"><?php echo $invalid_House_No;?></h3>
			<h3 style="color:red"><?php echo $invalid_postal_code;?></h3>
			<h3 style="color:red"><?php echo $invalid_Street_name;?></h3>
			<!-- HOUSE NUMBER  -->
			<b>House Number</b>
			<input type="text " name="houseNum" value="<?php echo $num_Of_House; ?>" size="5">

			<!-- STREET NAME -->
      <b>Street Name</b>
      <input type="text " name="streetName" value="<?php echo $name_Of_street; ?>" size=30>

			<!-- ZIP CODE -->
					<b>Postal Code: (
					<input type="text" name="zipCode1" value="<?php echo $postal_code_1; ?>" size=3> -
					<input type="text" name="zipCode2" value="<?php echo $postal_code_2; ?>" size=3>)</b>
		</div>

		<div>
			<br/>
			<b>city</b>
			<?php echo build_simple_dropdown(CITY,$city_Of_Listing); ?><br><br>
			<hr/>
		</div>

		<div>
		<br/>
		<!-- BEDROOMS -->
			<b>Bed Rooms</b>
			<?php echo build_simple_dropdown(BED,$num_Of_Bedrooms); ?>

		<!-- BATH -->
			<b>Bath</b>
			<?php echo build_simple_dropdown(BATH,$num_Of_Bathrooms); ?>

			<!-- stories -->
				<b>stories</b>
				<?php echo build_simple_dropdown(STORIES,$num_Of_Stories); ?>

				<!-- PARKING SPACE -->
				<b>Parking Space</b>
				<?php echo build_simple_dropdown(PARKING,$num_Of_ParkingSpots); ?>
		</div>

		<div>
		<br/>
			<!-- heating types -->
			<b>Heating Fuel</b>
			<?php echo build_simple_dropdown(HEAT,$type_Of_Heating); ?>


			<!-- cooling types -->
			<b>Cooling</b>
			<?php echo build_simple_dropdown(COOL,$type_Of_Cooling); ?>
		</div>

		<div>
		<br/>
			<h3 style="color:red"><?php echo $invalid_price;?></h3>
			<!-- PRICE -->
			<td colspan="3"><center><b>Price $</b>
			<input type="text" name="propertyPrice" value="<?php echo $price_Of_Listing; ?>" size=20></center></td>
		</div>

		<div>
			<hr/>
			<br/>
			<?php echo build_checkbox(PRPRT_OPTNS,$property_value);?><br><br>
		</div>

    <table align="center" cellspacing="15">

      <tr>
        <td>
					<!-- ACTION BUTTONS -->
          <p><input type="submit" name="create" value="Create Listing">
          <input type="reset" value="Clear Fields">
        </td>
      </tr>

    </table>
    </form>


    <h2></h2>
</center>

</div>
<?php include 'footer.php'; ?>
