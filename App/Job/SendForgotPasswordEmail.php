<?php
namespace App\Job;

use App\User;

class SendForgotPasswordEmail extends AbstractJob
{
  private $user;
  
  public function __construct(User $user)
  {
    $this->user = $user;
  }
  
  public function getUser()
  {
    return $this->user;
  }  
}
