<?php

require __DIR__ . '/../../vendor/autoload.php';

use Cyntelli\Aws\Sqs;

$service = new Sqs('REGION', 'ACCESS_ID', 'ACCESS_SECRET');

$result = $service->publish('MESSAGE_CONTENT', 'QUEUE_URL');

var_dump($result);
