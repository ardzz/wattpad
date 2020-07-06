<?php

/**
 * Wattpad API
 * 
 * @author Ardan <ardzz@indoxploit.or.id>
 * @package library
 * @license MIT
 */

namespace Wattpad;

use GuzzleHttp\Client;
use Wattpad\Config\API;

class Request {

    function __construct(){
        $this->apiv2 = new Client([
            "base_uri" => API::api_v2,
        ]);
        $this->apiv3 = new Client([
            "base_uri" => API::api_v3,
        ]);

        $this->apiv4 = new Client([
            "base_uri" => API::api_v4,
        ]);

        $this->apiv5 = new Client([
            "base_uri" => API::api_v5,
        ]);
    }

}