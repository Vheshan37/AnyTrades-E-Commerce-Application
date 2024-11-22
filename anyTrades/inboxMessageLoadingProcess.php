<?php

session_start();
require "connection.php";


$from = $_GET["e"];
$to = $_SESSION["at_u"]["email"];
$direction = $_GET["direction"];

$chat_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $from . "' AND `to`='" . $to . "' AND `direction`='" . $direction . "' OR `from`='" . $to . "' AND `to`='" . $from . "' AND `direction`<>'" . $direction . "' ORDER BY `time` ASC");
$chat_num = $chat_rs->num_rows;

Database::iud("UPDATE `chat` SET `status`='1' WHERE `from`='" . $from . "' AND `to`='" . $to . "' AND `direction`='" . $direction . "' OR `from`='" . $to . "' AND `to`='" . $from . "' AND `direction`<>'" . $direction . "' AND `status`='0'");

if ($chat_num > 0) {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $from . "'");
    $user_data = $user_rs->fetch_assoc();

    $image_rs = Database::search("SELECT * FROM `profile_image` WHERE `user_email`='" . $from . "'");
    $image_data = $image_rs->fetch_assoc();

?>

    <!-- Inbox Head -->
    <div class="d-flex align-items-center gap-3">
        <div class="width-60 height-60 rounded-circle shadow d-flex justify-content-center align-items-center p-0">
            <?php
            if (isset($image_data["p_img"])) {
            ?>
                <img src="<?php echo ($image_data["p_img"]); ?>" alt="" class="" style="height: 100%; object-position: center; clip-path: circle();" />
            <?php
            } else {
            ?>
                <img src="resources/new_user.svg" alt="" class="" style="height: 100%; object-position: center; clip-path: circle();" />
            <?php
            }
            ?>
        </div>
        <span class="fw-bold text-black-50 fs-5"><?php echo ($user_data["fname"] . " " . $user_data["lname"]); ?></span>
    </div>
    <div class="col-12">
        <hr class="my-2">
    </div>
    <!-- Inbox Head -->



    <!-- Message Inbox -->
    <div class="py-2" style="height: 90%; overflow-y: scroll; overflow-x: hidden;" id="msg_box">

        <?php

        for ($c = 0; $c < $chat_num; $c++) {
            $chat_data = $chat_rs->fetch_assoc();

            $date_time = $chat_data["time"];
            $date = (explode(" ", $date_time))[0];
            $time = (explode(" ", $date_time))[1];
            $hours = (explode(":", $time))[0];
            $minutes = (explode(":", $time))[1];

            if ($chat_data["from"] == $from) {
        ?>
                <!-- Recieve msg -->
                <div class="d-flex justify-content-start ps-4">
                    <div class="w-75 px-2 r-msg my-2" style="max-width: 700px; background-color: #e8e8e8;">
                        <span class="w-100 text-break"><?php echo ($chat_data["content"]); ?></span>
                        <span class="w-100 text-end d-block text-black-50 fw-bold mt-1">
                            <?php
                            echo ($date . " ");
                            echo ($hours . ":" . $minutes);
                            if ($hours > 11) {
                                echo (" PM");
                            } else {
                                echo (" AM");
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <!-- Recieve msg -->
            <?php
            } else {
            ?>
                <!-- Send msg -->
                <div class="d-flex justify-content-end px-4">
                    <div class="w-75 px-2 s-msg my-2" style="max-width: 700px; background-color: #e8e8e8;">
                        <span class="w-100 text-break"><?php echo ($chat_data["content"]); ?></span>
                        <span class="w-100 text-end d-block text-black-50 fw-bold mt-1">
                            <?php
                            echo ($date . " ");
                            echo ($hours . ":" . $minutes);
                            if ($hours > 11) {
                                echo (" PM");
                            } else {
                                echo (" AM");
                            }
                            ?>
                        </span>
                    </div>
                </div>
                <!-- Send msg -->
        <?php
            }
        }

        ?>

    </div>
    <!-- Message Inbox -->
    <hr class="my-1">
    <div class="d-flex justify-content-center align-items-center" style="height: 10%;">
        <div class="w-100 border border-1 border-secondary d-flex overflow-hidden ps-2 align-items-center" style="height: 50px; border-radius: 100vh;">
            <input type="text" name="" class="border-0 h-100 w-100 bg-transparent" style="width: 90%; outline: none;" placeholder="Message..." id="sendMessageText" />
            <i class="icon-message-svgrepo-com d-flex justify-content-center align-items-center fs-2 msg-send-btn h-100 c-pointer" style="width: 10%;" onclick="sendMessage('<?php echo ($from); ?>');"></i>
        </div>
    </div>




<?php

} else {
?>

    <!-- Empty View -->
    <div class="w-100 h-100 d-flex justify-content-center align-items-center flex-column">
        <span class="fw-bold fs-3 text-white">No Message to View</span>
        <i class="icon-message-svgrepo-com text-white" style="font-size: 72px;"></i>
    </div>
    <!-- Empty View -->

<?php
}

?>