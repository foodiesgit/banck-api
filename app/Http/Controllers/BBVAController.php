<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\APIClient\BBVAClient;
use Illuminate\Support\Str;
use App\Models\Consumers;
use App\Models\ConsumersAddresses;
use App\Models\Identification;
use App\Models\KYC;
use App\Models\CountryCodes;
use App\Models\USStates;
use App\Models\UploadedDocuments;

class BBVAController extends Controller
{
  /** Show BBVA API Test Page
   * Template: views/api-tester/bbva/show.blade.php
   * 
   * @return View
   */
  public function show()
  {
    $accessToken = $this->obtainAccessToken();

    $consumers = Consumers::all();

    $countries = CountryCodes::all();

    $states = USStates::all();

    return View::make('api-tester.bbva.show', [
      'accessToken' => $accessToken,
      'consumers' => $consumers,
      'countries' => $countries,
      'states' => $states
    ]);
  }

  /**
   * Obtain Access Token
   * 
   * @return string $accessToken
   */
  public function obtainAccessToken()
  {
    $bbva = new BBVAClient;
    $accessToken = $bbva->obtainAccessToken();

    if ($accessToken) {
      // Save Access Token to Session
      session()->put('bbvaAccessToken', $accessToken);

      return $accessToken;
    }

    return false;
  }

  /**
   * Invalidate Access Token
   * Data in Session
   * 
   * @return boolean - true: successful invalidation, false: failed invalidation
   */
  public function invalidateAccessToken()
  {
    // Get token from Session
    $accessToken = session()->get('bbvaAccessToken');

    $bbva = new BBVAClient;
    $invalidateAccessToken = $bbva->invalidateAccessToken($accessToken);

    if ($invalidateAccessToken) {
      // Remove Access Token to Session
      session()->forget('bbvaAccessToken');
      return true;
    }

    return false;
  }

