<?php

require "connection.php";
session_start();

$seller = $_GET["seller"];
$txt = $_GET["txt"];
$email = $_SESSION["at_u"]["email"];
$direction = "2";

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$time  = $d->format("Y-m-d H:i:s");

if (!empty($txt)) {
    Database::iud("INSERT INTO `chat`(`time`,`content`,`from`,`to`,`direction`) VALUES('" . $time . "','" . $txt . "','" . $email . "','" . $seller . "','1')");
}


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