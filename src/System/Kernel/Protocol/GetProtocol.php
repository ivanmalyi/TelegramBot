<?php

declare(strict_types=1);

namespace System\Kernel\Protocol;

use System\Util\Logging\LoggerReferenceTrait;

class GetProtocol implements ProtocolInterface
{
    use LoggerReferenceTrait;

    /**
     * @return ProtocolHeaders
     */
    public function getIncomingHeaders(): ProtocolHeaders
    {
        $contentType = $_SERVER["CONTENT_TYPE"] ?? '';
        return new ProtocolHeaders($contentType);
    }

    public function getIncomingPacket(): ProtocolPacket
    {
        $signature = $_SERVER['HTTP_SIGNATURE'] ?? '';
        $signature = getenv('ENVIRONMENT') === 'dev' && isset($_GET['signature']) ? $_GET['signature'] : $signature;
        $headers = [];

        $headers["CONTENT_TYPE"] = $_SERVER["CONTENT_TYPE"] ?? '';
        $headers['REQUEST_URI'] = isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI'])[0]: '';

        $packet = new ProtocolPacket(
            json_encode($_GET),
            $signature,
            $headers
        );

        return $packet;
    }

    public function sendResponse(ProtocolPacket $packet)
    {
        // TODO: Implement sendResponse() method.
    }


}
