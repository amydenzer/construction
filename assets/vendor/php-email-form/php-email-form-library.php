<?php

class PHP_Email_Form
{
    public $to = '';
    public $from_name = '';
    public $from_email = '';
    public $subject = '';
    public $ajax = false;
    public $smtp = array();

    private $messages = array();

    public function add_message($content, $label, $priority = 0)
    {
        $this->messages[] = array(
            'content' => $content,
            'label' => $label,
            'priority' => $priority
        );
    }

    public function send()
    {
        $email_text = '';
        foreach ($this->messages as $message) {
            $email_text .= $message['label'] . ": " . $message['content'] . "\n";
        }

        $headers = 'From: ' . $this->from_name . ' <' . $this->from_email . ">\r\n" .
                   'Reply-To: ' . $this->from_email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        if (!empty($this->smtp)) {
            return $this->send_smtp($email_text, $headers);
        } else {
            return mail($this->to, $this->subject, $email_text, $headers);
        }
    }

    private function send_smtp($email_text, $headers)
    {
        // SMTP mail sending logic here
        // This function needs to be implemented with a library like PHPMailer or similar for SMTP support
        return false; // Placeholder return for example purposes
    }
}

?>
