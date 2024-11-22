<?php

require "connection.php";
$brand = $_GET["brand"];

$model_rs = Database::search("SELECT *,`model`.`id` AS `mid` FROM `model` INNER JOIN `brand_has_model` ON `brand_has_model`.`model_id`=`model`.`id` WHERE `brand_id`='" . $brand . "'");
$model_num = $model_rs->num_rows;

?>
<option value="0">Select Model</option>
<?php

for ($x = 0; $x < $model_num; $x++) {
    $model_data = $model_rs->fetch_assoc();
?>
    <option value="<?php echo ($model_data["mid"]); ?>"><?php echo ($model_data["model"]); ?></option>
<?php
}
