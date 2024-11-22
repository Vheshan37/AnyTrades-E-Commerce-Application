<?php

require "connection.php";
if (isset($_GET["txt"])) {
    $txt = $_GET["txt"];
    $product_rs = Database::search("SELECT * FROM product WHERE title LIKE'%" . $txt . "%'");
    $product_num = $product_rs->num_rows;

?>
    <div class="admin-product-grid mt-2 p-2">
        <?php
        for ($x = 0; $x < $product_num; $x++) {
            $product_data = $product_rs->fetch_assoc();
            $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $product_data["id"] . "'");
            $img_data = $img_rs->fetch_assoc();
        ?>
            <div class="rounded overflow-hidden border border-success">
                <img src="<?php echo ($img_data["path"]); ?>" />
                <div class="d-flex flex-column p-2">
                    <span class="fw-bold fs-5"><?php echo ($product_data["title"]); ?></span>
                    <span class="">Rs. <?php echo ($product_data["price"]); ?>.00</span>
                </div>
                <div class="manege-btn bg-success text-white text-center text-decoration-underline c-pointer mt-auto">Manage</div>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
