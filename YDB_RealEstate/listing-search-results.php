<?php
/*
$title = "Lab 9";
$file = "lab9.php";
$description = "User Login PHP";
$date = "March 30, 2019";
$banner = "Lab 9 - User Login";
//    <center>     </center>
 */
require "./header.php";
unset($_SESSION['status']);
if (!isset($_SESSION[CITY])) {
	header("LOCATION: listing-search.php");
	ob_flush();
}
?>
<?php
//when user submits
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$active_vars = array();
	// Vars that will be update later might need
	// to delete from here.
	$id_Of_Listing = '';
	$id_Of_User = '';
	$postal_Code_Of_Listing = '';
	$image_id = '';
	$create_Date = '';
	$modified_Date = '';

	// Assingn id's of form to vars
	// $headline_Of_Listing = $_POST["headLine"];
	// $description_Of_Listing = $_POST["description"];

	// //Validate
	// $price_Of_Listing = trim($_POST["propertyPrice"]);
	$criteria = $_POST["and_or"];

	$city_Of_Listing = $_SESSION[CITY];
	// var_dump($city_Of_Listing[0]);
	$num_Of_Bedrooms = trim($_POST[BED]);
	$num_Of_Bathrooms = trim($_POST[BATH]);
	// $num_Of_Rooms = trim($_POST["numOfRooms"]);
	$num_Of_ParkingSpots = trim($_POST[PARKING]);
	// $has_pool = $_POST["poolOption"];
	$type_Of_Cooling = $_POST[COOL];
	$type_Of_Heating = $_POST[HEAT];
	$listing_Type = $_POST[TYPE];
	$property_options = $_POST[PRPRT_OPTNS];
	$stories = $_POST[STORIES];
	$listing_status = 'o';
	// $transaction_Type = $_POST["typeOfTransaction"];
	// $name_Of_street = $_POST["streetName"];
	// $num_Of_House = trim($_POST["houseNum"]);

	switch (true) {
		case $city_Of_Listing[0] != "":
			$sql_city = " (";
			for ($i = 0; $i < count($city_Of_Listing); $i++) {
				if ($city_Of_Listing[$i] == 'all') {
					continue;
				} elseif ($i == (count($city_Of_Listing) - 1)) {
					$one_city = get_value(CITY, $city_Of_Listing[$i]);
					$sql_city .= " city =" . $one_city;
				} else {
					$one_city = get_value(CITY, $city_Of_Listing[$i]);
					$sql_city .= " city= " . $one_city . " OR ";
				}
			}
			$sql_city .= " ) AND (";
			array_push($active_vars, $sql_city);
			// case isset($_POST["headLine"]):
			// 	$headline_Of_Listing = $_POST["headLine"];
			// 	array_push($active_vars, "headline LIKE '%$headline_Of_Listing%' ");
			// case isset($_POST["description"]):
			// 	$description_Of_Listing = $_POST["description"];
			// 	array_push($active_vars, " description LIKE '%$description_Of_Listing%' ");
		case isset($_POST["zipCode1"]) && isset($_POST["zipCode2"]):
			$postal_code_1 = trim($_POST["zipCode1"]);
			$postal_code_2 = trim($_POST["zipCode2"]);
			$postal_code = $postal_code_1 . $postal_code_2;
			if (is_valid_postal_code($postal_code)) {
				array_push($active_vars, " postal_code = '$postal_code' ");
			}
		case isset($_POST["propertyPrice"]):
			$price_Of_Listing = trim($_POST["propertyPrice"]);
			if ($price_Of_Listing != "") {
				array_push($active_vars, " price = " . $price_Of_Listing . " ");
			}
		case $num_Of_Bedrooms != "":
			$num_Of_Bedrooms = get_value(BED, $num_Of_Bedrooms);
			array_push($active_vars, " bedrooms = '$num_Of_Bedrooms' ");
		case $num_Of_Bathrooms != "":
			$num_Of_Bathrooms = get_value(BATH, $num_Of_Bathrooms);
			array_push($active_vars, " bathrooms = '$num_Of_Bathrooms' ");
		case $num_Of_ParkingSpots != "":
			$num_Of_ParkingSpots = get_value(PARKING, $num_Of_ParkingSpots);
			array_push($active_vars, " parking_space = '$num_Of_ParkingSpots' ");
		case $type_Of_Cooling != "":
			$type_Of_Cooling = get_value(COOL, $type_Of_Cooling);
			array_push($active_vars, " cooling = '$type_Of_Cooling' ");
		case $type_Of_Heating != "":
			$type_Of_Heating = get_value(HEAT, $type_Of_Heating);
			array_push($active_vars, " heating = '$type_Of_Heating' ");
		case $property_options != "":
			$property_options = get_value(PRPRT_OPTNS, $property_options);
			array_push($active_vars, " property_options = '$property_options' ");
		case $stories != "":
			$stories = get_value(STORIES, $stories);
			array_push($active_vars, " stories = '$stories' ");
		case $listing_Type != "":
			$listing_Type = get_value(TYPE, $listing_Type);
			array_push($active_vars, " type_of_listing = '$listing_Type' ");
			break;
		default:
			echo "Something else happened in the switch";
			break;
	}
}


