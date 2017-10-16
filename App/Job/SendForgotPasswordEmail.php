<?php
namespace App\Message;

use App\User;

class SendForgotPasswordEmail extends AbstractMessage
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
