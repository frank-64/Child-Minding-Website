<?php
// Start the session
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
$bottom_err = "";
$password_err = "";
  
// Include database file
include("database.php");
if(isset($_POST["submit"])){
        $sql = "SELECT CustomerID, firstnameParent, email, passwordUser FROM tblCustomers WHERE email = :email";
        if($stmt = $conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
            // Set parameters
            $param_email = trim($_POST["login_email"]);
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if email exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $CustomerID = $row["CustomerID"];
                        $firstnameParent= $row["firstnameParent"];
                        $email = $row["email"];
                        $fetchPassword = $row['passwordUser'];
                        $param_passwordUser=$_POST["login_password"];                                           
                        if(password_verify($param_passwordUser, $fetchPassword)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["firstnameParent"] = $firstnameParent;
                            $_SESSION["CustomerID"] = $CustomerID;
                            $_SESSION["email"] = $email;                            
                            
                            // Redirect user to dashboard
                            header("location: dashboard.php");
                        }else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                }else{
                    // Display an error message if email and password doesn't exist
                    $bottom_err = "No account found with that email and password.";
                }
            }else{
              echo "Something went wrong";
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
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  function ValidationEvent() {
// Storing Field Values In Variables
var id = ['login_email', 'login_password'];
var empty = 0;
var count = 0;
  
for (count = 0; count < id.length; count++){
  if (document.getElementById(id[count]).value == ''){
    empty++;
  }
}
    if (empty > 0){
        document.getElementById('errors').style.display = 'block';
        document.getElementById('empty_li').style.display = 'block';
        document.getElementById("err_empty").innerHTML = "Make sure all fields are filled";
    } else{
      document.getElementById('empty_li').style.display = 'none';
      if(document.getElementById('match_li').style.display == 'none' && document.getElementById('empty_li').style.display == 'none'){
      document.getElementById('errors').style.display = 'none';
    }
  }
  
  if(document.getElementById('errors').style.display == 'none'){
    return true;
  }else{
    return false;
  }
}
</script> 
 <!--Ensures the website is responsive with mobile devices-->
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
  <!--Navigation Bar-->
  <nav class="navbar navbar-expand-lg fixed-top text-uppercase align-left">
    <div class="container-fluid header">
      <a class="navbar-brand js-scroll-trigger a1" href="index.php" id="header" style="color: #ffffff">Kirsty's Child Minding Services</a>
      <button class="navbar-toggler navbar-toggler-right text-uppercase" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars a1"></i>
        </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav-brand ml-auto">
          <li class="nav mx-0 mx-lg-1">
            <input type="button" id="login" class="btn btn-outline-light nav-link rounded js-scroll-trigger" name="login" value="Login" onclick="location.href='login.php'" style="margin-top: 15px">
          </li>
        </ul>
        <ul>
          <li>
            <input type="button" id="register" class="btn btn-outline-light nav-link rounded js-scroll-trigger" name="register" value="Register" onclick="location.href='register.php'" style="margin-top: 15px">
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <br>
  <br>
  
<!--Login form-->
<div class="row justify-content-md-center">
<div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 container-fluid rounded" style="margin-top:90px;border-style:outset;border-color: #ff6b66;padding-right: 0px;padding-left: 0px;">
  <div align="center">
        <div class="container-fluid rounded" style="border-color: #ff6b66">
          <form action="<?php echo htmlspecialchars($_SERVER[" PHP_SELF "]); ?>" method="post" onsubmit="return ValidationEvent()">
         <h1 class="header" style="color: #ff6b66" align="center">Login:</h1>
            <div class="form-group">
              <label>Email:</label>
              <input type="email" name="login_email" id="login_email" class="form-control" style="border-color: #ff6b66; max-width:500px;" placeholder="Enter Email" value="<?php echo $_POST['login_email']; ?>">
              <span class="help-block"></span>
            </div>
            <div class="form-group form-group">
              <label>Password:</label>
              <input type="password" name="login_password" id="login_password" style="border-color: #ff6b66; max-width:500px;" placeholder="Enter Password " class="form-control">
            </div>
            <span><?php echo ($password_err)?></span>
            <span><?php echo ($bottom_err)?></span>
             <div class="alert alert-danger" align="left" id="errors" style="display: none; max-width:500px; ">
              <ul style="padding-left:0px;">
                <li style="display: none" id="empty_li"><i class="fa fa-times"></i><strong style="padding-left:17px" id="err_empty"></strong></li>
              </ul>
            </div>
            <div class="form-group a3">
              <input id="submit" type="submit" name="submit" value="Submit" class="btn btn-danger" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php" style="color: #ff6b66; font-weight: bold">Register here</a>.</p>
          </div>
          </form>
        </div>
       </div>
      </div>
  <img scr="images/graph.jpg"></img>
</body>
</html>