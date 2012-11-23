<?php
namespace Integration\Webcam;

use Webcam\Publisher;

class PublisherTest extends TestCase
{
    public function testGetLastFile()
    {
        $filePath = $this->rtmp_server->recordStream('mystream', time());

        $publisher = new Publisher('/tmp/av/');
        $this->assertEquals($filePath, $publisher->getLastFile('mystream'));
    }

    public function testIndexFlv()
    {
        $filePath = $this->rtmp_server->recordStream('mystream', time());

        $publisher = new Publisher('/tmp/av/');
        $indexedFilePath = $publisher->indexFlv($filePath);
        $this->assertNotEquals($filePath, $indexedFilePath);
        $this->assertFileExists($indexedFilePath);
        $this->assertIsFlv($indexedFilePath);
        $this->assertTrue($this->isIndexed($indexedFilePath));
    }
}
