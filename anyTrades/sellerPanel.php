<?php
session_start();
require "connection.php";

if (isset($_SESSION["seller"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Seller Panel | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body style="background-color: #e9e9e9;">

    <?php require "alert.php"; ?>
    
        <div class="container-fluid">
            <div class="row">

                <?php include "header.php" ?>

                <!-- Header -->
                <div class="col-12">
                    <div class="row" style="background-image: linear-gradient(60deg, #000b3a, #220059); min-height: 5vh;">

                        <div class="col-12 col-lg-10 offset-lg-1">
                            <div class="row p-1">

                                <div class="col-6 d-flex align-items-center">
                                    <span class="text-white fs-2 fw-normal f-Debugged l-space-2">Seller Panel</span>
                                </div>

                                <div class="col-6 d-flex justify-content-end gap-2 align-items-center">
                                    <img src="resources/icons/shopping_cart_white_24dp.png" class="cart" onclick="goToCart();" />
                                    <img src="resources/icons/bookmark_white_24dp.png" class="watchlist" onclick="goToWatchlist();" />
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- Header -->

                <!-- Content -->
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 mid-content pt-5 seller-panel">
                    <div class="row">

                        <div class="col-12 mb-5">
                            <div class="row">
                                <div class="col-12">
                                    <?php


                                    $img_rs = Database::search("SELECT * FROM `seller_profile_image` WHERE `seller_nic`='" . $_SESSION["seller"]["nic"] . "'");
                                    $img_num = $img_rs->num_rows;
                                    if ($img_num == 0) {
                                    ?>
                                        <img src="resources/profile_images/new_user.svg" class="mid-content">
                                    <?php
                                    } else {
                                        $img_data = $img_rs->fetch_assoc();
                                    ?>
                                        <img src="<?php echo ($img_data["seller_img"]); ?>" class="mid-content width-100 height-100" style="border-radius: 100%; object-fit: cover; object-position: center;">
                                    <?php
                                    }


                                    ?>
                                </div>
                                <div class="col-12 d-flex justify-content-center mt-1">

                                    <?php

                                    if ($_SESSION["u_type"] == "seller") {
                                    ?>
                                        <span class="d-block fw-bold text-black-50"><?php echo ($_SESSION["at_u"]["fname"] . " " . $_SESSION["at_u"]["lname"]); ?></span>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="sellerRegistration.php" class="user-panel-signin text-white text-decoration-none">Sign In</a>
                                    <?php
                                    }

                                    ?>


                                </div>
                            </div>
                        </div>

                        <ul class="seller-panel-menu">
                            <li>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="sellerProfile.php">
                                    <i class="icon-user-profile-svgrepo-com fs-5"></i>
                                    &nbsp;
                                    <span class="">Seller Profile</span>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="myProduct.php">
                                    <i class="icon-home fs-5"></i>
                                    &nbsp;
                                    <span class="">Seller House</span>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="mySelling.php">
                                    <i class="icon-dollar-svgrepo-com fs-5"></i>
                                    &nbsp;
                                    <span class="">My Selling</span>
                                </a>
                            </li>
                            <?php

                            $n_msg_rs = Database::search("SELECT * FROM `chat` WHERE `to`='" . $_SESSION["at_u"]["email"] . "' AND `direction`='1' AND `status`='0'");
                            $n_msg_num = $n_msg_rs->num_rows;

                            ?>
                            <li>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="message.php?t=1">
                                    <i class="icon-message-svgrepo-com fs-5"></i>
                                    &nbsp;
                                    <span class="">Message</span>
                                    <?php
                                    if ($n_msg_num > 0) {
                                    ?>
                                        <span style="width: 15px; height: 15px; border-radius: 100%; background-color: orange;"></span>
                                    <?php
                                    }
                                    ?>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="#">
                                    <i class="icon-setting-svgrepo-com fs-5"></i>
                                    &nbsp;
                                    <span class="">Setting</span>
                                </a>
                            </li>
                            <li>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="#">
                                    <i class="icon-support_agent_black_24dp fs-5"></i>
                                    &nbsp;
                                    <span class="">Customer Service</span>
                                </a>
                            </li>
                            <li <?php
                                if (isset($_SESSION["u_type"])) {
                                ?> onclick="sellerLogout();" <?php
                                                            }
                                                                ?>>
                                <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="#">
                                    <i class="icon-logout-svgrepo-com fs-5"></i>
                                    &nbsp;
                                    <span class="">Logout</span>
                                </a>
                            </li>
                        </ul>

                    </div>
                </div>
                <!-- Content -->


                <!-- Sign out Box -->
                <div class="box" id="sellerOutBox">
                    <div class="sellerOutBox rounded pb-1 bg-white">

                        <div class="box-head bg-warning">
                            <label class="fw-bold p-1">Alert &#9888;</label>
                        </div>

                        <div class="box-body mt-5">
                            <label class="p-1">Are you sure want to Logout?</label>
                        </div>

                        <div class="box-footer gap-2 p-1 px-2">
                            <button class="btn btn-primary" id="stay">Stay</button>
                            <button class="btn btn-danger" id="logOut">Logout</button>
                        </div>

                    </div>
                </div>
                <!-- Sign out Box -->


            </div>
        </div>

        <script src="script.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:sellerRegistration.php");
}

?>