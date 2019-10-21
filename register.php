<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else{
        //Prepare a select statement
        $sql = "Select id FROM users WHERE username = ?";

        if($stmt = mysqli_prepare($link, $sql)){
            //Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            //Set parameters
            $param_username = trim($_POST["username"]);

            //Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                //store result
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_number_rows($stmt) == 1 {
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong, please try again later.";
            }
        }
        //Close statement
        mysqli_stmt_close($stmt);
    }

    //Validate password
    if(empty(trim($-POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 5){
        $password_err = "Password must have at least 5 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    //Confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if($password != $confirm_password){
            $confirm_password_err = "Password did not match.";
        }
    }

    //Check for input errors before inserting into database
    if(empty($username_err) && empth($password_err) && empty($confirm_password_err)){

        //Prepare an insert statement
        $sql - "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            //Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            //Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //Creates a password hash

            //Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){

                //Redirect to login
                header("location: login.php");
            } else {
                echo "Something went wrong, please try again later.";
            }
        }
        //Close statement
        mysqli_stmt_close($stmt);    
    }
    //Close connection
    mysqli_stmt_close($link);
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
        <style type="text/css">
            body{ font: 14px sans-serif; }
            .wrapper{ width: 350px; padding: 20px; }
        </style>
</head>

<body>
    <div class="row">
		<div class="col-xs-12 center-block text-center">
		<h1>Web-Pad</h1>
		</div>
	</div>
    <div class="col-md-6 col-md-offset-4">
        <div class="wrapper">
            <h2>Sign Up</h2>
            <p>Please fill out the form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-default" value="Reset">
                </div>
                <div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>
    </div>
</body>
</html>