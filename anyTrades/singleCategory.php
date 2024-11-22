<?php

session_start();
require "connection.php";
$cat_id = $_GET["cat_id"];

$category_rs = Database::search("SELECT * FROM `category` WHERE `id`='" . $cat_id . "'");
$category_num  = $category_rs->num_rows;
if ($category_num == 1) {

    $category_data = $category_rs->fetch_assoc();

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo ($category_data["name"]); ?> || AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="min-vh-100">

    <?php require "alert.php"; ?>
    
        <div class="container-fluid">
            <div class="row">

                <?php include "header.php"; ?>


                <div class="col-12">
                    <div class="row mb-3">


                        <div class="col-12 p-0">
                            <div class="">
                                <img src="<?php echo ($category_data["img"]); ?>" style="width: 100%; height: 100%; max-height: 500px; object-fit: cover;" class="border-bottom border-1 border-dark">
                            </div>
                        </div>


                        <!-- Bread Crumb -->
                        <div class="col-12 mt-3">
                            <div class="row text-black c-default">

                                <div class="d-flex gap-1">
                                    <a href="home.php">Home</a>
                                    /
                                    <a href="product.php">Product</a>
                                    /
                                    <a class="text-black-50">Single Category</a>
                                </div>

                            </div>
                        </div>
                        <!-- Bread Crumb -->


                        <div class="col-12 mt-3 p-0">
                            <div class="d-flex bg-dark py-3 px-2 justify-content-lg-center justify-content-end position-relative align-items-center">
                                <span class="text-white fw-bold l-space-1 fs-4 c-default"><?php echo ($category_data["name"]); ?></span>

                                <div class="position-absolute d-flex align-items-center start-0 text-white gap-1 ms-1 fs-4 c-pointer" onclick="moveCategoryFilter();">
                                    <i class="icon-tune_black_24dp"></i>
                                    <span class="">Filter</span>
                                </div>

                                <div class="position-absolute top-100 bg-dark text-white rounded-bottom ms-1 start-0" style="min-width: 150px; box-shadow: 3px 3px 5px 0px black;">
                                    <ul class="list-unstyled m-0 category-filter" id="category_filter">
                                        <li class="my-1">Name</li>
                                        <li class="my-1">Date</li>
                                        <li class="my-1">Solled</li>
                                        <li class="my-1">Views</li>
                                        <li class="my-1">Rating</li>
                                    </ul>
                                </div>

                            </div>
                        </div>





                        <?php

                        if (isset($_GET["page_no"])) {
                            $page_no = $_GET["page_no"];
                        } else {
                            $page_no = 1;
                        }

                        $pagination_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $cat_id . "'");
                        $pagination_num = $pagination_rs->num_rows;

                        if ($pagination_num > 0) {

                        ?>
                            <!-- Category Grid -->
                            <div class="single-c-grid mt-3">
                                <?php

                                $result_per_page = 10   ;
                                $number_of_pages = ceil($pagination_num / $result_per_page);
                                $offset = ($page_no - 1) * $result_per_page;

                                $product_rs = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $cat_id . "' LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                $product_num = $product_rs->num_rows;

                                for ($x = 0; $x < $product_num; $x++) {
                                    $product_data = $product_rs->fetch_assoc();
                                    $img_rs =  Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "'");
                                    $img_num = $img_rs->num_rows;
                                    $img_data = $img_rs->fetch_assoc();

                                ?>
                                    <div class="border rounded border-1 overflow-hidden border-secondary pb-1">
                                        <div class="d-flex justify-content-center">
                                            <img src="<?php echo ($img_data["path"]); ?>" class="img-fluid" style="max-height: 200px; height: 200px; object-fit: contain;" />
                                        </div>
                                        <div class="d-flex flex-column align-items-center">
                                            <span class="fs-4 fw-bold _nowrap"><?php echo ($product_data["title"]) ?></span>
                                            <span class="fw-bold">Rs. <?php echo ($product_data["price"]); ?> .00</span>
                                            <div class="d-flex align-items-center gap-1 fw-bold">
                                                <i class="icon-star-full text-warning"></i>
                                                <span class="">4.7 / 5</span>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2">
                                                <button class="btn btn-success px-5" onclick="buyNowModal('<?php echo ($product_data['id']); ?>','<?php echo ($img_num); ?>');">Buy Now</button>
                                            </div>
                                            <div class="d-flex flex-column align-self-start mt-1 p-1 pb-0 text-black-50 fw-bold">
                                                <span class="">Views : 237</span>
                                                <span class="">Date : <?php echo ((explode(" ", $product_data["date_time"]))[0]); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </div>
                            <!-- Category Grid -->



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
                                    <a class="text-decoration-none p_nation_prev" href="?cat_id=<?php echo ($cat_id); ?>&page_no=<?php
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
                                    <a href="?cat_id=<?php echo ($cat_id); ?>&page_no=1" <?php
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
                                        <a href="?cat_id=<?php echo ($cat_id); ?>&page_no=<?php echo ($middle_left); ?>" <?php
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
                                        <a href="?cat_id=<?php echo ($cat_id); ?>&page_no=<?php echo ($middle_page); ?>" <?php
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
                                        <a href="?cat_id=<?php echo ($cat_id); ?>&page_no=<?php echo ($number_of_pages); ?>" <?php
                                                                                                                                if ($page_no == $number_of_pages) {
                                                                                                                                ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                                                                }
                                                                                                                                                                                    ?>><?php echo ($number_of_pages); ?></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Last page of the pagination -->


                                    <!-- Next Button of the pagination -->
                                    <a class="text-decoration-none p_nation_next" href="?cat_id=<?php echo ($cat_id); ?>&page_no=<?php
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
                        ?>
                            <div class="d-flex justify-content-center mt-4" style="min-height: 30vh;">
                                <span class="fw-bold l-space-1"><?php echo ($category_data["name"]); ?> products have not yet been added.</span>
                            </div>
                        <?php
                        }
                        ?>





                    </div>
                </div>







                <!-- Buy Now Modal -->
                <div class="position-fixed vw-100 vh-100 d-flex justify-content-center align-items-center at-modal d-none" id="buyNowModal" style="background-color: rgba(0, 0, 0, 0.5);">

                </div>
                <!-- Buy Now Modal -->

            </div>
        </div>

        <?php include "footer.php"; ?>

        <script src="buyNowModal.js"></script>
        <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
        <script src="script.js"></script>

    </body>

    </html>
<?php

} else {
?>
    <link rel="stylesheet" href="bootstrap.css" />
    <div class="d-flex flex-column align-items-center bg-dark text-white pt-4 pb-2 gap-1">
        <span class="fs-5">There is nothing to view</span>
        <a href="home.php" class="btn btn-outline-light px-4">Home</a>
    </div>

<?php
}
