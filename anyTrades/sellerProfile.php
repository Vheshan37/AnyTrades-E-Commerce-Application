<?php
session_start();
if (!isset($_SESSION["at_u"])) {
    header("Location:home.php");
} else if (!isset($_SESSION["seller"])) {
    header("Location:sellerRegistraion.php");
} else if ($_SESSION["u_type"] == "seller") {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Seller Profile | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body>
    
    <?php require "alert.php"; ?>
    
        <div class="container-fluid">
            <div class="row">

                <!-- Header -->
                <div class="col-12 user-profile-header">
                    <div class="row position-relative">

                        <?php

                        require "connection.php";

                        $image_rs = Database::search("SELECT * FROM `profile_image` WHERE user_email='" . $_SESSION["at_u"]["email"] . "'");
                        $image_num = $image_rs->num_rows;
                        $seller = $_SESSION["seller"];
                        if ($image_num == 1) {
                            $image_data = $image_rs->fetch_assoc();
                        }

                        $seller_img_rs = Database::search("SELECT * FROM `seller_profile_image` WHERE `seller_nic`='" . $seller["nic"] . "'");
                        $seller_img_num = $seller_img_rs->num_rows;

                        if ($seller_img_num == 1) {
                            $seller_img_data = $seller_img_rs->fetch_assoc();
                        }

                        ?>

                        <!-- Profile Background -->
                        <div class="col-12">
                            <div class="row profile-background">

                                <?php
                                if (isset($seller_img_data["seller_back"])) {
                                ?>
                                    <img src="<?php echo ($seller_img_data["seller_back"]); ?>" id="seller_background_image" class="p-0" style="object-position: center; height: 100%;object-fit: cover;">
                                <?php
                                } else if ($image_num == 1 && isset($image_data["p_back"])) {
                                ?>
                                    <img src="<?php echo ($image_data["p_back"]); ?>" id="seller_background_image" class="p-0" style="object-position: center; height: 100%;object-fit: cover;">
                                <?php
                                } else {
                                ?>
                                    <img src="resources/2483946.jpg" id="seller_background_image" class="p-0" style="object-position: center; height: 100%;object-fit: cover;">
                                <?php
                                }
                                ?>

                            </div>
                        </div>
                        <!-- Profile Background -->

                        <div class="p-0 seller-img">

                            <?php
                            if (isset($seller_img_data["seller_img"])) {
                            ?>
                                <img src="<?php echo ($seller_img_data["seller_img"]); ?>" id="profile_image">
                            <?php
                            } else if ($image_num == 1 && isset($image_data["p_img"])) {
                            ?>
                                <img src="<?php echo ($image_data["p_img"]); ?>" id="profile_image">
                            <?php
                            } else {
                            ?>
                                <img src="resources/new_user.svg" style="object-fit: cover; width: 100%; height: 100%;" id="profile_image">
                            <?php
                            }
                            ?>

                        </div>


                        <div class="col-3 col-md-2 col-lg-1 d-grid position-absolute top-0 end-0 mt-2">
                            <button class="btn btn-danger" onclick="viewEditSellerProfile();">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </button>
                        </div>


                    </div>
                </div>
                <!-- Header -->

                <!-- Content -->
                <div class="col-12 mt-5 mb-4">
                    <div class="row">


                        <div class="col-12">
                            <nav area-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a class="text-decoration-none" href="home.php">Home</a></li>
                                    <li class="breadcrumb-item"><a class="text-decoration-none" href="sellerPanel.php">Seller Panel</a></li>
                                    <li class="breadcrumb-item active" area-current="page">Seller Profile</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="col-12 mt-3 p-2" style="background-image: linear-gradient(60deg, #000b3a, #220059);">
                            <span class="text-white fw-bold l-space-1 fs-2">Seller Profile</span>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="row g-3">

                                <div class="col-12 col-lg-6 border-end">
                                    <div class="row profile-row">


                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $_SESSION["at_u"]["email"] . "'");
                                        $user_data = $user_rs->fetch_assoc();

                                        $seller_rs = Database::search("SELECT * FROM `seller` WHERE nic='" . $_SESSION["seller"]["nic"] . "'");
                                        $seller_data = $seller_rs->fetch_assoc();

                                        ?>


                                        <div class="col-12">
                                            <span class="fw-bold">Name : </span>
                                            <?php

                                            if ($seller_data["name"] == "") {
                                            ?>
                                                <span><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></span>
                                            <?php
                                            } else {
                                            ?>
                                                <span><?php echo ($seller_data["name"]); ?></span>
                                            <?php
                                            }

                                            ?>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Email : </span>
                                            <span><?php echo ($user_data["email"]); ?></span>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Mobile : </span>
                                            <span><?php echo ($user_data["mobile"]); ?></span>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">NIC : </span>
                                            <span><?php echo ($seller_data["nic"]); ?></span>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Joined Date : </span>
                                            <span><?php
                                                    $date = explode(" ", $user_data["join_date"]);
                                                    echo ($date[0]);
                                                    ?></span>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Address : </span>

                                            <?php

                                            if ($user_data["address_status"] == 0) {
                                                // No Address
                                            ?>
                                                <span>Address is not set.</span>
                                            <?php
                                            } else if ($user_data["address_status"] == 1) {
                                                // User Address
                                                $user_address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                                $user_address_data = $user_address_rs->fetch_assoc();

                                            ?>
                                                <span><?php

                                                        echo ($user_address_data["line1"] . ", " . $user_address_data["line2"]);
                                                        if (!empty($user_address_data["line3"])) {
                                                            echo (", " . $user_address_data["line3"] . ".");
                                                        } else {
                                                            echo (".");
                                                        }

                                                        ?></span>
                                            <?php
                                            } else if ($user_data["address_status"] == 2) {
                                                // Seller Address
                                                $seller_address_rs = Database::search("SELECT * FROM `seller_has_address` WHERE `seller_nic`='" . $seller_data["nic"] . "'");
                                                $seller_address_data = $seller_address_rs->fetch_assoc();

                                            ?>
                                                <span><?php

                                                        echo ($seller_address_data["line1"] . ", " . $seller_address_data["line2"]);
                                                        if (!empty($seller_address_data["line3"])) {
                                                            echo (", " . $seller_address_data["line3"] . ".");
                                                        } else {
                                                            echo (".");
                                                        }

                                                        ?></span>
                                            <?php
                                            }

                                            ?>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row g-3">

                                        <div class="col-12">
                                            <label class="fs-3 fw-bold">Bio :</label>
                                            <?php
                                            if (isset($seller_data["bio"])) {
                                            ?>
                                                <textarea class="form-control" cols="30" rows="10" id="bio" readonly><?php echo ($seller_data["bio"]); ?></textarea>
                                            <?php
                                            } else {
                                            ?>
                                                <textarea class="form-control" cols="30" rows="10" id="bio" readonly></textarea>
                                            <?php
                                            }
                                            ?>
                                        </div>


                                        <div class="col-12">
                                            <div class="bg-dark d-flex gap-4 align-items-center height-80 w-100 rounded p-3">
                                                <?php

                                                if ($seller_data["whatsapp"] != "") {
                                                ?>
                                                    <a href="<?php echo ($seller_data["whatsapp"]); ?>"><span class="icon-whatsapp text-white fs-2"></span></a>
                                                <?php
                                                }
                                                if ($seller_data["youtube"] != "") {
                                                ?>
                                                    <a href="<?php echo ($seller_data["youtube"]); ?>"><span class="icon-youtube text-white fs-2"></span></a>
                                                <?php
                                                }
                                                if ($seller_data["facebook"] != "") {
                                                ?>
                                                    <a href="<?php echo ($seller_data["facebook"]); ?>"><span class="icon-facebook text-white fs-2"></span></a>
                                                <?php
                                                }
                                                if ($seller_data["twitter"] != "") {
                                                ?>
                                                    <a href="<?php echo ($seller_data["twitter"]); ?>"><span class="icon-twitter text-white fs-2"></span></a>
                                                <?php
                                                }
                                                if ($seller_data["linkedin"] != "") {
                                                ?>
                                                    <a href="<?php echo ($seller_data["linkedin"]); ?>"><span class="icon-linkedin text-white fs-2"></span></a>
                                                <?php
                                                }

                                                if ($seller_data["whatsapp"] == "" && $seller_data["youtube"] == "" && $seller_data["facebook"] == "" && $seller_data["twitter"] == "" && $seller_data["linkedin"] == "") {
                                                ?>
                                                    <span class="text-warning fw-bold fs-5 l-space-2">No social media account.</span>
                                                <?php
                                                }

                                                ?>

                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <div class="col-12 col-lg-6">
                                    <div class="row p-2">

                                        <div class="col-12 bg-info rounded-top border">
                                            <div class="row">

                                                <div class="col-12">
                                                    <span class="fw-bold text-white l-space-2 fs-5 d-flex">
                                                        <span class="">Customer Review</span>
                                                        <span class="text-warning ms-auto">
                                                            <span class="icon-star-full"></span>
                                                            <span class="icon-star-full"></span>
                                                            <span class="icon-star-full"></span>
                                                            <span class="icon-star-full"></span>
                                                            <span class="icon-star-half"></span>
                                                        </span>
                                                    </span>
                                                </div>


                                                <div class="col-12 bg-body pt-1 pb-3" style="border-radius: 5px 5px 0 0;">
                                                    <div class="row g-3">

                                                        <div class="col-12 bg-body">
                                                            <span class="w-100 text-end d-block fw-bold">39 Customer Review</span>
                                                        </div>

                                                        <div class="rating-progress">
                                                            <span class="">5 Star</span>
                                                            <div class="">
                                                                <div class=""></div>
                                                            </div>
                                                            <span class="">25%</span>
                                                        </div>

                                                        <div class="rating-progress">
                                                            <span class="">4 Star</span>
                                                            <div class="">
                                                                <div class=""></div>
                                                            </div>
                                                            <span class="">25%</span>
                                                        </div>

                                                        <div class="rating-progress">
                                                            <span class="">3 Star</span>
                                                            <div class="">
                                                                <div class=""></div>
                                                            </div>
                                                            <span class="">25%</span>
                                                        </div>

                                                        <div class="rating-progress">
                                                            <span class="">2 Star</span>
                                                            <div class="">
                                                                <div class=""></div>
                                                            </div>
                                                            <span class="">25%</span>
                                                        </div>

                                                        <div class="rating-progress">
                                                            <span class="">1 Star</span>
                                                            <div class="">
                                                                <div class=""></div>
                                                            </div>
                                                            <span class="">25%</span>
                                                        </div>

                                                    </div>
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



            </div>
        </div>

        <script src="script.js"></script>
    </body>

    </html>

<?php
} else {
    header("Location:home.php");
}
?>