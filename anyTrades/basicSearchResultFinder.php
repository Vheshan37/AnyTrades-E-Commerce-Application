<?php
require "connection.php";

if (isset($_GET["txt"])) {

    $rs = Database::search("SELECT * FROM `product` WHERE `title` LIKE'%" . $_GET["txt"] . "%'");
    $num = $rs->num_rows;

?>

    <div class="col-12">
        <div class="d-flex flex-column" style="max-height: 40vh; overflow-y: scroll;">

            <?php
            for ($a = 0; $a < $num; $a++) {
                $data = $rs->fetch_assoc();

                $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $data["id"] . "'");
                $img_data = $img_rs->fetch_assoc();
            ?>

                <div class="d-flex border-bottom pb-2 search-result-item c-pointer align-items-center gap-2" onclick="singleProductView('<?php echo ($data['id']); ?>');">
                    <img src="<?php echo ($img_data["path"]); ?>" class="img-fluid w-25" style="max-height: 50px; object-fit: contain;">
                    <div class="fw-bold w-75"><?php echo ($data["title"]); ?></div>
                </div>

            <?php
            }
            ?>

        </div>
    </div>

<?php

}
?>