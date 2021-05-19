<!-- Group #: 12
     File Name: logout.php
     Date: 2019-10-03
     Description: This is the logout page for the session, this will unset the session, destroy the session, and restart the session.
                  This will also redirect the page.
-->
<?php
$title = "Logout";
include("header.php");

if (!isset($_SESSION['user'])) {
  header("LOCATION: login.php");
  ob_flush();
}
?>
<div class="content">
  <h1><?php echo $title; ?></h1>
  <p>Are you sure you want to log out of your account?</p>
  <center>
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="POST">
      <input type="submit" class="button" name="logout" value="Log Out" />
    </form>
  </center>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $output = "";

  if (isset($_SESSION)) {
    session_unset($_SESSION);
    session_destroy();
    session_start();
    $output .= "You have been succesfully logged out!";
    $_SESSION['output'] = $output;
    header('Location: ./login.php');
    ob_flush();
  } else {
    $output .= "There were errors Logging you out please try again!\n";
    $_SESSION['output'] = $output;
  }
}
include("footer.php");
?>