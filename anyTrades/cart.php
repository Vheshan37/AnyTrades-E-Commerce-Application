<?php

require "connection.php";
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | AnyTrades</title>
    <!-- CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="demo-files/demo.css" />
    <link rel="stylesheet" href="icomoon.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body>

    <?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php"; ?>

            <div class="col-12 py-2">
                <div class="row d-flex align-items-center">

                    <div class="col-6">
                        <div class="d-flex justify-content-start align-items-center gap-2 text-success fs-2">
                            <span class="fw-bold">Cart</span>
                            <i class="icon-cart"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-end">
                            <input type="text" placeholder="Search in Cart..." class="p-2 text-center cart-search" />
                        </div>
                    </div>


                </div>
            </div>

            <?php

            $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
            $cart_num = $cart_rs->num_rows;

            if ($cart_num > 0) {
            ?>

                <div class="col-12 my-2">
                    <div class="d-flex gap-1 justify-content-between pe-3">

                        <div class="position-fixed end-0 mt-2 bg-secondary py-3 ps-1 d-flex align-items-center c-pointer d-block d-lg-none" style="border-radius: 5px 0 0 5px;" id="summery_open">
                            <i class="icon-left-arrow-svgrepo-com text-white"></i>
                        </div>

                        <!-- Cart Product View Area -->
                        <div class="col-12 col-lg-8 border border-1 py-2 px-4 rounded border-dark d-flex flex-column gap-3" style="height: 85vh; overflow-y: scroll; overflow-x: hidden;">

                            <?php

                            $delivery_total = 0;
                            $item_price = 0;
                            $discount = 0;

                            for ($x = 0; $x < $cart_num; $x++) {
                                $cart_data = $cart_rs->fetch_assoc();
                                $product_rs = Database::search("SELECT *,`product`.`id` AS `product`,`product`.`qty` AS `stock` FROM `product` INNER JOIN `cart` ON `cart`.`product_id`=`product`.`id` WHERE `cart`.`id`='" . $cart_data["id"] . "'");
                                $product_data = $product_rs->fetch_assoc();

                                $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["product_id"] . "'");
                                $img_data = $img_rs->fetch_assoc();

                                $address_rs = Database::search("SELECT `district`.`id` AS `did` FROM `user_has_address` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` INNER JOIN `district` ON `city`.`district_id`=`district`.`id` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                $address_data = $address_rs->fetch_assoc();
                                $did = $address_data["did"];

                                $delivery;
                                if ($did == "2") {
                                    $delivery = $product_data["delivery_in"];
                                } else {
                                    $delivery = $product_data["delivery_out"];
                                }

                                $delivery_total = $delivery + $delivery_total;

                                $old_price = $product_data["price"] + (($product_data["price"] / 100) * 5);

                            ?>
                                <div class="col-12 border border-1 mid-content rounded p-2 border-secondary position-relative shadow">
                                    <div class="row">

                                        <div class="position-absolute start-0 top-0 m-3 cart-watchlist" onclick="addToWatchlist('<?php echo ($product_data['product_id']); ?>');">
                                            <i class="icon-heart"></i>
                                        </div>

                                        <!-- Image Side -->
                                        <div class="col-12 col-xl-5">
                                            <div class="d-flex flex-column align-items-center w-100">

                                                <div class="col-12 d-flex justify-content-center">
                                                    <div class="row">
                                                        <img src="<?php echo ($img_data["path"]); ?>" style="height: 200px; object-fit: contain;" title="<?php echo ($product_data["desc"]); ?>" />
                                                    </div>
                                                </div>

                                                <div class="col-12 d-flex justify-content-center cart-qty my-1">
                                                    <span class="" onclick="cartQty('-',<?php echo ($product_data['product_id']); ?>,<?php echo ($product_data['stock']); ?>);">-</span>
                                                    <input type="text" value="<?php echo ($cart_data["qty"]); ?>" class="text-center" readonly id="cartQty<?php echo ($product_data['product_id']); ?>" />
                                                    <span class="" onclick="cartQty('+',<?php echo ($product_data['product_id']); ?>,<?php echo ($product_data['stock']); ?>);">+</span>
                                                </div>

                                                <!-- Btn Area in the Cart -->
                                                <div class="col-12 mt-2 mb-1">
                                                    <div class="row">

                                                        <div class="col-6 d-grid">
                                                            <button class="btn btn-outline-success" style="border-radius: 100vh;" onclick="singleProductView('<?php echo ($product_data['product']); ?>');">Buy Now</button>
                                                        </div>
                                                        <div class="col-6 d-grid">
                                                            <button class="btn btn-outline-danger" style="border-radius: 100vh;" onclick="removeFromCart('<?php echo ($cart_data['id']); ?>');">Remove</button>
                                                        </div>

                                                    </div>
                                                </div>
                                                <!-- Btn Area in the Cart -->

                                            </div>
                                        </div>
                                        <!-- Image Side -->



                                        <!-- Details Side -->
                                        <div class="col-xl-7 col-12">
                                            <div class="row border rounded w-100 h-100 border-1 border-secondary d-flex flex-column p-1 mid-content">

                                                <span class="fs-3 fw-bold nowrap" title="<?php echo ($product_data["title"]); ?>"><?php echo ($product_data["title"]); ?></span>
                                                <span class="">Rs. <?php echo ($product_data["price"]); ?> .00 + <?php echo ($delivery) ?>.00 | <span class="fw-bold text-decoration-line-through text-danger">Rs. <?php echo ($old_price) ?>.00</span></span>
                                                <span class="">Rating: 4.7 <i class="icon-star-full text-warning"></i> | 37 Solled</span>

                                                <div class="col-12 border my-1 rounded border-secondary text-secondary" title="<?php echo ($product_data["desc"]); ?>" style="height: 150px; overflow-y: scroll;">
                                                    <?php echo ($product_data["desc"]); ?>
                                                </div>

                                                <?php
                                                $r_total = ($product_data["price"] * $cart_data["qty"]) + $delivery;
                                                $item_price = $item_price + $r_total;
                                                ?>

                                                <div class="d-flex justify-content-between text-secondary fw-bold">
                                                    <span class="">Requested Total</span>
                                                    <span class="">Rs. <?php echo ($r_total); ?> .00</span>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- Details Side -->
                                    </div>
                                </div>
                            <?php
                            }

                            ?>

                        </div>
                        <!-- Cart Product View Area -->

                        <style>

                        </style>



                        <!-- Cart Summery -->
                        <div class="col-10 col-lg-4 border border-1 rounded border-dark cart-summery d-lg-block" id="cart_summery" style="z-index: 1;">
                            <div class="row px-1">

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold fs-4">Summery</span>
                                        <span class="fw-bold fs-2 me-2 c-pointer d-block d-lg-none" id="summery_close">X</span>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="my-1">
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="row px-3 fw-bold">

                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-6">Item Price (3)</div>
                                                <div class="col-6 d-flex justify-content-end">Rs. <?php echo ($item_price); ?> .00</div>

                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-6">Delivery</div>
                                                <div class="col-6 d-flex justify-content-end">Rs. <?php echo ($delivery_total); ?> .00</div>

                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="row">

                                                <div class="col-6">Discount (0%)</div>
                                                <div class="col-6 d-flex justify-content-end">Rs. 00 .00</div>

                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr class="my-1">
                                        </div>

                                        <div class="col-12">
                                            <div class="row">

                                                <?php
                                                $total_price = ($item_price + $delivery_total) - $discount;
                                                ?>

                                                <div class="col-6">Total Price</div>
                                                <div class="col-6 d-flex justify-content-end">Rs. <?php echo ($total_price); ?> .00</div>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 mt-5">
                                    <div class="row">

                                        <div class="col-11 mid-content d-grid">
                                            <button class="checkout-btn fs-5" type="submit" id="payhere-payment" style="border-radius: 100vh;" onclick="buyCart('<?php echo ($total_price); ?>');">Checkout</button>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Cart Summery -->

                    </div>
                </div>


                <!-- Empty View -->
            <?php
            } else {
            ?>

                <div class="col-12">
                    <div class="border border-dark px-1 m-1 rounded d-flex justify-content-center align-items-center flex-column position-relative" style="min-height: 85vh;">

                        <i class="icon-cart empty-cart-icon text-black-50"></i>
                        <span class="fs-1 text-black-50 fw-bold text-center">You have not items in your Cart yet.</span>

                        <div class="col-10 col-md-8 col-lg-6 col-xl-4 col-xxl-3 d-grid my-2 position-absolute bottom-0">
                            <a class="btn btn-outline-primary" href="home.php">Start Shopping</a>
                        </div>

                    </div>
                </div>

            <?php
            }

            ?>
            <!-- Empty View -->


            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="script.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>

</html>

<?php

?>