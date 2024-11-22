<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Registration | AnyTrades</title>

    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="resources/AnyTrades logo.png" type="image">
</head>

<body class="s-r-body">

<?php require "alert.php"; ?>

    <div class="container-fluid vh-100 d-flex justify-content-center flex-column">
        <div class="row">

            <!-- Seller Reg Form -->
            <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6 mid-content" id="seller_reg">
                <div class="row g-3 p-3 form">

                    <div class="col-12">
                        <h3 class="fw-bold">Seller Registration</h3>
                    </div>

                    <div class="col-12 alert alert-danger d-none" id="signup_msg_container">
                        <div class="text-center" id="form-msg"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold" for="s_email">Email</label>
                        <input type="email" class="form-control" id="s_email" />
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" for="s_password">Password</label>
                        <input type="password" class="form-control" id="s_password" />
                    </div>

                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-bold" for="s_mobile">Seller Mobile</label>
                        <input type="text" class="form-control" id="s_mobile" />
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label fw-bold" for="nic">NIC</label>
                        <input type="text" class="form-control" id="nic" />
                    </div>

                    <div class="col-6">
                        <a href="#" class="link-primary text-decoration-none">Forgot Password?</a>
                    </div>

                    <div class="col-12">
                        <div class="row g-2">

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="text-white btn seller-btn" onclick="sellerRegistration();">Register</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="text-white btn seller-btn" onclick="sellerFormView();">Already have an account? Sign in</button>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <!-- Seller Reg Form -->

            <!-- Seller Sign in Form -->
            <div class="col-12 col-md-10 col-lg-8 col-xl-6 mid-content d-none" id="seller_login">
                <div class="row g-3 p-3 form">

                    <div class="col-12">
                        <h3 class="fw-bold">Seller Login</h3>
                    </div>

                    <div class="col-12 alert alert-danger d-none" id="signup_msg_container">
                        <div class="text-center" id="form-msg"></div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-bold" for="s_s_email">Email</label>
                        <input type="email" class="form-control" id="s_s_email" />
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold" for="s_s_nic">NIC</label>
                        <input type="text" class="form-control" id="s_s_nic" />
                    </div>

                    <div class="col-6">
                        <a href="#" class="link-primary text-decoration-none">Forgot Password?</a>
                    </div>

                    <div class="col-12">
                        <div class="row g-2">

                            <div class="col-12 col-lg-6 d-grid">
                                <button class="text-white btn seller-btn" onclick="sellerSignIn();">Login</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="text-white btn seller-btn" onclick="sellerFormView();">Create Account</button>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
            <!-- Seller Sign in Form -->


        </div>
    </div>


    <script src="script.js"></script>
</body>

</html>