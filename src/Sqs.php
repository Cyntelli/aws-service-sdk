<?php

namespace Cyntelli\Aws;

use Aws\Credentials\Credentials;
use Aws\Result;
use Aws\Sdk;
use Aws\Sqs\SqsClient;
use Cyntelli\Aws\Sqs\Message;

/**
 * SQS service.
 * 
 * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/class-Aws.Sqs.SqsClient.html
 * 
 * @author Leo Wang <leo.wang@cyntelli.com>
 * @version 1.0.0
 */
class Sqs
{
    /**
     * @var SqsClient $service
     */
    private $service;
	
    /**
     * Construct.
     */
    public function __construct(string $region, string $accessId, string $accessSecret, string $version='latest')
    {
        $credential = new Credentials($accessId, $accessSecret);

        $sdk = new Sdk([
            'version' => $version,
            'region' => $region,
            'credentials' => $credential
        ]);

        $this->service = $sdk->createSqs();
    }

    /**
     * Publish message.
     * 
     * @param string $messageBody
     * @param string $queueUrl
     * 
     * @return Result
     */
    public function publish(string $messageBody, string $queueUrl): Result
    {
        return $this->service->sendMessage([
            'MessageBody' => $messageBody,
            'QueueUrl' => $queueUrl
        ]);
    }
    
    /**
     * Consume message.
     * 
     * @var callback $callback
     * @var string $queueUrl
     */
    public function consume($callback, string $queueUrl, int $maxNumberOfMessages=10, int $waitTimeSeconds=20)
    {
        while (true) {
            $data = $this->service->receiveMessage([
                'QueueUrl' => $queueUrl,
                'MaxNumberOfMessages' => $maxNumberOfMessages,
                'WaitTimeSeconds' => $waitTimeSeconds
            ]);

            if (!empty($data->get('Messages'))) {
                foreach ($data->get('Messages') as $message) {
                    // generate message object
                    $messageObject = new Message;
                    $messageObject->service = $this->service;
                    $messageObject->queue_url = $queueUrl;
                    $messageObject->content = $message;

                    call_user_func($callback, $messageObject);
                }

                sleep(1);
            } else {
                sleep(30);
            }
        }
    }
}

