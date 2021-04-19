@extends('layouts.app', ['activePage' => 'bbva-api', 'titlePage' => __('BBVA')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            {{-- OAuth API --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title font-weight-bold">OAuth API</h4>
                            <p class="card-category">Open Platform uses OAuth 2.0, the industry-standard protocol for
                                authorization. OAuth 2.0 focuses on client developer simplicity while providing specific
                                authorization flows for web applications, desktop applications and other devices.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link nav-link-primary active" href="#oauth1"
                                                data-toggle="tab">Obtain Access Token</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link nav-link-primary" href="#oauth2"
                                                data-toggle="tab">Invalidate Access Token</a></li>
                                    </ul>
                                    <div class="tab-content tab-space">
                                        <div class="tab-pane active py-3" id="oauth1">
                                            <div
                                                class="alert alert-success oauth-notif-success oauth-on {{ $accessToken ? '' : 'd-none' }}">
                                                <span>
                                                    <b> Access Token Successfully Obtained! </b> You can now use other APIs
                                                    now
                                                </span>
                                            </div>
                                            <div
                                                class="alert alert-danger oauth-notif-failed oauth-off {{ $accessToken ? 'd-none' : '' }}">
                                                <span>
                                                    <b> No Access Token Found! </b> Please obtain Access Token by pressing
                                                    'OBTAIN' button to be able to use other APIs
                                                </span>
                                            </div>
                                            <table class="table oauth-on {{ $accessToken ? '' : 'd-none' }}"
                                                style="table-layout: fixed;">
                                                <tbody>
                                                    <tr>
                                                        <td class="font-weight-bold" style="width: 10%;">
                                                            Current Access Token
                                                        </td>
                                                        <td>
                                                            {{ $accessToken }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <a class="btn btn-success" href="/api-tester/bbva">Obtain New</a>
                                        </div>
                                        <div class="tab-pane pt-3" id="oauth2">
                                            <div class="alert alert-danger oauth-on {{ $accessToken ? '' : 'd-none' }}">
                                                <span>
                                                    <b>WARNING!</b> Current Access Token will be Invalidated when you press
                                                    the 'INVALIDATE' button and you will not be able to use other APIs
                                                </span>
                                            </div>
                                            <div class="alert alert-danger oauth-off {{ $accessToken ? 'd-none' : '' }}">
                                                <span class="font-weight-bold">
                                                    Access Token Successfully Invalidated
                                                </span>
                                            </div>
                                            <button class="btn btn-danger" id="invalidate-access-token-btn"
                                                {{ $accessToken ? '' : 'disabled' }}>Invalidate</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Consumer API --}}
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">Consumer API</h4>
                            <p class="card-category">Consumer API is the first API you will need to call to start using our
                                services. The Consumer API is the core resource to create consumer and business records for
                                your customers, to use our Move Money service, or to originate and manage accounts and
                                cards. You will need to use the UUID you receive in the create a consumer response (CO-UUID)
                                in all the rest of the headers as the OP-User-ID.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-primary float-right" data-toggle="modal"
                                        data-target="#create-consumer-modal">Create new consumer</button>
                                    <div class="consumers-table-container">
                                        <table class="table">
                                            <thead class="text-warning">
                                                <th>Name</th>
                                                <th>Date of Birth</th>
                                                <th>SSN</th>
                                                <th class="w-10 text-center">KYC Status</th>
                                                <th class="w-40 text-center">Actions</th>
                                            </thead>
                                            <tbody>
                                                @forelse ($consumers as $consumer)
                                                    <tr>
                                                        <td>{{ $consumer->first_name . ' ' . $consumer->last_name }}</td>
                                                        <td>{{ date('M. d, Y', strtotime($consumer->dob)) }}</td>
                                                        <td>{{ $consumer->ssn }}</td>
                                                        <td class="w-10 text-center">
                                                            @if ($consumer->kyc_status == 'approved')
                                                                <span class="badge badge-success p-2">APPROVED</span>
                                                            @elseif ($consumer->kyc_status == "declined")
                                                                <span class="badge badge-danger p-2">DECLINED</span>
                                                            @else
                                                                <span class="badge badge-primary p-2">REVIEW</span>
                                                            @endif
                                                        </td>
                                                        <td class="w-40 text-right">
                                                            <span class="d-none consumer-id">{{ $consumer->id }}</span>
                                                            <button class="btn btn-primary view-consumer-details-btn"
                                                                data-toggle="modal"
                                                                data-target="#view-consumer-details-modal">View Details</button>
                                                            <button class="btn btn-success review-consumer-kyc-btn"
                                                                data-toggle="modal" data-target="#review-kyc-modal">Review
                                                                KYC</button>
                                                            <button class="btn btn-info update-consumer-info-btn"
                                                                data-toggle="modal" data-target="#update-consumer-modal">Update
                                                                Info</button>
                                                            <button class="btn btn-warning upload-consumer-docs-btn"
                                                                data-toggle="modal" data-target="#upload-consumer-docs-modal">Upload
                                                                Documents</button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            No records found.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                        <div class="modal fade" id="create-consumer-modal" tabindex="-1" role="dialog"
                                            aria-labelledby="create-consumer-modal-label" aria-hidden="true">
                                            <div class="modal-dialog modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="create-consumer-modal-label">Create
                                                            consumer</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form id="bbva-create-consumer-form">
                                                        <div class="modal-body">
                                                            @csrf
                                                            <div class="row">
                                                                <div class="col-sm-5">
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Name</label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control"
                                                                                name="first_name" placeholder="First Name"
                                                                                value="" required>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control"
                                                                                name="middle_name" placeholder="Middle Name"
                                                                                value="">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control"
                                                                                name="last_name" placeholder="Last Name"
                                                                                value="" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">Birthdate</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text"
                                                                                class="form-control datepickers"
                                                                                value="1994-09-12" name="dob" />
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">SSN</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                name="ssn" placeholder="ex. 123456789"
                                                                                value="123456789" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Phone</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                name="phone" placeholder="ex. +14153214967"
                                                                                value="+14153214967" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">E-mail
                                                                            Address</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="email" class="form-control"
                                                                                name="email"
                                                                                placeholder="ex. test@email.com"
                                                                                value="test@peachtel.net" required>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Citizenship
                                                                            Status</label>
                                                                        <div class="col-sm-9">
                                                                            <select name="citizenship_status"
                                                                                class="form-control">
                                                                                <option value="us_citizen">US Citizen
                                                                                </option>
                                                                                <option value="resident">Resident</option>
                                                                                <option value="non_resident">Non-Resident
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Citizenship
                                                                            Country</label>
                                                                        <div class="col-sm-9">
                                                                            <select name="citizenship_country"
                                                                                class="form-control">
                                                                                <option value="USA">United States of America
                                                                                </option>
                                                                                @foreach ($countries as $country)
                                                                                    @if ($country->alpha_3 != 'USA')
                                                                                        <option
                                                                                            value="{{ $country->alpha_3 }}">
                                                                                            {{ $country->name }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">Address</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                name="address_line1"
                                                                                placeholder="Address Line 1"
                                                                                value="201 mission st" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                name="address_line2"
                                                                                placeholder="Address Line 2" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control"
                                                                                name="address_city" placeholder="City"
                                                                                value="San Francisco">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select name="address_state"
                                                                                class="form-control">
                                                                                <option value="">-Select State</option>
                                                                                @foreach ($states as $state)
                                                                                    <option
                                                                                        value="{{ $state->abbreviation }}"
                                                                                        {{ $state->abbreviation == 'CA' ? 'selected' : '' }}>
                                                                                        {{ $state->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <input type="text" class="form-control"
                                                                                name="address_zipcode"
                                                                                placeholder="Zip Code" value="94104">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Address
                                                                            Type</label>
                                                                        <div class="col-sm-9">
                                                                            <select name="address_type"
                                                                                class="form-control">
                                                                                <option value="legal">Legal Address</option>
                                                                                <option value="postal">Postal Address
                                                                                </option>
                                                                                <option value="work">Work Address</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">IP
                                                                            Address</label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                name="ip_address" placeholder=""
                                                                                value="{{ \Request::ip() }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-7">
                                                                    <div class="row">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">Occupation</label>
                                                                        <div class="col-sm-9">
                                                                            <select name="occupation" class="form-control">
                                                                                <option value="agriculture">Agriculture
                                                                                </option>
                                                                                <option value="clergy_ministry_staff">Clergy
                                                                                    Ministry Staff</option>
                                                                                <option value="construction_industrial">
                                                                                    Construction/Industrial</option>
                                                                                <option value="education">Education</option>
                                                                                <option value="finance_accounting_tax">
                                                                                    Finance
                                                                                    Accounting Tax</option>
                                                                                <option value="fire_first_responders">Fire
                                                                                    First
                                                                                    Responders</option>
                                                                                <option value="healthcare">Healthcare
                                                                                </option>
                                                                                <option value="homemaker">Homemaker</option>
                                                                                <option value="labor_general">Labor General
                                                                                </option>
                                                                                <option value="labor_skilled">Labor Skilled
                                                                                </option>
                                                                                <option value="law_enforcement_security">Law
                                                                                    Enforcement Security</option>
                                                                                <option value="legal_services">Legal
                                                                                    Services
                                                                                </option>
                                                                                <option value="military">Military</option>
                                                                                <option value="notary_registrar">Notary
                                                                                    Registrar
                                                                                </option>
                                                                                <option value="private_investor">Private
                                                                                    Investor
                                                                                </option>
                                                                                <option value="professional_administrative">
                                                                                    Professional Administrative</option>
                                                                                <option value="professional_management">
                                                                                    Professional
                                                                                    Management</option>
                                                                                <option value="professional_other">
                                                                                    Professional
                                                                                    Other</option>
                                                                                <option value="professional_technical">
                                                                                    Professional
                                                                                    Technical</option>
                                                                                <option value="retired">Retired</option>
                                                                                <option value="sales" selected>Sales
                                                                                </option>
                                                                                <option value="self_employed">Self Employed
                                                                                </option>
                                                                                <option value="student">Student</option>
                                                                                <option value="transportation">
                                                                                    Transportation
                                                                                </option>
                                                                                <option value="unemployed">Unemployed
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row mt-2">
                                                                        <label class="col-sm-3 col-form-label">Source of
                                                                            Income</label>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="inheritance"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Inheritance
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="salary"
                                                                                        name="source_of_income[]" checked>
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Salary
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="sale_of_a_company"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Sale of a Company
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3 offset-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="sale_of_a_property"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Sale of a Property
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="investments"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Investments
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="life_insurance"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Life Insurance
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3 offset-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="divorce_settlement"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Divorce Settlement
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="other"
                                                                                        name="source_of_income[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Other
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Expected
                                                                            Activity</label>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="cash"
                                                                                        name="expected_activity[]" checked>
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Cash
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="check"
                                                                                        name="expected_activity[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Check
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="domestic_wire_transfer"
                                                                                        name="expected_activity[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Domestic Wire Transfer
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3 offset-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="international_wire_transfer"
                                                                                        name="expected_activity[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    International Wire Transfer
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox" value="domestic_ach"
                                                                                        name="expected_activity[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Domestic Ach Payment
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <div class="form-check">
                                                                                <label class="form-check-label">
                                                                                    <input class="form-check-input"
                                                                                        type="checkbox"
                                                                                        value="international_ach"
                                                                                        name="expected_activity[]">
                                                                                    <span class="form-check-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    International Ach Payment
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label
                                                                            class="col-sm-3 col-form-label">Identification
                                                                            Document</label>
                                                                        <div class="col-sm-9">
                                                                            <select name="id_type" class="form-control">
                                                                                <option value="">-Document Type-</option>
                                                                                <option value="passport">Passport</option>
                                                                                <option value="drivers_license" selected>
                                                                                    Driver's
                                                                                    License</option>
                                                                                <option value="state_id">State ID</option>
                                                                                <option value="alien_registration_card">
                                                                                    Alien
                                                                                    Registration Card/Green Card</option>
                                                                                <option value="H_visa">U.S. visa types H-1B,
                                                                                    H-1C,
                                                                                    H-2A, H-2B, or H-3</option>
                                                                                <option value="L_visa">U.S. visa types L-1A
                                                                                    or L-1B
                                                                                </option>
                                                                                <option value="O_visa">U.S. visa type O-1
                                                                                </option>
                                                                                <option value="E1_visa">U.S. visa type E-1
                                                                                </option>
                                                                                <option value="E3_visa">U.S. visa type E-3
                                                                                </option>
                                                                                <option value="I_visa">U.S. visa type I
                                                                                </option>
                                                                                <option value="P_visa">U.S. visa types P-1A,
                                                                                    P-1B,
                                                                                    P-2, or P-3</option>
                                                                                <option value="TN_visa">TN_visa: U.S. visa
                                                                                    type TN
                                                                                </option>
                                                                                <option value="TD_visa">U.S. visa type TD
                                                                                </option>
                                                                                <option value="R1_visa">U.S. visa type R-1
                                                                                </option>
                                                                                <option value="other_visa">Other visa type
                                                                                </option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text" class="form-control"
                                                                                name="id_number" placeholder="ID Number"
                                                                                value="123456789">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-9">
                                                                            <select name="id_state" class="form-control">
                                                                                <option value="">-Select State</option>
                                                                                @foreach ($states as $state)
                                                                                    <option
                                                                                        value="{{ $state->abbreviation }}"
                                                                                        {{ $state->abbreviation == 'CA' ? 'selected' : '' }}>
                                                                                        {{ $state->name }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-9">
                                                                            <select name="id_country" class="form-control">
                                                                                <option value="">-Issuing Country-</option>
                                                                                <option value="USA" selected>United States
                                                                                    of
                                                                                    America</option>
                                                                                @foreach ($countries as $country)
                                                                                    @if ($country->alpha_3 != 'USA')
                                                                                        <option
                                                                                            value="{{ $country->alpha_3 }}">
                                                                                            {{ $country->name }}
                                                                                        </option>
                                                                                    @endif
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text"
                                                                                class="form-control datepickers"
                                                                                name="id_issuing_date"
                                                                                placeholder="Issuing Date"
                                                                                value="2020-01-01">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label"></label>
                                                                        <div class="col-sm-9">
                                                                            <input type="text"
                                                                                class="form-control datepickers-future"
                                                                                name="id_expiration_date"
                                                                                placeholder="Expiration Date"
                                                                                value="2025-01-01">
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <label class="col-sm-3 col-form-label">Are you a
                                                                            Political
                                                                            Exposed Person?</label>
                                                                        <div class="col-sm-9 d-flex mt-2">
                                                                            <div class="form-radio mr-3">
                                                                                <label class="form-radio-label">
                                                                                    <input class="form-radio-input"
                                                                                        type="radio" value="no" name="pep"
                                                                                        checked>
                                                                                    <span class="form-radio-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    No
                                                                                </label>
                                                                            </div>
                                                                            <div class="form-radio">
                                                                                <label class="form-radio-label">
                                                                                    <input class="form-radio-input"
                                                                                        type="radio" value="yes" name="pep">
                                                                                    <span class="form-radio-sign">
                                                                                        <span class="check"></span>
                                                                                    </span>
                                                                                    Yes
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button"
                                                                class="btn btn-secondary cancel-submit-btn"
                                                                data-dismiss="modal">Close</button>
                                                            <button class="btn btn-primary" id="submit-create-consumer-form"
                                                                type="submit">Submit</button>
                                                        </div>
                                                    </form>
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
            {{-- Business API --}}
            {{-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                            <h4 class="card-title font-weight-bold">Business API</h4>
                            <p class="card-category">Business API is the API you will need to use to create business records
                                for customers that are corporations, associations, partnerships, sole proprietors,
                                nonprofits or other nonconsumers.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link nav-link-warning active" href="#business1"
                                                data-toggle="tab">Create a business</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link nav-link-warning" href="#business2"
                                                data-toggle="tab">Update a business</a></li>
                                        <li class="nav-item"><a class="nav-link nav-link-warning" href="#business3"
                                                data-toggle="tab">Upload a business document</a></li>
                                    </ul>
                                    <div class="tab-content tab-space">
                                        <div class="tab-pane active" id="business1">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                        <div class="tab-pane" id="business2">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                        <div class="tab-pane" id="business3">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            {{-- Accounts API --}}
            {{-- <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title font-weight-bold">Accounts API</h4>
                            <p class="card-category">Accounts API is the second API you will need to call to start using our
                                services. This API will allow you to originate and manage accounts for individual or
                                business customers, which is a prerequisite in order to create debit cards for your
                                customers and use our Move Money service. You’ll also be able to associate multiple
                                participants with an account, manage customer account access and retrieve key account data,
                                such as real-time financial transactions.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link nav-link-primary active" href="#accounts1"
                                                data-toggle="tab">Create a consumer account</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link nav-link-primary" href="#accounts2"
                                                data-toggle="tab">Create a business account</a></li>
                                        <li class="nav-item"><a class="nav-link nav-link-primary" href="#accounts3"
                                                data-toggle="tab">Check account balance</a></li>
                                        <li class="nav-item"><a class="nav-link nav-link-primary" href="#accounts4"
                                                data-toggle="tab">Close account</a></li>
                                    </ul>
                                    <div class="tab-content tab-space">
                                        <div class="tab-pane active" id="accounts1">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                        <div class="tab-pane" id="accounts2">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                        <div class="tab-pane" id="accounts3">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                        <div class="tab-pane" id="accounts4">
                                            <br><br>
                                            ..
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    {{-- Consumer Details Modal --}}
    <div class="modal fade" id="view-consumer-details-modal" tabindex="-1" role="dialog"
        aria-labelledby="view-consumer-details-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="view-consumer-details-modal-label">Consumer Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row view-consumer-details-loader d-none">
                        <div class="col-12 text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                        </div>
                    </div>
                    <div class="view-consumer-details-container">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Review KYC Modal --}}
    <div class="modal fade" id="review-kyc-modal" tabindex="-1" role="dialog" aria-labelledby="review-kyc-modal-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="review-kyc-modal-label">Review KYC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row review-kyc-loader d-none">
                        <div class="col-12 text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                        </div>
                    </div>
                    <div class="review-kyc-container">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Consumer Modal --}}
    <div class="modal fade" id="update-consumer-modal" tabindex="-1" role="dialog"
        aria-labelledby="update-consumer-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="update-consumer-modal-label">Update
                        consumer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="update-consumer-loader">
                    <div class="row my-5">
                        <div class="col-12 text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                        </div>
                    </div>
                </div>
                <form id="bbva-update-consumer-form">
                    <div class="modal-body" id="update-consumer-form-container">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-submit-btn"
                            data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submit-update-consumer-form" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Update Consumer Modal --}}
    <div class="modal fade" id="upload-consumer-docs-modal" tabindex="-1" role="dialog"
        aria-labelledby="upload-consumer-docs-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="upload-consumer-docs-modal-label">Upload
                        document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="upload-consumer-docs-loader">
                    <div class="row my-5">
                        <div class="col-12 text-center">
                            <i class="fa fa-spinner fa-spin fa-2x"></i>
                        </div>
                    </div>
                </div>
                <form id="bbva-upload-consumer-docs-form">
                    <div class="modal-body" id="upload-consumer-docs-container">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-submit-btn"
                            data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" id="submit-upload-consumer-docs-form" type="submit">Submit</button>
                    </div>
                </form>
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
        let token = document.head.querySelector('meta[name="csrf-token"]');
        if (token) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        // Reload consumer records
        function reloadConsumers() {
            $('.consumers-table-container').load('/api-tester/bbva/reload-consumers');
        }

        // Show notification
        function showNotification(type, message) {
            $.notify({
                icon: "add_alert",
                message: message
            }, {
                type: type,
                timer: 3000,
                placement: {
                    from: 'top',
                    align: 'center'
                }
            });
        }

        // Initialize datepickers
        $('.datepickers').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "showCustomRangeLabel": false,
            "maxDate": moment(),
            "locale": {
                "format": "YYYY-MM-DD"
            }
        });

        $('.datepickers-future').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "showCustomRangeLabel": false,
            "minDate": moment(),
            "locale": {
                "format": "YYYY-MM-DD"
            }
        });

        $(document).ready(function() {
            // Invalidate Access Token
            $(document).on('click', '#invalidate-access-token-btn', function() {
                $.ajax({
                    type: "POST",
                    url: "/api-tester/bbva/invalidate-token",
                    beforeSend: function() {
                        $('#invalidate-access-token-btn').prop('disabled',
                            true);
                    },
                    success: function(res) {
                        // Success Invalidation
                        if (res) {
                            $('.oauth-on').addClass("d-none");
                            $('.oauth-off').removeClass("d-none");
                            $('#invalidate-access-token-btn').prop('disabled',
                                true);
                        } else {
                            $('#invalidate-access-token-btn').prop('disabled',
                                false);
                        }
                    }
                });
            });

            // Create consumer
            $(document).on('submit', '#bbva-create-consumer-form', function(e) {
                var formData = new FormData($('#bbva-create-consumer-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "/api-tester/bbva/create-consumer",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#submit-create-consumer-form').prop('disabled',
                            true);
                    },
                    success: function(res) {
                        if (res['success']) {
                            $('#create-consumer-modal').modal('toggle');
                            reloadConsumers();
                            showNotification('success', res['message']);
                        } else {
                            showNotification('danger', res['message']);
                        }
                    },
                    error: function(res) {
                        $('#submit-create-consumer-form').prop('disabled',
                            false);
                        $('#create-consumer-modal').modal('toggle');
                        showNotification('danger', res);
                    }
                });

                e.preventDefault();
            });

            // Cancel button
            $(document).on('click', '.cancel-submit-btn', function(e) {
                e.preventDefault();
            });

            // View Consumer details
            $(document).on('click', '.view-consumer-details-btn', function() {
                var consumer_id = $(this).closest('td').find('.consumer-id').html();
                $('.view-consumer-details-loader').removeClass('d-none');
                $('.view-consumer-details-container').addClass('d-none');
                $('.view-consumer-details-container').load(
                    '/api-tester/bbva/view-consumer/' + consumer_id,
                    function() {
                        $('.view-consumer-details-loader').addClass('d-none');
                        $('.view-consumer-details-container').removeClass('d-none');
                    });
            });

            // Review KYC status
            $(document).on('click', '.review-consumer-kyc-btn', function() {
                var consumer_id = $(this).closest('td').find('.consumer-id').html();
                $('.review-kyc-loader').removeClass('d-none');
                $('.review-kyc-container').addClass('d-none');
                $('.review-kyc-container').load(
                    '/api-tester/bbva/review-kyc/' + consumer_id,
                    function() {
                        $('.review-kyc-loader').addClass('d-none');
                        $('.review-kyc-container').removeClass('d-none');
                    });
            });

            // Show update consumer form
            $(document).on('click', '.update-consumer-info-btn', function() {
                var consumer_id = $(this).closest('td').find('.consumer-id').text();
                
                $('#bbva-update-consumer-form').addClass("d-none");
                $('.update-consumer-loader').removeClass("d-none");
                $('#update-consumer-form-container').load(
                    '/api-tester/bbva/update-consumer/' + consumer_id,
                    function() {
                        $('.update-consumer-loader').addClass("d-none");
                        $('#bbva-update-consumer-form').removeClass("d-none");
                        $('#submit-update-consumer-form').prop("disabled", false);
                    });
            });

            // Update consumer
            $(document).on('submit', '#bbva-update-consumer-form', function(e) {
                var formData = new FormData($('#bbva-update-consumer-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "/api-tester/bbva/update-consumer",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#submit-update-consumer-form').prop('disabled',
                            true);
                    },
                    success: function(res) {
                        if (res['success']) {
                            $('#update-consumer-modal').modal('toggle');
                            reloadConsumers();
                            showNotification('success', res['message']);
                        } else {
                            $('#update-consumer-modal').modal('toggle');
                            var err_msg = '<ul>';
                            for (var i = 0; i < res['message'].length; i++) {
                                err_msg += '<li>' + res['message'][i] + '</li>';
                            }
                            err_msg += '</ul>';
                            showNotification('danger', err_msg);
                        }
                    },
                    error: function(res) {
                        $('#submit-update-consumer-form').prop('disabled',
                            false);
                        $('#update-consumer-modal').modal('toggle');
                        showNotification('danger', res);
                    }
                });

                e.preventDefault();
            });

            // Show upload consumer document form
            $(document).on('click', '.upload-consumer-docs-btn', function() {
                var consumer_id = $(this).closest('td').find('.consumer-id').text();
                
                $('#bbva-upload-consumer-docs-form').addClass("d-none");
                $('.upload-consumer-docs-loader').removeClass("d-none");
                $('#upload-consumer-docs-container').load(
                    '/api-tester/bbva/upload-consumer-docs/' + consumer_id,
                    function() {
                        $('.upload-consumer-docs-loader').addClass("d-none");
                        $('#bbva-upload-consumer-docs-form').removeClass("d-none");
                        $('#submit-upload-consumer-docs-form').prop("disabled", false);
                    });
            });

            // Upload consumer document
            $(document).on('submit', '#bbva-upload-consumer-docs-form', function(e) {
                var formData = new FormData($('#bbva-upload-consumer-docs-form')[0]);

                $.ajax({
                    type: "POST",
                    url: "/api-tester/bbva/upload-consumer-docs",
                    data: formData,
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#submit-upload-consumer-docs-form').prop('disabled',
                            true);
                    },
                    success: function(res) {
                        if (res['success']) {
                            $('#upload-consumer-docs-modal').modal('toggle');
                            showNotification('success', res['message']);
                        } else {
                            $('#upload-consumer-docs-modal').modal('toggle');
                            var err_msg = '<ul>';
                            for (var i = 0; i < res['message'].length; i++) {
                                err_msg += '<li>' + res['message'][i] + '</li>';
                            }
                            err_msg += '</ul>';
                            showNotification('danger', err_msg);
                        }
                    },
                    error: function(res) {
                        $('#submit-upload-consumer-docs-form').prop('disabled',
                            false);
                        $('#upload-consumer-docs-modal').modal('toggle');
                        showNotification('danger', res.responseJSON.message);
                    }
                });

                e.preventDefault();
            });
        });

    </script>
@endpush
