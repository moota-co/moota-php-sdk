<?php

namespace Test\DTO;

use PHPUnit\Framework\TestCase;

class MutationDataTransferObjectTest extends TestCase
{
    public function testMutationQueryPrameterDataTransferObject()
    {
        $MutationQueryParameterData = new \Moota\Moota\DTO\Mutation\MutationQueryParameterData(
            'CR',
            'klasdoi',
            '100012',
            'Test Mutations',
            '',
            '',
            '2021-09-22',
            '2020-09-23',
            'tag_1,tag_2'
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationQueryParameterData::class, $MutationQueryParameterData);
    }

    public function testMutationStoreDataTransferObject()
    {
        $MutationStoreData = new \Moota\Moota\DTO\Mutation\MutationStoreData(
            '<bank_id>',
            '2021-09-30',
            '1000123',
            'CR' // CR <credit> | DB <debit>
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationStoreData::class, $MutationStoreData);
    }

    public function testMutationNoteDataTransferObject()
    {
        $MutationNoteData = new \Moota\Moota\DTO\Mutation\MutationNoteData(
            '<mutation_id>',
            'Test Mutations',
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationNoteData::class, $MutationNoteData);
    }

    public function testMutationDestroyDataTransferObject()
    {
        $MutationDestroyData = new \Moota\Moota\DTO\Mutation\MutationDestroyData(
            ['<mutation_id>', '<mutation_id>'],
        );
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationDestroyData::class, $MutationDestroyData);
    }

    public function testMutationAttachTaggingDataTransferObject()
    {
        $MutationAttachTaggingData = new \Moota\Moota\DTO\Mutation\MutationAttachTaggingData(
            '<mutation_id>',
            ['<tag_name_1>', '<tag_name_1>'],
        );

        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationAttachTaggingData::class, $MutationAttachTaggingData);
    }

    public function testMutationDetachTaggingDataTransferObject()
    {
        $MutationDetachTaggingData = new \Moota\Moota\DTO\Mutation\MutationDetachTaggingData(
            '<mutation_id>',
            ['<tag_name_1>', '<tag_name_1>'],
        );

        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationDetachTaggingData::class, $MutationDetachTaggingData);
    }

    public function testMutationUpdateTaggingDataTransferObject()
    {
        $MutationUpdateTaggingData = new \Moota\Moota\DTO\Mutation\MutationUpdateTaggingData(
            '<mutation_id>',
            ['<tag_name_1>', '<tag_name_1>'],
        );

        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationUpdateTaggingData::class, $MutationUpdateTaggingData);
    }
}