<?php

use Bernard\Driver\PredisDriver;
use Bernard\Normalizer\EnvelopeNormalizer;
use Bernard\QueueFactory\PersistentFactory;
use Bernard\Serializer;
use Normalt\Normalizer\AggregateNormalizer;
use Predis\Client;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

$predis = new Client('tcp://localhost', array(
    'prefix' => 'bernard:',
));
$driver = new PredisDriver($predis);

return new PersistentFactory(
    $driver,
    new Serializer(
        new AggregateNormalizer([
            new EnvelopeNormalizer(),
            new Symfony\Component\Serializer\Serializer(
                [new ObjectNormalizer()],
                [new JsonEncoder()]
            ),
        ])

    )
);
