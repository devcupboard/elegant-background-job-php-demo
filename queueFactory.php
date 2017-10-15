<?php
namespace App;

use Bernard\Normalizer\EnvelopeNormalizer;
use Bernard\Normalizer\PlainMessageNormalizer;
use Bernard\Serializer;
use Normalt\Normalizer\AggregateNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Bernard\Driver\PredisDriver;
use Predis\Client;

$predis = new Client('tcp://localhost', array(
    'prefix' => 'bernard:',
));
$driver = new PredisDriver($predis);

return new PersistentFactory(
    $driver,
    new Serializer(
        new AggregateNormalizer([
            new EnvelopeNormalizer(),
            new ObjectNormalizer(),
        ])

    )
);
