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
                                        name="first_name" placeholder="First Name" value=""
                                        required>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control"
                                        name="middle_name" placeholder="Middle Name"
                                        value="">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name="last_name"
                                        placeholder="Last Name" value="" required>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Birthdate</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepickers"
                                        value="1994-09-12" name="dob" />
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">SSN</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="ssn"
                                        placeholder="ex. 123456789" value="123456789"
                                        required>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Phone</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="phone"
                                        placeholder="ex. +14153214967" value="+14153214967"
                                        required>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">E-mail
                                    Address</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" name="email"
                                        placeholder="ex. test@email.com"
                                        value="test@peachtel.net" required>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Citizenship
                                    Status</label>
                                <div class="col-sm-9">
                                    <select name="citizenship_status" class="form-control">
                                        <option value="us_citizen">US Citizen</option>
                                        <option value="resident">Resident</option>
                                        <option value="non_resident">Non-Resident</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Citizenship
                                    Country</label>
                                <div class="col-sm-9">
                                    <select name="citizenship_country" class="form-control">
                                        <option value="USA">United States of America
                                        </option>
                                        @foreach ($countries as $country)
                                            @if ($country->alpha_3 != 'USA')
                                                <option value="{{ $country->alpha_3 }}">
                                                    {{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        name="address_line1" placeholder="Address Line 1"
                                        value="201 mission st" required>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        name="address_line2" placeholder="Address Line 2"
                                        value="">
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
                                    <select name="address_state" class="form-control">
                                        <option value="">-Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->abbreviation }}"
                                                {{ $state->abbreviation == 'CA' ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control"
                                        name="address_zipcode" placeholder="Zip Code"
                                        value="94104">
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Address Type</label>
                                <div class="col-sm-9">
                                    <select name="address_type" class="form-control">
                                        <option value="legal">Legal Address</option>
                                        <option value="postal">Postal Address</option>
                                        <option value="work">Work Address</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">IP Address</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control"
                                        name="ip_address" placeholder=""
                                        value="{{ \Request::ip() }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Occupation</label>
                                <div class="col-sm-9">
                                    <select name="occupation" class="form-control">
                                        <option value="agriculture">Agriculture</option>
                                        <option value="clergy_ministry_staff">Clergy
                                            Ministry Staff</option>
                                        <option value="construction_industrial">
                                            Construction/Industrial</option>
                                        <option value="education">Education</option>
                                        <option value="finance_accounting_tax">Finance
                                            Accounting Tax</option>
                                        <option value="fire_first_responders">Fire First
                                            Responders</option>
                                        <option value="healthcare">Healthcare</option>
                                        <option value="homemaker">Homemaker</option>
                                        <option value="labor_general">Labor General</option>
                                        <option value="labor_skilled">Labor Skilled</option>
                                        <option value="law_enforcement_security">Law
                                            Enforcement Security</option>
                                        <option value="legal_services">Legal Services
                                        </option>
                                        <option value="military">Military</option>
                                        <option value="notary_registrar">Notary Registrar
                                        </option>
                                        <option value="private_investor">Private Investor
                                        </option>
                                        <option value="professional_administrative">
                                            Professional Administrative</option>
                                        <option value="professional_management">Professional
                                            Management</option>
                                        <option value="professional_other">Professional
                                            Other</option>
                                        <option value="professional_technical">Professional
                                            Technical</option>
                                        <option value="retired">Retired</option>
                                        <option value="sales" selected>Sales</option>
                                        <option value="self_employed">Self Employed</option>
                                        <option value="student">Student</option>
                                        <option value="transportation">Transportation
                                        </option>
                                        <option value="unemployed">Unemployed</option>
                                    </select>
                                </div>
                            </div>
                    
                            <div class="row mt-2">
                                <label class="col-sm-3 col-form-label">Source of
                                    Income</label>
                                <div class="col-sm-3">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="checkbox" value="inheritance" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="salary" name="source_of_income[]" checked>
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
                                            <input class="form-check-input" type="checkbox" value="sale_of_a_company" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="sale_of_a_property" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="investments" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="life_insurance" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="divorce_settlement" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="other" name="source_of_income[]">
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
                                            <input class="form-check-input" type="checkbox" value="cash" name="expected_activity[]" checked>
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
                                            <input class="form-check-input" type="checkbox" value="check" name="expected_activity[]">
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
                                            <input class="form-check-input" type="checkbox" value="domestic_wire_transfer" name="expected_activity[]">
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
                                            <input class="form-check-input" type="checkbox" value="international_wire_transfer" name="expected_activity[]">
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
                                            <input class="form-check-input" type="checkbox" value="domestic_ach" name="expected_activity[]">
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
                                            <input class="form-check-input" type="checkbox" value="international_ach" name="expected_activity[]">
                                            <span class="form-check-sign">
                                                <span class="check"></span>
                                            </span>
                                            International Ach Payment
                                        </label>
                                    </div>
                                </div>
                            </div>
                    
                            <div class="row">
                                <label class="col-sm-3 col-form-label">Identification
                                    Document</label>
                                <div class="col-sm-9">
                                    <select name="id_type" class="form-control">
                                        <option value="">-Document Type-</option>
                                        <option value="passport">Passport</option>
                                        <option value="drivers_license" selected>Driver's
                                            License</option>
                                        <option value="state_id">State ID</option>
                                        <option value="alien_registration_card">Alien
                                            Registration Card/Green Card</option>
                                        <option value="H_visa">U.S. visa types H-1B, H-1C,
                                            H-2A, H-2B, or H-3</option>
                                        <option value="L_visa">U.S. visa types L-1A or L-1B
                                        </option>
                                        <option value="O_visa">U.S. visa type O-1</option>
                                        <option value="E1_visa">U.S. visa type E-1</option>
                                        <option value="E3_visa">U.S. visa type E-3</option>
                                        <option value="I_visa">U.S. visa type I</option>
                                        <option value="P_visa">U.S. visa types P-1A, P-1B,
                                            P-2, or P-3</option>
                                        <option value="TN_visa">TN_visa: U.S. visa type TN
                                        </option>
                                        <option value="TD_visa">U.S. visa type TD</option>
                                        <option value="R1_visa">U.S. visa type R-1</option>
                                        <option value="other_visa">Other visa type</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="id_number"
                                        placeholder="ID Number" value="123456789">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <select name="id_state" class="form-control">
                                        <option value="">-Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->abbreviation }}"
                                                {{ $state->abbreviation == 'CA' ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <select name="id_country" class="form-control">
                                        <option value="">-Issuing Country-</option>
                                        <option value="USA" selected>United States of
                                            America</option>
                                        @foreach ($countries as $country)
                                            @if ($country->alpha_3 != 'USA')
                                                <option value="{{ $country->alpha_3 }}">
                                                    {{ $country->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control datepickers"
                                        name="id_issuing_date" placeholder="Issuing Date"
                                        value="2020-01-01">
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <input type="text"
                                        class="form-control datepickers-future"
                                        name="id_expiration_date"
                                        placeholder="Expiration Date" value="2025-01-01">
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">Are you a Political
                                    Exposed Person?</label>
                                <div class="col-sm-9 d-flex mt-2">
                                    <div class="form-radio mr-3">
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" value="no" name="pep" checked>
                                            <span class="form-radio-sign">
                                                <span class="check"></span>
                                            </span>
                                            No
                                        </label>
                                    </div>
                                    <div class="form-radio">
                                        <label class="form-radio-label">
                                            <input class="form-radio-input" type="radio" value="yes" name="pep">
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