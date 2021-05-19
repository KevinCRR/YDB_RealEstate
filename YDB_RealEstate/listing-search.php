<!-- Group# : 12
     File Name: listing-create.php
     Date: 2019-10-03
     Description: Deliverable 1 static page for creating the real estate listings.
		 							The php is not yet added.
-->
<?php

$title = "Update Listing";
$file = "";
$description = "";
$date = "March 30, 2019";
$banner = "";

require("./header.php");
if (isset($_SESSION['results'])) {
	unset($_SESSION['results']);
	unset($_SESSION['records']);
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_SESSION['skip'])) {
		if (!$_SESSION['skip']) {
			$city_value=$_GET['id'];
			$city_value=get_property(CITY,$city_value);
			$_SESSION[CITY]= array($city_value );
		}
		unset($_SESSION['records']);
	}
	else {
		$city_value=$_GET['id'];
		$city_value=get_property(CITY,$city_value);
		$_SESSION[CITY]= array($city_value );
	}
	

}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$city_value=$_POST[CITY];
	$_SESSION[CITY]= $city_value;
}
?>
<div class="content">
	<center>
		<form action="./listing-search-results.php" method="POST">
			<table align="center" border="1">

				<tr>
					<td colspan="3">
						<center><b>Inset Picture:</b>
							<input type="file" name="pic" accept="image/*"></center>
					</td>
				</tr>
				<tr>

					<td><b>Type</b>
						<?php echo build_simple_dropdown(TYPE, 1); ?>

					<td><b>Transaction Type</b>
						<select>
							<option value="purchase">Purchase</option>
							<option value="rent">Rent</option>
							<option value="lease">Lease</option>
							<option value="other">Other</option>
						</select></td>

					<td><b>Square Feet</b>
						<input type="text" name="sqFT" value="" size=20></td>
				</tr>

				<tr width="30%">
					<td><b>House Number</b>
						<input type="text " name="houseNum" value="" size="5"></td>

					<td><b>Street Name</b>
						<input type="text " name="steetName" value="" size=30></td>
				</tr>

				<tr>
					<td><b>Zip Code</b>
						<p>(
							<input type="text" name="zipCode1" value="" size=3> -
							<input type="text" name="zipCode2" value="" size=3>)</p>
					</td>
				</tr>

				<tr>
					<td><b>Rooms</b>
						<input type="text" name="numOfRooms" value="" size=20></td>

					<td><b>Bed Rooms</b>
						<?php echo build_simple_dropdown(BED, 1); ?></td>

					<td><b>Bath</b>
						<?php echo build_simple_dropdown(BATH, 1); ?></td>
				</tr>

				<tr>
					<td><b>Parking Space</b>
						<?php echo build_simple_dropdown(PARKING, 1); ?></td>
					<td><b>Property Options</b>
						<?php echo build_simple_dropdown(PRPRT_OPTNS, 1); ?></td>
					<td><b>Stories</b>
						<?php echo build_simple_dropdown(STORIES, 1); ?></td>
				</tr>


				<tr>
					<td><b>Heating Fuel</b>
						<?php echo build_simple_dropdown(HEAT, 1); ?></td>

					<td><b>Cooling</b>
						<?php echo build_simple_dropdown(COOL, 1); ?></td>
				</tr>

				<tr>
					<td colspan="3">
						<center><b>Price $</b>
							<input type="text" name="propertyPrice" value="" size=20></center>
					</td>
				</tr>

			</table>
			<table align="center" cellspacing="15">
				<tr>
					<td> <input type="radio" name="and_or" value="AND" checked>AND<br />
						<input type="radio" name="and_or" value="OR">OR<br />
					</td>
					<td>
						<p><input type="submit" name="search" value="Search">
							<input type="reset" name="clear" value="Clear Fields">
					</td>
				</tr>
			</table>
		</form>


		<h2></h2>
		<hr />
	</center>
</div>
<?php include 'footer.php'; ?>