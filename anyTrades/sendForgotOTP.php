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

$email = $_POST["email"];

if (empty($email)) {
    // Empty Email
    echo ("1");
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Invalid Email
    echo ("2");
} else {
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "'");
    $num = $rs->num_rows;

    if ($num == 1) {
        $data = $rs->fetch_assoc();

        $code = "AT_" . rand(111111, 999999);

        Database::iud("UPDATE `user` SET `verification_code`='" . $code . "' WHERE `email`='" . $email . "'");

        $mail = new PHPMailer;
        try {
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'vihangaheshan37@gmail.com';
            $mail->Password = 'vxrgrywfcqlrbshg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->setFrom('vihangaheshan37@gmail.com', 'Forgot Password OTP Code');
            $mail->addReplyTo('vihangaheshan37@gmail.com', 'Forgot Password OTP Code');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'AnyTrades Forgot Password OTP Code';
            $bodyContent = '<h1>Your Verification Code is:</h1>
                <h4 style="text-decoration: underline;">' . $code . '</h4>
                <span>Once you use the verification code it will be expired.</span>';
            $mail->Body    = $bodyContent;

            $mail->send();
            echo "4"; // Email is send
        } catch (Exception $e) {
            echo "5"; // Email is not send
        }
    } else {
        // Email is not registered bofore
        echo ("3");
    }
}
