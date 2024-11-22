<?php
require "connection.php";
if (isset($_GET["id"])) {

    $oid = $_GET["id"];
    $invoice_rs = Database::search("SELECT * FROM `invoice` WHERE `order_id`='" . $oid . "'");
    $invoice_data = $invoice_rs->fetch_assoc();

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
                                <div class="d-flex flex-column text-white text-end">
                                    <span class="">#ATP_<?php echo ($oid); ?></span>
                                    <span class=""><?php
                                                    echo ($invoice_data["date_time"]);
                                                    $hour = (explode(":", (explode(" ", $invoice_data["date_time"]))[1]))[0];
                                                    if ($hour > 11) {
                                                        echo (" PM");
                                                    } else {
                                                        echo (" AM");
                                                    }
                                                    ?></span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Image Header -->
                <!-- Header -->


                <div class="col-12 mt-2">
                    <div class="row">

                        <?php
                        $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $invoice_data["product_id"] . "'");
                        $img_data = $img_rs->fetch_assoc();
                        ?>

                        <!-- Product Preview -->
                        <div class="col-12 col-md-4 col-xl-3 col-xxl-2">
                            <div class="d-flex w-100 h-100 justify-content-center align-items-center border rounded border-secondary border-opacity-50 invoice-slider-container" style="width: 100%;">
                                <img src="<?php echo ($img_data["path"]); ?>" alt="" class="w-100" style="max-height: 300px; object-fit: contain;">
                            </div>
                        </div>
                        <!-- Product Preview -->

                        <?php

                        $purchas_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` INNER JOIN `user_has_address` ON `user_has_address`.`user_email`=`user`.`email` INNER JOIN `product` ON `product`.`id`=`invoice`.`product_id` WHERE `invoice`.`order_id`='" . $oid . "'");
                        $purchas_data = $purchas_rs->fetch_assoc();

                        $address_rs = Database::search("SELECT *,`city`.`name` AS `city` FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` INNER JOIN `user` ON `user`.`email`=`user_has_address`.`user_email` WHERE `email`='" . $invoice_data["user_email"] . "'");
                        $address_data = $address_rs->fetch_assoc();

                        if ($address_data["district_id"] == 2) {
                            $delivery = $purchas_data["delivery_in"];
                        } else {
                            $delivery = $purchas_data["delivery_out"];
                        }

                        ?>

                        <!-- Invoice Details -->
                        <div class="col-12 col-md-8 col-xl-9 col-xxl-10">
                            <div class="d-flex flex-column">

                                <div class="">
                                    <span class="fw-bold fs-5">Invoice To :</span>
                                    <span class=""><?php echo ($purchas_data["fname"] . " " . $purchas_data["lname"]); ?></span>
                                </div>

                                <div class="">
                                    <span class="fw-bold fs-4">Title :</span>
                                    <span class="fs-5"><?php echo ($purchas_data["title"]); ?></span>
                                </div>

                                <div class="">
                                    <span class="">Unit Price :</span>
                                    <span class="">Rs. <?php echo ($purchas_data["price"]); ?>.00</span>
                                </div>

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
                                    <span class="">Rs. <?php echo ($delivery + $purchas_data["price"]); ?>.00</span>
                                </div>

                                <div class="">
                                    <span class="">Delivery To :</span>
                                    <span class="">231/D, Deenapamunuwa, Urapola.</span>
                                </div>

                                <div class="">
                                    <div class="btn btn-primary rounded-0">TOTAL : Rs. <?php echo ($invoice_data["total"]); ?>.00</div>
                                </div>

                                <div class="col-12 bg-dark py-2 mt-2">
                                    <div class="d-flex justify-content-center">
                                        <span class="text-white">Thank you for using our service.</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Invoice Details -->

                    </div>
                </div>


            </div>
        </div>


        <?php include "footer.php"; ?>

        <script src="script.js"></script>

    </body>

    </html>
<?php

} else {
    header("Location:home.php");
}

?>