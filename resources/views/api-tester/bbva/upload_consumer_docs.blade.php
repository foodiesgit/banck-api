@csrf
<input type="hidden" name="consumer_id" value="{{ $consumer_id }}">
<div class="row">
    <label class="col-sm-3 col-form-label">Document Type</label>
    <div class="col-sm-9">
        <select name="doc_type" class="form-control" required>
            <option value="">-Document Type-</option>
            <option value="drivers_license">Drivers license</option>
            <option value="passport">Passport</option>
            <option value="passport_card">Passport Card</option>
            <option value="residency_permit">Residency Permit</option>
            <option value="work_permit">Work Permit</option>
            <option value="social_security_card">Social Security Card</option>
        </select>
    </div>
</div>

<div class="row">
    <label class="col-sm-3 col-form-label">Verification Reason</label>
    @foreach ($verify_idv as $idv)
        <div class="col-sm-3 mt-3 mb-0">
            <div class="form-check">
                <label class="form-check-label">
                    <input class="form-check-input" type="checkbox" value="{{ $idv }}" name="verify_idv[]" checked>
                    <span class="form-check-sign">
                        <span class="check"></span>
                    </span>
                    {{ $idv }}
                </label>
            </div>
        </div>   
    @endforeach
</div>

<div class="row mt-2">
    <label class="col-sm-3 col-form-label">File</label>
    <div class="col-sm-9">
        <input type="file" name="file" class="form-control" accept=".pdf,.png,.jpg" required>
    </div>
</div>