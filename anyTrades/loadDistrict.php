<?php

require "connection.php";

$id = $_GET["pid"];

if ($id == 0) {
    $rs = Database::search("SELECT * FROM `district`");
    $num = $rs->num_rows;

    for ($x = 0; $x < $num; $x++) {
        $data = $rs->fetch_assoc();
?>
        <option value="<?php echo ($data["id"]); ?>"><?php echo ($data["name"]); ?></option>
    <?php
    }
} else {



    $rs = Database::search("SELECT * FROM `district` WHERE `province_id`='" . $id . "'");
    $num = $rs->num_rows;

    for ($x = 0; $x < $num; $x++) {
        $data = $rs->fetch_assoc();
    ?>
        <option value="<?php echo ($data["id"]); ?>"><?php echo ($data["name"]); ?></option>
<?php
    }
}
