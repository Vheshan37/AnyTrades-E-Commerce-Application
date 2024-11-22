<?php

session_start();
require "connection.php";
$seller = $_GET["email"];
$email = $_SESSION["at_u"]["email"];

if ($seller == $email) {
    echo ("1");
} else {

    $seller_rs = Database::search("SELECT * FROM `seller` INNER JOIN `user` ON `user`.`email`=`seller`.`user_email` INNER JOIN `seller_profile_image` ON `seller_profile_image`.`seller_nic`=`seller`.`nic` WHERE `user`.`email`='" . $seller . "'");
    $seller_num = $seller_rs->num_rows;

?>


    <div class="msg_modal rounded overflow-hidden col-xxl-4 col-xl-5 col-lg-6 col-md-7 col-11 d-flex flex-column">
        <div class="height-70 w-100 d-flex align-items-center gap-3 position-relative border-bottom border-secondary">
            <div class="width-80 height-80 d-flex align-items-center">
                <?php
                if ($seller_num > 0) {
                    $seller_data = $seller_rs->fetch_assoc();
                    $img = $seller_data["seller_img"];
                } else {
                    $img = "resources/new_user.svg";
                }
                ?>
                <img src="<?php echo ($img); ?>" alt="" class="" style="width: 100%; object-fit: contain; clip-path: circle();" />
            </div>
            <span class="w-100 fw-bold fs-5 text-white"><?php
                                                        if (isset($seller_data["name"])) {
                                                            echo ($seller_data["name"]);
                                                        } else {
                                                            $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $seller . "'");
                                                            $user_data = $user_rs->fetch_assoc();
                                                            echo ($user_data["fname"] . " " . $user_data["lname"]);
                                                        }
                                                        ?></span>
            <div class="position-absolute w-100 text-end pe-4">
                <span style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;" class="fs-1 fw-bold text-white-50 c-pointer" onclick="openSellerMessageModal();">X</span>
            </div>
        </div>

        <!-- Message View Area -->
        <div class="py-2 px-3 d-flex flex-column" style="min-height: 65vh; max-height: 65vh; overflow-y: scroll; overflow-x: hidden; row-gap: 10px;" id="sellerMsgArea">

            <?php

            $direction = $_GET["direction"];

            $chat_rs = Database::search("SELECT *
            FROM chat
            WHERE `from`='" . $seller . "' AND `to`='" . $email . "' AND direction='" . $direction . "'
            OR `from`='" . $email . "' AND `to`='" . $seller . "' AND direction<>'" . $direction . "'");
            $chat_num = $chat_rs->num_rows;

            for ($x = 0; $x < $chat_num; $x++) {
                $chat_data = $chat_rs->fetch_assoc();

                $date_time = $chat_data["time"];
                $time = (explode(" ", $date_time))[1];
                $hours = (explode("-", $time))[0];
                if ($hours > 11) {
                    $time_status = " PM";
                } else {
                    $time_status = " AM";
                }

                if ($chat_data["direction"] == "2") {
            ?>
                    <!-- Receive -->
                    <div class="d-flex w-100 justify-content-start">
                        <div class="rounded bg-white px-2 py-1" style="width: 70%;">
                            <span class="fw-bold"><?php echo ($chat_data["content"]); ?></span>
                            <span class="w-100 text-end d-block text-black-50 fw-bold"><?php echo ($time . " " . $time_status); ?></span>
                        </div>
                    </div>
                    <!-- Receive -->
                <?php
                } else {
                ?>
                    <!-- Send -->
                    <div class="d-flex w-100 justify-content-end">
                        <div class="rounded bg-white px-2 py-1" style="width: 70%;">
                            <span class="fw-bold"><?php echo ($chat_data["content"]); ?></span>
                            <span class="w-100 text-end d-block text-black-50 fw-bold"><?php echo ($time . " " . $time_status); ?></span>
                        </div>
                    </div>
                    <!-- Send -->
                <?php
                }

                ?>

            <?php
            }

            ?>

        </div>
        <!-- Message View Area -->


        <div class="height-80 w-100 border-top border-secondary d-flex justify-content-center align-items-center">
            <div class="bg-white d-flex align-items-center ps-3 pe-1 justify-content-between gap-2" style="width: 95%; height: 80%; border-radius: 100vh;">
                <input type="text" class="border-0" placeholder="Message..." id="modalTxt" />
                <i class="icon-message-svgrepo-com fs-3 d-flex justify-content-center align-items-center" style="height: 90%; width: 70px; border-radius: 100vh;" onclick="sendByMsgModal('<?php echo ($seller); ?>');"></i>
            </div>
        </div>
    </div>


<?php

}
