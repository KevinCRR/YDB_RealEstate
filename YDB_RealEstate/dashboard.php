<!-- Name: Kevin Romero
     File Name: lab9.php
     Date: 2019-03-30
     Description: Lab 9 Database/PHP User Login
-->
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
?>
<div class="content">
	<center>
		<?php
if ($user == AGENT) {

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $output1 = "";
        $userID = $_SESSION['user'];

        $user_persons = pg_execute($conn, "user_get_persons_data", array($_SESSION['user']));
        $user_users = pg_execute($conn, "user_get_users_data", array($_SESSION['user']));
        $personsInfo = pg_fetch_assoc($user_persons);
        $usersInfo = pg_fetch_assoc($user_users);

        if (isset($_SESSION['dashboardMessage']) ? isset($_SESSION['dashboardMessage']) : '') {
            $newMessage = $_SESSION['dashboardMessage'];
            unset($_SESSION['dashboardMessage']);
        } else {
            $newMessage = '';
        }

        echo "<h2 style=\"color:red;\">" . $newMessage . "</h2>";
        echo "<h1>Welcome, " . $_SESSION['salutation'] . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "!</h1>" .
            "<h6>Last access: " . $usersInfo['last_access'] . "</h6>";
        echo "<h1> Listings of user: \"" . $userID . "\"</h1>";

        echo "<form action=" . $_SERVER['PHP_SELF'] . " method=\"POST\">
		<input type=\"submit\" name=\"closed\" value=\"Show closed and sold\">
		</form>";

        //Added a table for offensives

        $sql = "SELECT * FROM listings WHERE user_id = '$userID' ORDER BY date_created DESC;";
        $result = pg_query($conn, $sql);
        $records = pg_num_rows($result);

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

        //Removed all tables, it should only show the agent's listings that are not closed
        $output1 .= "	<table border=;'1' width='75%'>
				<tr><th width='23%''>listing ID</th><th width='23%'>Address</th><th width='10%''>listing status</th>
				<th width='23%'>price</th><th width='10%'>headline</th><th width='11%'>description</th>";
        for ($i = $listingsStart; $i < $listingsEnd; $i++) { //loop through all of the retrieved records and add to the output variable

            //Skipping hidden listings
            $skip = false;
            $status = pg_fetch_result($result, $i, "listing_status");
            if ($status != STATUS_OPEN) {
                $skip = true;
            }

            if (!$skip) {
                $output1 .= "\n\t<tr>\n\t\t<td>" . pg_fetch_result($result, $i, "listing_id") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "address") . " " . get_property(CITY, pg_fetch_result($result, $i, "city")) . " " . pg_fetch_result($result, $i, "postal_code") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "listing_status") . "</td>";
                $output1 .= "\n\t\t<td>" . '$' . pg_fetch_result($result, $i, "price") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "headline") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "description") . "</td></tr>";
                $output1 .= "\n\t\t<tr><td colspan=\"3\"><center><a href=\"./listing_update.php?listing_id=" . pg_fetch_result($result, $i, "listing_id") . "\">UPDATE</a></center></td>";
                $output1 .= "\n\t\t<td colspan=\"3\"><center><a href=\"./redirection.php?listing_id=" . pg_fetch_result($result, $i, "listing_id") . "\">VIEW</a></center</td>\n\t</tr>";

            }
        }
        $output1 .= "</table>";
        $output1 .= "<br/>";

        build_pagination_menu($records);
        echo $output1;
        build_pagination_menu($records);
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $output1 = "";
        $userID = $_SESSION['user'];

        $user_persons = pg_execute($conn, "user_get_persons_data", array($_SESSION['user']));
        $user_users = pg_execute($conn, "user_get_users_data", array($_SESSION['user']));
        $personsInfo = pg_fetch_assoc($user_persons);
        $usersInfo = pg_fetch_assoc($user_users);

        if (isset($_SESSION['dashboardMessage']) ? isset($_SESSION['dashboardMessage']) : '') {
            $newMessage = $_SESSION['dashboardMessage'];
            unset($_SESSION['dashboardMessage']);
        } else {
            $newMessage = '';
        }

        echo "<h2 style=\"color:red;\">" . $newMessage . "</h2>";
        echo "<h1>Welcome, " . $_SESSION['salutation'] . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name'] . "!</h1>" .
            "<h6>Last access: " . $usersInfo['last_access'] . "</h6>";
        echo "<h1> Listings of user: \"" . $userID . "\"</h1>";

        //Added a table for offensives

        $sql = "SELECT * FROM listings WHERE user_id = '$userID' ORDER BY date_created DESC;";
        $result = pg_query($conn, $sql);
        $records = pg_num_rows($result);

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

        //Removed all tables, it should only show the agent's listings that are not closed
        $output1 .= "	<table border=;'1' width='75%'>
				<tr><th width='23%''>listing ID</th><th width='23%'>Address</th><th width='10%''>listing status</th>
				<th width='23%'>price</th><th width='10%'>headline</th><th width='11%'>description</th>";
        for ($i = $listingsStart; $i < $listingsEnd; $i++) { //loop through all of the retrieved records and add to the output variable

            //Skipping hidden listings
            $skip = false;
            $status = pg_fetch_result($result, $i, "listing_status");
            if ($status != STATUS_OPEN) {
                $skip = true;
            }

            if (!$skip) {
                $output1 .= "\n\t<tr>\n\t\t<td>" . pg_fetch_result($result, $i, "listing_id") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "address") . " " . get_property(CITY, pg_fetch_result($result, $i, "city")) . " " . pg_fetch_result($result, $i, "postal_code") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "listing_status") . "</td>";
                $output1 .= "\n\t\t<td>" . '$' . pg_fetch_result($result, $i, "price") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "headline") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "description") . "</td></tr>";
                $output1 .= "\n\t\t<tr><td colspan=\"3\"><center><a href=\"./listing_update.php?listing_id=" . pg_fetch_result($result, $i, "listing_id") . "\">UPDATE</a></center></td>";
                $output1 .= "\n\t\t<td colspan=\"3\"><center><a href=\"./redirection.php?listing_id=" . pg_fetch_result($result, $i, "listing_id") . "\">VIEW</a></center</td>\n\t</tr>";

            }
        }
        $output1 .= "</table>";
        $output1 .= "<br/>";

        //Removed all tables, it should only show the agent's listings that are not closed
        $output1 .= "	<table border=;'1' width='75%'><caption>Sold and Closed<caption/>
					<tr><th width='23%''>listing ID</th><th width='23%'>Address</th><th width='10%''>listing status</th>
					<th width='23%'>price</th><th width='10%'>headline</th><th width='11%'>description</th>";
        for ($i = $listingsStart; $i < $listingsEnd; $i++) { //loop through all of the retrieved records and add to the output variable

            //Skipping hidden listings
            $skip = true;
            $status = pg_fetch_result($result, $i, "listing_status");
            if ($status == STATUS_CLOSED || $status == STATUS_SOLD) {
                $skip = false;
            }

            if (!$skip) {
                $output1 .= "\n\t<tr>\n\t\t<td>" . pg_fetch_result($result, $i, "listing_id") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "address") . " " . get_property(CITY, pg_fetch_result($result, $i, "city")) . " " . pg_fetch_result($result, $i, "postal_code") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "listing_status") . "</td>";
                $output1 .= "\n\t\t<td>" . '$' . pg_fetch_result($result, $i, "price") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "headline") . "</td>";
                $output1 .= "\n\t\t<td>" . pg_fetch_result($result, $i, "description") . "</td></tr>";
                $output1 .= "\n\t\t<tr><td colspan=\"3\"><center><a href=\"./listing_update.php?listing_id=" . pg_fetch_result($result, $i, "listing_id") . "\">UPDATE</a></center></td>";
                $output1 .= "\n\t\t<td colspan=\"3\"><center><a href=\"./redirection.php?listing_id=" . pg_fetch_result($result, $i, "listing_id") . "\">VIEW</a></center</td>\n\t</tr>";

            }
        }
        $output1 .= "</table>";
        $output1 .= "<br/>";

        build_pagination_menu($records);
        echo $output1;
        build_pagination_menu($records);
    }
} else {
    header("Location: index.php");
    ob_flush();
}
?>
	</center>
</div>
<?php include 'footer.php';?>