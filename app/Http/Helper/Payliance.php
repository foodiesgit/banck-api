<?php
/**
 * User: SU
 */

namespace App\Http\Helper;

use Illuminate\Support\Facades\DB;

class Payliance
{
    public static $url = "";
    public static $username = "";
    public static $securityaccesskey = "";

    public static function init()
    {
//        self::$url = env("PAYLIANCE_URL");
        //        self::$username = env("PAYLIANCE_USERNAME");
        //        self::$securityaccesskey = env("PAYLIANCE_SECRET");
        self::$url = "https://staging.portal.payliance.com
";
        self::$username = "880f74f7-b0d2-4451-818b-e326089a621d";
//        self::$username = "b1ff3fce-5ffb-4ec5-b25d-889cc9d74f3b";
        //        self::$securityaccesskey = "XXXXXXXXXXXXXXXXXXQK25mclVGdngwS0Y2NEJ6Zz09";

        $accessKey = "880f74f7-b0d2-4451-818b-e326089a621d";
        self::$securityaccesskey = "S1NoZWV0czo5aUVYbXc5QzFFekNhT250VU5OREUxaHp6UWpyUlZITkE1dFpzTVo4bk5wWTBhK1NOcVgrR3RQQ1ZKUFQ4WmFldGF0Si83RXlkNEFsSFJJdmhhUjNHU2tQTGFiVnVRY1UwMDBXUE1TckUvdFlhU1FDL1pZaG8wK01ITjFzUXpOSTMxOGdYdnIrTWZzdDJlbkwwejg3ZW9ORGNJOGtmaTIvaExMc2MrM1JDKzlWeUU3VElLdGZkNzBScU44ZGlIZkNsM0VkYlB5dzkvbE54eFh2MHBMRkFKQmhtMHpJM3VlTG9oa2xMUzFDczJwa2RTQUo5MmN3Z1V0emxjWm9uSjFMSkNTOW1CWkkzdDhNWHNBTjBmUVpyUT09";

    }

    // Returns raw stirng.
    public static function GetCustomers()
    {
        // Seems all methods are post
        $item = json_encode(self::PayAuth(["Pagesize" => 200, "SortBy" => 0, "Direction" => 0, "Page" => 1]));
        return self::GetDetails($item, "/api/ReceivablesProCustomer/Customers");
    }

    /**
     * Checks to see if the customer exists
     * @param $customerID
     */
    public static function getCustomer($customerID)
    {
        $item = json_encode(self::PayAuth(["CustomerID" => $customerID]));
        return self::GetDetails($item, "/api/ReceivablesProCustomer/Customers");
    }

    public static function CheckPaymentbyId($paymentId)
    {

        $r = DB::table('payments')->where(["id" => $paymentId])->get()->first();
        if ($r->transactionidpayliance == null) {
            $result = json_decode(self::PaymentsfromSchedule($r->paymentscheduleidpayliance));
            if (isset($result->Response->Items) && count($result->Response->Items) == 1) {
                $transactionid = $result->Response->Items[0]->Id;
                //      echo "Updating Transactions $transactionid ";
                DB::table('payments')->where(['id' => $r->id])->update(['transactionidpayliance' => $transactionid]);
            }
        }
        return self::DailyPaymentItemCheck($r);

    }
    public static function DailyPaymentChecks()
    {
        $r = DB::table('payments')->whereNotNull('transactionidpayliance')->whereNotIn("status", ["succeeded", "NSF", "Settled"])->get();
        foreach ($r as $item) {
            self::DailyPaymentItemCheck($item);
        }
    }

    public static function DailyPaymentScheduleChecks()
    {
        $r = DB::table('payments')->whereNull('transactionidpayliance')->whereNotNull('paymentscheduleidpayliance')->get();
        foreach ($r as $item) {
            $checkfew = new \DateTime();
            $checkfew->add(new \DateInterval("P2D"));
            $when = new \DateTime($item->datedue);
            if ($when > $checkfew) {
                // No need to check dates in the future
                continue;
            }

            $result = json_decode(self::PaymentsfromSchedule($item->paymentscheduleidpayliance));
            // var_dump($result->Response->Items);
            // return;
            if (isset($result->Response->Items) && count($result->Response->Items) == 1) {
                //var_dump($result);
                $transactionid = $result->Response->Items[0]->Id;
                //      echo "Updating Transactions $transactionid ";
                DB::table('payments')->where(['id' => $item->id])->update(['transactionidpayliance' => $transactionid]);
                //echo "<hr/>";

            }
//{"Response":{"Page":1,"ItemsPerPage":200,"TotalItems":0,"TotalPages":0,"Items":[]},"Success":true,"Message":null}"
            // var_dump($r->Items);
        }
    }

