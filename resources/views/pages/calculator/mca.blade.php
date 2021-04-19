<div id="mca_calculator" class="card">
    <div class="card-header card-header-primary">
        <h4 class="card-header">Merchant cash advance (MCA) calculator</h4>
    </div>
    <div class="card-body">
        <div class="mb-1 mt-1">
            <button id="swap" onclick="hide()" class="btn btn-info">GO to Invoice financing calculator</button>
        </div>
        <label for="mca_cash_insert" >How much do you need?</label>
        <input id="mca_cash_insert" class="input-value" value="$3000" type="text">
        <div class="p-1 border-bottom mb-2">
            <input id="mca_cash_range" type="range" min="3000" max="500000" step="1000" value="3000">
            <div  class="label-row small-labels mt-2">
                <label for="mca_cash_range" style="width: 50%">$3000</label>
                <label for="mca_cash_range" style="width: 50%; text-align: right">$500000</label>
            </div>
        </div>

        <label for="mca_factorFee_insert">Estimated Factor Rate</label>
        <input id="mca_factorFee_insert" class="input-value" value="1.14"  maxlength="4" type="text">
        <div class="p-1 border-bottom mb-2">
            <input id="mca_factorFee_range" type="range" min="1.14" max="1.35" step="0.01" value="1.14">
            <div  class="label-row small-labels mt-2">
                <label for="mca_factorFee_range" style="width: 50%">1.14</label>
                <label for="mca_factorFee_range" style="width: 50%; text-align: right">1.35</label>
            </div>
        </div>

        <label for="mca_term_insert" >Estimated Term</label>
        <input id="mca_term_insert" class="input-value" value="3" type="text">
        <div class="p-1 border-bottom mb-2">
            <input id="mca_term_range" type="range" min="3" max="18" step="1" value="3">
            <div  class="label-row small-labels mt-2">
                <label for="mca_term_range" style="width: 50%">3 Months</label>
                <label for="mca_term_range" style="width: 50%; text-align: right">18 Months</label>
            </div>
        </div>

        <div class="container mt-2 p-2">
           <div class="mb-2">
               <input type="radio" id="per_day" name="mca_type" checked>
               <label  for="per_day">Day</label>
               <input class="with-gap" type="radio" id="per_week" name="mca_type" >
               <label  for="per_week">Week</label>
           </div>
            <h4>Payments:</h4>
            <p id="mca_payment" class="total">$54/day</p>
        </div>
    </div>
</div>

