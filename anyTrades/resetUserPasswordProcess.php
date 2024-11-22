<?php

require "connection.php";

$userTable = Database::search("SELECT * FROM user WHERE CAST(email AS BINARY)='" . $_POST["email"] . "' AND CAST(verification_code AS BINARY)='" . $_POST["otp"] . "'");
if ($userTable->num_rows > 0) {
    $userData = $userTable->fetch_assoc();
    Database::iud("UPDATE `user` SET `verification_code`=(NULL),password='" . $_POST["password"] . "' WHERE CAST(email AS BINARY)='" . $_POST["email"] . "' AND CAST(verification_code AS BINARY)='" . $_POST["otp"] . "'");
    echo ("2"); // Update completed
} else {
    echo ("1"); // Invalid input details
}
