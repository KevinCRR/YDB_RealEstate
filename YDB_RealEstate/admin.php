<?php
$title = "Admin";
$file = "admin.php";
$description = "Welcome page after successful login";
$date = "September 27, 2019";
$banner = "Welcome Page";
include "./header.php";
$output1 = "";
if ($user == ADMIN) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $options=$_POST;
        foreach ($options as $key => $value) {
            $type=explode("_",$key);
            if ($type[0]=="userChange") {
                if ($value=="Accept") {
                    $sql= "UPDATE users SET user_type='a' WHERE user_id='".$type[1]."';";
                    $result=pg_query($conn,$sql);
                }
                else {
                    $sql="SELECT user_type FROM users  WHERE user_id='".$type[1]."';";
                    $result = pg_query($conn, $sql);
                    $row = pg_fetch_all($result);
                    $previous_type=$row[0]['user_type'];
                    $sql= "UPDATE users SET user_type='d".$previous_type."' WHERE user_id='".$type[1]."';";
                    $result=pg_query($conn,$sql);
                }
            }
            if ($type[0]=="listingChange") {
                if ($value=="Hide") {
                    $sql= "UPDATE listings SET listing_status='h' WHERE listing_id='".$type[1]."';";
                    $result=pg_query($conn,$sql);
                    $result=pg_execute("delete_off",array($type[1]));
                }
                else {
                    $sql= "UPDATE listings SET listing_status='o' WHERE listing_id='".$type[1]."';";
                    $result=pg_query($conn,$sql);
                    $result=pg_execute("delete_off",array($type[1]));
                    $sql = "SELECT user_id FROM listings WHERE listing_id ='" . $type[1] . "'";
                    $result = pg_query($conn, $sql);
                    $row = pg_fetch_all($result);
                    $sql= "UPDATE users SET user_type='a' WHERE user_id='".$row[0]['user_id']."';";
                    $result=pg_query($conn,$sql);

                }
            }
                
        }
    }
	$output1 = "";
	$userID = $_SESSION['user'];

	$user_persons = pg_execute($conn, "user_get_persons_data", array($_SESSION['user']));
	$user_users = pg_execute($conn, "user_get_users_data", array($_SESSION['user']));
	$personsInfo = pg_fetch_assoc($user_persons);
	$usersInfo = pg_fetch_assoc($user_users);

	

    //Table for pending agents
    $sql_off = "SELECT user_id  FROM users WHERE user_type ='" . PENDING . "';";
    $result_off = pg_query($conn, $sql_off);
    $pendings = pg_fetch_all_columns($result_off);
    if ($pendings != null) {
        $offs = sizeof($pendings);
        $output1 .= "	<table border=;'1' width='75%'><caption>Pending users</caption>
			<th width='17%''>User ID</th><th width='17%'>First Name</th><th width='17%''>Last Name</th>
			  <th width='15%'>Preffered contact method</th><th width='16%'>Phone</th><th width='16%'>Accept or Deny</th>";
        for ($i = 0; $i < $offs; $i++) { //loop through all of the retrieved records and add to the output variable
            $result_favs = pg_execute("user_get_persons_data", array($pendings[$i]));
            $result_favs = pg_fetch_assoc($result_favs);
            $user_id = $result_favs['user_id'];
            $output1 .= "\n\t<tr>\n\t\t<td>" . $user_id . "</td>";
            $output1 .= "\n\t\t<td>" . $result_favs['first_name'] . "</td>";
            $output1 .= "\n\t\t<td>" . $result_favs['last_name'] . "</td>";
            $output1 .= "\n\t\t<td>" . get_property(CONT_METHOD, $result_favs['preferred_contact_method']) . "</td>";
            $output1 .= "\n\t\t<td>" . $result_favs['primary_phone_number'] . "</td>";
            $output1 .= "\n\t\t<td><input type=\"submit\" name=\"userChange_".$user_id."\" value=\"Disable\"><input type=\"submit\" name=\"userChange_".$user_id."\" value=\"Accept\"></td>\n\t</tr>";
        }
        $output1 .= "</table>";
        $output1 .= "<br/><br/><hr/>";
    }

    //Table for offensives
    $sql = "SELECT * FROM offensives;";
    $result_offs = pg_query($conn, $sql);
    $records_offs = pg_num_rows($result_offs);
    $out_offs = pg_fetch_all($result_offs);
    if ($records_offs != 0) {
        $output1 .= "	<table border=;'1' width='75%'><caption>Marked as offensive</caption>
							<th width='23%''>listing ID</th><th width='23%''>Marked by user ID</th><th width='23%'>Owned by user ID</th><th width='10%''>listing status</th>
							  <th width='23%'>price</th><th width='10%'>headline</th><th width='10%'>city</th><th width='11%'>description</th><th width='10%'>Hide or Remove from Offensives</th>";
        for ($i = 0; $i < $records_offs; $i++) { //loop through all of the retrieved records and add to the output variable
                $result_offs = pg_execute("from_favourites", array($out_offs[$i]['listing_id']));
                $result_offs = pg_fetch_assoc($result_offs);
                $listing_id = $result_offs['listing_id'];
                $output1 .= "\n\t<tr>\n\t\t<td><a href=\"./redirection.php?listing_id=" . $listing_id . "\">" . $listing_id . "</a></td>";
                $output1 .= "\n\t\t<td>" . $out_offs[$i]['user_id'] . "</td>";
                $output1 .= "\n\t\t<td>" . $result_offs['user_id'] . "</td>";
                $output1 .= "\n\t\t<td>" . $result_offs['listing_status'] . "</td>";
                $output1 .= "\n\t\t<td>" . '$' . $result_offs['price'] . "</td>";
                $output1 .= "\n\t\t<td>" . $result_offs['headline'] . "</td>";
                $output1 .= "\n\t\t<td>" . get_property(CITY, $result_offs['city']) . "</td>";
                $output1 .= "\n\t\t<td>" . $result_offs['description'] . "</td>";
                $output1 .= "\n\t\t<td><input type=\"submit\" name=\"listingChange_".$listing_id."\" value=\"Hide\"><input type=\"submit\" name=\"listingChange_".$listing_id."\" value=\"Not Offensive\"></td>\n\t</tr>";

        }
        $output1 .= "</table>";
        $output1 .= "<br/><br/><hr/>";
    }

}
else {
	header("Location: index.php");
    ob_flush();
}
?>
<div class="content">
<center>
	<h1>Welcome, <?php echo $_SESSION['salutation'] . " " . $_SESSION['first_name'] . " " . $_SESSION['last_name']; ?>!</h1>
	<h6>Last access: <?php echo $usersInfo['last_access']; ?></h6>
    <?php     
    echo "<form action=" . $_SERVER['PHP_SELF'] . " method=\"POST\">";
    echo $output1; 
    echo "</form>";
    ?>
</center>
</div>
<?php include "./footer.php";
?>