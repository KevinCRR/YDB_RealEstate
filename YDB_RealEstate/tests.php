<?php
	$title = "Contact us";
    include("./header.php");
    
    
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    echo "This is the get part";
}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $multiple_selection = $_POST[CITY];
    // var_dump($_POST[CITY]);
    foreach ($_POST[CITY] as $value) {
        echo "This is one of the selected cities: ".$value."<br/>";
    }
}
?>
			
		<div class="content">	
			<h1>Contact us</h1><hr>
				<div class="right-side-menu">
                    <br>
                    <p>Now testing the number 1234567890</p>
                    <?php echo display_phone_number(1234567890); ?>
                    <p>Now testing 12345678901234</p>
                    <?php echo display_phone_number(12345678901234); ?>
                    <p>Now testing 1234</p>
                    <?php echo display_phone_number(1234); ?>
                    <p>Now testing 12345678901234456789</p>
                    <?php echo display_phone_number(12345678901234456789); ?>
                    <p>Now testing the postal code A1A 2B2</p>
                    <?php $result= is_valid_postal_code("A1A 2B2"); if($result){echo "Yes, a postal code";} else {
                        echo "No, not a postal code";
                    } ?>
                    <p>Now testing the postal code A11 2B2</p>
                    <?php $result= is_valid_postal_code("A11 2B2"); if($result){echo "Yes, a postal code";} else {
                        echo "No, not a postal code";
                    } ?>
                    <p>Now testing the postal code A1A-2B2</p>
                    <?php $result= is_valid_postal_code("A1A-2B2"); if($result){echo "Yes, a postal code";} else {
                        echo "No, not a postal code";
                    } ?>
                    <p>Now testing the postal code aaa 111</p>
                    <?php $result= is_valid_postal_code("aaa 111"); if($result){echo "Yes, a postal code";} else {
                        echo "No, not a postal code";
                    } ?>
                    <p>Now testing the postal code random string</p>
                    <?php $result= is_valid_postal_code("random string"); if($result){echo "Yes, a postal code";} else {
                        echo "No, not a postal code";
                    } ?>
                    <p>Now testing the postal code 123456</p>
                    <?php $result= is_valid_postal_code("123456"); if($result){echo "Yes, a postal code";} else {
                        echo "No, not a postal code";
                    } ?>

                    <h1>Now testing the db</h1>
                    <p>Testing the create radio one, having 8 as the default value and city as the table name</p>
                    <?php echo build_radio(CITY,8);?>
                    <p>Testing the create radio one, table is bedrooms</p>
                    <?php echo build_radio(BED,64);?>
                    <p>Testing the create radio one, table is preferred contact method</p>
                    <?php echo build_radio(CONT_METHOD,'e');?>

                    <p>Testing the create dropdown one, table is city</p>
                    <?php echo build_simple_dropdown(CITY,8);?>
                    <p>Testing the create dropdown one, table is contact method</p>
                    <?php echo build_simple_dropdown(CONT_METHOD,'l');?>
                    <p>Testing the create dropdown one, table is exterior</p>
                    <?php echo build_simple_dropdown(CONT_METHOD,'l');?>

                    <p>Testing the get property method with city,64</p>
                    <?php echo get_property(CITY,64);?>
                    <p>Testing the get property method with table contact method,p</p>
                    <?php echo get_property(CONT_METHOD,'p');?>

                    <p>Testing the is_user_id method with jdoe</p>
                    <?php if (is_user_id('jdoe')) {echo "It is";} else {echo "It's not";};?>
                    <p>Testing the is_user_id method with random_user</p>
                    <?php if (is_user_id('random_user')) {echo "It is";} else {echo "It's not";};?>
                    <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
					<br>
                    <p>Testing the create checkbox one, table is city</p>
                    <?php echo build_checkbox(CITY,8);?>
                    <input type="submit" value="Submit">
				</form>

				</div>
			</div>
			<hr>
		</div>	
<?php 
	include("./footer.php");
?>		