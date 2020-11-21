<?php
if(isset($_POST["submit"])){
$hashPass = password_hash($_POST['reg_passwordUser'], PASSWORD_DEFAULT);
$postFirstname = test_data($_POST['reg_firstnameParent']);
$postSurname = test_data($_POST['reg_surnameParent']);
$postEmail = test_data($_POST['reg_email']);
$postPhoneNumber = test_data($_POST['reg_phoneNumber']);
$postPostcode = test_data($_POST['reg_postcode']);
$postAddress1 =  test_data($_POST['reg_addressLine1']);
$postAddress2 =  test_data($_POST['reg_addressLine2']);
$postTown = test_data($_POST['reg_town']);
try {
  include("database.php"); 
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $sql = "INSERT INTO tblCustomers (firstnameParent,
                surnameParent,
                email,
                phoneNumber,
                postcode,
                addressLine1,
                addressLine2,
                town,
                passwordUser)
                VALUES (
                :firstnameParent, 
                :surnameParent, 
                :email, 
                :phoneNumber, 
                :postcode,
                :addressLine1,
                :addressLine2,
                :town,
                :password)";
      $stmt = $conn->prepare($sql);                                              
      $stmt->bindParam(':firstnameParent', $postFirstname, PDO::PARAM_STR);       
      $stmt->bindParam(':surnameParent', $postSurname, PDO::PARAM_STR); 
      $stmt->bindParam(':email', $postEmail, PDO::PARAM_STR);
      $stmt->bindParam(':phoneNumber', $postPhoneNumber);
      $stmt->bindParam(':postcode', $postPostcode, PDO::PARAM_STR);
      $stmt->bindParam(':addressLine1', $postAddress1, PDO::PARAM_STR);
      $stmt->bindParam(':addressLine2', $postAddress2, PDO::PARAM_STR);
      $stmt->bindParam(':town', $postTown, PDO::PARAM_STR); 
      $stmt->bindParam(':password', $hashPass);
      $stmt->execute();
      header("Location: login.php");
} 
catch(PDOException $e)
{
  echo $sql . "<br>" . $e->getMessage();
}
$conn = null;
}

//Strip special characters and trim data
function test_data($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
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
    <scriptsrc src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
    <script>
function emailTaken(str) {
  var xhttp; 
  if (str == "") {
    if (document.getElementById("err_empty").style.display = 'block'){
      
    }
    document.getElementById("err_empty").innerHTML = "";
    return;
  }
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      if (this.responseText == "Taken"){
        document.getElementById('errors').style.display = 'block';
        document.getElementById('email_li').style.display = 'block';
        document.getElementById("err_email").innerHTML = "This email is already in use";
      } else if(this.responseText == "Not taken" ){
        document.getElementById('email_li').style.display = 'none';
        if(document.getElementById('match_li').style.display == 'none' && document.getElementById('empty_li').style.display == 'none' && document.getElementById('empty_li').style.display == 'none'){
          document.getElementById('errors').style.display = 'none';
        }
      }
    }
  };
  xhttp.open("GET", "getEmail.php?q="+str, true);
  xhttp.send();
}
      
function checkPassword(){
  if (document.getElementById("password").value.length > 7){
    document.getElementById("confirmPassword").disabled = false;
    document.getElementById("confirmPassword").style.opacity = "1";
  } else{
    document.getElementById("confirmPassword").value = '';
    document.getElementById("confirmPassword").disabled = true;
  }
}
  


function match(){
  if (document.getElementById("password").value != document.getElementById("confirmPassword").value){
    document.getElementById('errors').style.display = 'block';
    document.getElementById('match_li').style.display = 'block';
    document.getElementById("err_match").innerHTML = "Make sure both passwords match";
  } else if(document.getElementById("password").value == document.getElementById("confirmPassword").value){
    document.getElementById('match_li').style.display = 'none';
    if(document.getElementById('match_li').style.display == 'none' && document.getElementById('empty_li').style.display == 'none' && document.getElementById('email_li').style.display == 'none'){
      document.getElementById('errors').style.display = 'none';
    }
  } 
}  
      
