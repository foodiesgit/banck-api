@extends('layouts.app', ['activePage' => 'payliance', 'titlePage' => 'Payliance Tester'])

@section('content')
    <div class="content">

        <div class="container-fluid">

            <div class="row" id="createLinkToken">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title ">CreateCustomers</h4>
                        </div>
                    <div class="card-body">

                <form method="post" autocomplete="off" class="form-horizontal" id="pl-frm-customer">
                @csrf
                    <div class="row">
                        <label class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                            <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="first_name" id="first-name" type="text" placeholder="Enter First Name" value="John" required="true" aria-required="true"/>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <label class="col-sm-2 col-form-label">Last Name </label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="last_name" id="last-name" type="text" placeholder="Enter Last Name" value="Doe" required="true" aria-required="true"/>
                                </div>
                            </div>
                     </div>
                     <div class="row">
                            <label class="col-sm-2 col-form-label">Company</label>
                            <div class="col-sm-7">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="company" id="company" type="text" placeholder="Enter Company" value="QLC" required="true" aria-required="true"/>
                                </div>
                            </div>
                     </div>

                     <div class="row">
                        <label class="col-sm-2 col-form-label">Street Address 1 </label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="street_address1" id="street_address1" type="text" placeholder="Enter Street Address 1" value="1st street" required="true" aria-required="true"/>
                            </div>
                        </div>
                     </div>

                     <div class="row">
                        <label class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="city" id="city" type="text" placeholder="Enter City" value="austin" required="true" aria-required="true"/>
                            </div>
                        </div>
                     </div>
                     <div class="row">
                        <label class="col-sm-2 col-form-label">State Code</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="state_code" id="state_code" type="text" placeholder="Enter State Code" value="56" required="true" aria-required="true"/>
                            </div>
                        </div>
                     </div>
                     <div class="row">
                        <label class="col-sm-2 col-form-label">Zip Code</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="zip_code" id="zip_code" type="text" placeholder="Enter Zipcode" value="212212" required="true" aria-required="true"/>
                            </div>
                        </div>
                     </div>
                    <br>
                <button class="btn btn-info" id="pl-create-customer">Send Request </button>
                </form>

                <div class="overlay" id="overlay1"></div>
                <div class="loader" id="loader1"></div>

            </div> <!-- END ROW -->

             <div class="row" id="createLinkToken">

                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-success">
                            <h4 class="card-title ">Pay Auth</h4>
                        </div>
                    <div class="card-body">
                          <button class="btn btn-info" id="pl-pay-auth">Send Request </button>
                    </div>


                <div class="overlay" id="overlay1"></div>
                <div class="loader" id="loader1"></div>

            </div> <!-- END ROW -->




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
