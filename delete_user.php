<?php

header("Content-Type: application/json");

require "db.php";

$data =
json_decode(
file_get_contents("php://input"),
true
);

$id =
$data["id"];

$stmt =
$conn->prepare(
"DELETE FROM users
WHERE id=?"
);

$stmt->bind_param(
"i",
$id
);

$stmt->execute();

echo json_encode([
"success"=>true
]);

?>
`
