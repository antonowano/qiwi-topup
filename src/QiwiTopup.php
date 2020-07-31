<?php

namespace Antonowano\QiwiTopup;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as HttpRequest;

class QiwiTopup
{
    private const API_URL = 'https://api.qiwi.com/xml/topup.jsp';

    public function sendRequest(Request $request): Response
    {
        $xmlBuilder = new Builder\XMLBuilder();
        $xml = $xmlBuilder->build($request);
        $httpRequest = new HttpRequest('POST', self::API_URL, [], $xml);
        $client = new Client();
        $xmlResponse = $client->send($httpRequest)->getBody()->getContents();
        $responseBuilder = new Builder\ResponseBuilder();

        return $responseBuilder->build($xmlResponse);
    }
}
