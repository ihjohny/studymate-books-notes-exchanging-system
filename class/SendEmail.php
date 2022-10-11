<?php
require 'class/class.phpmailer.php';

class SendEmail
{

    private $mail;

	public function __construct()
	{
        $this->mail = new PHPMailer;
        $this->mail->IsSMTP();
        $this->mail->Host = 'smtp.gmail.com';
        $this->mail->Port = '587';
        $this->mail->SMTPAuth = true;
        $this->mail->Username = 'nstustudymate@gmail.com';
        $this->mail->Password = 'qjxaeiscemnqsbob';
        $this->mail->SMTPSecure = 'tls';
        $this->mail->From = 'nstustudymate@gmail.com';
        $this->mail->FromName = 'Studymate';
        $this->mail->WordWrap = 50;
        $this->mail->IsHTML(true);
	}

	function send($addresses, $subject, $body)
	{
        foreach($addresses as $addr) {
            $this->mail->AddAddress($addr);
        }
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        
        return $this->mail->Send();        
	}

}
