<?php
nnect database ด้วย mysqli
t = "localhost";
rname = "root";
sword = "";
abase = "bd68s_product";

  $conn = new mysqli($host,$username,$password,$database);
  if($conn->connect_error){
    die("Connection Failed: " . $conn->connect_error);
}else {
    echo "Connected successfully";


nnect database ด้วย PDO
{
    n = new PDO("mysql:host=$host;dbname=$database", $uername, $pas sword);

    n->setAttribute(PDO::ATTR_ERRMODE, PDO ::ERRMODE_EXCEPTION);
     "PDO Connected successfully";
t ch (P DOException $e) { 
     "Connected failed: ", $e>getMessage();


?>