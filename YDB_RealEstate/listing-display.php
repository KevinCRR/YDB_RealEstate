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
$date = "    Nov 11, 2019";
$banner = "";
 */
require "./header.php";
?>


<?php
// When page load
if ($_SERVER["REQUEST_METHOD"] == "GET") {

	$sql = "SELECT listing_id
		FROM listings;";
	$result = pg_query($conn, $sql);
	$row = pg_fetch_all($result);
	$listingID = $_GET['id'];
	$_SESSION['listing_id'] = $listingID;
	$arrayName = array("listing_id" => $listingID);
	$checker = in_array($arrayName, $row);
	if (!$checker) {
		$_SESSION['message'] = "That listing ID does not exist, try to search first";
		$_SESSION['skip'] = true;
		header("Location: listing-search.php");
		ob_flush();
	} else {
		$sql = "SELECT listing_status FROM listings WHERE listing_id ='" . $listingID . "'";
		$result = pg_query($conn, $sql);
		$row = pg_fetch_all_columns($result);
		if ($row[0]=='c') {
			$_SESSION['message'] = "That listing is marked as closed";
			$_SESSION['skip'] = true;
			header("Location: listing-search.php");
			ob_flush();
		} elseif ($row[0]=='h') {
			$_SESSION['message'] = "That listing is marked as offensive";
			$_SESSION['skip'] = true;
			header("Location: listing-search.php");
			ob_flush();
		}
		$sql = "SELECT *
			FROM listings
			WHERE listing_id  =" . $listingID . ";";
		$result = pg_query($conn, $sql);
		$row = pg_fetch_row($result);

		$listing_status = $row[2];
		$price_Of_Listing = $row[3];
		$headline_Of_Listing = $row[4];
		$description_Of_Listing = $row[5];
		$postal_Code_Of_Listing = $row[6];
		$image_id = $row[7];
		$full_address = $row[8];
		$city_Of_Listing = $row[9];
		$options_Of_Listing = $row[10];
		$num_Of_Bedrooms = $row[11];
		$num_Of_Bathrooms = $row[12];
		$num_Of_ParkingSpots = $row[13];
		$num_Of_Stories = $row[14];
		$type_Of_Cooling = $row[15];
		$type_Of_Heating = $row[16];
		$listing_Type = $row[17];


		$address = explode(' ', $full_address, 2);
		$postal = explode('-', $postal_Code_Of_Listing, 2);

		$num_Of_House = $address[0];
		$name_Of_street = $address[1];

		$postal_code_1 = $postal[0];
		$postal_code_2 = $postal[1];

		if (isset($_SESSION['user'])) {
			$render = true;
			$user_id = (string) $_SESSION['user'];
			$sql = "SELECT listing_id FROM favourites WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "'";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_all($result);
			if ($row == false) {
				$favorite_status = false;
			} else {
				$favorite_status = true;
			}
			$sql = "SELECT listing_id FROM offensives WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "'";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_all($result);
			if ($row == false) {
				$offensive_status = false;
			} else {
				$offensive_status = true;
			}
		} else {
			$render = false;
			$favorite_status = false;
		}

	}
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
	$sql = "SELECT listing_id
	FROM listings;";
	$result = pg_query($conn, $sql);
	$row = pg_fetch_all($result);
	$listingID = $_SESSION['listing_id'];
	$arrayName = array("listing_id" => $listingID);
	$checker = in_array($arrayName, $row);
	if (!$checker) {
		$_SESSION['message'] = "That listing ID does not exist, try to search first";
		$_SESSION['skip'] = true;
		header("Location: listing-search.php");
		ob_flush();
	} else {
		$sql = "SELECT *
		FROM listings
		WHERE listing_id  =" . $listingID . ";";
		$result = pg_query($conn, $sql);
		$row = pg_fetch_row($result);

		$listing_status = $row[2];
		$price_Of_Listing = $row[3];
		$headline_Of_Listing = $row[4];
		$description_Of_Listing = $row[5];
		$postal_Code_Of_Listing = $row[6];
		$image_id = $row[7];
		$full_address = $row[8];
		$city_Of_Listing = $row[9];
		$options_Of_Listing = $row[10];
		$num_Of_Bedrooms = $row[11];
		$num_Of_Bathrooms = $row[12];
		$num_Of_ParkingSpots = $row[13];
		$num_Of_Stories = $row[14];
		$type_Of_Cooling = $row[15];
		$type_Of_Heating = $row[16];
		$listing_Type = $row[17];


		$address = explode(' ', $full_address, 2);
		$postal = explode('-', $postal_Code_Of_Listing, 2);

		$num_Of_House = $address[0];
		$name_Of_street = $address[1];

		$postal_code_1 = $postal[0];
		$postal_code_2 = $postal[1];
		$user_id = (string) $_SESSION['user'];

		if (isset($_POST['fav'])) {
			$sql = "SELECT listing_id FROM favourites WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "'";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_all($result);
			if ($row == false) {
				$favorite_status = false;
			} else {
				$favorite_status = true;
			}
			if ($favorite_status == false) {
				$fav_id = $user_id . '-' . $listingID;
				$result = pg_execute("add_favourite", array($fav_id, $user_id, $listingID));
				$favorite_status = true;
			} else {
				$sql = "DELETE FROM favourites WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "';";
				$result = pg_query($conn, $sql);
				$row = pg_fetch_all($result);
				$favorite_status = false;
			}
			$sql = "SELECT listing_id FROM offensives WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "'";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_all($result);
			if ($row == false) {
				$offensive_status = false;
			} else {
				$offensive_status = true;
			}
		} elseif (isset($_POST['hide'])) {
			//Set status of listing to hidden
			$sql = "UPDATE listings SET listing_status = 'h' WHERE listing_id ='" . $listingID . "';";
			$result = pg_query($conn, $sql);
			//Setting the user to disabled
			$user_type = 'd' . $_SESSION['userType'];
			$sql = "UPDATE users SET user_type = '$user_type' WHERE user_id ='" . $user_id . "';";
		} elseif (isset($_POST['offensive'])) {
			$sql = "SELECT listing_id FROM offensives WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "'";
			$result = pg_query($conn, $sql);
			$row = pg_fetch_all($result);
			if ($row == false) {
				$offensive_status = false;
			} else {
				$offensive_status = true;
			}
			if ($offensive_status) {

				// //Deleting the listing from offensives table
				// $sql = "DELETE FROM offensives WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "';";
				// $result = pg_query($conn, $sql);
				// $offensive_status = false;
				// //Setting the listing as open
				// $sql = "UPDATE listings SET listing_status = 'o' WHERE listing_id ='" . $listingID . "';";
				// $result = pg_query($conn, $sql);
				// //Seting the user back to their original setting
				// $user_type = $_SESSION['userType'];
				// $sql = "UPDATE users SET user_type = '$user_type' WHERE user_id ='" . $user_id . "';";
				// $result = pg_query($conn, $sql);
			} else {
				//Adding the listing to offensive table.
				$result = pg_execute("add_offensive", array($user_id, $listingID, date("Y-m-d"), 'o'));
				//Delete from favourites
				$sql = "DELETE FROM favourites WHERE user_id='" . $user_id . "' AND listing_id ='" . $listingID . "';";
				$result = pg_query($conn, $sql);
				$favorite_status = false;
				$offensive_status = true;

				//Look for owner
				$sql = "SELECT user_id FROM listings WHERE listing_id ='" . $listingID . "'";
				$result = pg_query($conn, $sql);
				$row = pg_fetch_all($result);
				//Change status of the owner of the listing to d+type (usually da)
				$sql = "UPDATE users SET user_type='da' WHERE user_id='".$row[0]['user_id']."';";
				$result=pg_query($conn,$sql);
			}
		}
	}
}

