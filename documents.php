<?php

session_start();

if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {
    header("Location: admin.html");
    exit;
}

require "db.php";

$departments = [];

$result = $conn->query("
    SELECT department_name
    FROM departments
    WHERE status='Active'
    ORDER BY department_name
");

while ($row = $result->fetch_assoc()) {
    $departments[] = $row["department_name"];
}

$baseFolder =
"/home/femi/n8n-production/files";

$totalDocuments = 0;

$folders = glob($baseFolder . "/*");

foreach ($folders as $folder) {

    if (!is_dir($folder)) {
        continue;
    }

    $files = glob($folder . "/*");

    foreach ($files as $file) {

        if (is_file($file)) {
            $totalDocuments++;
        }

    }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Document Management</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Segoe UI',sans-serif;

    background:#f4f6fa;

}

.header{

    background:#1d2755;

    color:white;

    padding:20px;

    display:flex;

    justify-content:space-between;

    align-items:center;

}

.container{

    width:95%;

    margin:auto;

    margin-top:25px;

}

.stats{

    display:flex;

    gap:20px;

    margin-bottom:25px;

}

.stat-card{

    flex:1;

    background:white;

    padding:20px;

    border-radius:10px;

    text-align:center;

    box-shadow:
    0 2px 10px rgba(0,0,0,.08);

}

.stat-card h3{

    color:#1d2755;

    margin-bottom:10px;

}

.stat-card p{

    font-size:28px;

    font-weight:bold;

}

.card,
.table-card{

    background:white;

    border-radius:10px;

    padding:25px;

    margin-bottom:25px;

    box-shadow:
    0 2px 10px rgba(0,0,0,.08);

}

h2{

    margin-bottom:20px;

}

label{

    display:block;

    margin-bottom:8px;

    font-weight:bold;

}

select,
input[type=file],
input[type=text]{

    width:100%;

    padding:12px;

    border:1px solid #ccc;

    border-radius:6px;

    margin-bottom:15px;

}

.upload-btn{

    background:#4da3ff;

    color:white;

    border:none;

    padding:12px 20px;

    border-radius:6px;

    cursor:pointer;

}

.upload-btn:hover{

    background:#2b89eb;

}

.back-btn{

    color:white;

    text-decoration:none;

}

table{

    width:100%;

    border-collapse:collapse;

}

th{

    background:#4a90e2;

    color:white;

    padding:12px;

    text-align:left;

}

td{

    padding:12px;

    border-bottom:1px solid #ddd;

}

.status{

    color:green;

    font-weight:bold;

}

.view-btn{

    color:#28a745;

    text-decoration:none;

}

.delete-btn{

    color:#dc3545;

    text-decoration:none;

    margin-left:10px;

}

.success{

    background:#d4edda;

    color:#155724;

    padding:15px;

    border-radius:8px;

    margin-bottom:20px;

}

.error{

    background:#f8d7da;

    color:#721c24;

    padding:15px;

    border-radius:8px;

    margin-bottom:20px;

}

</style>

</head>

<body>

<div class="header">

    <h1>Document Management</h1>

    <a
    href="dashboard.php"
    class="back-btn">

    ← Back to Dashboard

    </a>

</div>

<div class="container">

<?php

if (isset($_GET["upload"])) {

    if ($_GET["upload"] === "success") {

        echo '
        <div class="success">
        ✅ Document uploaded successfully.
        </div>';

    }

    if ($_GET["upload"] === "failed") {

        echo '
        <div class="error">
        ❌ Document upload failed.
        </div>';

    }

}

?>

<div class="stats">

    <div class="stat-card">

        <h3>Documents</h3>

        <p><?= $totalDocuments ?></p>

    </div>

    <div class="stat-card">

        <h3>Departments</h3>

        <p><?= count($departments) ?></p>

    </div>

    <div class="stat-card">

        <h3>Status</h3>

        <p>Live</p>

    </div>

</div>

<div class="card">

<h2>Upload Document</h2>

upload_document.phpenctype="multipart/form-data">

<label>Department</label>

<select
name="department"
required>

<?php foreach ($departments as $department): ?>

<option
value="<?= htmlspecialchars($department) ?>">

<?= htmlspecialchars($department) ?>

</option>

<?php endforeach; ?>

</select>

<label>Document</label>

<input
type="file"
name="document"
accept=".pdf,.docx,.txt,.xlsx,.csv"
required>

<button
type="submit"
class="upload-btn">

Upload Document

</button>

</form>

</div>

<div class="table-card">

<h2>Uploaded Documents</h2>

<input
type="text"
id="docSearch"
placeholder="Search documents...">

<table id="documentsTable">

<thead>

<tr>

<th>File Name</th>
<th>Type</th>
<th>Department</th>
<th>Status</th>
<th>Size</th>

</tr>

</thead>

<tbody>

<?php

foreach ($folders as $folder) {

    if (!is_dir($folder)) {
        continue;
    }

    $department =
    basename($folder);

    $files =
    glob($folder . "/*");

    foreach ($files as $file) {

        if (!is_file($file)) {
            continue;
        }

        $fileName =
        basename($file);

        $type =
        strtoupper(
        pathinfo(
        $fileName,
        PATHINFO_EXTENSION
        ));

        $size =
        round(
        filesize($file)
        / 1024,
        2
        );

        ?>

        <tr>

            <td><?= htmlspecialchars($fileName) ?></td>

            <td><?= $type ?></td>

            <td><?= htmlspecialchars($department) ?></td>

            <td class="status">
                🟢 Indexed
            </td>

            <td>
                <?= $size ?> KB
            </td>

        </tr>

        <?php

    }

}

?>

</tbody>

</table>

</div>

</div>

<script>

document
.getElementById("docSearch")
.addEventListener("keyup", function() {

    let filter =
    this.value.toLowerCase();

    let rows =
    document.querySelectorAll(
    "#documentsTable tbody tr"
    );

    rows.forEach(row => {

        row.style.display =
        row.innerText
        .toLowerCase()
        .includes(filter)
        ? ""
        : "none";

    });

});

</script>

</body>
</html>
