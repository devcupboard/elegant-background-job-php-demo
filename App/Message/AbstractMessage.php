<?php
namespace App\Message;

use Bernard\Message;

abstract class AbstractMessage implements Message
{  
  public function getName()
  {
    return get_class($this);
  }
}
