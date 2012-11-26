<?php
require_once(__DIR__ . '/../vendor/autoload.php');
$streamName = basename($_SERVER['REQUEST_URI']);
$publisher = new \Webcam\Publisher('/tmp/av/');
$filePath = $publisher->getLastFile($streamName);
if ($filePath) {
    $indexedFilePath = $publisher->indexFlv($filePath);
    if ($indexedFilePath && file_exists($indexedFilePath)) {
        $uploader = new \Webcam\BarberryUploader('http://barberry.local/');
        header("Content-type: application/json", null, 200);
        echo json_encode($uploader->upload($indexedFilePath));
        exit(0);
    }
    header("Content-type: application/json", null, 500);
    echo json_encode('unable to create index');
    exit(1);
}
header("Content-type: application/json", null, 404);
echo json_encode('file not found');
