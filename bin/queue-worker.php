<?php

use Bernard\Router\SimpleRouter;
use Bernard\Consumer;
use Bernard\Queue\RoundRobinQueue;
use Bernard\Message;

/** @var Psr\Container\ContainerInterface */
$container = require '../container.php';

$queueFactory = require '../queueFactory.php');

$queues = [
    'default',
    'notifications',
    'emails'
];

$handlers = [
    App\Job\SendForgotPasswordEmail::class 
        => App\Handler\SendForgotPasswordEmailHandler::class,
    App\Job\SendImportantEmail::class 
        => App\Handler\SendImportantEmailHandler::class,
];
  
$router = new SimpleRouter();
$router->add(Message::class, function(Message $message) use ($handlers, $container) {
    $handlerClass = $handlers[$message->getName()];
    $handler = $container->get($handlerClass);
    $handler($message);
});

$queues = array_map(
    function ($queueName) {
      return $queueFactory->create($queueName);
    },
    $queues
  );

// Create a Consumer and start the loop.
$consumer = new Consumer($router, $eventDispatcher);
$consumer->consume(new RoundRobinQueue($queues));
