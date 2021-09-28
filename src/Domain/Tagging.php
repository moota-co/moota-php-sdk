<?php


namespace Moota\Moota\Domain;


use Moota\Moota\Config\Moota;
use Moota\Moota\Exception\MootaException;
use Moota\Moota\Helper\Helper;
use Moota\Moota\Response\ParseResponse;
use Moota\Moota\Response\Tagging\TaggingResponse;
use Zttp\Zttp;

class Tagging
{
    //eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiJLWmZzZ200Z29kUiIsImp0aSI6IjQ0NTg3ZThiYzM4NTA1NzRiNWJlYjJjZmRlYTE3MmI3MDk1NWIxZjhkNTJhOTRlZWY4MGM5MTAzZjFmZjY5ZTk0NmVlNGQ0MjlhZTlhM2UyIiwiaWF0IjoxNjMyNDU2MzA1LjI0MDgyOSwibmJmIjoxNjMyNDU2MzA1LjI0MDgzMSwiZXhwIjoxNjYzOTkyMzA1LjIzNzA5Mywic3ViIjoiMSIsInNjb3BlcyI6WyJhcGkiXX0.UYJFOlnL4G4KZ2okxUwLNp2769u3O3k0Urhj84G9pU9lreq9L8-037wsWT79DHN-c1zUD1WBnoIEUS6o0q3aM5S-Ssi_roczmB-Ts2Yov_k02BqgW_oLRcbTarbbOhzzHyMHNP7vcI4QrYeyTzpJLo7Wd4Fn4jfhuqqFpLvW34QUxws3gUIQGVz8cKc12OmHlCLgN4N1Bz6hg5jaOMRycIiD03hGM4NazH4fMNDMddhKkbQw8QjnoNnNRnuf7bbLTR-LquyzLDVTT0YGMKH-Cbtu67hmYB9E2wwCimZUpUyM-Bir772BSi59nW66mPqslS1fO8IixlkWTH03hhNu_ninKFmCpH8ZTdkVnruCy9fPDsjAn2pXeSco3NTFnKQccpdCiCJzILyQMNSmSpicqJm3AgPIcdoIZH-La_7niSR5xlks4Ln9Tzu2y8rAgLBCrPK0rIaI9qnhMHX37HQgX7GS9auJM8QVVmePVmfCbG6qsNaoiv5NqJ6tvknK9ilhUNWrHpJvfDIIJYZOG8_sAILFY1DKWk-rm7AF2DiMeOVWIsyfXhmqgnQLDNHfxYjVNVsYO1VWKx2yT4x8ylnz82clGGSA8AO9Rfqj4sOHmxZjndfeW2EqNmHCLoMUFv6WtRLSX3Fjfz30JCX9_wKolMf642kBxdDIwBMx2xecP3Q
    public function getTaggings(array $parameter)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_TAGGING_INDEX;
        $params['tag'] = implode(",", $parameter);

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->get($url, $params), $url
        ))
            ->getResponse()
            ->getTaggingData();
    }

    /**
     * @param array $payload
     *
     * @return TaggingResponse
     * @throws MootaException
     */
    public function storeTagging(array $payload)
    {
        $url = Moota::BASE_URL . Moota::ENDPOINT_TAGGING_STORE;

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->post($url, $payload), $url
        ))
            ->getResponse()
            ->getTaggingData();
    }

    /**
     * @param string $tag_id
     * @param array $payload
     *
     * @return TaggingResponse
     * @throws MootaException
     */
    public function updateTagging(string $tag_id, array $payload)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_TAGGING_UPDATE, $tag_id, '{tag_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->put($url, $payload), $url
        ))
            ->getResponse();
    }

    /**
     * @param string $tag_id
     *
     * @return void
     * @throws MootaException
     */
    public function destroyTagging(string $tag_id)
    {
        $url = Helper::replace_uri_with_id(Moota::BASE_URL . Moota::ENDPOINT_TAGGING_DESTROY, $tag_id, '{tag_id}');

        return (new ParseResponse(
            Zttp::withHeaders([
                'User-Agent'        => 'Moota/2.0',
                'Accept'            => 'application/json',
                'Authorization'     => 'Bearer ' . Moota::$ACCESS_TOKEN
            ])->delete($url), $url
        ))
            ->getResponse();
    }
}