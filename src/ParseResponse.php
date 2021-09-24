<?php


namespace Moota\Moota;

use Moota\Moota\Exception\Mutation\MootaException;

class ParseResponse
{
    public $responseClass = [
        Config::ENDPOINT_MUTATION_INDEX => 'Moota\Moota\Response\MutationResponse',
        Config::ENDPOINT_MUTATION_STORE => 'Moota\Moota\Response\MutationResponse'
    ];

    public $exceptionClass = [
        Config::ENDPOINT_MUTATION_INDEX => 'Moota\Moota\Exception\Mutation\MutationException',
        Config::ENDPOINT_MUTATION_STORE =>  'Moota\Moota\Exception\Mutation\MutationException',
        Config::ENDPOINT_MUTATION_DESTROY => 'Moota\Moota\Exception\Mutation\MutationException'
    ];

    private $response;

    public function __construct($results, $url)
    {
        $parts = parse_url($url);

        if(! $results->isOk() ) {
            if( isset($this->exceptionClass[$parts['path']]) ) {
                throw new $this->exceptionClass[$parts['path']]($results->json()['message'], $results->status(), null, $results->json());
            }

            throw new MootaException($results->json()['message'], $results->status(), null, $results->json());
        }

        if(! isset($this->responseClass[$parts['path']])) {
            return $this->response = $results->json();
        }

        $this->response = new $this->responseClass[$parts['path']]($results->json());
    }

    /**
     * Get response following by class
     *
     * @return void
     */
    public function getResponse()
    {
        return $this->response;
    }
}