    public static function PaymentsfromSchedule($id)
    {
        $item = json_encode(self::PayAuth(["Request" => $id]));
        return self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/RecurringPayments");
    }
    public static function ViewSinglePayment($paymentid)
    {
        $item = json_encode(self::PayAuth(["Request" => $paymentid]));
        return self::GetDetails($item, "/api/ReceivablesProPayment/Payment");

    }
    public static function ViewPayments()
    {
        $today = new \DateTime();

        $tendays = new \DateTime();
        $tendays->sub(new \DateInterval(("P10D")));

        $item = json_encode(self::PayAuth(["StartDate" => $tendays->format("Y-m-d"), $today->format("Y-m-d"),
            "Page" => 1, "Pagesize" => 200, "SortBy" => 0, "Lite" => false]));
        //$item =  json_encode(self::PayAuth([] ));

        /*
         * {"Response":{"Page":1,"ItemsPerPage":200,"TotalItems":1,"TotalPages":1,"Items":[{"Id":5084926,"AccountId":667329,"Amount":30.00,"IsDebit":false,"Cvv":null,"PaymentSubType":0,"InvoiceId":null,"InvoiceNumber":"","PurchaseOrderNumber":"","OrderId":null,"Description":"","Latitude":0.0,"Longitude":0.0,"SuccessReceiptOptions":null,"FailureReceiptOptions":null,"CustomerId":483143,"CustomerFirstName":"Scott","CustomerLastName":"Underhill","CustomerCompany":"QLC","ReferenceId":0,"Status":4,"RecurringScheduleId":0,"PaymentType":2,"ProviderAuthCode":"Approved","TraceNumber":"1c30be44-3463-4265-ae89-01aa843da3be","PaymentDate":"2018-08-17T06:00:00Z","ReturnDate":null,"EstimatedSettleDate":"2018-08-22T06:00:00Z","ActualSettleDate":null,"CanVoidUntil":"2018-08-17T21:00:00Z","FailureData":{"Code":null,"Description":null,"MerchantActionText":null,"IsDecline":false},"IsDecline":false,"CreatedOn":"2018-08-17T16:33:30Z","LastModified":"2018-08-17T16:33:30Z","RequiresReceipt":false,"PaymentToken":null}]},"Success":true,"Message":null}
         *
         */
        return self::GetDetails($item, "/api/ReceivablesProPayment/Payments");

    }

    public static function ProcessPaymentStatus()
    {
        $r = self::ViewPayments();
        $result = json_decode($r);
        foreach ($result->Response->Items as &$i) {
            // Not sure why the enum is no picking up
            $mapping = [0 => "Pending", 2 => "Failed", 4 => "Posted", 5 => "Refund", 7 => "Refunded",
                9 => "ReveersePosted", 10 => "Settled", 11 => "Voided", 15 => "ReverseNSF"];
            $i->StatusDisplay = $mapping[$i->Status];
        }
        return $result;
    }

    public static function CreateACHAccount($accountnumber, $routingnumber, $bankname, $customerid)
    {
        $item = json_encode(self::PayAuth(["Request" => ["AccountNumber" => $accountnumber, "RoutingNumber" => $routingnumber,
            "BankName" => $bankname, "IsCheckingAccount" => true, "CustomerId" => $customerid, "IsDefault" => true]]));

        //{"Response":{"AccountNumber":"***4598","RoutingNumber":"011201458","BankName":"Test Bank","IsCheckingAccount":true,"Id":667329,"CustomerId":483143,"IsDefault":true,"CreatedOn":"2018-08-17T15:32:34.6569043Z","LastModified":"2018-08-17T15:32:34.6569043Z"},"Success":true,"Message":null}

        return self::GetDetails($item, "/api/ReceivablesProAccount/CreateAchAccount");

    }

