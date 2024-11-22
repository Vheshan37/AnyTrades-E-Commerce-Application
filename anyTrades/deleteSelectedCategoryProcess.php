<?php

session_start();
if (isset($_SESSION["category"])) {
    unset($_SESSION["category"]);
    echo ("1");
} else {
    echo ("Something went Wrong? Please try again later");
}
