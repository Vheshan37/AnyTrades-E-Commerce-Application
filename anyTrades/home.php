<?php
session_start();
require "connection.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | AnyTrades</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="icomoon.css" />
    <link rel="icon" href="resources/AnyTrades logo.png" type="image">
</head>

<body class="home-body min-vh-100 c-default" id="home">

    <?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php" ?>

            <!-- Head -->
            <div class="col-12">
                <div class="row home-head">

                    <!-- Home Header -->
                    <div class="col-12 p-0">
                        <div class="d-flex align-items-center home-header py-2">

                            <div class="site-name">
                                <span class="f-Debugged">AnyTrades</span>
                            </div>

                            <!-- Nav Bar -->
                            <div class="home-nav">

                                <div class="fs-3 d-block d-lg-none">
                                    <a href="#" onclick="mobileNavBar();">&#9776;</a>
                                </div>

                                <div class="">
                                    <a href="home.php">Home</a>
                                </div>
                                <div class="">
                                    <a href="product.php">Products</a>
                                </div>
                                <div class="">
                                    <?php

                                    if (isset($_SESSION["seller"])) {
                                        if ($_SESSION["u_type"] == "seller") {
                                    ?>
                                            <a href="sellerPanel.php">Seller Panel</a>
                                        <?php
                                        } else if ($_SESSION["u_type"] == "buyer") {
                                        ?>
                                            <a href="sellerRegistration.php">Become a Seller</a>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <a href="sellerRegistration.php">Become a Seller</a>
                                    <?php
                                    }

                                    ?>
                                </div>
                                <div class="">
                                    <?php
                                    if (isset($_SESSION["at_u"])) {
                                    ?>
                                        <a href="userPanel.php">User Panel</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="index.php">Become a Buyer</a>
                                    <?php
                                    }
                                    ?>

                                </div>

                                <div class="position-relative">


                                    <!-- Search Suggestion -->
                                    <div class="position-absolute bg-white py-2 w-100 rounded" style="z-index: 3; top: 110%; left: 0;" id="search_suggestion">

                                    </div>
                                    <!-- Search Suggestion -->
                                    <div class="d-flex justify-content-end">
                                        <div class="home-search-bar">
                                            <input type="text" placeholder="Search Products..." id="basicSearchInput" onkeypress="basicSearchResultFinder();" onkeydown="basicSearchResultFinder();" onkeyup="basicSearchResultFinder();" autocomplete="OFF" />
                                            <span class="fw-bold" onclick="basicSearch('1');">Search</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- Nav Bar -->

                            <!-- Mobile-nav-bar -->
                            <div class="mobile-nav-bar d-lg-none bg-dark" id="mobile-nav-bar" style="min-height: 100vh; height: 100vh; overflow-y: auto;">

                                <div class="position-absolute start-0 top-0 mt-2 ms-2">
                                    <i class="icon-close_black_24dp text-white c-pointer fs-3 fw-bold" onclick="mobileNavBar();"></i>
                                </div>

                                <div class="col-12 mb-3 mt-3">
                                    <img src="resources/profile_images/new_user.svg" class="mid-content">
                                    <?php

                                    if (isset($_SESSION["at_u"])) {
                                    ?>
                                        <span class="text-center d-block fw-bold text-white"><?php echo ($_SESSION["at_u"]["fname"] . " " . $_SESSION["at_u"]["lname"]); ?></span>
                                        <span class="text-center d-block text-white-50 fw-bold"><?php echo ($_SESSION["at_u"]["email"]); ?></span>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="#" class="text-center d-block">Sign in or Register</a>
                                    <?php
                                    }

                                    ?>
                                </div>


                                <div class="col-12 px-1">
                                    <hr>
                                </div>


                                <ul class="fs-5">
                                    <li><a href="home.php" class="fw-bold gap-2">
                                            <i class="icon-home"></i>
                                            Home
                                        </a></li>
                                    <li><a href="product.php" class="fw-bold gap-2">
                                            <i class="icon-move_to_inbox_black_24dp"></i>
                                            products
                                        </a></li>
                                    <li>
                                        <?php

                                        if (isset($_SESSION["seller"])) {
                                            if ($_SESSION["u_type"] == "seller") {
                                        ?>
                                                <a class="fw-bold gap-2" href="sellerPanel.php">
                                                    <i class="icon-account_circle_black_24dp"></i>
                                                    Seller Panel
                                                </a>
                                            <?php
                                            } else if ($_SESSION["u_type"] == "buyer") {
                                            ?>
                                                <a class="fw-bold gap-2" href="sellerRegistration.php">
                                                    <i class="icon-account_circle_black_24dp"></i>
                                                    Become a Seller
                                                </a>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <a class="fw-bold gap-2" href="sellerRegistration.php">
                                                <i class="icon-account_circle_black_24dp"></i>
                                                Become a Seller
                                            </a>
                                        <?php
                                        }

                                        ?>
                                    </li>
                                    <li>
                                        <?php
                                        if (isset($_SESSION["at_u"])) {
                                        ?>
                                            <a href="userPanel.php" class="fw-bold gap-2">
                                                <i class="icon-account_circle_black_24dp"></i>
                                                User Panel
                                            </a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="index.php" class="fw-bold gap-2">
                                                <i class="icon-login-svgrepo-com"></i>
                                                Sign In
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </li>
                                </ul>

                            </div>
                            <!-- Mobile-nav-bar -->

                        </div>
                    </div>
                    <!-- Home Header -->


                </div>
            </div>
            <!-- Head -->

            <div class="col-12">
                <div class="row" id="BasicSearchResult">

                    <!-- Carousal -->
                    <div class="home_slider p-0">

                        <div class="slides" id="slides">

                            <div class="slide">
                                <img src="resources/homeSlide3.jpg" />
                                <div class="slide-details left-p-10">
                                    <p class="m-0">Welcome To AnyTrades</p>

                                    <?php
                                    if (isset($_SESSION["at_u"])) {
                                    ?>
                                        <a href="userPanel.php" class="btn-warning border-0 py-2 px-5 ms-2 text-white l-space-1 fs-5 btn">User Panel</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="index.php" class="btn-warning border-0 py-2 px-5 ms-2 text-white l-space-1 fs-5 btn">User Register</a>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                            <div class="slide">
                                <img src="resources/homeSlide2.jpg" />
                                <div class="slide-details text-end right-p-10">
                                    <p class="m-0">Start Your First Business With Us</p>

                                    <?php

                                    if (isset($_SESSION["seller"])) {
                                    ?>
                                        <a href="sellerPanel.php" class="btn-warning border-0 py-2 px-5 ms-2 text-white l-space-1 fs-5 btn">Seller Panel</a>
                                    <?php
                                    } else {
                                    ?>
                                        <a href="sellerRegistration.php" class="btn-warning border-0 py-2 px-5 ms-2 text-white l-space-1 fs-5 btn">Become a Seller</a>
                                    <?php
                                    }

                                    ?>

                                </div>
                            </div>
                            <div class="slide">
                                <img src="resources/homeSlide1.jpg" />
                                <div class="slide-details text-center w-100" style="top: 10%;">
                                    <p class="m-0">20% Discount On Any Product Above Rs.10'000.</p>
                                </div>
                            </div>
                            <div class="slide">
                                <img src="resources/homeSlide4.jpg" />
                            </div>
                            <div class="slide">
                                <img src="resources/homeSlide5.jpg" />
                            </div>

                        </div>

                        <div class="arrow-navigation fs-3 text-white" style="z-index: 2;">
                            <span class="icon-arrow_circle_left_black_24dp" onclick="arrowNavigation(-1);"></span>
                            <span class="icon-arrow_circle_right_black_24dp" onclick="arrowNavigation(1);"></span>
                        </div>

                        <div class="btn-navigation">
                            <label id="slide_line0" onclick="slideLineAnimation(0);"></label>
                            <label id="slide_line1" onclick="slideLineAnimation(1);"></label>
                            <label id="slide_line2" onclick="slideLineAnimation(2);"></label>
                            <label id="slide_line3" onclick="slideLineAnimation(3);"></label>
                            <label id="slide_line4" onclick="slideLineAnimation(4);"></label>
                        </div>

                    </div>
                    <!-- Carousal -->




                    <!-- Product View Area -->

                    <div class="col-12 my-3">
                        <div class="row">

                            <div class="col-12 my-1">
                                <p class="m-0 p-0 fs-3 fw-bold">All products</p>
                            </div>

                            <div class="col-12">
                                <hr class="m-0 p-0 mb-3">
                            </div>

                            <div class="home-product-area">

                                <?php

                                if (isset($_GET["page_no"])) {
                                    $page_no = $_GET["page_no"];
                                } else {
                                    $page_no = 1;
                                }

                                $pagination_rs = Database::search("SELECT * FROM `product`");
                                $pagination_num = $pagination_rs->num_rows;

                                $result_per_page = 6;
                                $number_of_pages = ceil($pagination_num / $result_per_page);

                                if ($number_of_pages < $page_no) {
                                ?>
                                    <script>
                                        window.location = "home.php?page_no=<?php echo ($number_of_pages); ?>";
                                    </script>
                                <?php
                                }

                                $offset = ($page_no - 1) * $result_per_page;

                                

                                $product_rs  = Database::search("SELECT * FROM `product` ORDER BY `date_time` DESC LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                $product_num = $product_rs->num_rows;

                                for ($x = 0; $x < $product_num; $x++) {
                                    $product_data = $product_rs->fetch_assoc();

                                    if (isset($_SESSION["at_u"])) {
                                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                                        $cart_num = $cart_rs->num_rows;

                                        $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "' AND product_id='" . $product_data["id"] . "'");
                                        $watchlist_num = $watchlist_rs->num_rows;
                                    }

                                ?>

                                    <div class="border rounded border-1 border-secondary position-relative shadow pb-2 w-100 home-item">

                                        <div class="cart-tag d-flex justify-content-center align-items-center text-white fs-4 m-1" onclick="addToCart('<?php echo ($product_data['id']); ?>');">
                                            <i class="icon-shopping_cart_black_24dp <?php
                                                                                    if ($cart_num == 0) {
                                                                                        echo ("text-black");
                                                                                    } else {
                                                                                        echo ("text-white");
                                                                                    }
                                                                                    ?>" id="home-cart-icon"></i>
                                        </div>

                                        <div class="watchlist-tag d-flex justify-content-center align-items-center fs-4 m-1" onclick="addToWatchlist('<?php echo ($product_data['id']); ?>');">
                                            <i class="icon-heart <?php
                                                                    if ($watchlist_num == 0) {
                                                                        echo ("text-black");
                                                                    } else {
                                                                        echo ("text-white");
                                                                    }
                                                                    ?>"></i>
                                        </div>

                                        <?php

                                        $image_rs = Database::search("SELECT * FROM `image` WHERE product_id='" . $product_data["id"] . "' ORDER BY RAND()");
                                        $image_data = $image_rs->fetch_assoc();

                                        ?>

                                        <div class="col-12 d-flex justify-content-center" style="height: fit-content;" onclick="singleProductView('<?php echo ($product_data['id']); ?>');">
                                            <img src="<?php echo ($image_data["path"]); ?>" class="rounded mt-1" style="width: 80%; height: 200px; object-fit: contain;">
                                        </div>

                                        <div class="col-12 mt-2 px-1">
                                            <p title="<?php echo ($product_data["title"]); ?>" class="fs-5 nowrap fw-bold m-0 p-0"><?php echo ($product_data["title"]); ?></p>
                                            <span class="d-block">Rs. <?php echo ($product_data["price"]); ?> .00</span>
                                            <span class="d-block">
                                                <i class="icon-star-full text-warning"></i>
                                                <i class="icon-star-full text-warning"></i>
                                                <i class="icon-star-full text-warning"></i>
                                                <i class="icon-star-full text-warning"></i>
                                                <i class="icon-star-empty text-warning"></i>
                                                <a href="singleProductView.php?p=<?php echo ($product_data["id"]); ?>" class="ms-2 text-black-50 fw-bold">View More...</a>
                                            </span>
                                        </div>

                                    </div>

                                <?php
                                }

                                ?>


                            </div>


                        </div>
                    </div>

                    <!-- Product View Area -->



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
                                <a href="?cat_id=<?php echo ($cat_id); ?>&page_no=<?php echo ($middle_right); ?>" <?php
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
                                                                                            } else if ($number_of_pages == 0) {
                                                                                                echo ("1");
                                                                                            } else {
                                                                                                echo ($number_of_pages);
                                                                                            }
                                                                                            ?>" <?php
                                                                                                if (($page_no == $number_of_pages) || ($number_of_pages == 0)) {
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
    </div>

    <?php include "footer.php"; ?>
    <script src="script.js"></script>
    <script src="imgSlider.js"></script>
</body>

</html>