<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';


function sendMail($subject, $message, $receiver_email, $receiver_name)
{
    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'your SMTP server here';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'your-username-here';                     // SMTP username
        $mail->Password   = 'your-password-here';                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('put here an valid email.', 'Online Certificate-System');

        $mail->addAddress($receiver_email, '');     // Add a recipient


        $body = "<p><strong>Hello $receiver_name,</strong><br>$message</p><br>Thank You";


        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body);

        if ($mail->send()) {
            echo 'Message has been sent';
            return true;
        }
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
