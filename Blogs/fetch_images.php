<?php
$images = [];
$targetDir = "uploads/";

// Scan the uploads directory for images
foreach (glob($targetDir . "*.{jpg,jpeg,png,gif}", GLOB_BRACE) as $file) {
    $images[] = ['filePath' => $file];
}

// Output as JSON
header('Content-Type: application/json');
echo json_encode($images);
