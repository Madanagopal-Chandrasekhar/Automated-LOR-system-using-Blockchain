<?php include ( "db.php" ); ?>
<?php 
if (!isset($_SESSION['user_login'])) {
	$user = "";
}
else {
	$user = $_SESSION['user_login'];
	$result = mysqli_query($con,"SELECT * FROM user WHERE id='$user'");
		$get_user_email = mysqli_fetch_assoc($result);
			$uname_db = $get_user_email['firstName'];
}   
?>
<title>Letter Of Recommendation for Higher Studies</title>
        <link rel="icon" type="image/x-icon" href="images/icon.ico">
        <nav class="menu">
            <?php if($user!=NULL){
				echo '<a href="studentindex.php" class="title">Letter Of Recommendation for Higher Studies</a>';}
				else{
					echo '<a href="index.php" class="title">Letter Of Recommendation for Higher Studies</a>';	
				}?>
					<?php 
						if ($user!="") {
							echo '<a class="all" href="logout.php">LogOut</a>';
						}
						else {
							echo '<a class="all" href="signup.php">Signup</a>';
						}
					 ?>
					<?php 
						if ($user!="") {
							echo '<a class="all" href="profile.php?uid='.$user.'">'.$uname_db.'</a>';
						}
						else {
							echo '<a class="all" href="login.php">LogIn</a>';
						}
					 ?>
        </nav>