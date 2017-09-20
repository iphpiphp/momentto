<?php
// Mailgun (2017.01.20 BrianPark)
use Mailgun\Mailgun;

class MY_Email extends CI_Email
{
    private $mailgunClient;
    private $mailgunDomain;

    public function __construct($config = array())
    {
        parent::__construct($config);

        $this->mailgunClient = new Mailgun("key-3b327118da8bba1328259cf83fe9f8b3");
        $this->mailgunDomain = "withvideo.com";

		//var_dump($this->mailgunClient );
    }

    /**
     * Send Mail
     * Mailgun을 사용해 메일을 날리는 기능
     */

    public function sendMailgun($to = null, $subject = null, $contents = null, $from = 'admin@withvideo.com')
    {
        if ($to != null && $subject != null && $contents != null) {
            $this->mailgunClient->sendMessage(
                $this->mailgunDomain,
                array(
                    'from' => $from,
                    'to' => $to,
                    'subject' => $subject,
                    'text' => $contents)
            );
        } else {
            return false;
        }
    }
}
