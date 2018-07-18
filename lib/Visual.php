<?php
namespace Turing;
use Exception;

/**
 * PHP class to call Turing Analytics visual APIs
 */
class Visual
{
    const IMG_FLIP_VERTICAL = 1;
    public $api_key;
    protected $base_url;

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

        if($mode != 'live' && $mode != "sandbox"){
          throw new VisualException('$mode can only be either \'live\' or \'sandbox\'. You provided: ' + $mode);
        } else {
          $this->mode = $mode;
        }

        if($api_version != 'v1'){
          throw new VisualException('Currenly only \'v1\' is supported for $api_version');
        } else {
          $this->api_version = $api_version;
        }

        $this->base_url = "https://api.turingiq.com/" + $this->api_version;
        return $this;
    }
