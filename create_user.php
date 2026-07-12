<?php

header("Content-Type: application/json");

require "db.php";

$data =
json_decode(
    file_get_contents("php://input"),
    true
);

$result =
$conn->query(
    "SELECT MAX(id) AS max_id FROM users"
);

$row =
$result->fetch_assoc();

$user_id =
"ATL-USR-" .
str_pad(
    ($row['max_id'] ?? 0) + 1,
    5,
    "0",
    STR_PAD_LEFT
);

$first_name =
$data["first_name"] ?? "";

$last_name =
$data["last_name"] ?? "";

$email =
$data["email"] ?? "";

$username =
$data["username"];

$passwordHash =
password_hash(
    $data["password"],
    PASSWORD_DEFAULT
);

$role =
$data["role"] ?? "user";

$group_id =
$data["group_id"] ?? "ATL-GRP-SUPPORT";

$status =
"Active";

$stmt =
$conn->prepare(
"
INSERT INTO users
(
    user_id,
    first_name,
    last_name,
    email,
    username,
    password_hash,
    role,
    group_id,
    status
)
VALUES
(
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?,
    ?
)
"
);

$stmt->bind_param(
    "sssssssss",
    $user_id,
    $first_name,
    $last_name,
    $email,
    $username,
    $passwordHash,
    $role,
    $group_id,
    $status
);

$stmt->execute();

echo json_encode([
    "success" => true,
    "user_id" => $user_id
]);

?>
