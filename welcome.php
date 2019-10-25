<?php
// Initialize the session


session_start();
ob_start();
if(array_key_exists("id", $_COOKIE) && $_COOKIE['id']){
    $_SESSION['id'] = $_COOKIE['id'];
}
if(array_key_exists("id", $_SESSION) && $_SESSION['id']){
    
    include("config.php");
    $sql = "SELECT diary FROM `users` WHERE id = '".mysqli_real_escape_string($link, $_SESSION['id'])."' LIMIT 1";
    $row = mysqli_fetch_array(mysqli_query($link,$sql));
    $diaryContent = $row['diary'];
} else{
    header("Location: login.php");
}
include("header.php");
ob_end_flush();
?>



 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>! <br />Welcome to Your Web-pad.</h1>
    </div>
	

	
		<div class="container">

			<textarea id="diary" class="form-control"><?php echo $diaryContent ; ?></textarea>

		</div>
		
	


	
    <p>
        <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    </p>
	
	
	
</body>

<?php
include("footer.php");
?>
	
</html>