<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/";
    $oldFilePath = $_POST['oldFilePath'];
    $newFileName = basename($_FILES["newImage"]["name"]);
    $newFilePath = $targetDir . $newFileName;

    $imageFileType = strtolower(pathinfo($newFilePath, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    $check = getimagesize($_FILES["newImage"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["newImage"]["tmp_name"], $newFilePath)) {
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            echo $newFilePath;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
