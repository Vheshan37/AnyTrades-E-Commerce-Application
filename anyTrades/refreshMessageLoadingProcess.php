<?php

session_start();
require "connection.php";

$from = $_GET["from"];
$to = $_SESSION["at_u"]["email"];
$direction = $_GET["direction"];

$chat_rs = Database::search("SELECT * FROM `chat` WHERE `from`='" . $from . "' AND `to`='" . $to . "' AND `direction`='" . $direction . "' OR `from`='" . $to . "' AND `to`='" . $from . "' AND `direction`<>'" . $direction . "' ORDER BY `time` ASC");
$chat_num = $chat_rs->num_rows;

if ($chat_num > 0) {

    $user_rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $from . "'");
    $user_data = $user_rs->fetch_assoc();


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