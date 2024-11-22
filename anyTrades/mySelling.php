<?php
session_start();
require "connection.php";

if (isset($_SESSION["seller"])) {
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Seller House | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body style="min-height: 100vh;">

    <?php require "alert.php"; ?>

        <!-- Remove Product -->
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
                        <input type="password" class="form-control" placeholder="Your NIC" id="admin_psw" />
                        <input type="text" disabled class="form-control mt-1" id="order_id" />
                    </div>
                    <div class="">
                        <button class="btn btn-primary px-4" style="border-radius: 100vh;" onclick="deleteOrder();">Delete</button>
                        <button class="btn btn-danger px-4" style="border-radius: 100vh;" onclick="orderDeleteViewer();">Cancell</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Remove Product -->


        <!-- View Customer Address -->
        <div class="box" id="customerAddress">
            <div class="signoutBox rounded pb-1 bg-white">

                <div class="box-head bg-success">
                    <label class="fw-bold p-1 text-white">Customer Address &#9888;</label>
                </div>

                <div class="box-body mt-5">
                    <label class="p-1" id="customerAddressDisplay">...</label>
                </div>

                <div class="box-footer gap-2 p-1 px-2">
                    <button class="btn btn-primary" id="removeYes" onclick="viewCustomerAddress(false,null);">Done</button>
                </div>

            </div>
        </div>
        <!-- View Customer Address -->


        <div class="container-fluid">
            <div class="row">

                <?php include "header.php" ?>


                <div class="col-12">
                    <div class="row home-head">

                        <!-- Home Header -->
                        <div class="col-12 p-0">
                            <div class="d-flex align-items-center home-header py-2">

                                <div class="site-name">
                                    <span class="f-Debugged">SellerHouse</span>
                                </div>

                                <!-- Nav Bar -->
                                <div class="home-nav">

                                    <div class="fs-3 d-block d-lg-none">
                                        <a href="#" onclick="mobileNavBar();">&#9776;</a>
                                    </div>

                                    <div class="">
                                        <a href="addNewProduct.php">Add New Product</a>
                                    </div>
                                    <div class="">
                                        <a href="#" onclick="filterPanelMove()">Filter Panel</a>
                                    </div>
                                    <div class="">
                                        <a href="#">Customer Reviews</a>
                                    </div>
                                    <div class="">
                                        <a href="myWallet.php">Wallet</a>
                                    </div>

                                    <div class="d-flex justify-content-end">

                                        <div class="home-search-bar">
                                            <input type="text" placeholder="Search orders" />
                                            <span class="fw-bold">Search</span>
                                        </div>
                                    </div>

                                </div>
                                <!-- Nav Bar -->

                                <!-- Mobile-nav-bar -->
                                <div class="mobile-nav-bar bg-dark d-lg-none" style="min-height: 100vh;" id="mobile-nav-bar">

                                    <div class="col-12 mb-3 mt-3">
                                        <img src="resources/profile_images/new_user.svg" class="mid-content">

                                        <span class="text-center d-block fw-bold text-white">Vihanga Heshan</span>
                                        <span class="text-center d-block text-white-50 fw-bold">vihangaheshan37@gmail.com</span>
                                        <!-- <a href="#" class="text-center d-block">Sign in or Register</a> -->
                                    </div>


                                    <div class="col-12 px-1">
                                        <hr>
                                    </div>


                                    <ul>
                                        <li><a href="addNewProduct.php" class="fw-bold">Add New Product</a></li>
                                        <li><a href="#" class="fw-bold" onclick="filterPanelMove();">Filter Panel</a></li>
                                        <li><a href="userPanel.php" class="fw-bold">Customer Reviews</a></li>
                                        <li><a href="#" class="fw-bold">Wallet</a></li>
                                    </ul>

                                </div>
                                <!-- Mobile-nav-bar -->

                            </div>
                        </div>
                        <!-- Home Header -->


                    </div>
                </div>
                <!-- Head -->


                <!-- My Product Filter Panel -->
                <div class="col-12 filterPanel" id="filterPanel">
                    <div class="row g-2">

                        <div class="col-xl-3 offset-xl-2 col-6 col-lg-4">
                            <select class="form-select">
                                <option value="0">Filter By</option>
                                <option value="0">Added Date</option>
                                <option value="0">Title</option>
                                <option value="0">Quantity</option>
                                <option value="0">Rating</option>
                                <option value="0">Sellings</option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-6 col-lg-4">
                            <select class="form-select">
                                <option value="0">Order By</option>
                                <option value="0">Ascending</option>
                                <option value="0">Descending</option>
                            </select>
                        </div>

                        <div class="col-xl-3 col-10 offset-1 offset-lg-0 col-lg-4">
                            <div class="row">
                                <div class="col-6 d-grid">
                                    <button class="btn btn-primary">Apply Filter</button>
                                </div>
                                <div class="col-6 d-grid">
                                    <button class="btn btn-dark">Clear Filter</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- My Product Filter Panel -->


                <!-- Orders -->
                <div class="min-vh-100">
                    <div class="row">

                        <!-- <div class="col-12 mt-2">
                            <div class="d-flex gap-3 flex-column flex-xl-row align-items-center">

                                <div class="d-flex justify-content-center w-100">
                                    <div class="border border-1 p-2 d-flex align-items-center gap-2 bg-secondary bg-opacity-25 w-50" style="border-radius: 100vh;">
                                        <i class="icon-search_black_24dp1 c-pointer fs-5 fw-bold text-primary" onclick="searchOrder(1);"></i>
                                        <input type="text" placeholder="Search by order id..." class="border-0 bg-transparent" style="outline: none; width: 100%;" id="searchOrderInput" onkeyup="searchOrderKey(event,1);" />
                                    </div>
                                </div>

                            </div>
                        </div> -->

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

                                        $pagination_rs = Database::search("SELECT * FROM `invoice` 
                                                                    INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` 
                                                                    INNER JOIN `order_status` ON `order_status`.`id`=`invoice`.`order_status_id` 
                                                                    WHERE (invoice.status<>2 OR invoice.order_status_id<>5) AND seller_nic='" . $_SESSION["seller"]["nic"] . "'");
                                        $pagination_num = $pagination_rs->num_rows;

                                        $result_per_page = 15;
                                        $number_of_pages = ceil($pagination_num / $result_per_page);
                                        $offset = ($page_no - 1) * $result_per_page;

                                        $invoice_rs = Database::search("SELECT *,
                                                                    `invoice`.`date_time` AS `invoice_time`,
                                                                    `order_status`.`status` AS `invoice_status`,
                                                                    `invoice`.`id` AS `invoice_id`,
                                                                    `user`.`email` AS `userMail` 
                                                                    FROM `invoice` 
                                                                    INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` 
                                                                    INNER JOIN `order_status` ON `order_status`.`id`=`invoice`.`order_status_id` 
                                                                    INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` 
                                                                    WHERE (invoice.status<>2 OR invoice.order_status_id<>5) AND seller_nic='" . $_SESSION["seller"]["nic"] . "'
                                                                    ORDER BY `invoice`.`date_time` 
                                                                    LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                        $invoice_num = $invoice_rs->num_rows;

                                        if ($invoice_num > 0) {
                                            for ($x = 0; $x < $invoice_num; $x++) {
                                                $invoice_data = $invoice_rs->fetch_assoc();
                                        ?>
                                                <tr>
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer"><?php echo ($invoice_data["order_id"]); ?></td>
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer">ATP_<?php echo ($invoice_data["product_id"]); ?></td>
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer" style="min-width: 180px;"><?php echo ($invoice_data["title"]); ?></td>
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer" style="min-width: 180px;"><?php echo ($invoice_data["fname"] . " " . $invoice_data["lname"]); ?></td>
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer" style="min-width: 180px;"><?php
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
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer">Rs. <?php echo ($invoice_data["total"]); ?>.00</td>
                                                    <td onclick="viewCustomerAddress(true,'<?php echo ($invoice_data['userMail']) ?>');" class="c-pointer <?php
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
                <!-- Orders -->


            </div>
        </div>

        <?php include "footer.php"; ?>

        <script src="script.js"></script>
    </body>

    </html>


<?php
} else {
    header("Location:home.php");
}


?>