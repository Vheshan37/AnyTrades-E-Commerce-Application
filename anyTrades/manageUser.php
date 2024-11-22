<?php

require "connection.php";
session_start();

if (isset($_SESSION["at_admin"])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Users || AnyTrades</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="admin_resources/admin.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="c-default">

    <?php require "alert.php"; ?>
    
        <div class="container-fluid">
            <div class="row">

                <!-- Side Bar -->
                <div class="col-xxl-2 col-xl-3 col-lg-4 col-6 col-md-5 bg-white border-end min-vh-100 admin-sidebar" style="max-height: 100vh; overflow-y: auto;" id="adminSideBar">
                    <div class="row p-1">

                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2 align-items-center">
                                <div class="width-50 height-50 bg-primary rounded-circle d-flex justify-content-center align-items-center text-white fw-bold">AT</div>
                                <h2 class="fw-bold">AnyTrades</h2>
                            </div>
                            <div class="d-flex align-items-center d-block d-lg-none">
                                <i class="icon-close_black_24dp fs-4 fw-bold c-pointer text-danger" onclick="adminSideBarMove();"></i>
                            </div>
                        </div>

                        <hr class="my-1">

                        <div class="col-12">
                            <div class="row p-1">

                                <ul class="list-unstyled admin-panel-menu">
                                    <li class="my-2">
                                        <a href="adminPanel.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                            <i class="icon-dashboard_black_24dp"></i>
                                            <span class="fs-5">Dashboard</span>
                                        </a>
                                    </li>
                                    <li class="my-2">
                                        <a href="leaderBoard.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                            <i class="icon-bar_chart_black_24dp"></i>
                                            <span class="fs-5">Leaderboard</span>
                                        </a>
                                    </li>
                                    <li class="my-2">
                                        <a href="adminProduct.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                            <i class="icon-shopping_bag_black_24dp"></i>
                                            <span class="fs-5">Product</span>
                                        </a>
                                    </li>
                                    <!-- <li class="my-2">
                                        <a href="orders.php" class="d-flex gap-2 align-items-center text-decoration-none p-2">
                                            <i class="icon-attach_money_black_24dp"></i>
                                            <span class="fs-5">Orders</span>
                                        </a>
                                    </li> -->
                                    <li class="my-2">
                                        <a href="manageUser.php" class="d-flex gap-2 align-items-center text-decoration-none p-2 active">
                                            <i class="icon-user-profile-svgrepo-com"></i>
                                            <span class="fs-5">Manage Users</span>
                                        </a>
                                    </li>
                                </ul>

                            </div>
                        </div>

                    </div>
                </div>
                <!-- Side Bar -->

                <!-- Content -->
                <div class="col-xxl-10 col-xl-9 col-lg-8 min-vh-100" style="max-height: 100vh; overflow-y: auto;">
                    <div class="row">

                        <div class="col-12 mt-2">
                            <div class="d-flex gap-3 flex-column flex-xl-row">

                                <div class="d-flex gap-3 align-items-center justify-content-between justify-content-lg-end">
                                    <i class="icon-menu_black_24dp fs-3 fw-bold d-block d-lg-none c-pointer" onclick="adminSideBarMove();"></i>
                                    <span class="fs-3 fw-bold d-block" style="font-family: arial;">Users</span>
                                </div>

                                <div class="d-flex justify-content-between w-100">
                                    <div class="border border-1 p-2 d-flex align-items-center gap-2 bg-secondary bg-opacity-25 w-50" style="border-radius: 100vh;">
                                        <i class="icon-search_black_24dp1 c-pointer fs-5 fw-bold text-primary" onclick="searchUsers();"></i>
                                        <input type="text" placeholder="Search here..." class="border-0 bg-transparent" style="outline: none; width: 100%;" id="search_user" onkeyup="searchUsersKey(event);">
                                    </div>

                                    <div class="d-flex gap-1">
                                        <!-- <img src="resources/profile_images/Vihanga_profile_img_636b2c60b5189.jpeg" alt="" style="width: 50px; height: 50px; clip-path: circle();"> -->
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold"><?php echo($_SESSION["at_admin"]["name"]) ?></span>
                                            <span class="text-black-50">Admin</span>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="icon-expand_more_black_24dp fs-4 c-pointer"></i>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="" id="search_user_content">
                            <div class="col-12 border-top mt-4">
                                <div class="row" style="overflow-x: auto;">

                                    <table class="table table-bordered table-hover table-striped table-dark">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Profile</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <?php

                                        if (isset($_GET["page_no"])) {
                                            $page_no = $_GET["page_no"];
                                        } else {
                                            $page_no = 1;
                                        }

                                        $pagination_rs = Database::search("SELECT * FROM `user` ORDER BY `fname`");
                                        $pagination_num = $pagination_rs->num_rows;

                                        $result_per_page = 20;
                                        $number_of_pages = ceil($pagination_num / $result_per_page);
                                        $offset = ($page_no - 1) * $result_per_page;

                                        if ($pagination_num > 0) {

                                            $user_rs = Database::search("SELECT * FROM `user` ORDER BY `fname` LIMIT " . $result_per_page . " OFFSET " . $offset . "");
                                            $user_num = $user_rs->num_rows;

                                        ?>
                                            <tbody>
                                                <?php
                                                for ($u = 0; $u < $user_num; $u++) {
                                                    $user_data = $user_rs->fetch_assoc();
                                                    $u_img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $user_data["email"] . "'");
                                                    $u_img_num = $u_img_rs->num_rows;
                                                    if ($u_img_num > 0) {
                                                        $u_img_data = $u_img_rs->fetch_assoc();
                                                        $user_img = $u_img_data["p_img"];
                                                    } else {
                                                        $user_img = "resources/new_user.svg";
                                                    }
                                                ?>
                                                    <tr>
                                                        <td><?php echo ($u + 1); ?></td>
                                                        <td><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></td>
                                                        <td><?php echo ($user_data["email"]); ?></td>
                                                        <td><img src="<?php echo ($user_img); ?>" alt="" style="width: 100%; object-fit: contain; max-height: 70px; clip-path: circle();"></td>
                                                        <td><?php
                                                            if ($user_data["user_type_id"] == 1) {
                                                                echo ("Buyer");
                                                            } else {
                                                                echo ("Seller");
                                                            }
                                                            ?></td>
                                                        <td class="<?php
                                                                    if ($user_data["status"] == 1) {
                                                                        echo ("text-primary");
                                                                    } else if ($user_data["status"] == 2) {
                                                                        echo ("text-danger");
                                                                    }
                                                                    ?>"><?php
                                                                        if ($user_data["status"] == 1) {
                                                                            echo ("Active");
                                                                        } else if ($user_data["status"] == 2) {
                                                                            echo ("Blocked");
                                                                        }
                                                                        ?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-center align-items-center gap-3">
                                                                <i class="icon-visibility_black_24dp fw-bold c-pointer fs-5"></i>

                                                                <?php
                                                                if ($user_data["status"] == 1) {
                                                                ?>
                                                                    <i class="icon-block_black_24dp text-danger fw-bold c-pointer fs-5" onclick="changeUserStatus(2,'<?php echo ($user_data['email']); ?>');"></i>
                                                                <?php
                                                                } else if ($user_data["status"] == 2) {
                                                                ?>
                                                                    <i class="icon-verified_user_black_24dp text-primary fw-bold c-pointer fs-5" onclick="changeUserStatus(1,'<?php echo ($user_data['email']); ?>');"></i>
                                                                <?php
                                                                }
                                                                ?>

                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                        <?php
                                        }

                                        ?>
                                    </table>

                                </div>
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
                                    <a class="text-decoration-none p_nation_prev" href="?&page_no=<?php
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
                                    <a href="?&page_no=1" <?php
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
                                        <a href="?&page_no=<?php echo ($middle_left); ?>" <?php
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
                                        <a href="?&page_no=<?php echo ($middle_page); ?>" <?php
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
                                        <a href="?&page_no=<?php echo ($middle_right); ?>" <?php
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
                                        <a href="?&page_no=<?php echo ($number_of_pages); ?>" <?php
                                                                                                if ($page_no == $number_of_pages) {
                                                                                                ?> style="background-color: #0c0091; color: white;" <?php
                                                                                                                                                }
                                                                                                                                                    ?>><?php echo ($number_of_pages); ?></a>
                                    <?php
                                    }
                                    ?>
                                    <!-- Last page of the pagination -->


                                    <!-- Next Button of the pagination -->
                                    <a class="text-decoration-none p_nation_next" href="?&page_no=<?php
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
    header("Location:adminSignin.php");
}

?>