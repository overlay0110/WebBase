<?php
    require 'phpmailer/PHPMailerAutoload.php';
    class SendMail
    {
        private $mail;

        function __construct() // 생성자
        {
            $mail_info = $email_arr[0];

            $this->mail = new PHPMailer;            
            //$this->mail->SMTPSecure = 'ssl'; // tls , ssl
            $this->mail->CharSet = "utf-8"; //언어셋 설정
            $this->mail->isSMTP();
            $this->mail->SMTPDebug = 0; // 0 : 디버깅 안보기 1~2 : 디버깅 보기
            $this->mail->Debugoutput = 'html';
            $this->mail->Host = gethostname(); // smtp 메일서버
            $this->mail->SMTPAuth = true;
        }

        function send($email="", $subject="title", $heml="Hello Email", $info=array(), $debug = 0){
            $this->mail->addAddress($email);
            $this->mail->Subject = $subject;
            $this->mail->isHTML(true);
            $this->mail->SMTPDebug = $debug;

            $this->mail->MsgHTML($heml);

            if(count($info) != 0){
                $this->mail->Username = $info[0]; 
                $this->mail->Password = $info[1]; 
                $this->mail->setFrom($info[0], 'USER');
                $this->mail->FromName = "USER";
            }

            if (!$this->mail->send()) {
                $msg = "ID : ".$this->mail->Username." Mailer Error: " . $this->mail->ErrorInfo;
                return array("msg"=>$msg, "send_email"=>$this->mail->Username);
            } else {
                return array("msg"=>"success", "send_email"=>$this->mail->Username);
            }
        }

    }

?>
