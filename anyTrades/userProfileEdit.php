<?php
session_start();
if (!isset($_SESSION["at_u"])) {
    header("Location:home.php");
} else {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>User Profile | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
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

                        $image_rs = Database::search("SELECT * FROM `profile_image` WHERE user_email='" . $_SESSION["at_u"]["email"] . "'");
                        $image_num = $image_rs->num_rows;
                        if ($image_num == 1) {
                            $image_data = $image_rs->fetch_assoc();
                        }

                        ?>

                        <!-- Profile Background -->
                        <div class="col-12">
                            <div class="row profile-edit-background overflow-hidden">

                                <?php
                                if ($image_num == 1 && isset($image_data["p_back"])) {
                                ?>
                                    <img src="<?php echo ($image_data["p_back"]); ?>" id="background_image" class="p-0" style="object-position: center; height: 100%;object-fit: cover;">
                                <?php
                                } else {
                                ?>
                                    <img src="resources/2483946.jpg" id="background_image" class="p-0" style="object-position: center; height: 100%;object-fit: cover;">
                                <?php
                                }
                                ?>

                                <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center top-0 start-0 profile-image-btn">
                                    <label for="profile_background_uploader" class="fs-5 fw-bold text-white c-pointer" onclick="profileBackground();">Add <i class="bi bi-camera"></i></label>
                                    <input type="file" id="profile_background_uploader" class="d-none" />
                                </div>

                            </div>
                        </div>
                        <!-- Profile Background -->

                        <div class="p-0 profile-img">

                            <?php
                            if ($image_num == 1 && isset($image_data["p_img"])) {
                            ?>
                                <img src="<?php echo ($image_data["p_img"]); ?>" id="profile_image">
                            <?php
                            } else {
                            ?>
                                <img src="resources/new_user.svg" id="profile_image">
                            <?php
                            }
                            ?>

                            <div class="position-absolute w-100 h-100 d-flex justify-content-center align-items-center top-0 start-0 profile-image-btn">
                                <label for="profile_img_uploader" class="fs-5 fw-bold text-white c-pointer" onclick="profileimage();">Add <i class="bi bi-camera"></i></label>
                                <input type="file" id="profile_img_uploader" class="d-none" />
                            </div>
                        </div>

                    </div>
                </div>
                <!-- Header -->

                <!-- Content -->
                <div class="col-12 mt-5 mb-4">
                    <div class="row">

                        <div class="col-12 mt-5 p-2" style="background-image: linear-gradient(60deg, #000b3a, #220059);">
                            <span class="text-white fw-bold l-space-1 fs-2">User Profile</span>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="row">

                                <div class="col-12 border-end col-lg-6">
                                    <div class="row profile-edit-row">

                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON `user`.`gender_id`=`gender`.`id` WHERE `email`='" . $_SESSION["at_u"]["email"] . "'");
                                        $user_num = $user_rs->num_rows;

                                        if ($user_num == 1) {
                                            $user_data = $user_rs->fetch_assoc();
                                        }

                                        ?>

                                        <div class="col-12">
                                            <span class="fw-bold">Name : </span>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="text" class="form-control" value="<?php echo ($user_data["fname"]); ?>" id="fname" placeholder="First Name" />
                                                </div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control" value="<?php echo ($user_data["lname"]); ?>" id="lname" placeholder="Last Name" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Email : </span>
                                            <input type="email" class="form-control" value="<?php echo ($user_data["email"]); ?>" disabled />
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Password : </span>
                                            <input type="password" class="form-control" disabled value="<?php

                                                                                                        $password = $user_data["password"];
                                                                                                        $p_lenght = strlen($password);
                                                                                                        for ($y = 0; $y < $p_lenght; $y++) {
                                                                                                            echo ("*");
                                                                                                        }
                                                                                                        ?>" />
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Mobile : </span>
                                            <input type="tel" class="form-control" value="<?php echo ($user_data["mobile"]); ?>" id="mobile" />
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Gender : </span>
                                            <select class="form-select" disabled>
                                                <option><?php echo ($user_data["gender_name"]); ?></option>
                                            </select>
                                        </div>

                                        <div class="col-12">
                                            <span class="fw-bold">Date of Birth : </span>
                                            <?php

                                            if (isset($user_data["dob"])) {
                                            ?>
                                                <input type="date" class="form-control" id="dob" value="<?php echo ($user_data["dob"]); ?>" />
                                            <?php
                                            } else {
                                            ?>
                                                <input type="date" class="form-control" id="dob" />
                                            <?php
                                            }

                                            ?>

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

                                        $address_rs = Database::search("SELECT city.id AS cid,district.id AS did,province.id AS pro_id,line1,line2,line3,postal_code FROM city 
                                        INNER JOIN district ON city.district_id=district.id 
                                        INNER JOIN province ON province.id=district.province_id 
                                        INNER JOIN user_has_address ON user_has_address.city_id=city.id WHERE user_email='" . $_SESSION["at_u"]["email"] . "'");
                                        $address_num = $address_rs->num_rows;

                                        if ($address_num == 1) {
                                            $address_data = $address_rs->fetch_assoc();
                                        ?>
                                            <div class="col-12">
                                                <span class="fw-bold">Address : </span>
                                                <input type="text" class="form-control" value="<?php echo ($address_data["line1"]); ?>" id="line1" />
                                                <input type="text" class="form-control" value="<?php echo ($address_data["line2"]); ?>" id="line2" />
                                                <input type="text" class="form-control" value="<?php echo ($address_data["line3"]); ?>" id="line3" />

                                                <hr>

                                                <div class="row mt-3 mt-lg-0">
                                                    <div class="col-12">
                                                        <div class="row g-2">
                                                            <div class="col-12 col-lg-6">
                                                                <select class="form-select" onchange="loadDistrict();" id="province">
                                                                    <option value="0">Select Province</option>

                                                                    <?php

                                                                    $province_rs = Database::search("SELECT * FROM `province`");
                                                                    $province_num = $province_rs->num_rows;


                                                                    for ($a = 0; $a < $province_num; $a++) {
                                                                        $province_data = $province_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($province_data["id"]); ?>" <?php

                                                                                                                                if ($province_data["id"] == $address_data["pro_id"]) {
                                                                                                                                    $province_id = $province_data["id"];
                                                                                                                                ?> selected <?php
                                                                                                                                        }

                                                                                                                                            ?>><?php echo ($province_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <select class="form-select" id="district" onchange="loadCity();">
                                                                    <option value="0">Select District</option>

                                                                    <?php

                                                                    $district_rs = Database::search("SELECT * FROM `district` WHERE `province_id`='" . $province_id . "'");
                                                                    $district_num = $district_rs->num_rows;

                                                                    for ($a = 0; $a < $district_num; $a++) {
                                                                        $district_data = $district_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($district_data["id"]); ?>" <?php

                                                                                                                                if ($district_data["id"] == $address_data["did"]) {
                                                                                                                                    $district_id = $district_data["id"];
                                                                                                                                ?> selected <?php
                                                                                                                                        }

                                                                                                                                            ?>><?php echo ($district_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <select class="form-select" id="city">
                                                                    <option value="0">Select City</option>

                                                                    <?php

                                                                    $city_rs = Database::search("SELECT * FROM `city` WHERE `district_id`='" . $district_id . "'");
                                                                    $city_num = $city_rs->num_rows;

                                                                    for ($a = 0; $a < $city_num; $a++) {
                                                                        $city_data = $city_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($city_data["id"]); ?>" <?php

                                                                                                                            if ($address_data["cid"] == $city_data["id"]) {
                                                                                                                            ?> selected <?php
                                                                                                                                    }

                                                                                                                                        ?>><?php echo ($city_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>

                                                            <div class="col-12 col-lg-6">
                                                                <input type="text" id="pCode" class="form-control" placeholder="Postal Code" value="<?php echo ($address_data["postal_code"]); ?>">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        } else {
                                        ?>

                                            <div class="col-12">
                                                <span class="fw-bold">Address : </span>
                                                <input type="text" class="form-control" placeholder="Line 1" id="line1" />
                                                <input type="text" class="form-control" placeholder="Line 2" id="line2" />
                                                <input type="text" class="form-control" placeholder="Line 3 (optional)" id="line3" />
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row g-2">
                                                            <div class="col-12 col-lg-6">
                                                                <select class="form-select" id="province" onchange="loadDistrict();">
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

                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <select class="form-select" id="district" onchange="loadCity();">
                                                                    <option value="0">Select District</option>

                                                                    <?php

                                                                    $district_rs = Database::search("SELECT * FROM `district`");
                                                                    $district_num = $district_rs->num_rows;

                                                                    for ($a = 0; $a < $district_num; $a++) {
                                                                        $district_data = $district_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($district_data["id"]); ?>"><?php echo ($district_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>
                                                            <div class="col-12 col-lg-6">
                                                                <select class="form-select" id="city">
                                                                    <option value="0">Select City</option>

                                                                    <?php

                                                                    $city_rs = Database::search("SELECT * FROM `city`");
                                                                    $city_num = $city_rs->num_rows;

                                                                    for ($a = 0; $a < $city_num; $a++) {
                                                                        $city_data = $city_rs->fetch_assoc();
                                                                    ?>

                                                                        <option value="<?php echo ($city_data["id"]); ?>"><?php echo ($city_data["name"]); ?></option>

                                                                    <?php
                                                                    }

                                                                    ?>

                                                                </select>
                                                            </div>

                                                            <div class="col-12 col-lg-6">
                                                                <input type="text" id="pCode" class="form-control" placeholder="Postal Code">
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }

                                        ?>




                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="row">

                                        <div class="col-12">
                                            <label class="fs-3 fw-bold">Bio :</label>
                                            <textarea class="form-control" cols="30" rows="10" id="bio"><?php echo ($user_data["bio"]); ?></textarea>
                                        </div>

                                        <div class="col-12 offset-0 offset-md-1 col-md-5 d-grid mt-3">
                                            <button class="btn btn-primary" onclick="editProfile();">Save Changes</button>
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