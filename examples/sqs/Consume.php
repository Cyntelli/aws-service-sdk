<?php

require __DIR__ . '/../../vendor/autoload.php';

use Cyntelli\Aws\Sqs;

$service = new Sqs('REGION', 'ACCESS_ID', 'ACCESS_SECRET');

$result = $service->consume(function ($message) {
    // get message content
    print_r($message->content);

    // ack message
    $message->ack();
}, 'QUEUE_URL');

var_dump($result);
