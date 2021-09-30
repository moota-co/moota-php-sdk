<?php

namespace Test\DTO;

use PHPUnit\Framework\TestCase;

class TaggingDataTransferObjectTest extends TestCase
{
    public function testTaggingQueryPrameterDTO()
    {
        $TaggingQueryParameterData = new \Moota\Moota\DTO\Tagging\TaggingQueryParameterData(['<tag_name_1>', '<tag_name_2>']);
        $this->assertInstanceOf(\Moota\Moota\DTO\Tagging\TaggingQueryParameterData::class, $TaggingQueryParameterData);
    }

    public function testTaggingStoreDTO()
    {
        $TaggingStoreData = new \Moota\Moota\DTO\Tagging\TaggingStoreData('<tag_name_1>');
        $this->assertInstanceOf(\Moota\Moota\DTO\Tagging\TaggingStoreData::class, $TaggingStoreData);
    }

    public function testTaggingUpdateDTO()
    {
        $TaggingUpdateData = new \Moota\Moota\DTO\Tagging\TaggingUpdateData('<tag_id>', '<tag_name_1>');
        $this->assertInstanceOf(\Moota\Moota\DTO\Tagging\TaggingUpdateData::class, $TaggingUpdateData);
    }
}