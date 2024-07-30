<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $filePath = $data['filePath'];

    if (file_exists($filePath)) {
        if (unlink($filePath)) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'file not found';
    }
}
