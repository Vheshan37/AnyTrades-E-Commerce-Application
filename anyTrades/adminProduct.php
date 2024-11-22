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
        <title>Manage Product || AnyTrades</title>
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
                                        <a href="adminProduct.php" class="d-flex gap-2 align-items-center text-decoration-none p-2 active">
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
                                    <span class="fs-3 fw-bold" style="font-family: arial;">Product</span>
                                </div>

                                <div class="d-flex justify-content-between w-100">
                                    <div class="border border-1 p-2 d-flex align-items-center gap-2 bg-secondary bg-opacity-25 w-50" style="border-radius: 100vh;">
                                        <i class="icon-search_black_24dp1 c-pointer fs-5 fw-bold text-primary" onclick="searchProduct();"></i>
                                        <input type="text" placeholder="Search here..." class="border-0 bg-transparent" style="outline: none; width: 100%;" onkeyup="searchProductKey(event);" id="product_name">
                                    </div>

                                    <div class="d-flex gap-1">
                                        <!-- <img src="resources/profile_images/Vihanga_profile_img_636b2c60b5189.jpeg" alt="" style="width: 50px; height: 50px; clip-path: circle();"> -->
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold"><?php echo ($_SESSION["at_admin"]["name"]) ?></span>
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

                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div class="d-flex gap-2 align-items-center">
                                    <i class="icon-tune_black_24dp fs-4 fw-bold"></i>
                                    <?php
                                    $cat_rs = Database::search("SELECT * FROM `category`");
                                    $cat_num = $cat_rs->num_rows;
                                    ?>

                                    <select class="form-select border-0 border-bottom rounded" style="min-width: 150px;" onchange="filterCategory();" id="CategoryFilterOption">
                                        <option value="0">Category</option>
                                        <?php
                                        for ($cat = 0; $cat < $cat_num; $cat++) {
                                            $cat_data = $cat_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($cat_data["id"]); ?>" <?php
                                                                                                if (isset($_GET["category"])) {
                                                                                                    if ($_GET["category"] == $cat_data["id"]) {
                                                                                                ?> selected <?php
                                                                                                        }
                                                                                                    }
                                                                                                            ?>><?php echo ($cat_data["name"]); ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="d-flex align-items-center position-relative">
                                    <i class="icon-more_vert_black_24dp fs-4 fw-bold c-pointer" onclick="viewProductMenu();"></i>
                                    <div class="position-absolute end-100 top-100 product-menu" style="z-index: 1;" id="productMenu">
                                        <div class="bg-dark text-white rounded px-4 py-2">
                                            <ul class="list-unstyled mb-0" style="width: max-content; height: fit-content;">
                                                <li class="my-1 c-pointer" onclick="newCategoryModal();">Add New Category</li>
                                                <li class="my-1 c-pointer" onclick="newBrandModal();">Add New Brand</li>
                                                <li class="my-1 c-pointer" onclick="newModelModal();">Add New Model</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="row" id="searchProductContent">

                                <div class="col-12 mt-2">
                                    <div class="row">

                                        <div class="">
                                            <?php

                                            if (isset($_GET["category"]) && $_GET["category"] != 0) {
                                                // View by single category

                                                if (isset($_GET["page_no"])) {
                                                    $page_no = $_GET["page_no"];
                                                } else {
                                                    $page_no = 1;
                                                }

                                                $category_rs = Database::search("SELECT * FROM `category` WHERE `id`='" . $_GET["category"] . "'");
                                                $category_data = $category_rs->fetch_assoc();

                                                $pagination_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $category_data["id"] . "'");
                                                $pagination_num = $pagination_rs->num_rows;

                                                $result_per_page = 20;
                                                $number_of_pages = ceil($pagination_num / $result_per_page);
                                                $offset = ($page_no - 1) * $result_per_page;


                                                $product_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $category_data["id"] . "' LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                                $product_num = $product_rs->num_rows;
                                            ?>
                                                <div class="border-bottom pb-1 mt-3">
                                                    <span class="fs-4 fw-bold me-1"><?php echo ($category_data["name"]); ?></span>
                                                </div>
                                                <?php
                                                if ($product_num > 0) {

                                                ?>
                                                    <div class="admin-product-grid mt-2 p-2">
                                                        <?php
                                                        for ($p = 0; $p < $product_num; $p++) {
                                                            $product_data = $product_rs->fetch_assoc();
                                                            $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "'");
                                                            $img_data = $img_rs->fetch_assoc();
                                                        ?>
                                                            <div class="rounded overflow-hidden border border-success">
                                                                <img src="<?php echo ($img_data["path"]); ?>" />
                                                                <div class="d-flex flex-column p-2">
                                                                    <span class="fw-bold fs-5"><?php echo ($product_data["title"]); ?></span>
                                                                    <span class="">Rs. <?php echo ($product_data["price"]); ?>.00</span>
                                                                    <span class="text-black-50 fw-bold" style="font-size: 12px;">Date : <?php echo ((explode(" ", $product_data["date_time"]))[0]) ?></span>
                                                                    <span class="text-black-50 fw-bold" style="font-size: 12px;">Views : 75</span>
                                                                    <span class="text-black-50 fw-bold" style="font-size: 12px;">Sellings : 820</span>
                                                                </div>
                                                                <div class="manege-btn bg-success text-white text-center text-decoration-underline c-pointer mt-auto">Manage</div>
                                                            </div>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>

                                                <?php

                                                } else {
                                                ?>
                                                    <div class="alert alert-danger fw-bold">No items added yet</div>
                                                <?php
                                                }

                                                ?>

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
                                                        <a class="text-decoration-none p_nation_prev" href="?category=<?php echo ($_GET["category"]) ?>&page_no=<?php
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
                                                        <a href="?category=<?php echo ($_GET["category"]) ?>&page_no=1" <?php
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
                                                            <a href="?category=<?php echo ($_GET["category"]) ?>&page_no=<?php echo ($middle_left); ?>" <?php
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
                                                            <a href="?category=<?php echo ($_GET["category"]) ?>&page_no=<?php echo ($middle_page); ?>" <?php
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
                                                            <a href="?category=<?php echo ($_GET["category"]) ?>&page_no=<?php echo ($middle_right); ?>" <?php
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
                                                            <a href="?category=<?php echo ($_GET["category"]) ?>&page_no=<?php echo ($number_of_pages); ?>" <?php
                                                                                                                                                            if ($page_no == $number_of_pages) {
                                                                                                                                                            ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                                                                                            }
                                                                                                                                                                                                                ?>><?php echo ($number_of_pages); ?></a>
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- Last page of the pagination -->


                                                        <!-- Next Button of the pagination -->
                                                        <a class="text-decoration-none p_nation_next" href="?category=<?php echo ($_GET["category"]) ?>&page_no=<?php
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

                                                <?php

                                            } else {
                                                // View all products by all category

                                                $category_rs = Database::search("SELECT * FROM `category`");
                                                $category_num = $category_rs->num_rows;
                                                for ($c = 0; $c < $category_num; $c++) {
                                                    $category_data = $category_rs->fetch_assoc();

                                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $category_data["id"] . "'");
                                                    $product_num = $product_rs->num_rows;
                                                ?>
                                                    <div class="border-bottom pb-1 mt-3">
                                                        <span class="fs-4 fw-bold me-1"><?php echo ($category_data["name"]); ?></span>
                                                    </div>
                                                    <?php
                                                    if ($product_num > 0) {
                                                    ?>
                                                        <div class="admin-product-grid mt-2 p-2 border rounded" style="max-height: 500px; overflow-y: auto;">
                                                            <?php
                                                            for ($p = 0; $p < $product_num; $p++) {
                                                                $product_data = $product_rs->fetch_assoc();
                                                                $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "' ORDER BY RAND ()");
                                                                $img_data = $img_rs->fetch_assoc();
                                                            ?>
                                                                <div class="rounded overflow-hidden border border-success">
                                                                    <img src="<?php echo ($img_data["path"]); ?>" />
                                                                    <div class="d-flex flex-column p-2">
                                                                        <span class="fw-bold fs-5"><?php echo ($product_data["title"]); ?></span>
                                                                        <span class="">Rs. <?php echo ($product_data["price"]); ?>.00</span>
                                                                    </div>
                                                                    <!-- <div class="manege-btn bg-success text-white text-center text-decoration-underline c-pointer mt-auto">Manage</div> -->
                                                                </div>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <div class="alert alert-danger fw-bold">No items added yet</div>
                                                    <?php
                                                    }
                                                    ?>
                                            <?php
                                                }
                                            }

                                            ?>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>


                        <!-- Category Modal -->
                        <div class="position-fixed top-0 start-0 vw-100 vh-100 bg-black bg-opacity-25 d-flex justify-content-center align-items-center d-none" id="categoryModal">
                            <div class="bg-white rounded-2 overflow-hidden col-10 col-lg-8 col-xl-6 col-xxl-4">
                                <div class="bg-success">
                                    <div class="text-white text-center p-2 fs-4 fw-bold" style="font-family: arial;">Add New Category</div>
                                </div>
                                <div class="p-3 d-flex flex-column gap-2">
                                    <div class="d-flex justify-content-center">
                                        <div class="rounded p-1 d-flex justify-content-center align-items-center" id="cat_img_viewer" style="border: 1px dashed green; width: 300px; height: 250px; max-width: 80%;">
                                            <label class="icon-plus text-success fs-1 c-pointer" for="cat_img"></label>
                                            <input type="file" class="d-none" id="cat_img" onchange="catImage();" />
                                        </div>
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Category</label>
                                        <input type="text" class="form-control" style="box-shadow: none;" id="category_name" />
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control" style="box-shadow: none;" id="admin_email" />
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-success px-5" id="categoryRegBtn" style="border-radius: 100vh;" onclick="registerCategory();">Register</button>
                                    </div>
                                </div>
                                <div class="bg-success">
                                    <div class="text-white text-center text-decoration-underline c-pointer" style="font-family: arial;" onclick="newCategoryModal();">Close</div>
                                </div>
                            </div>
                        </div>
                        <!-- Category Modal -->

                        <!-- Brand Modal -->
                        <div class="position-fixed top-0 start-0 vw-100 vh-100 bg-black bg-opacity-25 d-flex justify-content-center align-items-center d-none" id="brandModal">
                            <div class="bg-white rounded-2 overflow-hidden col-10 col-lg-8 col-xl-6 col-xxl-4">
                                <div class="bg-success">
                                    <div class="text-white text-center p-2 fs-4 fw-bold" style="font-family: arial;">Add New Brand</div>
                                </div>
                                <div class="p-3 d-flex flex-column gap-2">

                                    <?php
                                    $category_table = Database::search("SELECT * FROM `category`");
                                    $category_table_num = $category_table->num_rows;
                                    ?>

                                    <div class="">
                                        <label for="" class="form-label fw-bold">Category</label>
                                        <select class="form-select" style="box-shadow: none;" id="categorySelector">
                                            <option value="">Select Category</option>
                                            <?php
                                            for ($category = 0; $category < $category_table_num; $category++) {
                                                $category_table_data = $category_table->fetch_assoc();
                                            ?>
                                                <option value="<?php echo ($category_table_data["id"]); ?>"><?php echo ($category_table_data["name"]); ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Brand</label>
                                        <input type="text" class="form-control" id="brand" style="box-shadow: none;" />
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control" id="brandEmail" style="box-shadow: none;" />
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-success px-5" id="brandRegBtn" style="border-radius: 100vh;">Register</button>
                                    </div>
                                </div>
                                <div class="bg-success">
                                    <div class="text-white text-center text-decoration-underline c-pointer" style="font-family: arial;" onclick="newBrandModal();">Close</div>
                                </div>
                            </div>
                        </div>
                        <!-- Brand Modal -->

                        <!-- Model Modal -->
                        <div class="position-fixed top-0 start-0 vw-100 vh-100 bg-black bg-opacity-25 d-flex justify-content-center align-items-center d-none overflow-auto" id="modelModal">
                            <div class="bg-white rounded-2 overflow-hidden col-10 col-lg-8 col-xl-6 col-xxl-4">
                                <div class="bg-success">
                                    <div class="text-white text-center p-2 fs-4 fw-bold" style="font-family: arial;">Add New Modal</div>
                                </div>
                                <div class="p-3 d-flex flex-column gap-2">
                                    <div class="">
                                        <?php
                                        $category_table = Database::search("SELECT * FROM `category`");
                                        $category_table_num = $category_table->num_rows;
                                        ?>

                                        <div class="">
                                            <label for="" class="form-label fw-bold">Category</label>
                                            <select class="form-select" style="box-shadow: none;" id="modalCategory" onchange="loadBrand();">
                                                <option value="0">Select Category</option>
                                                <?php
                                                for ($category = 0; $category < $category_table_num; $category++) {
                                                    $category_table_data = $category_table->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo ($category_table_data["id"]); ?>"><?php echo ($category_table_data["name"]); ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Brand</label>
                                        <select class="form-select" style="box-shadow: none;" id="modalBrands">
                                            <option value="">Select Brand</option>
                                        </select>
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Modal</label>
                                        <input type="text" class="form-control" style="box-shadow: none;" id="modal" />
                                    </div>
                                    <div class="">
                                        <label for="" class="form-label fw-bold">Email</label>
                                        <input type="text" class="form-control" style="box-shadow: none;" id="modalEmail" />
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button class="btn btn-success px-5" id="modelRegBtn" style="border-radius: 100vh;">Register</button>
                                    </div>
                                </div>
                                <div class="bg-success">
                                    <div class="text-white text-center text-decoration-underline c-pointer" style="font-family: arial;" onclick="newModelModal();">Close</div>
                                </div>
                            </div>
                        </div>
                        <!-- Model Modal -->


                    </div>
                </div>
                <!-- Content -->

            </div>
        </div>

        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location:adminSignin.php");
}

?>