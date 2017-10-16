<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Job\SendForgotPasswordEmail;
use App\User;
use Bernard\Producer;
use Bernard\QueueFactory\PersistentFactory;
use Bernard\Serializer;
use Symfony\Component\EventDispatcher\EventDispatcher;

//.. create $driver
$queueFactory = require __DIR__ . '/../queueFactory.php';

$eventDispatcher = new EventDispatcher();
$producer = new Producer($queueFactory, $eventDispatcher);

$user = new User();
$user->setEmail('foo@bar.com');
$message = new SendForgotPasswordEmail($user);

$producer->produce($message, 'emails');
