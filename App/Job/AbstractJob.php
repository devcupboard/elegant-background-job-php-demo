<?php
namespace App\Job;

use Bernard\Message;

abstract class AbstractJob implements Message
{  
  public function getName()
  {
    return get_class($this);
  }
}
