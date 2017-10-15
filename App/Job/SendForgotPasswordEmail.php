<?php
namespace App\Jobs;

use App\Mail;

class SendForgotPasswordEmail extends AbstractJob
{
  private $user;
  
  public function __construct(User $user)
  {
    $this->user = $user;
  }
  
  public function getUser(): User
  {
    return $this->user;
  }  
}
