@csrf
<input type="hidden" name="consumer_id" value="{{ $consumer->id }}">
<div class="row">
    <div class="col-sm-5">
        <div class="row">
            <label class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{ $consumer->first_name }}" required>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" value="{{ $consumer->middle_name }}">
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{ $consumer->last_name }}" required>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">Birthdate</label>
            <div class="col-sm-9">
                <input type="text" class="form-control datepickers" value="{{ $consumer->dob }}" name="dob" />
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">SSN</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="ssn" placeholder="ex. 123456789" value="{{ $consumer->ssn }}"
                    required>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">Phone</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="phone" placeholder="ex. +14153214967" value="{{ $consumer->phone }}"
                    required>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">E-mail
                Address</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" name="email" placeholder="ex. test@email.com"
                    value="{{ $consumer->email }}" required>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">Citizenship
                Status</label>
            <div class="col-sm-9">
                <select name="citizenship_status" class="form-control" disabled>
                    <option value="us_citizen" {{ $consumer->citizenship_status == "us_citizen" ? " selected" : "" }}>US Citizen</option>
                    <option value="resident" {{ $consumer->citizenship_status == "resident" ? " selected" : "" }}>Resident</option>
                    <option value="non_resident" {{ $consumer->citizenship_status == "non_resident" ? " selected" : "" }}>Non-Resident</option>
                </select>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">Citizenship
                Country</label>
            <div class="col-sm-9">
                <select name="citizenship_country" class="form-control" disabled>
                    <option value="USA" {{ $consumer->citizenship_country == "USA" ? " selected" : "" }}>United States of America
                    </option>
                    @foreach ($countries as $country)
                        @if ($country->alpha_3 != 'USA')
                            <option value="{{ $country->alpha_3 }}" {{ $consumer->citizenship_country == $country->alpha_3  ? " selected" : "" }}>
                                {{ $country->name }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <label class="col-sm-3 col-form-label">Address</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="address_line1" placeholder="Address Line 1"
                    value="{{ $address->address_line1 }}" required>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="address_line2" placeholder="Address Line 2" value="{{ $address->address_line2 }}">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="address_city" placeholder="City" value="{{ $address->address_city }}">
            </div>
            <div class="col-sm-3">
                <select name="address_state" class="form-control">
                    <option value="">-Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->abbreviation }}" {{ $address->address_state == $state->abbreviation ? 'selected' : '' }}>
                            {{ $state->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="address_zipcode" placeholder="Zip Code" value="{{ $address->address_zipcode }}">
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">Address Type</label>
            <div class="col-sm-9">
                <select name="address_type" class="form-control">
                    <option value="legal" {{ $address->address_type == "legal" ? "selected" : "" }}>Legal Address</option>
                    <option value="postal" {{ $address->address_type == "postal" ? "selected" : "" }}>Postal Address</option>
                    <option value="work" {{ $address->address_type == "work" ? "selected" : "" }}>Work Address</option>
                </select>
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">IP Address</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="ip_address" placeholder="" value="{{ $consumer->ip_address }}" disabled>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="row">
            <label class="col-sm-3 col-form-label">Occupation</label>
            <div class="col-sm-9">
                <select name="occupation" class="form-control" disabled>
                    <option value="agriculture" {{ $consumer->occupation == "agriculture" ? "selected" : "" }}>Agriculture</option>
                    <option value="clergy_ministry_staff" {{ $consumer->occupation == "clergy_ministry_staff" ? "selected" : "" }}>Clergy
                        Ministry Staff</option>
                    <option value="construction_industrial" {{ $consumer->occupation == "construction_industrial" ? "selected" : "" }}>
                        Construction/Industrial</option>
                    <option value="education" {{ $consumer->occupation == "education" ? "selected" : "" }}>Education</option>
                    <option value="finance_accounting_tax" {{ $consumer->occupation == "finance_accounting_tax" ? "selected" : "" }}>Finance
                        Accounting Tax</option>
                    <option value="fire_first_responders" {{ $consumer->occupation == "fire_first_responders" ? "selected" : "" }}>Fire First
                        Responders</option>
                    <option value="healthcare" {{ $consumer->occupation == "healthcare" ? "selected" : "" }}>Healthcare</option>
                    <option value="homemaker" {{ $consumer->occupation == "homemaker" ? "selected" : "" }}>Homemaker</option>
                    <option value="labor_general" {{ $consumer->occupation == "labor_general" ? "selected" : "" }}>Labor General</option>
                    <option value="labor_skilled" {{ $consumer->occupation == "labor_skilled" ? "selected" : "" }}>Labor Skilled</option>
                    <option value="law_enforcement_security" {{ $consumer->occupation == "law_enforcement_security" ? "selected" : "" }}>Law
                        Enforcement Security</option>
                    <option value="legal_services" {{ $consumer->occupation == "legal_services" ? "selected" : "" }}>Legal Services
                    </option>
                    <option value="military" {{ $consumer->occupation == "military" ? "selected" : "" }}>Military</option>
                    <option value="notary_registrar" {{ $consumer->occupation == "notary_registrar" ? "selected" : "" }}>Notary Registrar
                    </option>
                    <option value="private_investor" {{ $consumer->occupation == "private_investor" ? "selected" : "" }}>Private Investor
                    </option>
                    <option value="professional_administrative" {{ $consumer->occupation == "professional_administrative" ? "selected" : "" }}>
                        Professional Administrative</option>
                    <option value="professional_management" {{ $consumer->occupation == "professional_management" ? "selected" : "" }}>Professional
                        Management</option>
                    <option value="professional_other" {{ $consumer->occupation == "professional_other" ? "selected" : "" }}>Professional
                        Other</option>
                    <option value="professional_technical" {{ $consumer->occupation == "professional_technical" ? "selected" : "" }}>Professional
                        Technical</option>
                    <option value="retired" {{ $consumer->occupation == "retired" ? "selected" : "" }}>Retired</option>
                    <option value="sales"  {{ $consumer->occupation == "sales" ? "selected" : "" }}>Sales</option>
                    <option value="self_employed" {{ $consumer->occupation == "self_employed" ? "selected" : "" }}>Self Employed</option>
                    <option value="student" {{ $consumer->occupation == "student" ? "selected" : "" }}>Student</option>
                    <option value="transportation" {{ $consumer->occupation == "transportation" ? "selected" : "" }}>Transportation
                    </option>
                    <option value="unemployed" {{ $consumer->occupation == "unemployed" ? "selected" : "" }}>Unemployed</option>
                </select>
            </div>
        </div>

        <div class="row mt-2">
            <label class="col-sm-3 col-form-label">Source of
                Income</label>
            <div class="col-sm-3">
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="inheritance" name="source_of_income[]" {{ in_array("inheritance", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="salary" name="source_of_income[]"
                        {{ in_array("salary", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="sale_of_a_company"
                            name="source_of_income[]"  {{ in_array("sale_of_a_company", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="sale_of_a_property"
                            name="source_of_income[]" {{ in_array("sale_of_a_property", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="investments" name="source_of_income[]" {{ in_array("investments", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="life_insurance"
                            name="source_of_income[]" {{ in_array("life_insurance", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="divorce_settlement"
                            name="source_of_income[]" {{ in_array("divorce_settlement", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="other" name="source_of_income[]" {{ in_array("other", $source_of_income) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="cash" name="expected_activity[]" {{ in_array("cash", $expected_activity) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="check" name="expected_activity[]" {{ in_array("check", $expected_activity) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="domestic_wire_transfer"
                            name="expected_activity[]" {{ in_array("domestic_wire_transfer", $expected_activity) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="international_wire_transfer"
                            name="expected_activity[]" {{ in_array("international_wire_transfer", $expected_activity) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="domestic_ach" name="expected_activity[]" {{ in_array("domestic_ach", $expected_activity) ? "checked" : "" }} disabled>
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
                        <input class="form-check-input" type="checkbox" value="international_ach"
                            name="expected_activity[]" {{ in_array("international_ach", $expected_activity) ? "checked" : "" }} disabled>
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
                    <option value="passport" {{ $identification->id_type == "passport" ? "selected" : "" }}>Passport</option>
                    <option value="drivers_license" {{ $identification->id_type == "drivers_license" ? "selected" : "" }}>Driver's
                        License</option>
                    <option value="state_id" {{ $identification->id_type == "state_id" ? "selected" : "" }}>State ID</option>
                    <option value="alien_registration_card" {{ $identification->id_type == "alien_registration_card" ? "selected" : "" }}>Alien
                        Registration Card/Green Card</option>
                    <option value="H_visa" {{ $identification->id_type == "H_visa" ? "selected" : "" }}>U.S. visa types H-1B, H-1C,
                        H-2A, H-2B, or H-3</option>
                    <option value="L_visa" {{ $identification->id_type == "L_visa" ? "selected" : "" }}>U.S. visa types L-1A or L-1B
                    </option>
                    <option value="O_visa" {{ $identification->id_type == "O_visa" ? "selected" : "" }}>U.S. visa type O-1</option>
                    <option value="E1_visa" {{ $identification->id_type == "E1_visa" ? "selected" : "" }}>U.S. visa type E-1</option>
                    <option value="E3_visa" {{ $identification->id_type == "E3_visa" ? "selected" : "" }}>U.S. visa type E-3</option>
                    <option value="I_visa" {{ $identification->id_type == "I_visa" ? "selected" : "" }}>U.S. visa type I</option>
                    <option value="P_visa" {{ $identification->id_type == "P_visa" ? "selected" : "" }}>U.S. visa types P-1A, P-1B,
                        P-2, or P-3</option>
                    <option value="TN_visa" {{ $identification->id_type == "TN_visa" ? "selected" : "" }}>TN_visa: U.S. visa type TN
                    </option>
                    <option value="TD_visa" {{ $identification->id_type == "TD_visa" ? "selected" : "" }}>U.S. visa type TD</option>
                    <option value="R1_visa" {{ $identification->id_type == "R1_visa" ? "selected" : "" }}>U.S. visa type R-1</option>
                    <option value="other_visa" {{ $identification->id_type == "other_visa" ? "selected" : "" }}>Other visa type</option>
                </select>
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="id_number" placeholder="ID Number" value="{{ $identification->id_number }}">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
                <select name="id_state" class="form-control">
                    <option value="">-Select State</option>
                    @foreach ($states as $state)
                        <option value="{{ $state->abbreviation }}" {{ $identification->id_state == $state->abbreviation ? 'selected' : '' }}>
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
                    <option value="USA" {{ $identification->id_country == "USA" ? 'selected' : '' }}>United States of
                        America</option>
                    @foreach ($countries as $country)
                        @if ($country->alpha_3 != 'USA')
                            <option value="{{ $country->alpha_3 }}" {{ $identification->id_country == $country->alpha_3 ? 'selected' : '' }}>
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
                <input type="text" class="form-control datepickers" name="id_issuing_date" placeholder="Issuing Date"
                    value="{{ $identification->id_issuing_date }}">
            </div>
        </div>
        <div class="row">
            <label class="col-sm-3 col-form-label"></label>
            <div class="col-sm-9">
                <input type="text" class="form-control datepickers-future" name="id_expiration_date"
                    placeholder="Expiration Date" value="{{ $identification->id_expiration_date }}">
            </div>
        </div>

        <div class="row">
            <label class="col-sm-3 col-form-label">Are you a Political
                Exposed Person?</label>
            <div class="col-sm-9 d-flex mt-2">
                <div class="form-radio mr-3">
                    <label class="form-radio-label">
                        <input class="form-radio-input" type="radio" value="no" name="pep" {{ !$consumer->pep ? "checked" : "" }} disabled>
                        <span class="form-radio-sign">
                            <span class="check"></span>
                        </span>
                        No
                    </label>
                </div>
                <div class="form-radio">
                    <label class="form-radio-label">
                        <input class="form-radio-input" type="radio" value="yes" name="pep" {{ $consumer->pep ? "checked" : "" }} disabled>
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
