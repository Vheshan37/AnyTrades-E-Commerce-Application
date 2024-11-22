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
    <title>Watchlist | AnyTrades</title>
    <!-- CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="demo-files/demo.css" />
    <link rel="stylesheet" href="icomoon.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
</head>

<body style="background-color: #e4e4e4;">

<?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php"; ?>

            <!-- Header -->
            <div class="col-12 py-2">
                <div class="row d-flex align-items-center">

                    <div class="col-6">
                        <div class="d-flex justify-content-start align-items-center gap-2 text-danger fs-2">
                            <span class="fw-bold">Watchlist</span>
                            <i class="icon-heart"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-end">
                            <input type="text" placeholder="Search in Watchlist..." class="p-2 text-center cart-search" />
                        </div>
                    </div>


                </div>
            </div>
            <!-- Header -->

            <?php

            $email = $_SESSION["at_u"]["email"];
            $rs = Database::search("SELECT * FROM watchlist WHERE user_email='" . $email . "'");
            $num = $rs->num_rows;

            ?>

            <!-- Content -->

            <?php

            if ($num == 0) {

            ?>

                <div class="col-12 mb-3" style="min-height: 65vh;">
                    <div class="d-flex w-100 h-100 border-purple rounded p-5 justify-content-center align-items-center flex-column position-relative">

                        <i class="icon-heart empty-watchlist-icon text-black-50"></i>
                        <span class="fs-1 text-black-50 fw-bold text-center">You have not items in your Cart yet.</span>

                        <div class="col-10 col-md-8 col-lg-6 col-xl-4 col-xxl-3 d-grid my-2 position-absolute bottom-0">
                            <a class="btn btn-outline-primary" href="home.php">Start Shopping</a>
                        </div>

                    </div>
                </div>

            <?php

            } else {
            ?>

                <div class="col-12" style="min-height: 80vh;">
                    <div class="row border-purple p-2 rounded watchlist-grid" style="max-height: 85vh; overflow-y: scroll;">


                        <?php
                        for ($x = 0; $x < $num; $x++) {
                            $data = $rs->fetch_assoc();

                            $product_rs = Database::search("SELECT * FROM `product` WHERE id='" . $data["product_id"] . "'");
                            $product_data = $product_rs->fetch_assoc();

                            $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $data["product_id"] . "'");
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

                            $old_price = $product_data["price"] + (($product_data["price"] / 100) * 5);

                        ?>

                            <!-- Product Area -->

                            <div class="col-12 border border-1 mid-content rounded p-2 border-secondary position-relative shadow bg-body">
                                <div class="row">

                                    <div class="position-absolute start-0 top-0 m-3 watchlist-cart" onclick="addToCart('<?php echo ($product_data['id']); ?>');">
                                        <i class="icon-cart"></i>
                                    </div>

                                    <!-- Image Side -->
                                    <div class="col-12 col-xxl-5">
                                        <div class="d-flex align-items-center w-100 watchlist-img-side">

                                            <div class="w-100 d-flex justify-content-center">
                                                <div class="row">
                                                    <img src="<?php echo ($img_data["path"]); ?>" style="height: 200px; object-fit: contain;" title="<?php echo ($product_data["desc"]); ?>" />
                                                </div>
                                            </div>

                                            <!-- Btn Area in the Cart -->
                                            <div class="w-100 mt-2 mb-1">
                                                <div class="row watchlist-btn">

                                                    <div class="d-grid">
                                                        <button class="btn btn-outline-success" style="border-radius: 100vh;">Buy Now</button>
                                                    </div>
                                                    <div class="d-grid">
                                                        <button class="btn btn-outline-danger" style="border-radius: 100vh;" onclick="removeFromWatchlist('<?php echo ($data['id']); ?>');">Remove</button>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- Btn Area in the Cart -->

                                        </div>
                                    </div>
                                    <!-- Image Side -->

                                    <div class="col-12 d-block d-xxl-none">
                                        <hr class="my-2 p-0">
                                    </div>

                                    <!-- Details Side -->
                                    <div class="col-xxl-7 col-12">
                                        <div class="row w-100 h-100 d-flex flex-column p-1 watchlist-details px-2 m-0">

                                            <span class="fs-3 fw-bold" title="<?php echo ($product_data["title"]); ?>"><?php echo ($product_data["title"]); ?></span>
                                            <span class="">Rs. <?php echo ($product_data["price"]); ?> .00 + <?php echo ($delivery); ?>.00 | <span class="text-danger text-decoration-line-through fw-bold">Rs. <?php echo ($old_price); ?>.00</span></span>
                                            <span class="">Quantity : <?php echo ($product_data["qty"]); ?> Items Available</span>
                                            <span class="">Rating: 4.7 <i class="icon-star-full text-warning"></i> | 37 Solled</span>

                                            <div class="border my-1 rounded border-secondary text-secondary w-100" title="<?php echo ($product_data["desc"]); ?>" style="height: 150px; overflow-y: scroll;">
                                                <?php echo ($product_data["desc"]); ?>
                                            </div>

                                        </div>
                                    </div>
                                    <!-- Details Side -->
                                </div>
                            </div>

                            <!-- Product Area -->

                        <?php
                        }
                        ?>


                    </div>
                </div>

            <?php
            }

            ?>



            <!-- Content -->


            <?php include "footer.php"; ?>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>