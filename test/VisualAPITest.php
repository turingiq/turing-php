<?php

use \Turing\VisualAPI;
use \Turing\VisualAPIException;
use \PHPUnit\Framework\TestCase;


class VisualAPITest extends TestCase
{

  public function testAutoCrop()
    {
        $visual_api = new VisualAPI(getenv("API_KEY"), "sandbox");
        $resp = $visual_api->autocrop("https://storage.googleapis.com/turingiq/unit_test_images/backpack-1.jpg");
        $this->assertEquals([188, 256, 656, 928], $resp["boxes"][0]);
        $this->assertEquals([379, 343, 651, 870], $resp["boxes"][1]);
    }
}
