<div id="invoice_calculator" class="card" hidden>
    <div class="card-header card-header-info">
        <h4 class="card-title ">Invoice financing calculator</h4>
    </div>
    <div class="card-body">
        <div class="mb-1 mt-1">
            <button id="swap" onclick="hide()" class="btn btn-primary">GO to Merchant cash advance (MCA) calculator</button>
        </div>
        <label for="invoice_cash_insert" >How much do you need?</label>
        <input id="invoice_cash_insert" class="input-value" value="$1000" type="text">
        <div class="p-1 border-bottom mb-2">
            <input id="invoice_cash_range" type="range" min="1000" max="150000" step="1000" value="1000">
            <div class="label-row small-labels mt-2">
                <label for="invoice_cash_range" style="width: 50%">$1000</label>
                <label for="invoice_cash_range" style="width: 50%; text-align: right">$150000</label>
            </div>
        </div>

        <label for="invoice_factorFee_insert">Estimated Factor Fee</label>
        <input id="invoice_factorFee_insert" class="input-value" value="1.00" maxlength="4" type="text">
        <div class="p-1 border-bottom mb-2">
            <input id="invoice_factorFee_range" type="range" min="1" max="3" step="0.01" value="1">
            <div class="label-row small-labels mt-2">
                <label for="invoice_factorFee_range" style="width: 50%">1</label>
                <label for="invoice_factorFee_range" style="width: 50%; text-align: right">3</label>
            </div>
        </div>

        <label for="invoice_due_insert">Invoice Due In (Weeks)</label>
        <input id="invoice_due_insert" class="input-value" value="1" type="text">
        <div class="p-1 border-bottom mt-2">
            <input id="invoice_due_range" type="range" min="1" max="12" step="1" value="1">
            <div class="label-row small-labels mt-2">
                <label for="invoice_due_range" style="width: 50%">1 Week</label>
                <label for="invoice_due_range" style="width: 50%; text-align: right">12 Weeks</label>
            </div>
        </div>

        <div class="container mt-2 p-2">
            <h4>Payments:</h4>
            <p id="invoice_payment" class="total">$500/ws</p>
            <h4>Reserve Amount:</h4>
            <p id="invoice_amount" class="total">$3200</p>
        </div>

    </div>
</div>
