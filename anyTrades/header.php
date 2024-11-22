<div class="col-12 py-1 bg-dark text-white">
    <?php
    if (isset($_SESSION["at_u"])) {
    ?>
        <span>Welcome <?php echo ($_SESSION["at_u"]["fname"]); ?></span>
    <?php
    } else {
    ?>
        <a href="index.php">Sign in or Register</a>
    <?php
    }
    ?>    
    <a class="text-end float-end text-white text-decoration-none" href="home.php">
        <span class="icon-home"></span>
        <span class="ms-1">AnyTrades</span>
    </a>
</div>