<?php

namespace App\APIClient;

use GuzzleHttp\Client;

class BBVAClient
{
    /**
     * General host URL
     */
    protected $hostURL = 'https://sandbox-apis.bbvaopenplatform.com';

    /**
     * Host URL for OAuth
     */
    protected $hostURLOAuth = 'https://sbx-paas.bbvacompass.com';

    /**
     * Base64-Encoded String
     * Compose of <App Name>:<Secret Key>
     */
    protected $base64String = 'YXBwLm9wZW4ucHRlbC50ZXN0OkJpQzZhKnRxcSN5WWVybGFubyRtaHF6MU9ASnRhRjBTMFBva0hVdklWMEhCeEFhWEg0NUpsNGl6N1dDUFQkaFo=';

    /**
     * OAuth - Obtain Access Token
     * Get access token and save it on session
     * 
     * @return string - the access token
     */
    public function obtainAccessToken()
    {
        $endPoint = '/auth/token?grant_type=client_credentials';

        $client = new Client([
            'base_uri' => $this->hostURLOAuth,
        ]);

        $response = $client->request('POST',  $endPoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . $this->base64String
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return false;
        }

        $body = json_decode($response->getBody()->getContents());

        return $body->access_token;
    }

    /**
     * OAuth - Invalidate Access Token
     * Invalidates the current access token on session
     * 
     * @param string $accessToken
     * 
     * @return boolean
     */
    public function invalidateAccessToken($accessToken)
    {
        $endPoint = '/auth/management/logout';

        $client = new Client([
            'base_uri' => $this->hostURLOAuth,
        ]);

        $response = $client->request('POST',  $endPoint, [
            'headers' => [
                'Authorization' => 'jwt ' . $accessToken
            ]
        ]);

        return $response->getStatusCode() == 204 ? true : false;
    }

    /**
     * Consumer API - Create Consumer
     * Create consumer records
     * 
     * @param string $accessToken
     * @param string $ip - The IP address of the customer being verified
     * @param string $transactionID - The unique transaction ID for this API request
     * @param string $body - The request body JSON string
     * 
     * @return JSON - The response body
     */
    public function createConsumer($accessToken, $ip, $transactionID, $body)
    {
        $endPoint = '/consumer/v3.0';

        $client = new Client([
            'base_uri' => $this->hostURL,
        ]);

        $response = $client->request('POST',  $endPoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'jwt ' . $accessToken,
                'X-Customer-IP' => $ip,
                'X-Unique-Transaction-ID' => $transactionID
            ],
            'body' => $body
        ]);

        if ($response->getStatusCode() != 201) {
            return false;
        }

        $body = json_decode($response->getBody()->getContents());

        return $body;
    }

    /**
     * Consumer API - Review KYC
     * Retrieve KYC Status of a consumer
     * 
     * @param string $accessToken
     * @param string $user_id - the UUID obtained from consumer record
     * @param string $transactionID - The unique transaction ID for this API request
     * 
     * @return JSON - The response body
     */
    public function reviewKYC($accessToken, $user_id, $transactionID)
    {
        $endPoint = '/consumer/v3.0/identity';

        $client = new Client([
            'base_uri' => $this->hostURL,
        ]);

        $response = $client->request('GET',  $endPoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'jwt ' . $accessToken,
                'OP-User-Id' => $user_id,
                'X-Unique-Transaction-ID' => $transactionID
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return false;
        }

        $body = json_decode($response->getBody()->getContents());

        return $body;
    }

    /**
     * Consumer API - Update Consumer
     * Update consumer record
     * 
     * @param string $accessToken
     * @param string $type - consumer|address|contact
     * @param string $user_id - CO-UUID
     * @param string $uuid - address or contact UUID
     * @param string $ip
     * @param string $transactionID
     * @param string $body
     * 
     * @return boolean
     */
    public function updateConsumer($accessToken, $type, $user_id, $uuid, $ip, $transactionID, $body)
    {
        if ($type == "consumer") {
            $endPoint = '/consumer/v3.0';
        } elseif ($type == "address") {
            $endPoint = '/consumer/v3.0/address/' . $uuid;
        } elseif ($type == "contact") {
            $endPoint = '/consumer/v3.0/contact/' . $uuid;
        } else {
            return abort(403);
        }
        
        $client = new Client([
            'base_uri' => $this->hostURL,
        ]);

        $response = $client->request('PATCH',  $endPoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'jwt ' . $accessToken,
                'OP-User-Id' => $user_id,
                'X-Customer-IP' => $ip,
                'X-Unique-Transaction-ID' => $transactionID
            ],
            'body' => $body
        ]);

        if ($response->getStatusCode() != 204) {
            return false;
        }

        return true;
    }

    /**
     * Consumer API - Upload Document
     * Upload consumer documer to verify identify
     * 
     * @param string $accessToken
     * @param string $ip
     * @param string $transactionID
     * @param string $user_id - CO-UUID
     * @param string $body
     * 
     * @return JSON
     */
    public function uploadDocument($accessToken, $ip, $transactionID, $user_id, $body)
    {
        $endPoint = '/consumer/v3.1/identity/document';

        $client = new Client([
            'base_uri' => $this->hostURL,
        ]);

        $response = $client->request('POST',  $endPoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'jwt ' . $accessToken,
                'OP-User-Id' => $user_id,
                'X-Customer-IP' => $ip,
                'X-Unique-Transaction-ID' => $transactionID
            ],
            'body' => $body
        ]);

        if ($response->getStatusCode() != 201) {
            return false;
        }

        $body = json_decode($response->getBody()->getContents());

        return $body;
    }

    /**
     * Update KYC Status
     * 
     * @param string $accessToken
     * @param string $ip
     * @param string $transactionID
     * @param string $user_id - CO-UUID
     * @param string $body
     * @param string $documentID - document UUID
     * 
     * @return JSON
     */
    public function updateKYC($accessToken, $ip, $transactionID, $user_id, $body, $documentID)
    {
        $endPoint = '/consumer/v3.1/identity/document/' . $documentID;

        $client = new Client([
            'base_uri' => $this->hostURL,
        ]);

        $response = $client->request('PATCH',  $endPoint, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'jwt ' . $accessToken,
                'OP-User-Id' => $user_id,
                'X-Customer-IP' => $ip,
                'X-Unique-Transaction-ID' => $transactionID
            ],
            'body' => $body
        ]);

        if ($response->getStatusCode() != 204) {
            return false;
        }

        return true;
    }
}
