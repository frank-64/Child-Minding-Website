<?php
// Initialize the session
session_start();
if(isset($_SESSION["loggedinStaff"]) && $_SESSION["loggedinStaff"] === true){
    header("location: staffdashboard.php");
    exit;
}
// Include config file
require_once "database.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT Username, Password FROM tblStaff WHERE Username = :Username";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":Username", $param_username, PDO::PARAM_STR);        
            // Set parameters
            $param_username = trim($_POST["login_username"]);
            $param_password = ($_POST["login_password"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                          $fetchPassword = $row['Password'];
                          if(password_verify($param_password, $fetchPassword)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedinStaff"] = true;
                            $_SESSION["username"] = $username;
                            $_SESSION["password"] = $password;                            
                            
                            // Redirect user to welcome page
                            header("location: staffdashboard.php");
                          }else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                       }
                    }else{
                    // Display an error message if email and password doesn't exist
                    $bottom_err = "No account found with that username and password.";
                }
              }else{
              echo "something went wrong";
            }
          }
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!--Ensures the website is responsive with mobile devices-->
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<!--Staff Login form-->
<form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 container rounded"  style="border-style:outset; margin-top:80px; border-color: #007bff">
      <div align="center">
      <h1 class="header" style="color: #007bff">Login:</h1>
      <div class="form-group">
        <label>Username:</label>
        <input type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" name="login_username" class="form-control" placeholder="Enter Username" required>
      </div>
      <div class="form-group">
        <label>Password:</label>
        <input type="password" name="login_password" placeholder="Enter Password " class="form-control" required>
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary">Login</button>
      </div>
      <span><?php echo ($password_err)?></span>
      <span><?php echo ($bottom_err)?></span>
    </div>
  </div>
 </div>
</form>
</body>
</html>