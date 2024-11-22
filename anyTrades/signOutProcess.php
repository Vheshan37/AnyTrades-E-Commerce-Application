<?php

session_start();
if (isset($_SESSION["at_u"])) {
    unset($_SESSION["at_u"]);
    unset($_SESSION["seller"]);
    echo ("1");
} else {
    echo ("Something went wrong?");
}