function ValidationEvent() {
// Storing Field Values In Variables
var id = ['firstnameParent', 'surnameParent' , 'email', 'phoneNumber', 'password','confirmPassword', 'addressLine1', 'addressLine2', 'town', 'postcode'];
var empty = 0;
var count = 0;
var error = true;
  
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
      if(document.getElementById('match_li').style.display == 'none' && document.getElementById('empty_li').style.display == 'none' && document.getElementById('email_li').style.display == 'none'){
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
  </head>
  <body>
    <!--Navigation Bar-->
  <nav class="navbar navbar-expand-lg fixed-top text-uppercase align-left">
    <div class="container-fluid header">
      <a class="navbar-brand js-scroll-trigger a1" href="index.php" id="header">Kirsty's Child Minding Services</a>
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

    <!--Register form-->
<div class="row justify-content-md-center">
  <div class="col-xs-12 col-sm-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4 container-fluid rounded" style="margin-top:90px;border-style:outset;border-color: #ff6b66;padding-right: 0px;padding-left: 0px;">
    <div align="center">
      <div class="container-fluid rounded" style="border-color: #ff6b66">
        <h1 class="header" style="color: #ff6b66" align="center">Register:</h1>
            <form method="post" id="form" onsubmit="return ValidationEvent()">
            <div class="form-group">
              <label for="Firstname">Firstname:</label>
              <input type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" style="border-color: #ff6b66; max-width:500px" title="Enter your firstname" class="form-control" id="firstnameParent" name="reg_firstnameParent" placeholder="Enter Firstname">
            </div>
            <div class="form-group">
              <label for="Surname">Surname:</label>
              <input type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" style="border-color: #ff6b66; max-width:500px " title="Enter your firstname" class="form-control" id="surnameParent" name="reg_surnameParent" placeholder="Enter Surname">
            </div>
            <div class="form-group">
              <label for="Email">E-mail:</label>
              <input type="email" title="Enter your email in the format: example@email.com" style="border-color: #ff6b66; max-width:500px" class="form-control" id="email" name="reg_email" placeholder="Enter E-mail" onchange="emailTaken(this.value)">
            </div>
            <div class="form-group">
              <label for="Phone Number">Mobile Number:</label>
              <input type="text" pattern="^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$" style="border-color: #ff6b66; max-width:500px" title="Mobile number starting 07 or +44 and 11-13 digits long" class="form-control" id="phoneNumber" name="reg_phoneNumber" placeholder="Enter Phone Number">
            </div>
            <div class="form-group">
              <label for="Password">Password:</label>
              <input type="password"  style="border-color: #ff6b66; max-width:500px" title="Minimum eight characters, at least one uppercase letter, one lowercase letter and one number:" class="form-control" id="password" name="reg_passwordUser" placeholder="Enter New Password" onchange="checkPassword()" onfocusout="checkpassword()">
            </div>
            <div class="form-group">
              <label for="Confirm Password">Confirm Password:</label>
              <input type="password" class="form-control" id="confirmPassword" style="border-color: #ff6b66; max-width:500px" placeholder="Confirm Password" style="opacity:0.1" disabled onfocusout="match()">
            </div>
            <div class="form-group">
              <label for="Address">Home Address:</label>
              <input type="text" class="form-control" style="border-color:#ff6b66; max-width:500px" id="addressLine1" name="reg_addressLine1" placeholder="Address line 1">
              <input type="text" class="form-control" style="margin-top: 10px; border-color:#ff6b66; max-width:500px" id="addressLine2" name="reg_addressLine2" placeholder="Address line 2">
              <input type="text" class="form-control" style="margin-top: 10px; border-color:#ff6b66; max-width:500px" id="town" name="reg_town" placeholder="Town">
              <input type="text" class="form-control" style="margin-top: 10px; border-color:#ff6b66; max-width:500px; align: left;" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}" title="Postcode must be in the pattern: LLNN NLL" id="postcode" name="reg_postcode" placeholder="Postcode">
            </div>                  
           <div class="alert alert-danger" align="left" id="errors" style="display: none; max-width:500px">
              <ul style="padding-left: 0px">
                <br>
                <li style="display: none" id="empty_li"><i class="fa fa-times"></i><strong style="padding-left:17px" id="err_empty"></strong></li>
                <li style="display: none" id="match_li"><i class="fa fa-times"></i><strong style="padding-left:17px" id="err_match"></strong></li>
                <li style="display: none" id="email_li"><i class="fa fa-times"></i><strong style="padding-left:17px" id="err_email"></strong></li>
              </ul>
            </div>
            <input id="submit" type="submit" name="submit" value="Submit"  class="btn btn-danger" style="margin-bottom: 15px"></input>
          </form>
        </div>
      </div>
    </div>
  </body>
  </html>