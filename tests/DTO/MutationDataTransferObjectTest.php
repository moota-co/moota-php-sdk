<?php

namespace Test\DTO;

use PHPUnit\Framework\TestCase;

class MutationDataTransferObjectTest extends TestCase
{
    public function testMutationQueryPrameterDataTransferObject()
    {
        $MutationQueryParameterData = new \Moota\Moota\DTO\Mutation\MutationQueryParameterData([
            'type' => 'CR',
            'bank' => 'klasdoi',
            'amount' => '100012',
            'description' => 'Test Mutations',
            'note' => '',
            'date' => '',
            'start_date' => '2021-09-22',
            'end_date' => '2020-09-23',
            'tag' => 'tag_1,tag_2'
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationQueryParameterData::class, $MutationQueryParameterData);
    }

    public function testMutationStoreDataTransferObject()
    {
        $MutationStoreData = new \Moota\Moota\DTO\Mutation\MutationStoreData([
            'bank_id' =>'<bank_id>',
            'date' =>  '2021-09-30',
            'amount' => '1000123',
            'type' => 'CR',// CR <credit> | DB <debit>
        ]);


        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationStoreData::class, $MutationStoreData);
    }

    public function testMutationNoteDataTransferObject()
    {
        $MutationNoteData = new \Moota\Moota\DTO\Mutation\MutationNoteData([
            'mutation_id' => '<mutation_id>',
            'note' => 'Test Mutations',
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationNoteData::class, $MutationNoteData);
    }

    public function testMutationDestroyDataTransferObject()
    {
        $MutationDestroyData = new \Moota\Moota\DTO\Mutation\MutationDestroyData([
            'mutations' => [
                '<mutation_id>',
                '<mutation_id>'
            ]
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationDestroyData::class, $MutationDestroyData);
    }

    public function testMutationAttachTaggingDataTransferObject()
    {
        $MutationAttachTaggingData = new \Moota\Moota\DTO\Mutation\MutationAttachTaggingData([
            'mutation_id' => 'ashdasb',
            'name' => [
                '<tag_name_1>',
                '<tag_name_1>'
            ]
        ]);

        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationAttachTaggingData::class, $MutationAttachTaggingData);
    }

    public function testMutationDetachTaggingDataTransferObject()
    {
        $MutationDetachTaggingData = new \Moota\Moota\DTO\Mutation\MutationDetachTaggingData([
            'mutation_id' => 'ashdasb',
            'name' => [
                '<tag_name_1>',
                '<tag_name_1>'
            ]
        ]);
        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationDetachTaggingData::class, $MutationDetachTaggingData);
    }

    public function testMutationUpdateTaggingDataTransferObject()
    {
        $MutationUpdateTaggingData = new \Moota\Moota\DTO\Mutation\MutationUpdateTaggingData([
            'mutation_id' => 'ashdasb',
            'name' => [
                '<tag_name_1>',
                '<tag_name_1>'
            ]
        ]);

        $this->assertInstanceOf(\Moota\Moota\DTO\Mutation\MutationUpdateTaggingData::class, $MutationUpdateTaggingData);
    }
}