<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   		"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<link href="https://fonts.googleapis.com/css?family=Exo&display=swap" rel="stylesheet">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="./css/webd3201.css" />
	<!-- CHANGE THE HREF ABOVE TO webd2201.css AFTER YOU HAVE COPY AND PASTED THE CONTENTS OF style.css INTO IT -->
	<!--
	Author: Group#12
	-->
	<title>Real State Property Finder</title><!-- THE <title> WILL COME FROM A PHP VARIABLE TOO -->
	<?php
	require("./includes/constants.php");
	require("./includes/db.php");
	require("./includes/functions.php");
	if(session_id() == "")
	{
		session_start();
	}
	ob_start();
	?>
</head>
<body>
<div id="container">
	<div id="header">
		<img src="./images/styles/house_master-bgb.png" alt="YOUR SITE LOGO ALT" style="width:50px; height:50px;" />
		<h1>
			YDB Real Estate
		</h1>
	</div>
	<?php if(isset($_SESSION['message'])){
		echo "<h2>".$_SESSION['message']."</h2>";
		unset($_SESSION['message']);
	};?>
  <div id="sites" style="text-align:center" >
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="about.php">About</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="./css/webd3201.css">CSS file</a></li>
	  <li><a href="listing-select-city.php">Search</a></li>
      <?php
        $output = "";
        $conn = db_connect();

        if(isset($_SESSION['userType']) ? isset($_SESSION['userType']) : '')
        {

          $user = $_SESSION["userType"];
        }
        else
        {
          $user = "";
        }

        if($user == "")
        {
          $output .= "\n\t<li>\n\t\t<a href='login.php'>Sign In</a></li>";
          $output .= "\n\t<li>\n\t\t<a href='register.php'>Register</a></li>";
        }else{
          if($user == ADMIN){
            $output .= "\n\t<li>\n\t\t<a href='logout.php'>Log out</a></li>";
            $output .= "\n\t<li>\n\t\t<a href='listing-create.php'>Create a listing</a></li>"; //Removed access to dashboard
			      $output .= "\n\t<li>\n\t\t<a href='admin.php'>Admin Page</a></li>";
			      $output .= "\n\t<li>\n\t\t<a href='disabled-users.php'>Disabled Users	</a></li>"; //Added disabled-users.php
            $output .= "\n\t<li>\n\t\t<a href='user-update.php'>Update Profile</a></li>";
          }
          elseif ($user == CLIENT) {
            $output .= "\n\t<li>\n\t\t<a href='welcome.php'>Welcome Page</a></li>";
            $output .= "\n\t<li>\n\t\t<a href='logout.php'>Log out</a></li>";
            $output .= "\n\t<li>\n\t\t<a href='user-update.php'>Update Profile</a></li>";
          }
          elseif($user == AGENT){
            $output .= "\n\t<li>\n\t\t<a href='dashboard.php'>Dashboard</a></li>";
            $output .= "\n\t<li>\n\t\t<a href='listing-create.php'>Create a listing</a></li>";
            $output .= "\n\t<li>\n\t\t<a href='logout.php'>Log out</a></li>";
            $output .= "\n\t<li>\n\t\t<a href='user-update.php'>Update Profile</a></li>";
          }
        }


        echo $output;
      ?>

		</ul>
	</div>
	<div id="content-container">
		<div id="navigation" class="navigation">
		</div>
