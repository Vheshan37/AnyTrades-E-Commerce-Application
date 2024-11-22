<?php

require "connection.php";

if (isset($_GET["id"])) {

    $pid = $_GET["id"];

    $seller_rs = Database::search("SELECT * FROM `seller` INNER JOIN `product` ON `seller`.`nic`=`product`.`seller_nic` WHERE `id`='" . $pid . "'");
    if ($seller_rs->num_rows == 1) {
        echo ("1");
    } else {
        echo ("2");
    }
} else {
    echo ("Something Went Wrong? Please Try Again Later");
}
