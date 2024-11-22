<?php

require "connection.php";
$txt = $_GET["txt"];

if (empty($txt) && $txt == null) {
    echo ('1');
} else {

?>

    <div class="col-12 overflow-auto">
        <table class="table table-bordered table-dark border-success table-hover">
            <thead>
                <tr>
                    <th rowspan="2">#</th>
                    <th colspan="2">Product</th>
                    <th rowspan="2">Customer</th>
                    <th rowspan="2">Date & Time</th>
                    <th rowspan="2">Price</th>
                    <th rowspan="2">Status</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>

                <?php

                if (isset($_GET["page_no"])) {
                    $page_no = $_GET["page_no"];
                } else {
                    $page_no = 1;
                }

                $invoice_rs = Database::search("SELECT *,`invoice`.`date_time` AS `invoice_time`,`order_status`.`status` AS `invoice_status`,`invoice`.`id` AS `invoice_id` FROM `invoice` INNER JOIN `product` ON `invoice`.`product_id`=`product`.`id` INNER JOIN `order_status` ON `order_status`.`id`=`invoice`.`order_status_id` INNER JOIN `user` ON `user`.`email`=`invoice`.`user_email` WHERE invoice.order_id LIKE '%" . $txt . "%' AND invoice.status<>2 OR invoice.order_status_id<>5");
                $invoice_num = $invoice_rs->num_rows;

                if ($invoice_num > 0) {
                    for ($x = 0; $x < $invoice_num; $x++) {
                        $invoice_data = $invoice_rs->fetch_assoc();
                ?>
                        <tr>
                            <td><?php echo ($invoice_data["order_id"]); ?></td>
                            <td>ATP_<?php echo ($invoice_data["product_id"]); ?></td>
                            <td style="min-width: 180px;"><?php echo ($invoice_data["title"]); ?></td>
                            <td style="min-width: 180px;"><?php echo ($invoice_data["fname"] . " " . $invoice_data["lname"]); ?></td>
                            <td style="min-width: 180px;"><?php
                                                            echo ((explode(" ", $invoice_data["invoice_time"]))[0]);
                                                            echo (" ");
                                                            echo ((explode(":", (explode(" ", $invoice_data["invoice_time"]))[1]))[0]);
                                                            echo (":");
                                                            echo ((explode(":", (explode(" ", $invoice_data["invoice_time"]))[1]))[1]);
                                                            echo (" ");
                                                            if ((explode(":", (explode(" ", $invoice_data["invoice_time"]))[1]))[0] > 11) {
                                                                echo ("PM");
                                                            } else {
                                                                echo ("AM");
                                                            }
                                                            ?></td>
                            <td>Rs. <?php echo ($invoice_data["total"]); ?>.00</td>
                            <td class="<?php
                                        if ($invoice_data["order_status_id"] == "1") {
                                            echo ("text-white");
                                        } else if ($invoice_data["order_status_id"] == "2") {
                                            echo ("text-info");
                                        } else if ($invoice_data["order_status_id"] == "3") {
                                            echo ("text-warning");
                                        } else if ($invoice_data["order_status_id"] == "4") {
                                            echo ("text-danger");
                                        } else if ($invoice_data["order_status_id"] == "5") {
                                            echo ("text-primary");
                                        }
                                        ?>"><?php echo ($invoice_data["invoice_status"]); ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="icon-arrow_circle_up_black_24dp text-success fs-3 c-pointer" onclick="changeOrderStatus(1,'<?php echo ($invoice_data['invoice_id']); ?>');"></i>
                                    <i class="icon-arrow_circle_down_black_24dp text-warning fs-3 c-pointer" onclick="changeOrderStatus(2,'<?php echo ($invoice_data['invoice_id']); ?>');"></i>
                                    <i class="icon-delete_forever_black_24dp text-danger fs-3 c-pointer" onclick="orderDeleteViewer('<?php echo ($invoice_data['invoice_id']); ?>');"></i>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>

                    <tr>
                        <td colspan="8">
                            <div class="text-center text-danger fs-3 fw-bolder" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                                No items to view...
                            </div>
                        </td>
                    </tr>

                <?php
                }

                ?>
            </tbody>
        </table>
    </div>

<?php

}

?>