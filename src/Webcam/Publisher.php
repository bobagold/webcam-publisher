<?php
namespace Webcam;

class Publisher
{
    private $path;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function getLastFile($streamName)
    {
        $filePaths = glob($this->path . $streamName . '-*.flv');
        return array_pop($filePaths);
    }

    public function indexFlv($filePath)
    {
        $indexedPath = $this->path . 'indexed/';
        if (!is_dir($indexedPath)) {
            mkdir($indexedPath);
        }
        $out = $indexedPath . basename($filePath);
        $cmdOut = exec('yamdi -i ' . escapeshellarg($filePath) . ' -o ' . escapeshellarg($out));
        if ($cmdOut) {
            throw new \RuntimeException($cmdOut);
        }
        return $out;
    }
}
