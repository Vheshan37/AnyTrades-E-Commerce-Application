<?php

require "connection.php";
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

$json_txt = $_POST["json"];
$phpObj = json_decode($json_txt);
$email = $phpObj->eml;
$password = $phpObj->psw;

if (empty($email) && empty($password)) {
    echo ("1");
} else if (empty($email)) {
    // Empty Email
    echo ("2");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid Email
    echo ("3");
} else if (empty($password)) {
    // Empty Password
    echo ("4");
} else if (strlen($password) < 8 || strlen($password) > 20) {
    // Invalid lenght
    echo ("5");
} else {
    $rs = Database::search("SELECT * FROM `admin` WHERE `email`='" . $email . "' AND `password`='" . $password . "'");
    $num = $rs->num_rows;

    if ($num == 1) {
        $data = $rs->fetch_assoc();
        $_SESSION["at_admin"] = $data;

        $code = "ATA_" . rand(111111, 999999);

        Database::iud("UPDATE `admin` SET `verification_code`='" . $code . "' WHERE `email`='" . $email . "' AND `password`='" . $password . "'");

        $mail = new PHPMailer;
        try {
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vihangaheshan37@gmail.com';
            $mail->Password = 'vxrgrywfcqlrbshg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->setFrom('vihangaheshan37@gmail.com', 'Admin Verification');
            $mail->addReplyTo('vihangaheshan37@gmail.com', 'Admin Verification');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'AnyTrades Admin Login verification Code';
            $bodyContent = '<h1>Your Verification Code is:</h1>
                <h4 style="text-decoration: underline;">' . $code . '</h4>
                <span>Once you use the verification code it will be expired.</span>';
            $mail->Body    = $bodyContent;

            $mail->send();
            echo "6";
        } catch (Exception $e) {
            echo "8";
        }
    } else {
        // Login Failed
        echo ("7");
    }
}

// email app password 
// vxrgrywfcqlrbshg
