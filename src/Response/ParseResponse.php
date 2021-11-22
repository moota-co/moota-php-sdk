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

    public $response;

    public function __construct(\GuzzleHttp\Psr7\Response $results, $uri)
    {

        $response = json_decode($results->getBody()->getContents(), true);
        $status_code = $results->getStatusCode();


        if( $status_code != 200 ) {
            $error_message = $response['message'] ?? $response['error'];
            if( isset($this->exceptionClass[$uri]) ) {
                throw new $this->exceptionClass[$uri]($error_message, $status_code, null, $response);
            }

            throw new MootaException($error_message, $status_code, null, $response);
        }

        if(! isset($this->responseClass[$uri])) {
            return $this->response = $response;
        }

        $this->response = new $this->responseClass[$uri]($response);
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