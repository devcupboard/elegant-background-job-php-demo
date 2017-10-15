<?php
namespace App\Handler;

use App\Job\SendForgotPassword;
use App\Mailer;

class SendForgotPasswordEmailHandler
{
  private $mailer;
  
  public function __construct(Mailer $mailer)
  {
    $this->mailer = $mailer;
  }
  
  public function __invoke(SendForgotPassword $message)
  {
    $mailer->sendMail($message->getUser()->getEmail(), 'subject', 'contents');
  }
}
