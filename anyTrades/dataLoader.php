<?php

// $sriLanka = new mysqli("localhost", "root", "Vheshan37@37", "sri_lanka", "3306");
// $anytrades = new mysqli("localhost", "root", "Vheshan37@37", "anytrades", "3306");

// $q = "SELECT * FROM `city` LIMIT 1000 OFFSET 1000";
// $rs = $sriLanka->query($q);

// $num = $rs->num_rows;

// for ($x = 0; $x < $num; $x++) {
//     $data = $rs->fetch_assoc();
//     echo ($data["cname"]);
//     echo ("<br>");

//     $insert = "INSERT INTO `city` (`name`,`district_id`) VALUES ('" . $data["cname"] . "','" . $data["did"] . "')";
//     $anytrades->query($insert);
// }



// $q = "SELECT * FROM `district` LIMIT 1000";
// $rs = $sriLanka->query($q);
// $num = $rs->num_rows;

// for ($x = 0; $x < $num; $x++) {
//     $data = $rs->fetch_assoc();
//     echo ($data["dname"]);
//     echo ("<br>");

//     $insert = "INSERT INTO `district`(`name`) VALUES('" . $data["dname"] . "')";
//     $anytrades->query($insert);
// }

// unset($_SESSION["seller"]);
