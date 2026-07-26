<?php

session_start();

if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {
    header("Location: admin.html");
    exit;
}

if (
    !isset($_FILES["document"])
) {
    die("No file uploaded.");
}

$department =
trim(
    $_POST["department"] ?? ""
);

if ($department === "") {
    die("Department not selected.");
}

$baseDirectory =
"/home/femi/n8n-production/files/";

$departmentFolder =
$baseDirectory .
$department .
"/";

if (
    !is_dir($departmentFolder)
) {
    mkdir(
        $departmentFolder,
        0775,
        true
    );
}

$fileName =
basename(
    $_FILES["document"]["name"]
);

$fileExtension =
strtolower(
    pathinfo(
        $fileName,
        PATHINFO_EXTENSION
    )
);

$allowedExtensions = [

    "pdf",

    "docx",

    "txt",

    "csv",

    "xlsx",

    "xls"

];

if (
    !in_array(
        $fileExtension,
        $allowedExtensions
    )
) {

    die(
        "Only PDF, DOCX, TXT, CSV, XLSX and XLS files are allowed."
    );

}

$targetFile =
$departmentFolder .
$fileName;

if (

    move_uploaded_file(

        $_FILES["document"]["tmp_name"],

        $targetFile

    )

) {

    header(
        "Location: documents.php?upload=success"
    );

    exit;

}
else {

    header(
        "Location: documents.php?upload=failed"
    );

    exit;

}
?>