    public static function getAchAccount($accoundid)
    {
        $item = json_encode(self::PayAuth(["Request" => $accoundid]));
        return self::GetDetails($item, "/api/ReceivablesProAccount/AchAccount");

    }

    /**
     * Perform to see if the customer exist allready in our billing, even if its for another customer
     * @param $firstName
     * @param $lastName
     * @return bool false if customer potentiall exists. Needs to be checked manually
     */
    public static function hasCustomer($firstName, $lastName)
    {
        // TODO: This will work for the first 200 customers, but we need to check all
        $firstName = strtolower($firstName);
        $lastName = strtolower($lastName);
        $getAllCustomers = self::GetCustomers();
        foreach ($getAllCustomers->items as $customer) {
            if ($firstName == strtolower($customer->firstname)
                && $lastName == strtolower($customer->lastname)) {
                return true;
            }
        }
        return false;
    }
    public static function CreateCustomers($firstname, $lastname, $company, $streetaddress1, $city, $statecode, $zipcode)
    {
        // Seems all methods are post
        $item = json_encode(self::PayAuth(["Request" => ["FirstName" => $firstname, "LastName" => $lastname, "ShippingSameAsBilling" => true, "Company" => $company,
            "BillingAddress" => ["StreetAddress1" => $streetaddress1, "City" => $city, "StateCode" => $statecode, "ZipCode" => $zipcode,
            ]]]));

        /*{"Response":{"Id":483143,"CustomerAccount":null,"FirstName":"Scott","MiddleName":null,"LastName":"Underhill","BillingAddress":{"StreetAddress1":"1st street","StreetAddress2":null,"City":"austin","StateCode":56,"ZipCode":"212212","Country":0},"ShippingSameAsBilling":true,"ShippingAddress":{"StreetAddress1":"1st street","StreetAddress2":null,"City":"austin","StateCode":56,"ZipCode":"212212","Country":0},"Company":"QLC","Phone":null,"AltPhone":null,"MobilePhone":null,"Fax":null,"Email":null,"AltEmail":null,"Website":null,"Notes":null,"CreatedOn":"2018-08-17T15:18:37.4465642Z","LastModified":"2018-08-17T15:18:37.4465642Z"},"Success":true,"Message":null}
         */
        return self::GetDetails($item, "/api/ReceivablesProCustomer/CreateCustomer");
    }

    public static function PayAuth($json)
    {
        self::init();
        return array_merge($json, ["Auth" => ["Username" => self::$username, "SecretAccessKey" => self::$securityaccesskey]]);

    }

    public static function GetAccountIds()
    {
        $accountd = DB::table("funded")->whereNotNull("payliancecustomerid")->whereNull("paylianceaccountid")->get();
        foreach ($accountd as $account) {
            //self::GetCustomers()
            $item = json_encode(self::PayAuth(["Request" => $account->payliancecustomerid]));
            $accountdetails = self::GetDetails($item, "/api/ReceivablesProCustomer/DefaultAchAccount");
            $ach = json_decode($accountdetails);
            var_dump($ach);
            DB::table("funded")->where(["id" => $account->id])->update(["paylianceaccountid" => $ach->Response->Id]);
        }
    }

