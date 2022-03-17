<?php


use Moota\Moota\Config\Moota;
use Moota\Moota\Helper\Helper;

require_once __DIR__ . '/../../../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__ . '/tests/')
);

function build_response($request)
{
    return response()->json([
        'headers' => $request->header(),
        'query' => http_build_query($request->query()),
        'json' => $request->json()->all(),
        'form_params' => $request->request->all(),
        'cookies' => $request->cookies->all(),
    ], $request->header('Z-Status', 200));
}

/**
 * Start Mocking Authentication
 */
$app->router->post(Moota::ENDPOINT_AUTH_LOGIN, function () {
    $request = app('request');
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Auth/MockAuthResponse.json');
    $response = json_decode($mock_success_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 200) );
});

$app->router->post(Moota::ENDPOINT_AUTH_LOGOUT, function () {
    $request = app('request');
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $response = json_decode($mock_success_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 200) );
});

/**
 * End Mocking Authentication
 */


/**
 * Start Mocking Local Server Mutation
 */
$app->router->get(Moota::ENDPOINT_MUTATION_INDEX, function () {
    $mutations = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockMutationResponse.json');
    $request = app('request');
    $query_params = $request->query();

    if(is_numeric($query_params['bank'])) {
        return response()->json(['message' => 'Bank tidak ditemukan.'], 404);
    }

    if (! $request->header('Authorization') || empty($request->header('Authorization'))) {
        return response()->json(['error' => 'Unauthenticated.'], 401);
    }

    return response()->json( json_decode($mutations, true),  $request->header('Z-Status', 200) );
});

$app->router->post(Moota::ENDPOINT_MUTATION_STORE, function () {
    $request = app('request');
    $mock_store_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockStoreMutation.json');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockFailStoreMutation.json');
    $response = json_decode($mock_store_response, true);
    $status = 200;

    if(empty($request->json()->all()['type'])) {
        $status = 422;
        $response = json_decode($mock_fail_response, true);
    }

    return response()->json( $response ,  $request->header('Z-Status', $status) );
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_NOTE, 'hash_mutation_id', '{mutation_id}'), function () {
    $request = app('request');
    $mock_store_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockaddNoteMutationResponse.json');
    $response = json_decode($mock_store_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 200) );
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_NOTE, 1, '{mutation_id}'), function () {
    $request = app('request');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockFailAddNoteMutationResponse.json');
    $response = json_decode($mock_fail_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 404) );
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, 'abcd', '{mutation_id}'), function () {
    $request = app('request');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockFailAddNoteMutationResponse.json');
    $response = json_decode($mock_fail_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 404) );
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_MUTATION_PUSH_WEBHOOK, 'hashing_mutation_id', '{mutation_id}'), function () {
    $request = app('request');

    return response()->json( ['status' => 'OK'] ,  $request->header('Z-Status', 200) );
});

$app->router->post(Moota::ENDPOINT_MUTATION_DESTROY, function () {
    $request = app('request');
    $mock_destroy_mutation_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockDestroyMutation.json');
    $mock_fail_destroy_mutation_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockFailDestrotMutation.json');
    $mock_invalid_request_destroy_mutation_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockInvalidRequestDestroyMutation.json');

    $response = json_decode($mock_destroy_mutation_response, true);
    $status = 200;

    if(! in_array( 'hash_mutation_id', $request->json()->all()['mutations'])) {
        $status = 500;
        $response = json_decode($mock_fail_destroy_mutation_response, true);
    }

    if(empty($request->json()->all()['mutations'])) {
        $status = 422;
        $response = json_decode($mock_invalid_request_destroy_mutation_response, true);
    }

    return response()->json($response,  $request->header('Z-Status', $status) );
});

$app->router->post(Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, '8aolk43WJxM', '{mutation_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $mock_invalid_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestNotFound.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

    if( $request->all()['name'][0] != 'assurance') {
        $status = 422;
        $response = json_decode($mock_invalid_response, true);
    }

    return response()->json($response,  $request->header('Z-Status', $status));
});

$app->router->delete(Helper::replace_uri_with_id( Moota::ENDPOINT_ATTATCH_TAGGING_MUTATION, '8aolk43WJxM', '{mutation_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

    return response()->json($response,  $request->header('Z-Status', $status));
});


/**
* End Mocking Local Server Mutation
*/





/**
 * Start Mocking Server BankAccount
 */
$app->router->get(Moota::ENDPOINT_BANK_INDEX, function () {
    $response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockingListBankAccountResponse.json');
    $request = app('request');

    return response()->json( json_decode($response, true),  $request->header('Z-Status', 200) );
});

