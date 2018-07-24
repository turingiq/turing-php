<?php
namespace Turing;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\ClientException;


/**
 * PHP class to call Turing Analytics visual APIs
 */
class VisualAPI
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
     * @return VisualAPI
     * @throws VisualAPIException
     */
    public function __construct($api_key, $mode = "live", $api_version = "v1")
    {
        if ($api_key === null || empty($api_key)) {
            throw new VisualAPIException('API key is not provided.');
        } else {
            $this->api_key = $api_key;
        }

        if ($mode != 'live' && $mode != "sandbox") {
            throw new VisualAPIException('$mode can only be either \'live\' or \'sandbox\'. You provided: ' + $mode);
        } else {
            $this->mode = $mode;
        }

        if ($api_version != 'v1') {
            throw new VisualAPIException('Currenly only \'v1\' is supported for $api_version');
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
          throw new VisualAPIException($json_error["error"]);
        }
      }
      return json_decode($response->getBody(), true);
    }

    public function search($url, $crop = [], $filters = [])
    {
      try {
        if($this->mode == 'live'){
          $path = "similar/search";
        } else {
          $path = "demo-similar/search";
        }
        $response = $this->client->post($path, ['json'=> ["url" => $url,
          'crop' => join(",", $crop),
          'filter1'=> $filters['filter1'],
          'filter2'=> $filters['filter2'],
          'filter3'=> $filters['filter3'],
        ]]);
      } catch (ClientException $e) {
        $response = $e->getResponse();
        $json_error = json_decode($response->getBody(), true);
        if($json_error){
          throw new VisualAPIException($json_error["error"]);
        }
      }
      return json_decode($response->getBody(), true);
    }

    public function recommendations($id, $filters = [])
    {
      try {
        if($this->mode == 'live'){
          $path = "similar/$id";
        } else {
          $path = "demo-similar/$id";
        }
        $response = $this->client->get($path, ['query'=> [
          'filter1'=> $filters['filter1'],
          'filter2'=> $filters['filter2'],
          'filter3'=> $filters['filter3'],
        ]]);
      } catch (ClientException $e) {
        $response = $e->getResponse();
        $json_error = json_decode($response->getBody(), true);
        if($json_error){
          throw new VisualAPIException($json_error["error"]);
        }
      }
      return json_decode($response->getBody(), true);
    }

    public function insert($id, $url, $filters, $metadata)
    {
      try {
        if($this->mode == 'live'){
          $path = "similar/create";
        } else {
          $path = "demo-similar/create";
        }
        $json_data = [
          'url' => $url,
          'filter1'=> $filters['filter1'],
          'filter2'=> $filters['filter2'],
          'filter3'=> $filters['filter3'],
        ];
        foreach ($metadata as $key => $value){
          $json_data[$key] = $value;
        }

        $response = $this->client->post($path, ['json'=> $json_data]);

      } catch (ClientException $e) {
        $response = $e->getResponse();
        $json_error = json_decode($response->getBody(), true);
        if($json_error){
          throw new VisualAPIException($json_error["error"]);
        }
      }
      return json_decode($response->getBody(), true);
    }

    public function update($id, $url, $filters, $metadata)
    {
      return $this->insert($id, $url, $filters, $metadata);
    }

    public function delete($id)
    {
      try {
        if($this->mode == 'live'){
          $path = "similar/$id";
        } else {
          $path = "demo-similar/$id";
        }
        $response = $this->client->delete($path);
      } catch (ClientException $e) {
        $response = $e->getResponse();
        $json_error = json_decode($response->getBody(), true);
        if($json_error){
          throw new VisualAPIException($json_error["error"]);
        }
      }
      return json_decode($response->getBody(), true);
    }
}
