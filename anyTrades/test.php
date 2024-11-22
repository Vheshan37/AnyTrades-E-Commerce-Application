<script>
    // Checkout button process
    function buyCart(total) {
        var req = new XMLHttpRequest();

        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                if (req.responseText == "1") {
                    alert("Complete your user profile");
                    window.location = "userProfileEdit.php";
                } else {
                    var json_obj = req.responseText;
                    var obj = JSON.parse(json_obj);

                    // Payment completed. It can be a successful failure.
                    payhere.onCompleted = function onCompleted(orderId) {
                        console.log("Payment completed. OrderID:" + orderId);
                        // Note: validate the payment and show success or failure page to the customer

                        // saveSingleInvoice(obj["order_id"], obj["amount"], obj["email"], id);
                        saveCartInvoice();
                    };

                    // Payment window closed
                    payhere.onDismissed = function onDismissed() {
                        // Note: Prompt user to pay again or show an error page
                        console.log("Payment dismissed");
                    };

                    // Error occurred
                    payhere.onError = function onError(error) {
                        // Note: show an error page
                        console.log("Error:" + error);
                    };

                    // Put the payment variables here
                    var payment = {
                        sandbox: true,
                        merchant_id: "1221196", // Replace your Merchant ID
                        return_url: "http://localhost/anyTrades/home.php", // Important
                        cancel_url: "http://localhost/anyTrades/home.php", // Important
                        notify_url: "http://sample.com/notify",
                        order_id: obj["order_id"],
                        items: obj["item"],
                        amount: obj["amount"] + ".00",
                        currency: obj["currency"],
                        hash: obj["hash"], // *Replace with generated hash retrieved from backend
                        first_name: obj["fname"],
                        last_name: obj["lname"],
                        email: obj["email"],
                        phone: obj["email"],
                        address: obj["address"],
                        city: obj["city"],
                        country: obj["country"],
                        delivery_address: obj["address"],
                        delivery_city: obj["city"],
                        delivery_country: obj["country"],
                    };

                    // Show the payhere.js popup, when "PayHere Pay" is clicked
                    document.getElementById("payhere-payment").onclick = function(e) {
                        payhere.startPayment(payment);
                    };
                }
            }
        };

        req.open("GET", "buyCartProcess.php?total=" + total, true);
        req.send();
    }




    function saveCartInvoice() {
        var req = new XMLHttpRequest();

        req.onreadystatechange = function() {
            if (req.readyState == 4 && req.status == 200) {
                var responseText = req.responseText;
                if (responseText.startsWith("'") && responseText.endsWith("'")) {
                    responseText = req.responseText.slice(1, -1);
                }
                window.location = `checkout.php?inv_no=${responseText}`;
                alert(req.responseText);
            }
        };

        req.open("GET", "saveCartInvoiceProcess.php", true);
        req.send();
    }
</script>