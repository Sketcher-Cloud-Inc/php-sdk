<?php

namespace Sketcher\SDK;

use GuzzleHttp\Client;
use \GuzzleHttp\Exception\RequestException;

class Main {

    private $BASE_URI;
    private $USE_HTTPS;
    private $AppToken;

    public function __construct() {
        $this->BASE_URI     = null;
        $this->USE_HTTPS    = null;
        $this->AppToken     = null;
    }

    /**
     * Define application base uri
     *
     * @param  string $BASE_URI
     * @return void
     */
    public function SetBaseUri(string $BASE_URI): void {
        $BASE_URI                   = trim($BASE_URI, "/");
        [$USE_HTTPS, $BASE_URI]     = \explode("://", $BASE_URI);
        $this->BASE_URI             = "{$USE_HTTPS}://{$BASE_URI}/";
        $this->USE_HTTPS            = ($USE_HTTPS == "https"? true: false);
        return;
    }
        
    /**
     * Define application token
     *
     * @param  string $token
     * @return void
     */
    public function SetToken(string $token): void {
        $this->AppToken = $token;
        return;
    }
    
    /**
     * Make a request
     *
     * @param  string $method
     * @param  string $URI
     * @param  array $Parameters
     * @return void
     */
    public function Request(string $method, string $URI, array $Parameters = []) {
        if (!empty($this->BASE_URI)) {
            $URI            = trim($URI, "/");
            $BodyContent    = [
                "token" => $this->AppToken,
                "main"  => $Parameters
            ];
            $ObjectResponse = $this->MakingHttp($method, $URI, $BodyContent);
            if (!empty($ObjectResponse) && $ObjectResponse->type == "SUCCESS") {
                return $ObjectResponse->response;
            } else {
                throw new \Sketcher\SDK\Exception (
                    (!empty($ObjectResponse->type)? $ObjectResponse->type: "Unknown error, please check your local configuration and retry. if the message persists check the servers status."),
                    $ObjectResponse
                );
                return;
            }
        }
    }
    
    /**
     * Run the http request
     *
     * @param  string $method
     * @param  string $HttpUrl
     * @param  array $BodyContent
     * @return void
     */
    private function MakingHttp(string $method,string $HttpUri, array $BodyContent): ?object {
        try {
            $HttpRequest    = new Client([
                "base_uri"  => $this->BASE_URI,
                "headers"   => [
                    "Content-Type" => "application/json"
                ]
            ]);
            $HttpResponse   = $HttpRequest->request($method, "/{$HttpUri}", [
                "body" => json_encode($BodyContent)
            ]);
            $HttpResponse   = $HttpResponse->getBody()->getContents();
        } catch (RequestException $e) {
            $HttpResponse = $e->getResponse()->getBody()->getContents();
        }
        $HttpResponse = (!empty($HttpResponse)? json_decode($HttpResponse, false): null);
        return $HttpResponse;
    }

}

?>