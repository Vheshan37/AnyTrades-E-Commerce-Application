<?php
require "connection.php";

?>


<div class="col-12 border-top mt-4">
    <div class="row" style="overflow-x: auto;">

        <table class="table table-bordered table-hover table-dark table-striped">
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

            $user = $_GET["txt"];
            $name_array = explode(" ", $user);
            $fname = $name_array[0];
            if (sizeof($name_array) > 1) {
                // Search by first name and last name
                $lname = $name_array[1];
                $user_rs = Database::search("SELECT * FROM `user` WHERE `fname` LIKE'%" . $fname . "%' AND `lname` LIKE'%" . $lname . "%'");
            } else {
                // Search by first name
                $user_rs = Database::search("SELECT * FROM `user` WHERE `fname` LIKE'%" . $fname . "%'");
            }
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
        </table>

    </div>
</div>