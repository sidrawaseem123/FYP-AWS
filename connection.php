<?php
error_reporting(E_ALL);
$servername = "localhost";
$username = "admin";
$password = "12345678";
$dbname = "product_module";

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