@extends('layouts.app', ['activePage' => 'api-wyre', 'titlePage' => __('API Wyre')])



@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title ">Submit Auth Token</h4>
                            <p class="card-category">Use to initialize a client-generated bearer token.</p>
                        </div>
                        <div class="card-body">
                            <p>NOTE IMPORTANT - Reference for secret Key: https://docs.sendwyre.com/docs/initialize-auth-token
                            </p>
                            <form method="post" autocomplete="off" class="form-horizontal" id="submit-auth-token">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Secret Key</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="secretKey" id="secretKey" type="text"
                                                   placeholder="Enter Secret Key" value="" required="true"
                                                   aria-required="true" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-info" id="btn-submit-auth-token">Submit Auth Token</button>
                            </form>

                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="submit-auth-token-result">
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
                            <h4 class="card-title ">Get Account</h4>
                            <p class="card-category">Use to retrieve all profile data for an account along with verification status.</p>
                        </div>
                        <div class="card-body">
                            <p>NOTE IMPORTANT - Reference for secret Key: https://docs.sendwyre.com/docs/initialize-auth-token
                            </p>
                            <form method="post" autocomplete="off" class="form-horizontal" id="wyre-account-get">
                                @csrf
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Secret Key</label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="secretKey" id="secretKey" type="text"
                                                   placeholder="Enter Secret Key" value="" required="true"
                                                   aria-required="true" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-sm-2 col-form-label">Account Id </label>
                                    <div class="col-sm-7">
                                        <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   name="accountId" id="accountId" type="text"
                                                   placeholder="Enter account Id" value="" required="true"
                                                   aria-required="true" />
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <button class="btn btn-success" id="btn-wyre-account-get">Get Account</button>
                            </form>

                            <div class="api-result">
                                <hr>
                                <span class="font-weight-bold">Results</span>
                                <br>
                                <div id="wyre-account-get-result">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
