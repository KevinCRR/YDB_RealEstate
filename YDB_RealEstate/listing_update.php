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
	// When page load
		if($_SERVER["REQUEST_METHOD"] == "GET")
		{
			//
			$listingID = $_GET["listing_id"];
			$userID = $_SESSION['user'];

			$sql = "SELECT *
							FROM listings
							WHERE user_id = '$userID'
							AND listing_id  = '$listingID'";
		  $result = pg_query($conn, $sql);
			$row = pg_fetch_row($result);

			//check if
			if(!isset($row) or $row == '')
			{
				$_SESSION['dashboardMessage'] = "You do not have permission to modify that listing";
				header("Location: dashboard.php");
				ob_flush();
			}


			$listing_status = $row[2];
			$price_Of_Listing = $row[3];
			$headline_Of_Listing = $row[4];
			$description_Of_Listing = $row[5];
			$postal_Code_Of_Listing = $row[6];
			$image_id = $row[7];
			$full_address = $row[8];
			$city_Of_Listing = $row[9];
			$property_value = $row[10];
			$num_Of_Bedrooms = $row[11];
			$num_Of_Bathrooms = $row[12];
			$num_Of_ParkingSpots = $row[13];
			$num_Of_Stories = $row[14];
			$type_Of_Cooling = $row[15];
			$type_Of_Heating = $row[16];
			$listing_Type = $row[17];

			//Split address and postal
			$address = explode(' ', $full_address, 2);
			$postal = explode('-', $postal_Code_Of_Listing, 2);

			$num_Of_House = $address[0];
			$name_Of_street = $address[1];

			$postal_code_1 = $postal[0];
			$postal_code_2 = $postal[1];

			$invalid_House_No = '';
			$invalid_Street_name = '';
			$invalid_postal_code = '';
			$invalid_price = '';
			$error = '';


		}
		//when user submits
		else if($_SERVER["REQUEST_METHOD"] == "POST")
		{
			$userID = $_SESSION['user'];

			$sql2 = "SELECT listing_id
			  			FROM listings
			 				WHERE user_id = '$userID';";

			$result2 = pg_query($conn, $sql2);
			$row2 = pg_fetch_row($result2);
			$listingID = $row2[0];


			//errors
			$invalid_House_No = '';
			$invalid_Street_name = '';
			$invalid_postal_code = '';
			$invalid_price = '';
			$error = 'There were errors found in your input: <br/>';

			// Vars that will be update later might need
			// to delete from here.
			$image_id = 2;
			$modified_Date = date("Y-m-d");

			// Assingn id's of form to vars
			$headline_Of_Listing = $_POST["headLine"];
			$description_Of_Listing = $_POST["description"];
			$city_Of_Listing = get_value(CITY,$_POST["city"]);

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

			//if no errors
			if($error == 'There were errors found in your input: <br/>')
			{
				$error = '';
				$full_address  = $num_Of_House . " " . $name_Of_street;

				// echo "ID: " . $id_Of_Listing .
				// 		 "<br/>USER: " . $user .
				// 		 "<br/>listing status: " . $listing_status .
				// 		 "<br/>price of listing: " . $price_Of_Listing .
				// 		 "<br/>headLine: " . $headline_Of_Listing .
				// 		 "<br/>description: " . $description_Of_Listing.
				// 		 "<br/>image: " . $image_id.
				// 		 "<br/>city_Of_Listing: " . $city_Of_Listing.
				// 		 "<br/>options: " . $options_Of_Listing.
				// 		 "<br/>num of bedrooms: " . $num_Of_Bedrooms.
				// 		 "<br/>bath: " . $num_Of_Bathrooms.
				// 		 "<br/>park: " . $num_Of_ParkingSpots.
				// 		 "<br/>stories: " . $num_Of_Stories.
				// 		 "<br/>cooling: " . $type_Of_Cooling.
				// 		 "<br/>heating: " . $type_Of_Heating.
				// 		 "<br/>listing_Type: " . $listing_Type.
				// 		 "<br/>create: " . $create_Date.
				// 		 "<br/>modified: " . $modified_Date;

				 $updateListing = pg_execute("update_listing", array($listing_status,$price_Of_Listing,
				 $headline_Of_Listing,$description_Of_Listing,$postal_Code_Of_Listing,$image_id,$full_address,$city_Of_Listing,$property_value,$num_Of_Bedrooms,$num_Of_Bathrooms,
				 $num_Of_ParkingSpots,$num_Of_Stories,$type_Of_Cooling,$type_Of_Heating,$listing_Type,$modified_Date,$listingID));

				$_SESSION["dashboardMessage"] = "Updated listing for ID: \"".$listingID."\"!";

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
			<center><a href="<?php echo "./listing-images.php?id=".$listingID; ?>">Go to the image upload page</a></center>
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
			<?php echo build_checkbox(PRPRT_OPTNS,$property_value); ?><br><br>
		</div>

    <table align="center" cellspacing="15">

      <tr>
        <td>
					<!-- ACTION BUTTONS -->
          <p><input type="submit" name="update" value="Update">
        </td>
      </tr>

    </table>
    </form>


    <h2></h2>
</center>

</div>
<?php include 'footer.php'; ?>
