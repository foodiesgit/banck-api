<?php

namespace App\APIClient;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class VisaApiClient
{
    /**
     * General host URL
     */
    protected $hostURL = '';

    /**
     * Host URL for OAuth
     */
    protected $hostURLOAuth = 'https://sandbox.api.visa.com';

    /**
     * Base64-Encoded String
     * Compose of <App Name>:<Secret Key>
     */
    protected $user_id = 'FN88KPTEG0OOXU7A703G21HX8VTFzp9lGBCaxPXIAetVxt-1g';
    protected $password = 'rMBgBFjtfqXV8DKzomt4tPU13fUqCcZ3Ee';


    /**
     * OAuth - Obtain Access Token
     * Get access token and save it on session
     *
     * @return string - the access token
     */
    public static function apiResponse($client ,$type, $endPoint, $headers ,$cert ,$ssl_key , $content = []) {


        try {

            if(!empty($content)){
                $response = $client->request($type,
                    $endPoint, [
                        'json'            => $content,
                        'headers'         => $headers,
                        'connect_timeout' => 650,
                        'cert'            => $cert,
                        'ssl_key'         => $ssl_key
                    ]);

            }else{
                $response = $client->request($type,
                    $endPoint, [
                        'headers'         => $headers,
                        'connect_timeout' => 650,
                        'cert'            => $cert,
                        'ssl_key'         => $ssl_key
                    ]);
            }

            $body = json_decode($response->getBody()->getContents());
            return $body;

        } catch (\Exception   $e) {

            return  $e->getMessage();
        }

    }
    public function api($endPoint , $method , $param_query = [] ,$param_json = [] ) {

        $credentials = base64_encode($this->user_id . ':' . $this->password);
        $cert        = env('Visa_Ssl_cert_path');
        $ssl_key     = env('Visa_Ssl_key_path');
        $param       = [];

        try {

            $client = new Client([
                'base_uri' => $this->hostURLOAuth,
            ]);

            $headers = [
                'Accept'        => 'application/json',
                'Authorization' => 'Basic ' . $credentials
            ];

            if(!empty($param_query)) {
                foreach ($param_query as $key => $value) {
                    $param[ 'query' ][ $key ] = $value;  //set param_query
                }
            }

            if(!empty($param_json)) {
                foreach ($param_json as $key => $value) {
                    $param[ 'json' ][ $key ] = $value;  //set param_json
                }
            }

            if(!empty($param[ 'json' ]) && !empty($param[ 'query' ])) {
                $param = [$param[ 'query' ], $param[ 'json' ]];
            } else if(!empty($param[ 'json' ]) && empty($param[ 'query' ])) {
                $param = $param[ 'json' ];
            } else if(!empty($param[ 'query' ]) && empty($param[ 'json' ])) {
                $param = $param[ 'query' ];
            }

            $response = self::apiResponse($client, $method, $endPoint, $headers, $cert, $ssl_key, $param);

            return $response;
        } catch (RequestException  $e) {
            if ($e->hasResponse()){
                return  $e->getResponse()->getStatusCode();
            }

        } catch (\Exception $e) {
            return $e->getTraceAsString();
        }

    }


}
