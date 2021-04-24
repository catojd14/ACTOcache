<?php
$servername = "localhost";
$username = "user";
$password = "zhouto6901";


$conn = new PDO("mysql:host=$servername;dbname=rwctest", $username, $password);
  // set the PDO error mode to exception
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  

