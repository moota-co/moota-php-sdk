<?php


namespace Moota\Moota;


class Config
{
    /**
     * Secret token anda untuk authentikasi
     *
     * @access_token
     */
    public static $ACCESS_TOKEN;

    /**
     * Target Url Moota V.2
     *
     * @BASE_URL
     */
//    const BASE_URL = 'https://app.moota.co';
    const BASE_URL = 'http://moota.test';

    /**
     * Endpoint list
     */
    const ENDPOINT_MUTATION_INDEX = '/api/v2/mutation';
    const ENDPOINT_MUTATION_STORE = '/api/v2/mutation/store/';
    const ENDPOINT_MUTATION_NOTE = '/api/v2/mutation/{mutation_id}/note';



}