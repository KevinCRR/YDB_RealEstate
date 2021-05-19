<?php

	$title = "Update Listing";
	$file = "";
	$description = "";
	$date = "March 30, 2019";
	$banner = "";

	require("./header.php");
?>


<?php
if($_SERVER["REQUEST_METHOD"] == "GET")
{

}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  $sql = "SELECT user_id
        FROM users
        WHERE user_type = 'a';";
  $result = pg_query($conn, $sql);
  #$records = pg_num_rows($result);



	$sql2 = "SELECT listing_id
					FROM listings
					ORDER BY listing_id DESC
					LIMIT 1";

  $userIDs = pg_fetch_all($result);

	$result2 = pg_query($conn, $sql2);
	$lastListingId = pg_fetch_assoc($result2);


	$newListingId = isset($lastListingId['listing_id']) ? $lastListingId['listing_id'] : '';
	//echo $newListingId;
	$status = array(STATUS_OPEN, STATUS_CLOSED, STATUS_SOLD, STATUS_HIDDEN);
	//add price
	$headlines = array('House on sale',
											'Your Next home',
											'Lovely home, in lovely neighbourhood',
											'You could live here',
											'Home for sale',
											'available for purchase',
										  'Best of Durham for sale',
										  'Lovely home for sale',
										  'Home available for purchase',
										  'Home available for purchase in great neighbourhood',
										  'House for sale',
										  'Buy now',
									    'The block is hot',
										  'House avaiable in lovely neighbourhood',
											'Buy now before it is gone');

	$descripton = array('This single-owner home sits on a large lot with mature trees. It is ready for the next owners to bring it into the 21st century',
	'It is hard to list all the indoor and outdoor features of this stunning home. Schedule a tour today!',
	'This move-in ready home has been recently updated, including new windows that provide ample of natural light. Enjoy the shaded backyard or walk to the neighborhood park down the street.',
  'This stunning two-story home is on a large lot in a hot neighborhood. From the open-concept kitchen and living space to the large shaded backyard, there is plenty of room for the whole family to enjoy. Recent updates include new carpeting upstairs and stainless appliances. Situated in a family-friendly neighborhood near a great park, this home is sure to go fast!',
	'Bright and Spacious Starter Home',
	'Newly Remodeled Mid-Century Home',
	'Cozy Bungalow in the Durham region');

	$streets = array('Bartlett Drive','Bartolo Crescent','Enderly Crescent','Larner Drive','Latham Court','Medley Lane','Meekings Drive',
	'Newing Court', 'Nicholls Court','Oshea Crescent','Oak Street','Pickett Street','Pine Street','Simpson Road','Singleton Lane','Sivyer Crescent');

	
	$decimalBath = array(0,0.5);



	//add postal

  // 1 - 64 CITY, stories, bathroms, bedrooms, parking
	$oneToSixtyFour = array(1,2,4,8,16,32,64);
	$options = array(1,2,4,8,16,32,64,128,256,512);
	$heating = array(1,2,4,8,16,32,64,128,256,512,1024);
	$types = array(1,2,4,8);
	$images = array(0);
	


	for($x = 0; $x <=1500; $x++)
	{
			++$newListingId;
			if(($randomUser = array_rand($userIDs)) == 0)
			{
				$randomUser = 249;
			}
			$statusInput = array_rand($status);
			$price = rand(100000,1000000);
			$randomHeadline = array_rand($headlines);
			$randomDescription = array_rand($descripton);
			$randomPostalCode = chr(rand(65,90)).strval(rand(0,9)).chr(rand(65,90)).'-'.strval(rand(0,9)). chr(rand(65,90)).strval(rand(0,9));
			$randomImage = array_rand($images); //Changed to array rand
			$randomCity = array_rand($oneToSixtyFour);
			$property_options = array_rand($options);
			$randomBedRooms = array_rand($oneToSixtyFour);
			$randomBathRooms = array_rand($oneToSixtyFour); //+ $decimalBath[rand(0,1)];
			//$randomRooms = $randomBedRooms + $randomBathRooms + rand(3,8);//round($randomBathRooms,0, PHP_ROUND_HALF_UP) + rand(3,8);
			$randomParkingSpace = array_rand($oneToSixtyFour);
			$randomStories = array_rand($oneToSixtyFour);
			$randomHeating = array_rand($oneToSixtyFour);
			$randomCooling = array_rand($oneToSixtyFour);
			$randomListingType = array_rand($types);
			//$randomTransactionType = rand(0,3);
			$randomDate = mt_rand(2000, date("Y")) . '-' . mt_rand(1,12) . '-' . mt_rand(1,28);
			$randomAddress = rand(1,400) . " " .$streets[rand(0,15)];


			//Changed to fit random image paths
			$listingUpdate = "INSERT INTO listings(listing_id,user_id, listing_status, price, headline, description, postal_code, images,address, city, property_options, bedrooms, bathrooms, parking_space, stories, cooling, heating, type_of_listing, date_created, last_update)
			 VALUES ('$newListingId','$randomUser','$status[$statusInput]','$price','$headlines[$randomHeadline]','$descripton[$randomDescription]',
				  '$randomPostalCode','$images[$randomImage]','$randomAddress','$oneToSixtyFour[$randomCity]','$options[$property_options]','$oneToSixtyFour[$randomBedRooms]','$oneToSixtyFour[$randomBathRooms]','$oneToSixtyFour[$randomParkingSpace]',
					 '$oneToSixtyFour[$randomStories]','$oneToSixtyFour[$randomCooling]','$heating[$randomHeating]','$types[$randomListingType]','$randomDate','$randomDate');";



			if(!(pg_query($conn, $listingUpdate)))
			{
				echo $listingUpdate;
			}
		  //echo "This is the sql query ".$listingUpdate;
			$recordsMade = $x . " Records were created <br/>";
			ob_flush();

			//L1Z 1Y6

		  //  echo "LISTING id: ". $newListingId
			//  ." \r\nUserId: " . $randomUser
			// 	." \r\nrandom status: ". $status[$statusInput]
			// . "\r\nPrice: " . $price . " \r\n headline: "
			// . $headlines[$randomHeadline] . "\r\nDescription: "
			// . $descripton[$randomDescription]
			// . "\r\nImage: " . $randomImage
			// . "\r\nCity: " . $city[$randomCity]
			// . " Postal Code: ". $randomPostalCode
			// . " Property options: " . $property_options
			// . " Bedrooms: " . $randomBedRooms
			// . " Bathrooms: " . $randomBathRooms
			// . " Rooms: " . $randomRooms
			// . " Parking: " . $randomParkingSpace
			// . " Stories: " .$randomStories
			// . " Pool: " . $randomPool
			// . " Heating: ". $randomHeating
			// . " Cooling: ". $randomCooling
			// . "<br/><br/>";
	}

	#	ob_start();
	#	setcookie("LOGIN_COOKIE", $username, (time() + COOKIE_LIFESPAN));
	#	ob_flush();

	}
	#$result->close();
?>
	<div class="content">

		<h1><?php echo $title; ?></h1><hr>

		<div class="side-by-side-menu">

			<div class="right-side-menu">
        <form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
           <input type="submit" value="Submit">
        </form>

				<p><?php echo 'Status:',(isset($recordsMade) ? 'Made '.$x : 'Not made anything'); ?></p>
			</div>

		</div>

	</div>
<?php
	include("footer.php");
?>
