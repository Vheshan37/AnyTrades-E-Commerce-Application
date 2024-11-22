<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin SignIn || AnyTrades</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="icomoon.css" />
</head>

<body class="c-default admin-background bg-dark">

<?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row">

            <div class="container-xl">
                <div class="row vh-100 vw-100 d-flex justify-content-center align-items-center flex-column overflow-hidden">

                    <img src="resources/2483960.jpg" alt="" class="" style="clip-path: circle(); width: 200px;">
                    <div class="fw-bolder text-center mt-1 fs-2 text-white">AnyTrades</div>

                    <div class="col-12 mt-4">
                        <div class="row">

                            <div class="col-6 d-none d-lg-block signin-logo">

                            </div>
                            <div class="col-lg-6 col-10 offset-1 offset-lg-0">
                                <div class="row">

                                    <label for="" class="form-label fs-4 fw-bold mb-2 text-white">Admin SignIn</label>

                                    <div class="d-flex flex-column gap-3">
                                        <div class="col-12 col-xl-8 d-flex align-items-center position-relative">
                                            <input type="text" class="text-white bg-transparent p-2 rounded w-100" id="emailInput" style="outline: none; border: 1px solid;" onclick="placeHolderMove('e');" required />
                                            <label for="" class="position-absolute ms-2 bg-dark text-white px-1" style="z-index: -1;" id="emailHolder">Email</label>
                                        </div>

                                        <div class="col-12 col-xl-8 d-flex align-items-center position-relative">
                                            <input type="password" class="text-white bg-transparent p-2 rounded w-100" id="pswInput" maxlength="20" style="outline: none; border: 1px solid;" onclick="placeHolderMove('p');" required onfocus="placeHolderMove('p')" />
                                            <label for="" class="position-absolute ms-2 bg-dark text-white px-1" style="z-index: -1;" id="passwordHolder">Password</label>
                                            <i class="icon-visibility_off_black_24dp text-white position-absolute end-0 me-2 c-pointer" onclick="viewPassword();" id="viewIcon"></i>
                                        </div>

                                        <div class="col-12 col-xl-8">
                                            <div class="row">

                                                <div class="d-flex gap-3">
                                                    <button class="btn btn-primary w-100" onclick="signInModalViewer('o');">Verify</button>
                                                    <a class="btn btn-light w-100" href="index.php">Customer Login</a>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Verification Modal for Admin Signin -->
                    <div class="vw-100 vh-100 bg-black bg-opacity-75 position-absolute top-0 start-0 d-flex justify-content-center align-items-center d-none" id="signInModal" style="z-index: 2;">
                        <div class="" style="min-width: 350px; max-width: 95%;">
                            <div class="bg-dark border border-white rounded-top border-bottom-0 p-2 text-center fs-5">
                                <span class="text-white">Admin Verification</span>
                            </div>
                            <div class="bg-white px-3 pt-2">
                                <div class="d-flex flex-column">
                                    <label for="" class="form-label fw-bold">Email</label>
                                    <input type="text" name="" id="verifyEmail" disabled class="form-control">
                                </div>
                                <div class="d-flex flex-column mt-3">
                                    <label for="" class="form-label fw-bold">Verification Code</label>
                                    <input type="text" name="" id="verifyCode" class="form-control">
                                </div>

                                <div class="mt-3">
                                    <span class="fw-bold">The verification code has been sent to the email.
                                        <br>
                                        <a class="text-danger" href="https://mail.google.com/mail/u/0/?tab=rm#inbox">
                                            please check your email.
                                        </a>
                                    </span>
                                </div>

                                <div class="d-flex mt-3 justify-content-center">
                                    <button class="btn btn-dark w-auto d-flex gap-2 align-items-center px-3 mb-3" onclick="adminLogin();">
                                        <span>Login</span>
                                        <i class="icon-login-svgrepo-com"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-dark border border-white rounded-bottom border-top-0 p-1 text-center">
                                <span class="text-white text-decoration-underline c-pointer" onclick="signInModalViewer('c');">Close</span>
                            </div>
                        </div>
                    </div>
                    <!-- Verification Modal for Admin Signin -->

                </div>
            </div>

        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>