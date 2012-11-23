<?php
namespace Webcam;

class BarberryUploader
{
    private $baseUrl;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function upload($filePath)
    {
        $ch = curl_init($this->baseUrl);
        curl_setopt_array(
            $ch,
            array(CURLOPT_RETURNTRANSFER => true, CURLOPT_POSTFIELDS => array('file' => '@' . $filePath),)
        );
        $ret = curl_exec($ch);
        curl_close($ch);
        $answer = json_decode($ret, true);
        if ($answer === null)
            throw new \RuntimeException($ret);
        return $answer;
    }
}
