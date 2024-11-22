<?php

require "connection.php";
$pid = $_GET["pid"];
session_start();

$p_rs = Database::search("SELECT * FROM `product` WHERE `id`='" . $pid . "'");
$p_data = $p_rs->fetch_assoc();

$img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $pid . "'");
$img_num = $img_rs->num_rows;

if (isset($_SESSION["at_u"])) {
    $user_rs = Database::search("SELECT * FROM `user` INNER JOIN `user_has_address` ON `user_has_address`.`user_email`=`user`.`email` INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id` WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
    $user_num = $user_rs->num_rows;
}

?>

<div class="d-flex flex-column bg-white rounded overflow-hidden">
    <div class="d-flex justify-content-center bg-success">
        <span class=""><?php echo ($p_data["title"]); ?></span>
    </div>

    <div class="d-none" id="size_of_slider"><?php echo ($img_num); ?></div>

    <div class="">

        <div class="position-relative">

            <div class="d-flex" style="width: <?php echo ($img_num); ?>00%;" id="buyNowSliderImages">
                <?php
                for ($x = 0; $x < $img_num; $x++) {
                    $img_data = $img_rs->fetch_assoc();
                ?>
                    <img src="<?php echo ($img_data["path"]); ?>" alt="" style="width: <?php echo (100 / $img_num); ?>%; max-height: 250px; object-fit: contain;">
                <?php
                }
                ?>
            </div>

            <div class="position-absolute top-50 w-100 d-flex justify-content-between px-3 fs-4 fw-bold buy-now-arrow">
                <i class="icon-chevron_left_black_24dp c-pointer" onclick="buyNowSlider(0);"></i>
                <i class="icon-chevron_right_black_24dp c-pointer" onclick="buyNowSlider(1);"></i>
            </div>

            <div class="bn-img-number position-absolute top-0 end-0 me-2 mt-1">
                <div class="fw-bold">
                    <span class="" id="buyNowImageNumber">1</span>
                    /
                    <span class=""><?php echo ($img_num); ?></span>
                </div>
            </div>

        </div>


        <div class="col-12">
            <hr>
        </div>

        <div class="d-flex flex-column justify-content-start gap-1 px-2">
            <div class="fw-bold">
                <span class="">RS. <?php echo ($p_data["price"]); ?> .00</span>
                ||
                <span class="text-danger text-decoration-line-through"><?php echo ((($p_data["price"] / 100) * 5) + $p_data["price"] . ".00"); ?></span>
            </div>
            <div class="">
                <?php
                if (isset($_SESSION["at_u"])) {
                    if ($user_num > 0) {
                        $user_data = $user_rs->fetch_assoc();
                        if ($user_data["district_id"] == 2) {
                            $delivery = $p_data["delivery_in"];
                        } else {
                            $delivery = $p_data["delivery_out"];
                        }
                ?>
                        <span class="">Delivery : <?php echo ($delivery); ?>.00</span>
                    <?php
                    } else {
                    ?>
                        <span class="text-danger">Complete your profile.</span>
                    <?php
                    }
                } else {
                    ?>
                    <span class="text-danger text-decoration-underline">Sign in first.</span>
                <?php
                }
                ?>
            </div>
            <div class="">
                <span class="text-primary fw-bold">Total Amount : <?php
                                                                    if (isset($_SESSION["at_u"])) {
                                                                        echo ($p_data["price"] + $delivery . " .00");
                                                                    } else {
                                                                        echo ($p_data["price"] . " .00" . " || Without Delivery Price");
                                                                    } ?></span>
            </div>

        </div>

        <div class="col-12 my-2">
            <div class="d-flex justify-content-center">
                <button class="btn btn-outline-success px-4" type="submit" id="payhere-payment" onclick="singleBuyNow('<?php echo ($p_data['id']); ?>');">Buy Now</button>
            </div>
        </div>


    </div>

    <div class="py-1 d-flex justify-content-center text-white bg-success">
        <span class="text-decoration-underline c-pointer" onclick="buyNowModal();">Continue Shopping</span>
    </div>

</div>