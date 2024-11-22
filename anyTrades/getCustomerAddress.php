<?php

require "connection.php";
$email = $_GET["email"];

$addressTAble = Database::search("SELECT *,CONCAT(`line1`,', ', `line2`,', ', `line3`,'. (', `province`.`name`,' - ', `district`.`name`,' - ', `city`.`name`,')') AS `address` 
                            FROM `user_has_address`
                            INNER JOIN `city` ON `city`.`id`=`user_has_address`.`city_id`
                            INNER JOIN `district` ON `district`.`id`=`city`.`district_id`
                            INNER JOIN `province` ON `province`.`id`=`district`.`province_id`
                            WHERE `user_has_address`.`user_email`='" . $email . "'");

$addressData = $addressTAble->fetch_assoc();
echo ($addressData["address"]);
