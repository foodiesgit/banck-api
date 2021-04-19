<div class="row">
    <div class="col-sm-6">
        <table class="table table-striped custom-table-sm">
            <tbody>
                <tr>
                    <td><label class="font-weight-bold">First Name</label></td>
                    <td>{{ $consumer->first_name }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Middle Name</label></td>
                    <td>{{ $consumer->middle_name }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Last Name</label></td>
                    <td>{{ $consumer->last_name }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Date of Birth</label></td>
                    <td>{{ date("M. d, Y", strtotime($consumer->dob)) }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">SSN</label></td>
                    <td>{{ $consumer->ssn }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Phone</label></td>
                    <td>{{ $consumer->phone }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">E-mail Address</label></td>
                    <td>{{ $consumer->email }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Citizenship Status</label></td>
                    <td>{{ $consumer->citizenship_status }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Citizenship Country</label></td>
                    <td>{{ $consumer->citizenship_country }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Occupation</label></td>
                    <td>{{ $consumer->occupation }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Source of Income</label></td>
                    <td>{{ $consumer->source_of_income }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Expected Activity</label></td>
                    <td>{{ $consumer->expected_activity }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">Politically Exposed Person?</label></td>
                    <td>{{ $consumer->pep ? "YES" : "NO" }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">IP Address</label></td>
                    <td>{{ $consumer->ip_address }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">user_id</label></td>
                    <td>{{ $consumer->user_id }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">contact_phone_id</label></td>
                    <td>{{ $consumer->contact_phone_id }}</td>
                </tr>
                <tr>
                    <td><label class="font-weight-bold">contact_email_id</label></td>
                    <td>{{ $consumer->contact_email_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-6">
        <table class="table table-striped custom-table-sm">
            <tbody>
                @foreach ($addresses as $address)
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">address_id</label></td>
                        <td>{{ $address->address_id }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Address Type</label></td>
                        <td>{{ $address->address_type }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Address Line 1</label></td>
                        <td>{{ $address->address_line1 }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Address Line 2</label></td>
                        <td>{{ $address->address_line2 }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">City</label></td>
                        <td>{{ $address->address_city }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">State</label></td>
                        <td>{{ $address->address_state }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Zip Code</label></td>
                        <td>{{ $address->address_zipcode }}</td>
                    </tr>  
                @endforeach
                
                @foreach ($identification as $id)
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Document Type</label></td>
                        <td>{{ $id->id_type }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">ID Number</label></td>
                        <td>{{ $id->number }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Issuing State</label></td>
                        <td>{{ $id->id_state }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Issuing Country</label></td>
                        <td>{{ $id->id_country }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Issuing Date</label></td>
                        <td>{{ date("M. d, Y", strtotime($id->id_issuing_date)) }}</td>
                    </tr>
                    <tr>
                        <td class="w-25"><label class="font-weight-bold">Expiration Date</label></td>
                        <td>{{ date("M. d, Y", strtotime($id->id_expiration_date)) }}</td>
                    </tr>
                @endforeach
                
                <tr>
                    <td class="w-25"><label class="font-weight-bold">KYC Status</label></td>
                    <td>{{ $consumer->kyc_status }}</td>
                </tr>
                <tr>
                    <td class="w-25"><label class="font-weight-bold">IDV Required</label></td>
                    <td>{{ $consumer->idv_required }}</td>
                </tr>
                <tr>
                    <td class="w-25"><label class="font-weight-bold">KYC Notes</label></td>
                    <td>
                        @foreach ($kyc as $note)
                            {{ $note->code . " - " . $note->details }}<br>
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
