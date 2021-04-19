$(document).ready(function () {
    function showNotification(type, message) {
        $.notify(
            {
                icon: "add_alert",
                message: message
            },
            {
                type: type,
                timer: 3000,
                placement: {
                    from: "top",
                    align: "center"
                }
            }
        );
    }

    function off() {
        document.getElementById("overlay").style.display = "none";
    }

    $("#spinner-on").click(function () {
        document.getElementById("overlay").style.display = "flex";
    });
    $("#accounts-get-access-token").text(localStorage.getItem("accessToken"));
    $.validator.addMethod(
        "alphaSpace",
        function (value, element) {
            return this.optional(element) || /^[a-z\s]+$/i.test(value);
        },
        "This field must contain only letters and spaces"
    );
    $("#btn-asset-report").validate({
        rules: {
            days_requested: {
                required: true
            }
        }
    });

    $("#create-link-token").validate({
        rules: {
            client_name: {
                required: true,
                alphaSpace: true
            },
            legal_name: {
                required: true,
                alphaSpace: true
            },
            phone_number: {
                required: true
            },
            email_address: {
                required: true,
                email: true
            },
            products: {
                required: true
            },
            country_codes: {
                required: true
            },
            language: {
                required: true
            }
        }
    });

    $("#pl-frm-customer").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            company: {
                required: true
            },
            street_address1: {
                required: true
            },
            city: {
                required: true
            },
            state_code: {
                required: true
            },
            zip_code: {
                required: true
            }
        }
    });

    function BindDataToTable(d, obj) {
        var keys = Object.keys(d[0]);
        var table = document.createElement("table");
        table.className = "table";
        var trHead = document.createElement("tr");
        trHead.className = "text-primary";
        jQuery(keys).each((index, item) => {
            var th = document.createElement("th");
            th.innerHTML = item;
            trHead.appendChild(th);
        });
        table.appendChild(trHead);
        for (var i = 0; i < d.length; i++) {
            var tr = document.createElement("tr");
            jQuery(keys).each((index, item) => {
                var td = document.createElement("td");
                td.innerHTML = d[i][item];
                tr.appendChild(td);
            });
            table.appendChild(tr);
        }

        jQuery(obj).append(table);
    }

    function getCustomers() {
        $.get({
            url: "/api/customers",
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                // When AJAX call is successfuly
                var customers = data.customers;

                var columns = "";
                customers.forEach(function (e) {
                    var column =
                        "<tr><td>" +
                        e.id +
                        "</td><td>" +
                        e.client_name +
                        "</td><td>" +
                        e.legal_name +
                        "</td><td>" +
                        e.phone_number +
                        "</td><td>" +
                        e.email_address +
                        "</td><td>" +
                        e.language +
                        "</td><td>" +
                        e.country_code +
                        "</td><td>" +
                        ["auth", "transactions"] +
                        "</td><td>" +
                        "</td></tr>";
                    columns += column;
                });

                var table = $(
                    "<table class='table'><tr><th>ID</th><th>Client Name </th><th>L egal Name</th><th> Phone Number</th><th> Email</th><th> Language</th><th> Country Code</th><th> Products</th></tr>" +
                    columns +
                    "</table>"
                );
                $("#tableCustomers").html(table);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    }

    getCustomers();

    $("#btn-create-token").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("create-link-token");
        var fd = new FormData(myform);

        if ($("#create-link-token").valid()) {
            $("#spinnerModal").modal("show");
            $.post({
                url: "/api/plaid-testing",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    $("#link-create-success").css("display", "block");
                    // When AJAX call is successfuly
                    console.log("AJAX call successful.");
                    console.log(data);
                    getCustomers();
                    $("#spinnerModal").modal("hide");
                    showNotification(
                        "success",
                        "Query completed successfully."
                    );
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log("AJAX call failed.");
                    console.log(textStatus + ": " + errorThrown);
                    $("#spinnerModal").modal("hide");
                },
                complete: function () {
                    // When AJAX call is complete, will fire upon success or when error is thrown
                    console.log("AJAX call completed");
                }
            });
        }
    });

    $("#btn-get-link-token").click(function (e) {
        e.preventDefault();
        $("#spinnerModal").modal("show");
        $.get({
            url: "/api/plaid-testing",
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                showNotification("success", "Query completed successfully.");
                $("#tableElement").text("");
                BindDataToTable(data.plaidAccounts, "#tableElement");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
                $("#spinnerModal").modal("hide");
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
                $("#spinnerModal").modal("hide");
            }
        });
    });
    $("#modal-dismiss").click(function () {
        $("#spinnerModal").modal("hide");
    });

    $("#btn-create-public-token").click(function (e) {
        var myform = document.getElementById("create-public-token");
        var fd = new FormData(myform);
        e.preventDefault();
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/public-token",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#public-token-result").html(data.publicToken);
                let publicToken = data.publicToken;
                publicToken = JSON.parse(publicToken);
                localStorage.setItem("publicToken", publicToken.public_token);
                $("#spinnerModal").modal("hide");
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
                $("#spinnerModal").modal("hide");
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-exchange-public-token").click(function (e) {
        let publicToken = localStorage.getItem("publicToken");
        var fd = new FormData();
        fd.append("public_token", publicToken);
        e.preventDefault();
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/public-token-exchange",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                let accessToken = data.accessToken;
                accessToken = JSON.parse(accessToken);
                localStorage.setItem("accessToken", accessToken.access_token);
                $("#public-token-exchange-result").html(data.accessToken);
                $("#spinnerModal").modal("hide");
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
                $("#spinnerModal").modal("hide");
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-fetch-item").click(function (e) {
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData();
        fd.append("access_token", accessToken);
        e.preventDefault();
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/item",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#fetch-item-result").html(data.item);
                $("#spinnerModal").modal("hide");
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-account-get").click(function (e) {
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData();
        fd.append("access_token", accessToken);
        e.preventDefault();
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/account",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                var accounts = data.accounts.accounts;

                var columns = "";
                var $dropdown = $("#fbd-account_ids");
                $.each(accounts, function (i) {
                    $dropdown.append(
                        $("<option />")
                            .val(accounts[i].account_id)
                            .text(accounts[i].account_id)
                    );
                });
                accounts.forEach(function (e) {
                    var column =
                        "<tr><td>" +
                        e.account_id +
                        "</td><td>" +
                        e.balances.available +
                        "</td><td>" +
                        e.balances.current +
                        "</td><td>" +
                        e.balances.iso_currency_code +
                        "</td><td>" +
                        e.name +
                        "</td><td>" +
                        e.subtype +
                        "</td><td>" +
                        e.type +
                        "</td><td>" +
                        e.official_name +
                        "</td></tr>";
                    columns += column;
                });

                var table = $(
                    "<table><tr><th>account_id</th><th>Available Balance</th><th>Current Balance</th><th>iso_currency_code</th><th>name</th><th>subtype</th><th>type</th><th>official_name</th></tr>" +
                    columns +
                    "</table>"
                );
                $("#account-get-result").append(table);
                $("#spinnerModal").modal("hide");
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
                $("#spinnerModal").modal("hide");
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#pl-create-customer").click(function (e) {
        var myform = document.getElementById("pl-frm-customer");
        var fd = new FormData(myform);
        e.preventDefault();

        if ($("#pl-frm-customer").valid()) {
            $("#spinnerModal").modal("show");
            $.post({
                url: "/api/payliance/customers",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    $("#fetch-item-result").html(data.item);
                    $("#spinnerModal").modal("hide");
                    showNotification(
                        "success",
                        "Query completed successfully."
                    );
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log("AJAX call failed.");
                    console.log(textStatus + ": " + errorThrown);
                },
                complete: function () {
                    // When AJAX call is complete, will fire upon success or when error is thrown
                    console.log("AJAX call completed");
                }
            });
        }
    });
    $("#btn-submit-auth-token").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("submit-auth-token")
        var fd = new FormData(myform)
        $("#submit-auth-token-result").html('')

        $.post({
            url: "api/submit-auth-token",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (response.code === 200) {
                    const {apiKey, authenticatedAs} = response.data
                    $("#submit-auth-token-result").append(`
                        <p>Status: ${response.code}</p>
                        <p>Api Key: ${apiKey}</p>
                        <p>Authenticated as: ${authenticatedAs}</p>
                    `)
                } else
                    $("#submit-auth-token-result").append(`<p>oops... Some thing went wrong</p>`)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-fetch-trans").click(function (e) {
        var fd = new FormData();
        let accessToken = localStorage.getItem("accessToken");
        fd.append("access_token", accessToken);
        fd.append("start_date", $("#start_date").val());
        fd.append("end_date", $("#end_date").val());
        e.preventDefault();

        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid-transactions-get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                $("#fetch-trans-result").html(
                    JSON.stringify(data.transactions)
                );
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-account-balance-get").click(function (e) {
        var myform = document.getElementById("fbd-form");
        var fd = new FormData(myform);
        let accessToken = localStorage.getItem("accessToken");
        fd.append("access_token", accessToken);

        e.preventDefault();

        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/account-balance-get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                $("#fbd-result").html(JSON.stringify(data.accounts));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-retrieve-identity").click(function (e) {
        var fd = new FormData();
        let accessToken = localStorage.getItem("accessToken");
        fd.append("access_token", accessToken);

        e.preventDefault();

        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/identity-get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                $("#ig-result").html(JSON.stringify(data.data));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-asset-report").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("asset-report-form");
        var fd = new FormData(myform);
        let accessToken = localStorage.getItem("accessToken");
        fd.append("access_token", accessToken);

        if ($("#asset-report-form").valid()) {
            $("#spinnerModal").modal("show");
            $.post({
                url: "/api/plaid/asset_report/create",
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    $("#spinnerModal").modal("hide");
                    localStorage.setItem(
                        "asset_report_token",
                        data.asset.asset_report_token
                    );
                    $("#asset-report-result").html(JSON.stringify(data.asset));
                    showNotification(
                        "success",
                        "Query completed successfully."
                    );
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    // When AJAX call has failed
                    console.log("AJAX call failed.");
                    console.log(textStatus + ": " + errorThrown);
                },
                complete: function () {
                    // When AJAX call is complete, will fire upon success or when error is thrown
                    console.log("AJAX call completed");
                }
            });
        }
    });

    $("#btn-retrieve-report").click(function (e) {
        e.preventDefault();
        var fd = new FormData();
        let accessToken = localStorage.getItem("accessToken");
        let asset_report_token = localStorage.getItem("asset_report_token");
        fd.append("access_token", accessToken);
        fd.append("asset_report_token", asset_report_token);
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/asset_report/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#retrieve-report-result").html(JSON.stringify(data.asset));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-retrieve-pdf").click(function (e) {
        e.preventDefault();
        var fd = new FormData();
        let accessToken = localStorage.getItem("accessToken");
        let asset_report_token = localStorage.getItem("asset_report_token");
        fd.append("access_token", accessToken);
        fd.append("asset_report_token", asset_report_token);
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/asset_report/pdf/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#retrieve-pdf-result").html(JSON.stringify(data.asset));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-remove-asset").click(function (e) {
        e.preventDefault();
        var fd = new FormData();
        let accessToken = localStorage.getItem("accessToken");
        let asset_report_token = localStorage.getItem("asset_report_token");
        fd.append("access_token", accessToken);
        fd.append("asset_report_token", asset_report_token);
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/asset_report/remove",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#remove-asset-result").html(JSON.stringify(data.asset));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });
    $("#btn-audit-create").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("audit-create-form");
        var fd = new FormData(myform);
        let accessToken = localStorage.getItem("accessToken");
        let asset_report_token = localStorage.getItem("asset_report_token");
        fd.append("access_token", accessToken);
        fd.append("asset_report_token", asset_report_token);
        $("#spinnerModal").modal("show");
        $("#remove-asset-result").html('Loading...');
        $.post({
            url: "/api/plaid/asset_report/audit_copy/create",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#remove-asset-result").html(JSON.stringify(data.asset));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-wyre-account-get").click(function (e) {
        e.preventDefault()
        var myform = document.getElementById("wyre-account-get")
        var fd = new FormData(myform)
        $("#wyre-account-get-result").html('Loading...');

        $.get({
            url: "api/wyre-account",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (response.code === 200) {
                    const {data, code} = response
                    $("#wyre-account-get-result").append(`
                        <p>Status: ${code}</p>
                        <p>Response: ${data}</p>
                    `)
                    showNotification("success", "Query completed successfully.");
                } else
                    $("#wyre-account-get-result").append(`<p>oops... Some thing went wrong</p>`)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });
    $("#btn-auth-get").click(function (e) {
        e.preventDefault()
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData();
        fd.append("_token", accessToken);
        $("#auth-get-result").html('')
        $("#spinnerModal").modal("show");
        $("#auth-get-result").html('Loading...');
        $.post({
            url: "/api/plaid/auth/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {

                    // const {data, code} = response
                    $("#auth-get-result").html(JSON.stringify(response));
                    /*  $("#investment-holdings-get-result").append(`
                          <p>Status: ${code}</p>
                          <p>Response: ${data}</p>
                      `)*/
                    showNotification("success", "Query completed successfully.");
                } else
                    $("#auth-get-result").html(`<p>oops... Some thing went wrong</p>`)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });
    $("#btn-investment-transactions-get").click(function (e) {
        e.preventDefault()
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData()
        fd.append("_token", accessToken);
        $("#identity-get-result").html('Loading...');
        $("#spinnerModal").modal("show");

        $.post({
            url: "/api/plaid/investments/transactions/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {

                    $('#investment-transactions-get-result').html(JSON.stringify(response));
                    showNotification("success", "Query completed successfully.");
                } else
                    $("#investment-transactions-get-result").html(`<p>oops... Some thing went wrong</p>`)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });


    $("#btn-identity-get").click(function (e) {
        e.preventDefault()
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData()
        fd.append("_token", accessToken);
        $("#identity-get-result").html('Loading...');
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/identity/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {

                    $('#identity-get-result').html(JSON.stringify(response));
                    showNotification("success", "Query completed successfully.");
                } else
                    $("#identity-get-result").html(`<p>oops... Some thing went wrong</p>`);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-investment-holdings-get").click(function (e) {
        e.preventDefault()
        var myform = document.getElementById("investment-holdings-get")
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData(myform)
        fd.append("_token", accessToken);
        $("#btn-investment-holdings-get-result").html('Loading...')
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/investments/holdings/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                if (response) {
                    // const {data, code} = response
                    $("#btn-investment-holdings-get-result").html(JSON.stringify(response));

                    /*  $("#investment-holdings-get-result").append(`
                          <p>Status: ${code}</p>
                          <p>Response: ${data}</p>
                      `)*/
                } else {
                    $("#btn-investment-holdings-get-result").append(`<p>oops... Some thing went wrong</p>`)
                }
                showNotification("success", "Query completed successfully.");
                $("#spinnerModal").modal("hide");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-liabilities-get").click(function (e) {
        e.preventDefault()
        var myform = document.getElementById("liabilities-get")
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData(myform)
        fd.append("_token", accessToken);
        $("#liabilities-get-result").html('Loading...')
        $("#spinnerModal").modal("show");


        $.post({
            url: "/api/plaid/liabilities/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {
                    $('#liabilities-get-result').html(JSON.stringify(response));

                } else {
                    $("#liabilities-get-result").append(`<p>oops... Some thing went wrong</p>`)
                }
                showNotification("success", "Query completed successfully.");

            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-institutions-get").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("institutions-get")
        var fd = new FormData(myform)
        $("#institutions-get-result").html('Loading...')
        $("#spinnerModal").modal("show");

        $.post({
            url: "/api/plaid/institutions/get",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {
                    $('#institutions-get-result').html(JSON.stringify(response));
                } else {
                    $("#institutions-get-result").append(`<p>oops... Some thing went wrong</p>`)
                }

                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-institutions-get-by-id").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("institutions-get-by-id")
        var fd = new FormData(myform)
        $("#institutions-get-by-id-result").html('Loading...')
        $("#spinnerModal").modal("show");

        $.post({
            url: "/api/plaid/institutions/get_by_id",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {
                    $('#institutions-get-by-id-result').html(JSON.stringify(response));
                } else {
                    $("#institutions-get-by-id-result").append(`<p>oops... Some thing went wrong</p>`)
                }

                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-institutions-search").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("institutions-search")
        var fd = new FormData(myform)
        $("#institutions-search-result").html('Loading...')
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/institutions/search",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {
                    $('#institutions-search-result').html(JSON.stringify(response));
                } else {
                    $("#institutions-search-result").append(`<p>oops... Some thing went wrong</p>`)
                }

                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });

    });

    $("#btn-item-remove").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("institutions-search")
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData(myform)
        fd.append("_token", accessToken);
        $("#item-remove-result").html('Loading...')
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/item/remove",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {
                    $('#item-remove-result').html(JSON.stringify(response));
                } else {
                    $("#item-remove-result").append(`<p>oops... Some thing went wrong</p>`)
                }

                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });

    });


    $("#btn-item-balance").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("institutions-search")
        let accessToken = localStorage.getItem("accessToken");
        var fd = new FormData(myform)
        fd.append("_token", accessToken);
        $("#item-balance-result").html('Loading...')
        $("#spinnerModal").modal("show");
        $.post({
            url: "/api/plaid/account/balance",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (response, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");
                if (response) {
                    $('#item-balance-result').html(JSON.stringify(response));
                } else {
                    $("#item-balance-result").append(`<p>oops... Some thing went wrong</p>`)
                }

                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });

    });

    $("#btn-process-create").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("process-create-form");
        var fd = new FormData(myform);
        let accessToken = localStorage.getItem("accessToken");
        fd.append("_token", accessToken);
        $("#spinnerModal").modal("show");
        $("#process-create-result").html('Loading...');
        $.post({
            url: "/api/plaid/processor/token/create",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#process-create-result").html(JSON.stringify(data));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-bank-account-create").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("stripe-bank-create-form");
        var fd = new FormData(myform);
        let accessToken = localStorage.getItem("accessToken");
        fd.append("_token", accessToken);
        $("#spinnerModal").modal("show");
        $("#bank-account-create-result").html('Loading...');
        $.post({
            url: "/api/plaid/bank/account/create",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#bank-account-create-result").html(JSON.stringify(data));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });

    $("#btn-dwello-account-create").click(function (e) {
        e.preventDefault();
        var myform = document.getElementById("dwello-create-form");
        var fd = new FormData(myform);
        $("#spinnerModal").modal("show");
        $("#dwello-account-create-result").html('Loading...');
        $.post({
            url: "/api/plaid/dwolla/create",
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                $("#spinnerModal").modal("hide");

                $("#dwello-account-create-result").html(JSON.stringify(data));
                showNotification("success", "Query completed successfully.");
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // When AJAX call has failed
                console.log("AJAX call failed.");
                console.log(textStatus + ": " + errorThrown);
            },
            complete: function () {
                // When AJAX call is complete, will fire upon success or when error is thrown
                console.log("AJAX call completed");
            }
        });
    });
});
