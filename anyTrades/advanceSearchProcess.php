<?php

require "connection.php";
session_start();
$txt = $_GET["txt"];
if (isset($_SESSION["at_u"])) {
    $email = $_SESSION["at_u"]["email"];
}

if (isset($_GET["page_no"])) {
    $page_no = $_GET["page_no"];
} else {
    $page_no = 1;
}

$pagination_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE'%" . $txt . "%' OR `desc` LIKE'%" . $txt . "%' OR `price` LIKE'%" . $txt . "%'");
$pagination_num = $pagination_rs->num_rows;

$result_per_page = 4;
$number_of_pages = ceil($pagination_num / $result_per_page);

$offset = ($page_no - 1) * $result_per_page;

$product_rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE'%" . $txt . "%' OR `desc` LIKE'%" . $txt . "%' OR `price` LIKE'%" . $txt . "%' LIMIT " . $result_per_page . " OFFSET " . $offset . "");
$product_num = $product_rs->num_rows;

if ($product_num > 0) {

?>
    <div class="home-product-area mt-3">
        <?php
        for ($x = 0; $x < $product_num; $x++) {
            $product_data = $product_rs->fetch_assoc();

            $image_rs = Database::search("SELECT * FROM `image` WHERE product_id='" . $product_data["id"] . "'");
            $image_data = $image_rs->fetch_assoc();

            if (isset($_SESSION["at_u"])) {
                $cart_rs = Database::search("SELECT * FROM `cart` WHERE `product_id`='" . $product_data["id"] . "' AND `user_email`='" . $_SESSION["at_u"]["email"] . "'");
                $cart_num = $cart_rs->num_rows;

                $watchlist_rs = Database::search("SELECT * FROM `watchlist` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "' AND product_id='" . $product_data["id"] . "'");
                $watchlist_num = $watchlist_rs->num_rows;
            }

        ?>

            <!-- Single Product -->
            <div class="border rounded border-1 border-secondary position-relative shadow pb-2 w-100 home-item">

                <div class="cart-tag d-flex justify-content-center align-items-center fs-4 m-1" onclick="addToCart('<?php echo ($product_data['id']); ?>');">
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
            <!-- Single Product -->

        <?php

        }
        ?>
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

            if ($page_no > 1) {
                $prev = $page_no - 1;
            }
            if ($page_no < $number_of_pages) {
                $next = $page_no + 1;
            }

            ?>

            <!--  -->
            <a href="#" onclick="advanceSearch('<?php echo ($prev); ?>');" class="text-decoration-none p_nation_prev" <?php
                                                                                                                        if ($page_no == 1) {
                                                                                                                        ?> style="opacity: 0.5;" <?php
                                                                                                                                                }
                                                                                                                                                    ?>>
                <span class="d-none d-lg-block">Prev</span>
                <i class="icon-arrow_circle_left_black_24dp d-block d-lg-none"></i>
            </a>


            <!-- First Page of the Pagination -->
            <a href="#" onclick="advanceSearch('1');" <?php
                                                        if ($page_no == "1") {
                                                        ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                        }
                                                                                                            ?>>1</a>
            <!-- First Page of the Pagination -->


            <!-- Inter ... of the Pagination -->
            <?php
            if (($middle_left != 2) && ($middle_left > 1)) {
            ?>
                <a href="#">...</a>
            <?php
            }
            ?>
            <!-- Inter ... of the Pagination -->


            <!-- Middle Left Button of the Pagination -->
            <?php
            if ($middle_left > 1) {
            ?>
                <a href="#" onclick="advanceSearch('<?php echo ($middle_left); ?>');" <?php
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
                <a onclick="advanceSearch('<?php echo ($middle_page); ?>');" href="#" <?php
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
                <a onclick="advanceSearch('<?php echo ($middle_right); ?>');" href="#" <?php
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
                <a href="#">...</a>
            <?php
            }
            ?>
            <!-- Inter ... of the pagination -->


            <!-- Last page of the pagination -->
            <?php
            if ($number_of_pages > 1) {
            ?>
                <a href="#" onclick="advanceSearch('<?php echo ($number_of_pages); ?>');" <?php
                                                                                            if ($page_no == $number_of_pages) {
                                                                                            ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                            }
                                                                                                                                                ?>><?php echo ($number_of_pages); ?></a>
            <?php
            }
            ?>
            <!-- Last page of the pagination -->


            <!-- Next Button of the pagination -->
            <a onclick="advanceSearch('<?php echo ($next); ?>');" class="text-decoration-none p_nation_next" <?php
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
    <div class="col-12 mt-3">
        <div class="d-flex justify-content-center fs-4">
            <span class="">There is no items to view.</span>
        </div>
    </div>
<?php

}
?>