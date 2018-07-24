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

    public function testInsert()
    {
        $visual_api = new VisualAPI(getenv("API_KEY"), "sandbox");
        $resp = $visual_api->insert("unit_test_id", "https://storage.googleapis.com/turingiq/unit_test_images/backpack-1.jpg", ["filter1" => "uint_test_filter"]);
        $this->assertEquals(true, $resp["success"]);
    }

    /**
     * @depends testInsert
     */
    public function testVisualSearch()
    {
        $visual_api = new VisualAPI(getenv("API_KEY"), "sandbox");
        $resp = $visual_api->search("https://storage.googleapis.com/turingiq/unit_test_images/backpack-1.jpg");
        $this->assertGreaterThanOrEqual(0.99, $resp["similar"][0]["similarity"]);
    }

    /**
     * @depends testVisualSearch
     */
    public function testVisualReco()
    {
        $visual_api = new VisualAPI(getenv("API_KEY"), "sandbox");
        $resp = $visual_api->recommendations("unit_test_id");
        $this->assertGreaterThanOrEqual(1, count($resp["similar"]));
    }

    /**
     * @depends testVisualReco
     */
    public function testDelete()
    {
        $visual_api = new VisualAPI(getenv("API_KEY"), "sandbox");
        $resp = $visual_api->delete("unit_test_id");
        $this->assertEquals(true, $resp["success"]);
    }
}
