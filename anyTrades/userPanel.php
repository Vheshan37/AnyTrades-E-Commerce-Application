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
    <title>User Panel | AnyTrades</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="demo-files/demo.css" />
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
                                <span class="text-white fs-2 fw-normal f-Debugged l-space-2">User Panel</span>
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
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 mid-content pt-5 user-panel">
                <div class="row">

                    <div class="col-12 mb-5">
                        <div class="row">
                            <div class="col-12">
                                <?php

                                $image_num = 0;

                                if (isset($_SESSION["at_u"])) {
                                    $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                    $image_num = $image_rs->num_rows;
                                }


                                if ($image_num == 0) {
                                ?>
                                    <img src="resources/profile_images/new_user.svg" class="mid-content">
                                <?php
                                } else {
                                    $image_data = $image_rs->fetch_assoc();
                                ?>
                                    <img src="<?php echo ($image_data["p_img"]); ?>" class="mid-content width-100" style="clip-path: circle();">
                                <?php
                                }

                                ?>
                            </div>
                            <div class="col-12 d-flex justify-content-center mt-1">
                                <?php

                                if (isset($_SESSION["at_u"])) {
                                ?>
                                    <span class="d-block fw-bold text-black-50"><?php echo ($_SESSION["at_u"]["fname"] . " " . $_SESSION["at_u"]["lname"]); ?></span>
                                <?php
                                } else {
                                ?>
                                    <a href="index.php" class="user-panel-signin text-white text-decoration-none">Sign In</a>
                                <?php
                                }

                                ?>

                            </div>
                        </div>
                    </div>

                    <ul class="user-panel-menu">
                        <li>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="userProfile.php">
                                <i class="fs-5 icon-user-profile-svgrepo-com"></i>
                                &nbsp;
                                <span class="">User Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="purchasingHistory.php">
                                <i class="fs-5 icon-history-svgrepo-com"></i>
                                &nbsp;
                                <span class="">Purchase History</span>
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="myOrders.php">
                                <i class="fs-5 icon-history-svgrepo-com"></i>
                                &nbsp;
                                <span class="">Orders</span>
                            </a>
                        </li>

                        <?php

                        if (isset($_SESSION["at_u"])) {
                            $n_msg_rs = Database::search("SELECT * FROM `chat` WHERE `to`='" . $_SESSION["at_u"]["email"] . "' AND `direction`='2' AND `status`='0'");
                            $n_msg_num = $n_msg_rs->num_rows;
                        }

                        ?>

                        <li>
                            <a class="d-flex align-items-center gap-1 fw-bold text-dark" href="message.php?t=2">
                                <i class="icon-message-svgrepo-com fs-5"></i>
                                &nbsp;
                                <span class="">Message</span>
                                <?php
                                if (isset($_SESSION["at_u"])) {
                                    if ($n_msg_num > 0) {
                                ?>
                                        <span style="width: 15px; height: 15px; border-radius: 100%; background-color: orange;"></span>
                                <?php
                                    }
                                }
                                ?>
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="setting.php">
                                <i class="fs-5 icon-setting-svgrepo-com"></i>
                                &nbsp;
                                <span class="">Setting</span>
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="<?php
                                                                                                if (!isset($_SESSION["seller"])) {
                                                                                                    echo ("sellerRegistration.php");
                                                                                                } else {
                                                                                                    echo ("sellerPanel.php");
                                                                                                }
                                                                                                ?>">
                                <i class="fs-5 icon-user-profile-svgrepo-com"></i>
                                &nbsp;
                                <span class=""><?php
                                                if (!isset($_SESSION["seller"])) {
                                                    echo ("Become a Seller");
                                                } else {
                                                    echo ("Seller Panel");
                                                }
                                                ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="#">
                                <i class="fs-5 icon-support_agent_black_24dp1"></i>
                                &nbsp;
                                <span class="">Customer Service</span>
                            </a>
                        </li>
                        <li <?php
                            if (isset($_SESSION["at_u"])) {
                            ?> onclick="signOutBox();" <?php
                                                    }
                                                        ?>>
                            <a class="fw-bold text-dark d-flex align-items-center gap-1" href="#">
                                <i class="fs-5 icon-logout-svgrepo-com"></i>
                                &nbsp;
                                <span class="">Logout</span>
                            </a>
                        </li>
                    </ul>

                </div>
            </div>
            <!-- Content -->



            <!-- Sign out Box -->
            <div class="box" id="signOutBox">
                <div class="signoutBox rounded pb-1 bg-white">

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