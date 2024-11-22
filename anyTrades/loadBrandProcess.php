<?php

require "connection.php";

$id = $_GET["id"];

$rs = Database::search("SELECT * FROM `brand` WHERE `category_id`='" . $id . "'");
$num = $rs->num_rows;

if ($id == 0) {
?>
    <option value="0">Select Brand</option>
    <?php
} else {
    for ($x = 0; $x < $num; $x++) {
        $data = $rs->fetch_assoc();
    ?>
        <option value="<?php echo ($data["id"]); ?>"><?php echo ($data["name"]); ?></option>
<?php
    }
}
