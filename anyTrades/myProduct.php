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
        <div class="box" id="removeItemModel">
            <div class="signoutBox rounded pb-1 bg-white">

                <div class="box-head bg-warning">
                    <label class="fw-bold p-1">Warning &#9888;</label>
                </div>

                <div class="box-body mt-5">
                    <label class="p-1">Are you sure want to remove this item?</label>
                </div>

                <div class="box-footer gap-2 p-1 px-2">
                    <button class="btn btn-primary" id="removeYes" onclick="removeMyProduct();">Yes</button>
                    <button class="btn btn-danger" id="removeNo" onclick="removeMyProductToggle(null,'close');">No</button>
                </div>

            </div>
        </div>
        <!-- Remove Product -->


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
                                            <input type="text" placeholder="Search Your Products..." />
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



                <!-- My Product View Area -->
                <div class="col-12">
                    <div class="row px-2 mt-3">

                        <div class="col-12 p-1">
                            <div class="gap-3 item-view-area">

                                <?php

                                if (isset($_GET["page_no"])) {
                                    $page_no = $_GET["page_no"];
                                } else {
                                    $page_no = 1;
                                }

                                $pagination_rs = Database::search("SELECT * FROM `product` WHERE `seller_nic`='" . $_SESSION["seller"]["nic"] . "'");
                                $pagination_num = $pagination_rs->num_rows;

                                $result_per_page = 10;
                                $number_of_pages = ceil($pagination_num / $result_per_page);
                                $offset = ($page_no - 1) * $result_per_page;

                                $product_rs = Database::search("SELECT * FROM `product` WHERE `seller_nic`='" . $_SESSION["seller"]["nic"] . "' LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                $product_num = $product_rs->num_rows;

                                for ($x = 0; $x < $product_num; $x++) {
                                    $product_data = $product_rs->fetch_assoc();
                                    $category_id = $product_data["category_id"];
                                    $category_rs = Database::search("SELECT * FROM `category` WHERE `id`='" . $category_id . "'");
                                    $category_data = $category_rs->fetch_assoc();
                                    $image_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "' ORDER BY RAND ()");
                                    $image_data = $image_rs->fetch_assoc();

                                    $qty_rs = Database::search("SELECT * FROM `quantity` WHERE `product_id`='" . $product_data["id"] . "'");
                                    $qty_data = $qty_rs->fetch_assoc();

                                ?>


                                    <div class="border rounded item-view p-1">
                                        <div class="d-flex flex-column justify-content-between h-100">
                                            <div class="">
                                                <div class="text-center fw-bold"><?php echo ($category_data["name"]); ?></div>
                                                <div class="d-flex justify-content-center">
                                                    <img src="<?php echo ($image_data["path"]); ?>" class="img-fluid" style="max-height: 200px;">
                                                </div>
                                            </div>
                                            <div class="">
                                                <div class="">
                                                    <span class="fs-5 fw-bold"><?php echo ($product_data["title"]); ?></span>
                                                </div>
                                                <div class="d-flex align-items-center gap-2">
                                                    <i class="icon-star-full text-warning"></i>
                                                    <span class="fw-bold">1.4/5</span>
                                                </div>
                                                <div class="">
                                                    <?php
                                                    if ($product_data["qty"] > 0) {
                                                    ?>
                                                        <span class="fw-bold text-primary"><?php echo ($qty_data["qty"] . " / " . $product_data["qty"]); ?> Stock</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="fw-bold text-danger">Out of Stock</span>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="">
                                                    <span class="fw-bold text-danger">Rs. <?php echo ($product_data["price"]); ?>.00</span>
                                                </div>
                                                <div class="d-flex flex-row flex-md-column flex-lg-row flex-xl-column flex-xxl-row mt-2 justify-content-center gap-2">
                                                    <a class="btn btn-primary px-4 w-100" href="updateProduct.php?id=<?php echo ($product_data["id"]); ?>">Update</a>
                                                    <button class="btn btn-dark px-4 w-100" onclick="removeMyProductToggle('<?php echo ($product_data['id']); ?>','open');">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php

                                }

                                ?>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- My Product View Area -->


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

        <?php include "footer.php"; ?>

        <script src="script.js"></script>
    </body>

    </html>


<?php
} else {
    header("Location:home.php");
}


?>