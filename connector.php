<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "skillstest";

$conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->error);
    }


?>