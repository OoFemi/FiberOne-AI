<?php

header("Content-Type: application/json");

require "db.php";

$result =
$conn->query(
"SELECT
id,
username,
role,
created_at
FROM users
ORDER BY username"
);

$users=[];

while(
$row=$result->fetch_assoc()
){

$users[]=$row;

}

echo json_encode(
$users
);

?>
