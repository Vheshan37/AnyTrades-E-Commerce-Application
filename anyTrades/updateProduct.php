<?php

session_start();
require "connection.php";
if (isset($_SESSION["seller"])) {
    if (isset($_GET["id"])) {
        $pid = $_GET["id"];

        $p_rs = Database::search("SELECT `product`.`id`,`brand`.`name` AS `brand`,`model`.`model`,`product`.`title`,`color`.`color`,`condition`.name AS `condition`,`product`.`qty`,`product`.`price`,`product`.`delivery_in`,`product`.`delivery_out`,`product`.`desc`
                            FROM `product`
                            INNER JOIN `brand_has_model` ON `brand_has_model`.`id`=`product`.`brand_has_model_id`
                            INNER JOIN `brand` ON `brand`.`id`=`brand_has_model`.`brand_id`
                            INNER JOIN `model` ON `model`.`id`=`brand_has_model`.`model_id`
                            INNER JOIN `color` ON `product`.`color_id`=`color`.`id`
                            INNER JOIN `condition` ON `condition`.`id`=`product`.`condition_id`
                            WHERE `product`.`id`='" . $pid . "'");
        $p_data = $p_rs->fetch_assoc();
?>

        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Product Registration | AnyTrades</title>
            <!-- Link to CSS -->
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="demo-files/demo.css" />
            <link rel="stylesheet" href="icomoon.css" />
        </head>

        <body class="anp-body" style="overflow-x: hidden;">

            <?php require "alert.php"; ?>

            <div class="container-fluid">
                <div class="row">


                    <!-- Content -->
                    <div class="col-12">
                        <div class="row">

                            <div class="col-12 mt-1">
                                <h1 class="fw-bold text-center text-primary">Product Registration</h1>
                            </div>

                            <div class="col-12 col-xl-6 mt-2 border-end border-secondary">
                                <div class="row g-3">

                                    <div class="col-12 col-lg-6">
                                        <label for="brand" class="form-label fw-bold">Select Brand</label>
                                        <select id="brand" class="form-select" disabled>
                                            <option value="0"><?php echo ($p_data["brand"]); ?></option>
                                        </select>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="modal" class="form-label fw-bold">Select Modal</label>
                                        <select id="model" class="form-select" disabled>
                                            <option value="0"><?php echo ($p_data["model"]); ?></option>
                                        </select>
                                    </div>

                                    <div class="col-12">
                                        <label for="title" class="form-label fw-bold">Add Product Title</label>
                                        <input type="text" id="title" class="form-control" value="<?php echo ($p_data["title"]); ?>" />
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <label for="color" class="form-label fw-bold">Color</label>
                                        <select id="color" class="form-select" disabled>
                                            <option value="0"><?php echo ($p_data["color"]); ?></option>
                                        </select>
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <label for="condition" class="form-label fw-bold">Condition</label>
                                        <select id="condition" class="form-select" disabled>
                                            <option value="0"><?php echo ($p_data["condition"]); ?></option>
                                        </select>
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <label for="quantity" class="form-label fw-bold">Quantity</label>
                                        <input type="number" value="<?php echo ($p_data["qty"]); ?>" min="1" id="quantity" class="form-control" />
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <label for="size" class="form-label fw-bold">Size</label>
                                        <select id="size" class="form-select" disabled>
                                            <option value="0">Product Size</option>
                                        </select>
                                    </div>



                                    <div class="col-12">

                                        <div class="row g-2">
                                            <div class="col-12 col-lg-6">

                                                <label for="" class="form-label fw-bold">Unit Price</label>

                                                <div class="input-group">
                                                    <span class="input-group-text">Rs.</span>
                                                    <input type="text" id="price" class="form-control" disabled value="<?php echo ($p_data["price"]); ?>" />
                                                    <span class="input-group-text">.00</span>
                                                </div>

                                            </div>
                                            <div class="col-12 col-lg-6">

                                                <label for="" class="form-label fw-bold">Delivery Fee ( Withing Colombo )</label>

                                                <div class="input-group">
                                                    <span class="input-group-text">Rs.</span>
                                                    <input type="text" id="DIP" class="form-control" value="<?php echo ($p_data["delivery_in"]); ?>" />
                                                    <span class="input-group-text">.00</span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="row">

                                            <div class="col-12 mb-2">
                                                <label class="fw-bold">Set Delivery Fee For Other District</label>
                                            </div>
                                            <div class="col-12 col-lg-6 mb-2">
                                                <div class="input-group">
                                                    <span class="input-group-text">Rs.</span>
                                                    <input type="text" id="DOP" class="form-control" value="<?php echo ($p_data["delivery_out"]); ?>" />
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-6 d-grid">
                                                <button class="btn btn-outline-primary" onclick="DOCModalActive();">Set By District</button>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="" class="form-label fw-bold">Add Product Description</label>
                                        <textarea class="form-control" id="product_desc" cols="30" rows="10" style="min-height: 250px; max-height: 300px; overflow: hidden; overflow-y: scroll;"><?php echo ($p_data["desc"]); ?></textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="DOCModal d-none" id="DOCModal">
                                <div class="DOCModalBox py-3">
                                    <div class="DOCModalHead">
                                        <h3 class="text-center fw-bold">Delivery Fee</h3>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <?php

                                    $d_rs = Database::search("SELECT * FROM `district`");
                                    $d_num = $d_rs->num_rows;
                                    for ($x = 0; $x < $d_num; $x++) {
                                        $d_data = $d_rs->fetch_assoc();
                                    ?>

                                        <div class="DOCModalBody p-1">
                                            <div class="DOCModalRow">
                                                <div class="fw-bold"><?php echo ($d_data["name"]); ?> :</div>
                                                <input type="text" name="" id="">
                                            </div>
                                        </div>

                                    <?php
                                    }

                                    ?>
                                    <div class="col-12 p-2">
                                        <div class="d-flex gap-3">
                                            <button class="btn btn-outline-primary w-100">Continue</button>
                                            <button class="btn btn-outline-danger w-100" onclick="DOCModalActive();">Close</button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-xl-6 mt-2">
                                <div class="row g-3">


                                    <div class="col-12">
                                        <label for="" class="form-label fw-bold">Add Product Images</label>
                                    </div>

                                    <div class="col-8 col-lg-5 position-relative mid-content">
                                        <img src="resources/addproductimg.svg" class="mid-content" id="addNewProductImage" style="height: 300px; width: 300px; object-fit: contain;">
                                        <span class="position-absolute bg-secondary opacity-25 top-0 start-0 h-100 w-100"></span>
                                        <label for="productImg" onclick="changeProductImg();" class="position-absolute start-0 top-0 mid-content d-flex h-100 fw-bold align-items-center"><span class="c-pointer fs-5" id="add">Add +</span></label>
                                        <input type="file" class="d-none" id="productImg" multiple />
                                    </div>
                                    <span class="d-block text-center w-100">You can select up to 5 images</span>

                                    <div class="col-12">
                                        <hr>
                                    </div>

                                    <div class="col-12 bg-dark text-white py-2 position-relative">
                                        <span class="">Your Product Images</span>
                                        <div class="addProductSliderBtn position-absolute top-0 end-0 d-flex h-100 align-items-center fs-4 gap-1">
                                            <span class="icon-chevron-left c-pointer" onclick="addProductSlider(0);"></span>
                                            <span class="icon-chevron-right c-pointer" onclick="addProductSlider(1);"></span>
                                        </div>
                                    </div>

                                    <div class="addProductSlider mid-content border shadow overflow-hidden border-1 border-secondary rounded mb-3 p-0" style="width: 450px;">

                                        <div class="d-flex addProductSlides" id="addProductSlides">

                                            <?php

                                            $img_rs = Database::search("SELECT * FROM `image` WHERE `product_id`='" . $p_data["id"] . "'");
                                            $img_num = $img_rs->num_rows;
                                            $img = array();
                                            $img[0] = "resources/addproductimg.svg";
                                            $img[1] = "resources/addproductimg.svg";
                                            $img[2] = "resources/addproductimg.svg";
                                            $img[3] = "resources/addproductimg.svg";
                                            $img[4] = "resources/addproductimg.svg";

                                            for ($x = 0; $x < $img_num; $x++) {
                                                $img_data = $img_rs->fetch_assoc();
                                                $img[$x] = $img_data["path"];
                                            }

                                            ?>


                                            <div class="addProductSlide">
                                                <img src="<?php echo ($img[0]); ?>" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_0" class="border border-white border-1" onclick="addNewProductImagePreview(0);">
                                            </div>
                                            <div class="addProductSlide">
                                                <img src="<?php echo ($img[1]); ?>" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_1" class="border border-white border-1" onclick="addNewProductImagePreview(1);">
                                            </div>
                                            <div class="addProductSlide">
                                                <img src="<?php echo ($img[2]); ?>" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_2" class="border border-white border-1" onclick="addNewProductImagePreview(2);">
                                            </div>
                                            <div class="addProductSlide">
                                                <img src="<?php echo ($img[3]); ?>" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_3" class="border border-white border-1" onclick="addNewProductImagePreview(3);">
                                            </div>
                                            <div class="addProductSlide">
                                                <img src="<?php echo ($img[4]); ?>" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_4" class="border border-white border-1" onclick="addNewProductImagePreview(4);">
                                            </div>


                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="row">

                                            <div class="col-12 col-lg-10 col-xl-8 col-xxl-6 d-grid mid-content">
                                                <button class="btn btn-success" onclick="updateProduct('<?php echo ($pid); ?>');">Update</button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>


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
        echo ("Something Went Wrong? PLease Try Again Later");
    }
} else {
    header("Location:home.php");
}
?>