  /**
   * Create consumer record
   * Data saved in MySQL
   * 
   * @param Request $request
   * @return array
   */
  public function createConsumer(Request $request)
  {
    // Validate inputs
    $inputs = $request->validate([
      'first_name' => 'required',
      'middle_name' => 'nullable',
      'last_name' => 'required',
      'dob' => 'required|date_format:"Y-m-d"',
      'ssn' => 'required',
      'phone' => 'required',
      'email' => 'required',
      'citizenship_status' => 'required',
      'citizenship_country' => 'required',
      'address_type' => 'required',
      'address_line1' => 'required',
      'address_line2' => 'nullable',
      'address_city' => 'required',
      'address_state' => 'required',
      'address_zipcode' => 'required',
      'occupation' => 'required',
      'source_of_income' => 'required|array',
      'expected_activity' => 'required|array',
      'id_type' => 'required',
      'id_number' => 'required',
      'id_state' => 'nullable',
      'id_country' => 'required',
      'id_issuing_date' => 'required|date_format:"Y-m-d"',
      'id_expiration_date' => 'required|date_format:"Y-m-d"',
      'pep' => 'required|in:no,yes',
      'ip_address' => 'required',
    ]);

    // Get access token
    $accessToken = session()->get('bbvaAccessToken');

    if ($accessToken) {
      // Generate request body strings
      $middle_name = $inputs['middle_name'] == null ? '' : '"middle_name": "' . $inputs['middle_name'] . '",';
      $address_line2 = $inputs['address_line2'] == null ? '' : '"line2": "' . $inputs['address_line2'] . '",';
      $id_state = $inputs['id_state'] == null ? '' : '"issuing_state": "' . $inputs['id_state'] . '",';
      $ip = $inputs['ip_address'];
      $source_of_income = implode('","', $inputs['source_of_income']);
      $expected_activity = implode('","', $inputs['expected_activity']);
      $transactionID = (string) Str::uuid();

      $body = '{
        "first_name": "' . $inputs['first_name'] . '",
        ' . $middle_name . '
        "last_name": "' . $inputs['last_name'] . '",
        "ssn": "' . $inputs['ssn'] . '",
        "dob": "' . $inputs['dob'] . '",
        "contact": [
          {
            "type": "phone",
            "value": "' . $inputs['phone'] . '"
          },
          {
            "type": "email",
            "value": "' . $inputs['email'] . '"
          }
        ],
        "citizenship_status": "' . $inputs['citizenship_status'] . '",
        "citizenship_country": "' . $inputs['citizenship_country'] . '",
        "occupation": "' . $inputs['occupation'] . '",
        "income": [
          "' . $source_of_income . '"
        ],
        "expected_activity": [
          "' . $expected_activity . '"
        ],
        "address": [
          {
            "type": "' . $inputs['address_type'] . '",
            "line1": "' . $inputs['address_line1'] . '",
            ' . $address_line2 . '
            "city": "' . $inputs['address_city'] . '",
            "state": "' . $inputs['address_state'] . '",
            "zip_code": "' . $inputs['address_zipcode'] . '"
          }
        ],
        "identification": [
            {
                "document": "' . $inputs['id_type'] . '",
                "number": "' . $inputs['id_number'] . '",
                ' . $id_state . '
                "issuing_country": "' . $inputs['id_country'] . '",
                "issued_date": "' . $inputs['id_issuing_date'] . '",
                "expiration_date": "' . $inputs['id_expiration_date'] . '"
            }
        ],
        "pep": {
          "association": "' . $inputs['pep'] . '"
        }
      }';

      // Call Consumer API
      $bbva = new BBVAClient;
      $createConsumer = $bbva->createConsumer($accessToken, $ip, $transactionID, $body);

      if ($createConsumer) {
        // Save consumer to database
        $consumer = new Consumers;
        $consumer->first_name = htmlspecialchars(strip_tags($inputs['first_name']));
        $consumer->middle_name = htmlspecialchars(strip_tags($inputs['middle_name']));
        $consumer->last_name = htmlspecialchars(strip_tags($inputs['last_name']));
        $consumer->dob = htmlspecialchars(strip_tags($inputs['dob']));
        $consumer->ssn = htmlspecialchars(strip_tags($inputs['ssn']));
        $consumer->phone = htmlspecialchars(strip_tags($inputs['phone']));
        $consumer->email = htmlspecialchars(strip_tags($inputs['email']));
        $consumer->citizenship_status = htmlspecialchars(strip_tags($inputs['citizenship_status']));
        $consumer->citizenship_country = htmlspecialchars(strip_tags($inputs['citizenship_country']));
        $consumer->occupation = htmlspecialchars(strip_tags($inputs['occupation']));
        $consumer->source_of_income = htmlspecialchars(strip_tags(implode(",", $inputs['source_of_income'])));
        $consumer->expected_activity = htmlspecialchars(strip_tags(implode(",", $inputs['expected_activity'])));
        $consumer->pep = $inputs['pep'] == "no" ? 0 : 1;
        $consumer->ip_address = htmlspecialchars(strip_tags($inputs['ip_address']));
        $consumer->user_id = $createConsumer->user_id;
        $consumer->contact_phone_id = $createConsumer->contact_id[0];
        $consumer->contact_email_id = $createConsumer->contact_id[1];
        $consumer->kyc_status = $createConsumer->kyc->status;
        $consumer->idv_required = isset($createConsumer->kyc->idv_required) ? implode(",", $createConsumer->kyc->idv_required) : null;
        $consumer->save();

        // Save addresses
        // !! Implement loop in the future
        $addresses = new ConsumersAddresses;
        $addresses->consumer_id = $consumer->id;
        $addresses->address_id = $createConsumer->address_id;
        $addresses->address_line1 = htmlspecialchars(strip_tags($inputs['address_line1']));
        $addresses->address_line2 = htmlspecialchars(strip_tags($inputs['address_line2']));
        $addresses->address_city = htmlspecialchars(strip_tags($inputs['address_city']));
        $addresses->address_state = htmlspecialchars(strip_tags($inputs['address_state']));
        $addresses->address_zipcode = htmlspecialchars(strip_tags($inputs['address_zipcode']));
        $addresses->address_type = htmlspecialchars(strip_tags($inputs['address_type']));
        $addresses->save();

        // Save Identification Documents
        // !! Implement loop in the future
        $id_documents = new Identification;
        $id_documents->consumer_id = $consumer->id;
        $id_documents->id_type = htmlspecialchars(strip_tags($inputs['id_type']));
        $id_documents->id_number = htmlspecialchars(strip_tags($inputs['id_number']));
        $id_documents->id_state = htmlspecialchars(strip_tags($inputs['id_state']));
        $id_documents->id_country = htmlspecialchars(strip_tags($inputs['id_country']));
        $id_documents->id_issuing_date = htmlspecialchars(strip_tags($inputs['id_issuing_date']));
        $id_documents->id_expiration_date = htmlspecialchars(strip_tags($inputs['id_expiration_date']));
        $id_documents->save();

        // Save KYC Notes
        if ($createConsumer->kyc_notes) {
          foreach ($createConsumer->kyc_notes as $kyc_note) {
            if (isset($kyc_note->code) && isset($kyc_note->detail)) {
              $kyc = new KYC;
              $kyc->consumer_id = $consumer->id;
              $kyc->code = $kyc_note->code;
              $kyc->details = $kyc_note->detail;
              $kyc->active = 1;
              $kyc->save();
            }
          }
        }

        return ["success" => true, "message" => "Successfully created consumer!"];
      }

      return ["success" => false, "message" => "Failed to create consumer", "details" => $createConsumer];
    } else {
      return ["success" => false, "message" => "Unauthorized Request"];
    }
  }

  /**
   * Reload consumer records
   * 
   * @return View
   */
  public function reloadConsumers()
  {
    $consumers = Consumers::all();

    $countries = CountryCodes::all();

    $states = USStates::all();

    return View::make('api-tester.bbva.reload_consumer', [
      'consumers' => $consumers,
      'countries' => $countries,
      'states' => $states,
    ]);
  }

  /**
   * View consumer records
   * 
   * @param integer $id
   * 
   * @return View
   */
  public function viewConsumerDetails($id)
  {
    $consumer = Consumers::find($id);
    $addresses = ConsumersAddresses::where('consumer_id', $id)->get();
    $identification = Identification::where('consumer_id', $id)->get();
    $kyc = KYC::where('consumer_id', $id)->where('active', 1)->get();

    return View::make('api-tester.bbva.consumer_details', [
      'consumer' => $consumer,
      'addresses' => $addresses,
      'identification' => $identification,
      'kyc' => $kyc
    ]);
  }

  /**
   * Review KYC Status of a consumer
   * 
   * @param integer $id
   * 
   * @return View
   */
  public function reviewKYC($id)
  {
    // Get consumer record
    $consumer = Consumers::find($id);

    // Get access token
    $accessToken = session()->get('bbvaAccessToken');

    if ($accessToken) {
      $transactionID = (string) Str::uuid();
      $bbva = new BBVAClient;
      $reviewKYC = $bbva->reviewKYC($accessToken, $consumer->user_id, $transactionID);

      if ($reviewKYC) {
        // Update KYC Status if changed
        if ($consumer->kyc_status != $reviewKYC->kyc->status) {
          $consumer->kyc_status = $reviewKYC->kyc->status;
          $consumer->save();
        }

        // Replace all KYC Notes
        KYC::where('consumer_id', $id)->update(['active' => 0]);
        if ($reviewKYC->kyc_notes) {
          foreach ($reviewKYC->kyc_notes as $kyc_note) {
            if (isset($kyc_note->code) && isset($kyc_note->detail)) {
              $kyc = new KYC;
              $kyc->consumer_id = $consumer->id;
              $kyc->code = $kyc_note->code;
              $kyc->details = $kyc_note->detail;
              $kyc->active = 1;
              $kyc->save();
            }
          }
        }

        return View::make('api-tester.bbva.review_kyc', ['success' => true, 'response' => $reviewKYC]);
      }

      return View::make('api-tester.bbva.review_kyc', ['success' => false, 'error' => "Failed to get KYC status", "response" => $reviewKYC]);
    } else {
      return View::make('api-tester.bbva.review_kyc', ['success' => false, 'error' => "Unauthorized request"]);
    }
  }

  /**
   * Show update consumer records form
   * 
   * @param integer $id
   * 
   * @return View
   */
  public function updateConsumer($id)
  {
    $consumer = Consumers::find($id);
    $addresses = ConsumersAddresses::where('consumer_id', $id)->first();
    $identification = Identification::where('consumer_id', $id)->first();
    $countries = CountryCodes::all();
    $states = USStates::all();

    return View::make('api-tester.bbva.update_consumer', [
      'consumer' => $consumer,
      'address' => $addresses,
      'source_of_income' => explode(",", $consumer->source_of_income),
      'expected_activity' => explode(",", $consumer->expected_activity),
      'identification' => $identification,
      'countries' => $countries,
      'states' => $states,
    ]);
  }

  /**
   * Submit Update consumer record
   * Data saved in MySQL
   * 
   * @param Request $request
   * 
   * @return array
   */
  public function submitUpdateConsumer(Request $request)
  {
    // Validate inputs
    $inputs = $request->validate([
      'consumer_id' => 'required|numeric',
      'first_name' => 'required',
      'middle_name' => 'nullable',
      'last_name' => 'required',
      'dob' => 'required|date_format:"Y-m-d"',
      'ssn' => 'required',
      'phone' => 'required',
      'email' => 'required',
      'address_type' => 'required',
      'address_line1' => 'required',
      'address_line2' => 'nullable',
      'address_city' => 'required',
      'address_state' => 'required',
      'address_zipcode' => 'required',
      'id_type' => 'required',
      'id_number' => 'required',
      'id_state' => 'nullable',
      'id_country' => 'required',
      'id_issuing_date' => 'required|date_format:"Y-m-d"',
      'id_expiration_date' => 'required|date_format:"Y-m-d"',
    ]);

    // Get access token
    $accessToken = session()->get('bbvaAccessToken');

    if ($accessToken) {
      $originalData = Consumers::find($inputs['consumer_id']);
      $originalIDData = Identification::where('consumer_id', $inputs['consumer_id'])->first();
      $originalAddressData = ConsumersAddresses::where('consumer_id', $inputs['consumer_id'])->first();
      $ip = $originalData->ip_address;
      $transactionID = (string) Str::uuid();
      $first_name = '';
      $middle_name = '';
      $last_name = '';
      $ssn = '';
      $dob = '';
      $identification = '';
      $updateConsumer = '';
      $updateConsumerPhone = '';
      $updateConsumerEmail = '';
      $updateConsumerAddress = '';
      $error = 0;
      $error_message = [];

      // Check for changes on original data and generate request body string - Consumer Data
      if ($originalData->first_name != $inputs['first_name']) {
        $first_name = '"first_name": "' . $inputs['first_name'] . '"';
      }

      if ($originalData->middle_name != $inputs['middle_name']) {
        $comma = $middle_name != '' ? ',' : '';
        $middle_name = $comma . '"middle_name": "' . $inputs['middle_name'] . '"';
      }

      if ($originalData->last_name != $inputs['last_name']) {
        $comma = $first_name != '' || $middle_name != '' ? ',' : '';
        $last_name = $comma . '"last_name": "' . $inputs['last_name'] . '"';
      }

      if ($originalData->ssn != $inputs['ssn']) {
        $comma = $first_name != '' || $middle_name != '' || $last_name != '' ? ',' : '';
        $ssn = $comma . '"ssn": "' . $inputs['ssn'] . '"';
      }

      if ($originalData->dob != $inputs['dob']) {
        $comma = $first_name != '' || $middle_name != '' || $last_name != '' || $ssn != '' ? ',' : '';
        $dob = $comma . '"dob": "' . $inputs['dob'] . '"';
      }

      if (($originalIDData->id_type != $inputs['id_type']) || ($originalIDData->id_number != $inputs['id_number']) || ($originalIDData->id_state != $inputs['id_state']) || ($originalIDData->id_country != $inputs['id_country']) || ($originalIDData->id_issuing_date != $inputs['id_issuing_date']) || ($originalIDData->id_expiration_date != $inputs['id_expiration_date'])) {
        $comma = $first_name != '' || $middle_name != '' || $last_name != '' || $ssn != '' || $dob != '' ? ',' : '';
        $id_state = $inputs['id_state'] == null ? '' : '"issuing_state": "' . $inputs['id_state'] . '",';
        $identification = $comma . '"identification": [
            {
                "document": "' . $inputs['id_type'] . '",
                "number": "' . $inputs['id_number'] . '",
                ' . $id_state . '
                "issuing_country": "' . $inputs['id_country'] . '",
                "issued_date": "' . $inputs['id_issuing_date'] . '",
                "expiration_date": "' . $inputs['id_expiration_date'] . '"
            }
        ]';
      }

      if ($first_name != '' || $middle_name != '' || $last_name != '' || $ssn != '' || $dob != '' || $identification != '') {
        $consumer_body = '{
          ' . $first_name . '
          ' . $middle_name . '
          ' . $last_name . '
          ' . $ssn . '
          ' . $dob . '
          ' . $identification . '
        }';

        // Call Consumer API
        $bbva = new BBVAClient;
        $updateConsumer = $bbva->updateConsumer($accessToken, "consumer", $originalData->user_id, null, $ip, $transactionID, $consumer_body);
      }

      // Check for changes on original data and generate request body string - Phone Data
      if ($originalData->phone != $inputs['phone']) {
        $contact_body = '{
            "contact":
            {
              "value": "' . $inputs['phone'] . '"
            }
        }';
        // Call Consumer API
        $bbva = new BBVAClient;
        $updateConsumerPhone = $bbva->updateConsumer($accessToken, "contact", $originalData->user_id, $originalData->contact_phone_id, $ip, $transactionID, $contact_body);
      }

      // Check for changes on original data and generate request body string - Email Data
      if ($originalData->email != $inputs['email']) {
        $contact_body = '{
          "contact": 
            {
              "value": "' . $inputs['email'] . '"
            }
        }';
        // Call Consumer API
        $bbva = new BBVAClient;
        $updateConsumerEmail = $bbva->updateConsumer($accessToken, "contact", $originalData->user_id, $originalData->contact_email_id, $ip, $transactionID, $contact_body);
      }

      // Check for changes on original data and generate request body string - Address Data
      if (($originalAddressData->address_type != $inputs['address_type']) || ($originalAddressData->address_line1 != $inputs['address_line1']) || ($originalAddressData->address_line2 != $inputs['address_line2']) || ($originalAddressData->address_city != $inputs['address_city']) || ($originalAddressData->address_state != $inputs['address_state']) || ($originalAddressData->address_zipcode != $inputs['address_zipcode'])) {
        $address_line2 = $inputs['address_line2'] == null ? '' : '"line2": "' . $inputs['address_line2'] . '",';
        $address_body = '{
          "address":
            {
              "type": "' . $inputs['address_type'] . '",
              "line1": "' . $inputs['address_line1'] . '",
              ' . $address_line2 . '
              "city": "' . $inputs['address_city'] . '",
              "state": "' . $inputs['address_state'] . '",
              "zip_code": "' . $inputs['address_zipcode'] . '"
            }
        }';
        // Call Consumer API
        $bbva = new BBVAClient;
        $updateConsumerAddress = $bbva->updateConsumer($accessToken, "address", $originalData->user_id, $originalAddressData->address_id, $ip, $transactionID, $address_body);
      }

      // Update database records
      if ($updateConsumer === true) {
        $consumer = Consumers::find($inputs['consumer_id']);
        $consumer->first_name = htmlspecialchars(strip_tags($inputs['first_name']));
        $consumer->middle_name = htmlspecialchars(strip_tags($inputs['middle_name']));
        $consumer->last_name = htmlspecialchars(strip_tags($inputs['last_name']));
        $consumer->dob = htmlspecialchars(strip_tags($inputs['dob']));
        $consumer->ssn = htmlspecialchars(strip_tags($inputs['ssn']));
        $consumer->save();

        // Save Identification Documents
        // !! Implement loop in the future
        $id_documents = Identification::where('consumer_id', $inputs['consumer_id'])->first();
        $id_documents->id_type = htmlspecialchars(strip_tags($inputs['id_type']));
        $id_documents->id_number = htmlspecialchars(strip_tags($inputs['id_number']));
        $id_documents->id_state = htmlspecialchars(strip_tags($inputs['id_state']));
        $id_documents->id_country = htmlspecialchars(strip_tags($inputs['id_country']));
        $id_documents->id_issuing_date = htmlspecialchars(strip_tags($inputs['id_issuing_date']));
        $id_documents->id_expiration_date = htmlspecialchars(strip_tags($inputs['id_expiration_date']));
        $id_documents->save();
      } elseif ($updateConsumer === false) {
        $error++;
        $error_message[] = "Updating consumer data failed";
      }

      if ($updateConsumerPhone === true) {
        $consumer = Consumers::find($inputs['consumer_id']);
        $consumer->phone = htmlspecialchars(strip_tags($inputs['phone']));
        $consumer->save();
      } elseif ($updateConsumerPhone === false) {
        $error++;
        $error_message[] = "Updating phone data failed";
      }

      if ($updateConsumerEmail === true) {
        $consumer = Consumers::find($inputs['consumer_id']);
        $consumer->email = htmlspecialchars(strip_tags($inputs['email']));
        $consumer->save();
      } elseif ($updateConsumerPhone === false) {
        $error++;
        $error_message[] = "Updating email data failed";
      }

      if ($updateConsumerAddress === true) {
        // !! Implement loop in the future
        $addresses = ConsumersAddresses::where('consumer_id', $inputs['consumer_id'])->first();
        $addresses->address_line1 = htmlspecialchars(strip_tags($inputs['address_line1']));
        $addresses->address_line2 = htmlspecialchars(strip_tags($inputs['address_line2']));
        $addresses->address_city = htmlspecialchars(strip_tags($inputs['address_city']));
        $addresses->address_state = htmlspecialchars(strip_tags($inputs['address_state']));
        $addresses->address_zipcode = htmlspecialchars(strip_tags($inputs['address_zipcode']));
        $addresses->address_type = htmlspecialchars(strip_tags($inputs['address_type']));
        $addresses->save();
      } elseif ($updateConsumerPhone === false) {
        $error++;
        $error_message[] = "Updating address data failed";
      }

      if ($error == 0) {
        return ["success" => true, "message" => "Successfully updated consumer!"];
      } else {
        return ["success" => false, "message" => $error_message, "details" => $updateConsumer];
      }
    } else {
      return ["success" => false, "message" => ["Unauthorized Request"]];
    }
  }

  /**
   * Show upload consumer document form
   * 
   * @param integer $consumerID
   * 
   * @return View
   */
  public function uploadConsumerDocs($consumerID)
  {
    $consumer = Consumers::find($consumerID);
    return View::make('api-tester.bbva.upload_consumer_docs', [
      'consumer_id' => $consumer->id,
      'verify_idv' => explode(",", $consumer->idv_required)
    ]);
  }

  /**
   * Submit upload consumer document form
   * 
   * @param Request $request
   * 
   * @return array
   */
  public function submitUploadConsumerDocs(Request $request)
  {
    $inputs = $request->validate([
      'consumer_id' => 'required|numeric',
      'doc_type' => 'required',
      'verify_idv' => 'required|array',
      'file' => 'required|mimes:pdf,jpg,png,jpeg'
    ]);

    // Get access token
    $accessToken = session()->get('bbvaAccessToken');

    if ($accessToken) {
      $consumer = Consumers::find($inputs['consumer_id']);
      $ip = $consumer->ip_address;
      $transactionID = (string) Str::uuid();

      $base64File = base64_encode(file_get_contents($inputs['file']));
      $mimeType = $inputs['file']->getMimeType();
      if ($mimeType == "image/jpg" || $mimeType == "image/jpeg") {
        $fileType = "application/jpeg";
      } elseif ($mimeType == "image/png") {
        $fileType = "application/png";
      } else {
        $fileType = $mimeType;
      }

      // Generate request body string
      $body = '{
        "file": "' . $base64File . '",
        "file_type": "' . $fileType . '",
        "doc_type": "' . $inputs['doc_type'] . '",
        "verify_idv": [
          "' . implode('","', $inputs['verify_idv']) . '"
        ]
      }
      ';

      $bbva = new BBVAClient;
      $uploadDocument = $bbva->uploadDocument($accessToken, $ip, $transactionID, $consumer->user_id, $body);

      if ($uploadDocument) {
        $transactionID = (string) Str::uuid();
        $body = '{
          "verify_idv": [
            "' . implode('","', $inputs['verify_idv']) . '"
          ]
        }';
        $updateKYC = $bbva->updateKYC($accessToken, $ip, $transactionID, $consumer->user_id, $body, $uploadDocument->id);

        if ($updateKYC) {
          
          // Save file to storage
          $fileName = md5($inputs['file']->getClientOriginalName() . time()) . "." . $inputs['file']->getClientOriginalExtension();
          $destinationPath = public_path('/storage/bbva/docs/');
          $inputs['file']->move($destinationPath, $fileName);

          $document = new UploadedDocuments;
          $document->account_type = "consumer";
          $document->account_id = $consumer->id;
          $document->file_type = $fileType;
          $document->doc_type = $inputs['doc_type'];
          $document->verify_idv =  implode(',', $inputs['verify_idv']);
          $document->doc_uuid = $uploadDocument->id;
          $document->file_path = $destinationPath;
          $document->file_name = $fileName;
          $document->save();

          return ["success" => true, "message" => "Successfully uploaded document!"];
        }
        
        return ['success' => false, "message" => "Sucessfully uploaded documents! Failed to update KYC status", "details" => $updateKYC];
        
      }

      return ['success' => false, "message" => "Failed to upload document", "details" => $uploadDocument];
    } else {
      return ["success" => false, "message" => "Unauthorized Request"];
    }
  }
}
