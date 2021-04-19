@if ($success)
    {{-- {!! "<pre>" . print_r($response, true) . "</pre>" !!} --}}
    <div class="row">
        <div class="col-5"><b>KYC Status</b></div>
        <div class="col-7">
            @if ($response->kyc->status == "review")
                <span class="badge badge-primary">{{ strtoupper($response->kyc->status) }}</span>
            @elseif ($response->kyc->status == "approved")
                <span class="badge badge-success">{{ strtoupper($response->kyc->status) }}</span>
            @elseif ($response->kyc->status == "declined")
                <span class="badge badge-danger">{{ strtoupper($response->kyc->status) }}</span>
            @endif
        </div>
        @if ($response->kyc->idv_required)
            <div class="col-5"><b>Information Required To Be Verified</b></div>
            <div class="col-7">{{ implode(",", $response->kyc->idv_required) }}</div>
        @endif
        @if ($response->kyc_notes)
            <div class="col-5"><b>KYC Notes</b></div>
            <div class="col-7">
                @foreach ($response->kyc_notes as $kyc_note)
                    @if (isset($kyc_note->code) && isset($kyc_note->detail))
                        {!! $kyc_note->code . " - " . $kyc_note->detail . "<br>" !!}
                    @endif
                @endforeach
            </div>
        @endif
    </div>
@else
    <div class="alert alert-danger">
        <span>
            {{ $error }}
        </span>
    </div>
@endif