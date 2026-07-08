<?php

header("Content-Type: application/json");

require "db.php";

$data =
json_decode(
file_get_contents("php://input"),
true
);

$username =
$data["username"];

$passwordHash =
password_hash(
$data["password"],
PASSWORD_DEFAULT
);

$role =
$data["role"] ?? "user";

$stmt =
$conn->prepare(
"INSERT INTO users
(username,password_hash,role)
VALUES (?,?,?)"
);

$stmt->bind_param(
"sss",
$username,
$passwordHash,
$role
);

$stmt->execute();

echo json_encode([
"success"=>true
]);

?>
