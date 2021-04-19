<?php
/**
 * User: SU
 */

namespace App\Http\Helper;

use App\Http\Helper\Enums\Payliancepaymentstatus;
use App\rawpayliancetransactions;
use DocuSign\eSign\Model\View;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Paylianceaccrcc
{
    public static $privateSecret = "";
    public static $url = "";
​
​
    public static function init()
    {
        self::$privateSecret = "XXXXXsa3dGam9WY1hHWEl6cDkydGdCbkFCRGXxTmRPMjZlcXpNZ1laeWhndHYxbEpuMjZOYzZUb0Y4eU1taFVDaWxMUUJtSHJKYWJXOHEveFpGQk9NdWw2QVRPOHVUR3cxVWE2L2VzRnE1SGlJaUZvZjh4SmZQUT09";
        self::$url = "https://staging.api.payliance.com";
    }
​
​
​
    public static function debitAccount($routingNumber, $accountNumber, $debitAmount
    , $lastName, $firstName , $accountType = "Business Checking"){
        self::init();
        // First name is currently not in use
        if($accountType != "Business Checking")
            throw new \Exception("Business Checking, only supported");
​
​
        $internalTransactionId = uniqid();
        // Note: First name is actually optional, but I have included it
        $query = ["Routing" => $routingNumber,
            "UniqueTranId" => $internalTransactionId,
            "AccountNumber" => $accountNumber,
            "CheckAmount" => $debitAmount,
            "SecCode" => "CCD",
            "AccountType" => $accountType,
            "LastName" => $lastName,
            "FirstName" => $firstName,
            "WebType" => "R" // TODO: This is either S := Signle or R:= Recuring. Assuming R to be part of the larger payment sequence
​
        ];
​
        $validator = Validator::make($query ,[
                "Routing" => 'required|digits:9',
                "UniqueTranId" => 'required|max:50',
                "AccountNumber"=> 'required|digits_between:2,17',
                "CheckAmount" => 'required|numeric',
                "LastName" => 'required',
            "FirstName" => 'required',
            "WebType" => 'required',
​
        ]);
​
        // Do not perform this action
        if ($validator->fails())
            throw new \Exception($validator->errors()->first());
​
        $rawTransaction = new rawpayliancetransactions();
        $rawTransaction->internaluuid = $internalTransactionId;
        $rawTransaction->requeststring = json_encode($query);
        $rawTransaction->responsestring = "";
        $rawTransaction->save();
​
        $client = new Client(['base_uri' => self::$url ]);
        $endpoint = "api/v1/echeck/debit";
        // This is for global tracking
        $response = $client->request("POST", $endpoint, ["json" =>
                $query,
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$privateSecret,
                ]]
        );
        $rawTransaction->responsestring = $response->getBody()->getContents();
        $rawTransaction->save();
        $object = json_decode($rawTransaction->responsestring);
        $rawTransaction->paylianceuuid = $object->AuthorizationId;
        $rawTransaction->save();
        // We use this id for tracking
        return $internalTransactionId;
    }
​
​
    public static function querySettlements(){
        self::init();
​
        $post = [];
        $post["Start"] = (new \DateTime())->sub(new \DateInterval("P5D")) ->format("Y-m-d");
​
        $post["End"] = (new \DateTime())->format("Y-m-d");
​
​
        $client = new Client(['base_uri' => self::$url ]);
        $endpoint = "/api/v1/echeck/querysettlements";
        $response = $client->request("POST", $endpoint, ["json" =>
            $post,
          'headers' => [
            'Authorization' => 'Bearer ' . self::$privateSecret,
        ]]
        );
        return $response->getBody()->getContents();
    }
​
    public static function getStatus($insternalId){
        $raw = rawpayliancetransactions::where("internaluuid", $insternalId)->first();
        $jsonResult = json_decode(self::queryTransaction($insternalId, $raw->paylianceuuid));
        return $jsonResult->Transaction->Status;
    }
​
    public static function queryTransaction($internalId, $authrizationId){
        self::init();
        $query = [
            "UniqueTranId" => $internalId,
            "AuthorizationId" => $authrizationId
        ];
​
                $client = new Client(['base_uri' => self::$url ]);
        $endpoint = "api/v1/echeck/retrieve";
        // This is for global tracking
        $response = $client->request("POST", $endpoint, ["json" =>
                $query,
                'headers' => [
                    'Authorization' => 'Bearer ' . self::$privateSecret,
                ]]
        );
        return $response->getBody()->getContents();
​
    }
}