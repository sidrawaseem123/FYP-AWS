<?php
error_reporting(E_ALL);
$servername = "product-module.cdmkgi6iiona.eu-west-2.rds.amazonaws.com";
$username = "admin";
$password = "12345678";
$dbname = "production_module";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if($conn)
{
  //echo"connection established1";
}
else 
{
  echo "failed1";
}

?>