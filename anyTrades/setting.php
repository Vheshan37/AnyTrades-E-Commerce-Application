<?php
session_start();
require "connection.php";
if (isset($_SESSION["at_u"])) {
    $email = $_SESSION["at_u"]["email"];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setting | AnyTrades</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="demo-files/demo.css" />
    <link rel="stylesheet" href="icomoon.css" />
    <link rel="icon" href="resources/AnyTrades logo.png" type="image">
</head>

<body class="min-vh-100 bg-dark c-default">

<?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row text-white">

            <?php include "header.php"; ?>

            <div class="col-12 mt-3">
                <div class="row">

                    <h2 style="font-family: arial;" class="fw-bold text-white">Setting</h1>

                        <div class="col-12">
                            <hr class="border-secondary border border-1 my-1">
                        </div>

                </div>
            </div>

            <div class="col-12">
                <div class="row ps-1 ps-md-3 ps-lg-5">

                    <div class="d-flex flex-column gap-3">

                        <div class="col-12">
                            <div class="d-flex align-items-center gap-1 fs-5">
                                <i class="icon-setting-svgrepo-com"></i>
                                <span class="">Security</span>
                            </div>
                            <div class="d-flex flex-column gap-1 ps-5">
                                <span class="">View Password</span>
                                <span class="">Reset Password</span>
                            </div>
                        </div>

                        <?php
                        if (!isset($_SESSION["seller"])) {
                        ?>
                            <div class="col-12">
                                <a href="sellerRegistration.php" class="text-white c-pointer d-flex align-items-center gap-1 fs-5">
                                    <i class="icon-account_circle_black_24dp"></i>
                                    <span class="">Become a Seller</span>
                                </a>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="col-12">
                                <a href="sellerPanel.php" class="text-white c-pointer d-flex align-items-center gap-1 fs-5">
                                    <i class="icon-account_circle_black_24dp"></i>
                                    <span class="">Seller Panel</span>
                                </a>
                                <div class="d-flex flex-column gap-1 ps-5">
                                    <a href="sellerProfile.php" class="text-white c-pointer">Profile</a>
                                    <a href="myProduct.php" class="text-white c-pointer">Seller House</a>
                                    <a href="#" class="text-white c-pointer">My Sellings</a>
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                        <div class="col-12">
                            <div class="d-flex align-items-center gap-1 fs-5">
                                <i class="icon-notifications_active_black_24dp"></i>
                                <span class="">Notification</span>
                            </div>
                            <div class="d-flex flex-column gap-1 ps-5">
                                <div class="d-flex gap-2 align-items-center">
                                    <span class="">New Updates</span>
                                    <input type="checkbox" class="d-none" id="new_update" onchange="newUpdate();">
                                    <?php

                                    if (isset($_SESSION["at_u"])) {
                                        $notification_rs = Database::search("SELECT * FROM `notification` WHERE user_email='" . $email . "'");
                                        $notification_data = $notification_rs->fetch_assoc();
                                    }


                                    if (isset($_COOKIE["update_status"])) {
                                        $status = $_COOKIE["update_status"];
                                    }

                                    if (isset($_COOKIE["notification_status"])) {
                                        $notification_status = $_COOKIE["notification_status"];
                                    }

                                    ?>
                                    <script>
                                        var status = <?php echo ($status); ?>;
                                        document.getElementById("new_update").onclick = function() {

                                            if (status == 0) {
                                                document.getElementById("new_update_label").classList = "setting_switch";
                                                status = 1;
                                            } else {
                                                document.getElementById("new_update_label").className = "setting_switch_off";
                                                status = 0;
                                            }
                                        }
                                    </script>
                                    <label for="new_update" class="<?php
                                                                    if ($notification_data["update"] == "0") {
                                                                        echo ("setting_switch_off");
                                                                    } else {
                                                                        echo ("setting_switch");
                                                                    }
                                                                    ?>" id="new_update_label">
                                        <span class="switch"></span>
                                    </label>
                                </div>
                                <div class="d-flex gap-2 align-items-center">
                                    <span class="">Notification</span>
                                    <input type="checkbox" class="d-none" id="notification" onchange="setNotification();">
                                    <script>
                                        var notification = <?php echo ($notification_status); ?>;
                                        document.getElementById("notification").onclick = function() {
                                            if (notification == 0) {
                                                document.getElementById("notification_label").classList = "setting_switch";
                                                notification = 1;
                                            } else {
                                                document.getElementById("notification_label").className = "setting_switch_off";
                                                notification = 0;
                                            }
                                        }
                                    </script>
                                    <label for="notification" class="<?php
                                                                        if ($notification_data["notification"] == "0") {
                                                                            echo ("setting_switch_off");
                                                                        } else {
                                                                            echo ("setting_switch");
                                                                        }
                                                                        ?>" id="notification_label">
                                        <span class="switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="d-flex align-items-center gap-1 fs-5">
                                <i class="icon-credit_card_black_24dp"></i>
                                <span class="">Purchasing</span>
                            </div>
                            <div class="d-flex flex-column gap-1 ps-5">
                                <span class="">Add Payment Method</span>
                                <span class="">Delivery Address</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>