    public static function ReSchedule($idgroup)
    {

        // I need to do this from here, because of lot

        // First, lets see if anything is in a holida
        $itemtoschedule = DB::table("payments")->where(["paymentgroup" => $idgroup, "status" => "unpaid"])->orderBy('datedue', 'asc')->get();
        $lastdate = DB::table("payments")->where(["paymentgroup" => $idgroup])->orderBy('datedue', 'asc')->max("datedue");

        $lastdate = new \DateTime($lastdate);
        $timenow = new \DateTime();
        //  $timenow = $timenow->sub(new \DateInterval("P1D"));

        $returnstring = "";

        $validitems = DB::table("payments")->where(["paymentgroup" => $idgroup])->whereIn("status", ["succeeded", "Settled", "Posted", "unpaid"])->orderBy('datedue', 'asc')->get();
        $paymentsumvalue = DB::table("payments")->where(["paymentgroup" => $idgroup])->whereIn("status", ["succeeded", "Settled", "Posted", "unpaid"])->sum('paymentamount');

        $funded = DB::table('funded')->where(["grouping" => $idgroup])->get()->first();
        $itemstocreate = $funded->days - count($validitems);
        $amounttocreate = $funded->amountdue / $funded->days;
        $amountmissing = $funded->amountdue - $paymentsumvalue;

        foreach ($itemtoschedule as $item) {
            $checkData = new \DateTime($item->datedue);
            $holidays = DB::table('usholidays')->where(["date" => $item->datedue])->count();

            // Weekend or holiday or in the past
            if ($checkData->format('N') >= 6 || $holidays == 1 || $timenow > $checkData) {
                // This shcedule item is invalid
                // Add A date to the last date

                $lastdate->add(new \DateInterval("P1D"));
                $holidayscheck = DB::table('usholidays')->where(["date" => $lastdate->format('Y-m-d')])->count();
                //  Make sure its not a weekend
                logger("lastdate " . $lastdate->format('Y-m-d'));
                while ($lastdate->format('N') >= 6 || $holidayscheck == 1) {
                    $lastdate->add(new \DateInterval("P1D"));
                    $holidayscheck = DB::table('usholidays')->where(["date" => $lastdate->format('Y-m-d')])->count();

                    logger("lastdate loop " . $lastdate->format('Y-m-d'));
                }

                $returnstring .= "Moving " . $checkData->format("Y-m-d") . $item->paymentscheduleidpayliance;
                // TODO: I need to delete this
                if ($item->paymentscheduleidpayliance != null) {
                    // TODO: Should check the response, going to ignore
                    self::DeleteRecuring($item->paymentscheduleidpayliance);
                    DB::table('payments')->where(['id' => $item->id])->update(['paymentscheduleidpayliance' => null]);
                    // Will reschedule at the end
                }
                DB::table('payments')->where(['id' => $item->id])->update(['datedue' => $lastdate->format("Y-m-d")]);

            }
        }
        self::CreatePaymentSchedule($idgroup);

        return $returnstring . "items to create:$itemstocreate amount:$amounttocreate amountmissing:$amountmissing";
        // To Delete Payment /api/ReceivablesProPaymentSchedule/RemoveRecurringPayment
    }

    public static function DeleteRecuring($id)
    {
        // {"Response":true,"Success":true,"Message":null}
        $item = json_encode(self::PayAuth(["Request" => $id]));
        return self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/RemoveRecurringPayment");
    }

    public static function SuspendRecuring($id)
    {
        // {"Response":true,"Success":true,"Message":null}
        $item = json_encode(self::PayAuth(["Request" => $id]));
        return self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/SuspendRecurringPayment");
    }

    public static function CreatePaymentSchedule($idgroup)
    {
        $funded = DB::table("funded")->where(["grouping" => $idgroup])->get()->first();

        $itemtoschedule = DB::table("payments")->where(["paymentgroup" => $idgroup, "status" => "unpaid"])
            ->whereNull("paymentscheduleidpayliance")->orderBy('datedue', 'asc')->get();
        logger("start creating payment schedule $idgroup");

        foreach ($itemtoschedule as $index => $item) {
//            if($index > 0)
            //                break;
            logger($item->paymentamount);
            if ($item->paymentamount > 0) {
                $r = self::CreatePayments($funded->paylianceaccountid, $item->paymentamount, new \DateTime($item->datedue));
                $result = json_decode($r);
                logger($r);
                DB::table("payments")->where(["id" => $item->id])->update(["paymentscheduleidpayliance" => $result->Response->Id]);
            }
        }
    }

