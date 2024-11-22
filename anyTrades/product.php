<?php

session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | AnyTrades</title>
    <!-- Link to CSS -->
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="demo-files/demo.css" />
    <link rel="stylesheet" href="icomoon.css" />
    <link rel="icon" href="resources/AnyTrades logo.png" type="image">
</head>

<body style="background-color: #f4f4f4; min-height: 100vh;">

<?php require "alert.php"; ?>

    <div class="container-fluid">
        <div class="row">

            <?php include "header.php"; ?>

            <div class="col-12">
                <div class="row">


                    <div class="col-12 col-lg-11 my-2 mid-content">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">

                                    <a href="#" class="d-flex justify-content-between align-items-center border-bottom border-secondary text-secondary my-1" onclick="categoryGridMove();">
                                        <span class="fs-4 fw-bold l-space-1">Category</span>
                                        <span class="icon-up-arrow-svgrepo-com fs-4 fw-bold" id="categoryMoveArrow"></span>
                                    </a>

                                    <div class="category_grid col-11 mid-content" id="category_grid">
                                        <?php

                                        require "connection.php";

                                        $category_rs = Database::search("SELECT * FROM `category`");
                                        $category_num = $category_rs->num_rows;
                                        for ($x = 0; $x < $category_num; $x++) {
                                            $category_data = $category_rs->fetch_assoc();
                                        ?>
                                            <div class="category-item position-relative" onclick="categoryView('<?php echo ($category_data['id']); ?>');">
                                                <img src="<?php echo ($category_data["img"]); ?>" />
                                                <div class="category-item-content position-absolute text-center"><?php echo ($category_data["name"]); ?></div>
                                            </div>
                                        <?php
                                        }
                                        ?>

                                    </div>

                                </div>
                            </div>






                            <div class="col-12 my-2">
                                <div class="row">

                                    <a href="#" class="d-flex justify-content-between align-items-center border-bottom border-secondary text-secondary my-1" onclick="advanceSearchMove();">
                                        <span class="fs-4 fw-bold l-space-1">Advance Search</span>
                                        <span class="icon-down-arrow-svgrepo-com-1 fs-4 fw-bold" id="advanceSearchArrow"></span>
                                    </a>

                                    <div class="col-12 col-xl-9 col-lg-11 col-xxl-7 mid-content" id="advanceSearchPanel" style="height: 0px; overflow: hidden;">
                                        <div class="row g-3">

                                            <div class="col-12 mt-4">
                                                <div class="d-flex gap-2">
                                                    <input type="text" class="form-control" placeholder="Product Title..." id="advSearchTxt" />
                                                    <button class="btn btn-primary px-5" onclick="advanceSearch('1');">Search</button>
                                                </div>
                                            </div>

                                            <div class="col-12 d-none d-lg-block">
                                                <hr class="m-0">
                                            </div>

                                            <?php
                                            $category_list_rs = Database::search("SELECT * FROM `category`");
                                            $category_list_num = $category_list_rs->num_rows;
                                            ?>

                                            <div class="col-12 col-lg-4">
                                                <select class="form-select" onchange="brandListLoader();" id="categoryList">
                                                    <option value="0">Select Category</option>
                                                    <?php
                                                    for ($x = 0; $x < $category_list_num; $x++) {
                                                        $category_list_data = $category_list_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($category_list_data["id"]); ?>"><?php echo ($category_list_data["name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <select class="form-select" id="brandList" onchange="modalListLoader();">
                                                    <option value="0">Select Brand</option>
                                                </select>
                                            </div>

                                            <div class="col-12 col-lg-4">
                                                <select class="form-select" id="modalList">
                                                    <option value="0">Select Model</option>
                                                </select>
                                            </div>



                                            <?php
                                            $condition_rs = Database::search("SELECT * FROM `condition`");
                                            $condition_num = $condition_rs->num_rows;
                                            ?>
                                            <div class="col-12 col-lg-6">
                                                <select class="form-select" id="condition">
                                                    <option value="0">Select Condition</option>
                                                    <?php
                                                    for ($x = 0; $x < $condition_num; $x++) {
                                                        $condition_data = $condition_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($condition_data["id"]); ?>"><?php echo ($condition_data["name"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <?php
                                            $color_rs = Database::search("SELECT * FROM `color`");
                                            $color_num = $color_rs->num_rows;
                                            ?>
                                            <div class="col-12 col-lg-6">
                                                <select class="form-select" id="color">
                                                    <option value="0">Select Color</option>
                                                    <?php
                                                    for ($x = 0; $x < $color_num; $x++) {
                                                        $color_data = $color_rs->fetch_assoc();
                                                    ?>
                                                        <option value="<?php echo ($color_data["id"]); ?>"><?php echo ($color_data["color"]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="col-12 col-lg-4">
                                                <select class="form-select" id="rating">
                                                    <option value="0">Select Rating</option>
                                                    <option value="1">1 Star</option>
                                                    <option value="2">2 Star</option>
                                                    <option value="3">3 Star</option>
                                                    <option value="4">4 Star</option>
                                                    <option value="5">5 Star</option>
                                                </select>
                                            </div>

                                            <?php

                                            $year_rs = Database::search("SELECT `date_time` FROM `product` ORDER BY `date_time` ASC LIMIT 1");
                                            $year_data = $year_rs->fetch_assoc();

                                            $start_year = (explode("-", (explode(" ", $year_data["date_time"]))[0]))[0];

                                            $d = new DateTime();
                                            $tz = new DateTimeZone("Asia/Colombo");
                                            $d->setTimezone($tz);
                                            $end_year = $d->format("Y");

                                            $dif_year = $end_year - $start_year;

                                            ?>
                                            <div class="col-12 col-lg-4">
                                                <select class="form-select" id="year">
                                                    <option value="0">Select Year</option>
                                                    <?php
                                                    for ($x = 0; $x < $dif_year; $x++) {
                                                    ?>
                                                        <option value="<?php echo ($start_year); ?>"><?php echo ($start_year); ?></option>
                                                    <?php
                                                        $start_year = $start_year + 1;
                                                    }
                                                    ?>
                                                    <option value="<?php echo ($end_year); ?>"><?php echo ($end_year); ?></option>
                                                </select>
                                            </div>



                                            <?php

                                            $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "Octomber", "November", "December");
                                            ?>
                                            <div class="col-12 col-lg-4">
                                                <select class="form-select" id="month">
                                                    <option value="0">Select Month</option>
                                                    <?php
                                                    for ($x = 0; $x < sizeof($months); $x++) {
                                                    ?>
                                                        <option value="<?php echo ($x + 1); ?>"><?php echo ($months[$x]); ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>


                                            <div class="col-12 col-lg-6">
                                                <input type="text" class="form-control" placeholder="Price From" id="p_from"/>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <input type="text" class="form-control" placeholder="Price To" id="p_to"/>
                                            </div>

                                            <div class="col-6 d-grid mid-content">
                                                <button class="btn btn-primary" onclick="advanceFullSearch('1');">Find The Product(s)</button>
                                            </div>

                                        </div>
                                    </div>




                                </div>
                            </div>

                            <!-- Product View Area -->
                            <div class="col-12 mt-2">
                                <div class="row">
                                    <span class="bg-secondary py-2 px-2 text-white fw-bold l-space-1 fs-5">Searched Product</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row" id="advanceSearchResult">

                                    <div class="col-12 w-100 height-100 d-flex flex-column align-items-center mt-2">
                                        <span class="fs-3 fw-bold text-black-50">No items searched yet.</span>
                                        <i class="icon-search_black_24dp text-black-50 fs-1"></i>
                                    </div>

                                </div>
                            </div>

                        </div>
                        <!-- Product View Area -->


                    </div>
                </div>


            </div>
        </div>

    </div>

    <?php include "footer.php"; ?>


    <script src="script.js"></script>
</body>

</html>