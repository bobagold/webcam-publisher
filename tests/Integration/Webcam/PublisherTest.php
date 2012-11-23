<?php
namespace Webcam;

class PublisherTest extends \PHPUnit_Framework_TestCase
{
    public function testFileCreated()
    {
        $rtmp_server = new TestRtmpServer('/tmp/av/', __DIR__ . '/../../res/stream.flv');
        $time = time();
        $filePath = '/tmp/av/mystream-' . $time . '.flv';
        $this->assertEquals($filePath, $rtmp_server->recordStream('mystream', $time));
        $this->assertFileExists($filePath);
        $this->assertIsFlv($filePath);
        $this->assertFalse($this->isIndexed($filePath));

        $publisher = new Publisher('/tmp/av/');
        $this->assertEquals($filePath, $publisher->getLastFile('mystream'));

        $indexedFilePath = $publisher->indexFlv($filePath);
        $this->assertNotEquals($filePath, $indexedFilePath);
        $this->assertFileExists($indexedFilePath);
        $this->assertIsFlv($indexedFilePath);
        $this->assertTrue($this->isIndexed($indexedFilePath));
    }

    public function assertIsFlv($filePath)
    {
        $this->assertContains('Macromedia Flash Video', exec('file ' . escapeshellarg($filePath)));
    }

    public function isIndexed($filePath)
    {
        return (bool)exec('ffmpeg -i ' . escapeshellarg($filePath) . ' 2>&1 | grep keyframe');
    }
}
