<?php
error_reporting(E_ALL);
$servername = "localhost";
$username = "root";
$password = " ";
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