<?php
namespace Turing;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;


/**
 * PHP class to call Turing Analytics visual APIs
 */
class Visual
{
    const IMG_FLIP_VERTICAL = 1;
    public $api_key;
    protected $base_url;
    protected $client;

    /**
     * Constructor for API calls
     *
     * @param string $api_key
     * @param string $mode
     * @param string $api_version
     * @return Visual
     * @throws VisualException
     */
    public function __construct($api_key, $mode = "live", $api_version = "v1")
    {
        if ($api_key === null || empty($api_key)) {
            throw new VisualException('API key is not provided.');
        } else {
            $this->api_key = $api_key;
        }

        if ($mode != 'live' && $mode != "sandbox") {
            throw new VisualException('$mode can only be either \'live\' or \'sandbox\'. You provided: ' + $mode);
        } else {
            $this->mode = $mode;
        }

        if ($api_version != 'v1') {
            throw new VisualException('Currenly only \'v1\' is supported for $api_version');
        } else {
            $this->api_version = $api_version;
        }

        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => "https://api.turingiq.com/$this->api_version/",
            'headers' => ['Authorization'=> "Bearer $this->api_key"],
            // You can set any number of default request options.
            'timeout'  => 10.0,
            'synchronous' => true
        ]);
        return $this;
    }

    public function autocrop($url)
    {
      try {
        $response = $this->client->get("autocrop", ['query'=> ["url" => $url]]);
      } catch (ClientException $e) {
        $response = $e->getResponse();
        $json_error = json_decode($response->getBody(), true);
        if($json_error){
          throw new VisualException($json_error["error"]);
        }
      }
      return json_decode($response->getBody(), true)["boxes"];

    }

    public function search($url, $filters)
    {
    }

    public function recommendations($id, $filters)
    {
    }

    public function insert($id, $url, $filters, $metadata)
    {
    }

    public function update($id, $url, $filters, $metadata)
    {
    }

    public function delete($id)
    {
    }
}
