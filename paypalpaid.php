<?php
include("database.php");
if($conn->connect_error) {
  exit('Could not connect');
}
$BID = $_GET['b'];
$true = 1;
$sqlPaid = "UPDATE tblBooking SET Paid = :Paid WHERE BookingID = :BookingID;";  
$stmtPaid = $conn->prepare($sqlPaid);                                              
$stmtPaid->bindParam(':BookingID', $BID);       
$stmtPaid->bindParam(':Paid', $true);                                      
$stmtPaid->execute();

echo ($BID);

?>