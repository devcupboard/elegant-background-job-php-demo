<?php
namespace App\Handler;

use App\Message\SendForgotPasswordEmail;
use App\Mailer;

class SendForgotPasswordEmailHandler
{
  private $mailer;
  
  public function __construct(Mailer $mailer)
  {
    $this->mailer = $mailer;
  }
  
  public function __invoke(SendForgotPasswordEmail $message)
  {
    $this->mailer->sendMail($message->getUser()->getEmail(), 'subject', 'contents');
  }
}