?>
<div class="content">
	<center>
		<?php if (isset($_SESSION['status'])) {
			echo "<h1>" . $_SESSION['status'] . "</h1>";
		} ?>

		<!-- HEADLINE -->
		<div>
			<b>Headline: </b>
			<?php echo $headline_Of_Listing; ?>
		</div>


		<!-- DESCRIPTION -->
		<div>

			<br />
			<b>description</b>
			<?php echo $description_Of_Listing; ?>
		</div>

		<!-- INSERT PICTURE -->
		<div>
			<br />
			<center><b>Picture:
					<?php $img_src="images/".$listingID."/".$listingID."_0.jpg"; 
					echo "<img src=\"$img_src\" alt=\"House image\"/>"; ?></b></center>
			<hr />
		</div>

		<!-- Favorite? -->
		<div>
			<br />
			<center>
				<?php
				if (isset($_SESSION['userType'])) {
					if ($_SESSION['userType'] == ADMIN) {
						echo "				<form action=" . $_SERVER['PHP_SELF'] . " method=\"POST\">
						<input type=\"submit\" name=\"hide\" value=\"Hide listing\">
					</form>";
					} elseif ($_SESSION['userType'] == CLIENT) {
						if (!$favorite_status) {
							$display_status = 'Not a favorite...';
						} else {
							$display_status = 'Favorite!';
						}
						echo "Current Favorite Status: " . $display_status;
						echo "				<form action=" . $_SERVER['PHP_SELF'] . " method=\"POST\">
						<input type=\"submit\" name=\"fav\" value=\"Change Favorite Status\">
					</form>";
					if ($offensive_status) {
						echo "You have already marked this listing as offensive";
					}
					else {
						echo "Click this button to mark this listing as offensive";
						echo "				<form action=" . $_SERVER['PHP_SELF'] . " method=\"POST\">
						<input type=\"submit\" name=\"offensive\" value=\"Change offensive status\">
					</form>";
					}
					}
					elseif ($_SESSION['userType']==AGENT) {
						$result = pg_execute($conn, "owner_check", array($user_id, $listingID));
						$checker = pg_fetch_all($result);
						if ($checker) {
							echo "<a href=\"listing_update.php?listing_id=".$listingID."\">Update Listing</a>";
						}
						
					}

				}
				?>

			</center>
			<hr />
		</div>
		<!-- TYPE OF HOUSE -->
		<div>
			<br />
			<b>Type</b>
			<?php echo output_dropdown(TYPE, $listing_Type); ?>

			<!-- STATUS -->
			<b>Status</b>
			<?php echo output_dropdown(LIST_STATUS, $listing_status); ?>
		</div>

		<div>
			<br />
			<!-- HOUSE NUMBER  -->
			<b>House Number</b>
			<?php echo $num_Of_House; ?> <br>

			<!-- STREET NAME -->
			<b>Street Name</b>
			<?php echo $name_Of_street; ?> <br>

			<!-- ZIP CODE -->
			<b>Postal Code: ( </b>
				<?php echo $postal_code_1; ?><b> - </b>
				<?php echo $postal_code_2; ?><b>)</b>
		</div>

		<div>
			<br />
			<b>City</b>
			<?php echo output_dropdown(CITY, $city_Of_Listing); ?><br><br>
			<hr />
		</div>

		<div>
			<br />
			<!-- BEDROOMS -->
			<b>Bed Rooms</b>
			<?php echo output_dropdown(BED, $num_Of_Bedrooms); ?><br>

			<!-- BATH -->
			<b>Bath Rooms</b>
			<?php echo output_dropdown(BATH, $num_Of_Bathrooms); ?><br>

			<!-- stories -->
			<b>Stories</b>
			<?php echo output_dropdown(STORIES, $num_Of_Stories); ?><br>

			<!-- PARKING SPACE -->
			<b>Parking Space</b>
			<?php echo output_dropdown(PARKING, $num_Of_ParkingSpots); ?>
		</div>

		<div>
			<br />
			<!-- heating types -->
			<b>Heating Fuel</b>
			<?php echo output_dropdown(HEAT, $type_Of_Heating); ?>


			<!-- cooling types -->
			<b>Cooling</b>
			<?php echo output_dropdown(COOL, $type_Of_Cooling); ?>
		</div>

		<div>
			<br />
			<!-- PRICE -->
			<td colspan="3">
				<center><b>Price $</b>
					<?php echo $price_Of_Listing; ?>
			</td>
		</div>

		<div>
			<hr />
			<br />
			<?php echo output_dropdown(PRPRT_OPTNS, $options_Of_Listing); ?><br><br>
		</div>
		<h2></h2>
	</center>

</div>
<?php include 'footer.php'; ?>