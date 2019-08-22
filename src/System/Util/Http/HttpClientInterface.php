<?php

declare(strict_types=1);

namespace System\Util\Http;

use System\Entity\Provider\HttpsRequest;
use System\Entity\Provider\HttpsResponse;
use System\Exception\Provider\CurlException;

interface HttpClientInterface
{
    /**
     * @param HttpsRequest $request
     * @return HttpsResponse
     *
     * @throws CurlException
     */
    public function sendRequest(HttpsRequest $request): HttpsResponse;
}
