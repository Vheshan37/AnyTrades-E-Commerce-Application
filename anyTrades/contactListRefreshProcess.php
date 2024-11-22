<?php

session_start();
require "connection.php";
$email = $_SESSION["at_u"]["email"];
$type = $_GET["direction"];

$chat_list_rs = Database::search("SELECT DISTINCT(`from`) FROM `chat` WHERE `to`='" . $email . "' AND `direction`='" . $type . "'");
$chat_list_num = $chat_list_rs->num_rows;

if ($chat_list_num > 0) {

    for ($x = 0; $x < $chat_list_num; $x++) {
        $chat_list_data = $chat_list_rs->fetch_assoc();

        $img_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $chat_list_data["from"] . "'");
        $img_data = $img_rs->fetch_assoc();

        $search_result = Database::search("SELECT MAX(id) AS `id` FROM `chat` WHERE `from`='" . $chat_list_data["from"] . "' AND `to`='" . $email . "' AND  `direction`='" . $type . "' OR `from`='" . $email . "' AND `to`='" . $chat_list_data["from"] . "' AND `direction`<>'" . $type . "' ORDER BY `time` DESC");
        $search_data = $search_result->fetch_assoc();

        $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $chat_list_data["from"] . "'");
        $user_data = $user_rs->fetch_assoc();

        $rs = Database::search("SELECT * FROM `chat` WHERE `id`='" . $search_data["id"] . "'");
        $data = $rs->fetch_assoc();
        $time_data = $data["time"];
        $content = $data["content"];

        $date_time = $time_data;
        $date = (explode(" ", $date_time))[0];
        $time = (explode(" ", $date_time))[1];
        $hours = (explode(":", $time))[0];
        $minute = (explode(":", $time))[1];

        $contact_unread_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $chat_list_data["from"] . "' AND `direction`='" . $type . "' AND `status`='0' AND `to`='" . $email . "'");
        $contact_unread_num = $contact_unread_rs->num_rows;

?>

        <!-- Single Contact -->
        <div class="col-12 my-1 p-0">
            <div class="d-flex gap-2 align-items-center msg-list p-1 c-pointer <?php
                                                                                if ($contact_unread_num > 0) {
                                                                                ?>
                                                                                                                        text-primary
                                                                                                                        <?php
                                                                                                                    } ?>" onclick="inboxLoader('<?php echo ($chat_list_data['from']) ?>');">


                <div class="width-60 height-60 rounded-circle shadow d-flex justify-content-center align-items-center p-0">
                    <?php
                    if (isset($img_data["p_img"])) {
                    ?>
                        <img src="<?php echo ($img_data["p_img"]); ?>" alt="" class="" style="height: 100%; object-position: center; clip-path: circle();" />
                    <?php
                    } else {
                    ?>
                        <img src="resources/new_user.svg" alt="" class="" style="height: 100%; object-position: center; clip-path: circle();" />
                    <?php
                    }
                    ?>
                </div>

                <div class="d-flex flex-column w-100 overflow-hidden">

                    <div class="w-100 flex-grow-1 d-flex justify-content-between fw-bold">
                        <span class="w-75 overflow-hidden nowrap"><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></span>
                        <span class="d-block">
                            <?php
                            echo ($hours . ":" . $minute);
                            if ($hours > 11) {
                                echo (" PM");
                            } else {
                                echo (" AM");
                            }
                            ?>
                        </span>
                    </div>
                    <hr class="m-0 p-0">
                    <div class="w-100 flex-grow-1 d-flex justify-content-between fw-bold">
                        <span class="overflow-hidden nowrap text-black-50" style="width: 95%;" title=""><?php echo ($content); ?></span>
                    </div>


                </div>

            </div>
        </div>
        <!-- Single Contact -->

        <div class="col-12 p-0">
            <hr class="my-2">
        </div>

    <?php
    }
} else {
    ?>

    <div class="w-100 d-flex justify-content-center align-items-center flex-column mt-5 text-black-50">
        <span class="fs-2 fw-bold l-space-1">No Contact to View</span>
        <i class="icon-customer-service-svgrepo-com-1" style="font-size: 72px;"></i>
    </div>

<?php
}
?>