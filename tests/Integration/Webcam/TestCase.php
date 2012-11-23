<?php
namespace Integration\Webcam;

use Webcam\TestRtmpServer;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TestRtmpServer
     */
    protected $rtmp_server;

    public function setUp()
    {
        parent::setUp();
        $this->rtmp_server = new TestRtmpServer('/tmp/av/', __DIR__ . '/../../res/stream.flv');
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
