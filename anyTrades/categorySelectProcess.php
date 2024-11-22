<?php

session_start();


if (isset($_GET["c"])) {

    $category = $_GET["c"];

    if ($category == "0") {

        echo ("Please select a Category");
        
    } else {

        $_SESSION["category"] = $category;

        echo ("1");
    }
} else {
    echo ("Something went wrong? Please try again later");
}
