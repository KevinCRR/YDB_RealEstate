<!-- Name: Kevin Romero
     File Name: lab9.php
     Date: 2019-03-30
     Description: Lab 9 Database/PHP User Login
-->
<?php
/*
$title = "Lab 9";
$file = "lab9.php";
$description = "User Login PHP";
$date = "March 30, 2019";
$banner = "Lab 9 - User Login";
//    <center>     </center>
 */
require "./header.php";
if (isset($_SESSION['results'])) {
    unset($_SESSION['results']);
    unset($_SESSION['records']);
}
?>
<div class="content">

		<!-- <div class="container">
			<div class="right-half"> -->
			<center>
			<table>
				<tr>
					<td>
								<!-- </div>
								<div class="left-half"> -->
                    	<p>Select the city</p>
                    	<form action="./listing-search.php" method="POST">
                    	<input type="checkbox"  onclick="toggle(this);" name="city[]" value="all">Select All<br/>
                    	<?php echo build_checkbox(CITY, 1); ?>

                    	<script type="text/javascript">
                    	/*NOTE: for the following function to work, on your page
                    			you have to create a checkbox id'ed as city_toggle

                    	<input type="checkbox"  onclick="toggle(this);" name="city[]" value="0">

                    		and each city checkbox element has to be an named as an
                    		array (specifically named "city[]")
                    		e.g.
                    			<input type="checkbox" name="city[]" value="1">Ajax
                    	*/
                    	function toggle(source) {
                    		checkboxes = document.getElementsByName('city[]');
                    		for(i = 0; i < checkboxes.length; i++)
                    		{
                    			checkboxes[i].checked = source.checked;
                    		}
                    	}
                    	</script>
                    	<input type="submit" name="search" value="Search">
                    	</form>
					</td>

					<td>
					<!-- image map aligned from west to east -->
					<img src="./images/styles/map.png" width="800 "alt="cities" usemap="#citymap">
					<map name="citymap">
						<area shape="rect" coords="150,220,330,350" href="redirection.php?id=16" alt="Pickering" id="16" >
						<area shape="rect" coords="150,350,250,500" href="redirection.php?id=16" alt="Pickering" id="16">

						<area shape="rect" coords="250,350,330,500" href="redirection.php?id=1" alt="Ajax" id="1">


						<area shape="rect" coords="335,315,415,360" href="redirection.php?id=2" alt="brooklyn" id="2">
						<area shape="rect" coords="330,220,425,500" href="redirection.php?id=64" alt="whitby" id="64">


						<area shape="rect" coords="425,220,525,500" href="redirection.php?id=8" alt="Oshawa" id="8">

						<area shape="rect" coords="525,430,740,530" href="redirection.php?id=4" alt="Bowmanville" id="4">

						<area shape="rect" coords="325,90,510,220" href="redirection.php?id=32" alt="Port Perry" id="32">
					</map>
				</td>

		</tr>
	</table>
	</center>
</div>
<?php include 'footer.php';?>
