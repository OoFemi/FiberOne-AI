<?php

$host = "localhost";
$user = "atlasai";
$pass = "AtlasAI123!";
$db   = "atlas_ai";

$conn = new mysqli(
    $host,
    $user,
    $pass,
    $db
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
