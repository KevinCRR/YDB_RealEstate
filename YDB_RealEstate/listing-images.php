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
if ($user == AGENT) {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $output1 = "";
        $user_id = $_SESSION['user'];
        $listing_id = $_GET['id'];
        $_SESSION['listing_id'] = $listing_id;
        $result = pg_execute($conn, "owner_check", array($user_id, $listing_id));
        $checker = pg_fetch_all($result);
        if (!$checker) {
            $_SESSION['dashboardMessage'] = "That is not your listing to change";
            header("Location: dashboard.php");
            ob_flush();
        }
        $target_dir = "images/" . $listing_id . "/";
        if (is_dir($target_dir)) {
            $num_images = sizeof(scandir($target_dir)) - 2;
            if ($num_images != -0) {
                $output1 .= "	<table border='1' width='75%'><caption>Available images<caption/>
                <tr><th style='witdh:23%'>Image</th><th style='width:23%'>Select?</th><th style='width:10%'>Delete?</th>";
    
                for ($i = 0; $i < $num_images; $i++) {
                    if ($i == 0) {
                        $img_src = "images/" . $listing_id . "/" . $listing_id . "_main.jpg";
                        $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Main image\" height=\"260\" width=\"389\"/></td>";
                        $output1 .= "\n\t\t<td><input type=\"radio\" name=\"main\" value=\"" . $i . "\" checked>Main Image<br></td>";
                        $output1 .= "\n\t\t<td><input type=\"checkbox\" name=\"del[]\" value=\"".$i."\"></td>\n\t</tr>";
                    } else {
                        $img_src = "images/" . $listing_id . "/" . $listing_id . "_" . $i . ".jpg";
                        $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Image of home\" height=\"260\" width=\"389\"/></td>";
                        $output1 .= "\n\t\t<td><input type=\"radio\" name=\"main\" value=\"" . $i . "\"> Image number " . $i . "<br></td>";
                        $output1 .= "\n\t\t<td><input type=\"checkbox\" name=\"del[]\" value=\"".$i."\"></td>\n\t</tr>";
                    }
                }
                $output1 .= "</table>";
                $output1 .= "<br/>";
            }
        }

    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $listing_id = $_SESSION['listing_id'];
        $target_dir = "images/" . $listing_id . "/".$listing_id;
        if (isset($_POST['img_change'])) {
            if (isset($_POST['del'])) {
                $to_delete=$_POST['del'];
                $to_del_size=sizeof($to_delete);
                $target_dir_m = "images/" . $listing_id . "/";
                $num_images = sizeof(scandir($target_dir_m)) - 2;
                if ($to_del_size==$num_images) {
                    $skip=true;
                }
                foreach ($to_delete as $key => $value) {
                    if ($value == 0) {
                        $target_file = $target_dir."_main.jpg";
                        $main_del=true;
                    }
                    else {
                        $target_file = $target_dir ."_".$value.".jpg";
                    }
                    if (unlink($target_file)) {
                        $_SESSION['deletion_message']="Deleted file: ".$target_file;
                    }
                    else {
                        $_SESSION['deletion_message']="Error in deleting file: ".$target_file;
                    }
                }
                $target_dir_m = "images/" . $listing_id . "/";
                $num_images = sizeof(scandir($target_dir_m)) - 2;
                $sql = "UPDATE listings SET images ='" . $num_images . "' WHERE listing_id ='" . $listing_id . "';";
                $result = pg_query($conn, $sql);
                if (isset($main_del)) {
                    if (isset($skip)) {
                    }
                    else {
                        if ($num_images!=0) {
                            $main = $target_dir."_main.jpg";
                            for ($i=MAX_UPLOADS; $i >0; $i--) { 
                                if (is_file($target_dir."_".$i.".jpg")) {
                                    $max_image=$i;
                                    break;
                                }
                            }
                            $target_file = $target_dir."_".$max_image.".jpg";
                            $rename_result=rename($target_file, $main);
                            if ($rename_result) {
                                $_SESSION['main_img_message']="Renamed old to main completed";
                            }
                            else {
                                $_SESSION['main_img_message']="Rename to main faled";
                            }
                        }
                    }
                }
            }
            if (isset($_POST['main'])) {

                $main_index=$_POST['main'];
                if ($main_index!=0) {
                    //Rename to temp name
                    $main = $target_dir."_main.jpg";
                    $temp_name = $target_dir ."_11.jpg";
                    $target_file = $target_dir."_".$main_index.".jpg";
                    $rename_result=rename($main, $temp_name);
                    if ($rename_result) {
                        $_SESSION['main_img_message']="Renamed main completed";
                        //Rename selected one to main
                        $rename_result=rename($target_file, $main);

                        if ($rename_result) {
                            $_SESSION['main_img_message']="Renamed old to main completed";
                            //Rename old main to target file original name
                            $rename_result=rename($temp_name, $target_file);
    
                            if ($rename_result) {
                                $_SESSION['main_img_message']="Renamed old main to target file completed";
                            }
                            else {
                                $_SESSION['main_img_message']="Renamed old main to target file failed";
                            }
                        }
                        else {
                            $_SESSION['main_img_message']="Rename to main faled";
                        }
                    }
                    else {
                        $_SESSION['main_img_message']="Rename main faled";
                    }
                }
            }
            $output1 = "";
            $user_id = $_SESSION['user'];
            $result = pg_execute($conn, "owner_check", array($user_id, $listing_id));
            $checker = pg_fetch_all($result);
            if (!$checker) {
                $_SESSION['dashboardMessage'] = "That is not your listing to change";
                header("Location: dashboard.php");
                ob_flush();
            }
            $sql = "SELECT images FROM listings WHERE listing_id='" . $listing_id . "';";
            $result = pg_query($conn, $sql);
            $target_dir = "images/" . $listing_id . "/";
            $num_images = sizeof(scandir($target_dir)) - 2;
            if ($num_images != 0) {
                $output1 .= "	<table border='1' width='75%'><caption>Available images<caption/>
            <tr><th style='witdh:23%'>Image</th><th style='width:23%'>Select?</th><th style='width:10%'>Delete?</th>";

                for ($i = 0; $i < $num_images; $i++) {
                    if ($i == 0) {
                        $img_src = "images/" . $listing_id . "/" . $listing_id . "_main.jpg";
                        $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Main image\" height=\"260\" width=\"389\"/></td>";
                        $output1 .= "\n\t\t<td><input type=\"radio\" name=\"main\" value=\"" . $i . "\" checked>Main Image<br></td>";
                        $output1 .= "\n\t\t<td><input type=\"checkbox\" name=\"del[]\" value=\"".$i."\"></td>\n\t</tr>";
                    } else {
                        $img_src = "images/" . $listing_id . "/" . $listing_id . "_" . $i . ".jpg";
                        $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Image of home\" height=\"260\" width=\"389\"/></td>";
                        $output1 .= "\n\t\t<td><input type=\"radio\" name=\"main\" value=\"" . $i . "\"> Image number " . $i . "<br></td>";
                        $output1 .= "\n\t\t<td><input type=\"checkbox\" name=\"del[]\" value=\"".$i."\"></td>\n\t</tr>";
                    }
                }
                $output1 .= "</table>";
                $output1 .= "<br/>";
            }
        }
        else {
            //File was uploaded
            $listing_id = $_SESSION['listing_id'];
            $target_dir = "images/" . $listing_id . "/";
            $max_allowed=false;
            if (is_dir($target_dir)) {
                $num_images = sizeof(scandir($target_dir)) - 2;
                if ($num_images == MAX_UPLOADS) {
                    $max_reached="You have uploaded the maximum amount of images for this listing, please delete one or more and try again.";
                    $max_allowed=true;
                }
            }
            if (upload_image($_FILES['image'], $listing_id) != "error" && !$max_allowed) {
                $sql = "SELECT images FROM listings WHERE listing_id='" . $listing_id . "';";
                $result = pg_query($conn, $sql);
                $target_dir = "images/" . $listing_id . "/";
                $num_images = sizeof(scandir($target_dir)) - 2;
                $sql = "UPDATE listings SET images ='" . $num_images . "' WHERE listing_id ='" . $listing_id . "';";
                $result = pg_query($conn, $sql);
            }
            $output1 = "";
            $user_id = $_SESSION['user'];
            $result = pg_execute($conn, "owner_check", array($user_id, $listing_id));
            $checker = pg_fetch_all($result);
            if (!$checker) {
                $_SESSION['dashboardMessage'] = "That is not your listing to change";
                header("Location: dashboard.php");
                ob_flush();
            }
            $sql = "SELECT images FROM listings WHERE listing_id='" . $listing_id . "';";
            $result = pg_query($conn, $sql);
            $target_dir = "images/" . $listing_id . "/";
            $num_images = sizeof(scandir($target_dir)) - 2;
            if ($num_images != 0) {
                $output1 .= "	<table border='1' width='75%'><caption>Available images<caption/>
            <tr><th style='witdh:23%'>Image</th><th style='width:23%'>Select?</th><th style='width:10%'>Delete?</th>";

                for ($i = 0; $i < $num_images; $i++) {
                    if ($i == 0) {
                        $img_src = "images/" . $listing_id . "/" . $listing_id . "_main.jpg";
                        $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Main image\" height=\"260\" width=\"389\"/></td>";
                        $output1 .= "\n\t\t<td><input type=\"radio\" name=\"main\" value=\"" . $i . "\" checked>Main Image<br></td>";
                        $output1 .= "\n\t\t<td><input type=\"checkbox\" name=\"del[]\" value=\"".$i."\"></td>\n\t</tr>";
                    } else {
                        $img_src = "images/" . $listing_id . "/" . $listing_id . "_" . $i . ".jpg";
                        $output1 .= "\n\t<tr>\n\t\t<td><img src=\"" . $img_src . "\" alt=\"Image of home\" height=\"260\" width=\"389\"/></td>";
                        $output1 .= "\n\t\t<td><input type=\"radio\" name=\"main\" value=\"" . $i . "\"> Image number " . $i . "<br></td>";
                        $output1 .= "\n\t\t<td><input type=\"checkbox\" name=\"del[]\" value=\"".$i."\"></td>\n\t</tr>";
                    }
                }
                $output1 .= "</table>";
                $output1 .= "<br/>";
            }
        }
    }
} elseif ($user == CLIENT) {
    header("Location: welcome.php");

    ob_flush();
} else {
    header("Location: index.php");

    ob_flush();
}

