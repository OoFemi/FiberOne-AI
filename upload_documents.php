<?php

session_start();

if (
    !isset($_SESSION["admin"]) ||
    $_SESSION["admin"] !== true
) {
    header("Location: admin.html");
    exit;
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (
    !isset($_FILES["document"])
) {

    header(
        "Location: documents.php?upload=failed"
    );

    exit;

}

$department =
trim(
    $_POST["department"] ?? ""
);

if (
    $department === ""
) {

    header(
        "Location: documents.php?upload=failed"
    );

    exit;

}

$baseFolder =
"/home/femi/n8n-production/files/";

$departmentFolder =
$baseFolder .
$department .
"/";

if (
    !is_dir($departmentFolder)
) {

    if (
        !mkdir(
            $departmentFolder,
            0775,
            true
        )
    ) {

        header(
            "Location: documents.php?upload=failed"
        );

        exit;

    }

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
    "doc",
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

    header(
        "Location: documents.php?upload=failed"
    );

    exit;

}

if (
    $_FILES["document"]["error"] !==
    UPLOAD_ERR_OK
) {

    header(
        "Location: documents.php?upload=failed"
    );

    exit;

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

header(
    "Location: documents.php?upload=failed"
);

exit;

?>
