<?php
include("database.php");
if($conn->connect_error) {
  exit('Could not connect');
}

$sql = "SELECT email FROM tblCustomers WHERE email = :email";

$stmt = $conn->prepare($sql);
$stmt->bindparam(":email", $_GET['q']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(isset($row["email"])){
  echo "Taken";
}else{
  echo "Not taken";
}


?>