<?php
namespace Webcam;

class TestRtmpServer
{
    private $path;

    private $testStream;

    public function __construct($path, $testStream)
    {
        $this->path = $path;
        $this->testStream = $testStream;
    }

    public function recordStream($streamName, $timestamp)
    {
        $filePath = $this->path . $streamName . '-' . $timestamp . '.flv';
        copy($this->testStream, $filePath);
        return $filePath;
    }
}