    public static function UpdatePaymentAmount($accountid, $scheduleid, $amount)
    {
        $r = DB::table("payments")->where(['paymentscheduleidpayliance' => $scheduleid])->get()->first();

        $enddate = new \DateTime($r->datedue);
        $enddate->modify('+2 days');

        $item = json_encode(self::PayAuth(["Request" =>
            [
                "Id" => $scheduleid,
                "AccountId" => $accountid,
                "PaymentAmount" => $amount,
                "StartDate" => $r->datedue,
                "EndDate" => $enddate->format("Y-m-d"),
                "ExecutionFrequencyType" => 9,
                "PaymentSubType" => 0,
            ],
        ]));
        return self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/UpdateRecurringPayment");
    }
    public static function CreatePayments($accountid, $amount, $date)
    {
        $enddate = new \DateTime($date->format("Y-m-d"));
        $enddate->add(new \DateInterval("P2D"));
        $item = json_encode(self::PayAuth(["Request" =>
            ["AccountId" => $accountid, "PaymentAmount" => $amount, "StartDate" => $date->format("Y-m-d"),
                "EndDate" => $enddate->format("Y-m-d"),
                "ExecutionFrequencyType" => 9,
                "PaymentSubType" => 0],
        ]));

        /*
        {"Response":{"Id":173941,"AccountId":667329,"CustomerId":"483143",
        "PaymentAmount":5.0,"CustomerFirstName":"Scott","CustomerLastName":"Underhill",
        "CustomerCompany":"QLC","PaymentSubType":0,"OrderId":null,"InvoiceNumber":null,
        "ExecutionFrequencyType":9,"ExecutionFrequencyParameter":0,"StartDate":"2018-08-25T06:00:00Z",
        "EndDate":"2018-08-27T06:00:00Z","DateOfLastPaymentMade":null,"NextScheduleDate":"2018-08-25T06:00:00Z",
        "PauseUntilDate":null,"TotalAmountPaid":0.0,"FirstPaymentAmount":0.0,"FirstPaymentDate":null,
        "FirstPaymentDone":false,"ScheduleStatus":1,"Description":null,"CreatedOn":"2018-08-20T15:59:08.1811532Z",
        "LastModified":"2018-08-20T15:59:08.1811532Z"},"Success":true,"Message":null}
         */
        return self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/CreateRecurringPayment");
    }

    public static function PaymentPlan($accountid, $totalamount, $numberofpayments, $startdate)
    {
        $item = json_encode(self::PayAuth(["Request" =>
            ["AccountId" => $accountid, "TotalDueAmount" => $totalamount, "TotalNumberOfPayments" => $numberofpayments,
                "StartDate" => $startdate, "ExecutionFrequencyType" => 1, "PaymentAmount" => $totalamount,
                "PaymentSubType" => 0,
            ]]));
/*
 * ExecutionFrequencyType: Integer-- the primary frequency on which to execute scheduled payments.
enumeration: 1 = Daily, 2 = Weekly, 3 = BiWeekley, 4 = First of Month, 5 = Specific Day of Month, 6 = Last of Month, 7 = Quarterly, 8 = Semi-Annually, 9 = Annually
 */
/*{"Response":{"Id":173882,"AccountId":667329,"CustomerId":"483143","PaymentAmount":5000.0,"CustomerFirstName":"Scott","CustomerLastName":"Underhill","CustomerCompany":"QLC","PaymentSubType":0,"OrderId":null,"InvoiceNumber":null,"ExecutionFrequencyType":1,"ExecutionFrequencyParameter":0,"StartDate":"2018-08-18T06:00:00Z","EndDate":null,"DateOfLastPaymentMade":null,"NextScheduleDate":"2018-08-18T06:00:00Z","PauseUntilDate":null,"TotalAmountPaid":0.0,"FirstPaymentAmount":0.0,"FirstPaymentDate":null,"FirstPaymentDone":false,"ScheduleStatus":1,"Description":null,"CreatedOn":"2018-08-17T15:50:30.72014Z","LastModified":"2018-08-17T15:50:30.72014Z"},"Success":true,"Message":null}
 */
        return self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/CreatePaymentPlan");

    }

    public static function GetDetails($json, $parturl)
    {
        self::init();
        $options = array('http' => array(
            'method' => "POST",
            'header' =>
            "Content-Type: application/json\r\n",
            'ignore_errors' => true,
            'content' => $json));
        //json_encode(["client_id" => self::$client_id, "secret" => self::$secret, "public_token" => $publicToken])));
        $context = stream_context_create($options);

        $tokenurl = self::$url . $parturl;

        $response = file_get_contents($tokenurl, false, $context);
        return $response;
    }

