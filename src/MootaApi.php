<?php

namespace Moota\Moota;

class MootaApi
{
    private static $instance;

    public static function getInstance()
    {
        if ( !self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function getAccountList()
    {
        // TODO Request Bank List
    }

    public function getMutation(string $mutation_id)
    {
        // TODO Get Specifcit Mutation ID
    }

    public static function attachMutationNote(string $message)
    {
        // TODO Request Attach Mutation Note
    }

    public static function attachMutationTag(array $tags)
    {
        // TODO : Attach Tags to mutations
    }

    public function __clone()
    {
    }

    public function __wakeup()
    {
    }
}