<?php
	define("AGENT",'a');
	define("ADMIN",'s');
	define("CLIENT",'c');
	define("PENDING",'p');
	define("DISABLED",'d');
	define("INCOMPLETE", 'i');

	define("DB_HOST","127.0.0.1");
	define("DB_NAME","group12_db");
	define("DB_PORT",5432);
	define("DB_PASSWORD","webd3201_group12");
	define("DB_USER","group12_admin");
	define("COOKIE_LIFESPAN",2592000);
	
	define("CONTACT_EMAIL", 'e');
	define("CONTACT_SNAIL_MAIL", 's');
	define("CONTACT_PHONE", 'p');
	
	define("STATUS_OPEN", 'o');
	define("STATUS_CLOSED", 'c');
	define("STATUS_SOLD", 's');
	define("STATUS_HIDDEN", 'h');
	
	define("MIN_AREA_CODE", 200);
	define("MAX_AREA_CODE", 999);

	define("MAX_UPLOADS", 4);
	
	define("MIN_PW_LENGTH", 6);
	define("MAX_PW_LENGTH", 20);
	
	define("MIN_ID_LENGTH", 3);
	define("MAX_ID_LENGTH", 20);
	
	define("MAX_FN_LENGTH", 50);
	define("MAX_LN_LENGTH", 50);
	define("MAX_EMAIL_LENGTH", 100);
	define("MAX_CLIENT_ADDRESS", 50);
	define("MAX_STREET_ADDRESS", 50);
	define("POSTAL_CODE_LENGTH", 6);
	define("PHONE_NUMBER_LENGTH", 10);
	define("PHONE_EXT_LENGTH", 14);
	
	define("CITY", 'city');
	define("PRICE", 'price');
	define("HEAT", 'heating');
	define("COOL", 'cooling');
	define("EXT", 'exterior');
	define("POOL", 'pool');
	define("ROOMS", 'rooms');
	define("STORIES", 'stories');
	define("PARKING", 'parking_space');
	define("BED", 'bedrooms');
	define("BATH", 'bathrooms');
	define("POSTAL", 'postal_code');
	define("LIST_ID", 'listing_id');
	define("USR_ID", 'user_id');
	define("LIST_STATUS", 'listing_status');
	define("HEADLINE", 'headline');
	define("DESC", 'description');
	define("IMGS", 'images');
	define("PRPRT_OPTNS", 'property_options');
	define("TYPE", 'type_of_listing');

	define("MAX_SEARCH_RESULTS", 200);
	
	define("CONT_METHOD", 'preferred_contact_method');
	
	define("SEARCH_RESULTS_PER_PAGE", 10);

	define("HASH_ALGO", "md5");
?>
