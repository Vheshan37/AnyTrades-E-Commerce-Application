<?php

require "connection.php";
session_start();

$income = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

$query = "SELECT *,MONTH(invoice.date_time) AS `month` FROM invoice
        INNER JOIN product ON product.id=invoice.product_id
        WHERE YEAR(invoice.date_time)='" . date("Y") . "' AND product.seller_nic='" . $_SESSION["seller"]["nic"] . "'
        ORDER BY `month` ASC";
// echo ($query);
$annualTable = Database::search($query);
for ($incomeIteration = 0; $incomeIteration < $annualTable->num_rows; $incomeIteration++) {
    $annualData = $annualTable->fetch_assoc();
    $annualMonth = $annualData["month"];
    $income[$annualMonth - 1] = $income[$annualMonth - 1] + $annualData["total"];
}

echo (json_encode($income));