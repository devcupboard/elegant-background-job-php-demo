<?php
/**
 * Returns a Psr\Container\ContainerInterface implementation
 *
 * For this, I am using `zendframework/zend-servicemanager`
 * But, you can use any PSR-11 Container compatible implementation
 */

use App\Handler\SendForgotPasswordEmailHandler;
use App\Handler\SendImportantEmailHandler;
use App\Mailer;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\ServiceManager;

$container = new ServiceManager;
$invokableFactory = new InvokableFactory();

$container->setFactory(
    Mailer::class,
    function() {
        return new Mailer();
    }
);

$container->setFactory(
    SendForgotPasswordEmailHandler::class,
    function() use ($container) {
        return new SendForgotPasswordEmailHandler(
            $container->get(Mailer::class)
        );
    }
);

$container->setFactory(
    SendImportantEmailHandler::class,
    function() use ($container) {
        return new SendImportantEmailHandler(
            $container->get(Mailer::class)
        );
    }
);

return $container;
