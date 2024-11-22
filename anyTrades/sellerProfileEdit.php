<?php
session_start();
if (!isset($_SESSION["at_u"]) && !isset($_SESSION["seller"])) {
    header("Location:home.php");
} else {
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
                <div class="col-12">
                    <div class="row position-relative">

                        <?php

                        require "connection.php";

                        $seller = $_SESSION["seller"];

                        $image_rs = Database::search("SELECT * FROM `profile_image` WHERE user_email='" . $_SESSION["at_u"]["email"] . "'");
                        $image_num = $image_rs->num_rows;

                        $seller_img_rs = Database::search("SELECT * FROM `seller_profile_image` WHERE `seller_nic`='" . $seller["nic"] . "'");
                        $seller_img_num = $seller_img_rs->num_rows;

                        if ($seller_img_num == 1) {
                            $seller_img_data = $seller_img_rs->fetch_assoc();
                        }


                        if ($image_num == 1) {
                            $image_data = $image_rs->fetch_assoc();
                        }

                        ?>

                        <!-- Profile Background -->
                        <div class="col-12">
                            <div class="row profile-edit-background overflow-hidden position-relative">

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

                                <div class="position-absolute w-100 h-100 top-0 start-0 d-flex justify-content-center align-items-center profile-image-btn">
                                    <label for="seller_background_uploader" class="fs-5 fw-bold c-pointer text-white" onclick="sellerBackground();">Add <i class="bi bi-camera"></i></label>
                                    <input type="file" id="seller_background_uploader" class="d-none" />
                                </div>

                            </div>
                        </div>
                        <!-- Profile Background -->

                        <div class="p-0 seller-img position-absolute end-0 position-relative">

                            <?php
                            if (isset($seller_img_data["seller_img"])) {
                            ?>
                                <img src="<?php echo ($seller_img_data["seller_img"]); ?>" id="seller_image">
                            <?php
                            } else if ($image_num == 1 && isset($image_data["p_img"])) {
                            ?>
                                <img src="<?php echo ($image_data["p_img"]); ?>" id="seller_image">
                            <?php
                            } else {
                            ?>
                                <img src="resources/new_user.svg" style="object-fit: cover; width: 100%; height: 100%;" id="seller_image">
                            <?php
                            }
                            ?>

                            <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center top-0 start-0 profile-image-btn">
                                <label for="seller_img_uploader" class="fs-5 fw-bold c-pointer text-white" onclick="sellerImage();"> Add <i class="bi bi-camera"></i></label>
                                <input type="file" id="seller_img_uploader" class="d-none" />
                            </div>

                        </div>

                    </div>
                </div>
                <!-- Header -->                

                <!-- Content -->
                <div class="col-12 mt-5 mb-4">
                    <div class="row">

                        <div class="col-12 mt-5 p-2" style="background-image: linear-gradient(60deg, #000b3a, #220059);">
                            <span class="text-white fw-bold l-space-1 fs-2">Seller Profile</span>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="row">

                                <div class="col-12 border-end col-lg-6">
                                    <div class="row profile-edit-row">

                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON `user`.`gender_id`=`gender`.`id` WHERE `email`='" . $_SESSION["at_u"]["email"] . "'");
                                        $user_num = $user_rs->num_rows;

                                        $seller_rs = Database::search("SELECT * FROM `seller` WHERE nic='" . $_SESSION["seller"]["nic"] . "'");
                                        $seller_data = $seller_rs->fetch_assoc();

                                        if ($user_num == 1) {
                                            $user_data = $user_rs->fetch_assoc();
                                        }

                                        ?>


                                        <div class="col-12">
                                            <span class="fw-bold">Name : </span>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" class="form-control" value="<?php
                                                                                                    if (!isset($seller_data["name"])) {
                                                                                                        echo ($user_data["fname"]);
                                                                                                    }
                                                                                                    ?>" disabled id="fname" placeholder="First Name" />
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" value="<?php
                                                                                                    if (!isset($seller_data["name"])) {
                                                                                                        echo ($user_data["fname"]);
                                                                                                    }
                                                                                                    ?>" disabled id="lname" placeholder="Last Name" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <span class="fw-bold">Create Your Own Seller Name : </span>
                                            <div class="row">
                                                <div class="col-12">
                                                    <?php

                                                    if (isset($seller_data["name"])) {
                                                    ?>
                                                        <input type="text" class="form-control" id="sname" onkeyup="sellerName();" value="<?php echo ($seller_data["name"]); ?>" />
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <input type="text" class="form-control" id="sname" placeholder="Seller Name" />
                                                    <?php
                                                    }

                                                    ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Email : </span>
                                            <input type="email" class="form-control" value="<?php echo ($user_data["email"]); ?>" disabled />
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Mobile : </span>
                                            <input type="tel" class="form-control" value="<?php echo ($user_data["mobile"]); ?>" disabled />
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">NIC : </span>
                                            <input type="tel" class="form-control" value="<?php echo ($seller_data["nic"]); ?>" disabled />
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Joined Date : </span>
                                            <input type="text" class="form-control" placeholder="<?php
                                                                                                    $join_date = $user_data["join_date"];
                                                                                                    $splite_date = explode(" ", $join_date);
                                                                                                    $date = $splite_date[0];
                                                                                                    echo ($date);
                                                                                                    ?>" disabled>
                                        </div>



                                        <?php

                                        if ($user_data["address_status"] == 0) {
                                            $line1 = "";
                                            $line2 = "";
                                            $line3 = "";
                                        } else if ($user_data["address_status"] == 1) {

                                            $user_address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $user_data["email"] . "'");
                                            $user_address_data = $user_address_rs->fetch_assoc();

                                            $line1 = $user_address_data["line1"];
                                            $line2 = $user_address_data["line2"];
                                            $line3 = $user_address_data["line3"];
                                        } else if ($user_data["address_status"] == 2) {

                                            $seller_address_rs = Database::search("SELECT * FROM `seller_has_address` WHERE `seller_nic`='" . $seller_data["nic"] . "'");
                                            $seller_address_data = $seller_address_rs->fetch_assoc();

                                            $line1 = $seller_address_data["line1"];
                                            $line2 = $seller_address_data["line2"];
                                            $line3 = $seller_address_data["line3"];
                                        }

                                        ?>




                                        <div class="col-12">
                                            <span class="fw-bold">Address : </span>
                                            <input type="text" class="form-control" value="<?php echo ($line1); ?>" id="line1" placeholder="Address Line 1" />
                                            <input type="text" class="form-control" value="<?php echo ($line2); ?>" id="line2" placeholder="Address Line 2" />
                                            <input type="text" class="form-control" value="<?php echo ($line3); ?>" id="line3" placeholder="Address Line 3" />

                                            <hr>

                                            <div class="row mt-3 mt-lg-0">
                                                <div class="col-12">
                                                    <div class="row g-2">
                                                        <div class="col-12 col-lg-6">
                                                            <select class="form-select" onchange="loadDistrict();" id="province">

                                                                <?php

                                                                if ($user_data["address_status"] == 0) {
                                                                ?>

                                                                    <option value="0">Select Province</option>

                                                                    <?php

                                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                                    $province_num = $province_rs->num_rows;


                                                                    for ($a = 0; $a < $province_num; $a++) {
                                                                        $province_data = $province_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($province_data["id"]); ?>"><?php echo ($province_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>

                                                                <?php
                                                                } else if ($user_data["address_status"] == 1) {

                                                                    $u_address_rs = Database::search("SELECT `city`.`id` AS `cid`,`district`.`id` AS `did`,`province`.`id` AS `pid` FROM `user_has_address` INNER JOIN `city` ON `user_has_address`.`city_id`=`city`.`id` INNER JOIN `district` ON `city`.`district_id`=`district`.`id` INNER JOIN `province` ON `district`.`province_id`=`province`.`id` WHERE `user_has_address`.`user_email`='" . $user_data["email"] . "'");
                                                                    $u_address_data = $u_address_rs->fetch_assoc();

                                                                ?>
                                                                    <option value="0">Select Province</option>

                                                                    <?php

                                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                                    $province_num = $province_rs->num_rows;


                                                                    for ($a = 0; $a < $province_num; $a++) {
                                                                        $province_data = $province_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($province_data["id"]); ?>" <?php
                                                                                                                                if ($u_address_data["pid"] == $province_data["id"]) {
                                                                                                                                ?>selected<?php
                                                                                                                                        }
                                                                                                                                            ?>><?php echo ($province_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>
                                                                <?php
                                                                } else if ($user_data["address_status"] == 2) {
                                                                    $s_address_rs = Database::search("SELECT `city`.`id` AS `cid`,`district`.`id` AS `did`,`province`.`id` AS `pid` FROM `seller_has_address` INNER JOIN `city` ON `seller_has_address`.`city_id`=`city`.`id` INNER JOIN `district` ON `city`.`district_id`=`district`.`id` INNER JOIN `province` ON `district`.`province_id`=`province`.`id` WHERE `seller_has_address`.`seller_nic`='" . $seller_data["nic"] . "'");
                                                                    $s_address_data = $s_address_rs->fetch_assoc();

                                                                ?>
                                                                    <option value="0">Select Province</option>

                                                                    <?php

                                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                                    $province_num = $province_rs->num_rows;


                                                                    for ($a = 0; $a < $province_num; $a++) {
                                                                        $province_data = $province_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($province_data["id"]); ?>" <?php
                                                                                                                                if ($s_address_data["pid"] == $province_data["id"]) {
                                                                                                                                ?>selected<?php
                                                                                                                                        }
                                                                                                                                            ?>><?php echo ($province_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>
                                                                <?php
                                                                }

                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <select class="form-select" id="district" onchange="loadCity();">
                                                                <!-- <option value="0">Select District</option> -->
                                                                <?php

                                                                if ($user_data["address_status"] == 0) {

                                                                    $district_rs = Database::search("SELECT * FROM `district`");
                                                                    $district_num = $district_rs->num_rows;

                                                                    for ($a = 0; $a < $district_num; $a++) {
                                                                        $district_data = $district_rs->fetch_assoc();
                                                                ?>

                                                                        <option value="<?php echo ($district_data["id"]); ?>"><?php echo ($district_data["name"]); ?></option>

                                                                    <?php
                                                                    }
                                                                } else if ($user_data["address_status"] == 1) {

                                                                    $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id`='" . $u_address_data["pid"] . "'");
                                                                    $district_num = $district_rs->num_rows;

                                                                    for ($a = 0; $a < $district_num; $a++) {
                                                                        $district_data = $district_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($district_data["id"]); ?>" <?php
                                                                                                                                if ($u_address_data["did"] == $district_data["id"]) {
                                                                                                                                ?> selected <?php
                                                                                                                                        }
                                                                                                                                            ?>><?php echo ($district_data["name"]); ?></option>

                                                                    <?php
                                                                    }
                                                                } else if ($user_data["address_status"] == 2) {
                                                                    $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id`='" . $s_address_data["pid"] . "'");
                                                                    $district_num = $district_rs->num_rows;

                                                                    for ($a = 0; $a < $district_num; $a++) {
                                                                        $district_data = $district_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($district_data["id"]); ?>" <?php
                                                                                                                                if ($s_address_data["did"] == $district_data["id"]) {
                                                                                                                                ?> selected <?php
                                                                                                                                        }
                                                                                                                                            ?>><?php echo ($district_data["name"]); ?></option>

                                                                <?php
                                                                    }
                                                                }

                                                                ?>

                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-lg-6">
                                                            <select class="form-select" id="city">
                                                                <!-- <option value="0">Select City</option> -->

                                                                <?php

                                                                if ($user_data["address_status"] == 0) {
                                                                    $city_rs = Database::search("SELECT * FROM `city`");
                                                                    $city_num = $city_rs->num_rows;

                                                                    for ($a = 0; $a < $city_num; $a++) {
                                                                        $city_data = $city_rs->fetch_assoc();
                                                                ?>

                                                                        <option value="<?php echo ($city_data["id"]); ?>"><?php echo ($city_data["name"]); ?></option>

                                                                    <?php
                                                                    }
                                                                } else if ($user_data["address_status"] == 1) {
                                                                    $city_rs = Database::search("SELECT * FROM `city` WHERE `district_id`='" . $u_address_data["did"] . "'");
                                                                    $city_num = $city_rs->num_rows;

                                                                    for ($a = 0; $a < $city_num; $a++) {
                                                                        $city_data = $city_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($city_data["id"]); ?>" <?php
                                                                                                                            if ($u_address_data["cid"] == $city_data["id"]) {
                                                                                                                            ?> selected <?php
                                                                                                                                    }
                                                                                                                                        ?>><?php echo ($city_data["name"]); ?></option>

                                                                    <?php
                                                                    }
                                                                } else if ($user_data["address_status"] == 2) {
                                                                    $city_rs = Database::search("SELECT * FROM `city` WHERE `district_id`='" . $s_address_data["did"] . "'");
                                                                    $city_num = $city_rs->num_rows;

                                                                    for ($a = 0; $a < $city_num; $a++) {
                                                                        $city_data = $city_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($city_data["id"]); ?>" <?php
                                                                                                                            if ($s_address_data["cid"] == $city_data["id"]) {
                                                                                                                            ?> selected <?php
                                                                                                                                    }
                                                                                                                                        ?>><?php echo ($city_data["name"]); ?></option>

                                                                <?php
                                                                    }
                                                                }

                                                                ?>

                                                            </select>
                                                        </div>

                                                        <div class="col-12 col-lg-6">
                                                            <?php

                                                            $user_pc_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                                            $user_pc_data = $user_pc_rs->fetch_assoc();

                                                            $seller_pc_rs = Database::search("SELECT * FROM `seller_has_address` WHERE `seller_nic`='" . $_SESSION["seller"]["nic"] . "'");
                                                            $seller_pc_data = $seller_pc_rs->fetch_assoc();

                                                            if ($user_data["address_status"] == 0) {
                                                            ?>
                                                                <input type="text" id="pCode" class="form-control" placeholder="Postal Code" value="">
                                                            <?php
                                                            } else if ($user_data["address_status"] == 1) {
                                                            ?>
                                                                <input type="text" id="pCode" class="form-control" placeholder="Postal Code" value="<?php echo ($user_pc_data["postal_code"]); ?>">
                                                            <?php
                                                            } else if ($user_data["address_status"] == 2) {
                                                            ?>
                                                                <input type="text" id="pCode" class="form-control" placeholder="Postal Code" value="<?php echo ($seller_pc_data["postal_code"]); ?>">
                                                            <?php
                                                            }
                                                            ?>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
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
                                                <textarea class="form-control" cols="30" rows="10" id="bio"><?php echo ($seller_data["bio"]); ?></textarea>
                                            <?php
                                            } else {
                                            ?>
                                                <textarea class="form-control" cols="30" rows="10" id="bio"></textarea>
                                            <?php
                                            }
                                            ?>
                                        </div>


                                        <div class="col-12 p-2">
                                            <div class="bg-dark d-flex gap-3 flex-column w-100 rounded p-3">
                                                <label class="text-white fs-4 fw-bold l-space-1">Social Media</label>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <span class="icon-whatsapp text-white fs-4"></span>
                                                    <input type="text" placeholder="Whatsapp Number Link" class="form-control" id="whatsapp" value="<?php
                                                                                                                                                    if (isset($seller_data["whatsapp"])) {
                                                                                                                                                        echo ($seller_data["whatsapp"]);
                                                                                                                                                    }
                                                                                                                                                    ?>" />
                                                </div>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <span class="icon-youtube text-white fs-4"></span>
                                                    <input type="text" placeholder="Youtube Channel Link" class="form-control" id="youtube" value="<?php
                                                                                                                                                    if (isset($seller_data["youtube"])) {
                                                                                                                                                        echo ($seller_data["youtube"]);
                                                                                                                                                    }
                                                                                                                                                    ?>" />
                                                </div>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <span class="icon-facebook text-white fs-4"></span>
                                                    <input type="text" placeholder="Facebook Profile or Group Link" class="form-control" id="facebook" value="<?php
                                                                                                                                                                if (isset($seller_data["facebook"])) {
                                                                                                                                                                    echo ($seller_data["facebook"]);
                                                                                                                                                                }
                                                                                                                                                                ?>" />
                                                </div>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <span class="icon-twitter text-white fs-4"></span>
                                                    <input type="text" placeholder="Twitter Profile Link" class="form-control" id="twitter" value="<?php
                                                                                                                                                    if (isset($seller_data["twitter"])) {
                                                                                                                                                        echo ($seller_data["twitter"]);
                                                                                                                                                    }
                                                                                                                                                    ?>" />
                                                </div>
                                                <div class="d-flex gap-3 align-items-center">
                                                    <span class="icon-linkedin text-white fs-4"></span>
                                                    <input type="text" placeholder="Linked In Profile Link" class="form-control" id="linkedin" value="<?php
                                                                                                                                                        if (isset($seller_data["linkedin"])) {
                                                                                                                                                            echo ($seller_data["linkedin"]);
                                                                                                                                                        }
                                                                                                                                                        ?>" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-12 offset-0 offset-md-1 col-md-5 d-grid mt-3">
                                            <button class="btn btn-primary" onclick="editSellerProfile();">Save Changes</button>
                                        </div>
                                        <div class="col-12 col-md-5 d-grid mt-3">
                                            <a class="btn btn-dark" href="userProfile.php">Discard</a>
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

        <script src=" script.js">
        </script>
    </body>

    </html>


<?php
}
?>