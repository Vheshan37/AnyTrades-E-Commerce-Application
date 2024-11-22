<?php

session_start();
require "connection.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice | AnyTrades</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="icomoon.css" />
</head>

<body class="min-vh-100">

    <?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row">

            <!-- Header -->
            <div class="col-12 bg-dark p-1">
                <div class="px-2 d-flex justify-content-between text-white align-items-center">
                    <h1 class="c-default" style="font-family: arial; font-weight: bolder;">AnyTrades</h1>
                    <div class="d-flex align-items-center gap-2 c-pointer invoice-download-button">
                        <i class="icon-file_download_black_24dp fs-5"></i>
                        <span class="">Download Invoice</span>
                    </div>
                </div>
            </div>

            <!-- Image Header -->
            <div class="col-12">
                <div class="row position-relative" style="max-height: 400px; height: 100%;">

                    <img src="resources/bg3.jpg" class="p-0" style="width: 100%; object-fit: cover; background-position: center; height: 100%;">

                    <div class="position-absolute bottom-0 w-100 mb-2">
                        <div class="d-flex justify-content-between">
                            <a href="home.php" class="d-flex justify-content-center align-items-center btn btn-warning">Continue Shopping</a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Image Header -->
            <!-- Header -->


            <?php

            $inv_no = $_GET["inv_no"];

            $checkout_obj = $_SESSION["checkout"];
            $user = $_SESSION["at_u"];
            $products = $checkout_obj->product;
            $cart_items = $checkout_obj->cart;
            $amount = $checkout_obj->amount;

            $totalTable = Database::search("SELECT SUM(total) AS total FROM `invoice` WHERE order_id='" . $inv_no . "'");
            $totalData = $totalTable->fetch_assoc();

            ?>
            <div class="d-flex justify-content-center mt-2 border-bottom border-primary">
                <div class="btn btn-primary rounded-0 rounded-top">Total Amount : Rs. <?php echo ($totalData["total"]); ?>.00</div>
            </div>
            <?php

            $invoiceRs = Database::search("SELECT * FROM invoice INNER JOIN product ON product.id=invoice.product_id WHERE invoice.order_id='" . $inv_no . "'");
            $invoice_rows = $invoiceRs->num_rows;

            for ($x = 0; $x < $invoice_rows; $x++) {
                $invoiceData = $invoiceRs->fetch_assoc();
                $imageRs = Database::search("SELECT * FROM image WHERE product_id='" . $invoiceData["product_id"] . "' ORDER BY RAND () LIMIT 1");
                $imageData = $imageRs->fetch_assoc();
            ?>
                <div class="col-12 mt-2">
                    <div class="row border-bottom pb-2 border-dark">

                        <!-- Product Preview -->
                        <div class="col-12 col-md-4 col-xl-3 col-xxl-2">
                            <div class="d-flex w-100 h-100 justify-content-center align-items-center border rounded border-secondary border-opacity-50 invoice-slider-container overflow-hidden" style="width: 100%;">
                                <img src="<?php echo ($imageData["path"]); ?>" alt="" class="w-100" style="max-height: 300px; object-fit: contain;">
                            </div>
                        </div>
                        <!-- Product Preview -->


                        <!-- Invoice Details -->
                        <div class="col-12 col-md-8 col-xl-9 col-xxl-10">
                            <div class="d-flex flex-column">

                                <div class="">
                                    <span class="fw-bold fs-5">Invoice To :</span>
                                    <span class=""><?php echo ($user["fname"] . " " . $user["lname"]); ?></span>
                                </div>

                                <div class="">
                                    <span class="fw-bold fs-4">Title :</span>
                                    <span class="fs-5"><?php echo ($invoiceData["title"]); ?></span>
                                </div>

                                <div class="">
                                    <span class="">Unit Price :</span>
                                    <span class="">Rs. <?php echo ($invoiceData["price"]); ?>.00</span>
                                </div>

                                <?php
                                $address_rs = Database::search("SELECT *,`city`.`name` AS `city` FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` INNER JOIN `user` ON `user`.`email`=`user_has_address`.`user_email` WHERE 
                                `email`='" . $user["email"] . "'");

                                $address_data = $address_rs->fetch_assoc();

                                if ($address_data["district_id"] == 2) {
                                    $delivery = $invoiceData["delivery_in"];
                                } else {
                                    $delivery = $invoiceData["delivery_out"];
                                }

                                // echo (json_encode($products));
                                // echo (json_encode($cart_items));


                                $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $inv_no . "'");
                                $invoice_data = $invoice_rs->fetch_assoc();

                                if (!empty($address_data["line3"])) {
                                    $address = $address_data["line1"] . ", " . $address_data["line2"] . ", " . $address_data["line3"] . ".";
                                } else {
                                    $address = $address_data["line1"] . ", " . $address_data["line2"] . ".";
                                }

                                ?>

                                <div class="">
                                    <span class="">Delivery Price :</span>
                                    <span class="">Rs. <?php echo ($delivery); ?>.00</span>
                                </div>

                                <div class="">
                                    <span class="">Items :</span>
                                    <span class=""><?php echo ($invoice_data["qty"]); ?></span>
                                </div>

                                <div class="">
                                    <span class="">Sub Total :</span>
                                    <span class="">Rs. <?php echo ($invoiceData["price"] + $delivery); ?>.00</span>
                                </div>

                                <div class="">
                                    <span class="">Delivery To :</span>
                                    <span class=""><?php echo ($address); ?></span>
                                </div>

                            </div>
                        </div>
                        <!-- Invoice Details -->

                    </div>
                </div>
            <?php
            }

            ?>


        </div>
    </div>


    <?php include "footer.php"; ?>

    <script src="script.js"></script>

</body>

</html>