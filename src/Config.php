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
    const ENDPOINT_MUTATION_PUSH_WEBHOOK = '/api/v2/mutation/{mutation_id}/webhook';
    const ENDPOINT_MUTATION_DESTROY = '/api/v2/mutation/destroy';

    const ENDPOINT_BANK_INDEX = '/api/v2/bank';
    const ENDPOINT_BANK_STORE = '/api/v2/bank/store';
    const ENDPOINT_BANK_UPDATE = '/api/v2/bank/update/{bank_id}';
    const ENDPOINT_BANK_REFRESH_MUTATION = '/api/v2/bank/{bank_id}/refresh';
    const ENDPOINT_BANK_DESTROY = '/api/v2/bank/{bank_id}/destroy';
    const ENDPOINT_BANK_EWALLET_REQUEST_OTP = '/api/v2/bank/request/otp/{bank_id}';
    const ENDPOINT_BANK_EWALLET_VERIFICATION_OTP = '/api/v2/bank/verification/otp/{bank_id}';
    const ENDPOINT_TAGGING_INDEX = '/api/v2/tagging';
    const ENDPOINT_TAGGING_STORE = '/api/v2/tagging';
    const ENDPOINT_TAGGING_UPDATE = '/api/v2/tagging/{tag_id}';
    const ENDPOINT_TAGGING_DESTROY = '/api/v2/tagging/{tag_id}';


    const BANK_TYPES = [
        "bca",
        "bcaSyariah",
        "bni",
        "bniSyariah",
        "bri",
        "briCms",
        "briGiro",
        "briSyariah",
        "briSyariahCms",
        "mandiriOnline",
        "mandiriBisnis",
        "mandiriMcm",
        "mandiriSyariah",
        "mandiriSyariahMcm",
        "mandiriSyariahBisnis",
        "bniBisnis",
        "muamalat",
        "bniBisnisSyariah",
        "gojek",
        "ovo"
    ];


}