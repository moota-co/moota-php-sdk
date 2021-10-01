<?php


namespace Moota\Moota\Response;


class MutationResponse
{
    private array $data;

    public function __construct(array $result)
    {
        if (! isset($result['data'])) {
           return $this->data = $result;
        }
        $this->data = $result['data'];
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