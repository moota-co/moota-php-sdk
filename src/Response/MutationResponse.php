<?php


namespace Moota\Moota\Response;


class MutationResponse
{
    private $data;

    public function __construct(array $result)
    {

        $this->data = $result;
    }

    /**
     * Get Mutation Data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
}