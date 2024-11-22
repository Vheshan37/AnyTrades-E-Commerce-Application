<?php

require "connection.php";
$ctgr = $_GET["ctgr"];

$brand_rs = Database::search("SELECT * FROM `brand` WHERE `category_id`='" . $ctgr . "'");
$brand_num = $brand_rs->num_rows;

?>
<option value="0">Select Brand</option>
<?php

for ($x = 0; $x < $brand_num; $x++) {
    $brand_data = $brand_rs->fetch_assoc();
?>
    <option value="<?php echo ($brand_data["id"]); ?>"><?php echo ($brand_data["name"]); ?></option>
<?php
}
