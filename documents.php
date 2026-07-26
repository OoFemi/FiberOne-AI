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

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
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

.card,
.table-card{

    background:white;

    border-radius:10px;

    padding:25px;

    margin-bottom:25px;

    box-shadow:
    0 2px 10px rgba(0,0,0,.08);

}

.card h2,
.table-card h2{

    margin-bottom:20px;

}

label{

    display:block;

    margin-bottom:8px;

    font-weight:bold;

}

select,
input[type=file]{

    width:100%;

    padding:12px;

    margin-bottom:18px;

    border:1px solid #ccc;

    border-radius:6px;

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

.back-btn:hover{

    text-decoration:underline;

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

.action-btn{

    text-decoration:none;

    padding:6px 10px;

    border-radius:5px;

    color:white;

    font-size:12px;

}

.view-btn{

    background:#28a745;

}

.delete-btn{

    background:#dc3545;

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

pre{

    background:#f5f5f5;

    padding:10px;

    border-radius:5px;

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

<div class="card">

    <h2>Upload Document</h2>

    upload_document.php

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

    <table>

        <tr>

            <th>File Name</th>

            <th>Department</th>

            <th>Size</th>

            <th>Actions</th>

        </tr>

        <?php

        $baseFolder =
        "/home/femi/n8n-production/files";

        $folders =
        glob($baseFolder . "/*");

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

                $size =
                round(
                    filesize($file) / 1024,
                    2
                );

                ?>

                <tr>

                    <td>
                        <?= htmlspecialchars($fileName) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars($department) ?>
                    </td>

                    <td>
                        <?= $size ?> KB
                    </td>

                    <td>

                        =<?= urlencode($fileName) ?>">

                        View

                        </a>

                         ?>&file=<?= urlencode($fileName) ?>"
                        onclick="return confirm('Delete this document?')">

                        Delete

                        </a>

                    </td>

                </tr>

                <?php

            }

        }

        ?>

    </table>

</div>

<div class="table-card">

<h2>Upload Instructions</h2>

<p>Supported files:</p>

<br>

<ul>

<li>PDF</li>
<li>DOCX</li>
<li>TXT</li>
<li>XLSX</li>
<li>CSV</li>

</ul>

<br>

<p>Files uploaded to:</p>

<br>

<pre>/home/femi/n8n-production/files/{department}</pre>

<br>

<p>

After upload, documents can be indexed
into Atlas AI through the ingestion workflow.

</p>

</div>

</div>

</body>
</html>
