<?php

session_start();
require "connection.php";

if (isset($_SESSION["at_u"])) {
    $email = $_SESSION["at_u"]["email"];
    $type = $_GET["t"];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message | AnyTrades</title>
        <!-- Link to CSS -->
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="demo-files/demo.css" />
        <link rel="stylesheet" href="icomoon.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="icon" href="resources/AnyTrades logo.png" type="image">
    </head>

    <body class="min-vh-100" id="messagePage" onload="contactListRefresher('<?php echo ($type); ?>');">

    <?php require "alert.php"; ?>

        <div class="container-fluid">
            <div class="row">

                <?php include "header.php"; ?>

                <div class="col-12 mb-2">
                    <div class="row">

                        <div class="col-12 col-xl-4 col-lg-5 border border-1">
                            <div class="row p-1">

                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <i class="icon-chevron-left fs-2 c-pointer fw-bold"></i>
                                        <input type="text" style="width: 60%; border: 1px solid gray; outline: none; border-radius: 100vh;" class="p-2" placeholder="Search Contact..." />
                                    </div>
                                </div>

                                <hr class="my-1">

                                <!-- Message Contact List -->
                                <div class="col-12 my-1" style="min-height: 80vh;">
                                    <div class="row" style="max-height: 80vh; overflow-y: scroll;" id="contact_list">

                                        <?php
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


                                    </div>
                                </div>
                                <!-- Message Contact List -->

                            </div>
                        </div>



                        <!-- Inbox Side-->
                        <div class="col-12 col-xl-8 col-lg-7 d-lg-block border border-1 d-none" id="inboxPanel" style="min-height: 80vh;">
                            <div class="row h-100 position-relative pt-3" style="max-height: 80vh;">

                                <div class="position-absolute top-0 w-100 d-flex my-2 justify-content-end d-block d-lg-none">
                                    <span class="fw-bold fs-3 mt-2 mb-2 c-pointer d-flex align-items-center gap-2" onclick="inboxLoader();"> <i class="icon-logout-svgrepo-com fs-1 fw-bold"></i> Exit</span>
                                </div>

                                <div class="d-flex flex-column justify-content-between h-100" id="message_box">


                                    <div class="w-100 h-100 d-flex justify-content-center align-items-center flex-column">
                                        <span class="fw-bold fs-3 text-white">Select a contact to view messages</span>
                                        <i class="icon-message-svgrepo-com text-white" style="font-size: 72px;"></i>
                                    </div>


                                </div>

                            </div>
                        </div>
                        <!-- Inbox Side-->


                    </div>
                </div>


            </div>
        </div>

        <?php include "footer.php"; ?>
        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {
    header("Location:index.php");
}

?>