<?php
namespace App\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ContactMailer {
  private $mailer;

  private $mailTo;

  public function __construct(MailerInterface $mailer, string $mailTo)
  {
    $this->mailer = $mailer;
    $this->mailTo =$mailTo;
  }

  public function sendContact(array $contactData)
  {
    $email = new Email();
    $email->from('hello@example.com')
      ->to($this->mailTo)
      ->replyTo($contactData['name'] . ' <' . $contactData['email'] . '>')
      ->subject('[AH-RESUME] Contact Form from  ' . $contactData['name'] . ' <' . $contactData['email'] . '>')
      ->text($contactData['message'])
      ->html('<pre>' . json_encode($contactData, JSON_PRETTY_PRINT) . '</pre>');

    return $this->mailer->send($email);
  }
}