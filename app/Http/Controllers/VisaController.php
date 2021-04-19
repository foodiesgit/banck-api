<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\APIClient\VisaApiClient;
use Illuminate\Support\Str;
use App\Models\Consumers;
use App\Models\ConsumersAddresses;
use App\Models\Identification;
use App\Models\KYC;
use App\Models\CountryCodes;
use App\Models\USStates;
use App\Models\UploadedDocuments;

class VisaController extends Controller
{
  /** Show Visa API Test Page
   * Template: views/api-tester/bbva/show.blade.php
   *
   * @return View
   */


  public function show()
  {




      $vdpTest                    = $this->vdpTest();
      $cashOutPushPayments        = $this->cashOutPushPayments();
      $adjustment                 = $this->adjustment();
      $manageReportGenerate       = $this->manageReportGenerate();
      $visaAliasDirectory         = $this->getVisaAliasDirectory();
      $cardValidation             = $this->cardValidation();



      return View::make('api-tester.visa.show', [
          'vdpTest'                => $vdpTest,
          'cashOutPushPayments'    => $cashOutPushPayments,
          'adjustment'             => $adjustment,
          'manageReportGenerate'   => $manageReportGenerate,
          'visaAliasDirectory'     => $visaAliasDirectory,
          'cardValidation'         => $cardValidation

      ]);
  }

    public function registerCallBack() {

        $visa = new VisaApiClient;
        $endPoint = '/vti/v1/registerCallback';
        $json_data =  cardRegisterCallback();
        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        if($res){
            return 1;
        }else{
            return 0;
        }

    }



  /**
   * Obtain Test APi
   *
   * @return string $endPoint
   */
  public function vdpTest()
  {

    $visa = new VisaApiClient;
    $endPoint = '/vdp/helloworld';
    $res = $visa->api($endPoint , 'Get');
    return  $res;

  }
    /**
     * Obtain cashOutPushPayments APi
     *
     * @return string $endPoint
     */
    public function cashOutPushPayments() {
        $visa = new VisaApiClient;
        $endPoint = '/visadirect/mvisa/v1/cashinpushpayments';
        $json_data =  pushPaymentsJson(); // get push payments Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);
        return  $res;
    }

    public function adjustment() {
        $visa = new VisaApiClient;
        $endPoint = '/visadirect/v1/adjustment';
        $json_data =  adjustmentJson(); // get push adjustment Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);
        return  $res;
    }
    public function manageReportGenerate() {
        $visa = new VisaApiClient;
        $endPoint = '/visaaliasdirectory/v1/managereport/generate';
        $json_data =  manageReportGenerate(); // get push for report generate Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);
        return  $res;
    }

    public function getVisaAliasDirectory() {
        $visa = new VisaApiClient;
        $endPoint = '/visaaliasdirectory/v1/resolve';
        $json_data =  visaAliasDirectory(); // get visa alias directory Json
        $res = $visa->api($endPoint,'Post' ,[],$json_data);
        return  $res;
    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function cardValidation()
    {

        $visa = new VisaApiClient;
        $endPoint = '/pav/v1/cardvalidation';
        $json_data = cardValidationDirectory(); // get visa alias directory Json
        $res = $visa->api($endPoint,'Post' ,[],$json_data);
        return  $res;

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function updateTravelNotification() {

        $visa = new VisaApiClient;
        $endPoint = '/travelnotificationservice/v1/travelnotification/itinerary';
        $json_data =  cardTravelnotificationJson();
        $res = $visa->api($endPoint,'Put' ,[],$json_data);
        if(!empty($res)){
            return json_encode($res);
        }else{
            return 0;
        }

    }
    /**
     * Obtain Test APi
     *
     * @return string $endPoint
     */
    public function multiPushFundsTransactions()
    {

        $visa = new VisaApiClient;
        $endPoint = '/visadirect/fundstransfer/v1/multipushfundstransactions';
        $json_data = multiPushFundsTransactionsJson(); // get visa alias directory Json
        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        if(isset($res->responseStatus->code) && ($res->responseStatus->code == 200)){

            return json_encode($res);
        }

        return  null;

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function totalsInquiry()
    {

        $visa = new VisaApiClient;
        $endPoint = '/globalatmlocator/v1/localatms/totalsinquiry';
        $json_data = totalsInquiryJson(); // get visa alias directory Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        return json_encode($res);

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function routeInquiry()
    {

        $visa = new VisaApiClient;
        $endPoint = '/globalatmlocator/v1/localatms/routesinquiry';
        $json_data = routeInquiryJson(); // get visa alias directory Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        return json_encode($res);

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function atmInquiry()
    {

        $visa = new VisaApiClient;
        $endPoint = '/globalatmlocator/v1/localatms/atmsinquiry';
        $json_data = atmInquiryJson(); // get visa alias directory Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        return json_encode($res);

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function createAlias()
    {

        $visa = new VisaApiClient;
        $endPoint = '/visaaliasdirectory/v1/manage/createalias';
        $json_data = createAlies(); // get visa alias directory Json

        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        return json_encode($res);

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function geoCodesInquiry()
    {

        $visa = new VisaApiClient;
        $endPoint = '/globalatmlocator/v1/localatms/geocodesinquiry';
        $json_data = inQuiryTransctionJson(); // get visa inQuiryTransctionJson

        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        return json_encode($res);

    }

    /**
     * Obtain Test APi
     *
     * @return string $card Validations
     */
    public function cvv2generation()
    {

        $visa = new VisaApiClient;
        $endPoint = '/dcas/cardservices/v1/cards/377164428581556/cvv2generation';
        $json_data = cvv2generationJson(); // get visa cvv2generationJson

        $res = $visa->api($endPoint,'Post' ,[],$json_data);

        return json_encode($res);

    }

}
