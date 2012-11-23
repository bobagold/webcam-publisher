<?php
namespace Integration\Webcam;

class TestRtmpServerTest extends TestCase
{
    public function testFileCreated()
    {
        $time = time();
        $filePath = '/tmp/av/mystream-' . $time . '.flv';
        $this->assertEquals($filePath, $this->rtmp_server->recordStream('mystream', $time));
        $this->assertFileExists($filePath);
        $this->assertIsFlv($filePath);
        $this->assertFalse($this->isIndexed($filePath));
    }
}
