<?php


namespace Moota\Moota\Response\Tagging;


class TaggingResponse
{
    private $tagging;

    public function __construct($results)
    {
        $this->tagging = $results['tagging'];
    }

    public function getTaggingData()
    {
        return $this->tagging;
    }
}