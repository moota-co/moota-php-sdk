<?php


namespace Moota\Moota\Config;


class Moota
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
    const ENDPOINT_ATTATCH_TAGGING_MUTATION = '/api/v2/tagging/mutation/{mutation_id}';
    const ENDPOINT_DETACH_TAGGING_MUTATION = '/api/v2/tagging/mutation/{mutation_id}';
    const ENDPOINT_UPDATE_TAGGING_MUTATION = '/api/v2/tagging/mutation/{mutation_id}';

    const ENDPOINT_PAYMENT_METHOD = '/api/v2/payment';
    const ENDPOINT_TOPUP_CONFIRMATION = '/api/v2/topup/confirmation/{topup_id}';
    const ENDPOINT_TOPUP_INDEX = '/api/v2/topup';
    const ENDPOINT_TOPUP_STORE = '/api/v2/topup';
    const ENDPOINT_TOPUP_DENOM = '/api/v2/topup/denom';
    const ENDPOINT_TOPUP_DOWNLOAD_INVOICE = '/api/v2/topup/download';
    const ENDPOINT_VOUCHER_REDEEM = '/api/v2/voucher/redeem';
    const ENDPOINT_TRANSACTION_HISTORY = '/api/v2/transaction';
    
    const ENDPOINT_USER_PROFILE = '/api/v2/user';
    const ENDPOINT_USER_PROFILE_UPDATE = '/api/v2/user';
    
    const BANK_TYPES = [
        "bca",
        "bcaGiro",
        "bcaSyariahV2",
        "bniBisnisSyariahV2",
        "bniBisnisV2",
        "bniSyariahV2",
        "bniV2",
        "bri",
        "briCmsV2",
        "briGiro",
        "briSyariah",
        "briSyariahCmsV2",
        "bsi",
        "bsiGiro",
        "gojek",
        "mandiriBisnisV2",
        "mandiriMcm2V2",
        "mandiriMcmV2",
        "mandiriOnlineV2",
        "mandiriSyariah",
        "mandiriSyariahBisnis",
        "mandiriSyariahMcm",
        "mayBank",
        "megaSyariahCms",
        "muamalatV2",
        "ovo"
    ];


}