?>
	<div class="content">
		<center>
			<?php
			if ($_SERVER["REQUEST_METHOD"] == "GET") {
				$output1 = "";

				$city_id = $_SESSION[CITY];
				$currentPage = $_GET["page"];

				if (isset($_SESSION['results'])) {
					// echo "The session is set";
					// var_dump($_SESSION);
					$result = $_SESSION['results'];
					$records = $_SESSION['records'];
				} else {
					// echo "Session is not set, will do now";
					$result = pg_execute("listings_by_city", array($city_id));
					$records = pg_num_rows($result);
					$_SESSION['results'] = pg_fetch_all($result);
					$_SESSION['records'] = $records;
					// var_dump($_SESSION['results']);
					$result = $_SESSION['results'];
					$records = $_SESSION['records'];
				}

				if ($records == 0) {
					echo "<h1>Sorry, no results match your criteria!</h1>";
				} elseif ($records == 1) {
					$listing_id = $_SESSION['results'][0]['listing_id'];
					$_SESSION['status'] = "This is the only result from your search";
					header("LOCATION: redirection.php?listing_id=" . $listing_id);
					ob_flush();
				} else {
					echo "<br/>Total Records: " . $records;

					$numPages = ceil($records / SEARCH_RESULTS_PER_PAGE);
					// echo "<br/>This is method 2 pages: " . $numPages;

					if ($currentPage == ($numPages - 1)) {
						$recordsLeft = SEARCH_RESULTS_PER_PAGE;
					} elseif ($currentPage == $numPages) {
						$recordsLeft = $records - ($currentPage - 1) * SEARCH_RESULTS_PER_PAGE;
					} elseif ($currentPage < $numPages) {
						$recordsLeft = SEARCH_RESULTS_PER_PAGE;
					}
					// echo "<br/>This is records left after forcing 10: " . $recordsLeft;
					for ($i = 0; $i < $recordsLeft; $i++) { //loop through all of the retrieved records and add to the output variable
						$j = $i + ($currentPage - 1) * SEARCH_RESULTS_PER_PAGE;
						$listing_id = $result[$j]['listing_id'];
						//Added checker if the listing has images
						if ($result[$j]['images']==0) {
							//If not display a string
							$image_display="\n\t\t<td>There are no images for this listing!</td>";
						}
						else{
							//If there are, display main image
							$img_src="images/".$listing_id."/".$listing_id."_main.jpg";
							$image_display="\n\t\t<td><img src=\"" . $img_src  . "\" alt=\"House image\"/></td>"; //Added row for img
						}
						$output1 .= "	<table border=;'1' width='75%'>
			<tr><th width='23%''>listing ID</th><th width='23%'>user ID</th><th width='23%'>Image</th><th width='10%''>listing status</th>
			  <th width='23%'>price</th><th width='10%'>headline</th><th width='10%'>city</th><th width='11%'>description</th>";

						$output1 .= "\n\t<tr>\n\t\t<td><a href=\"./redirection.php?listing_id=" . $listing_id . "\">" . $listing_id . "</a></td>";
						$output1 .= "\n\t\t<td>" . $result[$j]['user_id']  . "</td>";
						$output1 .= $image_display;
						$output1 .= "\n\t\t<td>" . $result[$j]['listing_status'] . "</td>";
						$output1 .= "\n\t\t<td>" . '$' . $result[$j]['price'] . "</td>";
						$output1 .= "\n\t\t<td>" . $result[$j]['headline']  . "</td>";
						$output1 .= "\n\t\t<td>" . get_property(CITY, $result[$j]['city']) . "</td>";
						$output1 .= "\n\t\t<td>" . $result[$j]['description']  . "</td>\n\t</tr>";
						$output1 .= "</table>";
						$output1 .= "<br/>";
					}
					echo "<br/>Total records in this page: " . $i;
					echo "<br/>Records up to: " . ($j + 1) . "<br/>";
					if ($records != 0) {
						build_pagination_menu($records);
					}
					echo $output1; //display the output
				}
			}
			if ($_SERVER["REQUEST_METHOD"] == "POST") {
				$output1 = "";

				// $city_id = $_SESSION["city_value"];
				$currentPage = 1;

				//Insert execute here
				$sql = "SELECT * FROM listings WHERE listing_status = 'o' AND (";
				$total_vars = count($active_vars);

				for ($i = 0; $i < $total_vars; $i++) {
					if ($i == 0) {
						$sql .= $active_vars[$i] . " ";
					} elseif ($i == ($total_vars - 1)) {
						$sql .= $active_vars[$i] . " ";
					} elseif ($i != $total_vars) {
						$sql .= $active_vars[$i] . " " . $criteria . " ";
					}
				}
				$sql .= ")) ORDER BY listing_id ASC LIMIT " . MAX_SEARCH_RESULTS . ";";



				if (isset($_SESSION['results'])) {
					// echo "The session is set, its contents: ";
					// var_dump($_SESSION);
					$result = $_SESSION['results'];
					$records = $_SESSION['records'];
				} else {
					// echo "Session is not set, will do now";
					$result = $result = pg_query(db_connect(), $sql);
					$records = pg_num_rows($result);
					$_SESSION['results'] = pg_fetch_all($result);
					$_SESSION['records'] = $records;
					// var_dump($_SESSION['results']);
					$result = $_SESSION['results'];
					$records = $_SESSION['records'];
				}
				if ($records == 0) {
					echo "<h1>Sorry, no results match your criteria!</h1>";
				} elseif ($records == 1) {
					$listing_id = $result[0]['listing_id'];
					$_SESSION['status'] = "This is the only result from your search";
					header("LOCATION: redirection.php?listing_id=" . $listing_id);
					ob_flush();
				} else {
					// echo "<br/>This is the sql ".$sql;
					echo "<br/>Total Records: " . $records;

					$numPages = ceil($records / SEARCH_RESULTS_PER_PAGE);
					// echo "<br/>This is method 2 pages: " . $numPages;

					if ($currentPage == ($numPages - 1)) {
						$recordsLeft = SEARCH_RESULTS_PER_PAGE;
						$_SESSION["records_left"] = $records - $currentPage * SEARCH_RESULTS_PER_PAGE;
					} elseif ($currentPage == $numPages) {
						if (isset($_SESSION["records_left"])) {
							$recordsLeft = $_SESSION["records_left"];
						} else {
							$recordsLeft = $records;
						}
					} elseif ($currentPage < $numPages) {
						$recordsLeft = SEARCH_RESULTS_PER_PAGE;
					} else {
						$recordsLeft = $_SESSION["records_left"];
					}
					// echo "<br/>This is records left after forcing 10: " . $recordsLeft;


					//Checking for forbidden
					$sql_off = "SELECT listing_id, listing_status FROM listings LIMIT 200";
					$result_off = pg_query($conn, $sql_off);
					$potentials = pg_fetch_all($result_off);
					$forbidden=array();
					$k=0;
					foreach ($potentials as $candidate) {
						if ($candidate['listing_status']==STATUS_CLOSED || $candidate['listing_status']==STATUS_HIDDEN ) {
							array_push($forbidden,$candidate['listing_id']);
						}
					}

					// Added a table for favorites first
					if (isset($_SESSION['user']) && $currentPage == 1) {
						$result_favs = pg_execute("favourites", array($_SESSION['user']));
						$records_favs = pg_num_rows($result_favs);
						$out_favs = pg_fetch_all($result_favs);
						$favourite_ids = array();
						if ($records_favs != 0) {

							$favs = sizeof($out_favs);
							$output1 .= "	<table border=;'1' width='75%'><caption>Favorites</caption>
							<tr><th width='23%''>listing ID</th><th width='23%'>user ID</th><th width='10%''>listing status</th>
							  <th width='23%'>price</th><th width='10%'>headline</th><th width='10%'>city</th><th width='11%'>description</th>";
							for ($i = 0; $i < $favs; $i++) { //loop through all of the retrieved records and add to the output variable
								$result_favs = pg_execute("from_favourites", array($out_favs[$i]['listing_id']));
								$result_favs = pg_fetch_assoc($result_favs);
								$listing_id = $result_favs['listing_id'];
								$img_src="images/".$listing_id."/".$listing_id."_0.jpg";
								if (!in_array($listing_id, $forbidden)) {
									$output1 .= "\n\t<tr>\n\t\t<td><a href=\"./redirection.php?listing_id=" . $listing_id . "\">" . $listing_id . "</a></td>";
									$output1 .= "\n\t\t<td>" . $result_favs['user_id']  . "</td>";
									$output1 .= "\n\t\t<td><img src=\"" . $img_src  . "\" alt=\"House image\"/></td>"; //Added row for img
									$output1 .= "\n\t\t<td>" . $result_favs['listing_status'] . "</td>";
									$output1 .= "\n\t\t<td>" . '$' . $result_favs['price'] . "</td>";
									$output1 .= "\n\t\t<td>" . $result_favs['headline']  . "</td>";
									$output1 .= "\n\t\t<td>" . get_property(CITY, $result_favs['city']) . "</td>";
									$output1 .= "\n\t\t<td>" . $result_favs['description']  . "</td>\n\t</tr>";
									array_push($favourite_ids, $listing_id);
								}
							}
							$output1 .= "</table>";
							$output1 .= "<br/><br/><hr/>";
						}
					}




					for ($i = 0; $i < $recordsLeft; $i++) { //loop through all of the retrieved records and add to the output variable
						$j = $i + ($currentPage - 1) * SEARCH_RESULTS_PER_PAGE;
						$listing_id = $result[$j]['listing_id'];
						if (!in_array($listing_id, $forbidden)) {
							if (isset($favourite_ids)) {
								if (in_array($listing_id, $favourite_ids)) {
									# code...
								} else {
															//Added checker if the listing has images
						if ($result[$j]['images']==0) {
							//If not display a string
							$image_display="\n\t\t<td>There are no images for this listing!</td>";
						}
						else{
							//If there are, display main image
							$img_src="images/".$listing_id."/".$listing_id."_main.jpg";
							$image_display="\n\t\t<td><img src=\"" . $img_src  . "\" alt=\"House image\"/></td>"; //Added row for img
						}
									$output1 .= "	<table border=;'1' width='75%'>
									<tr><th width='23%''>listing ID</th><th width='23%'>user ID</th><th width='23%'>Image</th><th width='10%''>listing status</th>
									  <th width='23%'>price</th><th width='10%'>headline</th><th width='10%'>city</th><th width='11%'>description</th>";

									$output1 .= "\n\t<tr>\n\t\t<td><a href=\"./redirection.php?listing_id=" . $listing_id . "\">" . $listing_id . "</a></td>";
									$output1 .= "\n\t\t<td>" . $result[$j]['user_id']  . "</td>";
									$output1 .= $image_display;
									$output1 .= "\n\t\t<td>" . $result[$j]['listing_status'] . "</td>";
									$output1 .= "\n\t\t<td>" . '$' . $result[$j]['price'] . "</td>";
									$output1 .= "\n\t\t<td>" . $result[$j]['headline']  . "</td>";
									$output1 .= "\n\t\t<td>" . get_property(CITY, $result[$j]['city'])  . "</td>";
									$output1 .= "\n\t\t<td>" . $result[$j]['description']  . "</td>\n\t</tr>";
									$output1 .= "</table>";
									$output1 .= "<br/>";
								}
							} else {
														//Added checker if the listing has images
						if ($result[$j]['images']==0) {
							//If not display a string
							$image_display="\n\t\t<td>There are no images for this listing!</td>";
						}
						else{
							//If there are, display main image
							$img_src="images/".$listing_id."/".$listing_id."_main.jpg";
							$image_display="\n\t\t<td><img src=\"" . $img_src  . "\" alt=\"House image\"/></td>"; //Added row for img
						}
								$output1 .= "	<table border=;'1' width='75%'>
									<tr><th width='23%''>listing ID</th><th width='23%'>user ID</th><th width='23%'>Image</th><th width='10%''>listing status</th>
									  <th width='23%'>price</th><th width='10%'>headline</th><th width='10%'>city</th><th width='11%'>description</th>";

								$output1 .= "\n\t<tr>\n\t\t<td><a href=\"./redirection.php?listing_id=" . $listing_id . "\">" . $listing_id . "</a></td>";
								$output1 .= "\n\t\t<td>" . $result[$j]['user_id']  . "</td>";
								$output1 .= $image_display;
								$output1 .= "\n\t\t<td>" . $result[$j]['listing_status'] . "</td>";
								$output1 .= "\n\t\t<td>" . '$' . $result[$j]['price'] . "</td>";
								$output1 .= "\n\t\t<td>" . $result[$j]['headline']  . "</td>";
								$output1 .= "\n\t\t<td>" . get_property(CITY, $result[$j]['city'])  . "</td>";
								$output1 .= "\n\t\t<td>" . $result[$j]['description']  . "</td>\n\t</tr>";
								$output1 .= "</table>";
								$output1 .= "<br/>";
							}
						}
					}
					echo "<br/>Total records in this page: " . $i;
					echo "<br/>Records up to: " . ($j + 1) . "<br/>";
					if ($records != 0) {
						build_pagination_menu($records);
					}
					echo $output1; //display the output
				}
			}
			if ($records != 0) {
				build_pagination_menu($records);
			}
			?>
		</center>
	</div>
	<?php require 'footer.php'; ?>