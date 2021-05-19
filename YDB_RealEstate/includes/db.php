<?php

function db_connect() {
    $conn = pg_connect("host=".DB_HOST." port=".DB_PORT." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASSWORD );
    return $conn;
}
$conn = db_connect();

$stmt1 = pg_prepare($conn, "user_login", 'SELECT user_id, email_address, user_type, last_access, enrol_date FROM users WHERE user_id = $1 AND password = $2;');
$stmt2 = pg_prepare($conn, "user_update_last_access", "update users set last_access = $1 where user_id = $2;");
$stmt3 = pg_prepare($conn, "user_change_password_get_security_question", "select user_id, security_question from securityquestions where user_id = $1;");
$stmt4 = pg_prepare($conn, "user_change_password_check_security_question", "select user_id, security_answer from securityquestions where user_id = $1 and security_answer = $2;");
$stmt5 = pg_prepare($conn, "user_change_password", "update users set password = $1 where user_id = $2;");
$stmt6 = pg_prepare($conn, "user_check_if_admin", "select user_id, user_type from users where user_id = $1;");
$stmt7 = pg_prepare($conn, "user_get_persons_data", "select * from persons where user_id = $1;");
$stmt8 = pg_prepare($conn, "user_get_users_data", "select * from users where user_id = $1;");
$stmt9 = pg_prepare($conn, "listings_by_city","SELECT * FROM listings WHERE listing_status = 'o' AND city = $1 ORDER BY listing_id ASC LIMIT ".MAX_SEARCH_RESULTS.";");
$stmt10 = pg_prepare($conn, "listing_create",'insert into listings(listing_id,user_id,listing_status,price,headline,description,postal_code,images,address,city,property_options,bedrooms,bathrooms,parking_space,stories,cooling,heating,type_of_listing,date_created, last_update)'.
                            'values($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20);');
$stmt11 = pg_prepare($conn, "user_register", "INSERT INTO users(user_id, password, email_address, user_type, enrol_date, last_access) VALUES($1, $2, $3, $4, $5, $6)");
$stmt12 = pg_prepare($conn, "person_register", "INSERT INTO persons(user_id, salutation, first_name, last_name, street_address1, street_address2, city, province, postal_code,primary_phone_number,secondary_phone_number, fax_number, preferred_contact_method) VALUES ($1, $2, $3,$4, $5, $6, $7, $8, $9, $10, $11, $12, $13)");
$stmt13 = pg_prepare($conn, "update_listing", "update listings set listing_status=$1,price=$2,headline=$3,description=$4,postal_code=$5,images=$6,address=$7,city=$8,property_options=$9,bedrooms=$10,bathrooms=$11,parking_space=$12,stories=$13,cooling=$14,heating=$15,".
                            "type_of_listing=$16,last_update=$17 where listing_id=$18");
$stmt14 = pg_prepare($conn, "password_request", "select user_id, email_address from users where user_id = $1 and email_address = $2;");
$stmt15 = pg_prepare($conn, "from_favourites","SELECT listing_id, user_id, listing_status, price, headline, city, description, images FROM listings WHERE listing_id=$1 ORDER BY listing_id ASC LIMIT 10;"); //Added statement for favorites
$stmt15 = pg_prepare($conn, "favourites","SELECT listing_id FROM favourites WHERE user_id=$1 ORDER BY listing_id ASC LIMIT 10;"); //Added statement for favorites
$stmt16 = pg_prepare($conn, "add_favourite","INSERT INTO favourites(favourite_id, user_id,listing_id) VALUES($1,$2,$3);");
$stmt16 = pg_prepare($conn, "add_offensive","INSERT INTO offensives(user_id,listing_id,reported_on,status) VALUES($1,$2,$3,$4);");
$stmt17 = pg_prepare($conn,"delete_fav","DELETE FROM favourites WHERE user_id=$1 AND listing_id = $2;");
$stmt17 = pg_prepare($conn,"delete_off","DELETE FROM offensives WHERE listing_id = $1;");
$stmt18 = pg_prepare($conn, "owner_check","SELECT listing_id FROM listings WHERE  user_id = $1 AND listing_id=$2;");
$stmt19 = pg_prepare($conn, "update_user","UPDATE users SET email_address=$1, user_type=$2, last_access=$3 WHERE user_id=$4");
$stmt20 = pg_prepare($conn, "update_person","UPDATE persons SET salutation=$1,first_name=$2, last_name=$3, street_address1=$4, street_address2=$5,city=$6, province=$7, postal_code=$8,primary_phone_number=$9,secondary_phone_number=$10,fax_number=$11,preferred_contact_method=$12 WHERE user_id=$13");


function pg_presql($conn)
{
    pg_prepare($conn, "login_query", 'SELECT user_id, password
  FROM users WHERE user_id = $1 AND password = $2;');
}

function is_user_id($user_id)
{
    global $conn;
    $result = pg_query_params($conn, 'SELECT * FROM users WHERE user_id = $1 ', array($user_id));

    $records = pg_num_rows($result);

    if ($records == 0) {
        return false;
    } else if ($records == 1) {
        return true;
    }
}

function build_simple_dropdown($table_name, $value)
{
    global $conn;


    // Do a switch to select the correct case for every table
    switch ($table_name) {
        case CITY:
            $result = pg_query($conn, 'SELECT * FROM city;');
            $name = CITY;
            break;

        case BED:
            $result = pg_query($conn, 'SELECT * FROM bedrooms;');
            $name = BED;
            break;

        case BATH:
            $result = pg_query($conn, 'SELECT * FROM bathrooms;');
            $name = BATH;
            break;

        case PRPRT_OPTNS:
            $result = pg_query($conn, 'SELECT * FROM property_options;');
            $name = PRPRT_OPTNS;
            break;

        case LIST_STATUS:
            $result = pg_query($conn, 'SELECT * FROM listing_status;');
            $name = LIST_STATUS;
            break;

        case CONT_METHOD:
            $result = pg_query($conn, 'SELECT * FROM preferred_contact_method;');
            $name = CONT_METHOD;
            break;

        case PARKING:
            $result = pg_query($conn, 'SELECT * FROM parking_space;');
            $name = PARKING;
            break;

        case STORIES:
            $result = pg_query($conn, 'SELECT * FROM stories;');
            $name = STORIES;
            break;

        case PRICE:
            $result = pg_query($conn, 'SELECT * FROM price;');
            $name = PRICE;
            break;
        case HEAT:
            $result = pg_query($conn, 'SELECT * FROM heating;');
            $name = HEAT;
            break;
        case COOL:
            $result = pg_query($conn, 'SELECT * FROM cooling;');
            $name = COOL;
            break;
        case TYPE:
            $result = pg_query($conn, 'SELECT * FROM types_of_listing;');
            $name = TYPE;
            break;
        case EXT:
            $result = pg_query($conn, 'SELECT * FROM exterior;');
            $name = EXT;
            break;

        default:
            # code...
            break;
    }
    $output = "<select name='$name'>
    ";
    $options = pg_fetch_all($result);
    // var_dump($options);
    $j = 0;
    foreach ($options as $element) {
        $row = pg_fetch_assoc($result, $j);
        $property = $row["property"];
        $val = $row["value"];
        $output .= "<option value=\"$property\"";
        if ($val == $value) {
            $output .= " selected";
        }
        $output .= ">" . $property . "</option>
    ";
        $j++;
    }
    $output .= "
  </select>
  ";
    return $output;
}

function build_radio($table_name, $value)
{
    $conn = db_connect();
    $output = "";
    // Do a switch to select the correct case for every table
    switch ($table_name) {
        case CITY:
            $result = pg_query($conn, 'SELECT * FROM city;');
            $name = CITY;
            break;

        case BED:
            $result = pg_query($conn, 'SELECT * FROM bedrooms;');
            $name = BED;
            break;

        case BATH:
            $result = pg_query($conn, 'SELECT * FROM bathrooms;');
            $name = BATH;
            break;

        case PRPRT_OPTNS:
            $result = pg_query($conn, 'SELECT * FROM property_options;');
            $name = PRPRT_OPTNS;
            break;

        case LIST_STATUS:
            $result = pg_query($conn, 'SELECT * FROM listing_status;');
            $name = LIST_STATUS;
            break;

        case CONT_METHOD:
            $result = pg_query($conn, 'SELECT * FROM preferred_contact_method;');
            $name = CONT_METHOD;
            break;

        case PARKING:
            $result = pg_query($conn, 'SELECT * FROM parking_space;');
            $name = PARKING;
            break;

        case STORIES:
            $result = pg_query($conn, 'SELECT * FROM stories;');
            $name = STORIES;
            break;

        case PRICE:
            $result = pg_query($conn, 'SELECT * FROM price;');
            $name = PRICE;
            break;
        case HEAT:
            $result = pg_query($conn, 'SELECT * FROM heating;');
            $name = HEAT;
            break;
        case COOL:
            $result = pg_query($conn, 'SELECT * FROM cooling;');
            $name = COOL;
            break;
        case TYPE:
            $result = pg_query($conn, 'SELECT * FROM types_of_listing;');
            $name = TYPE;
            break;
        case EXT:
            $result = pg_query($conn, 'SELECT * FROM exterior;');
            $name = EXT;
            break;

        default:
            # code...
            break;
    }
    $options = pg_fetch_all($result);
    // var_dump($options);
    $i = 1;
    $j = 0;
    foreach ($options as $element) {
        $row = pg_fetch_assoc($result, $j);
        $property = $row["property"];
        $val = $row["value"];
        $output .= "<input type=\"radio\" name=\"$name\" value=\"$property\"";
        if ($val == $value) {
            $output .= " checked";
        }

        $output .= ">$property<br/>
    ";
        $i = $i * 2;
        $j++;
    }
    return $output;
}

function get_property($table_name, $value)
{
    global $conn;
    switch ($table_name) {
        case CITY:
            $result = pg_query_params($conn, 'SELECT * FROM city WHERE value=$1;', array($value));
            break;

        case BED:
            $result = pg_query_params($conn, 'SELECT * FROM bedrooms WHERE value=$1;', array($value));
            break;

        case BATH:
            $result = pg_query_params($conn, 'SELECT * FROM bathrooms WHERE value=$1;', array($value));
            break;

        case PRPRT_OPTNS:
            $result = pg_query_params($conn, 'SELECT * FROM property_options WHERE value=$1;', array($value));
            break;

        case LIST_STATUS:
            $result = pg_query_params($conn, 'SELECT * FROM listing_status WHERE value=$1;', array($value));
            break;

        case CONT_METHOD:
            $result = pg_query_params($conn, 'SELECT * FROM preferred_contact_method WHERE value=$1;', array($value));
            break;

        case PARKING:
            $result = pg_query_params($conn, 'SELECT * FROM parking_space WHERE value=$1;', array($value));
            break;

        case STORIES:
            $result = pg_query_params($conn, 'SELECT * FROM stories WHERE value=$1;', array($value));
            break;

        case PRICE:
            $result = pg_query_params($conn, 'SELECT * FROM price WHERE value=$1;', array($value));
            break;
        case HEAT:
            $result = pg_query_params($conn, 'SELECT * FROM heating WHERE value=$1;', array($value));
            break;
        case COOL:
            $result = pg_query($conn, 'SELECT * FROM cooling WHERE value=$1;', array($value));
            break;
        case TYPE:
            $result = pg_query($conn, 'SELECT * FROM types_of_listing WHERE value=$1;', array($value));
            break;

        case EXT:
            $result = pg_query_params($conn, 'SELECT * FROM exterior WHERE value=$1;', array($value));
            break;

        default:
            # code...
            break;
    }
    $options = pg_fetch_all_columns($result, 1);
    return $options[0];
}

function get_value($table_name, $property)
{
    global $conn;
    switch ($table_name) {
        case CITY:
            $result = pg_query_params($conn, 'SELECT * FROM city WHERE property=$1;', array($property));
            break;

        case BED:
            $result = pg_query_params($conn, 'SELECT * FROM bedrooms WHERE property=$1;', array($property));
            break;

        case BATH:
            $result = pg_query_params($conn, 'SELECT * FROM bathrooms WHERE property=$1;', array($property));
            break;

        case PRPRT_OPTNS:
            $result = pg_query_params($conn, 'SELECT * FROM property_options WHERE property=$1;', array($property));
            break;

        case LIST_STATUS:
            $result = pg_query_params($conn, 'SELECT * FROM listing_status WHERE property=$1;', array($property));
            break;

        case CONT_METHOD:
            $result = pg_query_params($conn, 'SELECT * FROM preferred_contact_method WHERE property=$1;', array($property));
            break;

        case PARKING:
            $result = pg_query_params($conn, 'SELECT * FROM parking_space WHERE property=$1;', array($property));
            break;

        case STORIES:
            $result = pg_query_params($conn, 'SELECT * FROM stories WHERE property=$1;', array($property));
            break;

        case PRICE:
            $result = pg_query_params($conn, 'SELECT * FROM price WHERE property=$1;', array($property));
            break;

        case EXT:
            $result = pg_query_params($conn, 'SELECT * FROM exterior WHERE property=$1;', array($property));
            break;

        case HEAT:
            $result = pg_query_params($conn, 'SELECT * FROM heating WHERE property=$1;', array($property));
            $name = HEAT;
            break;
        case COOL:
            $result = pg_query_params($conn, 'SELECT * FROM cooling WHERE property=$1;', array($property));
            $name = COOL;
            break;
        case TYPE:
            $result = pg_query_params($conn, 'SELECT * FROM types_of_listing WHERE property=$1;', array($property));
            $name = TYPE;
            break;
        default:
            # code...
            break;
    }
    $options = pg_fetch_all_columns($result, 0);
    return $options[0];
}

function build_checkbox($table_name, $value)
{
    global $conn;


    // Do a switch to select the correct case for every table
    switch ($table_name) {
        case CITY:
            $result = pg_query($conn, 'SELECT * FROM city;');
            $name = CITY;
            break;

        case BED:
            $result = pg_query($conn, 'SELECT * FROM bedrooms;');
            $name = BED;
            break;

        case BATH:
            $result = pg_query($conn, 'SELECT * FROM bathrooms;');
            $name = BATH;
            break;

        case PRPRT_OPTNS:
            $result = pg_query($conn, 'SELECT * FROM property_options;');
            $name = PRPRT_OPTNS;
            break;

        case LIST_STATUS:
            $result = pg_query($conn, 'SELECT * FROM listing_status;');
            $name = LIST_STATUS;
            break;

        case CONT_METHOD:
            $result = pg_query($conn, 'SELECT * FROM preferred_contact_method;');
            $name = CONT_METHOD;
            break;

        case PARKING:
            $result = pg_query($conn, 'SELECT * FROM parking_space;');
            $name = PARKING;
            break;

        case STORIES:
            $result = pg_query($conn, 'SELECT * FROM stories;');
            $name = STORIES;
            break;

        case PRICE:
            $result = pg_query($conn, 'SELECT * FROM price;');
            $name = PRICE;
            break;

        case EXT:
            $result = pg_query($conn, 'SELECT * FROM exterior;');
            $name = EXT;
            break;
        case HEAT:
            $result = pg_query($conn, 'SELECT * FROM heating;');
            $name = HEAT;
            break;
        case COOL:
            $result = pg_query($conn, 'SELECT * FROM cooling;');
            $name = COOL;
            break;
        case TYPE:
            $result = pg_query($conn, 'SELECT * FROM type_of_listing;');
            $name = TYPE;
            break;
        default:
            # code...
            break;
    }
    $output = "";
    $options = pg_fetch_all($result);
    $records=pg_num_rows($result);
    // var_dump($options);
    $j = 0;
    foreach ($options as $element) {
        $row = pg_fetch_assoc($result, $j);
        $property = $row["property"];
        $val = $row["value"];
        $output .= "<input type=\"checkbox\" name=".$name."[] value=\"$property\"";
        if (is_bit_set($j,$value)) {
            $output .= " checked";
        }
        $output.=">'$property' <br/>";
        $j++;
    }
    return $output;
}

function randomPassword() {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $characterLength = strlen($characters) - 1; //Put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $characterLength);
        $pass[] = $characters[$n];
    }
    return implode($pass); //Turns the array into a string
}

function output_dropdown($table_name, $value)
{
    global $conn;


    // Do a switch to select the correct case for every table
    switch ($table_name) {
        case CITY:
            $result = pg_query($conn, 'SELECT * FROM city;');
            $name = CITY;
            break;

        case BED:
            $result = pg_query($conn, 'SELECT * FROM bedrooms;');
            $name = BED;
            break;

        case BATH:
            $result = pg_query($conn, 'SELECT * FROM bathrooms;');
            $name = BATH;
            break;

        case PRPRT_OPTNS:
            $result = pg_query($conn, 'SELECT * FROM property_options;');
            $name = PRPRT_OPTNS;
            break;

        case LIST_STATUS:
            $result = pg_query($conn, 'SELECT * FROM listing_status;');
            $name = LIST_STATUS;
            break;

        case CONT_METHOD:
            $result = pg_query($conn, 'SELECT * FROM preferred_contact_method;');
            $name = CONT_METHOD;
            break;

        case PARKING:
            $result = pg_query($conn, 'SELECT * FROM parking_space;');
            $name = PARKING;
            break;

        case STORIES:
            $result = pg_query($conn, 'SELECT * FROM stories;');
            $name = STORIES;
            break;

        case PRICE:
            $result = pg_query($conn, 'SELECT * FROM price;');
            $name = PRICE;
            break;
        case HEAT:
            $result = pg_query($conn, 'SELECT * FROM heating;');
            $name = HEAT;
            break;
        case COOL:
            $result = pg_query($conn, 'SELECT * FROM cooling;');
            $name = COOL;
            break;
        case TYPE:
            $result = pg_query($conn, 'SELECT * FROM types_of_listing;');
            $name = TYPE;
            break;
        case EXT:
            $result = pg_query($conn, 'SELECT * FROM exterior;');
            $name = EXT;
            break;

        default:
            # code...
            break;
    }
    $output = "<select name='$name'>
    ";
    $options = pg_fetch_all($result);
    // var_dump($options);
    $j = 0;
    foreach ($options as $element) {
        $row = pg_fetch_assoc($result, $j);
        $property = $row["property"];
        $val = $row["value"];
        $output .= "<option value=\"$property\"";
        if ($val == $value) {
            $output .= " selected";
        }
        $output .= ">" . $property . "</option>
    ";
        $j++;
    }
    $output .= "
  </select>
  ";
    return (string) $property;
}

?>
