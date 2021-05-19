<?php
$title = "Welcome";
$file = "welcome.php";
$description = "Welcome page after successful login";
$date = "September 27, 2019";
$banner = "Dashboard";
include "./header.php";

if (!isset($_SESSION['user'])) {
    header("LOCATION: login.php");
    ob_flush();
}
$conn = db_connect();

$user_persons = pg_execute($conn, "user_get_persons_data", array($_SESSION['user']));
$user_users = pg_execute($conn, "user_get_users_data", array($_SESSION['user']));
$personsInfo = pg_fetch_assoc($user_persons);
$usersInfo = pg_fetch_assoc($user_users);
if ($usersInfo['user_type'] != CLIENT) {
    ?>
	<div class="content">
		<h1>You do not have permission to be here!</h1>
	</div>
	<?php
    header("Location: index.php");
    ob_flush();
} else {
    ?>
	<div class="content">
	<center>
		<h1>Welcome, <?php echo $_SESSION['salutation'] . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>!</h1>
		<h6>Last access: <?php echo $usersInfo['last_access']; ?></h6>
		<?php
$userID = $_SESSION['user'];

    $conn = db_connect();
    //$sql = "SELECT * FROM favourites WHERE user_id='$userID';";
    $faves = pg_execute($conn, "favourites", array($userID));
    $records = pg_num_rows($faves);

    $query = $_SERVER["QUERY_STRING"];

    if (strlen($query) == 6) {
        $page = substr($query, 5);
    }
    if (strlen($query) == 7) {
        $page = substr($query, 5, 2);
    }
    if (strlen($query) == 0) {
        $page = 1;
    }

    $listingsStart = ($page * SEARCH_RESULTS_PER_PAGE) - SEARCH_RESULTS_PER_PAGE;
    $listingsEnd = $page * SEARCH_RESULTS_PER_PAGE;
    if ($listingsEnd > $records) {
        $listingsEnd = $records;
    }
    $output1 = "";

    for ($i = $listingsStart; $i < $listingsEnd; $i++) { //loop through all of the retrieved records and add to the output variable
        $listing = pg_fetch_result($faves, $i, "listing_id");

        $sql = "SELECT * FROM listings WHERE listing_id = $listing;";
        $result = pg_query($conn, $sql);

        //Added styling to listings that have been sold
        $skip = false;
        $status = pg_fetch_result($result, 0, "listing_status");
        if ($status == STATUS_SOLD) {
            $status = "<p style=\"color:red;\">This listing has been sold!<p/>";
        } elseif ($status == STATUS_CLOSED || $status == STATUS_HIDDEN) {
            $skip = true;
        }
        if (!$skip) {
			$listing_id=pg_fetch_result($result, 0, "listing_id");
			$img_src="images/".$listing_id."/".$listing_id."_main.jpg";
            $output1 .= "	<table border='1' width='75%'>
			<tr><th style='witdh:23%'>listing ID</th><th style='width:23%'>Address</th><th style='width:10%'>listing status</th>
			<th style='width:23%'>price</th><th style='width:10%'>headline</th><th style='width:11%'>description</th></tr>";
            $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Image of home\"/></td>";
            $output1 .= "\n\t\t<td>" . pg_fetch_result($result, 0, "address") . " " . get_property(CITY, pg_fetch_result($result, 0, "city")) . " " . pg_fetch_result($result, 0, "postal_code") . "</td>";
            $output1 .= "\n\t\t<td>" . $status . "</td>";
            $output1 .= "\n\t\t<td>" . '$' . pg_fetch_result($result, 0, "price") . "</td>";
            $output1 .= "\n\t\t<td>" . pg_fetch_result($result, 0, "headline") . "</td>";
            $output1 .= "\n\t\t<td>" . pg_fetch_result($result, 0, "description") . "</td></tr>";
            $output1 .= "\n\t\t<tr><td colspan=\"3\"><a href=\"./redirection.php?unfav_id=".$listing_id."&user_id=".$userID."\">UNFAVOURITE</a></td>";
            $output1 .= "\n\t\t<td colspan=\"3\"><a href=\"./redirection.php?listing_id=" . pg_fetch_result($result, 0, "listing_id") . "\">VIEW</a></td>\n\t</tr>";
            $output1 .= "</table>";
            $output1 .= "<br/>";
        }

    }
    echo "<h3>Your Favourites</h3>";
    build_pagination_menu($records);
    if ($output1 != "") {
        echo $output1;
    }
    build_pagination_menu($records);
    ?>
	</div>
	</center>
	<?php
}

include "./footer.php";
?>