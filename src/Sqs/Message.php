<?php

namespace Cyntelli\Aws\Sqs;

use Exception;

/**
 * SQS Message.
 * 
 * @author Leo Wang<leo.wang@cyntelli.com>
 * @version 1.0.0
 */
class Message
{
    /**
     * __set.
     * 
     * @param string $property
     * @param mixed $value
     */
    public function __set(string $property, $value)
    {
        $this->$property = $value;
    }

    /**
     * __get.
     * 
     * @param string $property
     * 
     * @return mixed
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        } else {
            throw new Exception("Undefinded property via __get(): $property", 500);

            return NULL;
        }
    }

    /**
     * Ack.
     */
    public function ack()
    {
        $this->service->deleteMessage([
            'QueueUrl' => $this->queue_url,
            'ReceiptHandle' => $this->content['ReceiptHandle']
        ]);
    }
}

