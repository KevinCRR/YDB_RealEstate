<?php
	$title = "About us";
    include("./header.php");


if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if (isset($_GET["id"])) {
        $city=$_GET["id"];
        $_SESSION[CITY]=get_property(CITY,$city);
        var_dump($_SESSION);
				setcookie("CitySearch",$_SESSION[CITY],COOKIE_LIFESPAN);
        header("LOCATION: listing-search.php?id=".$city);
        ob_flush();
    }
    elseif (isset($_GET['listing_id'])) {
        $id=$_GET['listing_id'];
				setcookie("CitySearch",$id,COOKIE_LIFESPAN);
        var_dump($_SESSION);
        header("LOCATION: listing-display.php?id=".$id);
        ob_flush();
    }
    elseif (isset($_GET['unfav_id'])) {
        $listing_id=$_GET['unfav_id'];
        $user_id=$_GET['user_id'];
        $result=pg_execute("delete_fav",array($user_id,$listing_id));
        $_SESSION['message']="Deleted favourite!";
        header("LOCATION: welcome.php");
        ob_flush();
    }
    else {
        echo "<h1>You're not supposed to be here</h1>";
        session_destroy();
    }

}
else {
    echo "<h3>What are you doing here?<h3/>";
}
include("./footer.php");
?>
