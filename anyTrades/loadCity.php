<?php

require "connection.php";

$id = $_GET["did"];

$rs = Database::search("SELECT * FROM `city` WHERE `district_id`='" . $id . "'");
$num = $rs->num_rows;

for ($x = 0; $x < $num; $x++) {
    $data = $rs->fetch_assoc();
?>
    <option value="<?php echo ($data["id"]); ?>"><?php echo ($data["name"]); ?></option>
<?php
}