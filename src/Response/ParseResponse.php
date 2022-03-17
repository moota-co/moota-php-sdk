<?php


namespace Moota\Moota\Response;

use Moota\Moota\Config\Moota;
use Moota\Moota\Exception\MootaException;

class ParseResponse
{
    public array $responseClass = [
        Moota::ENDPOINT_MUTATION_INDEX => 'Moota\Moota\Response\MutationResponse',
        Moota::ENDPOINT_MUTATION_STORE => 'Moota\Moota\Response\MutationResponse',

        Moota::ENDPOINT_BANK_INDEX => 'Moota\Moota\Response\BankAccount\BankAccountResponse',
        Moota::ENDPOINT_BANK_STORE => 'Moota\Moota\Response\BankAccount\BankAccountResponse',
        Moota::ENDPOINT_BANK_UPDATE => 'Moota\Moota\Response\BankAccount\BankAccountResponse',

        Moota::ENDPOINT_CONTRACT_STORE => 'Moota\Moota\Response\Contract\ConctractStoreResponse',

        Moota::ENDPOINT_TAGGING_STORE => 'Moota\Moota\Response\Tagging\TaggingResponse',

        Moota::ENDPOINT_TOPUP_INDEX => 'Moota\Moota\Response\Topup\TopupResponse',

        Moota::ENDPOINT_TRANSACTION_HISTORY => 'Moota\Moota\Response\Transaction\TransactionHistoryResponse',

        Moota::ENDPOINT_USER_PROFILE => 'Moota\Moota\Response\User\UserResponse',

        Moota::ENDPOINT_WEBHOOK_INDEX => 'Moota\Moota\Response\Webhook\WebhookIndexResponse',
        Moota::ENDPOINT_WEBHOOK_HISTORY => 'Moota\Moota\Response\Webhook\WebhookIndexResponse'
    ];

    public array $exceptionClass = [
        Moota::ENDPOINT_MUTATION_INDEX => 'Moota\Moota\Exception\Mutation\MutationException',
        Moota::ENDPOINT_MUTATION_STORE =>  'Moota\Moota\Exception\Mutation\MutationException',
        Moota::ENDPOINT_MUTATION_DESTROY => 'Moota\Moota\Exception\Mutation\MutationException'
    ];

    private $response;

    public function __construct($results, $url)
    {
        $parts = parse_url($url);

        if(! $results->isOk() ) {
            $error_message = $results->json()['message'] ?? $results->json()['error'];
            if( isset($this->exceptionClass[$parts['path']]) ) {
                throw new $this->exceptionClass[$parts['path']]($error_message, $results->status(), null, $results->json());
            }

            throw new MootaException($error_message, $results->status(), null, $results->json());
        }

        if(! isset($this->responseClass[$parts['path']])) {
            return $this->response = $results->json();
        }

        $this->response = new $this->responseClass[$parts['path']]($results->json());
    }

    /**
     * Get response following by class
     *
     */
    public function getResponse()
    {
        return $this->response;
    }
}