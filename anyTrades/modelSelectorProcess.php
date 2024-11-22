<?php

require "connection.php";

$rs = Database::search("SELECT `model`.`id` AS `model_id`,`model`.`model` FROM `model` INNER JOIN `brand_has_model` ON `brand_has_model`.`model_id`=`model`.`id` WHERE `brand_id`='" . $_GET["id"] . "'");
$num = $rs->num_rows;

if ($num > 0) {

    for ($x = 0; $x < $num; $x++) {
        $data = $rs->fetch_assoc();

?>
        <option value="<?php echo ($data["model_id"]); ?>"><?php echo ($data["model"]); ?></option>
    <?php

    }
} else {
    ?>
    <option value="0">Models not added yet</option>
<?php
}
