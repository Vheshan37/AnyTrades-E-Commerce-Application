<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaderboard || AnyTrades</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="admin_resources/admin.css" />
    <link rel="stylesheet" href="icomoon.css" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="icon" href="resources/AnyTrades logo.png" type="image">
</head>

<body class="c-default">

    <div class="container-fluid">
        <div class="row">

            <!-- Side Bar -->
            <div class="col-xxl-2 col-xl-3 col-lg-4 col-6 col-md-5 bg-white border-end min-vh-100 admin-sidebar" style="max-height: 100vh; overflow-y: auto;" id="adminSideBar">
                <div class="row p-1">

                    <div class="d-flex justify-content-between">
                        <div class="d-flex gap-2 align-items-center">
                            <div class="width-50 height-50 bg-primary rounded-circle d-flex justify-content-center align-items-center text-white fw-bold">AT</div>
                            <h2 class="fw-bold">AnyTrades</h2>
                        </div>
                        <div class="d-flex align-items-center d-block d-lg-none">
                            <i class="icon-close_black_24dp fs-4 fw-bold c-pointer text-danger" onclick="adminSideBarMove();"></i>
                        </div>
                    </div>

                    <hr class="my-1">

                    <div class="col-12">
                        <div class="row p-1">

                            <ul class="list-unstyled admin-panel-menu">
                                <li class="my-2">
                                    <a href="adminPanel.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                        <i class="icon-dashboard_black_24dp"></i>
                                        <span class="fs-5">Dashboard</span>
                                    </a>
                                </li>
                                <li class="my-2">
                                    <a href="leaderBoard.php" class="d-flex gap-2 align-items-center text-decoration-none p-2 active">
                                        <i class="icon-bar_chart_black_24dp"></i>
                                        <span class="fs-5">Leaderboard</span>
                                    </a>
                                </li>
                                <li class="my-2">
                                    <a href="adminProduct.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                        <i class="icon-shopping_bag_black_24dp"></i>
                                        <span class="fs-5">Product</span>
                                    </a>
                                </li>
                                <!-- <li class="my-2">
                                    <a href="orders.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                        <i class="icon-attach_money_black_24dp"></i>
                                        <span class="fs-5">Orders</span>
                                    </a>
                                </li> -->
                                <li class="my-2">
                                    <a href="manageUser.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                        <i class="icon-user-profile-svgrepo-com"></i>
                                        <span class="fs-5">Manage Users</span>
                                    </a>
                                </li>
                            </ul>

                        </div>
                    </div>

                </div>
            </div>
            <!-- Side Bar -->

            <!-- Center content -->
            <div class="col-xxl-10 col-xl-9 col-lg-8 min-vh-100" style="max-height: 100vh; overflow-y: auto;">
                <div class="row">

                    <!-- Header -->
                    <div class="col-12 mt-2">
                        <div class="d-flex gap-3 flex-column flex-xl-row">

                            <div class="d-flex gap-3 align-items-center justify-content-between justify-content-lg-end">
                                <i class="icon-menu_black_24dp fs-3 fw-bold d-block d-lg-none c-pointer" onclick="adminSideBarMove();"></i>
                                <span class="fs-3 fw-bold" style="font-family: arial;">Leaderboard</span>
                            </div>

                            <div class="d-flex justify-content-between w-100">
                                <div class="border border-1 p-2 d-flex align-items-center gap-2 bg-secondary bg-opacity-25 w-50" style="border-radius: 100vh;">
                                    <i class="icon-search_black_24dp1 c-pointer fs-5 fw-bold text-primary"></i>
                                    <input type="text" placeholder="Search here..." class="border-0 bg-transparent" style="outline: none; width: 100%;">
                                </div>

                                <div class="d-flex gap-1">
                                    <img src="resources/profile_images/Vihanga_profile_img_636b2c60b5189.jpeg" alt="" style="width: 50px; height: 50px; clip-path: circle();">
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">Vihanga Heshan</span>
                                        <span class="text-black-50">Admin</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="icon-expand_more_black_24dp fs-4 c-pointer"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Header -->

                    <hr class="my-2">

                    <!-- Content here -->

                    <!-- Content here -->

                </div>
            </div>
            <!-- Center content -->




        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>