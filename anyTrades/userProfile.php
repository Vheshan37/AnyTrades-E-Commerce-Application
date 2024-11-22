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
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="min-vh-100">

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
                        if ($image_num == 1) {
                            $image_data = $image_rs->fetch_assoc();
                        }

                        ?>

                        <!-- Profile Background -->
                        <div class="col-12">
                            <div class="row profile-background">

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

                            </div>
                        </div>
                        <!-- Profile Background -->

                        <div class="p-0 profile-img position-absolute end-0">

                            <?php
                            if ($image_num == 1 && isset($image_data["p_img"])) {
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
                            <button class="btn btn-danger" onclick="editUserProfile();">
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
                                    <li class="breadcrumb-item"><a class="text-decoration-none" href="userPanel.php">User Panel</a></li>
                                    <li class="breadcrumb-item active" area-current="page">User Profile</li>
                                </ol>
                            </nav>
                        </div>

                        <div class="col-12 mt-3 p-2" style="background-image: linear-gradient(60deg, #000b3a, #220059);">
                            <span class="text-white fw-bold l-space-1 fs-2">User Profile</span>
                        </div>

                        <div class="col-12 mt-2">
                            <div class="row g-3">

                                <div class="col-12 col-lg-6 border-end">
                                    <div class="row profile-row">

                                        <?php

                                        $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `gender` ON `user`.`gender_id`=`gender`.`id` WHERE `email`='" . $_SESSION["at_u"]["email"] . "'");
                                        $user_num = $user_rs->num_rows;

                                        if ($user_num == 1) {
                                            $user_data = $user_rs->fetch_assoc();
                                        ?>
                                            <div class="col-12">
                                                <span class="fw-bold">Name : </span>
                                                <span class=""><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Email : </span>
                                                <span class=""><?php echo ($user_data["email"]); ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Password : </span>
                                                <span class=""><?php
                                                                $p_length = strlen($user_data["password"]);
                                                                for ($p = 0; $p < $p_length; $p++) {
                                                                    echo ("*");
                                                                }
                                                                ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Mobile : </span>
                                                <span class=""><?php echo ($user_data["mobile"]); ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Gender : </span>
                                                <span class=""><?php echo ($user_data["gender_name"]); ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Date of Birth : </span>
                                                <span class=""><?php echo ($user_data["dob"]); ?></span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Joined Date : </span>
                                                <span class=""><?php echo ($user_data["join_date"]); ?></span>
                                            </div>

                                            <?php
                                            $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                            $address_num = $address_rs->num_rows;

                                            if ($address_num == 1) {
                                                $address_data = $address_rs->fetch_assoc();
                                            ?>
                                                <div class="col-12">
                                                    <span class="fw-bold">Address : </span>
                                                    <span class=""><?php
                                                                    echo ($address_data["line1"] . ", " . $address_data["line2"]);
                                                                    if (!empty($address_data["line3"])) {
                                                                        echo (", " . $address_data["line3"] . ".");
                                                                    } else {
                                                                        echo (".");
                                                                    }
                                                                    ?></span>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col-12">
                                                    <span class="fw-bold">Address : </span>
                                                    <span class="">------------------</span>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="col-12">
                                                <span class="fw-bold">Name : </span>
                                                <span class="">Vihanga Heshan</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Email : </span>
                                                <span class="">vihangaheshan37@gmail.com</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Password : </span>
                                                <span class="">*******</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Mobile : </span>
                                                <span class="">0719892932</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Gender : </span>
                                                <span class="">Male</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Date of Birth : </span>
                                                <span class="">2002-03-07</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Joined Date : </span>
                                                <span class="">2022-05-09 00:00:00</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="fw-bold">Address : </span>
                                                <span class="">231/D, Deenapamunuwa, Urapola.</span>
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
                                            <textarea class="form-control" cols="30" rows="10" id="bio" readonly><?php echo ($user_data["bio"]); ?></textarea>
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

        <?php include "footer.php"; ?>

        <script src="script.js"></script>
    </body>

    </html>

<?php
}
?>