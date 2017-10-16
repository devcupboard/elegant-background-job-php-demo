<?php

use Bernard\Router\ClassNameRouter;
use Bernard\Consumer;
use Bernard\Queue\RoundRobinQueue;
use Bernard\Message;
use Symfony\Component\EventDispatcher\EventDispatcher;

require __DIR__ . '/../vendor/autoload.php';

/** @var Psr\Container\ContainerInterface */
$container = require __DIR__. '/../container.php';

$queueFactory = require __DIR__. '/../queueFactory.php';

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
  
$router = new ClassNameRouter();
$router->add(Message::class, function(Message $message) use ($handlers, $container) {
    $handlerClass = $handlers[$message->getName()];
    $handler = $container->get($handlerClass);
    $handler($message);
});

$queues = array_map(
    function ($queueName) use ($queueFactory) {
      return $queueFactory->create($queueName);
    },
    $queues
);

$eventDispatcher = new EventDispatcher();


$eventDispatcher->addListener(
    Bernard\BernardEvents::INVOKE,
    function(Bernard\Event\EnvelopeEvent $envelopeEvent) {
        echo PHP_EOL . 'Processing: ' . $envelopeEvent->getEnvelope()->getClass();
    }
);

$eventDispatcher->addListener(
    Bernard\BernardEvents::ACKNOWLEDGE,
    function(Bernard\Event\EnvelopeEvent $envelopeEvent) {
        echo PHP_EOL . 'Processed: ' . $envelopeEvent->getEnvelope()->getClass();
    }
);

$eventDispatcher->addListener(
    Bernard\BernardEvents::REJECT,
    function(Bernard\Event\RejectEnvelopeEvent $envelopeEvent) {
        echo PHP_EOL . 'Failed: ' . $envelopeEvent->getEnvelope()->getClass();
        // you can also log error messages here
    }
);

// Create a Consumer and start the loop.
$consumer = new Consumer($router, $eventDispatcher);
$consumer->consume(new RoundRobinQueue($queues));
