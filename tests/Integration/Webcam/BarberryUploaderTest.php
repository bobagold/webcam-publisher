<?php
namespace Integration\Webcam;

use Webcam\BarberryUploader;

class BarberryUploaderTest extends TestCase
{
    public function testUpload()
    {
        $filePath = $this->rtmp_server->recordStream('mystream', time());

        $barberryUploader = new BarberryUploader('http://barberry.local/');
        $uploaded = $barberryUploader->upload($filePath);
        $this->assertInternalType('array', $uploaded);
        $this->assertNotEquals(array(), $uploaded);
        $this->assertEquals(basename($filePath), $uploaded['filename']);
        $this->assertEquals('video/x-flv', $uploaded['contentType']);
        $this->assertGreaterThan(0, strlen($uploaded['id']));
    }
}
