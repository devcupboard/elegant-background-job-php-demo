<?php
namespace App\Handler;

use App\Job\SendForgotPasswordEmail;
use App\Mailer;

class SendImportantEmailHandler
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
