@extends('layouts.app', ['activePage' => 'visa-api', 'titlePage' => __('VISA')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            {{-- Consumer API --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">VPD Test</h4>
                            <p class="card-category">VPD Test API is the first API you will need to call to start using our
                                services. The VPD Test API is the use only for Acknowledge Purpose your Visa Api is the successfully integrated .</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                                <th>Date & Time</th>
                                                <th>Message</th>
                                            </thead>
                                            <tbody>
                                                @if(!empty($vdpTest))
                                                    <tr>
                                                        <td>{{ @$vdpTest->timestamp}}</td>
                                                        <td>{{ @$vdpTest->message}}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            No records found.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title font-weight-bold">Cash Out Push Payments</h4>
                            <p class="card-category">Cash Out Push Payments API is the API will be need send some payment attribute
                               through the text box fields and after the successfully transactions will be return records.</p>

                            <small><p>For Get Response Use This Json Accordingly {!! json_encode(pushPaymentsJson()) !!}</p></small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>TransactionIdentifier</th>
                                            <th>Action Code</th>
                                            <th>Approval Code</th>
                                            <th>Response Code</th>
                                            <th>Transmission DateTime</th>
                                            <th>Retrieval Reference Number</th>
                                            <th>Card Acceptor</th>
                                            </thead>
                                            <tbody>
                                            @if(!empty($cashOutPushPayments))
                                                <tr>
                                                    <td>{{ @$cashOutPushPayments->transactionIdentifier}}</td>
                                                    <td>{{ @$cashOutPushPayments->actionCode}}</td>
                                                    <td>{{ @$cashOutPushPayments->approvalCode}}</td>
                                                    <td>{{ @$cashOutPushPayments->responseCode}}</td>
                                                    <td>{{ @$cashOutPushPayments->transmissionDateTime}}</td>
                                                    <td>{{ @$cashOutPushPayments->retrievalReferenceNumber}}</td>
                                                    <td>{{ json_encode(@$cashOutPushPayments->cardAcceptor)}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-rose">
                            <h4 class="card-title font-weight-bold">Adjustment</h4>
                            <p class="card-category">Adjust API is the API will be need send some attribute
                                through the text box fields while integrate this Api and  the will response successfully after the adjustment.</p>

                            <small>For Get Response Use This Json Accordingly {!! json_encode(adjustmentJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>TransactionIdentifier</th>
                                            <th>Action Code</th>
                                            <th>Date $ Time Transmission</th>
                                            <th>Settlement Flags</th>
                                            </thead>
                                            <tbody>
                                            @if(!empty($adjustment))
                                                <tr>
                                                    <td>{{ @$adjustment->transactionIdentifier}}</td>
                                                    <td>{{ @$adjustment->actionCode}}</td>
                                                    <td>{{ @$adjustment->dateAndTimeTransmission}}</td>
                                                    <td>{{ json_encode(@$adjustment->settlementFlags)}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title font-weight-bold">Adjustment</h4>
                            <p class="card-category">Adjust API is the API will be need send some attribute
                                through the text box fields while integrate this Api and  the will response successfully after the adjustment.</p>

                            <small>For Get Response Use This Json Accordingly {!! json_encode(adjustmentJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>TransactionIdentifier</th>
                                            <th>Action Code</th>
                                            <th>Date $ Time Transmission</th>
                                            <th>Settlement Flags</th>
                                            </thead>
                                            <tbody>
                                            @if(!empty($adjustment))
                                                <tr>
                                                    <td>{{ @$adjustment->transactionIdentifier}}</td>
                                                    <td>{{ @$adjustment->actionCode}}</td>
                                                    <td>{{ @$adjustment->dateAndTimeTransmission}}</td>
                                                    <td>{{ json_encode(@$adjustment->settlementFlags)}}</td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title font-weight-bold">Manage Report</h4>
                            <p class="card-category">Manage Report API is the API will be need return a report url accordingly send attribute into the input field.</p>

                            <small>For Get Response Use This Json Accordingly {!! json_encode(manageReportGenerate()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>Manage Report Url</th>
                                            </thead>
                                            <tbody>
                                            @if(!empty($manageReportGenerate))
                                                <tr>
                                                    <td><a class="btn btn-primary btn-block" target="_blank" href="{{ @$manageReportGenerate->reportLocation}}">{{ @$manageReportGenerate->reportLocation}}</a></td>

                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">Visa Alias Directory</h4>
                            <p class="card-category">Visa Alias Directory API is the API will be return a recipient primary Account Number with details.</p>

                            <small>For Get Response Use This Json Accordingly {!! json_encode(visaAliasDirectory()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>Recipient Primary Account Number</th>
                                            <th>Recipient Name</th>
                                            <th>Issuer Name</th>
                                            <th>Card Type</th>
                                            <th>Address 1</th>
                                            <th>Address 2</th>
                                            <th>city</th>
                                            <th>Country</th>
                                            <th>Postal Code</th>
                                            </thead>
                                            <tbody>
                                            @if(!empty($visaAliasDirectory))
                                                <tr>
                                                    <td>{{ @$visaAliasDirectory->recipientPrimaryAccountNumber }}</td>
                                                    <td>{{ @$visaAliasDirectory->recipientName }}</td>
                                                    <td>{{ @$visaAliasDirectory->issuerName }}</td>
                                                    <td>{{ @$visaAliasDirectory->cardType }}</td>
                                                    <td>{{ @$visaAliasDirectory->address1 }}</td>
                                                    <td>{{ @$visaAliasDirectory->address2 }}</td>
                                                    <td>{{ @$visaAliasDirectory->city }}</td>
                                                    <td>{{ @$visaAliasDirectory->country }}</td>
                                                    <td>{{ @$visaAliasDirectory->postalCode }}</td>

                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title font-weight-bold">Transaction Identifier</h4>
                            <p class="card-category">Transaction Identifier API is the API will be return a transaction identifier action code.</p>

                            <small>For Get Response Use This Json Accordingly {!! json_encode(cardValidationDirectory()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>Transaction Identifier</th>
                                            <th>Action Code</th>
                                            <th>Response Code</th>
                                            <th>Address Verification Results</th>
                                            <th>Cvv2 Result Code</th>

                                            </thead>
                                            <tbody>
                                            @if(!empty($cardValidation))
                                                <tr>
                                                    <td>{{ @$cardValidation->transactionIdentifier }}</td>
                                                    <td>{{ @$cardValidation->actionCode }}</td>
                                                    <td>{{ @$cardValidation->responseCode }}</td>
                                                    <td>{{ @$cardValidation->addressVerificationResults }}</td>
                                                    <td>{{ @$cardValidation->cvv2ResultCode }}</td>

                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        No records found.
                                                    </td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-danger">
                            <h4 class="card-title font-weight-bold">Update Travel notification</h4>
                            <p class="card-category">Update Travel notification API is that will be updated of travel notification service.</p>

                            <small>For Get Response Use This Json Accordingly {!! json_encode(cardTravelnotificationJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="consumers-table-container">
                                        <a class="btn btn-warning update-travel-notification" id="btn-remove-asset">Update Travel notification<div class="ripple-container"></div></a>
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>Response Code</th>
                                            <th>Response Message</th>
                                            </thead>
                                            <tbody id="update-travel-notification">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title font-weight-bold">Register Call</h4>


                            <small>For Get Response Use This Json Accordingly {!! json_encode(cardRegisterCallback()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-warning register-button" id="btn-remove-asset">Get Register Call and got response<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>Response Code</th>
                                            </thead>
                                            <tbody id="register-call">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title font-weight-bold">Muti Alies</h4>


                            <small>For Get Response Use This Json Accordingly {!! json_encode(createAlies()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-success create-alies" id="btn-remove-asset">Create Aliese<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                            <th>Response Code</th>
                                            </thead>
                                            <tbody id="create-alies">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title font-weight-bold">Total Json Inquiry Transactions</h4>


                            <small>For Get Response Use This Json Accordingly {!! json_encode(totalsInquiryJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-success total-inquiry" id="btn-remove-asset">Get Multi Push Fund response<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <div class="panel-body table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-warning">
                                                <th>Distance Unit</th>
                                                <th>Total ATM Count</th>
                                                <th>Best Map View</th>
                                                <th>Properties</th>
                                                <th>Meta Data</th>
                                                <th>Matched Locations</th>
                                                <th>Found ATM Locations</th>
                                                <th>WS Response Header</th>
                                                <th>WS Status</th>
                                                <th>WS Response Header V2</th>
                                                <th>Response Summary Data</th>
                                                </thead>
                                                <tbody id="total-inquiry">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">Route Inquiry Transactions</h4>

                            <small>For Get Response Use This Route Accordingly {!! json_encode(routeInquiryJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-success route-inquiry" id="btn-remove-asset">Get Multi Push Fund response<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <div class="panel-body table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-warning">
                                                <th>Response Data</th>
                                                <th>Ws ResponseHeader</th>
                                                <th>Ws ResponseHeaderV2</th>
                                                <th>Response Summary Data</th>
                                                </thead>
                                                <tbody id="route-inquiry">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title font-weight-bold">Atm Inquiry Transactions</h4>

                            <small>For Get Response Use This Route Accordingly {!! json_encode(atmInquiryJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-success atm-inquiry" id="btn-remove-asset">Get Atm Inquiry response<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <div class="panel-body table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-warning">
                                                <th>Response Data</th>
                                                <th>Ws ResponseHeader</th>
                                                <th>Ws ResponseHeaderV2</th>
                                                <th>Response Summary Data</th>
                                                </thead>
                                                <tbody id="atm-inquiry">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">Geo Code Inquiry Transactions</h4>

                            <small>For Get Response Use This Route Accordingly  {!! json_encode(inQuiryTransctionJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-success inquiry-transaction" id="btn-remove-asset">Get Multi Push Fund response<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <div class="panel-body table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-warning">
                                                <th>Response Data</th>
                                                <th>Ws ResponseHeader</th>
                                                <th>Ws ResponseHeaderV2</th>
                                                <th>Response Summary Data</th>
                                                </thead>
                                                <tbody id="inquiry-transaction">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">cvv2 Generation</h4>

                            <small>For Get Response Use This Route Accordingly  {!! json_encode(cvv2generationJson()) !!}</small>

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <a class="btn btn-success cvv2generationJson" id="btn-remove-asset">cvv2 Generation<div class="ripple-container"></div></a>
                                    <div class="consumers-table-container">
                                        <div class="panel-body table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="text-warning">
                                                <th>Response Data</th>
                                                </thead>
                                                <tbody id="cvv-generation">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="modal fade" tabindex="-1" role="dialog" id="spinnerModal">
        <div class="modal-dialog modal-dialog-centered text-center" role="document">
            <span class="fa fa-spinner fa-spin fa-3x w-100"></span>
        </div>
    </div>
    <div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <h5><strong>Your API Query is successful.</strong></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modal-dismiss">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        ul.nav-pills .nav-link,
        .nav-link:hover {
            color: #3C4858 !important;
        }

        .nav-link.nav-link-info.active {
            color: #ffffff !important;
            background-color: #15BACF !important;
        }

        .nav-link.nav-link-success.active {
            color: #ffffff !important;
            background-color: #4AA64E !important;
        }

        .nav-link.nav-link-warning.active {
            color: #ffffff !important;
            background-color: #FC9208 !important;
        }

        .nav-link.nav-link-primary.active {
            color: #ffffff !important;
            background-color: #942CAE !important;
        }

        .w-40 {
            width: 40%;
        }

        .badge {
            width: 75px;
        }

        .custom-table-sm td {
            padding: 0 0.5rem!important;
        }

        .applyBtn {
            background-color: #2196f3 !important;
            border-color: #2196f3 !important;
        }

        select {
            appearance: menulist !important;
        }

        @media (min-width: 768px) {
            .modal-xl {
                width: 90%;
                max-width: 1200px;
            }
        }

    </style>
@endpush

@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        function showNotification(type, message) {
            $.notify(
                {
                    icon: "add_alert",
                    message: message
                },
                {
                    type: type,
                    timer: 3000,
                    placement: {
                        from: "top",
                        align: "center"
                    }
                }
            );
        }
        $('.update-travel-notification').click(function(){
            $("#update-travel-notification").html('Loading...');
            $("#spinnerModal").modal("show");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/update-travel-notification")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data != null) {
                        var result = jQuery.parseJSON(data);
                        optionsHtml += '<td>'+result.updateTravelItineraryResponse.responseCode+'</td>';
                        optionsHtml += '<td>'+result.updateTravelItineraryResponse.responseMessage+'</td>';
                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#update-travel-notification").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });
        $('.register-button').click(function(){
            $("#spinnerModal").modal("show");
            $("#register-call").html('Loading...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/register-call-back")}}',
                data: '',
                type: 'post',
                success: function(result)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (result) {
                        optionsHtml += '<td>Register Call back trigger successfully</td>';

                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#register-call").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });

        $('.total-inquiry').click(function(){
            $("#total-inquiry").html('Loading...');
            $("#spinnerModal").modal("show");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/total-inquiry")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data) {
                        var result = jQuery.parseJSON(data);
                        $.each(result.responseData, function (key, val) {
                            optionsHtml += '<td>' + val.distanceUnit + '</td>';
                            optionsHtml += '<td>' + val.totalATMCount + '</td>';
                            optionsHtml += '<td>' + JSON.stringify(val.bestMapView) + '</td>';
                            optionsHtml += '<td>' + JSON.stringify(val.properties) + '</td>';
                            optionsHtml += '<td>' + val.metaData + '</td>';
                            optionsHtml += '<td>' + JSON.stringify(val.matchedLocations) + '</td>';
                            optionsHtml += '<td>' + val.foundATMLocations + '</td>';
                            optionsHtml += '<td>' + result.wsResponseHeader + '</td>';
                            optionsHtml += '<td>' + JSON.stringify(result.wsStatus) + '</td>';
                            optionsHtml += '<td>' + JSON.stringify(result.wsResponseHeaderV2) + '</td>';
                            optionsHtml += '<td>' + result.responseSummaryData + '</td>';
                        });
                    }else{
                        optionsHtml += '<td>Opps! something issued on your call</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#total-inquiry").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });

        $('.route-inquiry').click(function(){
            $("#route-inquiry").html('Loading...');
            $("#spinnerModal").modal("show");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/route-inquiry")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data) {
                        var result = jQuery.parseJSON(data);
                        //  console.log(result)
                        optionsHtml += '<td>'+JSON.stringify(result.responseData)+'</td>';
                        optionsHtml += '<td>'+result.wsResponseHeader+'</td>';
                        optionsHtml += '<td>'+JSON.stringify(result.wsStatus)+'</td>';
                        optionsHtml += '<td>'+JSON.stringify(result.wsResponseHeaderV2)+'</td>';
                        optionsHtml += '<td>'+result.responseSummaryData+'</td>';
                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#route-inquiry").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });

        $('.atm-inquiry').click(function(){
            $("#spinnerModal").modal("show");
            $("#atm-inquiry").html('Loading...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/atm-inquiry")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data) {

                        var result = jQuery.parseJSON(data);
                        //  console.log(result)
                        optionsHtml += '<td>'+JSON.stringify(result.responseData)+'</td>';
                        optionsHtml += '<td>'+result.wsResponseHeader+'</td>';
                        optionsHtml += '<td>'+JSON.stringify(result.wsStatus)+'</td>';
                        optionsHtml += '<td>'+JSON.stringify(result.wsResponseHeaderV2)+'</td>';
                        optionsHtml += '<td>'+result.responseSummaryData+'</td>';
                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#atm-inquiry").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });

        $('.create-alies').click(function(){
            $("#spinnerModal").modal("show");
            $("#create-alies").html('Loading...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/create-alias")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data) {

                        var result = jQuery.parseJSON(data);
                        //  console.log(result)
                        optionsHtml += '<td>'+JSON.stringify(result)+'</td>';
                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#create-alies").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });

        $('.inquiry-transaction').click(function(){
            $("#spinnerModal").modal("show");
            $("#create-alies").html('Loading...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/geo-codes-inquiry")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data) {
                        var result = jQuery.parseJSON(data);
                        //  console.log(result)
                        optionsHtml += '<td>'+JSON.stringify(result.responseData)+'</td>';
                        optionsHtml += '<td>'+result.wsResponseHeader+'</td>';
                        optionsHtml += '<td>'+JSON.stringify(result.wsStatus)+'</td>';
                        optionsHtml += '<td>'+JSON.stringify(result.wsResponseHeaderV2)+'</td>';
                        optionsHtml += '<td>'+result.responseSummaryData+'</td>';
                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#inquiry-transaction").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });

        $('.cvv2generationJson').click(function(){
            $("#spinnerModal").modal("show");
            $("#cvv-generation").html('Loading...');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax
            ({
                url: '{{url("/api-tester/generate-visa-ccvv")}}',
                data: '',
                type: 'post',
                success: function(data)
                {
                    $("#spinnerModal").modal("hide");
                    var optionsHtml = '';
                    optionsHtml += '<tr>';
                    if (data) {
                        var result = jQuery.parseJSON(data);
                        //  console.log(result)
                        optionsHtml += '<td>'+JSON.stringify(result)+'</td>';

                    }else{
                        optionsHtml += '<td>Not Found</td>';
                    }
                    optionsHtml += '</tr>';
                    showNotification("success", "Query completed successfully.");
                    $("#cvv-generation").html(optionsHtml);
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log("ERROR:" + xhr.responseText + " - " + thrownError);
                }
            });
        });
    </script>
@endpush
