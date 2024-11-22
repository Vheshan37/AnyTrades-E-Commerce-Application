<?php

require "connection.php";
session_start();

if (isset($_SESSION["at_u"])) {

    $user = $_SESSION["at_u"];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Purchasing History</title>
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="bg-secondary bg-opacity-10 c-default">

    <?php require "alert.php"; ?>

        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <div class="d-flex p-2 gap-2 gap-lg-4 flex-column flex-lg-row">

                        <div class="d-flex">
                            <div class="fs-3 fw-bolder" style="color: purple;">Purchasing History</div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center flex-grow-1">
                            <div class="position-relative d-flex align-items-center">
                                <input type="text" class="bg-transparent" style="border: 1px solid purple; border-radius: 100vh; outline: none; min-width: 250px; padding: 7px; padding-right: 30px;" placeholder="Search here..." />
                                <i class="icon-search_black_24dp position-absolute end-0 me-2 fs-5 fw-bold c-pointer" style="color: purple;"></i>
                            </div>
                            <div class="p-2 rounded" style="background-color: purple;">
                                <a class="icon-home fs-5 text-white c-pointer" href="home.php"></a>
                            </div>
                        </div>

                    </div>
                </div>


                <hr>

                <?php


                if (isset($_GET["page_no"])) {
                    $page_no = $_GET["page_no"];
                } else {
                    $page_no = 1;
                }

                $pagination_rs = Database::search("SELECT * FROM `invoice` WHERE `user_email`='" . $user["email"] . "' AND `status`=2");
                $pagination_num = $pagination_rs->num_rows;

                $result_per_page = 10;
                $number_of_pages = ceil($pagination_num / $result_per_page);
                $offset = ($page_no - 1) * $result_per_page;

                if ($page_no == 0) {
                    header("Location:purchasingHistory.php?page_no=1");
                } else if ($page_no > $number_of_pages && $number_of_pages != 0) {
                    header("Location:purchasingHistory.php?page_no=" . $number_of_pages);
                }

                $rs  = Database::search("SELECT * FROM `invoice` WHERE `user_email`='" . $user["email"] . "' AND `status`=2 LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                $num = $rs->num_rows;

                if ($num > 0) {
                ?>
                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <button class="btn btn-danger" onclick="deleteAllOrders();">
                                <span class="">Clear All</span>
                                <i class="icon-delete_forever_black_24dp fs-5"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 mt-3 overflow-auto">
                        <table class="table table-bordered table-light border-purple table-hover">
                            <thead>
                                <tr>
                                    <th class="fs-5">Order ID</th>
                                    <th class="fs-5" style="min-width: 200px;">Product</th>
                                    <th class="fs-5 d-none d-lg-table-cell">Image</th>
                                    <th class="fs-5" style="min-width: 150px;">Price</th>
                                    <th class="fs-5" style="min-width: 200px;">Date & Time</th>
                                    <th class="fs-5">Status</th>
                                    <th class="fs-5">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                for ($x = 0; $x < $num; $x++) {
                                    $data = $rs->fetch_assoc();

                                    $product_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $data["product_id"] . "'");
                                    $product_data = $product_rs->fetch_assoc();

                                    $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $data["product_id"] . "'");
                                    $img_data = $img_rs->fetch_assoc();

                                ?>

                                    <tr>
                                        <td>OID_<?php echo ($data["id"]); ?></td>
                                        <td><?php echo ($product_data["title"]); ?></td>
                                        <td class="d-none d-lg-table-cell">
                                            <div class="d-flex justify-content-center">
                                                <img src="<?php echo ($img_data["path"]); ?>" style="object-fit: contain; max-height: 100px;">
                                            </div>
                                        </td>
                                        <td>Rs. <?php echo ($data["total"]); ?>.00</td>
                                        <td><?php
                                            echo ((explode(" ", $data["date_time"]))[0] . " ");
                                            echo ((explode(":", (explode(" ", $data["date_time"]))[1]))[0] . ":" . (explode(":", (explode(" ", $data["date_time"]))[1]))[1]);
                                            if ((explode(":", (explode(" ", $data["date_time"]))[1]))[0] > 11) {
                                                echo (" PM");
                                            } else {
                                                echo (" AM");
                                            }
                                            ?></td>
                                        <td><?php
                                            if ($data["order_status_id"] == 1) {
                                                echo ("Placed");
                                            } else if ($data["order_status_id"] == 2) {
                                                echo ("Confirm");
                                            } else if ($data["order_status_id"] == 3) {
                                                echo ("Packing");
                                            } else if ($data["order_status_id"] == 4) {
                                                echo ("Deliver");
                                            } else if ($data["order_status_id"] == 5) {
                                                echo ("Delivered");
                                            }
                                            ?></td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <i class="icon-delete-svgrepo-com text-danger c-pointer fs-4 fw-bold" onclick="deletepurchaseItem('<?php echo ($data['id']); ?>');"></i>
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


                <?php
                } else {
                ?>
                    <!-- Empty View -->
                    <div class="col-12">
                        <div class="d-flex flex-column align-items-center">

                            <i class="icon-shopping_bag_black_24dp p-h-icon"></i>
                            <div class="">
                                <a href="home.php" class="btn btn-outline-info">Continue Shoppping</a>
                            </div>

                        </div>
                    </div>
                    <!-- Empty View -->
                <?php
                }

                ?>










            </div>
        </div>

        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location:index.php");
}

?>