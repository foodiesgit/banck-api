@extends('layouts.app', ['activePage' => 'plaid', 'titlePage' => 'Plaid Tester'])

@section('content')
    <div class="content">

        <div class="container-fluid">

            <div class="row" id="createLinkToken">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Create Link Token</h4>
                            <p class="card-category">The /link/token/create endpoint creates a link_token, which is required
                                as a parameter when initializing Link</p>
                        </div>
                    <div class="card-body">

                <form method="post" autocomplete="off" class="form-horizontal" id="create-link-token">
                @csrf
                    <div class="row">
                        <label class="col-sm-2 col-form-label">Client Name</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="client_name" id="client-name" type="text" placeholder="Enter Client Name" value="John Doe" required="true" aria-required="true"/>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <label class="col-sm-2 col-form-label">Legal Name </label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="legal_name" id="legal_name" type="text" placeholder="Enter Legal Name" value="John Doe" required="true" aria-required="true"/>
                                </div>
                            </div>
                     </div>
                     <div class="row">
                        <div class="col-xs-12">
                            <br />
                             <span class="api-note"> NOTE: Phone number should be verified. </span>
                        </div>
                     </div>
                     <div class="row">
                            <label class="col-sm-2 col-form-label">Phone Number</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="phone_number" id="phone_number" type="text" placeholder="Enter Phone Number" value="+14155552671" required="true" aria-required="true"/>
                                </div>
                            </div>
                     </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <br />
                             <span class="api-note"> NOTE: Email address should be verified.</span>
                        </div>
                     </div>
                     <div class="row">
                        <label class="col-sm-2 col-form-label">Email Address</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="email_address" id="email_address" type="text" placeholder="Enter Email Address" value="johndoe@peachtel.net" required="true" aria-required="true"/>
                            </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-xs-12">
                            <br />
                             <span class="api-note">NOTE: Choose Auth & Transactions for this demo.</span>
                        </div>
                     </div>
                     <div class="row">
                        <label class="col-sm-2 col-form-label">Products</label>
                        <div class="col-sm-7">
                            <select class="form-control " name="products[]" placeholder="Products" multiple id="select-product">
                                <option value="transactions" selected>Transactions</option>
                                <option value="auth" selected>Auth</option>
                                <option value="identity">Identity</option>
                                <option value="assets" selected>Assets</option>
                                <option value="investments">Investments</option>
                                <option value="liabilities">Liabilities</option>
                                <option value="payment_initiation">Payment Initiation</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <label class="col-sm-2 col-form-label">Country Codes</label>
                    <div class="col-sm-7">
                        <select class="form-control " name="country_codes" placeholder="Country Codes" >
                            <option value="">Select Country Code</option>
                            <option value="US" selected>US</option>
                            <option value="CA">CA</option>
                            <option value="ES">ES</option>
                            <option value="FR">FR</option>
                            <option value="GB">GB</option>
                            <option value="IE">IE</option>
                            <option value="NL">NL</option>
                        </select>
                    </div>
                    </div>
                    <div class="row">
                    <label class="col-sm-2 col-form-label">Language</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="language" placeholder="Country Codes" >
                            <option value="">Select Language</option>
                            <option value="en" selected>English </option>
                            <option value="fr">French </option>
                            <option value="es">Spanish </option>
                            <option value="nl">Dutch </option>
                        </select>
                    </div>
                    </div>
                    <br>
                <a href="#" class="btn btn-primary" id="btn-get-link-token" role="button" aria-disabled="true">Get link tokens</a>
                <button class="btn btn-info" id="btn-create-token">Send Request </button>
                </form>

                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Get Link Token</span>
                                <br>
                                <div id="tableElement">
                                </div>
                            </div>
                            <div class="api-costumer-result">
                                <hr>
                                <span class="font-weight-bold">Customers Table</span>
                                <br>
                                <div id="tableCustomers">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overlay" id="overlay1"></div>
                <div class="loader" id="loader1"></div>

            </div> <!-- END ROW -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Create Public Token</h4>
                            <p class="card-category">Use to create public token.</p>
                        </div>
                        <div class="card-body">
                            <p>NOTE IMPORTANT - Reference for institution ID: https://plaid.com/docs/sandbox/institutions/
                            </p>
                            <form method="post" autocomplete="off" class="form-horizontal" id="create-public-token">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Institution ID</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                name="institution_id" id="institution_id" type="text"
                                                placeholder="Enter Institution ID" value="ins_3" required="true"
                                                aria-required="true" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success" id="btn-create-public-token">Send Request</button>
                            </form>

                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="public-token-result">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title ">Exchange public token for an access token</h4>
                            <p class="card-category">Exchange a Link public_token for an API access_token</p>
                        </div>
                        <div class="card-body">
                            <div id="public-token-result2">
                            </div>
                            <br>
                            <button class="btn btn-info" id="btn-exchange-public-token">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="public-token-exchange-result">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title ">Fetching Transactions Data</h4>
                            <p class="card-category"> Plaid API and fetch transaction data using the /transactions/get endpoint</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                     <div class="form-group">
                                        <label class="label-control">Start Date</label>
                                        <input type="date" class="form-control " value="" name="start_date" id="start_date"/>
                                    </div>
                                </div>
                                <div class="col-6">
                                     <div class="form-group">
                                        <label class="label-control">End Date</label>
                                        <input type="date" class="form-control " value="" name="end_date" id="end_date"/>
                                    </div>
                                </div>
                            </div>
                                <br>
                            <button class="btn btn-warning" id="btn-fetch-trans">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="fetch-trans-result">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">Fetch an Item</h4>
                            <p class="card-category"> We put API description here for information</p>
                        </div>
                        <div class="card-body">
                            <br>
                            <button class="btn btn-primary" id="btn-fetch-item">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="fetch-item-result">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Accounts Get</h4>
                        <p class="card-category"> /accounts/get</p>
                    </div>
                    <div class="card-body">
                       <p id="accounts-get-access-token"></p>
                        <br>
                        <button class="btn btn-success" id="btn-account-get">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="account-get-result">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="fbd-form">
                @csrf
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Fetching Balance Data</h4>
                        <p class="card-category">/accounts/balance/get</p>
                    </div>
                    <div class="card-body">
                    <div class="form-group">
                        <label for="fbd-account_ids">Account Ids: </label>
                        <select class="form-control " name="account_ids[]" placeholder="Account Ids" multiple id="fbd-account_ids"  style="height: 100%;>
                            <option value="" >Select Account Ids</option>
                        </select>
                        </div>
                            <br>
                            <button class="btn btn-info" id="btn-account-balance-get">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="fbd-result">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>

          <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="fbd-form">
                @csrf
                    <div class="card-header card-header-warning">
                        <h4 class="card-title ">Retrieve Identity</h4>
                        <p class="card-category">/identity/get</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-warning" id="btn-retrieve-identity">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="ig-result">
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="asset-report-form">
                @csrf
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Create Asset Report</h4>
                        <p class="card-category">/asset_report/create</p>
                    </div>
                    <div class="card-body">
                             <input type="number" class="form-control " value="" name="days_requested" id="days_requested" placeholder="Number of Days Request" required/>
                            <br>

                            <button class="btn btn-primary" id="btn-asset-report">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="asset-report-result">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>


            <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="asset-report-form">
                @csrf
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Retrieve Asset Report (JSON)</h4>
                        <p class="card-category">/asset_report/get</p>
                    </div>
                    <div class="card-body">
                            <br>
                            <button class="btn btn-success" id="btn-retrieve-report">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="retrieve-report-result">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="asset-report-form">
                @csrf
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Retrieve Asset Report (PDF)</h4>
                        <p class="card-category">asset_report/pdf/get</p>
                    </div>
                    <div class="card-body">
                            <br>
                            <button class="btn btn-info" id="btn-retrieve-pdf">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="retrieve-pdf-result">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
             <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="asset-report-form">
                @csrf
                    <div class="card-header card-header-warning">
                        <h4 class="card-title ">Remove Asset Report</h4>
                        <p class="card-category">asset_report/remove</p>
                    </div>
                    <div class="card-body">
                            <br>
                            <button class="btn btn-warning" id="btn-remove-asset">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="remove-asset-result">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-12">
                <div class="card">
                 <form method="post" autocomplete="off" class="form-horizontal" id="audit-create-form">
                @csrf
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Credit Audit</h4>
                        <p class="card-category">asset_report/audit_copy/create</p>
                    </div>
                    <div class="card-body">
                      <input type="text" class="form-control " value="" name="auditor_id" id="auditor_id" placeholder="Enter Auditor I.D" required/>
                            <br>
                            <button class="btn btn-primary" id="btn-audit-create">Send Request</button>
                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="audit-create-result">
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="investment-holdings-get">
                    @csrf
                    <div class="card-header card-header-danger">
                        <h4 class="card-title ">Securities and holdings</h4>
                        <p class="card-category">investments/holdings/get</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-danger" id="btn-investment-holdings-get">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="btn-investment-holdings-get-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="investment-transactions-get">
                    @csrf
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Transactions</h4>
                        <p class="card-category">investments/transactions/get</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-info" id="btn-investment-transactions-get">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="investment-transactions-get-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="identity-get">
                    @csrf
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Auth Details Get</h4>
                        <p class="card-category">auth/get</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-success" id="btn-auth-get">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="auth-get-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="liabilities-get">
                    @csrf
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Liabilities</h4>
                        <p class="card-category">liabilities/get</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-primary" id="btn-liabilities-get">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="liabilities-get-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="institutions-get">
                    @csrf
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Institutions</h4>
                        <p class="card-category">institutions/get</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-info" id="btn-institutions-get">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="institutions-get-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="institutions-get-by-id">
                    @csrf
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Institutions</h4>
                        <p class="card-category">institutions/get_by_id</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-success" id="btn-institutions-get-by-id">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="institutions-get-by-id-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="institutions-search">
                    @csrf
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Institutions</h4>
                        <p class="card-category">institutions/search</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-primary"  id="btn-institutions-search">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="institutions-search-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="institutions-search">
                    @csrf
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Item</h4>
                        <p class="card-category">Items/remove</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-primary"  id="btn-item-remove">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="item-remove-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="institutions-search">
                    @csrf
                    <div class="card-header card-header-success">
                        <h4 class="card-title ">Balance</h4>
                        <p class="card-category">Balance</p>
                    </div>
                    <div class="card-body">
                        <br>
                        <button class="btn btn-primary"  id="btn-item-balance">Send Request</button>
                        <div class="api-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="item-balance-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="process-create-form">
                    @csrf
                    <div class="card-header card-header-info">
                        <h4 class="card-title ">Processor Token</h4>
                        <p class="card-category">processor_token/create</p>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value="6QpQE6WKk5cBzZAl8dmnSDJavMvER7trzX4db" name="account_id" id="account_id" placeholder="Enter processor token" required/>
                        <br>
                        <button class="btn btn-default" id="btn-process-create">Send Request</button>
                        <div class="api-process-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="process-create-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="stripe-bank-create-form">
                    @csrf
                    <div class="card-header card-header-rose">
                        <h4 class="card-title ">Bank Token</h4>
                        <p class="card-category">bank_account_token/create</p>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value="6QpQE6WKk5cBzZAl8dmnSDJavMvER7trzX4db" name="account_id" id="account_id" placeholder="Enter processor token" required/>
                        <br>
                        <button class="btn btn-black" id="btn-bank-account-create">Send Request</button>
                        <div class="api-process-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="bank-account-create-result">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form method="post" autocomplete="off" class="form-horizontal" id="dwello-create-form">
                    @csrf
                    <div class="card-header card-header-rose">
                        <h4 class="card-title ">Dwello</h4>
                        <p class="card-category">Dwello/create</p>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value="ins_3" name="institution_id" id="institution_id" placeholder="Enter processor token" required/>
                        <input type="text" class="form-control" value="public-sandbox-bbe9d8e6-8d36-46be-89d0-3a2fd94d6746" name="public_key" id="public_key" placeholder="Enter public key" required/>
                        <br>
                        <button class="btn btn-black" id="btn-dwello-account-create">Send Request</button>
                        <div class="api-process-result">
                            <hr>
                            <span class="font-weight-bold">Results</span>
                            <br>
                            <div id="dwello-account-create-result">
                            </div>
                        </div>
                    </div>
                </form>
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
