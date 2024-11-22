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
        <title>Orders || AnyTrades</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="admin_resources/admin.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="c-default">

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
                                        <a href="adminPanel.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
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
                                    <li class="my-2">
                                        <a href="orders.php" class="d-flex gap-2 align-items-center text-decoration-none p-2 active">
                                            <i class="icon-attach_money_black_24dp"></i>
                                            <span class="fs-5">Orders</span>
                                        </a>
                                    </li>
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
                                    <span class="fs-3 fw-bold" style="font-family: arial;">Orders</span>
                                </div>

                                <div class="d-flex justify-content-between w-100">
                                    <div class="border border-1 p-2 d-flex align-items-center gap-2 bg-secondary bg-opacity-25 w-50" style="border-radius: 100vh;">
                                        <i class="icon-search_black_24dp1 c-pointer fs-5 fw-bold text-primary" onclick="searchOrder(1);"></i>
                                        <input type="text" placeholder="Search by order id..." class="border-0 bg-transparent" style="outline: none; width: 100%;" id="searchOrderInput" onkeyup="searchOrderKey(event,1);" />
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

                        <hr class="my-2">

                        <div class="" id="searchOrderContainer">

                            <div class="col-12 overflow-auto">
                                <table class="table table-bordered table-dark border-success table-hover">
                                    <thead>
                                        <tr>
                                            <th rowspan="2">Order Id</th>
                                            <th colspan="2">Product</th>
                                            <th rowspan="2">Customer</th>
                                            <th rowspan="2">Date & Time</th>
                                            <th rowspan="2">Price</th>
                                            <th rowspan="2">Status</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th>Id</th>
                                            <th>Name</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php

                                        if (isset($_GET["page_no"])) {
                                            $page_no = $_GET["page_no"];
                                        } else {
                                            $page_no = 1;
                                        }

                                        $pagination_rs = Database::search("SELECT * FROM `invoice` INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `order_status` ON `order_status`.`id`=`invoice`.`order_status_id` WHERE invoice.status<>2 OR invoice.order_status_id<>5");
                                        $pagination_num = $pagination_rs->num_rows;

                                        $result_per_page = 15;
                                        $number_of_pages = ceil($pagination_num / $result_per_page);
                                        $offset = ($page_no - 1) * $result_per_page;

                                        $invoice_rs = Database::search("SELECT *,`invoice`.`date_time` AS `invoice_time`,`order_status`.`status` AS `invoice_status`,`invoice`.`id` AS `invoice_id` FROM `invoice` INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `order_status` ON `order_status`.`id`=`invoice`.`order_status_id` INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` WHERE invoice.status<>2 OR invoice.order_status_id<>5 ORDER BY `invoice`.`date_time` LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                        $invoice_num = $invoice_rs->num_rows;

                                        if ($invoice_num > 0) {
                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();
                                        ?>
                                                <tr>
                                                    <td><?php echo ($invoice_data["order_id"]); ?></td>
                                                    <td>ATP_<?php echo ($invoice_data["product_id"]); ?></td>
                                                    <td style="min-width: 180px;"><?php echo ($invoice_data["title"]); ?></td>
                                                    <td style="min-width: 180px;"><?php echo ($invoice_data["fname"] . " " . $invoice_data["lname"]); ?></td>
                                                    <td style="min-width: 180px;"><?php
                                                                                    echo ((explode(" ", $invoice_data["invoice_time"]))[0]);
                                                                                    echo (" ");
                                                                                    echo ((explode(":", (explode(" ", $invoice_data["invoice_time"]))[1]))[0]);
                                                                                    echo (":");
                                                                                    echo ((explode(":", (explode(" ", $invoice_data["invoice_time"]))[1]))[1]);
                                                                                    echo (" ");
                                                                                    if ((explode(":", (explode(" ", $invoice_data["invoice_time"]))[1]))[0] > 11) {
                                                                                        echo ("PM");
                                                                                    } else {
                                                                                        echo ("AM");
                                                                                    }
                                                                                    ?></td>
                                                    <td>Rs. <?php echo ($invoice_data["total"]); ?>.00</td>
                                                    <td class="<?php
                                                                if ($invoice_data["order_status_id"] == "1") {
                                                                    echo ("text-white");
                                                                } else if ($invoice_data["order_status_id"] == "2") {
                                                                    echo ("text-info");
                                                                } else if ($invoice_data["order_status_id"] == "3") {
                                                                    echo ("text-warning");
                                                                } else if ($invoice_data["order_status_id"] == "4") {
                                                                    echo ("text-danger");
                                                                } else if ($invoice_data["order_status_id"] == "5") {
                                                                    echo ("text-primary");
                                                                }
                                                                ?>"><?php echo ($invoice_data["invoice_status"]); ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center gap-3">
                                                            <i class="icon-arrow_circle_up_black_24dp text-success fs-3 c-pointer" onclick="changeOrderStatus(1,'<?php echo ($invoice_data['invoice_id']); ?>');"></i>
                                                            <i class="icon-arrow_circle_down_black_24dp text-warning fs-3 c-pointer" onclick="changeOrderStatus(2,'<?php echo ($invoice_data['invoice_id']); ?>');"></i>
                                                            <i class="icon-delete_forever_black_24dp text-danger fs-3 c-pointer" onclick="orderDeleteViewer('<?php echo ($invoice_data['invoice_id']); ?>');"></i>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>

                                            <tr>
                                                <td colspan="8">
                                                    <div class="text-center text-danger fs-3 fw-bolder" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                                        No items to view...
                                                    </div>
                                                </td>
                                            </tr>

                                        <?php
                                        }

                                        ?>
                                    </tbody>
                                </table>
                            </div>







                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                <div class="p_nation">

                                    <?php

                                    $middle_page;
                                    $middle_left;
                                    $middle_right;

                                    if ($page_no <= 1) {
                                        $middle_page = ceil($number_of_pages / 2);
                                    } else if ($page_no >= $number_of_pages) {
                                        $middle_page = ceil($number_of_pages / 2);
                                    } else {
                                        $middle_page = $page_no;
                                    }

                                    $middle_left = $middle_page - 1;
                                    $middle_right = $middle_page + 1;


                                    ?>

                                    <!--  -->
                                    <a class="text-decoration-none p_nation_prev" href="?page_no=<?php
                                                                                                    if ($page_no > 1) {
                                                                                                        echo ($page_no - 1);
                                                                                                    } else {
                                                                                                        echo ("1");
                                                                                                    }
                                                                                                    ?>" <?php
                                                                                                        if ($page_no == 1) {
                                                                                                        ?> style="opacity: 0.5;" <?php
                                                                                                                                }
                                                                                                                                    ?>>
                                        <span class="d-none d-lg-block">Prev</span>
                                        <i class="icon-arrow_circle_left_black_24dp d-block d-lg-none"></i>
                                    </a>


                                    <!-- First Page of the Pagination -->
                                    <a href="?page_no=1" <?php
                                                            if ($page_no == "1") {
                                                            ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                            }
                                                                                                                ?>>1</a>
                                    <!-- First Page of the Pagination -->


                                    <!-- Inter ... of the Pagination -->
                                    <?php
                                    if (($middle_left != 2) && ($middle_left > 1)) {
                                    ?>
                                        <a href="">...</a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Inter ... of the Pagination -->


                                    <!-- Middle Left Button of the Pagination -->
                                    <?php
                                    if ($middle_left > 1) {
                                    ?>
                                        <a href="?page_no=<?php echo ($middle_left); ?>" <?php
                                                                                            if ($page_no == $middle_left) {
                                                                                            ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                            }
                                                                                                                                                ?>><?php echo ($middle_left); ?></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Middle Left Button of the Pagination -->

                                    <!-- Middle Button of the Pagination -->
                                    <?php
                                    if ($number_of_pages > 2) {
                                    ?>
                                        <a href="?page_no=<?php echo ($middle_page); ?>" <?php
                                                                                            if ($page_no == $middle_page) {
                                                                                            ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                            }
                                                                                                                                                ?>><?php echo ($middle_page); ?></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Middle Button of the Pagination -->


                                    <!-- Middle Right Button of the Pagination -->
                                    <?php
                                    if ($middle_right < $number_of_pages) {
                                    ?>
                                        <a href="?page_no=<?php echo ($middle_right); ?>" <?php
                                                                                            if ($page_no == $middle_right) {
                                                                                            ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                            }
                                                                                                                                                ?>><?php echo ($middle_right); ?></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Middle Right Button of the Pagination -->


                                    <!-- Inter ... of the pagination -->
                                    <?php
                                    if ($middle_right != ($number_of_pages - 1) && ($middle_right < ($number_of_pages - 1))) {
                                    ?>
                                        <a href="">...</a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Inter ... of the pagination -->


                                    <!-- Last page of the pagination -->
                                    <?php
                                    if ($number_of_pages > 1) {
                                    ?>
                                        <a href="?page_no=<?php echo ($number_of_pages); ?>" <?php
                                                                                                if ($page_no == $number_of_pages) {
                                                                                                ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                                }
                                                                                                                                                    ?>><?php echo ($number_of_pages); ?></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Last page of the pagination -->


                                    <!-- Next Button of the pagination -->
                                    <a class="text-decoration-none p_nation_next" href="?page_no=<?php
                                                                                                    if ($page_no < $number_of_pages) {
                                                                                                        echo ($page_no + 1);
                                                                                                    } else {
                                                                                                        echo ($number_of_pages);
                                                                                                    }
                                                                                                    ?>" <?php
                                                                                                        if ($page_no == $number_of_pages) {
                                                                                                        ?> style="opacity: 0.5;" <?php
                                                                                                                                }
                                                                                                                                    ?>>
                                        <span class="d-none d-lg-block">Next</span>
                                        <i class="icon-arrow_circle_right_black_24dp1 d-block d-lg-none"></i>
                                    </a>
                                    <!-- Next Button of the pagination -->

                                </div>
                            </div>
                            <!-- Pagination -->

                        </div>









                    </div>
                </div>
                <!-- Content -->



                <div class="position-fixed top-0 start-0 vw-100 vh-100 bg-dark bg-opacity-25 d-flex justify-content-center align-items-center d-none" id="orderDeleteModal">
                    <div class="rounded shadow overflow-hidden pb-2 bg-white col-xxl-3 col-xl-4 col-lg-5 col-md-6 col-sm-7 col-8">
                        <div class="bg-warning p-2">
                            <div class="d-flex text-white align-items-center gap-2">
                                <span class="fs-5 fw-bold">warning</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-center gap-3 p-2">
                            <div class="w-100">
                                <label for="" class="form-label fw-bold">Confirm the request</label>
                                <input type="password" class="form-control" placeholder="Password" id="admin_psw" />
                                <input type="text" disabled class="form-control mt-1" id="order_id" />
                            </div>
                            <div class="">
                                <button class="btn btn-primary px-4" style="border-radius: 100vh;" onclick="deleteOrder();">Delete</button>
                                <button class="btn btn-danger px-4" style="border-radius: 100vh;" onclick="orderDeleteViewer();">Cancell</button>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>

        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:adminSignin.php");
}

?>