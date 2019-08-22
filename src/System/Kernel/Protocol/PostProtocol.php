<?php

//declare(strict_types=1);

namespace System\Kernel\Protocol;

use System\Util\Logging\LoggerReferenceTrait;

/**
 * Class PostJsonProtocol
 * @package System\Kernel\Protocol
 */
class PostProtocol implements ProtocolInterface
{
    use LoggerReferenceTrait;

    /**
     * PostProtocol constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return ProtocolPacket
     */
    public function getIncomingPacket() : ProtocolPacket
    {
        $signature = isset($_SERVER['HTTP_SIGNATURE']) ? $_SERVER['HTTP_SIGNATURE'] : '';
        $signature = getenv('ENVIRONMENT') === 'dev' && isset($_GET['signature']) ? $_GET['signature'] : $signature;
        $headers = [];

        $requestParams = isset($_SERVER['REQUEST_URI']) ? explode('?', $_SERVER['REQUEST_URI']): [];

        $headers["CONTENT_TYPE"] = $_SERVER["CONTENT_TYPE"] ?? '';
        $headers['REQUEST_URI'] = $requestParams[0] ?? '';
        $headers['REQUEST_URI_PARAMS'] = $requestParams[1] ?? '';
        $headers['IS_INTEGRATION_TESTING'] = (bool)($_SERVER['HTTP_IS_INTEGRATION_TESTING'] ?? false);

        $packet = new ProtocolPacket(
            file_get_contents("php://input"),
            $signature,
            $headers
        );
        
        return $packet;
    }

    /**
     * @return ProtocolHeaders
     */
    public function getIncomingHeaders() : ProtocolHeaders
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? $_SERVER["CONTENT_TYPE"] : '';
        return new ProtocolHeaders($contentType);
    }

    /**
     * @param ProtocolPacket $packet
     * @return void
     */
    public function sendResponse(ProtocolPacket $packet)
    {
        header('Signature: '. $packet->getSignature());
        
        if (!empty($packet->getHeaders())) {
            foreach ($packet->getHeaders() as $header) {
                header($header);
            }
        }
        
        echo $packet->getData();
    }
}
