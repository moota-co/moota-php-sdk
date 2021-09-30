<?php

namespace Moota\Moota\Exception\Webhook;

class WebhookValidateException  extends \Exception
{
    public function __construct($message = 'webhook authentication failed.', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}