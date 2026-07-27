<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION["admin"])) {
    header("Location: admin.html");
    exit;
}

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $department = trim($_POST["department_name"]);

    if (!empty($department)) {

        $groupId =
            "DEPT-" .
            strtoupper(
                preg_replace(
                    '/[^A-Za-z0-9]/',
                    '-',
                    $department
                )
            );

        $folder =
            "/home/femi/n8n-production/files/" .
            $department;

        if (!is_dir($folder)) {
            mkdir($folder, 0775, true);
        }

        $stmt = $conn->prepare(
            "INSERT INTO departments
            (department_name,group_id,folder_name)
            VALUES (?,?,?)"
        );

        $stmt->bind_param(
            "sss",
            $department,
            $groupId,
            $department
        );

        $stmt->execute();
    }

    header("Location: departments.php");
    exit;
}

$result = $conn->query(
"
SELECT *
FROM departments
ORDER BY department_name
"
);

?>

<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<title>Departments</title>

admin.css

<style>

.card{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    box-shadow:0 2px 8px rgba(0,0,0,.1);
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th{
    background:#4da3ff;
    color:white;
    text-align:left;
    padding:12px;
}

td{
    padding:12px;
    border-bottom:1px solid #eee;
}

input{
    padding:10px;
    width:250px;
}

button{
    padding:10px 15px;
}

</style>

</head>

<body>

<?php include 'sidebar.php'; ?>

<div class="content">

    <h1>Departments</h1>

    <div class="card">

        <form method="post">

            <h3>Add Department</h3>

            <input
                type="text"
                name="department_name"
                placeholder="Department Name"
                required>

            <br><br>

            <button type="submit">
                Add Department
            </button>

        </form>

    </div>

    <table>

        <thead>

            <tr>
                <th>ID</th>
                <th>Department</th>
                <th>Group ID</th>
                <th>Folder</th>
                <th>Status</th>
            </tr>

        </thead>

        <tbody>

        <?php while($row = $result->fetch_assoc()) { ?>

            <tr>

                <td><?= $row["id"] ?></td>

                <td><?= htmlspecialchars($row["department_name"]) ?></td>

                <td><?= htmlspecialchars($row["group_id"]) ?></td>

                <td><?= htmlspecialchars($row["folder_name"]) ?></td>

                <td><?= htmlspecialchars($row["status"]) ?></td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

</body>
</html>
