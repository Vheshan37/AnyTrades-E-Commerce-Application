<?php

require "connection.php";
session_start();

if (isset($_SESSION["at_admin"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Panel</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="admin_resources/admin.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="c-default" onload="chartLoad();">

    <?php require "alert.php"; ?>
    
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
                                        <a href="adminPanel.php" class="d-flex gap-2 align-items-center text-decoration-none p-2 active">
                                            <i class="icon-dashboard_black_24dp"></i>
                                            <span class="fs-5">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="my-2">
                                        <a href="leaderBoard.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
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

                <!-- Content -->
                <div class="col-xxl-10 col-xl-9 col-lg-8 min-vh-100" style="max-height: 100vh; overflow-y: auto;">
                    <div class="row">

                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3 flex-column flex-xl-row">

                                <div class="d-flex gap-3 align-items-center justify-content-between justify-content-lg-end">
                                    <i class="icon-menu_black_24dp fs-3 fw-bold d-block d-lg-none c-pointer" onclick="adminSideBarMove();"></i>
                                    <span class="fs-3 fw-bold" style="font-family: arial;">Dashboard</span>
                                </div>

                                <div class="d-flex justify-content-end w-100">
                                    <!-- <div class="border border-1 p-2 d-flex align-items-center gap-2 bg-secondary bg-opacity-25 w-50" style="border-radius: 100vh;">
                                    <i class="icon-search_black_24dp1 c-pointer fs-5 fw-bold text-primary"></i>
                                    <input type="text" placeholder="Search here..." class="border-0 bg-transparent" style="outline: none; width: 100%;">
                                </div> -->

                                    <div class="d-flex gap-1">
                                        <!-- <img src="resources/profile_images/Vihanga_profile_img_636b2c60b5189.jpeg" alt="" style="width: 50px; height: 50px; clip-path: circle();"> -->
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold"><?php echo($_SESSION["at_admin"]["name"]) ?></span>
                                            <span class="text-black-50">Admin</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="icon-expand_more_black_24dp fs-4 c-pointer"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="admin-dashboard">

                            <?php

                            $d = new DateTime();
                            $tz = new DateTimeZone("Asia/colombo");
                            $d->setTimezone($tz);
                            $today = $d->format("Y-m-d");

                            // Total Sales
                            $a = "0";
                            $a1 = 0;

                            // Total Orders
                            $b = 0;
                            $b1 = 0;

                            // Total Products
                            $c = 0;
                            $c1 = 0;

                            // New Users
                            $d = 0;
                            $d1 = 0;

                            // Sales Calculation ########################################
                            $total_rs = Database::search("SELECT * FROM `invoice`");
                            $total_num = $total_rs->num_rows;

                            $td = new DateTime();
                            $tz = new DateTimeZone("Asia/colombo");
                            $td->setTimezone($tz);
                            $ttoday = $td->format("Y-m-d");

                            $ty =  $td->modify('-1 day');
                            $tyesterday = $ty->format("Y-m-d");

                            $t = 0;
                            $yt = 0;
                            for ($x = 0; $x < $total_num; $x++) {
                                $total_data = $total_rs->fetch_assoc();
                                $total_date = (explode(" ", $total_data["date_time"]))[0];
                                if ($total_date == $ttoday) {
                                    $t += $total_data["total"];
                                } else if ($total_date == $tyesterday) {
                                    $yt += $total_data["total"];
                                }

                                $invoice_date = (explode(" ", $total_data["date_time"]))[0];

                                if ($invoice_date == $today) {
                                    $a += $total_data["total"];
                                }
                            }

                            if ($a > 0) {
                                $tyesterday_count = (($yt / $a) * 100);
                                $ttoday_count = (($t / $a) * 100);
                                $total_difference = $ttoday_count - $tyesterday_count;
                            } else {
                                $total_difference = 0;
                            }
                            // Sales Calculation ########################################

                            // Order Calculation ########################################
                            $order_rs = Database::search("SELECT * FROM `invoice`");
                            $order_num = $order_rs->num_rows;

                            $od = new DateTime();
                            $tz = new DateTimeZone("Asia/colombo");
                            $od->setTimezone($tz);
                            $otoday = $od->format("Y-m-d");

                            $oy =  $od->modify('-1 day');
                            $oyesterday = $oy->format("Y-m-d");

                            $o = 0;
                            $yo = 0;
                            for ($x = 0; $x < $order_num; $x++) {
                                $order_data = $order_rs->fetch_assoc();
                                $order_data = (explode(" ", $order_data["date_time"]))[0];
                                if ($order_data == $otoday) {
                                    $o += 1;
                                } else if ($order_data == $oyesterday) {
                                    $yo += 1;
                                }

                                $order_date = (explode(" ", $total_data["date_time"]))[0];

                                if ($order_date == $today) {
                                    $b += 1;
                                }
                            }

                            if ($b > 0) {
                                $oyesterday_count = (($yo / $order_num) * 100);
                                $otoday_count = (($o / $order_num) * 100);
                                $order_difference = $otoday_count - $oyesterday_count;
                            } else {
                                $order_difference = 0;
                            }
                            // Order Calculation ########################################

                            // Product Calculation ########################################
                            $product_rs = Database::search("SELECT * FROM `product`");
                            $product_num = $product_rs->num_rows;
                            // $c = $product_num;

                            $pd = new DateTime();
                            $tz = new DateTimeZone("Asia/colombo");
                            $pd->setTimezone($tz);
                            $ptoday = $pd->format("Y-m-d");

                            $py =  $pd->modify('-1 day');
                            $pyesterday = $py->format("Y-m-d");

                            $p = 0;
                            $yp = 0;
                            for ($x = 0; $x < $product_num; $x++) {
                                $product_data = $product_rs->fetch_assoc();
                                $product_date = (explode(" ", $product_data["date_time"]))[0];
                                if ($product_data == $ptoday) {
                                    $c += 1;
                                    $p += 1;
                                } else if ($product_date == $pyesterday) {
                                    $yp += 1;
                                }
                            }

                            $pyesterday_count = (($yp / $product_num) * 100);
                            $ptoday_count = (($p / $product_num) * 100);
                            $product_difference = $ptoday_count - $pyesterday_count;
                            // Product Calculation #########################################

                            // User Calculation ########################################
                            $ud = new DateTime();
                            $tz = new DateTimeZone("Asia/colombo");
                            $ud->setTimezone($tz);
                            $today = $ud->format("Y-m-d");

                            $y =  $ud->modify('-1 day');
                            $yesterday = $y->format("Y-m-d");

                            $user_rs = Database::search("SELECT * FROM `user`");
                            $user_num  = $user_rs->num_rows;

                            $u = 0;
                            $yu = 0;
                            for ($x = 0; $x < $user_num; $x++) {
                                $user_data = $user_rs->fetch_assoc();
                                $user_date = (explode(" ", $user_data["join_date"]))[0];
                                if ($user_date == $today) {
                                    $u += 1;
                                } else if ($user_date == $yesterday) {
                                    $yu += 1;
                                }
                            }

                            $yesterday_count = (($yu / $user_num) * 100);
                            $today_count = (($u / $user_num) * 100);
                            $user_difference = $today_count - $yesterday_count;
                            // User Calculation ########################################

                            ?>

                            <div class="">
                                <div class="d-flex flex-column gap-2">
                                    <span class="fs-5 fw-bold bg-dark text-white px-3">Today Summery</span>
                                    <div class="summery-items px-2">
                                        <div class="">
                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class="">Rs. <?php echo ($a); ?>.00</span>
                                            <span class="">Today Sales</span>
                                            <span class="<?php if ($total_difference == 0) {
                                                                echo ("text-danger");
                                                            } else if ($tyesterday_count > $ttoday_count) {
                                                                echo ("text-danger");
                                                            } else {
                                                                echo ("text-primary");
                                                            } ?>"><?php echo (round($total_difference, 2) . "%"); ?> from yesterday</span>
                                        </div>
                                        <div class="">
                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class=""><?php echo ($b); ?></span>
                                            <span class="">Today Orders</span>
                                            <span class="<?php if ($order_difference == 0) {
                                                                echo ("text-danger");
                                                            } else if ($oyesterday_count > $otoday_count) {
                                                                echo ("text-danger");
                                                            } else {
                                                                echo ("text-primary");
                                                            } ?>"><?php echo (round($order_difference, 2) . "%"); ?> from yesterday</span>
                                        </div>
                                        <div class="">
                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class=""><?php echo ($c); ?></span>
                                            <span class="">Today Products</span>
                                            <span class="<?php if ($product_difference == 0) {
                                                                echo ("text-danger");
                                                            } else if ($pyesterday_count > $ptoday_count) {
                                                                echo ("text-danger");
                                                            } else {
                                                                echo ("text-primary");
                                                            } ?>"><?php echo (round($product_difference, 2) . "%"); ?> from yesterday</span>
                                        </div>
                                        <div class="">
                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class=""><?php echo ($u . " / " . $user_num); ?></span>
                                            <span class="">New Users</span>
                                            <span class="<?php if ($yesterday_count > $today_count) {
                                                                echo ("text-danger");
                                                            } else {
                                                                echo ("text-primary");
                                                            } ?>"><?php echo (round($user_difference, 2) . "%"); ?> from yesterday</span>
                                        </div>
                                    </div>
                                    <span class="fs-5 fw-bold bg-dark text-white px-3">Total Summery</span>
                                    <div class="summery-items px-2">
                                        <div class="">

                                            <?php

                                            $total2_rs = Database::search("SELECT SUM(`total`) AS `total` FROM `invoice`");
                                            $total2_data = $total2_rs->fetch_assoc();

                                            ?>

                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class="">Rs. <?php echo ($total2_data["total"]); ?>.00</span>
                                            <span class="">Total Sales</span>
                                        </div>
                                        <div class="">

                                            <?php

                                            $order2_rs = Database::search("SELECT COUNT(*) AS `orders` FROM `invoice`");
                                            $order2_data = $order2_rs->fetch_assoc();

                                            ?>

                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class=""><?php echo ($order2_data["orders"]); ?></span>
                                            <span class="">Total Orders</span>
                                        </div>
                                        <div class="">
                                            <?php

                                            $product2_rs = Database::search("SELECT COUNT(*) AS `products` FROM `product`");
                                            $product2_data = $product2_rs->fetch_assoc();

                                            ?>

                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class=""><?php echo ($product2_data["products"]); ?></span>
                                            <span class="">Total Products</span>
                                        </div>
                                        <div class="">

                                            <?php

                                            $user2_rs = Database::search("SELECT COUNT(*) AS `users` FROM `user`");
                                            $user2_data = $user2_rs->fetch_assoc();

                                            ?>

                                            <i class="icon-assignment_black_24dp"></i>
                                            <span class=""><?php echo ($user2_data["users"]); ?></span>
                                            <span class="">All Users</span>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <?php

                            $top_rs = Database::search("SELECT SUM(`qty`) AS `sum_qty`,COUNT(DISTINCT `product_id`) AS `product`,`user_email` FROM `invoice` GROUP BY `user_email` ORDER BY `sum_qty` DESC LIMIT 1");
                            $top_num = $top_rs->num_rows;

                            if ($top_num > 0) {
                                $top_data = $top_rs->fetch_assoc();

                                $top_details_rs = Database::search("SELECT * FROM `user` INNER JOIN `seller` ON `seller`.`user_email`=`user`.`email` WHERE `user`.`email`='" . $top_data["user_email"] . "'");
                                $top_details_data = $top_details_rs->fetch_assoc();

                                $top_earn_rs = Database::search("SELECT SUM(`total`) AS `total` FROM `invoice` WHERE `user_email`='" . $top_data["user_email"] . "'");
                                $top_earn_data = $top_earn_rs->fetch_assoc();

                                $top_img_rs =  Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $top_data["user_email"] . "'");
                                $top_img_num = $top_img_rs->num_rows;
                                if ($top_img_num > 0) {
                                    $top_img_data = $top_img_rs->fetch_assoc();
                                    $top_img = $top_img_data["p_img"];
                                } else {
                                    $top_img = "resources/new_user.svg";
                                }

                            ?>
                                <!-- Top 1 -->
                                <div class="border-start">
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="<?php echo ($top_img); ?>" alt="" class="toper">
                                        <img src="resources/top_1.png" alt="" style="width: 100px;" class="top_img">
                                    </div>
                                    <div class="">
                                        <div class="text-center fs-4"><?php echo ($top_details_data["fname"] . " " . $top_details_data["lname"]); ?></div>
                                        <div class="text-center text-black-50"><?php echo ($top_details_data["email"]); ?></div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <table class="table w-75 table-bordered table-striped-columns">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-bold">Products</td>
                                                    <td><?php echo ($top_data["product"]); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Items</td>
                                                    <td><?php echo ($top_data["sum_qty"]); ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Earn</td>
                                                    <td>Rs. <?php echo ($top_earn_data["total"]); ?>.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-outline-primary" style="border-radius: 100vh;">View More</button>
                                    </div>
                                </div>
                                <!-- Top 1 -->
                            <?php
                            } else {
                            ?>
                                <!-- Top 1 -->
                                <div class="border-start">
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="resources/2483946.jpg" alt="" class="toper">
                                        <img src="resources/top_1.png" alt="" style="width: 100px;" class="top_img">
                                    </div>
                                    <div class="">
                                        <div class="text-center fs-4">Vihanga Heshan</div>
                                        <div class="text-center text-black-50">vihangaheshan37@gmail.com</div>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <table class="table w-75 table-bordered table-striped-columns">
                                            <tbody>
                                                <tr>
                                                    <td class="fw-bold">Products</td>
                                                    <td>53</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Items</td>
                                                    <td>53</td>
                                                </tr>
                                                <tr>
                                                    <td class="fw-bold">Earn</td>
                                                    <td>53</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-outline-primary" style="border-radius: 100vh;">View More</button>
                                    </div>
                                </div>
                                <!-- Top 1 -->
                            <?php
                            }

                            ?>




                            <div class="col-12">
                                <div class="fw-bold alert alert-primary text-dark text-center fs-5">All Products</div>
                                <canvas id="myChart"></canvas>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- Content -->

            </div>
        </div>

        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:adminsignin.php");
}

?>