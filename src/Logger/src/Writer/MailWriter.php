<?php


namespace rollun\logger\Writer;


use rollun\dic\InsideConstruct;
use Traversable;
use Zend\Cache\Storage\StorageInterface;
use Zend\Log\Writer\AbstractWriter;
use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

/**
 * Class MailWriter
 * @package rollun\logger\Writer
 */
class MailWriter extends AbstractWriter
{
    /**
     * @var string[]
     */
    protected $emails;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $fromMail;


    /**
     * MailWriter constructor.
     * @param $options
     * @param null $emails
     * @param null $name
     * @param null $fromMail
     */
    public function __construct($options, $emails = null, $name= null, $fromMail = null)
    {
        if ($options instanceof Traversable) {
            $options = iterator_to_array($options);
        }
        if (is_array($options)) {
            parent::__construct($options);
            $emails = $options["emails"];
            $name = $options["name"];
            $fromMail = $options["fromMail"];
        }
        $this->emails = $emails;
        $this->name = $name;
        $this->fromMail = $fromMail;
    }

    /**
     * Write a message to the log
     *
     * @param array $event log data event
     * @return void
     */
    protected function doWrite(array $event)
    {
        $mail = new Mail\Message();
        $parts = [];

        $message = $event["message"];
        $textPart = new MimePart($message);
        $textPart->type = "text/plain";
        $parts[] = $textPart;

        if(isset($event["context"]["html"])) {
            $htmlPart = new MimePart($event["context"]["html"]);
            $htmlPart->type = "text/html";
            $parts[] = $htmlPart;
        }

        $images = $event["context"]["png"] ?? [];
        foreach ($images as $image) {
            $imagePart = new MimePart(base64_decode($image));
            $imagePart->type = "image/png";
            $parts[] = $imagePart;
        }

        $body = new MimeMessage();
        $body->setParts($parts);
        $mail->setBody($body);

        $subject= $event["context"]["subject"];

        $mail->setFrom($this->fromMail, $this->name);
        $mail->setSubject($subject);
        foreach ($this->emails as $email) {
            $mail->addTo($email);
        }
        $transport = new Mail\Transport\Smtp();
        $options = new Mail\Transport\SmtpOptions([
            'name' => 'aspmx.l.google.com',
            'host' => 'aspmx.l.google.com',
            'port' => 25,
        ]);
        $transport->setOptions($options);
        $transport->send($mail);
    }
}