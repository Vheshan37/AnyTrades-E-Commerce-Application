<?php

session_start();
require "connection.php";
$_SESSION["u_type"] = "buyer";
$email = $_SESSION["at_u"]["email"];
Database::iud("UPDATE `user` SET `user_type_id`='1' WHERE `email`='" . $email . "'");
unset($_SESSION["seller"]);
echo ("1");
