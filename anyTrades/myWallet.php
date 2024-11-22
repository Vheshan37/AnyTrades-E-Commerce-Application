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
        <title>Seller Wallet | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
        <style>
            .orders span:first-child,
            .orders span:last-child {
                width: 50px;
                height: 5px;
                border-radius: 5px;
                background-color: rgba(255, 255, 255, 0.4);
            }
        </style>
    </head>

    <body style="min-height: 100vh;" class="bg-dark">

    <?php require "alert.php"; ?>

        <!-- Remove Product -->
        <div class="position-fixed top-0 start-0 vw-100 vh-100 bg-dark bg-opacity-25 d-flex justify-content-center align-items-center d-none" id="orderDeleteModal">
            <div class="rounded shadow overflow-hidden pb-2 bg-white col-xxl-3 col-xl-4 col-lg-5 col-md-6 col-sm-7 col-8">
                <div class="bg-warning p-2">
                    <div class="d-flex text-white align-items-center gap-2">
                        <span class="fs-5 fw-bold">warning</span>
                    </div>
                </div>
                <div class="d-flex flex-column align-items-center gap-3 p-2">
                    <div class="w-100">
                        <label for="" class="form-label fw-bold">Confirm the request</label>
                        <input type="password" class="form-control" placeholder="Your NIC" id="admin_psw" />
                        <input type="text" disabled class="form-control mt-1" id="order_id" />
                    </div>
                    <div class="">
                        <button class="btn btn-primary px-4" style="border-radius: 100vh;" onclick="deleteOrder();">Delete</button>
                        <button class="btn btn-danger px-4" style="border-radius: 100vh;" onclick="orderDeleteViewer();">Cancell</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Remove Product -->


        <!-- View Customer Address -->
        <div class="box" id="customerAddress">
            <div class="signoutBox rounded pb-1 bg-white">

                <div class="box-head bg-success">
                    <label class="fw-bold p-1 text-white">Customer Address &#9888;</label>
                </div>

                <div class="box-body mt-5">
                    <label class="p-1" id="customerAddressDisplay">...</label>
                </div>

                <div class="box-footer gap-2 p-1 px-2">
                    <button class="btn btn-primary" id="removeYes" onclick="viewCustomerAddress(false,null);">Done</button>
                </div>

            </div>
        </div>
        <!-- View Customer Address -->


        <div class="container-fluid">
            <div class="row">

                <?php include "header.php" ?>


                <div class="col-12">
                    <div class="row home-head">

                        <!-- Home Header -->
                        <div class="col-12 p-0">
                            <div class="d-flex align-items-center home-header py-2">

                                <div class="site-name">
                                    <span class="f-Debugged">SellerHouse</span>
                                </div>

                                <!-- Nav Bar -->
                                <div class="home-nav">

                                    <div class="fs-3 d-block d-lg-none">
                                        <a href="#" onclick="mobileNavBar();">&#9776;</a>
                                    </div>

                                    <div class="">
                                        <a href="addNewProduct.php">Add New Product</a>
                                    </div>
                                    <div class="">
                                        <a href="#" onclick="filterPanelMove()">Filter Panel</a>
                                    </div>
                                    <div class="">
                                        <a href="#">Customer Reviews</a>
                                    </div>
                                    <div class="">
                                        <a href="myWallet.php">Wallet</a>
                                    </div>

                                    <div class="d-flex justify-content-end">

                                        <div class="home-search-bar">
                                            <input type="text" placeholder="Search orders" />
                                            <span class="fw-bold">Search</span>
                                        </div>
                                    </div>

                                </div>
                                <!-- Nav Bar -->

                                <!-- Mobile-nav-bar -->
                                <div class="mobile-nav-bar bg-dark d-lg-none" style="min-height: 100vh;" id="mobile-nav-bar">

                                    <div class="col-12 mb-3 mt-3">
                                        <img src="resources/profile_images/new_user.svg" class="mid-content">

                                        <span class="text-center d-block fw-bold text-white">Vihanga Heshan</span>
                                        <span class="text-center d-block text-white-50 fw-bold">vihangaheshan37@gmail.com</span>
                                        <!-- <a href="#" class="text-center d-block">Sign in or Register</a> -->
                                    </div>


                                    <div class="col-12 px-1">
                                        <hr>
                                    </div>


                                    <ul>
                                        <li><a href="addNewProduct.php" class="fw-bold">Add New Product</a></li>
                                        <li><a href="#" class="fw-bold" onclick="filterPanelMove();">Filter Panel</a></li>
                                        <li><a href="userPanel.php" class="fw-bold">Customer Reviews</a></li>
                                        <li><a href="#" class="fw-bold">Wallet</a></li>
                                    </ul>

                                </div>
                                <!-- Mobile-nav-bar -->

                            </div>
                        </div>
                        <!-- Home Header -->


                    </div>
                </div>
                <!-- Head -->


                <!-- My Product Filter Panel -->
                <div class="col-12 filterPanel" id="filterPanel">
                    <div class="row g-2">

                        <div class="col-xl-3 offset-xl-2 col-6 col-lg-4">
                            <select class="form-select">
                                <option value="0">Filter By</option>
                                <option value="0">Added Date</option>
                                <option value="0">Title</option>
                                <option value="0">Quantity</option>
                                <option value="0">Rating</option>
                                <option value="0">Sellings</option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-6 col-lg-4">
                            <select class="form-select">
                                <option value="0">Order By</option>
                                <option value="0">Ascending</option>
                                <option value="0">Descending</option>
                            </select>
                        </div>

                        <div class="col-xl-3 col-10 offset-1 offset-lg-0 col-lg-4">
                            <div class="row">
                                <div class="col-6 d-grid">
                                    <button class="btn btn-primary">Apply Filter</button>
                                </div>
                                <div class="col-6 d-grid">
                                    <button class="btn btn-dark">Clear Filter</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- My Product Filter Panel -->


                <!-- Content -->
                <div class="col-12">
                    <div class="row pt-2">

                        <?php
                        $sellerTable = Database::search("SELECT * FROM seller
                                                    WHERE seller.nic='" . $_SESSION["seller"]["nic"] . "'");
                        if ($sellerTable->num_rows > 0) {
                            $sellerData = $sellerTable->fetch_assoc();

                            $totalIncomeTable = Database::search("SELECT SUM(`invoice`.`total`) AS `total` FROM `invoice`
                                                    INNER JOIN `product` ON `product`.`id`=`invoice`.`product_id`
                                                    WHERE `product`.`seller_nic`='" . $_SESSION["seller"]["nic"] . "'");
                            $totalIncome = $totalIncomeTable->fetch_assoc();

                            $monthlyIncomeTable = Database::search("SELECT SUM(`invoice`.`total`) AS `total` FROM `invoice`
                                                    INNER JOIN `product` ON `product`.`id`=`invoice`.`product_id`
                                                    WHERE `product`.`seller_nic`='" . $_SESSION["seller"]["nic"] . "' 
                                                    AND YEAR(`invoice`.`date_time`)='2024' AND MONTH(`invoice`.`date_time`)='06'");
                            $monthlyIncome = $monthlyIncomeTable->fetch_assoc();
                        ?>

                            <div class="summery border-0 text-white">
                                <div class="rounded p-1 bg-white bg-opacity-10 d-flex justify-content-center align-items-center flex-column" style="height: 200px; width: 100%;">
                                    <span class="fs-3 fw-bold w-100 text-center d-block">Overall Income</span>
                                    <span class="fs-5 w-100 text-center d-block text-white-50">Rs.<?php echo (number_format($totalIncome["total"], 2, '.', "'")); ?></span>
                                </div>
                                <div class="rounded p-1 bg-white bg-opacity-10 d-flex justify-content-center align-items-center flex-column" style="height: 200px; width: 100%;">
                                    <span class="fs-3 fw-bold w-100 text-center d-block">Available Cash</span>
                                    <span class="fs-5 w-100 text-center d-block text-white-50">Rs.<?php echo (number_format($sellerData["available_cash"], 2, '.', "'")); ?></span>
                                    <button class="btn btn-outline-light" onclick="requestWithdrawal();">Request Withdrawal</button>
                                </div>
                                <div class="rounded p-1 bg-white bg-opacity-10 d-flex justify-content-center align-items-center flex-column" style="height: 200px; width: 100%;">
                                    <span class="fs-3 fw-bold w-100 text-center d-block">Overall Withdrawal</span>
                                    <span class="fs-5 w-100 text-center d-block text-white-50">Rs.<?php echo (number_format($sellerData["withdrawal_amount"], 2, '.', "'")); ?></span>
                                </div>
                                <div class="rounded p-1 bg-white bg-opacity-10 d-flex justify-content-center align-items-center flex-column" style="height: 200px; width: 100%;">
                                    <span class="fs-3 fw-bold w-100 text-center d-block">Monthly Income</span>
                                    <span class="fs-5 w-100 text-center d-block text-white-50">Rs.<?php echo (number_format($monthlyIncome["total"], 2, '.', "'")); ?></span>
                                </div>
                            </div>

                        <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="">
                    <div class="d-flex justify-content-center orders gap-2 align-items-center">
                        <span></span>
                        <span class="fs-2 fw-bold text-white">Annual Income (<?php echo (date("Y")); ?>)</span>
                        <span></span>
                    </div>
                    <canvas id="myChart"></canvas>
                </div>
                <!-- Content -->

            </div>
        </div>

        <?php include "footer.php"; ?>

        <script src="script.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            (function() {
                var req = new XMLHttpRequest();

                req.onreadystatechange = function() {
                    if (req.readyState == 4) {
                        // Handle Response

                        var dataArray = JSON.parse(req.responseText);

                        // Handle Response

                        const ctx = document.getElementById('myChart'); // Create Chart

                        new Chart(ctx, { // Chart Initialization
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                                datasets: [{
                                    label: 'Total Income',
                                    data: dataArray,
                                    borderWidth: 1,
                                    backgroundColor: "rgba(158, 72, 41,0.5)",
                                    borderColor: "#ff270f",
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        ticks: {
                                            callback: function(value) {
                                                return "Rs. " + value + ".00"; // include the dollar sign into the values
                                            },
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    }
                };

                req.open("GET", "loadAnnualIncomeChart.php", true);
                req.send();
            })();
        </script>
    </body>

    </html>


<?php
} else {
    header("Location:home.php");
}


?>