let invoiceVisible = false;
let mcaVisible = true;
let mcaType = 1;
let mcaLocalCash = 3000;
let mcaFactorFee = 1.14;
let mcaTerm = 3;

let mcaTermInfo;
let mcaPaymentForDays;
let mcaPaymentForWeeks;

let invoiceCash = 1000;
let invoiceFactorFee = 1.00;
let invoiceDue = 1;
countOfDays();

function hide() {
    if(mcaVisible === true) {
        document.getElementById('mca_calculator').hidden = true;
        document.getElementById('invoice_calculator').hidden = false;
        mcaVisible = false;
    } else {
        document.getElementById('mca_calculator').hidden = false;
        document.getElementById('invoice_calculator').hidden = true;
        mcaVisible = true;
    }
}

function countOfDays(){
    $.get({
        url:'term-days',
        data:{
            months: mcaTerm,
        },
        success: response => mcaTermInfo = response,
        error: errors => console.log(errors),
    }).then(() => {
        calculatePayment();
    });
}

function showPayment() {
    let text;
    if(mcaType === 1) {
        text = '$'+Math.round(mcaPaymentForDays)+'/day';
    } else {
        text = '$'+Math.round(mcaPaymentForWeeks)+'/week';
    }
    $('#mca_payment').text(text);
}

function calculatePayment() {


    mcaPaymentForDays = (mcaLocalCash * mcaFactorFee) / Math.round(mcaTermInfo.days);
    mcaPaymentForWeeks = (mcaLocalCash * mcaFactorFee) / (Math.round(mcaTermInfo.days) / 5);
    showPayment();
}

setTimeout(function () {


    $('#per_day').change(() => {
        mcaType = 1;
        showPayment();
    });
    $('#per_week').change(() => {
        mcaType = 2;
        showPayment();
    });

    $('#mca_cash_insert').change(function () {
        let buffer = $('#mca_cash_insert').val().replace(/\D+/g,"");
        buffer = Math.round(buffer/1000) * 1000;
        if (buffer >= 3000 && buffer <= 500000) {
            mcaLocalCash = buffer;
            $('#mca_cash_range').val(mcaLocalCash);
            $('#mca_cash_insert').val('$'+mcaLocalCash);
            calculatePayment();
        } else {
            $('#mca_cash_insert').val('$'+mcaLocalCash);
        }
    });
    $('#mca_cash_range').change(function () {
        mcaLocalCash = $('#mca_cash_range').val();
        $('#mca_cash_insert').val('$'+mcaLocalCash);
        calculatePayment();
    });

    $('#mca_factorFee_insert').change(function () {
        let buffer = $('#mca_factorFee_insert').val();

        if (buffer >= 1.14 && buffer <= 1.35) {
            mcaFactorFee = buffer;
            $('#mca_factorFee_range').val(buffer);
            calculatePayment();
        } else {
            $('#mca_factorFee_insert').val(mcaFactorFee);
        }
    });
    $('#mca_factorFee_range').change(function () {
        mcaFactorFee = $('#mca_factorFee_range').val();
        $('#mca_factorFee_insert').val(mcaFactorFee);
        calculatePayment();
    });

    $('#mca_term_insert').change(function () {
        let buffer = $('#mca_term_insert').val();
        if (buffer >= 3 && buffer <= 18) {
            mcaTerm = buffer;
            $('#mca_term_range').val(buffer);
            countOfDays();
        } else {
            $('#mca_term_insert').val(mcaTerm);
        }
    });
    $('#mca_term_range').change(function () {
        mcaTerm = $('#mca_term_range').val();
        $('#mca_term_insert').val(mcaTerm);
        countOfDays();
    });



    $('#invoice_cash_insert').change(function () {
        let buffer = $('#invoice_cash_insert').val().replace(/\D+/g,"");
        buffer = Math.round(buffer/1000) * 1000;
        if (buffer >= 1000 && buffer <= 150000) {
            invoiceCash = buffer;
            $('#invoice_cash_range').val(invoiceCash);
            $('#invoice_cash_insert').val('$'+invoiceCash);
            calculate();
        } else {
            $('#invoice_cash_insert').val('$'+invoiceCash);
        }
    });
    $('#invoice_cash_range').change(function () {
        invoiceCash = $('#invoice_cash_range').val();
        $('#invoice_cash_insert').val('$'+invoiceCash);
        calculate();
    });

    $('#invoice_factorFee_insert').change(function () {
        let buffer = $('#invoice_factorFee_insert').val();

        if (buffer >= 1 && buffer <= 3) {
            invoiceFactorFee = buffer;
            $('#invoice_factorFee_range').val(invoiceFactorFee);
            calculate();
        } else {
            $('#invoice_factorFee_insert').val(invoiceFactorFee);
        }
    });
    $('#invoice_factorFee_range').change(function () {
        invoiceFactorFee = $('#invoice_factorFee_range').val();
        $('#invoice_factorFee_insert').val(invoiceFactorFee);
        calculate();
    });

    $('#invoice_due_insert').change(function () {
        let buffer = $('#invoice_due_insert').val().replace(/\D+/g,"");
        if (buffer >= 1 && buffer <= 12) {
            invoiceDue = buffer;
            $('#invoice_due_range').val(invoiceDue);
            calculate();
        } else {
            $('#invoice_due_range').val(invoiceDue);
        }
    });
    $('#invoice_due_range').change(function () {
        invoiceDue = $('#invoice_due_range').val();
        $('#invoice_due_insert').val(invoiceDue);
        calculate();
    });

    function calculate() {
        let resultPayments = Math.trunc(invoiceCash * invoiceFactorFee * (0.01 * invoiceDue));
        let resultAmount = (invoiceCash * 0.2) - resultPayments;
        $('#invoice_payment').text('$' + resultPayments + '/wk');
        $('#invoice_amount').text('$' + resultAmount);
    }
},500);


