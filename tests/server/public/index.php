<?php


use Moota\Moota\Config;
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
 * Mocking Mutation
 *
 */
$app->router->get(Config::ENDPOINT_MUTATION_INDEX, function () {
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

$app->router->post(Config::ENDPOINT_MUTATION_STORE, function () {
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

$app->router->post(Helper::replace_uri_with_id(Config::ENDPOINT_MUTATION_NOTE, 'hash_mutation_id', '{mutation_id}'), function () {
    $request = app('request');
    $mock_store_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockaddNoteMutationResponse.json');
    $response = json_decode($mock_store_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 200) );
});

$app->router->post(Helper::replace_uri_with_id(Config::ENDPOINT_MUTATION_NOTE, 1, '{mutation_id}'), function () {
    $request = app('request');
    $mock_fail_response = file_get_contents(dirname(__FILE__, '3') . '/Mocking/Mutation/MockFailAddNoteMutationResponse.json');
    $response = json_decode($mock_fail_response, true);

    return response()->json( $response ,  $request->header('Z-Status', 404) );
});





$app->router->post('/post', function () {
    return build_response(app('request'));
});

$app->router->put('/put', function () {
    return build_response(app('request'));
});

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

$app->router->get('/simple-response', function () {
    return "A simple string response";
});

$app->router->get('/timeout', function () {
    sleep(2);
});

$app->router->get('/basic-auth', function () {
    $headers = [
        (bool)preg_match('/Basic\s[a-zA-Z0-9]+/', app('request')->header('Authorization')),
        app('request')->header('php-auth-user') === 'zttp',
        app('request')->header('php-auth-pw') === 'secret'
    ];

    return (count(array_unique($headers)) === 1) ? response(null, 200) : response(null, 401);
});

$app->router->get('/digest-auth', function () {
    $realm = 'Restricted area';

    $authorization = app('request')->server->get('PHP_AUTH_DIGEST');
    if (!$authorization) {
        return response(null, 401)->header(
            'WWW-Authenticate',
            'Digest realm="' . $realm . '",qop="auth",nonce="' . uniqid() . '",opaque="' . md5($realm) . '"'
        );
    }

    $data = ['nonce' => null, 'nc' => null, 'cnonce' => null, 'qop' => null, 'username' => null, 'uri' => null, 'response' => null];
    foreach (array_keys($data) as $key) {
        if (!preg_match("@$key=(?:\"(.*)\"|'(.*)'|(.*),)@U", $authorization, $matches)) {
            return response(null, 401);
        }
        $data[$key] = array_values(array_filter($matches))[1];
    }

    if ($data['username'] != 'zttp') {
        return response(null, 401);
    }

    $a = md5('zttp:' . $realm . ':secret');
    $b = md5(app('request')->server->get('REQUEST_METHOD') . ':' . $data['uri']);
    $validResponse = md5($a . ':' . $data['nonce'] . ':' . $data['nc'] . ':' . $data['cnonce'] . ':' . $data['qop'] . ':' . $b);

    if ($data['response'] != $validResponse) {
        return response(null, 401);
    }

    return response(200);
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