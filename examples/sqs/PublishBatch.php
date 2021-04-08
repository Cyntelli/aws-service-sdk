<?php

require __DIR__ . '/../../vendor/autoload.php';

use Cyntelli\Aws\Sqs;

$service = new Sqs('REGION', 'ACCESS_ID', 'ACCESS_SECRET');

$result = $service->publishBatch([
    'MESSAGE_CONTENT_1',
    'MESSAGE_CONTENT_2'
], 'QUEUE_URL');

var_dump($result);