?>
<div class="content">
    <center>
        <?php
        if (isset($_SESSION['upload_message'])) {
            echo "<h3>" . $_SESSION['upload_message'] . "<h3/>";
            unset($_SESSION['upload_message']);
        }
        if (isset($_SESSION['deletion_message'])) {
            echo "<h3>" . $_SESSION['deletion_message'] . "<h3/>";
            unset($_SESSION['deletion_message']);
        }
        if (isset($_SESSION['main_img_message'])) {
            echo "<h3>" . $_SESSION['main_img_message'] . "<h3/>";
            unset($_SESSION['main_img_message']);
        }

        if (isset($max_reached)) {
            echo "<h2>".$max_reached."<h2/>";
        }
        echo $output1;
        if ($output1=="") {
            echo "<h2>There are no images associated with this listing<h2/>";
        }
        echo "<form action=" . $_SERVER['PHP_SELF'] . " method=\"post\">";
        echo "<input type=\"submit\" value=\"Process Changes to Images\" name=\"img_change\"></form>";
        echo "<form action=" . $_SERVER['PHP_SELF'] . " method=\"post\" enctype=\"multipart/form-data\">
        Select image to upload:
        <input type=\"file\" name=\"image\" id=\"fileToUpload\" accept=\"image/jpeg\">
        <input type=\"submit\" value=\"Upload Image\" name=\"submit\">
        </form>";
        ?>
    </center>

</div>
<?php include 'footer.php'; ?>