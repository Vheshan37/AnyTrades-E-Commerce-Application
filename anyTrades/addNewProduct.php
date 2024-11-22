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
        <title>Product Registration | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="anp-body" style="overflow-x: hidden; min-height: 100vh;">

    <?php require "alert.php"; ?>

        <div class="container-fluid">
            <div class="row">

                <!-- Category Selector -->
                <?php

                if (!isset($_SESSION["category"])) {
                ?>

                    <div class="position-fixed vw-100 vh-100 top-0 start-0 bg-dark d-flex justify-content-center align-items-center gap-2" id="categorySelecter" style="z-index: 1;">

                        <div class="col-12 col-xxl-6 col-xl-8 col-lg-10 gap-3">
                            <div class="d-flex align-items-center gap-3 p-1">



                                <div class="position-relative c-list-container w-100">
                                    <div class="border border-white p-3 text-white mb-1 form-select bg-transparent c-pointer" id="c-list-view" style="border-radius: 100vh;">Select Your Product Category</div>
                                    <div class="col-12 position-absolute top-100 c-list rounded bg-light overflow-hidden" id="c-list-menu">
                                        <?php

                                        $c_rs = Database::search("SELECT * FROM `category`");
                                        $c_num = $c_rs->num_rows;
                                        for ($y = 1; $y <= $c_num; $y++) {
                                            $c_data = $c_rs->fetch_assoc();
                                        ?>
                                            <span class="d-block w-100 text-center p-2" id="c-list-item-<?php echo ($y); ?>" onclick="cListChange('<?php echo ($y); ?>');"><?php echo ($c_data["name"]); ?></span>
                                        <?php
                                        }

                                        ?>
                                    </div>
                                </div>

                                <div class="d-flex col-3 mb-2 justify-content-center">
                                    <div class="col-12 d-grid">
                                        <button class="btn btn-outline-warning" onclick="ProductRegistration();" style="border-radius: 100vh;">Next</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>

                <?php
                }

                ?>
                <!-- Category Selector -->


                <!-- Content -->
                <div class="col-12">
                    <div class="row">

                        <div class="col-12 mt-1">
                            <h1 class="fw-bold text-center text-primary">Product Registration</h1>
                        </div>

                        <?php
                        if (isset($_SESSION["category"])) {
                            $c_rs = Database::search("SELECT * FROM `category` WHERE `id`='" . $_SESSION["category"] . "'");
                            $c_data = $c_rs->fetch_assoc();
                        }
                        ?>

                        <div class="col-12 bg-secondary py-2 text-white mt-3 d-flex align-items-center gap-1">
                            <span class="text-dark fw-bold c-pointer">Category</span>
                            /
                            <span class="c-pointer" id="category_name"><?php echo ($c_data["name"]); ?></span>
                            <span class="icon-delete-svgrepo-com text-danger c-pointer" onclick="deleteselectedCategory();"></span>
                        </div>

                        <div class="col-12 col-xl-6 mt-2 border-end border-secondary">
                            <div class="row g-3">

                                <div class="col-12 col-lg-6">
                                    <label for="brand" class="form-label fw-bold">Select Brand</label>
                                    <select id="brand" class="form-select" onchange="modelSelector();">
                                        <?php

                                        $b_rs = Database::search("SELECT * FROM `brand` WHERE `category_id`='" . $_SESSION["category"] . "'");
                                        $b_num = $b_rs->num_rows;

                                        for ($x = 0; $x < $b_num; $x++) {
                                            $b_data = $b_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($b_data["id"]); ?>"><?php echo ($b_data["name"]); ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="modal" class="form-label fw-bold">Select Modal</label>
                                    <select id="model" class="form-select">
                                        <option value="0">Select Modal</option>
                                        <?php

                                        $m_rs = Database::search("SELECT * FROM `model`");
                                        $m_num = $m_rs->num_rows;

                                        for ($y = 0; $y < $m_num; $y++) {

                                            $m_data = $m_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($m_data["id"]); ?>"><?php echo ($m_data["model"]); ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label for="title" class="form-label fw-bold">Add Product Title</label>
                                    <input type="text" id="title" class="form-control" />
                                </div>

                                <div class="col-12 col-lg-6">
                                    <label for="color" class="form-label fw-bold">Color</label>
                                    <select id="color" class="form-select">
                                        <option value="0">Select Color</option>
                                        <?php

                                        $color_rs = Database::search("SELECT * FROM `color`");
                                        $color_num = $color_rs->num_rows;
                                        for ($x = 0; $x < $color_num; $x++) {

                                            $color_data = $color_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($color_data["id"]); ?>"><?php echo ($color_data["color"]); ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>


                                <div class="col-12 col-lg-6">
                                    <label for="condition" class="form-label fw-bold">Condition</label>
                                    <select id="condition" class="form-select">
                                        <option value="0">Select Condition</option>
                                        <?php

                                        $condition_rs = Database::search("SELECT * FROM `condition`");
                                        $condition_num = $condition_rs->num_rows;
                                        for ($x = 0; $x < $condition_num; $x++) {

                                            $condition_data = $condition_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($condition_data["id"]); ?>"><?php echo ($condition_data["name"]); ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>


                                <div class="col-12 col-lg-6">
                                    <label for="quantity" class="form-label fw-bold">Quantity</label>
                                    <input type="number" value="1" min="1" id="quantity" class="form-control" />
                                </div>


                                <div class="col-12 col-lg-6">
                                    <label for="size" class="form-label fw-bold">Size</label>
                                    <select id="size" class="form-select" <?php
                                                                            if ($_SESSION["category"] != "6" && $_SESSION["category"] != "9") {
                                                                                echo ("disabled");
                                                                            }
                                                                            ?>>
                                        <option value="0">Product Size</option>
                                        <?php

                                        $size_rs = Database::search("SELECT * FROM size WHERE `category_id`='" . $_SESSION["category"] . "'");
                                        $size_num = $size_rs->num_rows;

                                        for ($x = 0; $x < $size_num; $x++) {
                                            $size_data  = $size_rs->fetch_assoc();
                                        ?>
                                            <option value="<?php echo ($size_data["id"]); ?>"><?php echo ($size_data["size"]); ?></option>
                                        <?php
                                        }

                                        ?>
                                    </select>
                                </div>



                                <div class="col-12">

                                    <div class="row g-2">
                                        <div class="col-12 col-lg-6">

                                            <label for="" class="form-label fw-bold">Unit Price</label>

                                            <div class="input-group">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="text" id="price" class="form-control" />
                                                <span class="input-group-text">.00</span>
                                            </div>

                                        </div>
                                        <div class="col-12 col-lg-6">

                                            <label for="" class="form-label fw-bold">Delivery Fee ( Withing Colombo )</label>

                                            <div class="input-group">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="text" id="DIP" class="form-control" />
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
                                                <input type="text" id="DOP" class="form-control" />
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
                                    <textarea class="form-control" id="product_desc" cols="30" rows="10"></textarea>
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

                                <div class="col-5 position-relative mid-content">
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
                                        <span class="icon-chevron_left_black_24dp c-pointer" onclick="addProductSlider(0);"></span>
                                        <span class="icon-chevron_right_black_24dp c-pointer" onclick="addProductSlider(1);"></span>
                                    </div>
                                </div>

                                <div class="addProductSlider mid-content border shadow overflow-hidden border-1 border-secondary rounded mb-3 p-0" style="width: 450px;">

                                    <div class="d-flex addProductSlides" id="addProductSlides">

                                        <div class="addProductSlide">
                                            <img src="resources/addproductimg.svg" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_0" class="border border-white border-1" onclick="addNewProductImagePreview(0);">
                                        </div>
                                        <div class="addProductSlide">
                                            <img src="resources/addproductimg.svg" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_1" class="border border-white border-1" onclick="addNewProductImagePreview(1);">
                                        </div>
                                        <div class="addProductSlide">
                                            <img src="resources/addproductimg.svg" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_2" class="border border-white border-1" onclick="addNewProductImagePreview(2);">
                                        </div>
                                        <div class="addProductSlide">
                                            <img src="resources/addproductimg.svg" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_3" class="border border-white border-1" onclick="addNewProductImagePreview(3);">
                                        </div>
                                        <div class="addProductSlide">
                                            <img src="resources/addproductimg.svg" style="width: 150px; height: 200px; object-fit: contain; object-position: center;" id="product_img_4" class="border border-white border-1" onclick="addNewProductImagePreview(4);">
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 mb-2">
                                    <div class="row">

                                        <div class="col-12 col-lg-10 col-xl-8 col-xxl-6 d-grid mid-content">
                                            <button class="btn btn-success" onclick="newProductRegistration();">Register</button> 
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

        <?php include "footer.php"; ?>

        <script src="script.js"></script>
    </body>

    </html>



<?php
} else {
    header("Location:home.php");
}
?>