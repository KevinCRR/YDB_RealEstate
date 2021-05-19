<?php
	$title = "Contact us";
	include("./header.php");
?>
			
		<div class="content">	
			<h1>Contact us</h1><hr>
			<div class="side-by-side-menu">
				<div class="left-side-menu">
					<h3>First Name</h3>
					<h3>Last Name</h3>
					<h3>Email</h3>
					<h3>Username</h3>
				</div>
				<div class="right-side-menu">
					<br>
					<input type="text" placeholder="Enter your first name" name="FirstName" required><br><br>
					<input type="text" placeholder="Enter your last name" name="LastName" required><br><br>
					<input type="text" placeholder="Enter Email" name="Email" required><br><br>
					<input type="text" placeholder="Enter Username" name="uname" required>
				</div>
			</div>
			<hr>
			<textarea rows="4" cols="50" name="comment" form="usrform">Enter here to contact us...</textarea><br>
			<button type="submit">Submit</button>
		</div>	
<?php 
	include("./footer.php");
?>		