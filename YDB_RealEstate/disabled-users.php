
<?php
require "./header.php";
?>
<div class="content">
	<center>
		<?php
if ($user == ADMIN) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id=array_keys($_POST);
        $sql_enable="UPDATE users SET user_type='a' WHERE user_id='".$user_id[0]."';";
        $result_enable=pg_query($conn,$sql_enable);
    }
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


    
    //Table of disabled users
    $sql_off = "SELECT user_id  FROM users WHERE user_type LIKE 'd%' ";
    $result_off = pg_query($conn, $sql_off);
    $offensives = pg_fetch_all_columns($result_off);
    if ($offensives != null) {
        $offs = sizeof($offensives);
        $output1 .= "	<table border=;'1' width='75%'><caption>Disabled users</caption>
            <th width='23%''>User ID</th><th width='23%'>First Name</th><th width='10%''>Last Name</th>
              <th width='23%'>Preffered contact method</th><th width='10%'>Phone</th><th>Restore user</th>";
        for ($i = 0; $i < $offs; $i++) { //loop through all of the retrieved records and add to the output variable
            $result_favs = pg_execute("user_get_persons_data", array($offensives[$i]));
            $result_favs = pg_fetch_assoc($result_favs);
            $user_id = $result_favs['user_id'];
            $output1 .= "\n\t<tr>\n\t\t<td>" . $user_id . "</td>";
            $output1 .= "\n\t\t<td>" . $result_favs['first_name'] . "</td>";
            $output1 .= "\n\t\t<td>" . $result_favs['last_name'] . "</td>";
            $output1 .= "\n\t\t<td>" . get_property(CONT_METHOD, $result_favs['preferred_contact_method']) . "</td>";
            $output1 .= "\n\t\t<td>" . $result_favs['primary_phone_number'] . "</td>";
            $output1 .= "\n\t\t<td><input type=\"submit\" name=\"".$user_id."\" value=\"Enable\"></td>\n\t</tr>";
        }
        $output1 .= "</table>";
        $output1 .= "<br/><br/><hr/>";
    }
    echo "<form action=" . $_SERVER['PHP_SELF'] . " method=\"POST\">";
    echo $output1;
    echo "</form>";
} else {
    header("Location: index.php");
    ob_flush();
}
?>
	</center>
</div>
<?php include 'footer.php';?>