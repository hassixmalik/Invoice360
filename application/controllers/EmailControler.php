<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
defined('BASEPATH') OR exit('No direct script access allowed');

class EmailControler extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');

        // Include PHPMailer classes
        require_once APPPATH . '../PHPMailer/src/Exception.php';
        require_once APPPATH . '../PHPMailer/src/PHPMailer.php';
        require_once APPPATH . '../PHPMailer/src/SMTP.php';
    }

    public function index() {
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = '';
            $mail->Password   = ''; // Your App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('cprogramer04@gmail.com', 'NMR');
            $mail->addAddress('hassi.x.malik@gmail.com');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'This is the template subject';
            $mail->Body    = 'This is the template message';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