$app->router->post(Moota::ENDPOINT_BANK_STORE, function () {
    $mock_list_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockStoreBankAccountResponse.json');
    $mock_fail_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockInvalidStoreBankAccountResponse.json');
    $mock_fail_with_point_not_enough_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockStoreBankAccountResponse.json');
    $request = app('request');
    $response = json_decode($mock_list_bank_account_response, true);
    $status = 200;

    if(! in_array($request->json()->all()['bank_type'], Moota::BANK_TYPES)) {
        $status = 422;
        $response = json_decode($mock_fail_bank_account_response, true);
    }

    return response()->json( $response ,  $request->header('Z-Status', $status) );
});

$app->router->put(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, "hashing_qwopejs_id", '{bank_id}'), function () {
    $mock_update_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockUpdateBankAccountResponse.json');
    $request = app('request');
    $response = json_decode($mock_update_bank_account_response, true);

    return response()->json($response,  $request->header('Z-Status', 200) );
});

$app->router->put(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_UPDATE, 1, '{bank_id}'), function () {
    $mock_fail_update_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockFailUpdateBankAccountResponse.json');
    $request = app('request');
    $response = json_decode($mock_fail_update_bank_account_response, true);

    return response()->json($response,  $request->header('Z-Status', 500));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, 'hash_oqwjas_id', '{bank_id}'), function () {
    $mock_fail_update_bank_account_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $request = app('request');
    $response = json_decode($mock_fail_update_bank_account_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_REFRESH_MUTATION, 'hash_aswj_id', '{bank_id}'), function () {
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockFailRequestWithPointNotEnough.json');
    $request = app('request');
    $response = json_decode($mock_fail_response, true);

    return response()->json($response,  $request->header('Z-Status', 422));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, 'hash_kiusd_id', '{bank_id}'), function () {
    $mock_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $request = app('request');
    $response = json_decode($mock_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_DESTROY, 'hash_qweas_id', '{bank_id}'), function () {
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestNotFound.json');
    $request = app('request');
    $response = json_decode($mock_fail_response, true);

    return response()->json($response,  $request->header('Z-Status', 500));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, 'hash_ewallet_id', '{bank_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockSuccessRequestOtpResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_REQUEST_OTP, 'hash_fail_ewallet_id', '{bank_id}'), function () {
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/BankAccount/MockFailRequestOtpResponse.json');
    $request = app('request');
    $response = json_decode($mock_fail_response, true);

    return response()->json($response,  $request->header('Z-Status', 500));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_BANK_EWALLET_VERIFICATION_OTP, 'hash_verification_ewallet_id', '{bank_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $mock_invalid_request_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/bankAccount/MockInvalidVerificationOtpCodeResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

    if( strlen($request->all()['otp_code']) > 4 || strlen($request->all()['otp_code']) < 4) {
        $status = 422;
        $response = json_decode($mock_invalid_request_response, true);
    }

    return response()->json($response,  $request->header('Z-Status', $status));
});

/**
 * End Mocking Server BankAccount
 */




/**
 * Start Mocking Server Tagging
 */
$app->router->get(Moota::ENDPOINT_TAGGING_INDEX, function () {
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Tagging/MockListTaggingResponse.json');
    $request = app('request');
    $response = json_decode($mock_fail_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Moota::ENDPOINT_TAGGING_STORE, function () {
    $mock_succcess_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Tagging/MockSuccessStoreTaggingResponse.json');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Tagging/MockInvalidRequestTaggingResponse.json');
    $request = app('request');
    $response = json_decode($mock_succcess_response, true);
    $status = 200;

    if( empty($request->all()['name']) ) {
        $status = 422;
        $response = json_decode($mock_fail_response, true);
    }

    return response()->json($response,  $request->header('Z-Status', $status));
});

$app->router->put(Helper::replace_uri_with_id( Moota::ENDPOINT_TAGGING_UPDATE, 'VLagzqBj42Ds', '{tag_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Tagging/MockUpdateTaggingResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->put(Helper::replace_uri_with_id( Moota::ENDPOINT_TAGGING_DESTROY, 'VLagzqBj42Ds', '{tag_id}'), function () {
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $request = app('request');
    $response = json_decode($mock_fail_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

/**
 * End Mocking Server Tagging
 */




/**
 * Start Mocking Server Topup
 */
$app->router->get(Moota::ENDPOINT_PAYMENT_METHOD, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockPaymentMethodResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->get(Moota::ENDPOINT_TOPUP_INDEX, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockListTopupResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Moota::ENDPOINT_TOPUP_STORE, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockCreateTopupResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->get(Moota::ENDPOINT_TOPUP_DENOM, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockListAmountTopup.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Helper::replace_uri_with_id(Moota::ENDPOINT_TOPUP_CONFIRMATION, 'ajksdha', '{topup_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockListAmountTopup.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json([
        'body_content' => app('request')->only(['foo', 'baz']),
        'has_file' => app('request')->hasFile('test-file'),
        'file_content' => file_get_contents($_FILES),
        'headers' => app('request')->header(),
    ], 200);

    return response()->json(app('request'),  $request->header('Z-Status', 200));
});

$app->router->post(Moota::ENDPOINT_VOUCHER_REDEEM, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockSuccessRedeemVoucherResponse.json');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Topup/MockInvalidRedeemVoucherResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

    if( $request->all()['code'] != 'abcd' ) {
        $status = 422;
        $response = json_decode($mock_fail_response, true);
    }

    return response()->json($response,  $request->header('Z-Status', $status));
});

$app->router->get(Moota::ENDPOINT_TRANSACTION_HISTORY, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Transaction/MockTransactionResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->get(Moota::ENDPOINT_USER_PROFILE, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/User/MockUserProfileResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Moota::ENDPOINT_USER_PROFILE_UPDATE, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/User/MockUpdateUserResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});
/**
 * End Mocking Server Topup
 */


/**
 * Start Mocking Server webhook
 */

$app->router->get(Moota::ENDPOINT_WEBHOOK_INDEX, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Webhook/MockingWebhookIndexResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);

    return response()->json($response,  $request->header('Z-Status', 200));
});

$app->router->post(Moota::ENDPOINT_WEBHOOK_STORE, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/MockRequestSuccessResponse.json');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Webhook/MockingInvalidStoreWebhookResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

    if( $request->all()['kinds'] != 'credit' ) {
        $status = 422;
        $response = json_decode($mock_fail_response, true);
    }

    return response()->json($response,  $request->header('Z-Status', $status));
});

$app->router->get(Helper::replace_uri_with_id( Moota::ENDPOINT_WEBHOOK_HISTORY, 'hash_webhook_id', '{webhook_id}'), function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Webhook/MockingWebhookHistoryResponse.json');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Webhook/MockingInvalidStoreWebhookResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

//    if( $request->all()['kinds'] != 'credit' ) {
//        $status = 422;
//        $response = json_decode($mock_fail_response, true);
//    }

    return response()->json($response,  $request->header('Z-Status', $status));
});
/**
 * End Mocking Server webhook
 */

 /**
 * Start Mocking Server Contract
 */

