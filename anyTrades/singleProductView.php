<?php

session_start();

if (isset($_GET["p"])) {
    require "connection.php";
    $pid = $_GET["p"];
    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
    $product_data = $product_rs->fetch_assoc();

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo ($product_data["title"]); ?> | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <?php

    $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "'");
    $img_num = $img_rs->num_rows;

    ?>

    <body onload="setSliderSize('<?php echo ($img_num); ?>');">

    <?php require "alert.php"; ?>
    
        <div class="container-fluid">
            <div class="row">

                <?php include "header.php"; ?>

                <div class="col-12 my-1">
                    <div class="row">

                        <div class="col-12">
                            <div class="row">
                                <a class="d-flex align-items-center fs-5 fw-bold justify-content-start text-decoration-none text-dark w-auto" href="home.php">
                                    <span class="icon-chevron_left_black_24dp fs-3 fw-bold"></span>
                                    <span class="">Back</span>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>





                <!-- Content -->
                <div class="col-12" style="min-height: 70vh;">
                    <div class="row">

                        <div class="col-12 col-lg-6">
                            <div class="row h-100 overflow-hidden singleViewSlider position-relative">

                                <div class="position-absolute d-flex justify-content-end py-3">
                                    <span style="border-radius: 100vh; padding: 2px 10px;" class="text-white fw-bold l-space-2 single-img-count"><span id="singleImgNumber">1</span>/<?php echo ($img_num); ?></span>
                                </div>

                                <div class="singleSlider d-flex p-0 vw-100 align-items-center" id="singleSlider">
                                    <?php

                                    for ($img = 0; $img < $img_num; $img++) {
                                        $img_data = $img_rs->fetch_assoc();
                                    ?>
                                        <img src="<?php echo ($img_data["path"]); ?>" style="max-height: 400px; width: 100%; object-fit: contain;" class="col-12" />
                                    <?php
                                    }

                                    ?>
                                </div>


                                <div class="position-absolute top-50 w-100 p-0 m-0 d-flex justify-content-between px-2 singleSliderArrow">
                                    <i class="icon-left-arrowhead-in-a-circle-svgrepo-com fw-bold fs-4 c-pointer" style="color: #555;" onclick="singleSlider('-');"></i>
                                    <i class="icon-right-arrowhead-in-a-circle-svgrepo-com fw-bold fs-4 c-pointer" style="color: #555;" onclick="singleSlider('+');"></i>
                                </div>

                                <div class="position-absolute w-100 d-flex justify-content-center gap-1 singleSliderIndicator" style="bottom: 3%;">
                                    <?php

                                    for ($indicator = 0; $indicator < $img_num; $indicator++) {
                                        $img_data = $img_rs->fetch_assoc();
                                    ?>
                                        <div class="" style="width: 35px; height: 7px; border-radius: 100vh;" onclick="singleSlider('<?php echo ($indicator); ?>');" id="singleSliderIndicator_<?php echo ($indicator); ?>"></div>
                                    <?php
                                    }

                                    ?>
                                </div>

                            </div>
                        </div>

                        <div class="col-12 d-block d-lg-none">
                            <hr>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="row">

                                <div class="col-12">
                                    <div class="row">

                                        <?php

                                        $seller_rs  = Database::search("SELECT * FROM `seller` INNER JOIN `product` ON `product`.`seller_nic`=`seller`.`nic` INNER JOIN `user` ON `seller`.`user_email`=`user`.`email` WHERE `product`.`id`='" . $product_data["id"] . "'");
                                        $seller_data = $seller_rs->fetch_assoc();

                                        $seller_img = Database::search("SELECT * FROM `seller_profile_image` WHERE `seller_nic`='" . $seller_data["nic"] . "'");
                                        $seller_img_data = $seller_img->fetch_assoc();

                                        ?>

                                        <div class="d-flex gap-2 align-items-center mt-2 w-auto c-pointer" onclick="viewSeller('<?php echo ($product_data['id']); ?>');">
                                            <img src="<?php
                                                        if (!empty($seller_img_data["seller_img"])) {
                                                            echo ($seller_img_data["seller_img"]);
                                                        } else if (!empty($seller_img_data["p_img"])) {
                                                            echo ($seller_img_data["p_img"]);
                                                        } else {
                                                            echo ("resources/new_user.svg");
                                                        }
                                                        ?>" style="border-radius: 100%; width: 60px; height: 60px; object-position: center;" />
                                            <div class="d-flex flex-column">
                                                <span class="fw-bold">
                                                    <?php

                                                    if (!empty($seller_data["name"])) {
                                                        echo ($seller_data["name"]);
                                                    } else {
                                                        echo ($seller_data["fname"] . " " . $seller_data["lname"]);
                                                    }

                                                    ?>
                                                </span>
                                                <span class="text-black-50"><?php echo ($seller_data["email"]); ?></span>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <hr>
                                        </div>


                                        <div class="col-12 my-1">
                                            <div class="row px-4">


                                                <div class="col-12">
                                                    <span class="fs-5 fw-bold"><?php echo ($product_data["title"]); ?></span>
                                                </div>

                                                <div class="d-flex">
                                                    <span class="fw-bold">Quantity :</span>

                                                    <div class="col-12 d-flex justify-content-center cart-qty mx-2">
                                                        <span class="btn border-0" onclick="setQuantity(0);">-</span>
                                                        <input type="text" class="text-center" readonly value="1" id="setQty" />
                                                        <span class="btn border-0" onclick="setQuantity(1,'<?php echo ($product_data['qty']) ?>');">+</span>
                                                    </div>
                                                </div>

                                                <div class="col-12 fw-bold">

                                                    <?php

                                                    $price = $product_data["price"];
                                                    $discount = ($price / 100) * 5;
                                                    $old_price = $discount + $price;

                                                    $rs =  Database::search("SELECT `color`.`color`,`condition`.`name` AS `condition`
                                                    FROM `color`
                                                    INNER JOIN `product` ON `product`.`color_id`=`color`.`id`
                                                    INNER JOIN `condition` ON `condition`.`id`=`product`.`condition_id` WHERE `product`.`id`='" . $product_data["id"] . "'");
                                                    $data = $rs->fetch_assoc();

                                                    ?>

                                                    <span class="">Price :</span>
                                                    <span class="text-success">Rs. <?php echo ($price); ?> .00</span>
                                                    |
                                                    <span class="text-decoration-line-through text-danger">Rs. <?php echo ($old_price) ?> .00</span>
                                                </div>
                                                <div class="col-12 fw-bold">
                                                    <span class="">Condition : <?php echo ($data["condition"]); ?></span>
                                                </div>
                                                <div class="col-12 fw-bold">
                                                    <span class="">Color : <?php echo ($data["color"]); ?></span>
                                                </div>

                                                <div class="col-12 fw-bold">
                                                    <span class="">4.7 <i class="icon-star-full text-warning"></i> Rating | 34 Solled</span>
                                                </div>

                                                <div class="col-12 fw-bold">
                                                    <span class="">Description :</span>
                                                    <textarea class="form-control mt-1" cols="30" rows="10" readonly style="max-height: 250px; min-height: 250px;"><?php echo ($seller_data["desc"]) ?></textarea>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="col-12 my-2">
                                            <div class="row g-2">

                                                <div class="col-12 d-grid col-sm-10 offset-sm-1 col-md-4 offset-md-0 col-lg-10 offset-lg-1 col-xl-4 offset-xl-0">
                                                    <button class="btn btn-success d-flex align-items-center justify-content-center gap-2" type="submit" id="payhere-payment" onclick="singleBuyNow('<?php echo ($product_data['id']); ?>');">
                                                        <span>Buy Now</span>
                                                        <i class="icon-coin-dollar fs-5"></i>
                                                    </button>
                                                </div>

                                                <?php

                                                if (isset($_SESSION["at_u"])) {
                                                    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                                    $cart_num = $cart_rs->num_rows;

                                                    $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "' AND product_id='" . $product_data["id"] . "'");
                                                    $watchlist_num = $watchlist_rs->num_rows;
                                                }

                                                ?>

                                                <div class="d-grid col-6 col-sm-5 offset-sm-1 col-md-4 offset-md-0 col-lg-5 offset-lg-1 col-xl-4 offset-xl-0">
                                                    <button class="btn <?php
                                                                        if ($cart_num == 0) {
                                                                            echo ("btn-warning");
                                                                        } else {
                                                                            echo ("btn-outline-warning");
                                                                        }
                                                                        ?> d-flex align-items-center justify-content-center gap-2" onclick="addToCart('<?php echo ($product_data['id']); ?>');">
                                                        <span>Add to Cart</span>
                                                        <i class="icon-cart fs-5"></i>
                                                    </button>
                                                </div>

                                                <div class="d-grid col-6 col-sm-5 col-md-4 offset-md-0 col-lg-5 col-xl-4 offset-xl-0">
                                                    <button class="btn <?php
                                                                        if ($watchlist_num == 0) {
                                                                            echo ("btn-danger");
                                                                        } else {
                                                                            echo ("btn-outline-danger");
                                                                        }
                                                                        ?> d-flex align-items-center justify-content-center gap-2" onclick="addToWatchlist('<?php echo ($product_data['id']); ?>');">
                                                        <span>Add to Watchlist</span>
                                                        <i class="icon-heart"></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                </div>
                <!-- Content -->


                <!-- Related Items -->
                <div class="col-12 my-3 py-2 px-0">

                    <p class="w-100 d-block m-0">
                        <span class="fs-4 text-dark px-2">Related Items</span>
                    </p>
                    <hr class="m-0">

                    <div class="col-12">

                        <?php

                        $related_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $product_data["category_id"] . "' AND `id`<>'" . $pid . "' LIMIT 10");
                        $related_num = $related_rs->num_rows;

                        if ($related_num > 0) {

                        ?>
                            <div class="related_items_container py-3">
                                <?php

                                for ($x = 0; $x < $related_num; $x++) {
                                    $related_data = $related_rs->fetch_assoc();

                                    $product_img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $related_data["id"] . "'");
                                    $product_img_data = $product_img_rs->fetch_assoc();

                                ?>

                                    <div class="">

                                        <div class="border border-1 rounded position-relative overflow-hidden">

                                            <div class="d-flex justify-content-center">
                                                <img src="<?php echo ($product_img_data["path"]); ?>" alt="" class="img-fluid" style="object-fit: contain; max-height: 250px; height: 250px;" />
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex flex-column fw-bold p-1">

                                                    <span class="fs-5"><?php echo ($related_data["title"]); ?></span>
                                                    <span>Price : Rs. <?php echo ($related_data["price"]); ?> .00</span>
                                                    <span>10 Items Availble</span>

                                                    <div class="px-1 mt-3 related-btn" style="display: flex; column-gap: 5px;">
                                                        <button class="btn btn-outline-warning" onclick="singleProductView('<?php echo ($related_data['id']); ?>');">View More...</button>
                                                        <button class="btn btn-outline-danger" onclick="addToCart('<?php echo ($related_data['id']); ?>');">Add to Cart</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                <?php
                                }

                                ?>
                            </div>
                        <?php

                        } else {
                        ?>

                            <div class="d-flex justify-content-center my-2">

                                <div class="w-auto btn btn-outline-success rounded px-5 py-3">No related items in this product</div>

                            </div>

                        <?php
                        }
                        ?>
                    </div>

                </div>
                <!-- Related Items -->



                <?php include "footer.php"; ?>


            </div>
        </div>

        <script src="script.js"></script>
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
    </body>

    </html>

<?php

} else {
    echo ("Something went wrong");
}
?>