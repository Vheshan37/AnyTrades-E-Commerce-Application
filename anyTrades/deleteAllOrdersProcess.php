<?php

session_start();
require "connection.php";

Database::iud("UPDATE `invoice` SET `status`='3' WHERE `user_email`='" . $_SESSION["at_u"]["email"] . "'");
echo ("1");