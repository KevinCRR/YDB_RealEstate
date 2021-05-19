<?php

function display_copyright()
{
    echo " <a href=\"http://validator.w3.org/check?uri=referer\">
    <img 	style=\"width:88px;
                height:31px;\"
            src=\"http://www.w3.org/Icons/valid-xhtml10\"
            alt=\"Valid XHTML 1.0 Strict\" />
</a>
     <a href=\"http://jigsaw.w3.org/css-validator/check/referer\">
        <img 	style=\"width:88px;
                    height:31px;\"
                src=\"http://jigsaw.w3.org/css-validator/images/vcss\"
                alt=\"Valid CSS!\" />
</a>
&copy; Site name,
";
    $today = date("d/m/Y");
    echo $today;
}

function dump($arg)
{
    echo "<pre>";
    echo (is_array($arg)) ? print_r($arg) : $arg;
    echo "</pre>";
}

function display_phone_number($number)
{
//     //eliminate every char except 0-9
    //     $justNums = preg_replace("/[^0-9]/", '', $number);

// //eliminate leading 1 if its there
    //     if (strlen($justNums) == 11) {
    //         $justNums = preg_replace("/^1/", '', $justNums);
    //     }

// //if we have 10 digits left, it's probably valid.
    //     if (strlen($justNums) == 10) {
    //         $isPhoneNum = true;
    //     }
    $result = "";
    if (is_numeric($number)) {
        $digits = str_split($number);
        if (sizeof($digits) == PHONE_NUMBER_LENGTH) {
            $result = "(" . $digits[0] . $digits[1] . $digits[2] . ")" . $digits[3] . $digits[4] . $digits[5] . "-" . $digits[6] . $digits[7] . $digits[8] . $digits[9];
            return $result;
        } else if (sizeof($digits) > PHONE_NUMBER_LENGTH) {
            if (sizeof($digits == PHONE_EXT_LENGTH)) {
                $result = "(" . $digits[0] . $digits[1] . $digits[2] . ")" . $digits[3] . $digits[4] . $digits[5] . "-" . $digits[6] . $digits[7] . $digits[8] . $digits[9] . " ext. " . $digits[10] . $digits[11] . $digits[12] . $digits[13];
                return $result;
            } else {
                $result = "Length of the number is higher than " . PHONE_EXT_LENGTH;
                return $result;
            }
        } else {
            $result = "Length of the number is lower than " . PHONE_NUMBER_LENGTH;
            return $result;
        }
    }

}

function is_valid_postal_code($code)
{
    // Regex obtained from: https://stackoverflow.com/questions/11149678/validate-canadian-postal-code-regex
    if (preg_match("/^[a-z][0-9][a-z][- ]?[0-9][a-z][0-9]$/i", $code)) {
        return true;
    } else {
        return false;
    }
}

function build_listing_preview($page, $listings)
{
    for ($i = ($page - 1) * 10; $i < $page * 10 && $i < $listings; $i++) {
        echo $i;
    }
}

function build_pagination_menu($records)
{
    if ($records != 0) {
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
        $pages = ceil($records / SEARCH_RESULTS_PER_PAGE);
        for ($i = 1; $i <= $pages; $i++) {
            if ($i == 1 && $page != 1) {
                ?>
				<a href="?page=1">&lt;&lt;</a>
				<a href="?page=<?php echo $page - 1; ?>">&lt;</a>
				<?php
}
            if ($i == $page) {
                ?>
				<a href="?page=<?php echo $i; ?>"><strong><?php echo $i; ?></strong></a>
				<?php
} else {
                ?>
				<a href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
				<?php
}
            if ($i == $pages && $page != $pages) {
                ?>
				<a href="?page=<?php echo $page + 1; ?>">&gt;</a>
				<a href="?page=<?php echo $pages; ?>">&gt;&gt;</a>
				
				<?php
}
        }
    }
}
/*
this function can be passed an array of numbers (like those submitted as
part of a named[] check box array in the $_POST array).
 */
function sum_check_box($array)
{
    $num_checks = count($array);
    $sum = 0;
    for ($i = 0; $i < $num_checks; $i++) {
        $sum += $array[$i];
    }
    return $sum;
}
/*
this function should be passed a integer power of 2, and any decimal number,
it will return true (1) if the power of 2 is contain as part of the decimal argument
 */
function is_bit_set($power, $decimal)
{
    if ((pow(2, $power)) & ($decimal)) {
        return 1;
    } else {
        return 0;
    }

}

// //Upload function
function upload_image($file,$listing_id)
{
    $_FILES=$file;
    $message="";
    //Check if target dir exists
    $target_dir = "images/".$listing_id."/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir,0777);
    }
    $uploadOk = 1;
    for ($i=0; $i < MAX_UPLOADS; $i++) { 
        $target_file = $target_dir . basename($listing_id."_".$i).".jpg";
        if ($i==0) {
            $target_file = $target_dir . basename($listing_id)."_main.jpg";
            if (!file_exists($target_file)) {
                break;
            }
        }
        elseif (!file_exists($target_file)){
            break;
        }
        if ($i==(MAX_UPLOADS-1)) {
            if (file_exists($target_file)){
                $message.= "This was the last chance, all files taken";
                $uploadOk=0;
            }
        }
    }
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
        $check = getimagesize($file["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $message.= "File is not an image.";
            $uploadOk = 0;
        }
// Check if file already exists
    if (file_exists($target_file)) {
        $message.= "Sorry, file already exists.";
        $uploadOk = 0;
    }
// Check file size
    if ($file["size"] > 100000) {
        $message.= "Sorry, your file is too large.";
        $uploadOk = 0;
    }
// Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
            $message.= "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
// Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $message.= " Your file was not uploaded.";
        $_SESSION['upload_message']=$message;
		return "error";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $message.= "The file " . basename($file["name"]) . " has been uploaded.";
            $_SESSION['upload_message']=$message;
			return $target_file;
        } else {
            $message.= "Sorry, there was an error uploading your file.";
            $_SESSION['upload_message']=$message;
			return "error";
        }
    }
}

?>

