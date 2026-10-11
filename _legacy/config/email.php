<?php
/**
 * Project: truepathexpress
 * Created by: mrwayne
 *
 * Email configuration using PHPMailer
 */

require_once __DIR__ . '/constants.php';
require_once APP_ROOT . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mailer {
    private $host;
    private $port;
    private $username;
    private $password;
    private $fromEmail;
    private $fromName;

    public function __construct() {
        $this->host = getenv('SMTP_HOST') ?: 'mail.spacemail.com';
        $this->port = (int)(getenv('SMTP_PORT') ?: 465);
        $this->username = getenv('SMTP_USER') ?: '';
        $this->password = getenv('SMTP_PASS') ?: '';
        $this->fromEmail = getenv('SMTP_FROM') ?: $this->username;
        $this->fromName = getenv('SMTP_FROM_NAME') ?: APP_NAME;
    }

    /**
     * Send an HTML email
     *
     * @param string $to      Recipient email
     * @param string $subject Email subject
     * @param string $body    HTML email body
     * @return bool
     */
    public function send($to, $subject, $body) {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $this->host;
            $mail->SMTPAuth = true;
            $mail->Username = $this->username;
            $mail->Password = $this->password;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $this->port;

            $mail->setFrom($this->fromEmail, $this->fromName);
            $mail->addAddress($to);

            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Mailer error: " . $mail->ErrorInfo);
            return false;
        }
    }
}
