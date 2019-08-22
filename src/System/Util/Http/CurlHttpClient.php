<?php

declare(strict_types=1);

namespace System\Util\Http;

use System\Entity\Provider\HttpAuth;
use System\Entity\Provider\HttpsRequest;
use System\Entity\Provider\HttpsResponse;
use System\Exception\Provider\CurlException;

/**
 * Class HttpClient
 * @package System\Util\Http
 */
class CurlHttpClient implements HttpClientInterface
{
    /**
     * @param HttpsRequest $request
     * @return HttpsResponse
     * @throws CurlException
     */
    public function sendRequest(HttpsRequest $request): HttpsResponse
    {
        $ch = curl_init($request->getUrl());
        $curlOptions = $this->getCurlOptions($request);
        curl_setopt_array($ch, $curlOptions);

        if (!$response = curl_exec($ch)) {
            $err = curl_errno($ch);
            $errMessage = curl_error($ch);
            throw new CurlException((int) $err, $errMessage);
        }

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = $this->getHeadersFromCurlResponse($response);
        $body = substr($response, $header_size);

        curl_close($ch);

        return new HttpsResponse($header, $body);
    }

    /**
     * @param HttpsRequest $request
     * @return array
     */
    private function getCurlOptions(HttpsRequest $request): array
    {
        $curlOptions = [
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => $request->getTimeout(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true
        ];

        if ($request->getHttpAuth() instanceof HttpAuth) {
            $credentials = $request->getHttpAuth();
            $curlOptions[CURLOPT_USERPWD] = $credentials->getLogin().":".$credentials->getPassword();
        }

        if (!empty($request->getHeaders())) {
            $curlOptions[CURLOPT_HTTPHEADER] = $request->getHeaders();
        }

        if ($request->getBody() !== '') {
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $request->getBody();
        }

        if ($request->getSslCertificate() !== '') {
            $curlOptions[CURLOPT_SSLCERT] = $request->getSslCertificate();
        }

        if ($request->getSslKey() !== '') {
            $curlOptions[CURLOPT_SSLKEY] = $request->getSslKey();
            $curlOptions[CURLOPT_SSLKEYPASSWD] = $request->getSslKeyPassword();
        }

        if ($request->getSslCertificatePassword() !== '') {
            $curlOptions[CURLOPT_SSLCERTPASSWD] = $request->getSslCertificatePassword();
        }

        if ($request->getInterface() !== '') {
            $curlOptions[CURLOPT_INTERFACE] = $request->getInterface();
        }
        
        return $curlOptions;
    }

    /**
     * @param mixed $response
     * @return array
     */
    protected function getHeadersFromCurlResponse($response): array
    {
        $headers = [];

        $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

        foreach (explode("\r\n", $header_text) as $i => $line)
            if ($i === 0)
                $headers['http_code'] = $line;
            else
            {
                list ($key, $value) = explode(': ', $line);
                $headers[$key] = $value;
            }

        return $headers;
    }
}
