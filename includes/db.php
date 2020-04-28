<?php

function getConnection(){
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $db = "ideal";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $db);
    return $conn;
}
$BASEURL = "http://localhost:8888"; // testomgeving
//$BASEURL = "http://0111.nl"; // productieomgeving

?>