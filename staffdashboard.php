<?
session_start();
if(!isset($_SESSION["loggedinStaff"])){
    header("location: stafflogin.php");
    exit;
}
if(isset($_POST["logoutStaff"])){
  $_SESSION["loggedin"] = false;
  header("Location: stafflogin.php");
  session_unset();
  session_destroy();
}
//Display the children in the table for view
include("database.php");
//Check In
if(isset($_POST['timeIn'])){
  $CheckIn = 1;
  $currentDate = date('Y-m-d H:i:s');
  $checkInSQL = "UPDATE tblBooking SET CheckIn = :CheckIn, timeIn = :timeIn WHERE BookingID = :BookingID";
  $checkInStmt = $conn->prepare($checkInSQL);
  $checkInStmt->bindParam(':CheckIn', $CheckIn);
  $checkInStmt->bindParam(':timeIn', $currentDate);
  $checkInStmt->bindParam(':BookingID', $_POST['timeIn']);
  $checkInStmt->execute();
}
//Check out
if(isset($_POST['timeOut'])){
  $CheckOut = 1;
  $currentDate = date('Y-m-d H:i:s');
  $checkOutSQL = "UPDATE tblBooking SET CheckOut = :CheckOut, timeOut = :timeOut WHERE BookingID = :BookingID";
  $checkOutStmt = $conn->prepare($checkOutSQL);
  $checkOutStmt->bindParam(':CheckOut', $CheckOut);
  $checkOutStmt->bindParam(':timeOut', $currentDate);
  $checkOutStmt->bindParam(':BookingID', $_POST['timeOut']);
  $checkOutStmt->execute();
}
//Display children
$database = "SELECT tblChild.Child_Firstname, tblChild.Child_Surname, tblChild.Date_Of_Birth, tblChild.gender, tblChild.otherInfo, tblChild.currentDate, tblCustomers.firstnameParent, tblCustomers.surnameParent, tblChild.ChildID FROM tblChild INNER JOIN tblCustomers ON tblChild.tblCustomers_CustomerID=tblCustomers.CustomerID;";
$stmtCheck = $conn->prepare($database);
$stmtCheck->execute();
//Display the parents
$dbParent = "SELECT tblCustomers.firstnameParent, tblCustomers.surnameParent, tblCustomers.email, tblCustomers.phoneNumber, tblCustomers.addressLine1, tblCustomers.addressLine2, tblCustomers.Town, tblCustomers.postcode, tblCustomers.CustomerID FROM tblCustomers ;";
$stmtParent = $conn->prepare($dbParent);
$stmtParent->execute();
//Display booking
$sqlBooking = "SELECT tblChild.Child_Firstname, tblChild.Child_Surname, tblBooking.Date_Of_booking, tblBooking.CheckIn, tblBooking.CheckOut, tblBooking.timeIn, tblBooking.timeOut, tblBooking.timeStart, tblBooking.timeEnd, tblBooking.otherBookingInfo, tblBooking.Price_Of_booking, tblBooking.Paid, tblBooking.tblCustomers_CustomerID, tblBooking.BookingID FROM tblBooking INNER JOIN tblCustomers ON tblBooking.tblCustomers_CustomerID = tblCustomers.CustomerID INNER JOIN tblChild ON tblBooking.tblChild_ChildID = tblChild.ChildID WHERE tblBooking.tblCustomers_CustomerID = tblCustomers.CustomerID;";
$stmtBooking = $conn->prepare($sqlBooking);
$stmtBooking->execute();
//Delete the child once button is clicked
if(isset($_POST["deleteChild"])){
  $deleteCSQL = "DELETE FROM tblChild WHERE ChildID = :deleteChild";
  $stmtDeleteC = $conn->prepare($deleteCSQL);
  $stmtDeleteC->bindParam(':deleteChild', $_POST['deleteChild']);
  $stmtDeleteC->execute();
  header("Refresh:0");
}
//Delete the parent once button is clicked
if(isset($_POST["deleteParent"])){
  $deletePSQL = "DELETE FROM tblCustomers WHERE tblCustomers.CustomerID = :deleteParent;";
  $stmtDeleteP = $conn->prepare($deletePSQL);
  $stmtDeleteP->bindParam(':deleteParent', $_POST['deleteParent']);
  $stmtDeleteP->execute();
  header("Refresh:0");
}
//Delete booking once button is clicked
if(isset($_POST["deleteBooking"])){
  $deleteCSQL = "DELETE FROM tblBooking WHERE BookingID = :deleteBooking";
  $stmtDeleteC = $conn->prepare($deleteCSQL);
  $stmtDeleteC->bindParam(':deleteBooking', $_POST['deleteBooking']);
  $stmtDeleteC->execute();
  header("Refresh:0");
}
//Edit booking
if(isset($_POST['submitBooking'])){
    $current = date('Y-m-d');
    $sql = "UPDATE tblBooking 
            SET tblChild_ChildID = :tblChild_ChildID, Date_Modified = :Date_Modified, Date_Of_booking = :Date_Of_booking, timeStart = :timeStart, timeEnd = :timeEnd, otherBookingInfo = :otherB, Price_Of_Booking = :Price_Of_Booking, Paid = :Paid 
            WHERE BookingID = :BookingID;";
    $stmtEditBooking = $conn->prepare($sql);
    $stmtEditBooking->bindParam(':tblChild_ChildID', $_POST['selectedChild']);
    $stmtEditBooking->bindParam(':Date_Modified', $current);  
    $stmtEditBooking->bindParam(':Date_Of_booking', $_POST['datePicker']);
    $stmtEditBooking->bindParam(':timeStart', $_POST['timeStart']);
    $stmtEditBooking->bindParam(':timeEnd', $_POST['timeEnd']);
    $stmtEditBooking->bindParam(':otherB', $_POST['otherBookingInfo']);
    $stmtEditBooking->bindParam(':Price_Of_Booking', $_POST['bookingInput']);
    $stmtEditBooking->bindParam(':Paid', $_POST['Paid']);
    $stmtEditBooking->bindParam(':BookingID', $_POST['bookingID']);
    $stmtEditBooking->execute();
}
//Edit parent
if(isset($_POST['editParentForm'])){
 $sql = "UPDATE tblCustomers 
         SET firstnameParent = :firstnameParent, surnameParent = :surnameParent, email = :email, phoneNumber = :phoneNumber, postcode = :postcode, addressLine1 = :addressLine1, addressLine2 = :addressLine2, town = :town 
         WHERE CustomerID = :CustomerID;";
      $stmtEditParent = $conn->prepare($sql);                                              
      $stmtEditParent->bindParam(':firstnameParent', $_POST['reg_firstnameParent']);       
      $stmtEditParent->bindParam(':surnameParent', $_POST['reg_surnameParent']); 
      $stmtEditParent->bindParam(':email', $_POST['reg_email']);
      $stmtEditParent->bindParam(':phoneNumber', $_POST['reg_phoneNumber']);
      $stmtEditParent->bindParam(':postcode', $_POST['reg_postcode']);
      $stmtEditParent->bindParam(':addressLine1', $_POST['reg_addressLine1']);
      $stmtEditParent->bindParam(':addressLine2', $_POST['reg_addressLine2']);
      $stmtEditParent->bindParam(':town', $_POST['reg_town']);
      $stmtEditParent->bindParam(':CustomerID', $_POST['inputCustomerID']);
      $stmtEditParent->execute();
}
//Edit child
if(isset($_POST["editChildButton"])){
  echo($_POST['inputChildID']);
  $currentD = date('Y-m-d');
  $updateSQL = "UPDATE tblChild SET Child_Firstname = :Child_Firstname, Child_Surname = :Child_Surname, Date_Of_Birth = :Date_Of_Birth, gender = :Gender, currentDate = :currentDate, otherInfo = :otherInfo WHERE ChildID = :ChildID";
  $stmtUpdate = $conn->prepare($updateSQL);
  $stmtUpdate->bindParam(':Child_Firstname', $_POST['reg_firstnameChild']);       
  $stmtUpdate->bindParam(':Child_Surname', $_POST['reg_surnameChild']); 
  $stmtUpdate->bindParam(':Date_Of_Birth', $_POST['reg_dobChild']);
  $stmtUpdate->bindParam(':Gender', $_POST['reg_genderChild']);
  $stmtUpdate->bindParam(':currentDate', $currentD);
  $stmtUpdate->bindParam(':otherInfo', $_POST['reg_otherInfo']);
  $stmtUpdate->bindParam(':ChildID', $_POST['inputChildID']);
  $stmtUpdate->execute();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset="utf-8">
<link rel="icon" href="http://example.com/favicon.png">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  var currentDiv = "viewBookingDiv";
  function btnViewChildDiv() {
    document.getElementById(currentDiv).style.display = 'none';
    document.getElementById('viewChildDiv').style.display = 'block';
    document.getElementById('top_text').innerHTML = 'Here is all the information about each child:';
    currentDiv = "viewChildDiv";
  }
  function btnViewParentDiv() {
    document.getElementById(currentDiv).style.display = 'none';
    document.getElementById('viewParentDiv').style.display = 'block';
    document.getElementById('top_text').innerHTML = 'Here is all the information about each parent:';
    currentDiv = "viewParentDiv";
  }
  function btnViewBookingDiv() {
    document.getElementById(currentDiv).style.display = 'none';
    document.getElementById('viewBookingDiv').style.display = 'block';
    document.getElementById('top_text').innerHTML = "View each booking:";
    currentDiv = "viewBookingDiv";
  }
function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("ChildInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("ChildTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
  <!--Ensures the website is responsive with mobile devices-->
<meta name="viewport" content="width=device-width, initial-scale=1">
  <body>
    <nav class="navbar navbar-expand-lg fixed-top align-left" style="background-color: #007bff">
      <div class="container-fluid header">
        <a class="navbar-brand js-scroll-trigger a1" id="header" style="color: white;">Staff Dashboard</a>
        <button class="navbar-toggler navbar-toggler-right text-uppercase" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars a1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav-brand ml-auto" style="list-style: none;">
            <li class="nav mx-0 mx-lg-1">
            </li>
          </ul>
          <ul style="list-style: none;">
            <li>
              <form method="post">
                 <input type="submit" id="logoutStaff" class="btn btn-outline-light" name="logoutStaff" value="Logout" style="margin-top:12px;">
              </form>
            </li>
          </ul>
        </div>
      </div>
    </nav>
<div style="margin-top:90px;">
  <div class="row justify-content-md-center">
    <div class="col-12 col-sm-12 col-md-12 col-lg-10 col-xl-10 container-fluid rounded" style="margin-top:90px;border-style:outset;border-color: #007bff;padding-right: 0px;padding-left: 0px;">
      <h1 class="header" style="color: #007bff" align="center" id="top_text">All bookings</h1>
      <div id="viewChildDiv" style="display: none">
       <input type="text" id="ChildInput" onkeyup="myFunction()" placeholder="Search">
        <div class="col-md-auto container-fluid rounded" style="padding-left: 0px; padding-right: 0px;">
          <table id="ChildTable" class='table table-striped'>
            <thead>
              <tr>
                <th scope="col">ChildID</th>
                <th scope="col" style='text-transform:Capitalize'>Firstname</th>
                <th scope="col" style='text-transform:Capitalize'>Surname</th>
                <th scope="col">Date of Birth</th>
                <th scope="col" style='text-transform:Capitalize'>Gender</th>
                <th scope="col">Other Information</th>
                <th scope="col">Date of Last Change</th>
                <th scope="col" style='text-transform:Capitalize'>Parent Name</th>
                <th scope="col"></th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <?php
            $countChild = 0;
            while ($r = $stmtCheck->fetch(PDO::FETCH_ASSOC)): ?>
            <tbody>
              <tr>
                <td><?php echo ($r['ChildID']);?></td>
                <td><?php echo ($r['Child_Firstname']);?></td>
                <td><?php echo ($r['Child_Surname']);?></td>
                <td><?php echo ($r['Date_Of_Birth']);?></td>
                <td><?php echo ($r['gender']);?></td>
                <td><?php echo ($r['otherInfo']);?></td>
                <td><?php echo ($r['currentDate']);?></td>
                <td><?php echo ($r['firstnameParent'] . " " .$r['surnameParent']);?></td>
                <td><form method="post"><button type="submit" name="deleteChild" value="<?php echo $r['ChildID'];?>" class="btn btn-danger" id="deleteChild">Delete</button></form></td>
                <td><button type="submit" name="editChild" class="btn btn-info" data-toggle='modal' data-target='#editChildModal<?php echo ($countChild);?>' id="editChild">Edit</button></td> 
                <div id="editChildModal<?php echo ($countChild);?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #007bff">
                          <h2 class="modal-title" style="color: #ffffff">Edit this child: </h2>
                        </div>
                        <div class="modal-body">
                          <div align="center">
                         <h4>ChildID: <?php echo ($r['ChildID']);?></h4>
                            <form method="post" id="editChildForm">
                              <div class="form-group" align="center">
                                <label for="Firstname">Firstname:</label>
                                <input style="border-color: #007bff" type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" class="form-control" id="firstnameChild" name="reg_firstnameChild" required value="<?php echo ($r['Child_Firstname']);?>">
                              </div>
                              <div class="form-group" align="center">
                                <label for="Surname">Surname:</label>
                                <input style="border-color: #007bff" type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" title="Enter your child's surname" class="form-control" id="surnameChild" name="reg_surnameChild" required value="<?php echo ($r['Child_Surname']);?>">
                              </div>
                              <div class="form-group" align="center">
                                <label for="dob">Date of birth:</label>
                                <input style="border-color: #007bff" type="date" class="form-control" id="dobChild" name="reg_dobChild" required value="<?php echo ($r['Date_Of_Birth']);?>">
                              </div>
                              <div class="form-group" align="center">
                                <label for="otherInfo">Other Information:</label>
                                <textarea style="border-color: #007bff" type="text" class="form-control" id="reg_otherInfo" name="reg_otherInfo" required><?php echo ($r['otherInfo']);?></textarea>
                              </div>
                              <div class="form-group" align="center">
                                <label for="Gender">Gender:</label>
                                <br>
                                <input type="radio" name="reg_genderChild" value="Male" checked> Male<br>
                                <input type="radio" name="reg_genderChild" value="Female"> Female<br>
                              </div>
                              <div align="center">
                                <input type="submit" name="editChildButton" value="Submit" class="btn btn-primary" id="editChild" style="margin-bottom:15px"></input>
                                <input name="inputChildID" value="<?php echo ($r['ChildID']);?>" hidden>
                              </div>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </tr>
            </tbody>
           <?php 
            $countChild ++;
            endwhile; ?>
          </table>          
          </div>
      </div>
      <div id="viewParentDiv" style="display: none">
        <div class="col-md-auto container-fluid rounded" style="padding-left: 0px; padding-right: 0px;">
          <table class='table table-striped'>
            <thead>
              <tr>
                <th scope="col">CustomerID</th>
                <th scope="col" style='text-transform:Capitalize'>Firstname</th>
                <th scope="col" style='text-transform:Capitalize'>Surname</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col" style='text-transform:Capitalize'>Address</th>
                <th></th>
                <th></th>
              </tr>
            </thead>
            <?php
            $countParent = 0;
            while ($e = $stmtParent->fetch(PDO::FETCH_ASSOC)): ?>
            <tbody>
              <tr>
                <td><?php echo ($e['CustomerID']);?></td>
                <td><?php echo ($e['firstnameParent']);?></td>
                <td><?php echo ($e['surnameParent']);?></td>
                <td><?php echo ($e['email']);?></td>
                <td><?php echo ($e['phoneNumber']);?></td>
                <td><?php echo nl2br($e['addressLine1']. "\n" . $e['addressLine2'] . "\n" . $e['Town'] . "\n" . $e['postcode'])?></td>
                <td><form method="post"><button type="submit" name="deleteParent" value="<?php echo $r['CustomerID'];?>" class="btn btn-danger">Delete</button></form></td>
                <td><button type="submit" name="editParent" class="btn btn-info" id="editParent" data-toggle='modal' data-target='#editParentModal<?php echo ($countParent);?>'>Edit</button></td>
                <div id="editParentModal<?php echo $countParent;?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #007bff">
                          <h2 class="modal-title" style="color: #ffffff">Edit this parent: </h2>
                        </div>
                        <div class="modal-body">
                          <div align="center">
                         <h4>CustomerID: <?php echo ($e['CustomerID']);?></h4>
                            <form method="post" id="form" onsubmit="return ValidationEvent()">
                              <div class="form-group">
                                <label for="Firstname">Firstname:</label>
                                <input type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" style="border-color: #007bff;" class="form-control" id="firstnameParent" name="reg_firstnameParent" value="<?php echo ($e['firstnameParent']);?>" required>
                              </div>
                              <div class="form-group">
                                <label for="Surname">Surname:</label>
                                <input type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" style="border-color: #007bff;" class="form-control" id="surnameParent" name="reg_surnameParent" value="<?php echo ($e['surnameParent']);?>" required>
                              </div>
                              <div class="form-group">
                                <label for="Email">E-mail:</label>
                                <input type="email" title="Enter your email in the format: example@email.com" style="border-color: #007bff;" class="form-control" id="email" name="reg_email" value="<?php echo ($e['email']);?>" required>
                              </div>
                              <div class="form-group">
                                <label for="Phone Number">Mobile Number:</label>
                                <input type="text" pattern="^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$" style="border-color: #007bff;" class="form-control" id="phoneNumber" name="reg_phoneNumber" value="<?php echo ($e['phoneNumber']);?>" required>
                              </div>
                              <div class="form-group">
                                <Label>Address Line 1:</Label>
                                <input type="text" class="form-control" style="border-color:#007bff; " id="addressLine1" name="reg_addressLine1" value="<?php echo ($e['addressLine1']);?>" required>
                                <Label>Address Line 2:</Label>
                                <input type="text" class="form-control" style="margin-top: 10px; border-color:#007bff" id="addressLine2" name="reg_addressLine2" value="<?php echo ($e['addressLine2']);?>" required>
                                <Label>Town:</Label>
                                <input type="text" class="form-control" style="margin-top: 10px; border-color:#007bff;" id="town" name="reg_town" value="<?php echo ($e['Town']);?>" required>
                                <Label>Postcode:</Label>
                                <input type="text" class="form-control" style="margin-top: 10px; border-color:#007bff;; align: left;" pattern="[A-Za-z]{1,2}[0-9Rr][0-9A-Za-z]? [0-9][ABD-HJLNP-UW-Zabd-hjlnp-uw-z]{2}" id="postcode" name="reg_postcode" value="<?php echo ($e['postcode']);?>" required>
                              </div>                  
                              <input id="submit" type="submit" name="editParentForm" value="Submit"  class="btn btn-primary" style="margin-bottom: 15px"></input>
                            <input value="<?php echo ($e['CustomerID']);?>" name="inputCustomerID" hidden></input>
                            </form>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </tr>
            </tbody>
           <?php
            $countParent ++;
            endwhile; ?>
          </table>          
          </div>
      </div>
      <div id="addChildDiv" style="display: none">
        <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-7 container-fluid rounded a2">
          <form method="post" id="addChildForm">
            <div class="form-group" align="center">
              <label for="Firstname">Firstname:</label>
              <input style="border-color: #007bff" type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" title="Enter your child's firstname" class="form-control" id="firstnameChild" name="reg_firstnameChild" placeholder="Enter Firstname" required>
            </div>
            <div class="form-group" align="center">
              <label for="Surname">Surname:</label>
              <input style="border-color: #007bff" type="text" pattern="^(?![\s.]+$)[a-zA-Z\s.]*$" title="Enter your child's surname" class="form-control" id="surnameChild" name="reg_surnameChild" placeholder="Enter Surname" required>
            </div>
            <div class="form-group" align="center">
              <label for="Dob">Date of birth:</label>
              <input style="border-color: #007bff" type="date" title="Enter your child's date of birth" class="form-control" id="dobChild" name="reg_dobChild" placeholder="Enter Date of Birth" required>
            </div>
            <div class="form-group" align="center">
              <label for="Gender">Gender:</label>
              <br>
              <input type="radio" name="reg_genderChild" value="Male" checked> Male<br>
              <input type="radio" name="reg_genderChild" value="Female"> Female<br>
            </div>
            <div class="form-group" align="center">
              <label for="Other Information">Other Information:</label>
              <input style="border-color: #007bff" type="comment" title="Enter other information about the child" class="form-control" id="otherInfo" name="reg_Other" placeholder="Enter other information">
            </div>
            <div align="center">
              <input type="submit" name="submitChild" value="Submit" class="btn btn-primary" id="submitChild" style="margin-bottom:15px"></input>
            </div>
          </form>
        </div>
       </div>
      <div id="viewBookingDiv">
        <div class="col-md-auto container-fluid rounded" style="padding-left: 0px; padding-right: 0px;">
          <table class='table table-striped' style='text-transform:Capitalize'>
            <thead>
              <tr>
                <th scope="col">BookingID</th>
                <th scope="col">Child Name</th>
                <th scope="col">Booking Date</th>
                <th scope="col">Session</th>
                <th scope="col">Other Infoamtion</th>
                <th scope="col">Price of booking</th>
                <th scope="col">Paid</th>
                <th scope="col">Edit</th>
                <th scope="col">CheckIn</th>
                <th scope="col">CheckOut</th>
              </tr>
            </thead>
            <?php
            $count = 0;
            while ($b = $stmtBooking->fetch(PDO::FETCH_ASSOC)): ?>
            <tbody>
              <tr>
                <td><?php echo ($b['BookingID']);?></td>
                <td><?php echo ($b['Child_Firstname'] . " " . $b['Child_Surname']);?></td>
                <td><?php echo ($b['Date_Of_booking']);?></td>
                <td><?php echo ($b['timeStart'] . " - " . $b['timeEnd']);?></td>
                <td><?php echo ($b['otherBookingInfo']);?></td>
                <td><?php echo ($b['Price_Of_booking']);?></td>
                <td><?php 
                  if($b['Paid'] == 0){
                    echo "<form method='post'><button type='submit' name='deleteBooking' value='" . $b['BookingID'] . "' class='btn btn-danger' id='deleteBooking'>Delete</button></form>";
                  } else{
                    echo "Yes";
                  }
                  ?></td>
                <td><button type='submit' name='editBooking' class='btn btn-info' data-toggle='modal' data-target='#editModal<?php echo ($count);?>'>Edit</button></td>
              <div id="editModal<?php echo $count;?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #007bff">
                          <h2 class="modal-title" style="color: #ffffff">Edit this booking: </h2>
                        </div>
                        <div class="modal-body">
                          <div align="center">
                            <form method="post" id="makeBooking" onSubmit="return bookingVal<?php echo ($count);?>()">
                            <div class="form-group" align="center">
                              <label for="selectChild">Select Child:</label>
                              <select name="selectedChild" style="border-color: #007bff">
                                <br>
                                <option>Select...</option>
                                <?php 
                                 $database2 = "SELECT Child_Firstname, Child_Surname, ChildID FROM tblChild WHERE tblCustomers_CustomerID = :CustomerID";
                                 $stmtChoose = $conn->prepare($database2);
                                 $stmtChoose->bindParam(':CustomerID', $b['tblCustomers_CustomerID']);
                                 $stmtChoose->execute();
                                 while ($u = $stmtChoose->fetch(PDO::FETCH_ASSOC)): ?>
                                <option value="<?php echo $u['ChildID'];?>"><?php echo ($u['Child_Firstname'] . " " . $u['Child_Surname']);?></option>
                                <?php endwhile; ?>
                              </select>
                            </div>
                            <div class="container" align="center">
                                    <div class="form-group">
                                      <label>Choose Date: </label>
                                        <div class="input-group date" id="datetimeBook<?php echo ($count);?>" data-target-input="nearest">
                                            <input type="text" onkeydown="return false" class="form-control datetimepicker-input" data-target="#datetimeBook<?php echo ($count);?>" name="datePicker" style="border-color: #007bff"/>
                                            <div class="input-group-append" data-target="#datetimeBook<?php echo ($count);?>" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="form-group" align="center">
                              <label>Start of session:</label>
                              <select id="timeStart<?php echo ($count);?>" name="timeStart" style="border-color: #007bff">
                                <option value="06:00:00">6:00 am</option>
                                <option value="06:30:00">6:30 am</option>
                                <option value="07:00:00">7:00 am</option>
                                <option value="07:30:00">7:30 am</option>
                                <option value="08:00:00">8:00 am</option>
                                <option value="08:30:00">8:30 am</option>
                                <option value="09:00:00">9:00 am</option>
                                <option value="09:30:00">9:30 am</option>
                                <option value="10:00:00">10:00 am</option>
                                <option value="10:30:00">10:30 am</option>
                                <option value="11:00:00">11:00 am</option>
                                <option value="11:30:00">11:30 am</option>
                                <option value="12:00:00">12:00 pm</option>
                                <option value="12:30:00">12:30 pm</option>
                                <option value="13:00:00">13:00 pm</option>
                                <option value="13:30:00">13:30 pm</option>
                                <option value="14:00:00">14:00 pm</option>
                                <option value="14:30:00">14:30 pm</option>
                                <option value="15:00:00">15:00 pm</option>
                                <option value="15:30:00">15:30 pm</option>
                                <option value="16:00:00">16:00 pm</option>
                                <option value="16:30:00">16:30 pm</option>
                                <option value="17:00:00">17:00 pm</option>
                                <option value="17:30:00">17:30 pm</option>
                                <option value="18:00:00">18:00 pm</option>
                                <option value="18:30:00">18:30 pm</option>
                                <option value="19:00:00">19:00 pm</option>
                                <option value="19:30:00">19:30 pm</option>
                                <option value="20:00:00">20:00 pm</option>
                                <option value="20:30:00">20:30 pm</option>
                                <option value="21:00:00">9:00 pm</option>
                               </select>
                            </div>
                            <div class="form-group" align="center">
                              <label>End of session:</label>
                              <select id="timeEnd<?php echo ($count);?>" name="timeEnd" style="border-color: #007bff">
                                <option value="06:00:00">6:00 am</option>
                                <option value="06:30:00">6:30 am</option>
                                <option value="07:00:00">7:00 am</option>
                                <option value="07:30:00">7:30 am</option>
                                <option value="08:00:00">8:00 am</option>
                                <option value="08:30:00">8:30 am</option>
                                <option value="09:00:00">9:00 am</option>
                                <option value="09:30:00">9:30 am</option>
                                <option value="10:00:00">10:00 am</option>
                                <option value="10:30:00">10:30 am</option>
                                <option value="11:00:00">11:00 am</option>
                                <option value="11:30:00">11:30 am</option>
                                <option value="12:00:00">12:00 pm</option>
                                <option value="12:30:00">12:30 pm</option>
                                <option value="13:00:00">13:00 pm</option>
                                <option value="13:30:00">13:30 pm</option>
                                <option value="14:00:00">14:00 pm</option>
                                <option value="14:30:00">14:30 pm</option>
                                <option value="15:00:00">15:00 pm</option>
                                <option value="15:30:00">15:30 pm</option>
                                <option value="16:00:00">16:00 pm</option>
                                <option value="16:30:00">16:30 pm</option>
                                <option value="17:00:00">17:00 pm</option>
                                <option value="17:30:00">17:30 pm</option>
                                <option value="18:00:00">18:00 pm</option>
                                <option value="18:30:00">18:30 pm</option>
                                <option value="19:00:00">19:00 pm</option>
                                <option value="19:30:00">19:30 pm</option>
                                <option value="20:00:00">20:00 pm</option>
                                <option value="20:30:00">20:30 pm</option>
                                <option value="21:00:00">9:00 pm</option>
                               </select>
                            </div>
                            <div class="form-group" align="center">
                              <p id="p<?php echo ($count);?>"></p>
                              <input name="bookingInput" id="bookingInput<?php echo ($count);?>" hidden>
                            </div>
                            <div class="form-group" align="center">
                              <Label>Other Information: </Label>
                              <textarea style="border-color: #007bff" type="text" title="Enter other information about your child." class="form-control" name="otherBookingInfo" placeholder="Other information that Kirsty may need to know e.g. picking kids up from school, work on their literacy"><?php echo ($b['otherBookingInfo']);?></textarea>
                            </div>
                            <div class="form-group" align="center">
                              <label for="Paid">Already Paid?:</label>
                              <br>
                              <input type="radio" name="Paid" value="0" checked> No<br>
                              <input type="radio" name="Paid" value="1"> Yes<br>
                            </div>
                            <div class="alert alert-primary" align="left" id="errorsTime<?php echo ($count);?>" style="display: none; max-width:500px">
                                <ul style="padding-left:0px;">
                                  <li style="display: none" id="time_li<?php echo ($count);?>"><i class="fa fa-times"></i><strong style="padding-left:17px" id="time_err<?php echo ($count);?>"></strong></li>
                                </ul>
                            </div>
                            <div class="form-group" align="center" style="padding-top:20px">
                              <input type="submit" name="submitBooking" value="Submit" class="btn btn-primary" id="submitBooking" style="margin-bottom:15px"></input>
                            </div>
                            <input name="bookingID" value="<?php echo ($b['BookingID']);?>" hidden>
                          </form>
                          <script>
                               function bookingVal<?php echo ($count);?> (){
                                 if(document.getElementById('errorsTime<?php echo ($count);?>').style.display == 'none'){
                                    return true;
                                  }else{
                                    return false;
                                  }
                                }
                              //calling the datetime picker
                               $(function () {
                                          $('#datetimeBook<?php echo ($count);?>').datetimepicker({
                                              format: 'YYYY-MM-DD',
                                              minDate:new Date(),
                                              sideBySide: true,
                                              daysOfWeekDisabled: [0,6],
                                              keyBinds: false,
                                          });
                                      });
                                $(document).ready(function() {    
                                  function calculateTime() {
                                          //get values
                                          var valuestart = $("#timeStart<?php echo ($count);?>").val();
                                          var valuestop = $("#timeEnd<?php echo ($count);?>").val();

                                           //create date format          
                                           var timeStartHr = new Date("01/01/2007 " + valuestart).getHours();
                                           var timeEndHr = new Date("01/01/2007 " + valuestop).getHours();
                                           var timeStartMin = new Date("01/01/2007 " + valuestart).getMinutes();
                                           var timeEndMin = new Date("01/01/2007 " + valuestop).getMinutes();

                                           var hourDiff = timeEndHr - timeStartHr;
                                           var minDiff = timeEndMin - timeStartMin;
                                           var time = ((((hourDiff * 60) + minDiff)/60)*5)
                                            if (time <= 0){
                                             document.getElementById('errorsTime<?php echo ($count);?>').style.display = "block";
                                             document.getElementById('time_li<?php echo ($count);?>').style.display = "block";
                                             document.getElementById('time_err<?php echo ($count);?>').innerHTML = "You can't book these times.";
                                             $("#p<?php echo ($count);?>").html("");
                                           } else{
                                             document.getElementById('errorsTime<?php echo ($count);?>').style.display = "none";
                                             document.getElementById('time_li<?php echo ($count);?>').style.display = "none";
                                             $("#p<?php echo ($count);?>").html("<b>Cost of Booking: £</b>" + time);
                                             document.getElementById('bookingInput<?php echo ($count);?>').value = time;  
                                           }                          

                                  }

                                  $("select").change(calculateTime);
                                  calculateTime();
                                  });
                          </script>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php 
                  if($b['CheckIn'] == 0){
                    $td1 = ("<form method='post'><button type='submit' name='timeIn' value='" . $b['BookingID'] . "' class='btn btn-success' id='CheckIn'>Check In</button></form>");
                    $td2 = ("-");
                  }elseif($b['CheckIn'] == 1 && $b['CheckOut'] == 0){
                    $td1 = ($b['timeIn']);
                    $td2 = ("<form method='post'><button type='submit' name='timeOut' value='" . $b['BookingID'] . "' class='btn btn-success' id='CheckOut'>Check Out</button></form>");
                  }elseif($b['CheckOut'] == 1){
                    $td1 = ($b['timeIn']);
                    $td2 = ($b['timeOut']);
                  }
              ?>
                <td><?php echo ($td1);?></td>
                <td><?php echo ($td2);?></td>
              </tr>
            </tbody>
           <?php
            $count ++;
            endwhile; ?>
          </table>          
          </div>
      </div>
    </div>
    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6 col-xl-6 container rounded" style="margin-top:90px; border-style:outset;border-color: #007bff;">
      <ul style="list-style: none; padding-left:0px">
        <li>
            <input type="button" id="viewBooking" class="btn btn-outline-warning a1" name="viewBooking" value="View Booking" style="width:120px; margin-bottom: 20px;  margin-top: 10px; " onclick="btnViewBookingDiv();">
            <span class="a1">View Bookings</span>
        </li>
        <li>
            <input type="button" id="viewChild" class="btn btn-outline-success a1" name="addChild" value="View Children" style="width:120px; margin-bottom: 20px;" onclick="btnViewChildDiv();">
            <span class="a1">View children</span>
        </li>
        <li>
            <input type="button" id="viewParents" class="btn btn-outline-primary a1" name="viewParent" value="View Parents" style="width:120px; margin-bottom: 20px;" onclick="btnViewParentDiv();">
            <span class="a1">View parents</span>
        </li>
      </ul>
    </div>
  </div>
</div>
</head>
</body>
</html>