$app->router->post(Moota::ENDPOINT_CONTRACT_STORE, function () {
    $mock_success_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Contract/MockStoreContractResponse.json');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Contract/MockFailContractStoreResponse.json');
    $request = app('request');
    $response = json_decode($mock_success_response, true);
    $status = 200;

    if($request->json()->all()['invoice_number'] == 'inv_moota_01') {
        $status = 422;
        $response = json_decode($mock_fail_response, true);
    }

    return response()->json( $response ,  $request->header('Z-Status', $status) );
});
/**
 * End Mocking Server Contract
 */

$app->router->patch('/patch', function () {
    return build_response(app('request'));
});

$app->router->delete('/delete', function () {
    return build_response(app('request'));
});

$app->router->get('/redirect', function () {
    return redirect('redirected');
});

$app->router->get('/redirected', function () {
    return "Redirected!";
});

$app->router->get('/basic-auth', function () {
    $headers = [
        (bool)preg_match('/Basic\s[a-zA-Z0-9]+/', app('request')->header('Authorization')),
        app('request')->header('php-auth-user') === 'zttp',
        app('request')->header('php-auth-pw') === 'secret'
    ];

    return (count(array_unique($headers)) === 1) ? response(null, 200) : response(null, 401);
});

$app->router->post('/multi-part', function () {
    return response()->json([
        'body_content' => app('request')->only(['foo', 'baz']),
        'has_file' => app('request')->hasFile('test-file'),
        'file_content' => file_get_contents($_FILES['test-file']['tmp_name']),
        'headers' => app('request')->header(),
    ], 200);
});

$app->router->get('/set-cookie', function () {
    return response(null, 200)->withCookie(
        new \Symfony\Component\HttpFoundation\Cookie('foo', 'bar')
    );
});

$app->router->get('/set-another-cookie', function () {
    return response(null, 200)->withCookie(
        new \Symfony\Component\HttpFoundation\Cookie('baz', 'qux')
    );
});

$app->run();