<?php

require "connection.php";
session_start();

$rs = Database::search("SELECT * FROM user_has_address WHERE user_email='" . $_SESSION["at_u"]["email"] . "'");
if ($rs->num_rows > 0) {
    echo ("1");
} else {
    echo ("2");
}