    public static function CheckRecuring()
    {
//        $item =  json_encode($s);
        //json_encode($s);
        $customers = DB::table("funded")->whereNotNull("payliancecustomerid")->where(["status" => "active"])->get();
        $missmatch = [];
        $date = (new \DateTime())->sub(new \DateInterval("P1D"));
        $enddate = (new \DateTime())->add(new \DateInterval("P300D"));
        $issues = [];

        foreach ($customers as $c) {
            $item = json_encode(self::PayAuth(
                ["CustomerId" => $c->payliancecustomerid,
                    "StartDate" => $date->format("Y-m-d"),
                    "EndDate" => $enddate->format("Y-m-d"),
                    "SortBy" => 1,
                    "Direction" => 0,
                    "Page" => 1,
                    "PageSize" => 200,
                    "Status" => 1,
                    "Lite" => "false",
                ]));

            logger($item);

//        $d = self::GetDetails($item, "/api/ReceivablesProCustomer/RecurringPaymentSchedules");
            $d = self::GetDetails($item, "/api/ReceivablesProCustomer/PaymentSchedules");

            $scheduleitems = json_decode($d);
            $check = [];

            if (isset($scheduleitems->Response)) {
                foreach ($scheduleitems->Response->Items->RecurringPayments as $item) {
                    if (isset($check[$item->CustomerId . "_" . $item->NextScheduleDate])) {
                        array_push($issues, "Dup Payment:" . $item->CustomerId . " " . $item->CustomerFirstName . " " . $item->CustomerLastName . " on:" . $item->NextScheduleDate);
                        logger("\n\n");
                        logger("Dup Payment:" . $item->CustomerId . " " . $item->CustomerFirstName . " " . $item->CustomerLastName . " on:" . $item->NextScheduleDate);
                    } else {
                        array_push($check, $item->CustomerId . "_" . $item->NextScheduleDate);
                    }

                    $count = DB::table("payments")->where(["paymentscheduleidpayliance" => $item->Id])->count();
                    if ($count == 0 && $item->DateOfLastPaymentMade == null) {
                        array_push($issues, "Unfound Payments:" . $item->Id . " - " . $item->CustomerId . " " . $item->CustomerFirstName . " " . $item->CustomerLastName . " on:" . $item->NextScheduleDate);
                        logger("\n\n");
                        logger("Unfound Payments:" . $item->Id . " - " . $item->CustomerId . " " . $item->CustomerFirstName . " " . $item->CustomerLastName . " on:" . $item->NextScheduleDate);
                    }
                }
            }
            //return $d;

//            logger($item);
            //            logger("\n\n\n");
            //            logger($d);

        }
        file_put_contents(storage_path("issuecheck.txt"), json_encode($issues));

        return "";
    }

    public static function CheckRecuring2()
    {
        $s = [];
        $s["Page"] = "2";
        $s["Username"] = "APIUser124297";
        $s["SecretAccessKey"] = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

        $item = json_encode($s);

        logger($item);

        $d = self::GetDetails($item, "/api/ReceivablesProPaymentSchedule/AllPaymentSchedules");
        return $d;

    }
    /**
     * @param $item
     */
    protected static function DailyPaymentItemCheck($paymentRow)
    {
        $item = $paymentRow;
        $result = self::ViewSinglePayment($item->transactionidpayliance);
        $singlepayment = json_decode($result);
        $mapping = [0 => "Pending", 2 => "Failed", 4 => "Posted", 5 => "Refund", 6 => 'Invalid Account', 7 => "Refunded",
            8 => "NSF", 9 => "ReveersePosted", 10 => "Settled", 11 => "Voided", 15 => "ReverseNSF"];
        logger($result);
        if (isset($singlepayment->Response->Status)) {
            $status = $mapping[$singlepayment->Response->Status];
            DB::table("payments")->where(["id" => $item->id])->update(["status" => $status]);
        } else {
            DB::table("payments")->where(["id" => $item->id])->update(["manual" => 1]);
            // Some error, to ignore
        }
        return $result;
    }
}
