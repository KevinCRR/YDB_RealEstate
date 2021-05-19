<?php
$title = "Change Password";
include("header.php");

if(!isset($_SESSION['user']))
{
	header("LOCATION: login.php");
	ob_flush();
}
$output = "";

if($_SERVER["REQUEST_METHOD"] == "GET")
{
	?>
	<div class="content">
		<h1><?php echo $title; ?></h1><hr>
		<p>To recover your password, please enter the following information:</p>
		<div class="side-by-side-menu">
			<div class="left-side-menu">
				<h3>Username:</h3>
			</div>
			<div class="right-side-menu">
				<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
					<br>
					<input type="text" name="username"><br><br>
					<input type="submit" value="Submit">
				</form>
			</div>
		</div>
		<hr>
	</div>
	<?php
}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$conn = db_connect();
    pg_presql($conn);
	if(isset($_POST["username"]))
	{
		$username = trim($_POST["username"]);
		$result = pg_execute($conn, "user_change_password_get_security_question", array($username));
		$records = pg_num_rows($result);	

		if($records == 0)
		{
			?>
			<div class="content">
				<h1><?php echo $title; ?></h1><hr>
				<p>To recover your password, please enter the following information:</p>
				<p>NO USERNAMES FOUND</p>
				<div class="side-by-side-menu">
					<div class="left-side-menu">
						<h3>Username:</h3>
					</div>
					<div class="right-side-menu">
						<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
							<br>
							<input type="text" name="username"><br><br>
							<input type="submit" value="Submit">
						</form>
					</div>
				</div>
				<hr>
			</div>
			<?php	
		}
		else if($records == 1)
		{
			$question = pg_fetch_assoc($result, 0);
			if(!isset($_POST["answer"]))
			{
				?>
				<div class="content">
					<h1><?php echo $title; ?></h1><hr>
					<p>To recover your password, please enter the following information:</p>
					<div class="side-by-side-menu">
						<div class="left-side-menu">
							<h3>Username:</h3>
							<h3><?php echo $question['security_question'];?></h3>
						</div>
						<div class="right-side-menu">
							<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
								<br>
								<input type="text" name="username" value="<?php echo $_POST["username"]; ?>"><br><br>
								<input type="text" name="answer"><br><br>
								<input type="submit" value="Submit">
							</form>
						</div>
					</div>
					<hr>
				</div>
				<?php 
			}
			if(isset($_POST["answer"]))
			{
				$answer = trim($_POST["answer"]);
				$result = pg_execute($conn, "user_change_password_check_security_question", array($username, $answer));
				$records = pg_num_rows($result);
				if($records == 0)
				{
					?>
					<div class="content">
						<h1><?php echo $title; ?></h1><hr>
						<p>To recover your password, please enter the following information:</p>
						<p>Answer is incorrect.</p>
						<div class="side-by-side-menu">
							<div class="left-side-menu">
								<h3>Username:</h3>
								<h3><?php echo $question['security_question'];?></h3>
							</div>
							<div class="right-side-menu">
								<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
									<br>
									<input type="text" name="username" value="<?php echo $_POST["username"]; ?>"><br><br>
									<input type="text" name="answer"><br><br>
									<input type="submit" value="Submit">
								</form>
							</div>
						</div>
						<hr>
					</div>
					<?php
				}
				else if($records == 1)
				{
					if(!isset($_POST["newPass"]) && !isset($_POST["newPassConf"]))
					{
						?>
						<div class="content">
							<h1><?php echo $title; ?></h1><hr>
							<p>To recover your password, please enter the following information:</p>
							<div class="side-by-side-menu">
								<div class="left-side-menu">
									<h3>Username:</h3>
									<h3><?php echo $question['security_question'];?></h3>
									<h3>New password:</h3>
									<h3>Confirm password:</h3>
								</div>
								<div class="right-side-menu">
									<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
										<br>
										<input type="text" name="username" value="<?php echo $_POST["username"]; ?>"><br><br>
										<input type="text" name="answer" value="<?php echo $_POST["answer"];?>"><br><br>
										<input type="password" name="newPass"><br><br>
										<input type="password" name="newPassConf"><br><br>
										<input type="submit" value="Submit">
									</form>
								</div>
							</div>
							<hr>
						</div>
						<?php
					}
					if(isset($_POST["newPass"]) && isset($_POST["newPassConf"]))
					{
						if($_POST["newPass"] == "" || $_POST["newPassConf"] == "")
						{
							?>
							<div class="content">
								<h1><?php echo $title; ?></h1><hr>
								<p>To recover your password, please enter the following information:</p>
								<p>Make sure both password fields are filled.</p>
								<div class="side-by-side-menu">
									<div class="left-side-menu">
										<h3>Username:</h3>
										<h3><?php echo $question['security_question'];?></h3>
										<h3>New password:</h3>
										<h3>Confirm password:</h3>
									</div>
									<div class="right-side-menu">
										<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
											<br>
											<input type="text" name="username" value="<?php echo $_POST["username"]; ?>"><br><br>
											<input type="text" name="answer" value="<?php echo $_POST["answer"];?>"><br><br>
											<input type="password" name="newPass"><br><br>
											<input type="password" name="newPassConf"><br><br>
											<input type="submit" value="Submit">
										</form>
									</div>
								</div>
								<hr>
							</div>
							<?php
						}
						else if($_POST["newPass"] != "" || $_POST["newPassConf"] != "")
						{
							if($_POST["newPass"] == $_POST["newPassConf"])
							{//IF EVERYTHING IS RIGHT ... THIS IS THE FINAL STEP
								$newPassword = hash(HASH_ALGO, trim($_POST["newPass"]));
								pg_execute($conn, "user_change_password", array($newPassword, $username));
								?>
								<div class="content">
									<h1><?php echo $title; ?></h1><hr>
									<h3>Your password has been changed.</h3>
								</div>
								<?php
							}
							else
							{
								?>
								<div class="content">
									<h1><?php echo $title; ?></h1><hr>
									<p>To recover your password, please enter the following information:</p>
									<p>Passwords don't match.</p>
									<div class="side-by-side-menu">
										<div class="left-side-menu">
											<h3>Username:</h3>
											<h3><?php echo $question['security_question'];?></h3>
											<h3>New password:</h3>
											<h3>Confirm password:</h3>
										</div>
										<div class="right-side-menu">
											<form action="<?php $_SERVER["PHP_SELF"]?>" method="POST">
												<br>
												<input type="text" name="username" value="<?php echo $_POST["username"]; ?>"><br><br>
												<input type="text" name="answer" value="<?php echo $_POST["answer"];?>"><br><br>
												<input type="password" name="newPass"><br><br>
												<input type="password" name="newPassConf"><br><br>
												<input type="submit" value="Submit">
											</form>
										</div>
									</div>
									<hr>
								</div>
								<?php
							}
						}
					}
				}
			}
		}
	}
}
include("footer.php");
?>
