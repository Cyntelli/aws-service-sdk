<?php

require __DIR__ . '/../../vendor/autoload.php';

use Cyntelli\Aws\Sqs;

$service = new Sqs('ap-northeast-1', 'AKIA3IXIS7QRS5NMW22H', 'oCHNUME4WXOlix95dICjCVfOpqx8hl1fUrCr3kKy');

$result = $service->publish('123', 'https://sqs.ap-northeast-1.amazonaws.com/774655638563/mpc-dev-media-facebook');

var_dump($result);
