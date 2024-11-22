<?php
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Any Trades</title>

    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="resources/AnyTrades logo.png" type="image">
</head>

<body class="main-body c-default">

    <?php require "alert.php"; ?>

    <div class="container-fluid vh-100 d-flex justify-content-center">

        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 d-flex justify-content-center align-items-center d-none" id="forgotPasswordModel">
            <div class="bg-white rounded overflow-hidden col-lg-4">
                <div class="row">
                    <div class="col-12">

                        <div class="bg-warning fs-5 text-white px-2 col-12">Reset Your Password</div>
                        <div class="px-4 py-2 col-12">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-9">
                                            <label for="" class="form-label text-secondary">Email</label>
                                            <input type="text" class="form-control" id="forgotEmail">
                                        </div>
                                        <div class="col-3 d-flex align-items-end">
                                            <button class="btn btn-primary mt-2" onclick="sendResetPasswordOTP();">Send OTP</button>
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="" class="form-label text-secondary">OTP Code</label>
                                            <input type="text" class="form-control" id="forgotOTP">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <label for="" class="form-label text-secondary">New Password</label>
                                            <input type="password" class="form-control" id="newPassword">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-outline-success" onclick="resetUserPassword();" disabled id="resetBtn">Reset Password</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-warning py-2 fs-5 text-white px-2 col-12 d-flex justify-content-center">
                            <button class="btn btn-light" onclick="closeForgotPasswordModel();">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row align-content-center">

            <!-- Header -->
            <div class="col-12">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <div class="app-logo"></div>
                    </div>
                    <div class="col-12">
                        <p class="text-center title1 fs-5">Hi, Welcome to Any Trades</p>
                    </div>
                </div>
            </div>
            <!-- Header -->

            <!-- Content -->
            <div class="col-12 mt-5">
                <div class="row">

                    <!-- Sign Up -->
                    <div class="col-12 col-md-10 col-lg-6 mx-auto d-none" id="sign_up">
                        <div class="row g-3 p-3 form">

                            <div class="col-12">
                                <h3>Create New Acccount</h3>
                            </div>

                            <div class="col-12 alert alert-danger d-none" id="signup_msg_container">
                                <div class="text-center" id="form-msg"></div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" />
                            </div>
                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname" />
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" />
                            </div>

                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="mobile">Mobile</label>
                                <input type="text" class="form-control" id="mobile" />
                            </div>

                            <?php

                            $gender_rs = Database::search("SELECT * FROM `gender`");
                            $gender_num = $gender_rs->num_rows;

                            ?>

                            <div class="col-12 col-lg-6">
                                <label class="form-label" for="gender">Gender</label>
                                <select class="form-select" id="gender">

                                    <?php
                                    for ($g = 0; $g < $gender_num; $g++) {
                                        $gender_data = $gender_rs->fetch_assoc();
                                    ?>
                                        <option value="<?php echo ($gender_data["id"]); ?>"><?php echo ($gender_data["gender_name"]); ?></option>
                                    <?php
                                    }
                                    ?>

                                </select>
                            </div>

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-primary" onclick="signup();">Sign Up</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-dark" onclick="changeView();">Already have an account? Sign In</button>
                            </div>


                        </div>
                    </div>
                    <!-- Sign Up -->

                    <!-- Sign In -->
                    <div class="col-12 col-md-10 col-lg-6 mx-auto" id="sign_in">
                        <div class="row g-3 p-3 form">

                            <?php

                            if (isset($_COOKIE["email"])) {
                                $email = $_COOKIE["email"];
                            } else {
                                $email = "";
                            }
                            if (isset($_COOKIE["password"])) {
                                $password = $_COOKIE["password"];
                            } else {
                                $password = "";
                            }

                            ?>

                            <div class="col-12">
                                <h3>Sign In</h3>
                            </div>

                            <div class="col-12 alert alert-danger d-none" id="signin_msg_container">
                                <div class="text-center" id="signin_msg"></div>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="email2">Email</label>
                                <input type="email" class="form-control" id="email2" value="<?php echo ($email); ?>" />
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="password2">Password</label>
                                <input type="password" class="form-control" id="password2" value="<?php echo ($password); ?>" />
                            </div>

                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rememberme">
                                    <label class="form-check-label" for="rememberme">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <a onclick="openForgotPasswordModel();" class="link-primary text-decoration-none c-pointer">Forgot Password?</a>
                            </div>

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-primary" onclick="signIn();">Sign In</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-danger" onclick="changeView();">New to AnyTrades? Join Now</button>
                            </div>


                        </div>
                    </div>
                    <!-- Sign Up -->

                </div>
            </div>
            <!-- Content -->

            <!-- Copyrights -->
            <div class="col-12 fixed-bottom d-none d-lg-block" style="z-index: 1;">
                <p class="text-center fw-bold">&copy; 2022 AnyTrades.com || All Rights Reserved</p>
            </div>
            <!-- Copyrights -->

            <div class="position-fixed bg-danger vh-100 vw-100 top-0 start-0 d-flex justify-content-center align-items-center flex-column d-none" id="suspendMode" style="z-index: 3;">
                <lord-icon src="https://cdn.lordicon.com/lfqzieho.json" trigger="loop" delay="1000" colors="primary:#ffffff" state="intro" style="width:250px;height:250px">
                </lord-icon>
                <span class="text-white fs-5 fw-bold l-space-1">Account was suspended.</span>
            </div>

        </div>
    </div>


    <script src="script.js"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
</body>

</html>